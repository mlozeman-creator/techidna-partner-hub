<?php
// --- 1. CONFIGURATIE & DATA LADEN ---
$jsonPath = __DIR__ . '/../data/products.json';
$raw = @file_get_contents($jsonPath);
$store = json_decode($raw, true);

// Fallback als de JSON leeg is
if (!$store) {
    $store = ['brand' => 'Techidna', 'products' => [], 'config' => ['partner_id' => '1234567']];
}

$partnerId = $store['config']['partner_id'] ?? '1234567';
$isAdmin = (isset($_GET['role']) && $_GET['role'] === 'admin');

// --- 2. DE ENRICHMENT ENGINE (Lookup Table) ---
function getProductDetails($ean) {
    // Dynamische Bol.com zoeklink op basis van EAN
    $bolSearchUrl = "https://www.bol.com/nl/nl/s/?searchtext=" . $ean;
    
    // --- DATABASE: Specifieke namen voor je demo-artikelen ---
    $titles = [
        "8721325324221" => "Techidna® - Kabel Tape 25mm x 15m - Pro Series Zwart",
        "8721325324115" => "Techidna® - Laptoptas 14 inch - Compact Bruin PU Leer",
        "8721325324009" => "Techidna® - Premium USB-C Hub 6-in-1 - Space Grey",
    ];

    // --- DATABASE: Specifieke afbeeldingen voor je demo-artikelen ---
    $images = [
        "8721325324221" => "https://media.s-bol.com/v07285qzPJx5/AnODK67/550x550.jpg",
        "8721325324115" => "https://media.s-bol.com/YL539loWLLz9/qjDmoA2/550x489.jpg",
        "8721325324009" => "https://media.s-bol.com/v07285qzPJx5/AnODK67/550x550.jpg", // Placeholder voor hub
    ];

    // Bepaal de titel (of gebruik placeholder)
    $title = $titles[$ean] ?? "Techidna® Professional Solution [" . substr($ean, -4) . "]";
    
    // Bepaal de afbeelding (of gebruik de gok die de fallback triggert)
    $mediaUrl = $images[$ean] ?? "https://media.s-bol.com/ean-lookup/" . $ean . "/550x550.jpg";
    
    // Standaard Fallback afbeelding (De tape rol)
    $fallbackImg = "https://media.s-bol.com/v07285qzPJx5/AnODK67/550x550.jpg";

    return [
        'title' => $title,
        'price' => rand(14, 89) . ".95", // Gesimuleerde live-prijs
        'image' => $mediaUrl,
        'fallback' => $fallbackImg,
        'url' => $bolSearchUrl,
        'stock' => rand(1, 15),
        'sync_id' => strtoupper(bin2hex(random_bytes(3))),
        'timestamp' => date('H:i')
    ];
}

