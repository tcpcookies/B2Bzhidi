<?php
/**
 * Blog Listing — Dynamic version (reads from SQLite DB)
 */
require_once __DIR__ . '/../admin/includes/config.php';

$posts = [];
try {
    $db = getDB();
    $posts = $db->query("SELECT * FROM blogs WHERE status = 'published' ORDER BY published_at DESC LIMIT 12")->fetchAll();
} catch (Exception $e) {
    header('Location: index.html');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Blog — Industry Insights & Application Guides | ZHIDI Tech</title>
  <meta name="description" content="ZHIDI Tech blog: mixing technology insights, application guides, equipment comparisons, and industry trends.">
  <link rel="canonical" href="https://zhiditech.com/blog/">
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
        <a href="../products/index.php">Products</a>
        <a href="../industries/index.html">Industries</a>
        <a href="../support/index.html">Support</a>
        <a href="index.php" class="active">Blog</a>
        <a href="../contact.html" class="navbar-cta">Get Quote</a>
      </div>
      <button class="menu-toggle" aria-label="Toggle menu"><span></span><span></span><span></span></button>
    </div>
  </nav>

  <section class="page-header">
    <div class="container">
      <div class="breadcrumb"><a href="../index.html">Home</a><i data-lucide="chevron-right"></i><span>Blog</span></div>
      <h1>Blog & Insights</h1>
      <p>Mixing technology guides, application tips, and industry updates</p>
    </div>
  </section>

  <section class="section">
    <div class="container">
      <div class="blog-grid">
        <?php foreach ($posts as $i => $p): ?>
        <article class="blog-card anim-fade-up" data-stagger="<?= ($i % 6) + 1 ?>">
          <div class="blog-card-img" style="background:var(--color-bg-alt);display:flex;align-items:center;justify-content:center">
            <i data-lucide="file-text" style="width:48px;height:48px;color:var(--color-accent)"></i>
          </div>
          <div class="blog-card-body">
            <div class="blog-date"><?= date('M j, Y', strtotime($p['published_at'])) ?></div>
            <h3><?= htmlspecialchars($p['title']) ?></h3>
            <p><?= htmlspecialchars(mb_substr(strip_tags($p['excerpt'] ?: $p['content']), 0, 120)) ?>...</p>
          </div>
        </article>
        <?php endforeach; ?>
        <?php if (empty($posts)): ?>
          <p class="text-center text-gray-400 col-span-full py-12">No articles published yet. Check back soon!</p>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <section class="cta-section">
    <div class="container anim-fade-up">
      <h2>Want to discuss your mixing challenge?</h2>
      <p>Our engineers are ready to help. Tell us your process and we'll recommend the right equipment.</p>
      <a href="../contact.html" class="btn btn-white btn-lg"><i data-lucide="send"></i> Talk to an Engineer</a>
    </div>
  </section>

  <footer class="footer">
    <div class="container">
      <div class="footer-grid">
        <div class="footer-brand">
          <img src="../assets/images/company/logo.png" alt="ZHIDI Tech">
          <p>Shenzhen Zhidi Technology Co., Ltd. — Professional manufacturer of industrial mixing, grinding, and processing equipment.</p>
        </div>
        <div><h4>Products</h4><ul><li><a href="../products/planetary-vacuum-mixer.html">Planetary Vacuum Mixer</a></li><li><a href="../products/double-planetary-mixer.html">Double Planetary Mixer</a></li><li><a href="../products/scraping-grinding-machine.html">Ball Mill</a></li><li><a href="../products/mixer-machine.html">Ink Mixer</a></li><li><a href="../products/screening-machine.html">Screening Machine</a></li></ul></div>
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
