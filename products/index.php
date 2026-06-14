<?php
/**
 * Products Listing — Dynamic version (reads from SQLite DB)
 * Falls back gracefully if DB is unavailable.
 */
require_once __DIR__ . '/../admin/includes/config.php';

$products = [];
try {
    $db = getDB();
    $products = $db->query("SELECT * FROM products WHERE status = 'published' ORDER BY sort_order ASC, id DESC")->fetchAll();
} catch (Exception $e) {
    // DB not available — redirect to static HTML
    header('Location: index.html');
    exit;
}

// Map to card data
$cards = [];
foreach ($products as $p) {
    $images = array_filter([$p['image_main'], $p['image_thumb1'], $p['image_thumb2'], $p['image_thumb3'], $p['image_thumb4']]);
    $cards[] = [
        'name'   => $p['name'],
        'slug'   => $p['slug'],
        'desc'   => $p['short_desc'] ?: $p['description'],
        'price'  => $p['price'],
        'models' => $p['models_count'],
        'img'    => $images[0] ?? '',
        'url'    => $p['slug'] . '.html',
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Products — Industrial Mixing, Grinding & Screening Equipment | ZHIDI Tech</title>
  <meta name="description" content="Browse ZHIDI Tech's full catalog: planetary vacuum mixers, double planetary mixers, ball mills, ink mixers, and screening machines. <?= count($cards) ?>+ products, factory direct.">
  <link rel="canonical" href="https://zhiditech.com/products/">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="../assets/css/style.css">
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
</head>
<body>

  <nav class="navbar">
    <div class="container">
      <a href="../index.html" class="navbar-logo">
        <img src="../assets/images/company/logo.png" alt="ZHIDI Tech">
        <span>ZHIDI Tech</span>
      </a>
      <div class="navbar-links">
        <a href="../index.html">Home</a>
        <a href="../about.html">About Us</a>
        <a href="index.php" class="active">Products</a>
        <a href="../industries/index.html">Industries</a>
        <a href="../support/index.html">Support</a>
        <a href="../blog/index.html">Blog</a>
        <a href="../contact.html" class="navbar-cta">Get Quote</a>
      </div>
      <button class="menu-toggle" aria-label="Toggle menu"><span></span><span></span><span></span></button>
    </div>
  </nav>

  <section class="page-header">
    <div class="container">
      <div class="breadcrumb">
        <a href="../index.html">Home</a>
        <i data-lucide="chevron-right"></i>
        <span>Products</span>
      </div>
      <h1>Our Products</h1>
      <p><?= count($cards) ?>+ industrial equipment models — vacuum mixers, planetary mixers, ball mills, rolling machines & screening systems</p>
    </div>
  </section>

  <section class="section">
    <div class="container">
      <div class="product-category-grid">
        <?php foreach ($cards as $i => $c): ?>
        <a href="<?= htmlspecialchars($c['url']) ?>" class="product-category-card anim-fade-up" data-stagger="<?= ($i % 6) + 1 ?>">
          <div class="product-category-card-img">
            <img src="../assets/images/products/<?= htmlspecialchars($c['img']) ?>" alt="<?= htmlspecialchars($c['name']) ?>" loading="lazy">
          </div>
          <div class="product-category-card-body">
            <h3><?= htmlspecialchars($c['name']) ?></h3>
            <p><?= htmlspecialchars($c['desc']) ?></p>
            <div class="card-meta">
              <span><strong><?= $c['models'] ?></strong> models</span>
              <span><?= htmlspecialchars($c['price']) === 'Inquire' ? 'Inquire for price' : 'From <strong>' . htmlspecialchars($c['price']) . '</strong>' ?></span>
            </div>
            <span class="card-link">View Details <i data-lucide="arrow-right"></i></span>
          </div>
        </a>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <section class="cta-section">
    <div class="container anim-fade-up">
      <h2>Don't see what you need?</h2>
      <p>We offer custom OEM solutions. Tell us your specs and we'll engineer the right equipment.</p>
      <a href="../contact.html" class="btn btn-white btn-lg"><i data-lucide="send"></i> Request Custom Quote</a>
    </div>
  </section>

  <footer class="footer">
    <div class="container">
      <div class="footer-grid">
        <div class="footer-brand">
          <img src="../assets/images/company/logo.png" alt="ZHIDI Tech">
          <p>Shenzhen Zhidi Technology Co., Ltd. — Professional manufacturer of industrial mixing, grinding, and processing equipment.</p>
        </div>
        <div><h4>Products</h4><ul><li><a href="planetary-vacuum-mixer.html">Planetary Vacuum Mixer</a></li><li><a href="double-planetary-mixer.html">Double Planetary Mixer</a></li><li><a href="scraping-grinding-machine.html">Ball Mill</a></li><li><a href="mixer-machine.html">Ink Mixer</a></li><li><a href="screening-machine.html">Screening Machine</a></li></ul></div>
        <div><h4>Company</h4><ul><li><a href="../about.html">About Us</a></li><li><a href="../industries/index.html">Industries</a></li><li><a href="../support/index.html">Support</a></li><li><a href="../contact.html">Contact</a></li></ul></div>
        <div><h4>Contact</h4><ul><li><a href="mailto:sales@zhiditech.com">sales@zhiditech.com</a></li><li><a href="https://wa.me/8613800000000">WhatsApp</a></li><li><a href="https://szzhidi.en.alibaba.com">Alibaba Store</a></li></ul></div>
      </div>
      <div class="footer-bottom">
        <span>&copy; 2026 Shenzhen Zhidi Technology Co., Ltd.</span>
        <div class="footer-social"><a href="#"><i data-lucide="linkedin"></i></a><a href="#"><i data-lucide="youtube"></i></a></div>
      </div>
    </div>
  </footer>

  <a href="https://wa.me/8613800000000" class="whatsapp-float" aria-label="Chat on WhatsApp"><i data-lucide="message-circle"></i></a>

  <script src="../assets/js/main.js"></script>
  <script>lucide.createIcons();</script>
</body>
</html>
