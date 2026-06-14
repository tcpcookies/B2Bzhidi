#!/usr/bin/env python3
"""Generate updated products/index.html with real data."""
import json
import os

DATA_DIR = "/Users/wenchengdr/zhidi-tech-website/data"
PROD_DIR = "/Users/wenchengdr/zhidi-tech-website/products"
ROOT_DIR = "/Users/wenchengdr/zhidi-tech-website"

with open(os.path.join(DATA_DIR, "all_products_data.json")) as f:
    all_products = json.load(f)

# Get top products per category
def find_product(keywords):
    for p in all_products:
        name = (p.get('subject', '') or '').lower()
        if all(kw in name for kw in keywords):
            return p
    return None

# Core product: flagship double planetary mixer
centrifugal_mixers = [p for p in all_products if 'planetary centrifugal' in (p.get('subject','') or '').lower() or 'vacuum planetary centrifugal' in (p.get('subject','') or '').lower()]
double_planetary = [p for p in all_products if 'double planetary' in (p.get('subject','') or '').lower() and 'centrifugal' not in (p.get('subject','') or '').lower()]
ball_mill = [p for p in all_products if 'ball mill' in (p.get('subject','') or '').lower()]
ink_mixers = [p for p in all_products if ('ink' in (p.get('subject','') or '').lower() and 'mixer' in (p.get('subject','') or '').lower()) or 'printing' in (p.get('subject','') or '').lower()]
rolling = [p for p in all_products if 'rolling machine' in (p.get('subject','') or '').lower()]
mealworms = [p for p in all_products if 'mealworm' in (p.get('subject','') or '').lower()]

print(f"Planetary Centrifugal: {len(centrifugal_mixers)}")
print(f"Double Planetary: {len(double_planetary)}")
print(f"Ball Mill: {len(ball_mill)}")
print(f"Ink Mixers: {len(ink_mixers)}")
print(f"Rolling Machines: {len(rolling)}")
print(f"Mealworm: {len(mealworms)}")

# Get the flagship product (most expensive centrifugal mixer with high price)
centrifugal_with_price = [p for p in centrifugal_mixers if p.get('formatFixedPrice','')]
centrifugal_with_price.sort(key=lambda p: int(p.get('formatFixedPrice','$0').replace('$','').replace(',','')) if p.get('formatFixedPrice','').replace('$','').replace(',','').isdigit() else 0, reverse=True)
flagship = centrifugal_with_price[0] if centrifugal_with_price else centrifugal_mixers[0]

# Print data for manual HTML generation
print(f"\nFlagship: {flagship.get('subject','')[:100]} | {flagship.get('formatFixedPrice','')}")

# Save product data for JS consumption (for the website)
site_data = {
    "flagship": {
        "name": flagship.get('subject',''),
        "price": flagship.get('formatFixedPrice',''),
        "images": flagship.get('mediaImages',[]),
        "specs": flagship.get('specifications',[]),
        "id": flagship.get('productId','')
    },
    "centrifugal_mixers": [{"name": p.get('subject',''), "price": p.get('formatFixedPrice',''), "id": p.get('productId','')} for p in centrifugal_mixers[:10]],
    "double_planetary": [{"name": p.get('subject',''), "price": p.get('formatFixedPrice',''), "id": p.get('productId','')} for p in double_planetary[:10]],
    "ball_mill": [{"name": p.get('subject',''), "price": p.get('formatFixedPrice',''), "id": p.get('productId','')} for p in ball_mill],
    "ink_mixers": [{"name": p.get('subject',''), "price": p.get('formatFixedPrice',''), "id": p.get('productId','')} for p in ink_mixers[:10]],
    "rolling_machines": [{"name": p.get('subject',''), "price": p.get('formatFixedPrice',''), "id": p.get('productId','')} for p in rolling],
    "mealworm": [{"name": p.get('subject',''), "price": p.get('formatFixedPrice',''), "id": p.get('productId','')} for p in mealworms],
}

with open(os.path.join(DATA_DIR, "site_product_data.json"), 'w') as f:
    json.dump(site_data, f, indent=2, ensure_ascii=False)

print("\nSaved site_product_data.json")
