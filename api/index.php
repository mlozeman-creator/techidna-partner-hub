<?php if($isAdmin): ?>
<section class="container my-5 p-5 bg-white rounded-5 shadow-lg border-primary border-top border-5">
    <h2 class="fw-extrabold mb-4">🚀 Nieuw Techidna Artikel Toevoegen</h2>
    <p class="text-muted">Vul de gegevens van Bol.com in om de JSON-code te genereren.</p>
    
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label fw-bold">EAN Nummer</label>
            <input type="text" id="newEan" class="form-control rounded-pill" placeholder="Bijv. 8721325324221">
        </div>
        <div class="col-md-6">
            <label class="form-label fw-bold">Product Titel</label>
            <input type="text" id="newTitle" class="form-control rounded-pill" placeholder="Techidna® - ...">
        </div>
        <div class="col-md-4">
            <label class="form-label fw-bold">Prijs (€)</label>
            <input type="text" id="newPrice" class="form-control rounded-pill" placeholder="13.95">
        </div>
        <div class="col-md-8">
            <label class="form-label fw-bold">Afbeelding URL (Bol.com Media)</label>
            <input type="text" id="newImage" class="form-control rounded-pill" placeholder="https://media.s-bol.com/...">
        </div>
        <div class="col-12">
            <label class="form-label fw-bold">Bol.com Product Link</label>
            <input type="text" id="newUrl" class="form-control rounded-pill" placeholder="https://www.bol.com/nl/nl/p/...">
        </div>
        <div class="col-12">
            <button onclick="generateJSON()" class="btn btn-primary w-100 rounded-pill py-3 fw-bold">Genereer JSON Code</button>
        </div>
    </div>

    <div id="jsonResultBox" class="mt-4 d-none">
        <label class="fw-bold text-danger">Kopieer dit naar je products.json in GitHub:</label>
        <textarea id="jsonOutput" class="form-control mt-2 bg-dark text-info font-monospace" rows="5" readonly></textarea>
        <a href="https://github.com/mlozeman-creator/techidna-partner-hub/edit/main/data/products.json" target="_blank" class="btn btn-link text-decoration-none mt-2 fw-bold">➜ Open GitHub om te plakken</a>
    </div>
</section>

<script>
function generateJSON() {
    const ean = document.getElementById('newEan').value;
    const title = document.getElementById('newTitle').value;
    const price = document.getElementById('newPrice').value;
    const image = document.getElementById('newImage').value;
    const url = document.getElementById('newUrl').value;

    const newItem = {
        "ean": ean,
        "title": title,
        "price": price,
        "image": image,
        "bol_url": url,
        "features": ["Origineel Techidna", "Direct leverbaar"]
    };

    document.getElementById('jsonOutput').value = JSON.stringify(newItem, null, 2) + ",";
    document.getElementById('jsonResultBox').classList.remove('d-none');
}
</script>
<?php endif; ?>
