<?php
$jsonPath = __DIR__ . '/../data/products.json';
$raw = @file_get_contents($jsonPath);
$store = json_decode($raw, true);
$partnerId = $store['config']['partner_id'] ?? '1234567';

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
    <title>Techidna® | Premium Partner Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        :root { --bol: #004899; --techidna: #00d1b2; --dark: #0f172a; --glass: rgba(255, 255, 255, 0.9); }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f1f5f9; color: var(--dark); }
        .navbar { background: var(--glass); backdrop-filter: blur(10px); border-bottom: 2px solid var(--techidna); padding: 1.2rem 0; }
        .hero { background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: white; padding: 80px 0; border-radius: 0 0 50px 50px; margin-bottom: -50px; }
        .filter-section { background: white; border-radius: 20px; padding: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); margin-bottom: 40px; position: relative; z-index: 10; }
        .product-card { border: none; border-radius: 24px; transition: 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); background: white; height: 100%; display: flex; flex-direction: column; overflow: hidden; border: 1px solid #e2e8f0; }
        .product-card:hover { transform: translateY(-12px); box-shadow: 0 25px 50px rgba(0,0,0,0.1); }
        .card-img-container { height: 200px; padding: 20px; background: #fff; display: flex; align-items: center; justify-content: center; }
        .price-tag { font-size: 1.75rem; font-weight: 800; color: var(--bol); }
        .btn-bol { background: var(--bol); color: white; border-radius: 50px; padding: 14px; font-weight: 700; text-decoration: none; display: block; text-align: center; border: none; transition: 0.3s; }
        .btn-bol:hover { background: #003366; color: white; box-shadow: 0 10px 20px rgba(0,72,153,0.3); }
        .form-control, .form-select { border-radius: 12px; border: 2px solid #f1f5f9; padding: 12px; }
        .form-control:focus { border-color: var(--techidna); box-shadow: none; }
    </style>
</head>
<body>

<nav class="navbar sticky-top">
    <div class="container d-flex justify-content-between align-items-center">
        <span class="fw-800 fs-2" style="letter-spacing: -1px;">TECHIDNA<span style="color:var(--techidna)">.</span></span>
        <span class="badge bg-dark rounded-pill px-3 py-2">PARTNER HUB 2.0</span>
    </div>
</nav>

<header class="hero text-center">
    <div class="container">
        <h1 class="display-3 fw-800 mb-3 text-white">Smart Solutions.</h1>
        <p class="lead opacity-75 fs-4 text-white">Het officiële Techidna® assortiment, slim gesorteerd.</p>
    </div>
</header>

<main class="container mt-5">
    <section class="filter-section">
        <div class="row g-3 align-items-end">
            <div class="col-md-6">
                <label class="form-label fw-bold">Zoek in assortiment</label>
                <input type="text" id="searchInput" class="form-control" placeholder="Typ bijv. 'Tape' of 'Tas'...">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Sorteer op prijs</label>
                <select id="sortSelect" class="form-select">
                    <option value="default">Standaard volgorde</option>
                    <option value="low">Prijs: Laag naar Hoog</option>
                    <option value="high">Prijs: Hoog naar Laag</option>
                </select>
            </div>
        </div>
    </section>

    <div class="row g-4" id="productGrid">
        <?php 
        if($store && isset($store['products'])):
            foreach($store['products'] as $item): 
                $details = getProductDetails($item['ean']);
                if(!$details) continue;
                $finalUrl = getAffiliateLink($details['url'], $partnerId);
        ?>
        <div class="col-md-6 col-lg-4 product-item" 
             data-title="<?php echo strtolower($details['title']); ?>" 
             data-price="<?php echo $details['price']; ?>">
            <div class="card product-card p-4">
                <div class="card-img-container">
                    <img src="<?php echo $details['image']; ?>" style="max-height: 100%; max-width: 100%; object-fit: contain;">
                </div>
                <h5 class="fw-bold mb-3 mt-2" style="min-height: 3em;"><?php echo $details['title']; ?></h5>
                <div class="price-tag mb-4">€ <?php echo number_format($details['price'], 2, ',', '.'); ?></div>
                <div class="mt-auto">
                    <a href="<?php echo $finalUrl; ?>" target="_blank" class="btn-bol">Bestel via Bol.com</a>
                </div>
            </div>
        </div>
        <?php 
            endforeach; 
        endif; 
        ?>
    </div>
</main>

<footer class="py-5 mt-5 text-center text-muted">
    <p class="mb-0 fw-600">Techidna® Brand Experience &bull; Mark Lozeman</p>
    <small>Data-driven Dynamic Interface</small>
</footer>

<script>
    const searchInput = document.getElementById('searchInput');
    const sortSelect = document.getElementById('sortSelect');
    const productGrid = document.getElementById('productGrid');
    const products = Array.from(document.getElementsByClassName('product-item'));

    function filterAndSort() {
        const searchTerm = searchInput.value.toLowerCase();
        const sortValue = sortSelect.value;

        // 1. Filteren
        products.forEach(product => {
            const title = product.getAttribute('data-title');
            if (title.includes(searchTerm)) {
                product.style.display = 'block';
            } else {
                product.style.display = 'none';
            }
        });

        // 2. Sorteren
        const visibleProducts = products.filter(p => p.style.display !== 'none');
        
        if (sortValue !== 'default') {
            visibleProducts.sort((a, b) => {
                const priceA = parseFloat(a.getAttribute('data-price'));
                const priceB = parseFloat(b.getAttribute('data-price'));
                return sortValue === 'low' ? priceA - priceB : priceB - priceA;
            });

            visibleProducts.forEach(p => productGrid.appendChild(p));
        }
    }

    searchInput.addEventListener('input', filterAndSort);
    sortSelect.addEventListener('change', filterAndSort);
</script>

</body>
</html>
