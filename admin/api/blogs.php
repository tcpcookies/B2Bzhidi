<?php
/**
 * Public API — Blog Posts
 * Returns JSON array of published blog posts.
 * Usage: GET /admin/api/blogs.php  → all published posts
 *        GET /admin/api/blogs.php?slug=article-slug  → single post
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

require_once __DIR__ . '/../includes/config.php';

try {
    $db = getDB();

    if (isset($_GET['slug'])) {
        $stmt = $db->prepare("SELECT * FROM blogs WHERE slug = ? AND status = 'published'");
        $stmt->execute([$_GET['slug']]);
        $post = $stmt->fetch();

        if (!$post) {
            http_response_code(404);
            echo json_encode(['error' => 'Post not found']);
            exit;
        }
        echo json_encode($post, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    } else {
        $limit = min((int)($_GET['limit'] ?? 20), 50);
        $stmt = $db->prepare("SELECT * FROM blogs WHERE status = 'published' ORDER BY published_at DESC LIMIT ?");
        $stmt->execute([$limit]);
        $posts = $stmt->fetchAll();
        echo json_encode($posts, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
