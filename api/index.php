<?php
/**
 * TECHIDNA® PARTNER HUB - V5.8 FINAL MASTER
 * Integratie van alle Windesheim pagina's + Sorteer/Filter functionaliteit
 */

// --- 1. CONFIGURATIE ---
$jsonPath = __DIR__ . '/../data/products.json';
$raw = @file_get_contents($jsonPath);
$store = json_decode($raw, true);

$adminSecret = trim(getenv('ADMIN_PASSWORD') ?: 'admin123');
$partnerId = getenv('BOL_PARTNER_ID') ?: '1234567';

$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$isAdmin = (isset($_REQUEST['role']) && $_REQUEST['role'] === 'admin' && isset($_REQUEST['pass']) && $_REQUEST['pass'] === $adminSecret);

// --- 2. DATA MAPPING LAYER ---
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
        .admin-bar { background: #ff4757; color: white; padding: 8px; text-align: center; font-size: 0.8rem; position: sticky; top:0; z-index: 10000; }
        .product-card { border-radius: 20px; border: 1px solid #eee; transition: 0.3s; height: 100%; display: flex; flex-direction: column; background: white; }
        .product-card:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        footer { background: white; border-top: 1px solid #eee; padding: 40px 0; margin-top: 60px; }
    </style>
</head>
<body>

<?php if($isAdmin): ?>
    <div class="admin-bar">🔒 SECURE ADMIN MODE ACTIVE | <a href="index.php" class="text-white text-decoration-underline">Exit Admin</a></div>
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
            <h1 class="display-3 fw-800 mb-3 text-white">Premium Tech Essentials.</h1>
            <p class="lead opacity-75 fs-4 mb-4">Focus, Kwaliteit en Vertrouwen in elke werkplek.</p>
            <a href="index.php?page=producten" class="btn btn-lg rounded-pill px-5" style="background:var(--techidna); color:white; font-weight:700;">Bekijk Assortiment</a>
        </div>
    </header>
    <div class="container py-5 mt-4 text-center">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="p-4">
                    <h3 class="fw-bold">100% Focus</h3>
                    <p class="text-muted">Onze producten zijn ontworpen om afleiding te elimineren.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4">
                    <h3 class="fw-bold">Bol.com Partner</h3>
                    <p class="text-muted">Veilig en vertrouwd bestellen via het grootste platform.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4">
                    <h3 class="fw-bold">Premium Design</h3>
                    <p class="text-muted">Duurzame materialen met een moderne uitstraling.</p>
                </div>
            </div>
        </div>
    </div>

<?php elseif($page == 'producten'): ?>
    <div class="container mt-5">
        <h2 class="fw-800 mb-4 text-center">Onze Catalogus</h2>
        
        <div class="row mb-5 g-3 justify-content-center">
            <div class="col-md-5">
                <input type="text" id="searchInput" class="form-control form-control-lg shadow-sm border-0 rounded-pill px-4" placeholder="Zoek een artikel...">
            </div>
            <div class="col-md-3">
                <select id="sortSelect" class="form-select form-select-lg shadow-sm border-0 rounded-pill px-4">
                    <option value="default">Sorteer op prijs</option>
                    <option value="low">Laag naar Hoog</option>
                    <option value="high">Hoog naar Laag</option>
                </select>
            </div>
        </div>

        <div class="row g-4" id="productGrid">
            <?php foreach($store['products'] as $item): 
                $details = getProductDetails($item['ean']);
                if(!$details) continue;
            ?>
            <div class="col-md-6 col-lg-4 product-item" data-title="<?php echo strtolower($details['title']); ?>" data-price="<?php echo $details['price']; ?>">
                <div class="card product-card p-4">
                    <div class="text-center mb-4">
                        <img src="<?php echo $details['image']; ?>" style="height:180px; object-fit:contain;">
                    </div>
                    <h5 class="fw-bold mb-3" style="min-height: 2.5em;"><?php echo $details['title']; ?></h5>
                    <?php if($isAdmin): ?> <small class="text-muted d-block mb-2">EAN: <?php echo $item['ean']; ?></small> <?php endif; ?>
                    <div class="fs-4 fw-800 text-dark mb-4">€ <?php echo number_format($details['price'], 2, ',', '.'); ?></div>
                    <div class="mt-auto">
                        <a href="<?php echo $details['url']; ?>" target="_blank" class="btn w-100 rounded-pill py-3" style="background:var(--bol); color:white; font-weight:700;">Bekijk op bol.com</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

<?php elseif($page == 'over'): ?>
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h2 class="fw-800 mb-4">Over Techidna®</h2>
                <p class="lead">Wij geloven dat een opgeruimde werkplek leidt tot een scherpere focus.</p>
                <p>Techidna is een merknaam van Easy Computershop. Wij cureren een specifiek assortiment van kantoorartikelen en technische hulpmiddelen die uitblinken in eenvoud en kwaliteit.</p>
            </div>
            <div class="col-md-6"><div class="p-5 bg-light rounded-5 border text-center text-muted">BRAND STORY IMAGE</div></div>
        </div>
    </div>

<?php elseif($page == 'faq'): ?>
    <div class="container py-5">
        <h2 class="fw-800 mb-5 text-center">Veelgestelde Vragen</h2>
        <div class="accordion accordion-flush mx-auto shadow-sm rounded-4 overflow-hidden" style="max-width:800px;" id="faqAcc">
            <div class="accordion-item">
                <h2 class="accordion-header"><button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#q1">Verkopen jullie direct vanaf deze site?</button></h2>
                <div id="q1" class="accordion-collapse collapse" data-bs-parent="#faqAcc"><div class="accordion-body text-muted">Nee, wij zijn een informatieve merkwebsite. Voor de veiligheid en logistiek verwijzen we je door naar onze officiële partner bol.com.</div></div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header"><button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#q2">Hoe zit het met de garantie?</button></h2>
                <div id="q2" class="accordion-collapse collapse" data-bs-parent="#faqAcc"><div class="accordion-body text-muted">Op alle artikelen geldt de volledige fabrieksgarantie. Bij aankoop via bol.com geniet je bovendien van hun uitstekende retourvoorwaarden.</div></div>
            </div>
        </div>
    </div>

<?php elseif($page == 'contact'): ?>
    <div class="container py-5 text-center">
        <h2 class="fw-800 mb-4">Contact</h2>
        <div class="card p-5 border-0 shadow-sm mx-auto rounded-5" style="max-width:600px;">
            <h5>Heeft u vragen over een product?</h5>
            <p class="text-muted">Techidna is onderdeel van Easy Computershop.</p>
            <a href="mailto:info@techidna.nl" class="btn btn-lg rounded-pill px-5 mt-3" style="background:var(--techidna); color:white; font-weight:700;">Stuur een e-mail</a>
        </div>
    </div>
<?php endif; ?>

<footer class="text-center">
    <div class="container">
        <p class="mb-1 fw-800">Techidna® Brand Experience</p>
        <p class="text-muted small">Mark Lozeman &bull; Windesheim s1220834</p>
        <div class="mt-4"><span class="badge rounded-pill bg-light text-dark border px-3 py-2">Versie 5.8 - Enterprise & Windesheim Edition</span></div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // DE SORTEER- EN FILTERLOGICA (Alleen op de productenpagina)
    const searchInput = document.getElementById('searchInput');
    const sortSelect = document.getElementById('sortSelect');
    const grid = document.getElementById('productGrid');
    
    if(grid) {
        const items = Array.from(document.getElementsByClassName('product-item'));

        function update() {
            const query = searchInput.value.toLowerCase();
            const sort = sortSelect.value;
            
            items.forEach(el => {
                const title = el.getAttribute('data-title');
                el.style.display = title.includes(query) ? 'block' : 'none';
            });

            const visible = items.filter(el => el.style.display !== 'none');
            
            if (sort === 'low') {
                visible.sort((a,b) => a.getAttribute('data-price') - b.getAttribute('data-price'));
            } else if (sort === 'high') {
                visible.sort((a,b) => b.getAttribute('data-price') - a.getAttribute('data-price'));
            }

            visible.forEach(el => grid.appendChild(el));
        }

        searchInput.addEventListener('input', update);
        sortSelect.addEventListener('change', update);
    }
</script>
</body>
</html>
