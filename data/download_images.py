#!/usr/bin/env python3
"""Download product images from Alibaba CDN."""
import json
import os
import subprocess
import time

DATA_DIR = "/Users/wenchengdr/zhidi-tech-website/data"
IMG_DIR = "/Users/wenchengdr/zhidi-tech-website/assets/images/products"

os.makedirs(IMG_DIR, exist_ok=True)

with open(os.path.join(DATA_DIR, "all_products_data.json")) as f:
    products = json.load(f)

# Collect unique image URLs (big size) for top products
# Focus on: first image of each product
downloads = []
for p in products:
    name = p.get('subject', '') or p.get('jsonld_title', '')
    pid = p.get('productId', '')
    images = p.get('mediaImages', [])

    if images:
        # Use first image as main
        big_url = images[0].get('big', '')
        if big_url and big_url not in [d['url'] for d in downloads]:
            downloads.append({
                'url': big_url,
                'product_id': pid,
                'name': name[:80],
                'index': 0
            })

print(f"Total images to download: {len(downloads)}")

# Download using curl with proxy
proxy = "http://127.0.0.1:7897"
success = 0
failed = 0

for i, d in enumerate(downloads):
    url = d['url']
    pid = d['product_id']
    ext = url.split('.')[-1].split('?')[0]
    if ext not in ('jpg', 'jpeg', 'png', 'webp'):
        ext = 'jpg'

    filename = f"{pid}_{d['index']:02d}.{ext}"
    filepath = os.path.join(IMG_DIR, filename)

    if os.path.exists(filepath):
        success += 1
        continue

    cmd = [
        "curl", "-s", "-L", "-o", filepath,
        "--proxy", proxy,
        "--max-time", "30",
        url
    ]

    result = subprocess.run(cmd, capture_output=True, text=True, timeout=35)

    if result.returncode == 0 and os.path.exists(filepath) and os.path.getsize(filepath) > 1000:
        success += 1
        if (i + 1) % 10 == 0:
            print(f"  [{i+1}/{len(downloads)}] Downloaded {success}, failed {failed}")
    else:
        failed += 1
        # Clean up failed download
        if os.path.exists(filepath):
            os.remove(filepath)

    time.sleep(0.3)  # Rate limit

print(f"\nDone! Success: {success}, Failed: {failed}")

# Compress images
print("\nCompressing images...")
subprocess.run([
    "sips", "-s", "formatOptions", "75"
] + [os.path.join(IMG_DIR, f) for f in os.listdir(IMG_DIR) if f.endswith(('.jpg', '.jpeg', '.png'))],
    capture_output=True)

# Report total size
total_size = sum(os.path.getsize(os.path.join(IMG_DIR, f)) for f in os.listdir(IMG_DIR) if os.path.isfile(os.path.join(IMG_DIR, f)))
print(f"Total images: {len(os.listdir(IMG_DIR))}, Size: {total_size / 1024 / 1024:.1f} MB")
