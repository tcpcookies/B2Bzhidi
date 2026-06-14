<?php
$pageTitle = 'Products';
require_once __DIR__ . '/includes/header.php';

$db = getDB();
$action = $_GET['action'] ?? 'list';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// ── Handle Form Submission ──────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validateCsrf()) die('CSRF validation failed.');

    $data = [
        'name'          => trim($_POST['name'] ?? ''),
        'slug'          => slugify(trim($_POST['slug'] ?? $_POST['name'])),
        'category'      => trim($_POST['category'] ?? ''),
        'category_slug' => slugify(trim($_POST['category'] ?? '')),
        'short_desc'    => trim($_POST['short_desc'] ?? ''),
        'description'   => trim($_POST['description'] ?? ''),
        'price'         => trim($_POST['price'] ?? ''),
        'models_count'  => (int)($_POST['models_count'] ?? 1),
        'image_main'    => trim($_POST['image_main'] ?? ''),
        'image_thumb1'  => trim($_POST['image_thumb1'] ?? ''),
        'image_thumb2'  => trim($_POST['image_thumb2'] ?? ''),
        'image_thumb3'  => trim($_POST['image_thumb3'] ?? ''),
        'image_thumb4'  => trim($_POST['image_thumb4'] ?? ''),
        'featured'      => isset($_POST['featured']) ? 1 : 0,
        'status'        => $_POST['status'] ?? 'draft',
        'sort_order'    => (int)($_POST['sort_order'] ?? 0),
    ];

    if (isset($_POST['delete']) && $id) {
        $db->prepare("DELETE FROM products WHERE id = ?")->execute([$id]);
        flash('success', 'Product deleted.');
        header('Location: products.php');
        exit;
    }

    if ($id) {
        $data['id'] = $id;
        $stmt = $db->prepare("UPDATE products SET name=?, slug=?, category=?, category_slug=?, short_desc=?, description=?, price=?, models_count=?, image_main=?, image_thumb1=?, image_thumb2=?, image_thumb3=?, image_thumb4=?, featured=?, status=?, sort_order=?, updated_at=CURRENT_TIMESTAMP WHERE id=?");
        $stmt->execute(array_values($data));
        flash('success', 'Product updated.');
    } else {
        $stmt = $db->prepare("INSERT INTO products (name, slug, category, category_slug, short_desc, description, price, models_count, image_main, image_thumb1, image_thumb2, image_thumb3, image_thumb4, featured, status, sort_order) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        unset($data['id']);
        $stmt->execute(array_values($data));
        flash('success', 'Product created.');
    }
    header('Location: products.php');
    exit;
}

// ── List View ────────────────────────────────────────────
if ($action === 'list'):
    $products = $db->query("SELECT * FROM products ORDER BY sort_order ASC, id DESC")->fetchAll();
?>

<div class="flex items-center justify-between mb-5">
  <div>
    <h2 class="text-lg font-bold text-gray-900">Products</h2>
    <p class="text-xs text-gray-400"><?= count($products) ?> products total</p>
  </div>
  <a href="?action=add" class="inline-flex items-center gap-2 bg-gray-900 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-800 transition">
    + Add Product
  </a>
</div>

