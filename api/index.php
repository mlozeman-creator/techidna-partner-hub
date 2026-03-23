<?php
// --- 1. DATA LADEN ---
$jsonPath = __DIR__ . '/../data/products.json';
$raw = @file_get_contents($jsonPath);
$store = json_decode($raw, true);
$partnerId = $store['config']['partner_id'] ?? '1234567';

// --- 2. DE WATERDICHTE CATALOGUS ---
function getProductDetails($ean) {
    // We koppelen hier de EAN aan de EXACTE Bol.com URL
    $catalog = [
        "8721325324467" => [
            "title" => "Kapton Tape / Polyimide Tape - 3 mm x 33 m", 
            "image" => "https://media.s-bol.com/RNO2Zw2X5wJw/wjNr35J/550x550.jpg", 
            "price" => "4.99",
            "direct_url" => "https://www.bol.com/nl/nl/p/kapton-tape-polyimide-tape-3-mm-x-33-m-hittebestendig-voor-elektronica-3d-printen/9300000247123648/?cid=1774297895087-8880773570188&bltgh=d327422f-e3a9-4489-bb98-aaa703384807.ProductList_Middle.13.ProductTitle"
        ],
        "8721325324559" => [
            "title" => "Techidna® - Mini Portemonnee - Pasjeshouder - Sleuteltasje - Zwart", 
            "image" => "https://media.s-bol.com/m5p6B180WpE3/WnVpOJx/550x550.jpg", 
            "price" => "12.95",
            "direct_url" => "https://www.bol.com/nl/nl/p/techidna-mini-portemonnee-pasjeshouder-sleuteltasje-zwart-vegan-leer-met-rits/9300000253717739/?cid=1774297786271-2784415590372&bltgh=fc9509eb-eea2-4dc0-aad7-cfa2b8fb2ef1.ProductList_Middle.4.ProductTitle"
        ],
        "8721325324009" => [
            "title" => "Techidna® - Kabel organiser tas - Zwart", 
            "image" => "https://media.s-bol.com/RzmlmKW21OLz/G5nM6P5/550x545.jpg", 
            "price" => "11.99",
            "direct_url" => "https://www.bol.com/nl/nl/p/techidna-kabel-organiser-tas-zwart-compact-design-waterafstotend-geschikt-voor-elektronische-accessoires/9300000257047329/?cid=1774297661424-6846047636534&bltgh=574c13b9-58c4-4a55-8dde-79a755ab095a.ProductList_Middle.0.ProductTitle"
        ],
        "8721325324085" => [
            "title" => "Techidna® - Documentenmap A4 - Veganleer", 
            "image" => "https://media.s-bol.com/YLlVGQxvkYJM/Z4vKLL2/550x396.jpg", 
            "price" => "19.95",
            "direct_url" => "https://www.bol.com/nl/nl/p/techidna-documentenmap-a4-veganleer-magneetsluiting-bruin/9300000237445292/?cid=1774297634308-2141810414960&bltgh=0c53ae2e-545f-49c1-a670-0c2b8adc6b97.ProductList_Middle.0.ProductTitle"
        ],
        "8721325324542" => [
            "title" => "Techidna® - Draadloze USB Microfoon Set", 
            "image" => "https://media.s-bol.com/yggrkkGE09nw/qjVrNVG/550x550.jpg", 
            "price" => "14.99",
            "direct_url" => "https://www.bol.com/nl/nl/p/techidna-draadloze-usb-microfoon-2-microfoons-usb-c-ontvanger-voor-smartphones-tablets-laptops-plug-play-vlogs-interviews-opnames/9300000236951588/?cid=1774297608187-8205790665981&bltgh=8a4b243b-e406-43d5-8151-f57a4ceff72b.ProductList_Middle.0.ProductTitle"
        ],
        "8721325324610" => [
            "title" => "Techidna® - Ergonomische Muismat - Paars", 
            "image" => "https://media.s-bol.com/JBP9xyAmr3mv/qjE1qG0/550x598.jpg", 
            "price" => "19.95",
            "direct_url" => "https://www.bol.com/nl/nl/p/techidna-ergonomische-muismat-met-polssteun-paars-gelkussen-antislip-compact/9300000269418990/?cid=1774297571371-4658679032520&bltgh=39059fa7-578f-432c-822b-d9a4aad92261.ProductList_Middle.2.ProductTitle"
        ],
        "8721325324498" => [
            "title" => "Techidna® - Perzisch Tapijt Muismat", 
            "image" => "https://media.s-bol.com/n16DP3gD3YlR/g5jy3qj/550x550.jpg", 
            "price" => "12.50",
            "direct_url" => "https://www.bol.com/nl/nl/p/perzisch-tapijt-muismat-25x18-cm-anti-slip-rubber-onderkant-warm-rood/9300000249510020/?cid=1774297538909-5170753745564&bltgh=05d6ba7c-80d3-442b-8532-bcf1e7bf17ed.ProductList_Middle.0.ProductTitle"
        ],
        "8721325324221" => [
            "title" => "Techidna® - Kabel Tape 25mm x 15m - Zwart", 
            "image" => "https://media.s-bol.com/v07285qzPJx5/AnODK67/550x550.jpg", 
            "price" => "13.95",
            "direct_url" => "https://www.bol.com/nl/nl/p/techidna-kabel-tape-25mm-x-15m-zwarte-isolatietape-textieltape-waterproof-hittebestendig-voor-kabelbundels-auto-elektronica-hockeysticks-rackets/9300000241270454/?cid=1774297512537-5872503231197&bltgh=bfae6eb7-5050-4527-aa6c-3d01e525fe5a.ProductList_Middle.0.ProductTitle"
        ],
        "8721325324078" => [
            "title" => "Techidna® - Kapton Tape - 25mm x 33m", 
            "image" => "https://media.s-bol.com/BZ5y3zqoVlO2/r0nlmW2/550x686.jpg", 
            "price" => "12.95",
            "direct_url" => "https://www.bol.com/nl/nl/p/techidna-hittebestendige-kapton-tape-25mm-x-33m-polyimide-tape-voor-3d-printer-sublimatie-solderen-isolatie/9300000238449004/?cid=1774297460690-6406872140596&bltgh=44e800ad-01d2-4c44-a7ea-ac405a9fb02b.ProductList_Middle.0.ProductTitle"
        ],
        "8721325324016" => [
            "title" => "Techidna® - Teflon Tape (PTFE) - 2 Rollen", 
            "image" => "https://media.s-bol.com/4Zwgxlw8zqV6/nZJQBjY/550x550.jpg", 
            "price" => "9.95",
            "direct_url" => "https://www.bol.com/nl/nl/p/techidna-teflon-tape-2-rollen-20-meter-totaal-12mm-x-0-075mm-voor-water-gas-lucht-sanitair/9300000241265911/?cid=1774297353920-8849744073513&bltgh=98910a28-13dc-4762-aba5-d97efd5bf9f1.ProductList_Middle.0.ProductTitle"
        ]
    ];

    $data = $catalog[$ean] ?? [
        "title" => "Techidna® Product",
        "image" => "https://media.s-bol.com/v07285qzPJx5/AnODK67/550x550.jpg",
        "price" => "19.95",
        "direct_url" => "https://www.bol.com/nl/nl/s/?searchtext=" . $ean
    ];

    return $data;
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
    <title>Techidna® | Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --bol: #004899; --techidna: #00d1b2; --bg: #f8fafc; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: var(--bg); }
        .navbar { background: white; border-bottom: 3px solid var(--techidna); padding: 1rem; }
        .hero { background: #0f172a; color: white; padding: 60px 0; border-bottom-left-radius: 40px; border-bottom-right-radius: 40px; text-align: center; margin-bottom: 40px; }
        .product-card { border: none; border-radius: 20px; transition: 0.3s; background: white; height: 100%; display: flex; flex-direction: column; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .product-card:hover { transform: translateY(-5px); box-shadow: 0 12px 20px rgba(0,0,0,0.1); }
        .price { font-size: 1.5rem; font-weight: 800; color: var(--bol); margin: 15px 0; }
        .btn-bol { background: var(--bol); color: white; border-radius: 50px; padding: 12px; font-weight: 700; text-decoration: none; display: block; text-align: center; }
    </style>
</head>
<body>

<nav class="navbar sticky-top">
    <div class="container">
        <span class="fw-bold fs-3">TECHIDNA<span style="color:var(--techidna)">.</span></span>
    </div>
</nav>

<header class="hero">
    <div class="container">
        <h1>Official Brand Hub</h1>
        <p class="opacity-75">Gecureerd assortiment</p>
    </div>
</header>

<div class="container mb-5">
    <div class="row g-4">
        <?php if($store && isset($store['products'])): ?>
            <?php foreach($store['products'] as $item): 
                $details = getProductDetails($item['ean']);
                $finalUrl = getAffiliateLink($details['direct_url'], $partnerId);
            ?>
            <div class="col-md-4">
                <div class="card product-card p-4">
                    <img src="<?php echo $details['image']; ?>" class="mb-3" style="height:180px; object-fit:contain;">
                    <h5 class="fw-bold"><?php echo $details['title']; ?></h5>
                    <div class="price">€ <?php echo $details['price']; ?></div>
                    <div class="mt-auto">
                        <a href="<?php echo $finalUrl; ?>" target="_blank" class="btn-bol">Bekijk op Bol.com</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
