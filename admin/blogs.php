<?php
$pageTitle = 'Blog & News';
require_once __DIR__ . '/includes/header.php';

$db = getDB();
$action = $_GET['action'] ?? 'list';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// ── Handle Form Submission ──────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validateCsrf()) die('CSRF validation failed.');

    if (isset($_POST['delete']) && $id) {
        $db->prepare("DELETE FROM blogs WHERE id = ?")->execute([$id]);
        flash('success', 'Article deleted.');
        header('Location: blogs.php');
        exit;
    }

    $title = trim($_POST['title'] ?? '');
    $slug = slugify(trim($_POST['slug'] ?? $title));
    $excerpt = trim($_POST['excerpt'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $category = trim($_POST['category'] ?? 'Industry News');
    $status = $_POST['status'] ?? 'draft';
    $published_at = ($status === 'published' && empty($_POST['published_at']))
        ? date('Y-m-d H:i:s')
        : ($_POST['published_at'] ?? null);

    if ($id) {
        $stmt = $db->prepare("UPDATE blogs SET title=?, slug=?, excerpt=?, content=?, category=?, status=?, published_at=COALESCE(?, published_at), updated_at=CURRENT_TIMESTAMP WHERE id=?");
        $stmt->execute([$title, $slug, $excerpt, $content, $category, $status, $published_at, $id]);
        flash('success', 'Article updated.');
    } else {
        $stmt = $db->prepare("INSERT INTO blogs (title, slug, excerpt, content, category, status, published_at) VALUES (?,?,?,?,?,?,?)");
        $stmt->execute([$title, $slug, $excerpt, $content, $category, $status, $published_at]);
        flash('success', 'Article created.');
    }
    header('Location: blogs.php');
    exit;
}

// ── List View ────────────────────────────────────────────
if ($action === 'list'):
    $blogs = $db->query("SELECT * FROM blogs ORDER BY created_at DESC")->fetchAll();
?>

<div class="flex items-center justify-between mb-5">
  <div>
    <h2 class="text-lg font-bold text-gray-900">Blog & Industry News</h2>
    <p class="text-xs text-gray-400"><?= count($blogs) ?> articles total</p>
  </div>
  <a href="?action=add" class="inline-flex items-center gap-2 bg-gray-900 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-800 transition">
    + New Article
  </a>
</div>

<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
  <table class="w-full">
    <thead>
      <tr class="text-left text-xs text-gray-400 font-medium border-b border-gray-100">
        <th class="px-4 py-3">Title</th>
        <th class="px-4 py-3 hidden md:table-cell">Category</th>
        <th class="px-4 py-3 hidden md:table-cell">Date</th>
        <th class="px-4 py-3">Status</th>
        <th class="px-4 py-3 text-right">Actions</th>
      </tr>
    </thead>
    <tbody class="divide-y divide-gray-50">
    <?php foreach ($blogs as $b): ?>
      <tr class="hover:bg-gray-50 transition">
        <td class="px-4 py-3">
          <div class="text-sm font-medium text-gray-900 max-w-md truncate"><?= htmlspecialchars($b['title']) ?></div>
          <div class="text-xs text-gray-400 truncate max-w-md mt-0.5"><?= htmlspecialchars(mb_substr(strip_tags($b['excerpt']), 0, 80)) ?>...</div>
        </td>
        <td class="px-4 py-3 hidden md:table-cell text-sm text-gray-600"><?= htmlspecialchars($b['category']) ?></td>
        <td class="px-4 py-3 hidden md:table-cell text-xs text-gray-400">
          <?= $b['published_at'] ? date('M j, Y', strtotime($b['published_at'])) : '—' ?>
        </td>
        <td class="px-4 py-3">
          <span class="text-xs px-2 py-0.5 rounded-full <?= $b['status'] === 'published' ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-500' ?>">
            <?= $b['status'] ?>
          </span>
        </td>
        <td class="px-4 py-3 text-right">
          <a href="?action=edit&id=<?= $b['id'] ?>" class="text-xs text-blue-600 hover:underline">Edit</a>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php
// ── Add / Edit View ─────────────────────────────────────
else:
    $blog = null;
    if ($id) {
        $stmt = $db->prepare("SELECT * FROM blogs WHERE id = ?");
        $stmt->execute([$id]);
        $blog = $stmt->fetch();
    }
    $isEdit = $blog !== null;
?>

<div class="flex items-center justify-between mb-5">
  <div>
    <h2 class="text-lg font-bold text-gray-900"><?= $isEdit ? 'Edit Article' : 'New Article' ?></h2>
    <p class="text-xs text-gray-400"><?= $isEdit ? htmlspecialchars($blog['title']) : 'Write a new blog post or industry news' ?></p>
  </div>
  <a href="blogs.php" class="text-sm text-gray-500 hover:text-gray-700 transition">&larr; Back to list</a>
</div>

<form method="post" class="space-y-6 max-w-3xl">
  <input type="hidden" name="csrf_token" value="<?= csrfToken() ?>">

  <div class="bg-white rounded-xl border border-gray-200 p-6 space-y-4">
    <div>
      <label class="block text-xs font-medium text-gray-600 mb-1">Title *</label>
      <input type="text" name="title" value="<?= htmlspecialchars($blog['title'] ?? '') ?>" required
             class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none" placeholder="Article title...">
    </div>
    <div>
      <label class="block text-xs font-medium text-gray-600 mb-1">Slug (auto-generated)</label>
      <input type="text" name="slug" value="<?= htmlspecialchars($blog['slug'] ?? '') ?>"
             class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm bg-gray-50 outline-none">
    </div>
    <div class="grid grid-cols-2 gap-4">
      <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Category</label>
        <select name="category" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none">
          <?php foreach (['Industry News', 'Application Guide', 'Technology', 'Company News', 'Case Study'] as $cat): ?>
            <option value="<?= $cat ?>" <?= ($blog['category'] ?? '') === $cat ? 'selected' : '' ?>><?= $cat ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Status</label>
        <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none">
          <option value="draft" <?= ($blog['status'] ?? '') === 'draft' ? 'selected' : '' ?>>Draft</option>
          <option value="published" <?= ($blog['status'] ?? '') === 'published' ? 'selected' : '' ?>>Published</option>
        </select>
      </div>
    </div>
    <div>
      <label class="block text-xs font-medium text-gray-600 mb-1">Excerpt (shown on blog listing cards)</label>
      <textarea name="excerpt" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none resize-none" placeholder="Short summary (1-2 sentences)..."><?= htmlspecialchars($blog['excerpt'] ?? '') ?></textarea>
    </div>
    <div>
      <label class="block text-xs font-medium text-gray-600 mb-1">Content *</label>
      <p class="text-xs text-gray-400 mb-2">Supports HTML for formatting (headings, paragraphs, lists, links, bold/italic).</p>
      <textarea name="content" rows="16" required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm font-mono focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none"
                placeholder="<h2>Section Title</h2>&#10;<p>Your content here...</p>&#10;<ul>&#10;<li>Key point</li>&#10;</ul>"><?= htmlspecialchars($blog['content'] ?? '') ?></textarea>
    </div>
  </div>

  <div class="flex items-center justify-between">
    <div>
      <?php if ($isEdit): ?>
        <button type="submit" name="delete" value="1" class="text-sm text-red-500 hover:text-red-700 transition"
                onclick="return confirm('Delete this article? This cannot be undone.')">Delete Article</button>
      <?php endif; ?>
    </div>
    <div class="flex items-center gap-3">
      <a href="blogs.php" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-900 transition">Cancel</a>
      <button type="submit" class="bg-gray-900 text-white px-6 py-2 rounded-lg text-sm font-medium hover:bg-gray-800 transition">
        <?= $isEdit ? 'Save Changes' : 'Publish Article' ?>
      </button>
    </div>
  </div>
</form>

<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
