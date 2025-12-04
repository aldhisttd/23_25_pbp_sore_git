<?php

//Mengatur jenis data dari respon(json)
header("Content-Type: application/json; charset=UTF-8");
if($_SERVER ['REQUEST_METHOD'] != 'POST') {
    http_response_code(405);

    $res = [
    'status' => 'succes'

    ];

    echo json_encode($res);
    exit();
};


//php json
echo json_encode([
    'status' => 'succes'

]);

