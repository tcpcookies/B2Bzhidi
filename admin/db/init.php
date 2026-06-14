<?php
/**
 * ZHIDI Tech Admin — Database Initialization
 * SQLite-powered, zero-configuration.
 * Run once: php db/init.php
 */

$dbPath = __DIR__ . '/zhidi_admin.sqlite';

try {
    $db = new PDO("sqlite:$dbPath");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Users table
    $db->exec("CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT NOT NULL UNIQUE,
        password_hash TEXT NOT NULL,
        display_name TEXT DEFAULT '',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

    // Products table
    $db->exec("CREATE TABLE IF NOT EXISTS products (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        slug TEXT NOT NULL UNIQUE,
        category TEXT DEFAULT '',
        category_slug TEXT DEFAULT '',
        description TEXT DEFAULT '',
        short_desc TEXT DEFAULT '',
        price TEXT DEFAULT '',
        models_count INTEGER DEFAULT 1,
        image_main TEXT DEFAULT '',
        image_thumb1 TEXT DEFAULT '',
        image_thumb2 TEXT DEFAULT '',
        image_thumb3 TEXT DEFAULT '',
        image_thumb4 TEXT DEFAULT '',
        featured INTEGER DEFAULT 0,
        status TEXT DEFAULT 'draft' CHECK(status IN ('published','draft','archived')),
        specs TEXT DEFAULT '[]',
        sort_order INTEGER DEFAULT 0,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

    // Blog posts table
    $db->exec("CREATE TABLE IF NOT EXISTS blogs (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title TEXT NOT NULL,
        slug TEXT NOT NULL UNIQUE,
        excerpt TEXT DEFAULT '',
        content TEXT DEFAULT '',
        category TEXT DEFAULT 'Industry News',
        image_url TEXT DEFAULT '',
        status TEXT DEFAULT 'draft' CHECK(status IN ('published','draft')),
        published_at DATETIME DEFAULT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

    // Insert default admin (password: admin123 — CHANGE AFTER FIRST LOGIN)
    $stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
    $stmt->execute(['admin']);
    if ($stmt->fetchColumn() == 0) {
        $hash = password_hash('admin123', PASSWORD_BCRYPT);
        $db->prepare("INSERT INTO users (username, password_hash, display_name) VALUES (?, ?, ?)")
           ->execute(['admin', $hash, 'Admin']);
        echo "✓ Default admin created (admin / admin123)\n";
    }

    // Seed existing products
    $products = [
        [
            'name' => 'Planetary Centrifugal Vacuum Mixer',
            'slug' => 'planetary-vacuum-mixer',
            'category' => 'Mixing Equipment',
            'category_slug' => 'mixing',
            'short_desc' => 'High-speed planetary centrifugal mixing with vacuum defoaming for battery slurry, ceramics, epoxy, LED phosphor.',
            'price' => '$5,660 — $60,000',
            'models_count' => 36,
            'image_main' => '1601564575134_00.png',
            'image_thumb1' => '1601559039570_00.png',
            'image_thumb2' => '1601564496849_00.png',
            'image_thumb3' => '1601562168246_00.png',
            'image_thumb4' => '1601564617370_00.png',
            'featured' => 1,
            'status' => 'published',
            'sort_order' => 1
        ],
        [
            'name' => 'Double Planetary Mixer',
            'slug' => 'double-planetary-mixer',
            'category' => 'Mixing Equipment',
            'category_slug' => 'mixing',
            'short_desc' => 'Heavy-duty double planetary mixing for high-viscosity materials — silicone sealants, epoxy, polyurethane, solder paste.',
            'price' => '$6,000 — $18,000',
            'models_count' => 9,
            'image_main' => '1601449517132_00.png',
            'image_thumb1' => '1601487180431_00.png',
            'image_thumb2' => '1601487186418_00.png',
            'image_thumb3' => '1601475984731_00.jpg',
            'image_thumb4' => '1601563917022_00.png',
            'featured' => 0,
            'status' => 'published',
            'sort_order' => 2
        ],
        [
            'name' => 'Planetary Ball Mill',
            'slug' => 'planetary-ball-mill',
            'category' => 'Laboratory Equipment',
            'category_slug' => 'lab',
            'short_desc' => 'High-energy laboratory grinding for fine grinding, mixing, and mechanical alloying. For materials science and pharmaceutical R&D.',
            'price' => 'CNY 10,094',
            'models_count' => 3,
            'image_main' => '1601482481640_00.png',
            'image_thumb1' => '1601482481640_00.png',
            'featured' => 0,
            'status' => 'published',
            'sort_order' => 3
        ],
        [
            'name' => 'Ink Mixer & Rolling Machine',
            'slug' => 'ink-mixer',
            'category' => 'Paint & Ink Equipment',
            'category_slug' => 'ink',
            'short_desc' => 'Variable-frequency ink mixing and paint rolling. Offset printing color mixers, barrel rollers for 20-40kg containers.',
            'price' => 'Inquire',
            'models_count' => 8,
            'image_main' => '1601582367568_00.png',
            'image_thumb1' => '1601582191562_00.jpg',
            'image_thumb2' => '1601582426241_00.jpg',
            'featured' => 0,
            'status' => 'published',
            'sort_order' => 4
        ],
        [
            'name' => 'Multi-Purpose Screening Machine',
            'slug' => 'screening-machine',
            'category' => 'Screening Equipment',
            'category_slug' => 'screening',
            'short_desc' => 'Multi-purpose sorting — separates pupae, dead worms, feces, grades by size. Stainless steel, dust-free enclosure.',
            'price' => 'Inquire',
            'models_count' => 8,
            'image_main' => '1601498700347_00.png',
            'image_thumb1' => '1601498592806_00.png',
            'image_thumb2' => '1601498655948_00.png',
            'image_thumb3' => '1601498669711_00.png',
            'image_thumb4' => '1601498776615_00.png',
            'featured' => 0,
            'status' => 'published',
            'sort_order' => 5
        ],
        [
            'name' => 'Paint Rolling & Aging Machine',
            'slug' => 'paint-rolling-machine',
            'category' => 'Paint & Ink Equipment',
            'category_slug' => 'ink',
            'short_desc' => 'Continuous rolling anti-sedimentation for paint curing. Large barrel rollers for industrial ink and paint production.',
            'price' => 'Inquire',
            'models_count' => 2,
            'image_main' => '1601487145098_00.png',
            'featured' => 0,
            'status' => 'published',
            'sort_order' => 6
        ],
        [
            'name' => 'Screen Frame Dryer',
            'slug' => 'screen-frame-dryer',
            'category' => 'PCB Equipment',
            'category_slug' => 'pcb',
            'short_desc' => 'Horizontal precision drying for screen printing frames. Uniform heat distribution, digital temperature control.',
            'price' => 'Inquire',
            'models_count' => 2,
            'image_main' => '1601492514842_00.png',
            'image_thumb1' => '1601492544289_00.jpg',
            'featured' => 0,
            'status' => 'published',
            'sort_order' => 7
        ],
        [
            'name' => '100L Double Planetary Mixer',
            'slug' => '100l-double-planetary-mixer',
            'category' => 'Mixing Equipment',
            'category_slug' => 'mixing',
            'short_desc' => 'Industrial-scale mixing for adhesives, sealants, and high-viscosity compounds. Hydraulic lift, vacuum capable.',
            'price' => '$18,000',
            'models_count' => 1,
            'image_main' => '100L-mixer-main.jpg',
            'featured' => 0,
            'status' => 'published',
            'sort_order' => 8
        ],
        [
            'name' => 'Ceramic Planetary Mixer 30L',
            'slug' => 'ceramic-planetary-mixer-30l',
            'category' => 'Mixing Equipment',
            'category_slug' => 'mixing',
            'short_desc' => 'Alumina ceramic chamber for metal-free mixing. Ideal for electronic ceramics, MLCC paste, and high-purity material processing.',
            'price' => '$12,000',
            'models_count' => 1,
            'image_main' => 'ceramic-mixer-30L-1.jpg',
            'featured' => 0,
            'status' => 'published',
            'sort_order' => 9
        ],
    ];

    $stmt = $db->prepare("SELECT COUNT(*) FROM products");
    $stmt->execute();
    if ($stmt->fetchColumn() == 0) {
        $insert = $db->prepare("INSERT INTO products (name, slug, category, category_slug, short_desc, price, models_count, image_main, image_thumb1, image_thumb2, image_thumb3, image_thumb4, featured, status, sort_order) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        foreach ($products as $p) {
            $insert->execute([
                $p['name'], $p['slug'], $p['category'], $p['category_slug'],
                $p['short_desc'], $p['price'], $p['models_count'],
                $p['image_main'],
                $p['image_thumb1'] ?? '', $p['image_thumb2'] ?? '',
                $p['image_thumb3'] ?? '', $p['image_thumb4'] ?? '',
                $p['featured'], $p['status'], $p['sort_order']
            ]);
        }
        echo "✓ " . count($products) . " products seeded.\n";
    }

    echo "✓ Database initialized successfully.\n";
} catch (PDOException $e) {
    die("DB Error: " . $e->getMessage() . "\n");
}
