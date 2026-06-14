#!/usr/bin/env python3
"""Scrape product detail pages from Alibaba using window.detailData + JSON-LD."""
import subprocess
import json
import time
import os

BROWSER = "/Users/wenchengdr/.claude/skills/browser-control/browser.py"
DATA_DIR = "/Users/wenchengdr/zhidi-tech-website/data"
OUTPUT_FILE = os.path.join(DATA_DIR, "all_products_data.json")

def browser_eval(js_code, timeout=25):
    cmd = ["python3", BROWSER, "eval", js_code]
    result = subprocess.run(cmd, capture_output=True, text=True, timeout=timeout)
    if result.returncode != 0:
        return None
    try:
        data = json.loads(result.stdout)
        if isinstance(data, dict) and 'result' in data:
            inner = data['result']
            if isinstance(inner, dict) and 'value' in inner:
                val = inner['value']
                if isinstance(val, str):
                    try:
                        return json.loads(val)
                    except:
                        return val
                return val
            return inner
        return data
    except:
        return result.stdout.strip()

def scrape_product_page():
    """Scrape current product page using window.detailData and JSON-LD."""
    js = """
    (() => {
      const data = {};

      // Method 1: JSON-LD
      const jsonldScripts = document.querySelectorAll('script[type="application/ld+json"]');
      const jsonld = [];
      jsonldScripts.forEach(el => {
        try {
          const d = JSON.parse(el.textContent);
          jsonld.push(d);
        } catch(e) {}
      });

      // Find Product schema
      const productLD = jsonld.find(d => d['@type'] === 'Product' || (Array.isArray(d) && d[0] && d[0]['@type'] === 'Product'));
      if (productLD) {
        const p = Array.isArray(productLD) ? productLD[0] : productLD;
        data.jsonld_title = p.name || '';
        data.jsonld_price = p.offers ? p.offers.price : '';
        data.jsonld_currency = p.offers ? p.offers.priceCurrency : '';
        data.jsonld_images = p.image || [];
        data.jsonld_sku = p.sku || '';
        data.jsonld_brand = p.brand ? p.brand.name : '';
        data.jsonld_description = (p.description || '').substring(0, 500);
      }

      // Breadcrumb
      const bcLD = jsonld.find(d => d['@type'] === 'BreadcrumbList' || (Array.isArray(d) && d.some(i => i['@type'] === 'BreadcrumbList')));
      if (bcLD) {
        const bc = Array.isArray(bcLD) ? bcLD.find(i => i['@type'] === 'BreadcrumbList') : bcLD;
        data.breadcrumbs = (bc.itemListElement || []).map(i => i.name);
      }

      // Method 2: window.detailData
      try {
        const dd = window.detailData;
        if (dd && dd.globalData && dd.globalData.product) {
          const prod = dd.globalData.product;

          // Basic info
          data.subject = prod.subject || '';
          data.productId = prod.productId || '';
          data.formatFixedPrice = prod.customPrice ? prod.customPrice.formatFixedPrice : '';
          data.priceRangeText = prod.price ? prod.price.productRangePrices ? prod.price.productRangePrices.priceRangeText : '' : '';
          data.moq = prod.moq || '';
          data.priceUnit = prod.customPrice ? prod.customPrice.unit : '';

          // Full specs from productBasicProperties
          data.specifications = (prod.productBasicProperties || []).map(attr => ({
            name: attr.attrName || '',
            value: attr.attrValue || ''
          }));

          // Key industry properties
          data.keyProperties = (prod.productKeyIndustryProperties || []).map(attr => ({
            name: attr.attrName || '',
            value: attr.attrValue || ''
          }));

          // Other properties
          data.otherProperties = (prod.productOtherProperties || []).map(attr => ({
            name: attr.attrName || '',
            value: attr.attrValue || ''
          }));

          // Images from mediaItems
          data.mediaImages = (prod.mediaItems || []).map(item => ({
            big: item.imageUrl ? item.imageUrl.big : '',
            normal: item.imageUrl ? item.imageUrl.normal : '',
            small: item.imageUrl ? item.imageUrl.small : ''
          }));

          // Video
          if (prod.video && prod.video.cover) {
            data.videoCover = prod.video.cover;
            data.videoId = prod.video.videoId;
          }

          // SKU info
          if (prod.sku && prod.sku.skuAttrs) {
            data.skuAttrs = prod.sku.skuAttrs.map(attr => ({
              name: attr.name,
              values: (attr.values || []).map(v => v.name)
            }));
          }

          // Light customization
          if (prod.productLightCustomizationList) {
            data.customizationOptions = prod.productLightCustomizationList.map(c => ({
              type: c.customTypeEn || c.customType,
              options: (c.customContentList || []).map(o => o.titleEn || o.title)
            }));
          }

          // Category
          data.categoryId = prod.productCategoryId || '';
          data.firstLevelCateId = prod.firstLevelCateId || '';

          // Delivery
          if (dd.globalData.trade) {
            const trade = dd.globalData.trade;
            if (trade.leadTimeInfo) {
              data.leadTime = trade.leadTimeInfo;
            }
            if (trade.shipFromInfo) {
              data.shipFrom = trade.shipFromInfo;
            }
          }
        }
      } catch(e) {
        data.detailDataError = e.message;
      }

      return JSON.stringify(data);
    })()
    """
    return browser_eval(js)

# Load products
merged_file = os.path.join(DATA_DIR, "all_products_merged.json")
with open(merged_file) as f:
    products = json.load(f)

# Load existing data
existing = {}
if os.path.exists(OUTPUT_FILE):
    with open(OUTPUT_FILE) as f:
        existing_list = json.load(f)
        for item in existing_list:
            existing[item.get('url', '')] = item

print(f"Total: {len(products)}, Already scraped: {len(existing)}")

results = []
for i, p in enumerate(products):
    url = p['url']
    pid = url.split('_')[-1].replace('.html', '')

    print(f"\n[{i+1}/{len(products)}] {pid}")

    if url in existing and (existing[url].get('subject') or existing[url].get('jsonld_title')):
        print(f"  SKIP (already scraped)")
        results.append(existing[url])
        continue

    # Navigate to page via location.href (preserves referrer)
    nav_js = f"window.location.href = '{url}';'Navigating'"
    browser_eval(nav_js, timeout=40)
    time.sleep(6)

    # Check we're on the right page
    title = browser_eval("document.title")
    print(f"  Title: {str(title)[:100]}")

    data = scrape_product_page()
    if data and isinstance(data, dict):
        data['url'] = url
        data['list_title'] = p.get('title', '')
        print(f"  Product: {data.get('subject','')[:80]}")
        print(f"  Price: {data.get('formatFixedPrice','')} / {data.get('priceRangeText','')}")
        print(f"  Images: {len(data.get('mediaImages',[]))}")
        print(f"  Specs: {len(data.get('specifications',[]))}")
        results.append(data)
    else:
        print(f"  FAILED")
        results.append({'url': url, 'list_title': p.get('title', ''), 'error': str(data)})

    # Save incrementally every 5 products
    if (i + 1) % 5 == 0:
        with open(OUTPUT_FILE, 'w') as f:
            json.dump(results, f, indent=2, ensure_ascii=False)
        print(f"  [Saved {len(results)} products]")

    time.sleep(1)

# Final save
with open(OUTPUT_FILE, 'w') as f:
    json.dump(results, f, indent=2, ensure_ascii=False)

# Summary
success_count = sum(1 for r in results if r.get('subject') or r.get('jsonld_title'))
print(f"\n\nDONE! {success_count}/{len(results)} successful. Saved to {OUTPUT_FILE}")
