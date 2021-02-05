<?php
/**
Generate QR code (EUR) and diplay as image.
*/
require_once __DIR__.'/../lib/QrStart.php';

$data=[
	'type' => 'ean13',
	'code' => '9780471117094',
	'size' => 2
];

$qrstart = new QrStart('your-api-key');
$response = $qrstart->qrCode($data);
$result = json_decode($response, true);

if ($result['success'] === true) {
	echo "<img src=\"".$result['url']."\" alt=\"QR code\">";
} else {
	echo "API error: ".$result['message'];
}
