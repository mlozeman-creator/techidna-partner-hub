<?php
/**
 * TECHIDNA® PARTNER HUB - V5.7 WINDESHEIM EDITION
 * Inclusief routering voor Home, Producten, Over, FAQ en Contact
 */

// --- 1. CONFIGURATIE & AUTH ---
$jsonPath = __DIR__ . '/../data/products.json';
$raw = @file_get_contents($jsonPath);
$store = json_decode($raw, true);

$adminSecret = trim(getenv('ADMIN_PASSWORD') ?: 'admin123');
$partnerId = getenv('BOL_PARTNER_ID') ?: '1234567';

// Routering: welke pagina moeten we tonen?
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$isAdmin = (isset($_REQUEST['role']) && $_REQUEST['role'] === 'admin' && isset($_REQUEST['pass']) && $_REQUEST['pass'] === $adminSecret);

// --- 2. PRODUCT DATA ---
function getProductDetails($ean) {
    $catalog = [
        "8721325324467" => ["title" => "Techidna® Premium - Kapton Tape - 3 mm", "image" => "https://media.s-bol.com/RNO2Zw2X5wJw/wjNr35J/550x550.jpg", "price" => 4.99, "url" => "https://www.bol.com/nl/nl/p/9300000247123648/"],
        "8721325324559" => ["title" => "Techidna® Premium - Pasjeshouder Mini - Zwart", "image" => "https://media.s-bol.com/m5p6B180WpE3/WnVpOJx/550x550.jpg", "price" => 12.95, "url" => "https://www.bol.com/nl/nl/p/9300000253717739/"],
        "8721325324009" => ["title" => "Techidna® Premium - Kabel Organiser Case", "image" => "https://media.s-bol.com/RzmlmKW21OLz/G5nM6P5/550x545.jpg", "price" => 11.99, "url" => "https://www.bol.com/nl/nl/p/9300000257047329/"],
        "8721325324085" => ["title" => "Techidna® Premium - Documentenmap A4 - Bruin", "image" => "https://media.s-bol.com/YLlVGQxvkYJM/Z4vKLL2/550x396.jpg", "price" => 19.95, "url" => "https://www.bol.com/nl/nl/p/9300000237445292/"],
        "8721325324542" => ["title" => "Techidna® Premium - Wireless Mic Pro Set", "image" => "https://media.s-bol.com/yggrkkGE09nw/qjVrNVG/550x550.jpg", "price" => 14.99, "url" => "https://www.bol.com/nl/nl/p/9300000236951588/"],
        "8721325324610" => ["title" => "Techidna® Premium - Ergonomische Muismat", "image" => "https://media.s-bol.com/JBP9xyAmr3mv/qjE1qG0/550x598.jpg", "price" => 19.95, "url" => "https://www.bol.com/nl/nl/p/9300000269418990/"],
        "8721325324498" => ["title" => "Techidna® Premium - Perzisch Tapijt Muismat", "image" => "https://media.s-bol.com/n16DP3gD3YlR/g5jy3qj/550x550.jpg", "price" => 12.50, "url" => "https://www.bol.com/nl/nl/p/9300000249510020/"],
        "8721325324221" => ["title" => "Techidna® Premium - Kabel Tape Pro - Zwart", "image" => "https://media.s-bol.com/v07285qzPJx5/AnODK67/550x550.jpg", "price" => 13.95, "url" => "https://www.bol.com/nl/nl/p/9300000241270454/"],
        "8721325324078" => ["title" => "Techidna® Premium - Kapton Tape - 25mm", "image" => "https://media.s-bol.com/BZ5y3zqoVlO2/r0nlmW2/550x686.jpg", "price" => 12.95, "url" => "https://www.bol.com/nl/nl/p/9300000238449004/"],
        "8721325324016" => ["title" => "Techidna® Premium - Teflon Tape Pro", "image" => "https://media.s-bol.com/4Zwgxlw8zqV6/nZJQBjY/550x550.jpg", "price" => 9.95, "url" => "https://www.bol.com/nl/nl/p/9300000241265911/"]
    ];
    return $catalog[$ean] ?? null;
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Techidna® | <?php echo ucfirst($page); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        :root { --bol: #004899; --techidna: #00d1b2; --dark: #0f172a; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f8fafc; }
        .navbar { background: white; border-bottom: 2px solid var(--techidna); padding: 1rem 0; }
        .nav-link { font-weight: 600; color: var(--dark); }
        .nav-link.active { color: var(--techidna) !important; }
        .hero { background: var(--dark); color: white; padding: 80px 0; border-radius: 0 0 50px 50px; text-align: center; }
        .admin-bar { background: #ff4757; color: white; padding: 8px; text-align: center; font-size: 0.8rem; }
        .product-card { border-radius: 20px; border: 1px solid #eee; transition: 0.3s; height: 100%; display: flex; flex-direction: column; }
        .product-card:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        footer { background: white; border-top: 1px solid #eee; padding: 40px 0; margin-top: 60px; }
    </style>
</head>
<body>

<?php if($isAdmin): ?>
    <div class="admin-bar">🔒 SECURE ADMIN MODE ACTIVE | <a href="index.php" class="text-white">Exit</a></div>
<?php endif; ?>

<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <a class="navbar-brand fw-800 fs-3" href="index.php">TECHIDNA<span style="color:var(--techidna)">.</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link <?php echo $page=='home'?'active':''; ?>" href="index.php?page=home">Home</a></li>
                <li class="nav-item"><a class="nav-link <?php echo $page=='producten'?'active':''; ?>" href="index.php?page=producten">Producten</a></li>
                <li class="nav-item"><a class="nav-link <?php echo $page=='over'?'active':''; ?>" href="index.php?page=over">Over Techidna</a></li>
                <li class="nav-item"><a class="nav-link <?php echo $page=='faq'?'active':''; ?>" href="index.php?page=faq">FAQ</a></li>
                <li class="nav-item"><a class="nav-link <?php echo $page=='contact'?'active':''; ?>" href="index.php?page=contact">Contact</a></li>
            </ul>
        </div>
    </div>
</nav>

<?php if($page == 'home'): ?>
    <header class="hero">
        <div class="container">
            <h1 class="display-3 fw-800 mb-3">Premium Tech Essentials.</h1>
            <p class="lead opacity-75 fs-4 mb-4">Wij bouwen de brug tussen kwaliteit en jouw werkplek.</p>
            <a href="index.php?page=producten" class="btn btn-lg rounded-pill px-5" style="background:var(--techidna); color:white; font-weight:700;">Bekijk Assortiment</a>
        </div>
    </header>
    <section class="container py-5 text-center">
        <div class="row py-5">
            <div class="col-md-4"><h3>Focus</h3><p class="text-muted">Geen afleiding, alleen de beste tools.</p></div>
            <div class="col-md-4"><h3>Vertrouwen</h3><p class="text-muted">Geleverd via het vertrouwde bol.com netwerk.</p></div>
            <div class="col-md-4"><h3>Kwaliteit</h3><p class="text-muted">Premium materialen voor langdurig gebruik.</p></div>
        </div>
    </section>

<?php elseif($page == 'producten'): ?>
    <div class="container mt-5">
        <h2 class="fw-800 mb-4 text-center">Onze Producten</h2>
        <div class="row g-4">
            <?php foreach($store['products'] as $item): 
                $details = getProductDetails($item['ean']);
                if(!$details) continue;
            ?>
            <div class="col-md-4">
                <div class="card product-card p-4">
                    <img src="<?php echo $details['image']; ?>" class="img-fluid mb-3" style="height:200px; object-fit:contain;">
                    <h5 class="fw-bold"><?php echo $details['title']; ?></h5>
                    <p class="fs-4 fw-800 mt-2">€ <?php echo number_format($details['price'], 2, ',', '.'); ?></p>
                    <a href="<?php echo $details['url']; ?>" target="_blank" class="btn w-100 rounded-pill py-3 mt-auto" style="background:var(--bol); color:white; font-weight:700;">Bekijk op bol.com</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

<?php elseif($page == 'over'): ?>
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h2 class="fw-800 mb-4">Het Verhaal achter Techidna</h2>
                <p class="lead">Techidna is ontstaan vanuit een passie voor efficiëntie en design op de werkvloer.</p>
                <p>Als onderdeel van Easy Computershop richten wij ons op het cureren van producten die jouw dagelijkse workflow verbeteren. Of het nu gaat om kabelmanagement of ergonomische tools, wij kiezen alleen voor het beste.</p>
            </div>
            <div class="col-md-6 text-center">
                <div class="p-5 bg-light rounded-5 border">Logo / Brand Image</div>
            </div>
        </div>
    </div>

<?php elseif($page == 'faq'): ?>
    <div class="container py-5">
        <h2 class="fw-800 mb-5 text-center">Veelgestelde Vragen</h2>
        <div class="accordion accordion-flush mx-auto" style="max-width:800px;" id="faqAcc">
            <div class="accordion-item border-bottom py-3">
                <h2 class="accordion-header"><button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#q1">Waarom bestel ik via bol.com?</button></h2>
                <div id="q1" class="accordion-collapse collapse" data-bs-parent="#faqAcc"><div class="accordion-body">Bol.com is onze logistieke partner. Dit garandeert een snelle levering en betrouwbare klantenservice.</div></div>
            </div>
            <div class="accordion-item border-bottom py-3">
                <h2 class="accordion-header"><button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#q2">Hoe zit het met garantie?</button></h2>
                <div id="q2" class="accordion-collapse collapse" data-bs-parent="#faqAcc"><div class="accordion-body">Op alle Techidna producten geldt de standaard wettelijke garantie. De afhandeling verloopt soepel via jouw bol.com account.</div></div>
            </div>
        </div>
    </div>

<?php elseif($page == 'contact'): ?>
    <div class="container py-5 text-center">
        <h2 class="fw-800 mb-4">Neem Contact Op</h2>
        <p class="mb-5">Vragen over onze producten? Wij helpen je graag verder.</p>
        <div class="card p-5 border-0 shadow-sm mx-auto" style="max-width:600px; border-radius:30px;">
            <p class="fs-5 fw-bold mb-1">Techidna Customer Support</p>
            <p class="text-muted mb-4">Via Easy Computershop</p>
            <a href="mailto:info@techidna.nl" class="btn btn-lg rounded-pill px-5" style="background:var(--techidna); color:white;">Stuur een E-mail</a>
        </div>
    </div>
<?php endif; ?>

<footer class="text-center">
    <div class="container">
        <p class="mb-1 fw-bold">Techidna® Brand Experience</p>
        <p class="text-muted small">Mark Lozeman &bull; Windesheim s1220834</p>
        <div class="mt-3">
            <span class="badge rounded-pill bg-light text-dark border px-3 py-2">Versie 5.7 - Flat-file Architecture</span>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
