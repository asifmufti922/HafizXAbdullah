const fetch = require("node-fetch");

exports.handler = async (event) => {
    if (event.httpMethod !== "POST") {
        return {
            statusCode: 405,
            body: JSON.stringify({ error: "Method Not Allowed" })
        };
    }

    const { category, service, quantity, price, videoLink, whatsappNumber } = JSON.parse(event.body);

    const message = `📦 New Order!\n\n▫️ Category: ${category}\n▫️ Service: ${service}\n▫️ Quantity: ${quantity}\n▫️ Price: Rs ${price}\n▫️ Link: ${videoLink}\n▫️ WhatsApp: ${whatsappNumber}`;

    const telegramAPI = `https://api.telegram.org/bot${process.env.TELEGRAM_BOT_TOKEN}/sendMessage`;
    const chatId = process.env.TELEGRAM_CHAT_ID;

    try {
        const response = await fetch(telegramAPI, {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ chat_id: chatId, text: message })
        });

        if (!response.ok) throw new Error("Failed to send order");

        return {
            statusCode: 200,
            body: JSON.stringify({ success: true })
        };
    } catch (error) {
        return {
            statusCode: 500,
            body: JSON.stringify({ error: error.message })
        };
    }
};
