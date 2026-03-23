<?php
$jsonPath = __DIR__ . '/../data/products.json';
$raw = @file_get_contents($jsonPath);
$store = json_decode($raw, true);
$partnerId = $store['config']['partner_id'] ?? '1234567';

// BEVEILIGING: Alleen als ?role=admin in de URL staat
$isAdmin = (isset($_GET['role']) && $_GET['role'] === 'admin');

function getProductDetails($ean) {
    $catalog = [
        "8721325324467" => ["title" => "Kapton Tape / Polyimide Tape - 3 mm x 33 m", "image" => "https://media.s-bol.com/RNO2Zw2X5wJw/wjNr35J/550x550.jpg", "price" => 4.99, "url" => "https://www.bol.com/nl/nl/p/kapton-tape-polyimide-tape-3-mm-x-33-m-hittebestendig-voor-elektronica-3d-printen/9300000247123648/"],
        "8721325324559" => ["title" => "Techidna® - Mini Portemonnee - Pasjeshouder", "image" => "https://media.s-bol.com/m5p6B180WpE3/WnVpOJx/550x550.jpg", "price" => 12.95, "url" => "https://www.bol.com/nl/nl/p/techidna-mini-portemonnee-pasjeshouder-sleuteltasje-zwart-vegan-leer-met-rits/9300000253717739/"],
        "8721325324009" => ["title" => "Techidna® - Kabel organiser tas - Zwart", "image" => "https://media.s-bol.com/RzmlmKW21OLz/G5nM6P5/550x545.jpg", "price" => 11.99, "url" => "https://www.bol.com/nl/nl/p/techidna-kabel-organiser-tas-zwart-compact-design-waterafstotend-geschikt-voor-elektronische-accessoires/9300000257047329/"],
        "8721325324085" => ["title" => "Techidna® - Documentenmap A4 - Veganleer", "image" => "https://media.s-bol.com/YLlVGQxvkYJM/Z4vKLL2/550x396.jpg", "price" => 19.95, "url" => "https://www.bol.com/nl/nl/p/techidna-documentenmap-a4-veganleer-magneetsluiting-bruin/9300000237445292/"],
        "8721325324542" => ["title" => "Techidna® - Draadloze USB Microfoon Set", "image" => "https://media.s-bol.com/yggrkkGE09nw/qjVrNVG/550x550.jpg", "price" => 14.99, "url" => "https://www.bol.com/nl/nl/p/techidna-draadloze-usb-microfoon-2-microfoons-usb-c-ontvanger-voor-smartphones-tablets-laptops-plug-play-vlogs-interviews-opnames/9300000236951588/"],
        "8721325324610" => ["title" => "Techidna® - Ergonomische Muismat - Paars", "image" => "https://media.s-bol.com/JBP9xyAmr3mv/qjE1qG0/550x598.jpg", "price" => 19.95, "url" => "https://www.bol.com/nl/nl/p/techidna-ergonomische-muismat-met-polssteun-paars-gelkussen-antislip-compact/9300000269418990/"],
        "8721325324498" => ["title" => "Techidna® - Perzisch Tapijt Muismat", "image" => "https://media.s-bol.com/n16DP3gD3YlR/g5jy3qj/550x550.jpg", "price" => 12.50, "url" => "https://www.bol.com/nl/nl/p/perzisch-tapijt-muismat-25x18-cm-anti-slip-rubber-onderkant-warm-rood/9300000249510020/"],
        "8721325324221" => ["title" => "Techidna® - Kabel Tape 25mm x 15m - Zwart", "image" => "https://media.s-bol.com/v07285qzPJx5/AnODK67/550x550.jpg", "price" => 13.95, "url" => "https://www.bol.com/nl/nl/p/techidna-kabel-tape-25mm-x-15m-zwarte-isolatietape-textieltape-waterproof-hittebestendig-voor-kabelbundels-auto-elektronica-hockeysticks-rackets/9300000241270454/"],
        "8721325324078" => ["title" => "Techidna® - Kapton Tape - 25mm x 33m", "image" => "https://media.s-bol.com/BZ5y3zqoVlO2/r0nlmW2/550x686.jpg", "price" => 12.95, "url" => "https://www.bol.com/nl/nl/p/techidna-hittebestendige-kapton-tape-25mm-x-33m-polyimide-tape-voor-3d-printer-sublimatie-solderen-isolatie/9300000238449004/"],
        "8721325324016" => ["title" => "Techidna® - Teflon Tape (PTFE) - 2 Rollen", "image" => "https://media.s-bol.com/4Zwgxlw8zqV6/nZJQBjY/550x550.jpg", "price" => 9.95, "url" => "https://www.bol.com/nl/nl/p/techidna-teflon-tape-2-rollen-20-meter-totaal-12mm-x-0-075mm-voor-water-gas-lucht-sanitair/9300000241265911/"]
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
        .navbar { background: white; border-bottom: 2px solid var(--techidna); padding: 1.2rem 0; }
        .admin-bar { background: #ff4757; color: white; padding: 10px 0; font-weight: bold; text-align: center; }
        .hero { background: var(--dark); color: white; padding: 60px 0; border-radius: 0 0 40px 40px; }
        .product-card { border: none; border-radius: 20px; transition: 0.3s; background: white; height: 100%; border: 1px solid #e2e8f0; }
        .product-card:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0,0,0,0.05); }
        .btn-bol { background: var(--bol); color: white; border-radius: 50px; font-weight: 700; text-decoration: none; display: block; text-align: center; padding: 12px; }
        .btn-edit { background: #f1f5f9; color: #64748b; border-radius: 10px; padding: 5px 15px; font-size: 0.8rem; text-decoration: none; margin-top: 10px; display: inline-block; }
    </style>
</head>
<body>

<?php if($isAdmin): ?>
    <div class="admin-bar shadow-sm">
        ⚠️ ADMIN MODE ACTIEF - Je beheert nu de dataset van Techidna®
    </div>
<?php endif; ?>

<nav class="navbar sticky-top">
    <div class="container d-flex justify-content-between">
        <span class="fw-800 fs-3">TECHIDNA<span style="color:var(--techidna)">.</span></span>
        <?php if(!$isAdmin): ?>
            <a href="?role=admin" class="text-muted small text-decoration-none">Admin Login</a>
        <?php else: ?>
            <a href="index.php" class="text-white badge bg-dark text-decoration-none">Logout Admin</a>
        <?php endif; ?>
    </div>
</nav>

<header class="hero text-center">
    <div class="container">
        <h1 class="display-4 fw-800 mb-2">Partner Catalogus</h1>
        <p class="opacity-75 fs-5">Beheer en bekijk het assortiment van Techidna®</p>
    </div>
</header>

<main class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <input type="text" id="searchInput" class="form-control form-control-lg border-0 shadow-sm" placeholder="Zoek op naam...">
        </div>
        <div class="col-md-4">
            <select id="sortSelect" class="form-select form-select-lg border-0 shadow-sm">
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
        <div class="col-md-4 product-item" data-title="<?php echo strtolower($details['title']); ?>" data-price="<?php echo $details['price']; ?>">
            <div class="card product-card p-4">
                <img src="<?php echo $details['image']; ?>" class="mb-3" style="height:180px; object-fit:contain;">
                <h6 class="fw-bold mb-2"><?php echo $details['title']; ?></h6>
                <div class="fs-4 fw-800 text-primary mb-3">€ <?php echo number_format($details['price'], 2, ',', '.'); ?></div>
                
                <div class="mt-auto">
                    <a href="<?php echo $finalUrl; ?>" target="_blank" class="btn-bol">Bekijk op Bol.com</a>
                    
                    <?php if($isAdmin): ?>
                        <div class="border-top mt-3 pt-2">
                            <span class="badge bg-light text-dark mb-2">EAN: <?php echo $item['ean']; ?></span><br>
                            <a href="https://github.com/mlozeman-creator/techidna-partner-hub/edit/main/data/products.json" target="_blank" class="btn-edit">⚙️ Bewerk JSON</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</main>

<script>
    // JS voor Filteren & Sorteren
    const searchInput = document.getElementById('searchInput');
    const sortSelect = document.getElementById('sortSelect');
    const productGrid = document.getElementById('productGrid');
    const products = Array.from(document.getElementsByClassName('product-item'));

    function updateGrid() {
        const query = searchInput.value.toLowerCase();
        const sort = sortSelect.value;

        products.forEach(p => {
            const match = p.getAttribute('data-title').includes(query);
            p.style.display = match ? 'block' : 'none';
        });

        const visible = products.filter(p => p.style.display !== 'none');
        if(sort === 'low') visible.sort((a,b) => a.getAttribute('data-price') - b.getAttribute('data-price'));
        if(sort === 'high') visible.sort((a,b) => b.getAttribute('data-price') - a.getAttribute('data-price'));

        visible.forEach(p => productGrid.appendChild(p));
    }

    searchInput.addEventListener('input', updateGrid);
    sortSelect.addEventListener('change', updateGrid);
</script>

</body>
</html>
