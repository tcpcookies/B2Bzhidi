<?php
/**
 * Public API — Products
 * Returns JSON array of published products.
 * Usage: GET /admin/api/products.php  → all published products
 *        GET /admin/api/products.php?slug=planetary-vacuum-mixer  → single product
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

require_once __DIR__ . '/../includes/config.php';

try {
    $db = getDB();

    if (isset($_GET['slug'])) {
        $stmt = $db->prepare("SELECT * FROM products WHERE slug = ? AND status = 'published'");
        $stmt->execute([$_GET['slug']]);
        $product = $stmt->fetch();

        if (!$product) {
            http_response_code(404);
            echo json_encode(['error' => 'Product not found']);
            exit;
        }
        echo json_encode($product, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    } else {
        $stmt = $db->query("SELECT * FROM products WHERE status = 'published' ORDER BY sort_order ASC, id DESC");
        $products = $stmt->fetchAll();
        echo json_encode($products, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
