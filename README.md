# Techidna® Partner Hub v5.5 (Enterprise Secure)

De **Techidna® Partner Hub** is een robuust affiliate platform gebouwd met PHP en Vanilla JS. Versie 5.5 introduceert "Force Mode" routing voor maximale compatibiliteit met cloud-omgevingen zoals Vercel.

## 🚀 Kenmerken
* **Force Secure Auth:** Token-based authenticatie die werkt via $_REQUEST en URI-parsing.
* **Secrets Management:** Volledige scheiding van credentials via Vercel Environment Variables.
* **Premium Grid:** Responsive Bootstrap 5.3 interface met Techidna® branding.
* **Dynamic Search:** Real-time client-side filtering zonder latency.

## 🔐 Beheer & Beveiliging
De beheeromgeving is verborgen en alleen toegankelijk via een geautoriseerde URL-query.

### Toegang:
Gebruik de volgende structuur:
`https://[domein]/api/index.php?role=admin&pass=[ADMIN_PASSWORD]`

### Vereiste Cloud Variabelen:
* `ADMIN_PASSWORD`: Server-side gecontroleerd wachtwoord.
* `BOL_PARTNER_ID`: Affiliate tracking identifier.

## 🛠 Projectstructuur
* `api/index.php`: De "Engine" (Logica, Auth & UI).
* `data/products.json`: De "Database" (Product EAN's).

---
*Gerealiseerd door Mark Lozeman - 2026*
