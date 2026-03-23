<?php
// 1. Data laden
$raw = file_get_contents(__DIR__ . '/../data/products.json');
$store = json_decode($raw, true);
$partnerId = $store['config']['partner_id'] ?? '1234567';

// 2. De "EAN-to-Data" Generator
// Deze functie bouwt alles op basis van enkel het EAN nummer
function getProductDetails($ean) {
    // We bouwen de directe zoek-link van Bol.com op basis van EAN
    // Dit is de meest betrouwbare manier om altijd bij het juiste product uit te komen
    $bolSearchUrl = "https://www.bol.com/nl/nl/s/?searchtext=" . $ean;
    
    // Voor de presentatie: we genereren de metadata dynamisch
    // In een live API koppeling zou dit de 'Request' naar Bol zijn
    return [
        'title' => "Techidna® Product [" . substr($ean, -4) . "]", // Placeholder die we live vullen
        'price' => rand(10, 89) . ".95", // Simulatie van live prijs-fetch
        'image' => "https://media.s-bol.com/v07285qzPJx5/AnODK67/550x550.jpg", // Standaard Techidna placeholder
        'url' => $bolSearchUrl,
        'stock' => rand(2, 12)
    ];
}

function getAffiliateLink($url, $pid) {
    return "https://partner.bol.com/click/click?p=2&s=" . $pid . "&t=url&url=" . urlencode($url) . "&f=TID";
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Techidna® | Smart EAN Engine</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --techidna: #00d1b2; --bol: #004899; }
        body { background: #f0f2f5; font-family: 'Plus Jakarta Sans', sans-serif; }
        .product-card { border-radius: 20px; border: none; overflow: hidden; transition: 0.3s; }
        .product-card:hover { transform: translateY(-10px); }
        .ean-badge { font-size: 0.7rem; background: #eee; padding: 3px 8px; border-radius: 5px; color: #777; }
        .btn-bol { background: var(--bol); color: white; border-radius: 50px; font-weight: bold; padding: 12px; text-decoration: none; display: block; text-align: center; }
    </style>
</head>
<body>

<nav class="navbar bg-white shadow-sm sticky-top">
    <div class="container">
        <span class="navbar-brand fw-bold fs-3">TECHIDNA<span class="text-info">.</span></span>
        <span class="badge bg-light text-dark border">EAN-Driven Mode v2.0</span>
    </div>
</nav>

<div class="container my-5">
    <div class="row g-4">
        <?php foreach($store['products'] as $item): 
            $details = getProductDetails($item['ean']);
            $finalUrl = getAffiliateLink($details['url'], $partnerId);
        ?>
        <div class="col-md-4">
            <div class="card product-card h-100 shadow-sm p-4">
                <div class="mb-3 d-flex justify-content-between">
                    <span class="ean-badge">EAN: <?php echo $item['ean']; ?></span>
                    <span class="text-success fw-bold small">● LIVE</span>
                </div>
                
                <img src="<?php echo $details['image']; ?>" class="rounded-4 mb-4" style="height:200px; object-fit:contain;">
                
                <h5 class="fw-bold mb-3"><?php echo $details['title']; ?></h5>
                
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <span class="fs-3 fw-bold">€ <?php echo $details['price']; ?></span>
                    <span class="badge bg-info text-dark">Voorraad: <?php echo $details['stock']; ?></span>
                </div>

                <a href="<?php echo $finalUrl; ?>" target="_blank" class="btn-bol">Bekijk op Bol.com</a>
                <small class="text-center mt-3 text-muted" style="font-size: 0.6rem;">Attributie ID: <?php echo $partnerId; ?></small>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

</body>
</html>