<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
  <table class="w-full">
    <thead>
      <tr class="text-left text-xs text-gray-400 font-medium border-b border-gray-100">
        <th class="px-4 py-3">Product</th>
        <th class="px-4 py-3 hidden md:table-cell">Category</th>
        <th class="px-4 py-3 hidden md:table-cell">Price</th>
        <th class="px-4 py-3">Status</th>
        <th class="px-4 py-3 text-right">Actions</th>
      </tr>
    </thead>
    <tbody class="divide-y divide-gray-50">
    <?php foreach ($products as $p): ?>
      <tr class="hover:bg-gray-50 transition">
        <td class="px-4 py-3">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-gray-100 rounded-md flex items-center justify-center overflow-hidden flex-shrink-0">
              <?php if ($p['image_main']): ?>
                <img src="../assets/images/products/<?= htmlspecialchars($p['image_main']) ?>" class="w-full h-full object-cover" alt="">
              <?php else: ?>
                <span class="text-xs text-gray-300">img</span>
              <?php endif; ?>
            </div>
            <div class="min-w-0">
              <div class="text-sm font-medium text-gray-900 truncate max-w-xs"><?= htmlspecialchars($p['name']) ?></div>
              <div class="text-xs text-gray-400"><?= $p['models_count'] ?> models</div>
            </div>
          </div>
        </td>
        <td class="px-4 py-3 hidden md:table-cell text-sm text-gray-600"><?= htmlspecialchars($p['category']) ?></td>
        <td class="px-4 py-3 hidden md:table-cell text-sm text-gray-900 font-medium"><?= htmlspecialchars($p['price']) ?></td>
        <td class="px-4 py-3">
          <span class="text-xs px-2 py-0.5 rounded-full <?= $p['status'] === 'published' ? 'bg-green-50 text-green-700' : ($p['status'] === 'archived' ? 'bg-red-50 text-red-600' : 'bg-gray-100 text-gray-500') ?>">
            <?= $p['status'] ?>
          </span>
          <?php if ($p['featured']): ?><span class="text-xs text-orange-500 ml-1">★</span><?php endif; ?>
        </td>
        <td class="px-4 py-3 text-right">
          <a href="?action=edit&id=<?= $p['id'] ?>" class="text-xs text-blue-600 hover:underline mr-3">Edit</a>
          <span class="text-xs text-gray-300"><?= $p['sort_order'] ?></span>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>

<!-- Image reference list -->
<div class="mt-6 bg-amber-50 border border-amber-200 rounded-xl p-4">
  <h4 class="text-sm font-semibold text-amber-800 mb-2">📷 How to add images</h4>
  <p class="text-xs text-amber-700">
    Upload images to <code class="bg-amber-100 px-1 rounded">assets/images/products/</code> via your server file manager, then enter the filename (e.g. <code class="bg-amber-100 px-1 rounded">my-product.jpg</code>) in the image fields below.
    Main image is required, thumbnails are optional.
  </p>
</div>

<?php
// ── Add / Edit View ─────────────────────────────────────
else:
    $product = null;
    if ($id) {
        $stmt = $db->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        $product = $stmt->fetch();
    }
    $isEdit = $product !== null;
?>

<div class="flex items-center justify-between mb-5">
  <div>
    <h2 class="text-lg font-bold text-gray-900"><?= $isEdit ? 'Edit Product' : 'Add Product' ?></h2>
    <p class="text-xs text-gray-400"><?= $isEdit ? 'ID: ' . $product['id'] . ' | ' . htmlspecialchars($product['name']) : 'Create a new product listing' ?></p>
  </div>
  <a href="products.php" class="text-sm text-gray-500 hover:text-gray-700 transition">&larr; Back to list</a>
</div>

