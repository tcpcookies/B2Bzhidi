<?php
$pageTitle = 'Dashboard';
require_once __DIR__ . '/includes/header.php';

$db = getDB();

// Stats
$productCount = $db->query("SELECT COUNT(*) FROM products WHERE status = 'published'")->fetchColumn();
$totalProducts = $db->query("SELECT COUNT(*) FROM products")->fetchColumn();
$draftProducts = $db->query("SELECT COUNT(*) FROM products WHERE status = 'draft'")->fetchColumn();
$publishedBlogs = $db->query("SELECT COUNT(*) FROM blogs WHERE status = 'published'")->fetchColumn();
$draftBlogs = $db->query("SELECT COUNT(*) FROM blogs WHERE status = 'draft'")->fetchColumn();
?>

<div class="mb-6">
  <h2 class="text-lg font-bold text-gray-900">Dashboard</h2>
  <p class="text-sm text-gray-500">Manage your ZHIDI Tech website content</p>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
  <div class="bg-white rounded-xl border border-gray-200 p-5">
    <div class="text-2xl font-bold text-gray-900"><?= $productCount ?></div>
    <div class="text-xs text-gray-500 mt-1">Published Products</div>
  </div>
  <div class="bg-white rounded-xl border border-gray-200 p-5">
    <div class="text-2xl font-bold text-orange-500"><?= $draftProducts ?></div>
    <div class="text-xs text-gray-500 mt-1">Draft Products</div>
  </div>
  <div class="bg-white rounded-xl border border-gray-200 p-5">
    <div class="text-2xl font-bold text-gray-900"><?= $publishedBlogs ?></div>
    <div class="text-xs text-gray-500 mt-1">Published Articles</div>
  </div>
  <div class="bg-white rounded-xl border border-gray-200 p-5">
    <div class="text-2xl font-bold text-blue-500"><?= $draftBlogs ?></div>
    <div class="text-xs text-gray-500 mt-1">Draft Articles</div>
  </div>
</div>

<!-- Recent Products -->
<div class="bg-white rounded-xl border border-gray-200 mb-6">
  <div class="px-5 py-3 border-b border-gray-100 flex items-center justify-between">
    <h3 class="text-sm font-semibold text-gray-700">Recent Products</h3>
    <a href="products.php" class="text-xs text-orange-500 hover:underline">View all</a>
  </div>
  <div class="divide-y divide-gray-100">
    <?php
    $recent = $db->query("SELECT * FROM products ORDER BY updated_at DESC LIMIT 5");
    foreach ($recent as $p):
    ?>
    <div class="px-5 py-3 flex items-center justify-between">
      <div class="flex items-center gap-3">
        <div class="w-9 h-9 bg-gray-100 rounded-md flex items-center justify-center overflow-hidden">
          <?php if ($p['image_main']): ?>
            <img src="../assets/images/products/<?= htmlspecialchars($p['image_main']) ?>" class="w-full h-full object-cover" alt="">
          <?php else: ?>
            <span class="text-xs text-gray-400">N/A</span>
          <?php endif; ?>
        </div>
        <div>
          <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($p['name']) ?></div>
          <div class="text-xs text-gray-400"><?= $p['price'] ?></div>
        </div>
      </div>
      <span class="text-xs px-2 py-0.5 rounded-full <?= $p['status'] === 'published' ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-500' ?>">
        <?= $p['status'] ?>
      </span>
    </div>
    <?php endforeach; ?>
  </div>
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-2 gap-4">
  <a href="products.php?action=add" class="bg-white rounded-xl border border-gray-200 p-5 hover:border-orange-300 hover:shadow-sm transition group">
    <div class="text-lg mb-1">📦</div>
    <div class="text-sm font-semibold text-gray-900 group-hover:text-orange-500 transition">Add New Product</div>
    <div class="text-xs text-gray-400 mt-1">Create a product listing with images and specs</div>
  </a>
  <a href="blogs.php?action=add" class="bg-white rounded-xl border border-gray-200 p-5 hover:border-orange-300 hover:shadow-sm transition group">
    <div class="text-lg mb-1">📝</div>
    <div class="text-sm font-semibold text-gray-900 group-hover:text-orange-500 transition">Write New Article</div>
    <div class="text-xs text-gray-400 mt-1">Publish a blog post or industry news</div>
  </a>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
