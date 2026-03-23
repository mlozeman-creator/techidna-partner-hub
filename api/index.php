<?php
// Voeg deze functie toe bovenaan je script
function generateTrackingLink($baseUrl, $partnerId) {
    if (empty($partnerId)) return $baseUrl;
    // Dit is de officiële manier waarop Bol clicks trackt
    return "https://partner.bol.com/click/click?p=2&s=" . $partnerId . "&t=url&url=" . urlencode($baseUrl) . "&f=TID&name=TechidnaHub";
}

$partnerId = $store['config']['partner_id'] ?? '';
?>

<a href="<?php echo generateTrackingLink($item['bol_url'], $partnerId); ?>" 
   target="_blank" 
   class="btn-bol">
   Bestel op Bol.com
</a>
