<?php
// --- 1. DATA LADEN ---
$jsonPath = __DIR__ . '/../data/products.json';
$raw = @file_get_contents($jsonPath);
$store = json_decode($raw, true);
$partnerId = $store['config']['partner_id'] ?? '1234567';

// --- 2. DE HANDMATIGE CATALOGUS (Jouw 10 demo-artikelen) ---
function getProductDetails($ean) {
    $catalog = [
        "8721325324221" => [
            "title" => "Techidna® - Kabel Tape 25mm x 15m - Zwart",
            "image" => "https://media.s-bol.com/v07285qzPJx5/AnODK67/550x550.jpg",
            "price" => "13.95"
        ],
        "8721325324115" => [
            "title" => "Techidna® - Laptoptas 14 inch - Compact Bruin",
            "image" => "https://media.s-bol.com/YL539loWLLz9/qjDmoA2/550x489.jpg",
            "price" => "24.95"
        ],
        "8721325324009" => [
            "title" => "Techidna® - Kabel organiser tas - Zwart - Compact design",
            "image" => "https://media.s-bol.com/RzmlmKW21OLz/G5nM6P5/550x545.jpg",
            "price" => "11.99"
        ],
        "8721325324078" => [
            "title" => "Techidna® - Hittebestendige Kapton Tape - 25mm x 33m",
            "image" => "https://media.s-bol.com/BZ5y3zqoVlO2/r0nlmW2/550x686.jpg",
            "price" => "12.95"
        ],
        "8721325324542" => [
            "title" => "Techidna® Draadloze USB Microfoon - 2 Microfoons + USB-C",
            "image" => "https://media.s-bol.com/yggrkkGE09nw/qjVrNVG/550x550.jpg",
            "price" => "14.99"
        ],
        "8721325324610" => [
            "title" => "Techidna® - Ergonomische Muismat met Polssteun - Paars",
            "image" => "https://media.s-bol.com/JBP9xyAmr3mv/qjE1qG0/550x598.jpg",
            "price" => "19.95"
        ],
        "8721325324016" => [
            "title" => "Techidna® - Teflon Tape (PTFE) - 2 Rollen - 20 Meter",
            "image" => "https://media.s-bol.com/4Zwgxlw8zqV6/nZJQBjY/550x550.jpg",
            "price" => "9.95"
        ],
        "8721325324085" => [
            "title" => "Techidna® - Documentenmap A4 - Veganleer - Bruin",
            "image" => "https://media.s-bol.com/YLlVGQxvkYJM/Z4vKLL2/550x396.jpg",
            "price" => "19.95"
        ],
        "8721325324498" => [
            "title" => "Perzisch Tapijt Muismat - 25x18 cm - Warm Rood",
            "image" => "https://media.s-bol.com/n16DP3gD3YlR/g5jy3qj/550x550.jpg",
            "price" => "12.50"
        ],
        "8721325324108" => [
            "title" => "Techidna® - Laptophoes 14 inch - Waterafstotend - Blauw",
            "image" => "https://media.s-bol.com/v07285qzPJx5/AnODK67/550x550.jpg",
            "price" => "17.99"
        ]
    ];

    $data = $catalog[$ean] ?? [
        "title" => "Techidna® Premium Product",
        "image" => "https://media.s-bol.com/v07285qzPJx5/AnODK67/550x550.jpg",
        "price" => "19.95"
    ];

    return [
        'title' => $data['title'],
        'image' => $data['image'],
        'price' => $data['price'],
        'url'   => "https://www.bol.com/nl/nl/s/?searchtext=" . $ean,
        'stock' => rand(2, 12)
    ];
}

function getAffiliateLink($url, $pid) {
    return "https://partner.bol.com/click/click?p=2&s=" . $pid . "&t=url&url=" . urlencode($url) . "&f=TID";
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Techidna® | Partner Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --bol: #004899; --techidna: #00d1b2; --bg: #f8fafc; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: var(--bg); color: #1e293b; }
        .navbar { background: white; border-bottom: 3px solid var(--techidna); padding: 1rem 0; }
        .hero { background: #0f172a; color: white; padding: 60px 0; margin-bottom: 40px; border-bottom-left-radius: 40px; border-bottom-right-radius: 40px; }
        .product-card { border: none; border-radius: 20px; transition: 0.3s; background: white; height: 100%; display: flex; flex-direction: column; overflow: hidden; }
        .product-card:hover { transform: translateY(-8px); box-shadow: 0 20px 40px rgba(0,0,0,0.08); }
        .price-text { font-size: 1.75rem; font-weight: 800; color: var(--bol); }
        .btn-bol { background: var(--bol); color: white; border-radius: 50px; padding: 12px; font-weight: 700; text-decoration: none; display: block; text-align: center; border: none; }
        .btn-bol:hover { background: #003366; color: white; }
    </style>
</head>
<body>

<nav class="navbar shadow-sm sticky-top">
    <div class="container">
        <span class="navbar-brand fw-bold fs-3">TECHIDNA<span style="color:var(--techidna)">.</span></span>
        <span class="badge bg-light text-dark border d-none d-md-inline">Official Partner Hub</span>
    </div>
</nav>

<header class="hero text-center">
    <div class="container">
        <h1 class="fw-800 display-4 mb-2 text-white">Techidna® Shop</h1>
        <p class="lead opacity-75 text-white">Ontdek ons exclusieve assortiment op Bol.com</p>
    </div>
</header>

<div class="container mb-5">
    <div class="row g-4">
        <?php if($store && isset($store['products'])): ?>
            <?php foreach($store['products'] as $item): 
                $details = getProductDetails($item['ean']);
                $finalUrl = getAffiliateLink($details['url'], $partnerId);
            ?>
            <div class="col-md-6 col-lg-4">
                <div class="card product-card p-4 shadow-sm">
                    <div class="text-center mb-4">
                        <img src="<?php echo $details['image']; ?>" class="rounded-3" style="height:200px; width:100%; object-fit:contain;">
                    </div>
                    <h5 class="fw-bold mb-2"><?php echo $details['title']; ?></h5>
                    <div class="price-text mb-4">€ <?php echo $details['price']; ?></div>
                    
                    <div class="mt-auto">
                        <div class="d-flex justify-content-between small mb-3">
                            <span class="text-muted">Status:</span>
                            <span class="text-success fw-bold">✓ <?php echo $details['stock']; ?> op voorraad</span>
                        </div>
                        <a href="<?php echo $finalUrl; ?>" target="_blank" class="btn-bol">Bestel bij Bol.com</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<footer class="py-5 bg-white border-top text-center text-muted">
    <div class="container">
        <p class="mb-1 fw-bold">Techidna® Brand Portal</p>
        <small>Real-time Partner Dashboard &copy; <?php echo date('Y'); ?></small>
    </div>
</footer>

</body>
</html>
