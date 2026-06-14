#!/usr/bin/env python3
"""Auto-paginate Alibaba product list and collect all product links."""
import subprocess
import json
import time

BROWSER = "/Users/wenchengdr/.claude/skills/browser-control/browser.py"

def browser_eval(js_code, timeout=20):
    """Run eval in browser, returns raw decoded value."""
    cmd = ["python3", BROWSER, "eval", js_code]
    result = subprocess.run(cmd, capture_output=True, text=True, timeout=timeout)
    if result.returncode != 0:
        print(f"  EVAL ERROR: {result.stderr.strip()}")
        return None
    try:
        data = json.loads(result.stdout)
        # browser.py returns {"result": {"type": "string", "value": "..."}}
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
    except json.JSONDecodeError:
        return result.stdout.strip()

def collect_page_links():
    """Collect product links from current page."""
    js = """
    (() => {
      const links = [];
      const seen = new Set();
      document.querySelectorAll('a[href*="product-detail"]').forEach(a => {
        const href = a.href;
        const title = a.textContent.trim();
        if (href && title.length > 3 && !seen.has(href)) {
          seen.add(href);
          links.push(href + '|||' + title.substring(0, 200));
        }
      });
      return JSON.stringify(links);
    })()
    """
    return browser_eval(js) or []

def click_next_page():
    """Click next page button."""
    js = """
    (() => {
      const allBtns = document.querySelectorAll('.next-pagination button, .next-pagination-item:not(.active)');
      for (const btn of allBtns) {
        if (btn.textContent.trim() === 'Next' && !btn.disabled && !btn.classList.contains('disabled')) {
          btn.click();
          return 'clicked';
        }
      }
      // Also try .next-btn
      const next = document.querySelector('.next-pagination .next-btn.next:not(.disabled)');
      if (next) { next.click(); return 'clicked-next-btn'; }
      return 'no-next';
    })()
    """
    result = browser_eval(js)
    return result

# Main
all_links = []
seen_urls = set()

for page in range(1, 11):
    print(f"Page {page}...")
    time.sleep(2)

    links = collect_page_links()
    new_count = 0
    if isinstance(links, list):
        for link in links:
            if isinstance(link, str) and '|||' in link:
                parts = link.split('|||', 1)
                url, title = parts[0].strip(), parts[1].strip()
                if url not in seen_urls:
                    seen_urls.add(url)
                    all_links.append({"url": url, "title": title})
                    new_count += 1

    print(f"  Collected {new_count} new links (total: {len(all_links)})")

    if page < 10:
        result = click_next_page()
        if result == 'no-next':
            print("  No more pages, stopping")
            break
        time.sleep(4)

# Save results
output_file = "/Users/wenchengdr/zhidi-tech-website/data/all_products_links.json"
with open(output_file, 'w') as f:
    json.dump(all_links, f, indent=2, ensure_ascii=False)

print(f"\nDone! Saved {len(all_links)} product links to {output_file}")
