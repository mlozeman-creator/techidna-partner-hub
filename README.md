# Techidna® Partner Hub v5.2 (Secure Edition)

De **Techidna® Partner Hub** is een high-performance affiliate platform dat het premium assortiment van Techidna op Bol.com presenteert. Deze versie (5.2) introduceert een verhoogde beveiligingsstandaard voor beheerfuncties.

## 🚀 Kenmerken
* **Premium Branding:** Volledig op maat gemaakte interface met de officiële Techidna® huisstijl.
* **Token-based Authentication:** De beheeromgeving is beveiligd via server-side validatie van een geheim token.
* **Decoupled Architecture:** Strikte scheiding tussen JSON-data en PHP-logica (Service Layer).
* **Zero-Latency Filters:** Razendsnelle client-side zoek- en sorteerfunctionaliteit via Vanilla JS.
* **Cloud Native:** Gebruik van Vercel Environment Variables voor "Secrets Management".

## 🔐 Beveiliging & Authenticatie
In tegenstelling tot eerdere versies is de Admin-modus niet langer publiekelijk zichtbaar of toegankelijk via een simpele URL-parameter. 

### Toegang tot Admin Mode:
Toegang wordt alleen verleend indien zowel de juiste `role` als de bijbehorende `pass` (token) worden meegegeven in de URL-query. Dit token wordt op de server gevalideerd tegen de opgeslagen omgevingsvariabele in de cloud.

**Vereiste Environment Variables (Vercel Settings):**
| Variabele | Omschrijving |
| :--- | :--- |
| `ADMIN_PASSWORD` | De geheime sleutel voor toegang tot de beheerinterface. |
| `BOL_PARTNER_ID` | Unieke affiliate ID voor commissie-tracking. |
| `BOL_CLIENT_ID` | Gereserveerd voor de officiële Bol.com API v10 koppeling. |

## 🛠 Technische Stack
* **Backend:** PHP 8.x (Logic & Security Layer)
* **Frontend:** Bootstrap 5.3 & Vanilla JS (ES6+)
* **Data:** JSON (Single Source of Truth)

## 📂 Projectstructuur
* `api/index.php`: Core Applicatie, Beveiligingslogica & UI.
* `data/products.json`: Product-database (EAN-lijst).

## 📈 Ontwikkelproces
De evolutie van dit project bewoog van onstabiele **Web Scraping** naar een robuuste **Gecureerde Dataset**. Door de logica te scheiden van de data-bron is het systeem "API-ready": de lokale mapping kan direct worden vervangen door een live API-koppeling zonder dat de frontend-integriteit in gevaar komt.

---
*Ontwikkeld door Mark Lozeman - 2026*
