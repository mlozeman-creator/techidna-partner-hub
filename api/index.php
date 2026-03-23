function getProductDetails($ean) {
    $catalog = [
        "8721325324115" => ["title" => "Techidna® - Laptoptas 14 inch - Bruin", "image" => "https://media.s-bol.com/YL539loWLLz9/qjDmoA2/550x489.jpg", "price" => "24.95"],
        "8721325324108" => ["title" => "Techidna® - Laptophoes 14 inch - Blauw", "image" => "https://media.s-bol.com/v07285qzPJx5/AnODK67/550x550.jpg", "price" => "17.99"],
        "8721325324009" => ["title" => "Techidna® - Kabel organiser tas - Zwart", "image" => "https://media.s-bol.com/RzmlmKW21OLz/G5nM6P5/550x545.jpg", "price" => "11.99"],
        "8721325324085" => ["title" => "Techidna® - Documentenmap A4 - Veganleer", "image" => "https://media.s-bol.com/YLlVGQxvkYJM/Z4vKLL2/550x396.jpg", "price" => "19.95"],
        "8721325324542" => ["title" => "Techidna® - Draadloze USB Microfoon Set", "image" => "https://media.s-bol.com/yggrkkGE09nw/qjVrNVG/550x550.jpg", "price" => "14.99"],
        "8721325324610" => ["title" => "Techidna® - Ergonomische Muismat - Paars", "image" => "https://media.s-bol.com/JBP9xyAmr3mv/qjE1qG0/550x598.jpg", "price" => "19.95"],
        "8721325324498" => ["title" => "Techidna® - Perzisch Tapijt Muismat", "image" => "https://media.s-bol.com/n16DP3gD3YlR/g5jy3qj/550x550.jpg", "price" => "12.50"],
        "8721325324221" => ["title" => "Techidna® - Kabel Tape 25mm x 15m - Zwart", "image" => "https://media.s-bol.com/v07285qzPJx5/AnODK67/550x550.jpg", "price" => "13.95"],
        "8721325324078" => ["title" => "Techidna® - Kapton Tape - 25mm x 33m", "image" => "https://media.s-bol.com/BZ5y3zqoVlO2/r0nlmW2/550x686.jpg", "price" => "12.95"],
        "8721325324016" => ["title" => "Techidna® - Teflon Tape (PTFE) - 2 Rollen", "image" => "https://media.s-bol.com/4Zwgxlw8zqV6/nZJQBjY/550x550.jpg", "price" => "9.95"]
    ];

    $data = $catalog[$ean] ?? [
        "title" => "Techidna® Premium Product",
        "image" => "https://media.s-bol.com/v07285qzPJx5/AnODK67/550x550.jpg",
        "price" => "19.95"
    ];

    return [
        'title' => $data['title'],
        'image' => $data['image'],
        'price' => $data['price'],
        'url'   => "https://www.bol.com/nl/nl/s/?searchtext=" . $ean,
        'stock' => rand(2, 12)
    ];
}
