<?php
/**
 * TECHIDNA® PARTNER HUB - V5.1
 * Gecureerde catalogus met Admin-functies en JS-filters
 */

// --- 1. DATA & CONFIGURATIE ---
$jsonPath = __DIR__ . '/../data/products.json';
$raw = @file_get_contents($jsonPath);
$store = json_decode($raw, true);

// Beveiliging: IDs via Environment Variables of fallback uit JSON
$partnerId = getenv('BOL_PARTNER_ID') ?: ($store['config']['partner_id'] ?? '1234567');
$apiReady = getenv('BOL_CLIENT_ID') ? true : false;
$isAdmin = (isset($_GET['role']) && $_GET['role'] === 'admin');

// --- 2. DE GECUREERDE CATALOGUS (Premium Mapping) ---
function getProductDetails($ean) {
    $catalog = [
        "8721325324467" => ["title" => "Techidna® Premium - Kapton Tape - 3 mm", "image" => "https://media.s-bol.com/RNO2Zw2X5wJw/wjNr35J/550x550.jpg", "price" => 4.99, "url" => "https://www.bol.com/nl/nl/p/kapton-tape-polyimide-tape-3-mm-x-33-m-hittebestendig-voor-elektronica-3d-printen/9300000247123648/"],
        "8721325324559" => ["title" => "Techidna® Premium - Pasjeshouder Mini - Zwart", "image" => "https://media.s-bol.com/m5p6B180WpE3/WnVpOJx/550x550.jpg", "price" => 12.95, "url" => "https://www.bol.com/nl/nl/p/techidna-mini-portemonnee-pasjeshouder-sleuteltasje-zwart-vegan-leer-met-rits/9300000253717739/"],
        "8721325324009" => ["title" => "Techidna® Premium - Kabel Organiser Case", "image" => "https://media.s-bol.com/RzmlmKW21OLz/G5nM6P5/550x545.jpg", "price" => 11.99, "url" => "https://www.bol.com/nl/nl/p/techidna-kabel-organiser-tas-zwart-compact-design-waterafstotend-geschikt-voor-elektronische-accessoires/9300000257047329/"],
        "8721325324085" => ["title" => "Techidna® Premium - Documentenmap A4 - Bruin", "image" => "https://media.s-bol.com/YLlVGQxvkYJM/Z4vKLL2/550x396.jpg", "price" => 19.95, "url" => "https://www.bol.com/nl/nl/p/techidna-documentenmap-a4-veganleer-magneetsluiting-bruin/9300000237445292/"],
        "8721325324542" => ["title" => "Techidna® Premium - Wireless Mic Pro Set", "image" => "https://media.s-bol.com/yggrkkGE09nw/qjVrNVG/550x550.jpg", "price" => 14.99, "url" => "https://www.bol.com/nl/nl/p/techidna-draadloze-usb-microfoon-2-microfoons-usb-c-ontvanger-voor-smartphones-tablets-laptops-plug-play-vlogs-interviews-opnames/9300000236951588/"],
        "8721325324610" => ["title" => "Techidna® Premium - Ergonomische Muismat", "image" => "https://media.s-bol.com/JBP9xyAmr3mv/qjE1qG0/550x598.jpg", "price" => 19.95, "url" => "https://www.bol.com/nl/nl/p/techidna-ergonomische-muismat-met-polssteun-paars-gelkussen-antislip-compact/9300000269418990/"],
        "8721325324498" => ["title" => "Techidna® Premium - Perzisch Tapijt Muismat", "image" => "https://media.s-bol.com/n16DP3gD3YlR/g5jy3qj/550x550.jpg", "price" => 12.50, "url" => "https://www.bol.com/nl/nl/p/perzisch-tapijt-muismat-25x18-cm-anti-slip-rubber-onderkant-warm-rood/9300000249510020/"],
        "8721325324221" => ["title" => "Techidna® Premium - Kabel Tape Pro - Zwart", "image" => "https://media.s-bol.com/v07285qzPJx5/AnODK67/550x550.jpg", "price" => 13.95, "url" => "https://www.bol.com/nl/nl/p/techidna-kabel-tape-25mm-x-15m-zwarte-isolatietape-textieltape-waterproof-hittebestendig-voor-kabelbundels-auto-elektronica-hockeysticks-rackets/9300000241270454/"],
        "8721325324078" => ["title" => "Techidna® Premium - Kapton Tape - 25mm", "image" => "https://media.s-bol.com/BZ5y3zqoVlO2/r0nlmW2/550x686.jpg", "price" => 12.95, "url" => "https://www.bol.com/nl/nl/p/techidna-hittebestendige-kapton-tape-25mm-x-33m-polyimide-tape-voor-3d-printer-sublimatie-solderen-isolatie/9300000238449004/"],
        "8721325324016" => ["title" => "Techidna® Premium - Teflon Tape Pro", "image" => "https://media.s-bol.com/4Zwgxlw8zqV6/nZJQBjY/550x550.jpg", "price" => 9.95, "url" => "https://www.bol.com/nl/nl/p/techidna-teflon-tape-2-rollen-20-meter-totaal-12mm-x-0-075mm-voor-water-gas-lucht-sanitair/9300000241265911/"]
    ];
    return $catalog[$ean] ?? null;
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
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        :root { --bol: #004899; --techidna: #00d1b2; --dark: #0f172a; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f8fafc; }
        .admin-bar { background: #1e293b; color: white; padding: 10px 0; font-size: 0.85rem; text-align: center; border-bottom: 2px solid #ff4757; }
        .navbar { background: white; border-bottom: 2px solid var(--techidna); padding: 1rem 0; }
        .hero { background: var(--dark); color: white; padding: 70px 0; border-radius: 0 0 50px 50px; text-align: center; }
        .product-card { border: none; border-radius: 24px; transition: 0.4s; background: white; height: 100%; border: 1px solid #e2e8f0; display: flex; flex-direction: column; overflow: hidden; }
        .product-card:hover { transform: translateY(-10px); box-shadow: 0 20px 40px rgba(0,0,0,0.06); }
        .btn-bol { background: var(--bol); color: white; border-radius: 50px; font-weight: 700; padding: 14px; text-decoration: none; display: block; text-align: center; transition: 0.3s; }
        .btn-bol:hover { background: #003366; color: white; transform: scale(1.02); }
        .status-dot { height: 10px; width: 10px; border-radius: 50%; display: inline-block; margin-right: 8px; }
    </style>
</head>
<body>

<?php if($isAdmin): ?>
    <div class="admin-bar shadow-sm">
        <span class="status-dot <?php echo $apiReady ? 'bg-success' : 'bg-warning'; ?>"></span>
        API STATUS: <?php echo $apiReady ? 'CONNECTED' : 'STANDBY (MANUAL MODE)'; ?> | 
        <a href="https://github.com/mlozeman-creator/techidna-partner-hub/edit/main/data/products.json" target="_blank" class="text-white text-decoration-underline ms-2">Edit Data</a>
    </div>
<?php endif; ?>

<nav class="navbar sticky-top">
    <div class="container d-flex justify-content-between align-items-center">
        <a href="https://techidna-partner-hub.vercel.app/" class="fw-800 fs-2 text-decoration-none text-dark">
            TECHIDNA<span style="color:var(--techidna)">.</span>
        </a>
        <div>
            <?php if(!$isAdmin): ?>
                <a href="?role=admin" class="btn btn-sm btn-outline-secondary rounded-pill px-3">Admin</a>
            <?php else: ?>
                <a href="index.php" class="btn btn-sm btn-danger rounded-pill px-3">Exit Admin</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<header class="hero">
    <div class="container">
        <h1 class="display-3 fw-800 mb-3">Premium Solutions.</h1>
        <p class="lead opacity-75 fs-4">Ontdek ons exclusieve assortiment.</p>
    </div>
</header>

<main class="container mt-5">
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
            $finalUrl = getAffiliateLink($details['url'], $partnerId);
        ?>
        <div class="col-md-6 col-lg-4 product-item" data-title="<?php echo strtolower($details['title']); ?>" data-price="<?php echo $details['price']; ?>">
            <div class="card product-card p-4">
                <div class="text-center mb-4">
                    <img src="<?php echo $details['image']; ?>" style="height:200px; width:100%; object-fit:contain;">
                </div>
                <h5 class="fw-bold mb-3" style="min-height: 2.5em;"><?php echo $details['title']; ?></h5>
                <?php if($isAdmin): ?> <small class="text-muted d-block mb-2">EAN: <?php echo $item['ean']; ?></small> <?php endif; ?>
                <div class="fs-3 fw-800 text-dark mb-4">€ <?php echo number_format($details['price'], 2, ',', '.'); ?></div>
                <div class="mt-auto">
                    <a href="<?php echo $finalUrl; ?>" target="_blank" class="btn-bol">Bestel bij Bol.com</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</main>

<footer class="py-5 mt-5 text-center text-muted bg-white border-top">
    <p class="mb-1 fw-600 text-dark">Techidna® Brand Experience &bull; Mark Lozeman</p>
    <small>Versie 5.0 Premium - API-Ready Architecture</small>
</footer>

<script>
    const searchInput = document.getElementById('searchInput');
    const sortSelect = document.getElementById('sortSelect');
    const grid = document.getElementById('productGrid');
    const items = Array.from(document.getElementsByClassName('product-item'));

    function update() {
        const query = searchInput.value.toLowerCase();
        const sort = sortSelect.value;
        items.forEach(el => el.style.display = el.getAttribute('data-title').includes(query) ? 'block' : 'none');
        const visible = items.filter(el => el.style.display !== 'none');
        if (sort === 'low') visible.sort((a,b) => a.getAttribute('data-price') - b.getAttribute('data-price'));
        if (sort === 'high') visible.sort((a,b) => b.getAttribute('data-price') - a.getAttribute('data-price'));
        visible.forEach(el => grid.appendChild(el));
    }

    searchInput.addEventListener('input', update);
    sortSelect.addEventListener('change', update);
</script>

</body>
</html>
