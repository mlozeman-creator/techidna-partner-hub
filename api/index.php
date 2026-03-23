<?php
// --- 1. DATA LADEN ---
$jsonPath = __DIR__ . '/../data/products.json';
$raw = @file_get_contents($jsonPath);
$store = json_decode($raw, true);
$partnerId = $store['config']['partner_id'] ?? '1234567';

// --- 2. HANDMATIGE PRODUCT DATA (De "PIM" laag) ---
function getProductDetails($ean) {
    // Hier definieer je de 10 artikelen voor je demo
    $catalog = [
        "8721325324221" => [
            "title" => "Techidna® - Kabel Tape 25mm x 15m - Zwart",
            "image" => "https://media.s-bol.com/v07285qzPJx5/AnODK67/550x550.jpg",
            "price" => "13.95"
        ],
        "8721325324115" => [
            "title" => "Techidna® - Laptoptas 14 inch - Bruin PU Leer",
            "image" => "https://media.s-bol.com/YL539loWLLz9/qjDmoA2/550x489.jpg",
            "price" => "24.95"
        ],
        "8721325324009" => [
            "title" => "Techidna® - USB-C Hub 6-in-1 Multiport",
            "image" => "https://media.s-bol.com/v07285qzPJx5/AnODK67/550x550.jpg",
            "price" => "34.95"
        ]
        // VOEG HIER DE OVERIGE 7 ARTIKELEN TOE OP DEZELFDE MANIER
    ];

    // Fallback voor als een EAN niet in de lijst staat
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
        'stock' => rand(3, 12)
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
        .product-card { border: none; border-radius: 20px; transition: 0.3s; background: white; height: 100%; display: flex; flex-direction: column; }
        .product-card:hover { transform: translateY(-8px); box-shadow: 0 20px 40px rgba(0,0,0,0.05); }
        .btn-bol { background: var(--bol); color: white; border-radius: 50px; padding: 12px; font-weight: 700; text-decoration: none; display: block; text-align: center; }
    </style>
</head>
<body>

<nav class="navbar shadow-sm">
    <div class="container">
        <span class="navbar-brand fw-bold fs-3">TECHIDNA<span style="color:var(--techidna)">.</span></span>
    </div>
</nav>

<header class="hero text-center">
    <div class="container">
        <h1 class="fw-800 display-4">Official Partner Hub</h1>
        <p class="lead opacity-75">Geselecteerde Techidna® producten direct leverbaar via Bol.com</p>
    </div>
</header>

<div class="container mb-5">
    <div class="row g-4">
        <?php foreach($store['products'] as $item): 
            $details = getProductDetails($item['ean']);
            $finalUrl = getAffiliateLink($details['url'], $partnerId);
        ?>
        <div class="col-md-4">
            <div class="card product-card p-4 shadow-sm">
                <img src="<?php echo $details['image']; ?>" class="rounded-4 mb-3" style="height:200px; object-fit:contain;">
                <h5 class="fw-bold mb-2"><?php echo $details['title']; ?></h5>
                <div class="fs-3 fw-bold mb-3 text-primary">€ <?php echo $details['price']; ?></div>
                
                <div class="mt-auto">
                    <div class="d-flex justify-content-between small mb-2">
                        <span>Beschikbaarheid:</span>
                        <span class="text-success fw-bold"><?php echo $details['stock']; ?> op voorraad</span>
                    </div>
                    <a href="<?php echo $finalUrl; ?>" target="_blank" class="btn-bol">Bestel bij Bol.com</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<footer class="py-4 text-center text-muted">
    <small>&copy; <?php echo date('Y'); ?> Techidna® Hub - Mark Lozeman</small>
</footer>

</body>
</html>
