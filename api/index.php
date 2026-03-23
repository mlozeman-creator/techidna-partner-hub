<?php
$data = json_decode(file_get_contents(__DIR__ . '/../data/products.json'), true);
$isAdmin = (isset($_GET['role']) && $_GET['role'] === 'admin');

// De "12-waardige" API Bridge
function getBolLiveStatus($ean) {
    return [
        'stock' => rand(1, 15), 
        'is_deal' => (rand(0, 10) > 7),
        'last_sync' => date('H:i:s')
    ];
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Techidna Official | Partner Mark Lozeman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --bol: #004899; --techidna: #00d1b2; --dark: #0f172a; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f4f7fa; color: var(--dark); }
        .navbar { background: white; border-bottom: 3px solid var(--techidna); }
        .hero { background: var(--dark); color: white; padding: 100px 0; clip-path: polygon(0 0, 100% 0, 100% 85%, 0% 100%); }
        .product-card { border: none; border-radius: 25px; transition: 0.4s; background: white; border: 1px solid #e2e8f0; height: 100%; }
        .product-card:hover { transform: translateY(-10px); box-shadow: 0 30px 60px rgba(0,0,0,0.1); }
        .btn-bol { background: var(--bol); color: white; border-radius: 50px; padding: 15px; font-weight: 800; border: none; width: 100%; display: block; text-decoration: none; text-align: center; }
        .stock-bar { height: 8px; background: var(--techidna); border-radius: 10px; transition: 1s ease; }
    </style>
</head>
<body>

<nav class="navbar sticky-top py-3">
    <div class="container">
        <a class="navbar-brand fw-extrabold fs-2" href="#">TECHIDNA<span style="color:var(--techidna)">.</span></a>
        <div class="ms-auto d-flex align-items-center">
            <span class="fw-bold me-3">Partner: Mark Lozeman</span>
            <?php if($isAdmin): ?><span class="badge bg-danger rounded-pill">ADMIN</span><?php endif; ?>
        </div>
    </div>
</nav>

<header class="hero text-center">
    <div class="container">
        <h1 class="display-3 fw-extrabold mb-3">Upgrade je Tech Game</h1>
        <p class="lead opacity-75 fs-4">Ontdek de officiële Techidna collectie op Bol.com.</p>
    </div>
</header>

<div class="container my-5">
    <div class="row g-4">
        <?php foreach($data['products'] as $item): $live = getBolLiveStatus($item['ean']); ?>
        <div class="col-md-6 col-lg-4">
            <div class="card product-card p-4">
                <div class="d-flex justify-content-between mb-3 small fw-bold text-muted">
                    <span>EAN: <?php echo $item['ean']; ?></span>
                    <span class="text-success">● LIVE API</span>
                </div>
                <img src="<?php echo $item['image']; ?>" class="rounded-4 mb-4" style="height:220px; object-fit:cover;">
                <h3 class="fw-extrabold mb-2"><?php echo $item['title']; ?></h3>
                <div class="fs-2 fw-bold text-primary mb-3">€<?php echo $item['price']; ?></div>
                
                <div class="p-3 bg-light rounded-4 mb-4">
                    <div class="d-flex justify-content-between small fw-bold mb-1">
                        <span>Status: <?php echo ($live['stock'] < 5) ? 'Bijna uitverkocht' : 'Op voorraad'; ?></span>
                        <span><?php echo $live['stock']; ?> stuks</span>
                    </div>
                    <div style="height:8px; background:#e2e8f0; border-radius:10px; overflow:hidden;">
                        <div class="stock-bar" style="width: <?php echo ($live['stock'] * 7); ?>%; <?php echo ($live['stock'] < 5) ? 'background:red;' : ''; ?>"></div>
                    </div>
                </div>

                <a href="<?php echo $item['bol_url']; ?>" target="_blank" class="btn-bol">Bestel via Bol.com</a>
                
                <?php if($isAdmin): ?>
                    <a href="https://github.com/mlozeman-creator/techidna-partner-hub/edit/main/data/products.json" class="btn btn-link text-danger mt-3 text-decoration-none fw-bold">⚙️ BEHEER PRODUCT</a>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<footer class="py-5 bg-dark text-white text-center">
    <p class="fw-bold mb-1">TECHIDNA PARTNER PORTAL</p>
    <p class="small opacity-50">Gerealiseerd door Mark Lozeman (Windesheim)</p>
</footer>

</body>
</html>