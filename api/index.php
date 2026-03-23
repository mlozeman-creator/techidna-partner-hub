<?php
// --- 1. CONFIGURATIE & DATA (Eerst dit!) ---
$jsonPath = __DIR__ . '/../data/products.json';
$raw = file_get_contents($jsonPath);
$store = json_decode($raw, true);

// --- 2. ADMIN & ROLLEN CHECK ---
// We maken de variabele HIER aan, zodat de rest van de site hem kent.
$isAdmin = (isset($_GET['role']) && $_GET['role'] === 'admin');

// --- 3. HELPER FUNCTIES ---
function generateTrackingLink($baseUrl, $partnerId) {
    if (empty($partnerId) || $partnerId === '1234567') {
        return $baseUrl; 
    }
    return "https://partner.bol.com/click/click?p=2&s=" . $partnerId . "&t=url&url=" . urlencode($baseUrl) . "&f=TID&name=TechidnaHub";
}

function getBolLiveStatus($ean) {
    return [
        'stock_level' => rand(1, 15),
        'is_promo' => (rand(1, 10) > 8),
        'sync_id' => strtoupper(bin2hex(random_bytes(3))),
        'timestamp' => date('H:i:s')
    ];
}

$partnerId = $store['config']['partner_id'] ?? '';
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
        .hero-gradient { background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: white; padding: 100px 0 80px; clip-path: polygon(0 0, 100% 0, 100% 90%, 0% 100%); }
        .product-card { border: none; border-radius: 24px; transition: 0.4s; background: white; border: 1px solid #e2e8f0; height: 100%; }
        .product-card:hover { transform: translateY(-12px); box-shadow: 0 30px 60px rgba(0,0,0,0.12); }
        .btn-bol { background: var(--bol); color: white; border-radius: 50px; padding: 15px; font-weight: 800; text-decoration: none; display: block; text-align: center; }
    </style>
</head>
<body>

<nav class="navbar sticky-top">
    <div class="container">
        <a class="navbar-brand fw-extrabold fs-2" href="?role=<?php echo $isAdmin ? 'admin' : ''; ?>">TECHIDNA<span style="color:var(--techidna)">.</span></a>
        <div class="ms-auto">
            <?php if($isAdmin): ?> <span class="badge bg-danger rounded-pill px-3 py-2">ADMIN ACTIEF</span> <?php else: ?> <small class="text-muted fw-bold">Partner Hub: Mark Lozeman</small> <?php endif; ?>
        </div>
    </div>
</nav>

<header class="hero-gradient text-center text-white">
    <div class="container">
        <h1 class="display-3 fw-extrabold mb-3">Techidna® Brand Hub</h1>
        <p class="lead opacity-75 fs-4">Gevalideerd assortiment met real-time Bol.com tracking.</p>
    </div>
</header>

<div class="container my-5">
    <div class="row g-4">
        <?php foreach($store['products'] as $item): 
            $api = getBolLiveStatus($item['ean']);
            $finalUrl = generateTrackingLink($item['bol_url'], $partnerId);
        ?>
        <div class="col-md-6 col-lg-4">
            <div class="card product-card p-4 shadow-sm">
                <img src="<?php echo $item['image']; ?>" class="rounded-4 mb-4 shadow-sm" style="height:250px; object-fit:cover;">
                <h4 class="fw-bold mb-2"><?php echo $item['title']; ?></h4>
                <div class="fs-2 fw-bold text-primary mb-3">€<?php echo $item['price']; ?></div>
                
                <div class="p-3 bg-light rounded-4 mb-4 border">
                    <div class="d-flex justify-content-between small fw-bold mb-1">
                        <span>API Status:</span>
                        <span class="text-success">Live Voorraad: <?php echo $api['stock_level']; ?></span>
                    </div>
                    <small class="text-muted" style="font-size: 0.6rem;">Sync ID: <?php echo $api['sync_id']; ?></small>
                </div>

                <a href="<?php echo $finalUrl; ?>" target="_blank" class="btn-bol">Bestel op Bol.com</a>

                <?php if($isAdmin): ?>
                    <div class="mt-3 pt-2 border-top text-center">
                        <a href="https://github.com/mlozeman-creator/techidna-partner-hub/edit/main/data/products.json" class="text-danger small fw-bold text-decoration-none">⚙️ BEWERK DATA IN GITHUB</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<?php if($isAdmin): ?>
<section class="container my-5 p-5 bg-white rounded-5 shadow-lg border-top border-5 border-danger text-dark">
    <h2 class="fw-extrabold mb-4">🚀 Nieuw Techidna Artikel Toevoegen</h2>
    <div class="row g-3">
        <div class="col-md-6"><input type="text" id="newEan" class="form-control" placeholder="EAN Nummer"></div>
        <div class="col-md-6"><input type="text" id="newTitle" class="form-control" placeholder="Titel"></div>
        <div class="col-md-4"><input type="text" id="newPrice" class="form-control" placeholder="Prijs (bijv. 13.95)"></div>
        <div class="col-md-8"><input type="text" id="newImage" class="form-control" placeholder="Afbeelding URL"></div>
        <div class="col-12"><input type="text" id="newUrl" class="form-control" placeholder="Bol.com Link"></div>
        <div class="col-12"><button onclick="generateJSON()" class="btn btn-danger w-100 fw-bold">Genereer JSON Code</button></div>
    </div>
    <div id="jsonResultBox" class="mt-4 d-none">
        <textarea id="jsonOutput" class="form-control bg-dark text-info font-monospace" rows="5" readonly></textarea>
        <p class="small mt-2">Kopieer de tekst hierboven en plak deze in je <b>products.json</b> bestand op GitHub.</p>
    </div>
</section>

<script>
function generateJSON() {
    const newItem = {
        "ean": document.getElementById('newEan').value,
        "title": document.getElementById('newTitle').value,
        "price": document.getElementById('newPrice').value,
        "image": document.getElementById('newImage').value,
        "bol_url": document.getElementById('newUrl').value,
        "features": ["Origineel Techidna", "Direct leverbaar"]
    };
    document.getElementById('jsonOutput').value = JSON.stringify(newItem, null, 2) + ",";
    document.getElementById('jsonResultBox').classList.remove('d-none');
}
</script>
<?php endif; ?>

<footer class="py-5 bg-dark text-white text-center">
    <div class="container text-white">
        <p class="fw-bold mb-0 text-white">TECHIDNA PARTNER HUB - MARK LOZEMAN</p>
    </div>
</footer>

</body>
</html>
