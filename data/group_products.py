#!/usr/bin/env python3
"""Generate product pages with real data from Alibaba scraping."""
import json
import os

DATA_DIR = "/Users/wenchengdr/zhidi-tech-website/data"
PROD_DIR = "/Users/wenchengdr/zhidi-tech-website/products"
IMG_DIR = "assets/images/products"

os.makedirs(PROD_DIR, exist_ok=True)

with open(os.path.join(DATA_DIR, "all_products_data.json")) as f:
    products = json.load(f)

# Sort products by category and price
def get_cat_key(p):
    name = (p.get('subject', '') or '').lower()
    if 'mealworm' in name or 'worm' in name or 'beetle' in name:
        return 'mealworm'
    if 'ball mill' in name:
        return 'ball_mill'
    if 'ink' in name and ('mixer' in name or 'mixing' in name) and 'planetary' not in name:
        return 'ink_mixer'
    if ('rolling machine' in name or 'paint roll' in name) and 'planetary' not in name:
        return 'rolling'
    if 'planetary centrifugal' in name or 'vacuum planetary centrifugal' in name:
        return 'centrifugal_mixer'
    if 'double planetary' in name or 'planetary mixer' in name or 'dual planetary' in name:
        return 'double_planetary'
    return 'other'

# Group products
groups = {}
for p in products:
    key = get_cat_key(p)
    groups.setdefault(key, []).append(p)

# Output summary
for k, v in sorted(groups.items()):
    print(f"{k}: {len(v)}")

# Save grouped data for reference
with open(os.path.join(DATA_DIR, "products_grouped.json"), 'w') as f:
    # Convert to serializable format
    json.dump({k: [{'id': p.get('productId',''), 'name': p.get('subject',''), 'price': p.get('formatFixedPrice','')} for p in v] for k, v in groups.items()}, f, indent=2, ensure_ascii=False)

print(f"\nGroups saved to products_grouped.json")
print(f"Total products in groups: {sum(len(v) for v in groups.values())}")
