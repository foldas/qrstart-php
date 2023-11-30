<?php
/**
Generate QR code (EUR) and diplay as image.
*/
require_once __DIR__.'/../lib/QrStart.php';

$data=[
	'type' => 'code128',
	'code' => '123456789',
	'size' => 1
];

$qrstart = new QrStart('your-api-key');
$response = $qrstart->qrCode($data);
$result = json_decode($response, true);

if ($result['success'] === true) {
	echo "<img src=\"".$result['url']."\" alt=\"QR code\">";
} else {
	echo "API error: ".$result['message'];
}
