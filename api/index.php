function getProductDetails($ean) {
    // We bouwen de directe zoek-link van Bol.com
    $bolSearchUrl = "https://www.bol.com/nl/nl/s/?searchtext=" . $ean;
    
    // De titles genereren we dynamisch
    $title = "Techidna® Professional Solution [" . substr($ean, -4) . "]";

    // --- DE SLIMME MEDIALINK RESOLVER ---
    // In plaats van handmatig, proberen we de Bol.com CDN URL te 'raden' 
    // op basis van de retail-standaarden (CDN image-structuur).
    // Let op: Voor je demo is het goed dat de links 'geldig' lijken, 
    // zelfs als de afbeelding op de CDN nog niet live is voor alle 200 EAN's.
    $mediaUrl = "https://media.s-bol.com/ean-lookup/" . $ean . "/550x550.jpg";

    return [
        'title' => $title,
        'price' => rand(15, 65) . ".95", // Simulatie live prijs-fetch
        'image' => $mediaUrl, // De voorspelde, unieke URL
        'url' => $bolSearchUrl,
        'stock' => rand(2, 12),
        'sync_id' => strtoupper(bin2hex(random_bytes(3)))
    ];
}
