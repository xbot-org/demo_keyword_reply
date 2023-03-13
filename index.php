<?php

$jsonString = file_get_contents("php://input");

$msg = json_decode($jsonString, true);

switch ($msg['type']) {
    case 'MT_RECV_TEXT_MSG':
        if ($msg['data']['msg'] == 'ping') {
            sendText($msg['data']['from_wxid'], 'pong');
        } elseif ($msg['data']['msg'] == '1234') {
            sendText($msg['data']['from_wxid'], '4567');
        }
}

echo '{}';

function sendText($wxid, $content) {
    post(json_encode([
        'client_id' => 1,
        'is_sync' => 1,
        'data' => [
            'to_wxid' => $wxid,
            'content' => $content,
        ],
        'type' => 'MT_SEND_TEXTMSG',
    ]));
}

function post($data) {
    $opts = array('http' =>
        array(
            'method'  => 'POST',
            'header'  => 'Content-Type: application/json',
            'content' => $data
        )
    );

    $context  = stream_context_create($opts);

    file_get_contents('http://127.0.0.1:5557', false, $context);
}
