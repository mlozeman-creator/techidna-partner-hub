<?php
// --- 1. DATA LADEN ---
$jsonPath = __DIR__ . '/../data/products.json';
$raw = @file_get_contents($jsonPath);
$store = json_decode($raw, true);
$partnerId = $store['config']['partner_id'] ?? '1234567';

// --- 2. DE WATERDICHTE CATALOGUS ---
function getProductDetails($ean) {
    // We koppelen hier de EAN aan de EXACTE Bol.com URL
    $catalog = [
        "8721325324115" => [
            "title" => "Techidna® - Laptoptas 14 inch - Bruin", 
            "image" => "https://media.s-bol.com/YL539loWLLz9/qjDmoA2/550x489.jpg", 
            "price" => "24.95",
            "direct_url" => "https://www.bol.com/nl/nl/p/techidna-laptoptas-14-inch-bruin/9300000166213254/"
        ],
        "8721325324108" => [
            "title" => "Techidna® - Laptophoes 14 inch - Blauw", 
            "image" => "https://media.s-bol.com/v07285qzPJx5/AnODK67/550x550.jpg", 
            "price" => "17.99",
            "direct_url" => "https://www.bol.com/nl/nl/s/?searchtext=8721325324108"
        ],
        "8721325324009" => [
            "title" => "Techidna® - Kabel organiser tas - Zwart", 
            "image" => "https://media.s-bol.com/RzmlmKW21OLz/G5nM6P5/550x545.jpg", 
            "price" => "11.99",
            "direct_url" => "https://www.bol.com/nl/nl/p/techidna-kabel-organiser-tas-zwart/9300000166213248/"
        ],
        "8721325324085" => [
            "title" => "Techidna® - Documentenmap A4 - Veganleer", 
            "image" => "https://media.s-bol.com/YLlVGQxvkYJM/Z4vKLL2/550x396.jpg", 
            "price" => "19.95",
            "direct_url" => "https://www.bol.com/nl/nl/s/?searchtext=8721325324085"
        ],
        "8721325324542" => [
            "title" => "Techidna® - Draadloze USB Microfoon Set", 
            "image" => "https://media.s-bol.com/yggrkkGE09nw/qjVrNVG/550x550.jpg", 
            "price" => "14.99",
            "direct_url" => "https://www.bol.com/nl/nl/s/?searchtext=8721325324542"
        ],
        "8721325324610" => [
            "title" => "Techidna® - Ergonomische Muismat - Paars", 
            "image" => "https://media.s-bol.com/JBP9xyAmr3mv/qjE1qG0/550x598.jpg", 
            "price" => "19.95",
            "direct_url" => "https://www.bol.com/nl/nl/s/?searchtext=8721325324610"
        ],
        "8721325324498" => [
            "title" => "Techidna® - Perzisch Tapijt Muismat", 
            "image" => "https://media.s-bol.com/n16DP3gD3YlR/g5jy3qj/550x550.jpg", 
            "price" => "12.50",
            "direct_url" => "https://www.bol.com/nl/nl/s/?searchtext=8721325324498"
        ],
        "8721325324221" => [
            "title" => "Techidna® - Kabel Tape 25mm x 15m - Zwart", 
            "image" => "https://media.s-bol.com/v07285qzPJx5/AnODK67/550x550.jpg", 
            "price" => "13.95",
            "direct_url" => "https://www.bol.com/nl/nl/s/?searchtext=8721325324221"
        ],
        "8721325324078" => [
            "title" => "Techidna® - Kapton Tape - 25mm x 33m", 
            "image" => "https://media.s-bol.com/BZ5y3zqoVlO2/r0nlmW2/550x686.jpg", 
            "price" => "12.95",
            "direct_url" => "https://www.bol.com/nl/nl/s/?searchtext=8721325324078"
        ],
        "8721325324016" => [
            "title" => "Techidna® - Teflon Tape (PTFE) - 2 Rollen", 
            "image" => "https://media.s-bol.com/4Zwgxlw8zqV6/nZJQBjY/550x550.jpg", 
            "price" => "9.95",
            "direct_url" => "https://www.bol.com/nl/nl/p/techidna-teflon-tape-2-rollen-20-meter-totaal-12mm-x-0-075mm-voor-water-gas-lucht-sanitair/9300000241265911/?cid=1774297353920-8849744073513&bltgh=98910a28-13dc-4762-aba5-d97efd5bf9f1.ProductList_Middle.0.ProductTitle"
        ]
    ];

    $data = $catalog[$ean] ?? [
        "title" => "Techidna® Product",
        "image" => "https://media.s-bol.com/v07285qzPJx5/AnODK67/550x550.jpg",
        "price" => "19.95",
        "direct_url" => "https://www.bol.com/nl/nl/s/?searchtext=" . $ean
    ];

    return $data;
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
    <title>Techidna® | Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --bol: #004899; --techidna: #00d1b2; --bg: #f8fafc; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: var(--bg); }
        .navbar { background: white; border-bottom: 3px solid var(--techidna); padding: 1rem; }
        .hero { background: #0f172a; color: white; padding: 60px 0; border-bottom-left-radius: 40px; border-bottom-right-radius: 40px; text-align: center; margin-bottom: 40px; }
        .product-card { border: none; border-radius: 20px; transition: 0.3s; background: white; height: 100%; display: flex; flex-direction: column; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .product-card:hover { transform: translateY(-5px); box-shadow: 0 12px 20px rgba(0,0,0,0.1); }
        .price { font-size: 1.5rem; font-weight: 800; color: var(--bol); margin: 15px 0; }
        .btn-bol { background: var(--bol); color: white; border-radius: 50px; padding: 12px; font-weight: 700; text-decoration: none; display: block; text-align: center; }
    </style>
</head>
<body>

<nav class="navbar sticky-top">
    <div class="container">
        <span class="fw-bold fs-3">TECHIDNA<span style="color:var(--techidna)">.</span></span>
    </div>
</nav>

<header class="hero">
    <div class="container">
        <h1>Official Brand Hub</h1>
        <p class="opacity-75">Gecureerd assortiment</p>
    </div>
</header>

<div class="container mb-5">
    <div class="row g-4">
        <?php if($store && isset($store['products'])): ?>
            <?php foreach($store['products'] as $item): 
                $details = getProductDetails($item['ean']);
                $finalUrl = getAffiliateLink($details['direct_url'], $partnerId);
            ?>
            <div class="col-md-4">
                <div class="card product-card p-4">
                    <img src="<?php echo $details['image']; ?>" class="mb-3" style="height:180px; object-fit:contain;">
                    <h5 class="fw-bold"><?php echo $details['title']; ?></h5>
                    <div class="price">€ <?php echo $details['price']; ?></div>
                    <div class="mt-auto">
                        <a href="<?php echo $finalUrl; ?>" target="_blank" class="btn-bol">Bekijk op Bol.com</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
