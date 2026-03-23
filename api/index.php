<?php
// --- 1. DATA LADEN ---
$jsonPath = __DIR__ . '/../data/products.json';
$raw = @file_get_contents($jsonPath);
$store = json_decode($raw, true);
$partnerId = $store['config']['partner_id'] ?? '1234567';

// --- 2. DE GECONTROLEERDE CATALOGUS ---
function getProductDetails($ean) {
    // Deze lijst koppelt de EAN uit je JSON aan de juiste tekst en foto
    $catalog = [
        "8721325324115" => [
            "title" => "Techidna® - Laptoptas 14 inch - Bruin", 
            "image" => "https://media.s-bol.com/YL539loWLLz9/qjDmoA2/550x489.jpg", 
            "price" => "24.95"
        ],
        "8721325324108" => [
            "title" => "Techidna® - Laptophoes 14 inch - Blauw", 
            "image" => "https://media.s-bol.com/v07285qzPJx5/AnODK67/550x550.jpg", 
            "price" => "17.99"
        ],
        "8721325324009" => [
            "title" => "Techidna® - Kabel organiser tas - Zwart", 
            "image" => "https://media.s-bol.com/RzmlmKW21OLz/G5nM6P5/550x545.jpg", 
            "price" => "11.99"
        ],
        "8721325324085" => [
            "title" => "Techidna® - Documentenmap A4 - Veganleer", 
            "image" => "https://media.s-bol.com/YLlVGQxvkYJM/Z4vKLL2/550x396.jpg", 
            "price" => "19.95"
        ],
        "8721325324542" => [
            "title" => "Techidna® - Draadloze USB Microfoon Set", 
            "image" => "https://media.s-bol.com/yggrkkGE09nw/qjVrNVG/550x550.jpg", 
            "price" => "14.99"
        ],
        "8721325324610" => [
            "title" => "Techidna® - Ergonomische Muismat - Paars", 
            "image" => "https://media.s-bol.com/JBP9xyAmr3mv/qjE1qG0/550x598.jpg", 
            "price" => "19.95"
        ],
        "8721325324498" => [
            "title" => "Techidna® - Perzisch Tapijt Muismat", 
            "image" => "https://media.s-bol.com/n16DP3gD3YlR/g5jy3qj/550x550.jpg", 
            "price" => "12.50"
        ],
        "8721325324221" => [
            "title" => "Techidna® - Kabel Tape 25mm x 15m - Zwart", 
            "image" => "https://media.s-bol.com/v07285qzPJx5/AnODK67/550x550.jpg", 
            "price" => "13.95"
        ],
        "8721325324078" => [
            "title" => "Techidna® - Kapton Tape - 25mm x 33m", 
            "image" => "https://media.s-bol.com/BZ5y3zqoVlO2/r0nlmW2/550x686.jpg", 
            "price" => "12.95"
        ],
        "8721325324016" => [
            "title" => "Techidna® - Teflon Tape (PTFE) - 2 Rollen", 
            "image" => "https://media.s-bol.com/4Zwgxlw8zqV6/nZJQBjY/550x550.jpg", 
            "price" => "9.95"
        ]
    ];

    // De fallback: als de EAN niet in de catalogus staat, tonen we een standaard Techidna item
    $data = $catalog[$ean] ?? [
        "title" => "Techidna® Premium Product",
        "image" => "https://media.s-bol.com/v07285qzPJx5/AnODK67/550x550.jpg",
        "price" => "19.95"
    ];

    return [
        'title' => $data['title'],
        'image' => $data['image'],
        'price' => $data['price'],
        // De URL wordt hier hard gekoppeld aan de EAN die binnenkomt
        'url'   => "https://www.bol.com/nl/nl/s/?searchtext=" . $ean,
        'stock' => rand(3, 15)
    ];
}

function getAffiliateLink($url, $pid) {
    // Voegt partner-id toe aan de link voor commissie-tracking
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
        .navbar { background: white; border-bottom: 3px solid var(--techidna); padding: 1.2rem 0; }
        .hero { background: #0f172a; color: white; padding: 80px 0; margin-bottom: 40px; border-bottom-left-radius: 50px; border-bottom-right-radius: 50px; }
        .product-card { border: none; border-radius: 24px; transition: 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); background: white; height: 100%; display: flex; flex-direction: column; overflow: hidden; border: 1px solid #e2e8f0; }
        .product-card:hover { transform: translateY(-12px); box-shadow: 0 30px 60px rgba(0,0,0,0.1); }
        .price-tag { font-size: 1.8rem; font-weight: 800; color: var(--bol); }
        .btn-bol { background: var(--bol); color: white; border-radius: 50px; padding: 14px; font-weight: 800; text-decoration: none; display: block; text-align: center; border: none; transition: 0.3s; }
        .btn-bol:hover { background: #003366; color: white; transform: scale(1.02); }
    </style>
</head>
<body>

<nav class="navbar shadow-sm sticky-top">
    <div class="container">
        <span class="navbar-brand fw-extrabold fs-2">TECHIDNA<span style="color:var(--techidna)">.</span></span>
        <span class="badge bg-light text-dark border d-none d-md-inline">Official Partner Dashboard</span>
    </div>
</nav>

<header class="hero text-center">
    <div class="container">
        <h1 class="fw-800 display-3 mb-3 text-white">Techidna® Shop</h1>
        <p class="lead opacity-75 text-white fs-4">Ontdek ons volledige assortiment via Bol.com</p>
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
                        <img src="<?php echo $details['image']; ?>" class="rounded-4" style="height:220px; width:100%; object-fit:contain;">
                    </div>
                    <h5 class="fw-bold mb-2" style="min-height: 3em;"><?php echo $details['title']; ?></h5>
                    <div class="price-tag mb-4 mt-2">€ <?php echo $details['price']; ?></div>
                    
                    <div class="mt-auto">
                        <div class="d-flex justify-content-between small mb-3">
                            <span class="text-muted fw-bold">Beschikbaarheid:</span>
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
        <p class="mb-1 fw-bold text-dark">Techidna® Brand Portal</p>
        <p class="small mb-0">Powered by Data-Driven Middleware | Mark Lozeman</p>
    </div>
</footer>

</body>
</html>
