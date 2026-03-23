# Techidna® Partner Hub v5.6 (Enterprise API-Ready)

De **Techidna® Partner Hub** is een geavanceerd affiliate platform ontwikkeld voor Techidna®. Deze versie (5.6) is gebouwd volgens moderne software-architectuur principes, met een strikte scheiding tussen de data-laag en de presentatie-laag.

## 🌟 Belangrijkste Kenmerken
* **Enterprise Security:** Token-based authenticatie via server-side PHP validatie, onzichtbaar voor de client.
* **API-Ready Architecture:** De applicatie maakt gebruik van een *Service Layer* mapping. Dit betekent dat de overstap van lokale JSON-data naar een live Bol.com API v10 koppeling kan worden gemaakt zonder de frontend te wijzigen.
* **Real-time System Status:** De footer bevat actieve status-indicatoren die de verbinding met de "API Bridge" en de data-integriteit monitoren via Vercel Environment Variables.
* **High-Performance UI:** Gebouwd op Bootstrap 5.3 en Vanilla ES6+ JavaScript voor een razendsnelle, "zero-latency" zoek- en sorteerervaring.

## 🛠 Technische Specificaties

### 🔐 Beveiligde Toegang (Admin Mode)
De beheeromgeving is uitsluitend toegankelijk via een geautoriseerde query-string:
`https://[domein]/api/index.php?role=admin&pass=[SECRET_TOKEN]`

### ☁️ Cloud Configuratie (Vercel)
De applicatie is "Cloud Native" en haalt haar configuratie uit beveiligde omgevingsvariabelen:
* `ADMIN_PASSWORD`: De cryptografische sleutel voor beheerderstoegang.
* `BOL_PARTNER_ID`: De unieke identifier voor affiliate commissies.
* `BOL_CLIENT_ID`: (Optioneel) Activeert de API Bridge status wanneer geconfigureerd.

## 📂 Project Structuur
* `/api/index.php`: De kern van de applicatie (Routing, Auth, Mapping & UI).
* `/data/products.json`: De gecureerde database van het assortiment.

## 🚀 Toekomstige Schaalbaarheid
Door de gekozen *Middleware* opzet in PHP is de hub voorbereid op:
1.  **Live Voorraad-checks:** Directe koppeling met de Bol.com Retailer API.
2.  **Dynamische Prijs-updates:** Automatische synchronisatie van prijzen en aanbiedingen.
3.  **Multi-Partner Support:** Eenvoudige uitbreiding naar meerdere affiliate netwerken.

---
*Ontwikkeld door Mark Lozeman - Enterprise Web Development 2026*
