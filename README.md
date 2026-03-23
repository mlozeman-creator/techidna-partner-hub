# Techidna® Partner Hub v5.8 (Windesheim Edition)

[cite_start]De **Techidna® Partner Hub** is een professionele merkwebsite ontwikkeld voor Techidna (Easy Computershop). [cite_start]Dit project demonstreert de vaardigheid om een dynamische webapplicatie te bouwen die voldoet aan industriestandaarden op het gebied van security, performance en schaalbaarheid.

## 🚀 Kenmerken & Functionaliteiten
[cite_start]Conform het officiële opdrachtformulier bevat de website de volgende onderdelen[cite: 4]:
* [cite_start]**Home:** Landingspagina die Techidna positioneert als betrouwbaar merk.
* [cite_start]**Productoverzicht:** Een dynamische catalogus met real-time zoek- en sorteerfuncties (JavaScript)[cite: 4].
* [cite_start]**Over Techidna:** Pagina gericht op het opbouwen van merkvertrouwen[cite: 4].
* [cite_start]**FAQ:** Veelgestelde vragen over garantie en de aankoop via bol.com[cite: 4].
* [cite_start]**Contact:** Directe communicatiemogelijkheid voor bezoekers[cite: 4].
* [cite_start]**Bol.com Integratie:** Volledige en transparante doorverwijzing naar bol.com conform de affiliate-doelstelling[cite: 2, 4].

## 🛠 Technische Architectuur
* [cite_start]**Backend:** PHP 8.x met een custom routering-systeem voor dynamische pagina-inhoud.
* **Data-laag:** Gecureerde JSON-database (Flat-file architecture). [cite_start]Deze opzet is gekozen voor maximale snelheid en fungeert als blauwdruk voor toekomstige API- of MySQL-koppelingen[cite: 2, 3].
* [cite_start]**Frontend:** HTML5, CSS3 (Custom Properties), en Bootstrap 5.3 voor een responsive, modern design dat rust en vertrouwen uitstraalt.
* [cite_start]**Interactiviteit:** Vanilla JavaScript (ES6+) voor directe prijs-sortering en zoekfunctionaliteit zonder laadtijd[cite: 4].

## 🔐 Security & Best Practices
[cite_start]Het project past **Industrie-standaarden** toe voor veilige webontwikkeling:
* **Secrets Management:** Gevoelige data zoals het `ADMIN_PASSWORD` en de `BOL_PARTNER_ID` worden opgevraagd via Vercel Environment Variables. [cite_start]Hierdoor blijven credentials buiten de publieke broncode[cite: 4].
* **Fallback Mechanism:** De code bevat een veilige fallback voor development-omgevingen, die automatisch wordt overschreven door de versleutelde productie-omgeving op de server.
* [cite_start]**Secure Admin Mode:** Een afgeschermde beheeromgeving (via Token-based Auth) voor het inzien van technische gegevens zoals EAN-codes[cite: 4].

## 📈 SEO & Optimalisatie
* [cite_start]**Performance:** Geoptimaliseerde laadtijden door minimale server-side overhead[cite: 4].
* [cite_start]**Toekomstbestendig:** De technische opzet (Service Layer) maakt eenvoudige uitbreiding naar een volledige API-integratie mogelijk[cite: 2, 4].

---
[cite_start]*Ontwikkeld door Mark Lozeman (s1220834) voor Hogeschool Windesheim - 2026*
