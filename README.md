# Techidna® Partner Hub v5.8 (Windesheim Edition)

De **Techidna® Partner Hub** is een professionele merkwebsite ontwikkeld voor Techidna (Easy Computershop). Dit project demonstreert de vaardigheid om een dynamische webapplicatie te bouwen die voldoet aan de industriestandaarden op het gebied van security, performance en schaalbaarheid.

## 🚀 Kenmerken & Functionaliteiten
Conform het officiële opdrachtformulier bevat de website de volgende onderdelen:
* **Home:** Landingspagina die Techidna positioneert als betrouwbaar merk.
* **Productoverzicht:** Een dynamische catalogus met Techidna-producten, voorzien van real-time zoek- en sorteerfuncties.
* **Over Techidna:** Pagina gericht op het opbouwen van merkvertrouwen en het uitleggen van het merkverhaal.
* **FAQ:** Veelgestelde vragen over garantie en de aankoop via bol.com.
* **Contact:** Directe communicatiemogelijkheid voor bezoekers.
* **Bol.com Integratie:** Volledige en transparante doorverwijzing naar bol.com conform de officiële affiliate-doelstelling.

## 🛠 Technische Architectuur
* **Backend:** PHP 8.x met een custom routering-systeem voor het ontsluiten van dynamische pagina-inhoud.
* **Data-laag:** Gecureerde JSON-database (Flat-file architecture). Deze opzet fungeert als blauwdruk voor toekomstige database- of API-koppelingen.
* **Frontend:** HTML5, CSS3 en Bootstrap 5.3 voor een responsive, modern design dat rust en vertrouwen uitstraalt.
* **Interactiviteit:** Vanilla JavaScript (ES6+) voor directe prijs-sortering en zoekfunctionaliteit zonder server-latency.

## 🔐 Security & Best Practices
Het project past industrie-standaarden toe voor veilige webontwikkeling en dataverwerking:
* **Secrets Management:** Gevoelige data zoals het `ADMIN_PASSWORD` en de `BOL_PARTNER_ID` worden beheerd via Vercel Environment Variables. Hierdoor blijven credentials buiten de publieke broncode.
* **Secure Admin Mode:** Een afgeschermde beheeromgeving via Token-based Authentication voor het inzien van technische productgegevens (EAN).
* **Privacy:** Ontworpen met oog op AVG-aspecten door minimale data-opslag en veilige externe doorverwijzingen.

## 📈 SEO & Optimalisatie
* **Performance:** Geoptimaliseerde laadtijden door minimale server-side overhead en snelle client-side interactie.
* **Toekomstbestendig:** De technische opzet (Service Layer) maakt eenvoudige uitbreiding naar een volledige API-integratie of MySQL-koppeling mogelijk.

---
*Ontwikkeld door Mark Lozeman (s1220834) voor Hogeschool Windesheim - 2026*
