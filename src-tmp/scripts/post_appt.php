<?php
$base = 'http://127.0.0.1:8000';
$url = $base . '/v1/appointments';
$bearer = '1|CLVqyKg8IXnZyLCjGdUtsCY4VypLojXhbNMBYpgKfe1d699d';
$payload = file_get_contents(__DIR__ . '/../create_appt_payload.json');

// First GET / to obtain cookies and XSRF token
$home = file_get_contents($base);
$headers = $http_response_header ?? [];
$cookies = [];
foreach ($headers as $h) {
    if (stripos($h, 'Set-Cookie:') === 0) {
        $val = trim(substr($h, strlen('Set-Cookie:')));
        $part = explode(';', $val)[0];
        list($k,$v) = explode('=', $part, 2);
        $cookies[trim($k)] = trim($v);
    }
}

$cookieHeader = '';
foreach ($cookies as $k=>$v) { $cookieHeader .= "$k=$v; "; }

$xsrf = $cookies['XSRF-TOKEN'] ?? null;
if ($xsrf) {
    $xsrf = urldecode($xsrf);
}

$opts = [
    'http' => [
        'method' => 'POST',
        'header' => "Content-Type: application/json\r\nAuthorization: Bearer $bearer\r\nX-XSRF-TOKEN: $xsrf\r\nCookie: $cookieHeader\r\n",
        'content' => $payload,
        'ignore_errors' => true,
    ]
];

$context = stream_context_create($opts);
$result = file_get_contents($url, false, $context);
echo $result;
