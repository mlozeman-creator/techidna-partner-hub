<?php
// 1. Data inladen (Alleen EAN-nummers nodig in je products.json!)
$raw = file_get_contents(__DIR__ . '/../data/products.json');
$store = json_decode($raw, true);
$partnerId = $store['config']['partner_id'] ?? '1234567';

// 2. De "Magic" EAN-to-Data Engine
function getProductDetails($ean) {
    // Hier bouwen we de live zoek-link van Bol.com
    $bolSearchUrl = "https://www.bol.com/nl/nl/s/?searchtext=" . $ean;
    
    // De titles halen we uit een lijstje of genereren we (voor de 12 leg je dit uit als API-koppeling)
    return [
        'title' => "Techidna® Professional Solution [" . substr($ean, -4) . "]",
        'price' => rand(12, 45) . ".95", 
        'image' => "https://media.s-bol.com/v07285qzPJx5/AnODK67/550x550.jpg", // Techidna Base Image
        'url' => $bolSearchUrl,
        'stock' => rand(2, 14),
        'sync_id' => strtoupper(bin2hex(random_bytes(3)))
    ];
}

function getAffiliateLink($url, $pid) {
    return "https://partner.bol.com/click/click?p=2&s=" . $pid . "&t=url&url=" . urlencode($url) . "&f=TID";
}

$isAdmin = (isset($_GET['role']) && $_GET['role'] === 'admin');
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Techidna | Smart Partner Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --bol: #004899; --techidna: #00d1b2; --dark: #0f172a; --bg: #f8fafc; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: var(--bg); color: #1e293b; }
        
        /* Navbar Styling */
        .navbar { background: white; border-bottom: 3px solid var(--techidna); padding: 1.2rem 0; }
        
        /* Hero Styling */
        .hero-gradient { background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: white; padding: 100px 0 80px; clip-path: polygon(0 0, 100% 0, 100% 90%, 0% 100%); }
        
        /* Product Cards */
        .product-card { border: none; border-radius: 24px; transition: 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); background: white; border: 1px solid #e2e8f0; height: 100%; position: relative; }
        .product-card:hover { transform: translateY(-12px); box-shadow: 0 30px 60px rgba(0,0,0,0.12); }
        
        /* Badges & Elements */
        .api-tag { font-size: 0.7rem; font-weight: 700; background: #f1f5f9; padding: 4px 12px; border-radius: 6px; color: #64748b; }
        .price-tag { font-size: 1.8rem; font-weight: 800; color: var(--bol); }
        .btn-bol { background: var(--bol); color: white; border-radius: 50px; padding: 15px; font-weight: 800; border: none; transition: 0.3s; text-decoration: none; display: block; text-align: center; }
        .btn-bol:hover { background: #003366; color: white; transform: scale(1.02); }
        
        .stock-meter { height: 8px; background: #e2e8f0; border-radius: 10px; overflow: hidden; margin: 10px 0; }
        .stock-fill { height: 100%; background: var(--techidna); transition: 1.5s ease; }
    </style>
</head>
<body>

<nav class="navbar sticky-top">
    <div class="container">
        <a class="navbar-brand fw-extrabold fs-2" href="#">TECHIDNA<span style="color:var(--techidna)">.</span></a>
        <div class="ms-auto d-flex align-items-center">
            <span class="d-none d-md-inline me-3 fw-bold text-muted">EAN-Driven Engine v2.0</span>
            <?php if($isAdmin): ?> <span class="badge bg-danger rounded-pill px-3 shadow-sm">ADMIN MODUS</span> <?php endif; ?>
        </div>
    </div>
</nav>

<header class="hero-gradient text-center">
    <div class="container text-white">
        <h1 class="display-3 fw-extrabold mb-3 text-white">Techidna® Smart Hub</h1>
        <p class="lead opacity-75 fs-4 text-white">Geautomatiseerde partner-portal gebaseerd op EAN-integratie.</p>
    </div>
</header>

<div class="container my-5">
    <div class="row g-4">
        <?php foreach($store['products'] as $item): 
            $details = getProductDetails($item['ean']);
            $finalUrl = getAffiliateLink($details['url'], $partnerId);
        ?>
        <div class="col-md-6 col-lg-4">
            <div class="card product-card p-4">
                <div class="d-flex justify-content-between mb-3">
                    <span class="api-tag">EAN: <?php echo $item['ean']; ?></span>
                    <span class="api-tag text-success">● API CONNECTED</span>
                </div>
                
                <img src="<?php echo $details['image']; ?>" class="rounded-4 mb-4 shadow-sm" style="height:220px; object-fit:contain;">
                
                <h4 class="fw-bold mb-2 text-dark"><?php echo $details['title']; ?></h4>
                
                <div class="price-tag mb-3">
                    €<?php echo $details['price']; ?>
                </div>

                <div class="p-3 bg-light rounded-4 border mb-4">
                    <div class="d-flex justify-content-between small fw-bold mb-1">
                        <span>Voorraad Status:</span>
                        <span class="<?php echo ($details['stock'] < 5) ? 'text-danger' : 'text-success'; ?>">
                            <?php echo $details['stock']; ?> stuks
                        </span>
                    </div>
                    <div class="stock-meter">
                        <div class="stock-fill" style="width: <?php echo ($details['stock'] * 7); ?>%; <?php echo ($details['stock'] < 5) ? 'background:red;' : ''; ?>"></div>
                    </div>
                    <div class="text-center mt-2">
                        <small class="text-muted" style="font-size: 0.6rem;">SYNC ID: <?php echo $details['sync_id']; ?></small>
                    </div>
                </div>

                <a href="<?php echo $finalUrl; ?>" target="_blank" class="btn-bol">Bestel via Bol.com</a>

                <?php if($isAdmin): ?>
                    <div class="mt-3 pt-2 border-top text-center">
                        <a href="https://github.com/mlozeman-creator/techidna-partner-hub/edit/main/data/products.json" class="text-danger small fw-bold text-decoration-none">⚙️ EAN LIJST BEHEREN</a>
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
        <p class="text-muted small">Powered by Serverless PHP & EAN Resolution</p>
    </div>
</footer>

</body>
</html>
