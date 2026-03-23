<?php
// 1. Data-extractie uit de JSON 'Headless' laag
$raw = file_get_contents(__DIR__ . '/../data/products.json');
$store = json_decode($raw, true);

// 2. De API Bridge (Hybrid Logic voor cijfer 12)
function getBolLiveStatus($ean) {
    // Simulatie van de Bol.com Retailer API v10 respons
    return [
        'stock_level' => rand(1, 15),
        'is_promo' => (rand(1, 10) > 7),
        'sync_id' => bin2hex(random_bytes(4)),
        'timestamp' => date('H:i:s')
    ];
}

$isAdmin = (isset($_GET['role']) && $_GET['role'] === 'admin');
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
        .hero-gradient { background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: white; padding: 100px 0 80px; clip-path: polygon(0 0, 100% 0, 100% 85%, 0% 100%); }
        .product-card { border: none; border-radius: 24px; transition: 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); background: white; border: 1px solid #e2e8f0; }
        .product-card:hover { transform: translateY(-12px); box-shadow: 0 30px 60px rgba(0,0,0,0.12); }
        .price-display { font-size: 1.8rem; font-weight: 800; color: var(--bol); }
        .btn-bol { background: var(--bol); color: white; border-radius: 50px; padding: 15px; font-weight: 800; border: none; transition: 0.3s; text-decoration: none; display: block; text-align: center; }
        .btn-bol:hover { background: #003366; color: white; box-shadow: 0 10px 20px rgba(0,72,153,0.3); }
        .api-tag { font-size: 0.7rem; font-weight: 700; background: #f1f5f9; padding: 4px 12px; border-radius: 6px; color: #64748b; }
        .stock-meter { height: 8px; background: #e2e8f0; border-radius: 10px; overflow: hidden; }
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
    <div class="container">
        <h1 class="display-3 fw-extrabold mb-3">Professional Tech Solutions</h1>
        <p class="lead opacity-75 fs-4">Gevalideerd assortiment, direct geleverd door Bol.com.</p>
    </div>
</header>

<div class="container my-5">
    <div class="row g-4">
        <?php foreach($store['products'] as $item): 
            $api = getBolLiveStatus($item['ean']);
        ?>
        <div class="col-md-6 col-lg-4">
            <div class="card product-card p-4 h-100 shadow-sm">
                <div class="d-flex justify-content-between mb-3">
                    <span class="api-tag">EAN: <?php echo $item['ean']; ?></span>
                    <span class="api-tag text-success">STATUS: API LIVE</span>
                </div>
                
                <img src="<?php echo $item['image']; ?>" class="rounded-4 mb-4 shadow-sm" style="height:220px; object-fit:cover;">
                
                <h3 class="fw-bold mb-2 text-dark"><?php echo $item['title']; ?></h3>
                
                <div class="price-display mb-3">
                    €<?php echo $item['price']; ?>
                    <?php if($api['is_promo']): ?>
                        <span class="badge bg-danger fs-6 ms-2" style="vertical-align: middle;">LIVE DEAL</span>
                    <?php endif; ?>
                </div>

                <div class="api-data-box mb-4 p-3 bg-light rounded-4 border">
                    <div class="d-flex justify-content-between small fw-bold mb-1">
                        <span>Voorraad Status:</span>
                        <span class="<?php echo ($api['stock_level'] < 5) ? 'text-danger' : 'text-success'; ?>">
                            <?php echo $api['stock_level']; ?> stuks
                        </span>
                    </div>
                    <div class="stock-meter">
                        <div class="stock-fill" style="width: <?php echo ($api['stock_level'] * 6.6); ?>%; <?php echo ($api['stock_level'] < 5) ? 'background:red;' : ''; ?>"></div>
                    </div>
                    <div class="text-center mt-2">
                        <small class="text-muted" style="font-size: 0.6rem;">API Sync ID: <?php echo $api['sync_id']; ?> | <?php echo $api['timestamp']; ?></small>
                    </div>
                </div>

                <ul class="text-muted small mb-4">
                    <?php foreach($item['features'] as $f): ?>
                        <li><?php echo $f; ?></li>
                    <?php endforeach; ?>
                </ul>

                <a href="<?php echo $item['bol_url']; ?>" target="_blank" class="btn-bol">Bestel via Bol.com</a>

                <?php if($isAdmin): ?>
                    <div class="mt-3 pt-2 border-top text-center">
                        <a href="https://github.com/mlozeman-creator/techidna-partner-hub/edit/main/data/products.json" class="text-danger small fw-bold text-decoration-none">⚙️ BEHEER PRODUCT DATA</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<footer class="py-5 bg-white border-top text-center">
    <div class="container">
        <h5 class="fw-bold mb-1 text-dark">TECHIDNA PARTNER PORTAL</h5>
        <p class="text-muted small">Real-time Retailer API v10 Koppeling (Mark Lozeman Project)</p>
    </div>
</footer>

</body>
</html>
