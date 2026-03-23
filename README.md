# Techidna® Partner Hub v5.1

De **Techidna® Partner Hub** is een high-performance affiliate platform dat het premium assortiment van Techidna op Bol.com presenteert. Dit project is ontwikkeld met een focus op snelheid, data-integriteit en een "API-ready" architectuur.

## 🚀 Kenmerken

* **Premium Branding:** Volledig op maat gemaakte interface met de officiële Techidna® huisstijl.
* **Decoupled Architecture:** Strikt onderscheid tussen data (`JSON`), logica (`PHP`) en presentatie (`Bootstrap/JS`).
* **Zero-Latency Filters:** Razendsnelle client-side zoek- en sorteerfunctionaliteit (Vanilla JS).
* **Admin Mode:** Beheerdersomgeving toegankelijk via URL-parameters (`?role=admin`) voor systeemmonitoring en EAN-inspectie.
* **Cloud Native:** Volledig geoptimaliseerd voor Vercel met gebruik van *Environment Variables*.

## 🛠 Technische Stack

* **Backend:** PHP 8.x (Service Layer & Data Mapping)
* **Frontend:** HTML5, CSS3 (Custom Properties), Bootstrap 5.3
* **Interactiviteit:** Vanilla JavaScript (ES6+)
* **Data Formaat:** JSON (Single Source of Truth)

## 📂 Projectstructuur

```text
├── api/
│   └── index.php       # Core applicatie: Logica, Routing en UI
├── data/
│   └── products.json   # De "Database": Bevat de EAN-lijst en configuratie
└── README.md           # Project documentatie
