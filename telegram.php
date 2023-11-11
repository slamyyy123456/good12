<?php

$token = "6956590238:AAEE5goLAJl96-oWt8-8Aj_eKqp2wiyLXKQ";

// تحديد الأزرار
$buttons_list = [
    ["text" => "زر 1", "url" => "https://example.com"],
    ["text" => "زر 2", "callback_data" => "button2"],
];

// عرض الأزرار
function show_buttons($chat_id) {
    global $buttons_list, $token;

    $keyboard = ["inline_keyboard" => [$buttons_list]];
    $reply_markup = json_encode($keyboard);

    $url = "https://api.telegram.org/bot$token/sendMessage?chat_id=$chat_id&text=قائمة الأزرار&reply_markup=$reply_markup";
    file_get_contents($url);
}

// استجابة للضغط على الزر
function button_click($chat_id, $button_id) {
    global $token;

    if ($button_id === 'button1') {
        $text = "تم الضغط على زر 1. [زر 1](https://example.com)";
    } elseif ($button_id === 'button2') {
        $text = "تم الضغط على زر 2";
    }

    $text = urlencode($text);
    $url = "https://api.telegram.org/bot$token/editMessageText?chat_id=$chat_id&message_id=$message_id&text=$text";
    file_get_contents($url);
}

// التحقق من الاستعلام
$update = json_decode(file_get_contents("php://input"), true);
if (isset($update["message"])) {
    $chat_id = $update["message"]["chat"]["id"];
    show_buttons($chat_id);
} elseif (isset($update["callback_query"])) {
    $chat_id = $update["callback_query"]["message"]["chat"]["id"];
    $button_id = $update["callback_query"]["data"];
    button_click($chat_id, $button_id);
}
