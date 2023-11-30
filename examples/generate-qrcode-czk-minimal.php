<?php
/**
Generate QR code (CZK) and diplay as image.
*/
require_once __DIR__.'/../lib/QrStart.php';

$data=[
	'amount' => 1000,
	'currency' => 'CZK',
	'account' => '1234567890/6666'
];

$qrstart = new QrStart('your-api-key');
$response = $qrstart->qrCode($data);
$result = json_decode($response, true);

if ($result['success'] === true) {
	echo "<img src=\"".$result['url']."\" alt=\"QR code\">";
} else {
	echo "API error: ".$result['message'];
}
