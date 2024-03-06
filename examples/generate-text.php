<?php
/**
Generate content QR code and diplay as image.
*/
require_once __DIR__.'/../lib/QrStart.php';
$data=[
	'type' => 'text',
	'code' => 'This is content of QR code',
	'size' => 150
];
$qrstart = new Qr\QrStart('your-api-key');
$response = $qrstart->qrCode($data);
$result = json_decode($response, true);
if ($result['success'] === true) {
	echo "<img src=\"".$result['url']."\" alt=\"QR code\">";
} else {
	echo "API error: ".$result['message'];
}
