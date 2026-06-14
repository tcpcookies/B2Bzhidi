<!-- Admin Sidebar -->
<aside class="w-56 bg-gray-900 text-gray-300 flex flex-col flex-shrink-0">
  <a href="dashboard.php" class="flex items-center gap-3 px-5 py-4 border-b border-gray-800">
    <div class="w-8 h-8 bg-orange-500 rounded-lg flex items-center justify-center text-white font-bold text-sm">Z</div>
    <span class="text-sm font-semibold text-white">ZHIDI Admin</span>
  </a>
  <nav class="flex-1 p-3 space-y-1">
    <?php
    $current = basename($_SERVER['PHP_SELF']);
    $nav = [
        ['Dashboard', 'dashboard.php', '📊'],
        ['Products', 'products.php', '📦'],
        ['Blog / News', 'blogs.php', '📝'],
    ];
    foreach ($nav as [$label, $file, $icon]):
        $active = $current === $file;
    ?>
    <a href="<?= $file ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition <?= $active ? 'bg-gray-800 text-white font-medium' : 'hover:bg-gray-800 hover:text-white' ?>">
      <span class="text-base"><?= $icon ?></span>
      <?= $label ?>
    </a>
    <?php endforeach; ?>
  </nav>
  <div class="p-3 border-t border-gray-800">
    <a href="../index.html" target="_blank" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-xs text-gray-500 hover:bg-gray-800 hover:text-white transition">
      <span>🌐</span> View Website
    </a>
  </div>
</aside>
