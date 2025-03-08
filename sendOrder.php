<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $telegramBotToken = "7251452177:AAEMKs8bl3IhtdNM5_GWRS-0mu-reWYaxXI";
    $chatId = "7933723681";

    $category = $_POST["category"];
    $service = $_POST["service"];
    $quantity = $_POST["quantity"];
    $price = $_POST["price"];
    $videoLink = $_POST["videoLink"];
    $whatsappNumber = $_POST["whatsappNumber"];

    $message = "📦 New Order!\n\n▫️ Category: $category\n▫️ Service: $service\n▫️ Quantity: $quantity\n▫️ Price: Rs $price\n▫️ Link: $videoLink\n▫️ WhatsApp: $whatsappNumber";

    $telegramAPI = "https://api.telegram.org/7251452177:AAEMKs8bl3IhtdNM5_GWRS-0mu-reWYaxXI/sendMessage";
    
    $data = [
        "chat_id" => $chatId,
        "text" => $message,
        "parse_mode" => "HTML"
    ];

    $options = [
        "http" => [
            "header" => "Content-Type: application/x-www-form-urlencoded\r\n",
            "method" => "POST",
            "content" => http_build_query($data)
        ]
    ];
    
    $context = stream_context_create($options);
    $response = file_get_contents($telegramAPI, false, $context);
    
    if ($response) {
        echo json_encode(["success" => true, "message" => "Order sent successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to send order"]);
    }
}
?>
