# Techidna® Partner Hub v5.9 (Enterprise Bridge Edition)

De **Techidna® Partner Hub** is een geavanceerde merkwebsite ontwikkeld voor Techidna (Easy Computershop). Dit project demonstreert een schaalbare, dynamische webapplicatie die voldoet aan de professionele standaarden voor informatievoorziening en conversie-optimalisatie.

## 🚀 Gerealiseerde Functionaliteiten
Conform het officiële opdrachtformulier zijn de volgende onderdelen volledig operationeel:
* **Home:** Centrale landingspagina voor merkpositionering en vertrouwen.
* **Productoverzicht:** Dynamische catalogus met real-time zoek- en sorteerfuncties via Vanilla JavaScript.
* **Over Techidna:** Pagina gericht op het merkverhaal en autoriteitsopbouw.
* **FAQ:** Beantwoording van veelgestelde vragen over garantie en de logistieke afhandeling via bol.com.
* **Contact:** Directe communicatielijn voor klantondersteuning.
* **Affiliate Bridge:** Transparante doorverwijzing naar bol.com voor de daadwerkelijke aankoop.

## 🛠 Technische Architectuur & Innovatie
* **PHP Routering:** Een custom server-side router beheert de navigatie en behoudt de sessiestatus (Admin Mode) over verschillende pagina's.
* **API-Ready Design:** De applicatie maakt gebruik van een *Service Layer* mapping. De actuele "System Status" indicators in de footer monitoren de verbinding met de API-bridge.
* **Flat-file Database:** Gebruik van een gecureerde JSON-datastructuur voor superieure performance en eenvoudige migratie naar MySQL of live API-koppelingen.
* **Responsive UI:** Gebouwd met Bootstrap 5.3 en Plus Jakarta Sans voor een moderne, rustige uitstraling die voldoet aan de ontwerpeisen.

## 🔐 Security & Best Practices
In het kader van de vaktechnische leerdoelen zijn de volgende veiligheidsmaatregelen geïmplementeerd:
* **Secrets Management:** Gebruik van Vercel Environment Variables om gevoelige tokens (`ADMIN_PASSWORD`, `BOL_PARTNER_ID`) buiten de broncode te houden.
* **Role-Based Access:** Beveiligde Admin-modus via token-based authenticatie voor toegang tot technische productmetadata (EAN-codes).
* **AVG Compliance:** Ontworpen met een focus op veilige dataverwerking en minimale opslag van privacygevoelige gegevens.

## 📈 SEO & Performance
* **Zero-Latency Filtering:** Client-side verwerking van zoekopdrachten zorgt voor een optimale gebruikerservaring.
* **Toekomstbestendig:** De modulaire opzet maakt directe integratie van de Bol.com Retailer API mogelijk.

---
*Ontwikkeld door Mark Lozeman (s1220834) voor Hogeschool Windesheim - 2026*
