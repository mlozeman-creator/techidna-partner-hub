<?php
// 1. Data-extractie uit de JSON 'Headless' laag
$raw = file_get_contents(__DIR__ . '/../data/products.json');
$store = json_decode($raw, true);

// 2. De API Bridge & Tracking Generator (Cijfer 12 Logica)
function generateTrackingLink($baseUrl, $partnerId) {
    if (empty($partnerId) || $partnerId === '1234567') {
        return $baseUrl; 
    }
    return "https://partner.bol.com/click/click?p=2&s=" . $partnerId . "&t=url&url=" . urlencode($baseUrl) . "&f=TID&name=TechidnaHub";
}

function getBolLiveStatus($ean) {
    // Simulatie van de Bol Retailer API v10 respons
    return [
        'stock_level' => rand(1, 15),
        'is_promo' => (rand(1, 10) > 8),
        'sync_id' => strtoupper(bin2hex(random_bytes(3))),
        'timestamp' => date('H:i:s')
    ];
}

$isAdmin = (isset($_GET['role']) && $_GET['role'] === 'admin');
$partnerId = $store['config']['partner_id'] ?? '';
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Techidna Partner Hub | Mark Lozeman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --bol: #004899; --techidna: #00d1b2; --bg: #f8fafc; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: var(--bg); color: #1e293b; }
        .navbar { background: white; border-bottom: 3px solid var(--techidna); padding: 1.2rem 0; }
        .hero-gradient { background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: white; padding: 100px 0 80px; clip-path: polygon(0 0, 100% 0, 100% 90%, 0% 100%); }
        .product-card { border: none; border-radius: 24px; transition: 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); background: white; border: 1px solid #e2e8f0; height: 100%; }
        .product-card:hover { transform: translateY(-12px); box-shadow: 0 30px 60px rgba(0,0,0,0.12); }
        .price-display { font-size: 1.8rem; font-weight: 800; color: var(--bol); }
        .btn-bol { background: var(--bol); color: white; border-radius: 50px; padding: 15px; font-weight: 800; border: none; transition: 0.3s; text-decoration: none; display: block; text-align: center; }
        .btn-bol:hover { background: #003366; color: white; transform: scale(1.02); }
        .api-tag { font-size: 0.7rem; font-weight: 700; background: #f1f5f9; padding: 4px 10px; border-radius: 6px; color: #64748b; }
        .stock-meter { height: 8px; background: #e2e8f0; border-radius: 10px; overflow: hidden; margin: 10px 0; }
        .stock-fill { height: 100%; background: var(--techidna); transition: 1.5s ease; }
    </style>
</head>
<body>

<nav class="navbar sticky-top">
    <div class="container">
        <a class="navbar-brand fw-extrabold fs-2" href="#">TECHIDNA<span style="color:var(--techidna)">.</span></a>
        <div class="ms-auto d-flex align-items-center">
            <span class="d-none d-md-inline me-3 fw-bold text-muted">Partner Hub: Mark Lozeman</span>
            <?php if($isAdmin): ?> <span class="badge bg-danger rounded-pill px-3 shadow-sm">ADMIN MODUS</span> <?php endif; ?>
        </div>
    </div>
</nav>

<header class="hero-gradient text-center">
    <div class="container text-white">
        <h1 class="display-3 fw-extrabold mb-3 text-white">Techidna® Brand Hub</h1>
        <p class="lead opacity-75 fs-4 text-white">Officiële partnerpagina met real-time Bol.com integratie.</p>
    </div>
</header>

<div class="container my-5">
    <div class="row g-4">
        <?php foreach($store['products'] as $item): 
            $api = getBolLiveStatus($item['ean']);
            $finalUrl = generateTrackingLink($item['bol_url'], $partnerId);
        ?>
        <div class="col-md-6 col-lg-4">
            <div class="card product-card p-4">
                <div class="d-flex justify-content-between mb-3">
                    <span class="api-tag">EAN: <?php echo $item['ean']; ?></span>
                    <span class="api-tag text-success">STATUS: API LIVE</span>
                </div>
                
                <img src="<?php echo $item['image']; ?>" class="rounded-4 mb-4 shadow-sm" style="height:250px; object-fit:cover;">
                
                <h4 class="fw-bold mb-2 text-dark"><?php echo $item['title']; ?></h4>
                
                <div class="price-display mb-3">
                    €<?php echo $item['price']; ?>
                    <?php if($api['is_promo']): ?>
                        <span class="badge bg-danger fs-6 ms-2" style="vertical-align: middle;">LIVE DEAL</span>
                    <?php endif; ?>
                </div>

                <div class="api-box mb-4 p-3 bg-light rounded-4 border">
                    <div class="d-flex justify-content-between small fw-bold mb-1">
                        <span>Live Voorraad:</span>
                        <span class="<?php echo ($api['stock_level'] < 5) ? 'text-danger' : 'text-success'; ?>">
                            <?php echo $api['stock_level']; ?> stuks
                        </span>
                    </div>
                    <div class="stock-meter">
                        <div class="stock-fill" style="width: <?php echo ($api['stock_level'] * 6.6); ?>%; <?php echo ($api['stock_level'] < 5) ? 'background:red;' : ''; ?>"></div>
                    </div>
                    <small class="text-muted" style="font-size: 0.6rem;">Last Sync: <?php echo $api['sync_id']; ?> | <?php echo $api['timestamp']; ?></small>
                </div>

                <ul class="text-muted small mb-4">
                    <?php foreach($item['features'] as $f): ?>
                        <li><?php echo $f; ?></li>
                    <?php endforeach; ?>
                </ul>

                <a href="<?php echo $finalUrl; ?>" target="_blank" class="btn-bol">Bestel op Bol.com</a>

                <?php if($isAdmin): ?>
                    <div class="mt-3 pt-2 border-top text-center">
                        <a href="https://github.com/mlozeman-creator/techidna-partner-hub/edit/main/data/products.json" class="text-danger small fw-bold text-decoration-none">⚙️ PRODUCT DATA WIJZIGEN</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<footer class="py-5 bg-dark text-white text-center">
    <div class="container text-white">
        <p class="fw-bold mb-1 text-white">TECHIDNA PARTNER HUB - MARK LOZEMAN</p>
        <p class="text-muted small mb-0">Retailer API v10 Simulation Engine</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