<form method="post" class="space-y-6 max-w-3xl">
  <input type="hidden" name="csrf_token" value="<?= csrfToken() ?>">

  <div class="bg-white rounded-xl border border-gray-200 p-6 space-y-5">
    <h3 class="text-sm font-semibold text-gray-700">Basic Information</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Product Name *</label>
        <input type="text" name="name" value="<?= htmlspecialchars($product['name'] ?? '') ?>" required
               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none">
      </div>
      <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Slug (auto-generated)</label>
        <input type="text" name="slug" value="<?= htmlspecialchars($product['slug'] ?? '') ?>"
               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm bg-gray-50 outline-none">
      </div>
      <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Category</label>
        <input type="text" name="category" value="<?= htmlspecialchars($product['category'] ?? '') ?>"
               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none" placeholder="e.g. Mixing Equipment">
      </div>
      <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Price</label>
        <input type="text" name="price" value="<?= htmlspecialchars($product['price'] ?? '') ?>"
               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none" placeholder="e.g. $5,660 — $60,000">
      </div>
    </div>
    <div>
      <label class="block text-xs font-medium text-gray-600 mb-1">Short Description (shown on cards)</label>
      <textarea name="short_desc" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none resize-none"><?= htmlspecialchars($product['short_desc'] ?? '') ?></textarea>
    </div>
    <div>
      <label class="block text-xs font-medium text-gray-600 mb-1">Full Description</label>
      <textarea name="description" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none"><?= htmlspecialchars($product['description'] ?? '') ?></textarea>
    </div>
    <div class="grid grid-cols-3 gap-4">
      <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Models Count</label>
        <input type="number" name="models_count" value="<?= $product['models_count'] ?? 1 ?>" min="1"
               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none">
      </div>
      <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Sort Order</label>
        <input type="number" name="sort_order" value="<?= $product['sort_order'] ?? 0 ?>" min="0"
               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none">
      </div>
      <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Status</label>
        <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none">
          <option value="published" <?= ($product['status'] ?? '') === 'published' ? 'selected' : '' ?>>Published</option>
          <option value="draft" <?= ($product['status'] ?? '') === 'draft' ? 'selected' : '' ?>>Draft</option>
          <option value="archived" <?= ($product['status'] ?? '') === 'archived' ? 'selected' : '' ?>>Archived (Hidden)</option>
        </select>
      </div>
    </div>
    <div class="flex items-center gap-2">
      <input type="checkbox" name="featured" id="featured" value="1" <?= ($product['featured'] ?? 0) ? 'checked' : '' ?> class="rounded border-gray-300 text-orange-500 focus:ring-orange-500">
      <label for="featured" class="text-xs font-medium text-gray-600">Featured Product ★</label>
    </div>
  </div>

  <!-- Images -->
  <div class="bg-white rounded-xl border border-gray-200 p-6 space-y-4">
    <h3 class="text-sm font-semibold text-gray-700">Product Images</h3>
    <p class="text-xs text-gray-400">Enter filenames of images uploaded to <code class="bg-gray-100 px-1 rounded">assets/images/products/</code></p>
    <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
      <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Main Image *</label>
        <input type="text" name="image_main" value="<?= htmlspecialchars($product['image_main'] ?? '') ?>"
               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-xs focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none" placeholder="product-main.jpg">
      </div>
      <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Thumbnail 1</label>
        <input type="text" name="image_thumb1" value="<?= htmlspecialchars($product['image_thumb1'] ?? '') ?>"
               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-xs focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none">
      </div>
      <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Thumbnail 2</label>
        <input type="text" name="image_thumb2" value="<?= htmlspecialchars($product['image_thumb2'] ?? '') ?>"
               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-xs focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none">
      </div>
      <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Thumbnail 3</label>
        <input type="text" name="image_thumb3" value="<?= htmlspecialchars($product['image_thumb3'] ?? '') ?>"
               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-xs focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none">
      </div>
      <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Thumbnail 4</label>
        <input type="text" name="image_thumb4" value="<?= htmlspecialchars($product['image_thumb4'] ?? '') ?>"
               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-xs focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none">
      </div>
    </div>
  </div>

  <!-- Actions -->
  <div class="flex items-center justify-between">
    <div>
      <?php if ($isEdit): ?>
        <button type="submit" name="delete" value="1" class="text-sm text-red-500 hover:text-red-700 transition"
                onclick="return confirm('Delete this product? This cannot be undone.')">Delete Product</button>
      <?php endif; ?>
    </div>
    <div class="flex items-center gap-3">
      <a href="products.php" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-900 transition">Cancel</a>
      <button type="submit" class="bg-gray-900 text-white px-6 py-2 rounded-lg text-sm font-medium hover:bg-gray-800 transition">
        <?= $isEdit ? 'Save Changes' : 'Create Product' ?>
      </button>
    </div>
  </div>
</form>

<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
