<?php
function get($url, $headers = []){
    $opts = [
        "http" => [
            "method" => "GET",
            "header" => implode("\r\n", $headers),
            "ignore_errors" => true,
        ],
    ];
    $context = stream_context_create($opts);
    $res = file_get_contents($url, false, $context);
    $info = isset($http_response_header) ? $http_response_header : [];
    return [$info, $res];
}

function post($url, $data, $headers = []){
    $body = json_encode($data);
    $headers[] = 'Content-Type: application/json';
    $opts = [
        'http' => [
            'method' => 'POST',
            'header' => implode("\r\n", $headers),
            'content' => $body,
            'ignore_errors' => true,
        ],
    ];
    $context = stream_context_create($opts);
    $res = file_get_contents($url, false, $context);
    $info = isset($http_response_header) ? $http_response_header : [];
    return [$info, $res];
}

// Fetch services
list($h, $b) = get('http://127.0.0.1:8000/api/v1/services');
echo "--- GET /api/v1/services ---\n";
foreach($h as $line) echo $line . "\n";
echo $b . "\n\n";

// Try login with common test user
list($h2,$b2) = post('http://127.0.0.1:8000/api/v1/login', ['email' => 'admin@example.com', 'password' => 'secret']);
echo "--- POST /api/v1/login ---\n";
foreach($h2 as $line) echo $line . "\n";
echo $b2 . "\n\n";

// If login returned token, try appointments
$resp = json_decode($b2, true);
if (isset($resp['token'])){
    $token = $resp['token'];
    list($h3,$b3) = get('http://127.0.0.1:8000/api/v1/appointments', ['Authorization: Bearer ' . $token]);
    echo "--- GET /api/v1/appointments ---\n";
    foreach($h3 as $line) echo $line . "\n";
    echo $b3 . "\n";
} else {
    echo "No token from login; cannot call protected endpoints.\n";
}
