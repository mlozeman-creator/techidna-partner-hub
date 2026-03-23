<?php
// Bovenin je bestand, na het laden van de JSON
function generateTrackingLink($baseUrl, $partnerId) {
    if (empty($partnerId) || $partnerId === '1234567') {
        return $baseUrl; // Retourneer normale link als er geen ID is
    }
    // De officiële Bol.com Partner Redirect
    return "https://partner.bol.com/click/click?p=2&s=" . $partnerId . "&t=url&url=" . urlencode($baseUrl) . "&f=TID&name=TechidnaHub";
}

$partnerId = $store['config']['partner_id'] ?? '';
?>

<a href="<?php echo generateTrackingLink($item['bol_url'], $partnerId); ?>" 
   target="_blank" 
   class="btn-bol">
   Bestel op Bol.com
</a>
