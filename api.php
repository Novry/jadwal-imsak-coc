<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$tag = isset($_GET['tag']) ? str_replace('#', '', $_GET['tag']) : '';
if (!$tag) {
    echo json_encode(["error" => "Tag tidak ditemukan"]);
    exit;
}

// Token terbaru kamu
$token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiIsImtpZCI6IjI4YTMxOGY3LTAwMDAtYTFlYi03ZmExLTJjNzQzM2M2Y2NhNSJ9.eyJpc3MiOiJzdXBlcmNlbGwiLCJhdWQiOiJzdXBlcmNlbGw6Z2FtZWFwaSIsImp0aSI6IjViMTgxN2Y1LWZkZTMtNDZiMC04ZDc1LWEwNmU2YTNhMWE5YiIsImlhdCI6MTc3MTIzNDE0Miwic3ViIjoiZGV2ZWxvcGVyL2M2OTM1NWZiLWE5MjYtNDU3YS03NmRmLTQ2YzQwNWMzODNmYSIsInNjb3BlcyI6WyJjbGFzaCJdLCJsaW1pdHMiOlt7InRpZXIiOiJkZXZlbG9wZXIvc2lsdmVyIiwidHlwZSI6InRocm90dGxpbmcifSx7ImNpZHJzIjpbIjEwMy4xMzguMTg5LjQ5Il0sInR5cGUiOiJjbGllbnQifV19.nzykRT4FUYrvGANr7ZNRoOm0Gry2_g6G2JY9NdLYXsYIW0_lv7Cs2eGMhL_aHX1RXSBzFAUqhGFTgTjmcgkfTQ";

$url = "https://api.clashofclans.com/v1/players/%23" . $tag;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer " . $token,
    "Accept: application/json"
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode !== 200) {
    echo json_encode(["error" => "Gagal mengambil data", "code" => $httpCode]);
} else {
    echo $response;
}
?>