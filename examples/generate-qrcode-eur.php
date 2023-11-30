<?php
/**
Generate QR code (EUR) and diplay as image.
*/
require_once __DIR__.'/../lib/QrStart.php';

$data=[
	'amount' => 1000,
	'currency' => 'EUR',
	'date' => date("Ymd"),
	'iban' => 'SK1234000000000000999999',
	'swift' => 'GIBASKBX',
	'note' => 'QR Platba',
	'variable' => '20210001'
];

$qrstart = new QrStart('your-api-key');
$response = $qrstart->qrCode($data);
$result = json_decode($response, true);

if ($result['success'] === true) {
	echo "<img src=\"".$result['url']."\" alt=\"QR code\">";
} else {
	echo "API error: ".$result['message'];
}