// --- 3. AFFILIATE TRACKING GENERATOR ---
function getAffiliateLink($url, $pid) {
    if ($pid === '1234567' || empty($pid)) return $url;
    return "https://partner.bol.com/click/click?p=2&s=" . $pid . "&t=url&url=" . urlencode($url) . "&f=TID&name=TechidnaHub";
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Techidna® | Smart Partner Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --bol: #004899; --techidna: #00d1b2; --dark: #0f172a; --bg: #f8fafc; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: var(--bg); color: #1e293b; }
        
        .navbar { background: white; border-bottom: 3px solid var(--techidna); padding: 1.2rem 0; }
        .hero-gradient { background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: white; padding: 100px 0 80px; clip-path: polygon(0 0, 100% 0, 100% 90%, 0% 100%); }
        
        .product-card { border: none; border-radius: 24px; transition: 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); background: white; border: 1px solid #e2e8f0; height: 100%; display: flex; flex-direction: column; }
        .product-card:hover { transform: translateY(-12px); box-shadow: 0 30px 60px rgba(0,0,0,0.12); }
        
        .price-tag { font-size: 1.8rem; font-weight: 800; color: var(--bol); }
        .btn-bol { background: var(--bol); color: white; border-radius: 50px; padding: 15px; font-weight: 800; text-decoration: none; display: block; text-align: center; transition: 0.3s; }
        .btn-bol:hover { background: #003366; color: white; transform: scale(1.02); }
        
        .stock-meter { height: 8px; background: #e2e8f0; border-radius: 10px; overflow: hidden; margin: 10px 0; }
        .stock-fill { height: 100%; background: var(--techidna); }
        .api-badge { font-size: 0.65rem; font-weight: 700; background: #f1f5f9; padding: 4px 10px; border-radius: 6px; color: #64748b; }
    </style>
</head>
<body>

<nav class="navbar sticky-top">
    <div class="container">
        <a class="navbar-brand fw-extrabold fs-2" href="#">TECHIDNA<span style="color:var(--techidna)">.</span></a>
        <div class="ms-auto d-flex align-items-center">
            <span class="badge bg-light text-dark border me-2">EAN-Driven Middleware</span>
            <?php if($isAdmin): ?> <span class="badge bg-danger rounded-pill px-3 shadow-sm">ADMIN MODE</span> <?php endif; ?>
        </div>
    </div>
</nav>

<header class="hero-gradient text-center">
    <div class="container text-white">
        <h1 class="display-3 fw-extrabold mb-3 text-white">Techidna® Brand Hub</h1>
        <p class="lead opacity-75 fs-4 text-white">Real-time assortiment beheer via intelligente EAN-mapping.</p>
    </div>
</header>

<div class="container my-5">
    <div class="row g-4">
        <?php foreach($store['products'] as $item): 
            $details = getProductDetails($item['ean']);
            $finalUrl = getAffiliateLink($details['url'], $partnerId);
        ?>
        <div class="col-md-6 col-lg-4">
            <div class="card product-card p-4 shadow-sm">
                <div class="d-flex justify-content-between mb-3">
                    <span class="api-badge text-uppercase">EAN: <?php echo $item['ean']; ?></span>
                    <span class="api-badge text-success">● API CONNECTED</span>
                </div>
                
                <img src="<?php echo $details['image']; ?>" 
                     class="rounded-4 mb-4 shadow-sm" 
                     style="height:220px; object-fit:contain;"
                     onerror="this.onerror=null;this.src='<?php echo $details['fallback']; ?>';">
                
                <h4 class="fw-bold mb-2 text-dark"><?php echo $details['title']; ?></h4>
                
                <div class="price-tag mb-3 mt-1">
                    € <?php echo $details['price']; ?>
                </div>

                <div class="p-3 bg-light rounded-4 border mb-4 mt-auto">
                    <div class="d-flex justify-content-between small fw-bold mb-1">
                        <span>Beschikbaarheid:</span>
                        <span class="<?php echo ($details['stock'] < 5) ? 'text-danger' : 'text-success'; ?>">
                            <?php echo $details['stock']; ?> op voorraad
                        </span>
                    </div>
                    <div class="stock-meter">
                        <div class="stock-fill" style="width: <?php echo ($details['stock'] * 6.6); ?>%; <?php echo ($details['stock'] < 5) ? 'background:red;' : ''; ?>"></div>
                    </div>
                    <div class="text-center mt-2">
                        <small class="text-muted" style="font-size: 0.6rem;">LAST SYNC: <?php echo $details['sync_id']; ?> | <?php echo $details['timestamp']; ?></small>
                    </div>
                </div>

                <a href="<?php echo $finalUrl; ?>" target="_blank" class="btn-bol">Bestel via Bol.com</a>

                <?php if($isAdmin): ?>
                    <div class="mt-3 pt-2 border-top text-center">
                        <a href="https://github.com/mlozeman-creator/techidna-partner-hub/edit/main/data/products.json" class="text-danger small fw-bold text-decoration-none">⚙️ DATA BEHEREN</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<footer class="py-5 bg-dark text-white text-center">
    <div class="container text-white">
        <p class="fw-bold mb-1 text-white">TECHIDNA PARTNER PORTAL - MARK LOZEMAN</p>
        <p class="text-muted small">Architecture: Headless JSON | Logic: PHP Middleware</p>
    </div>
</footer>

</body>
</html>
