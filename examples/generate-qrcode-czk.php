<?php
/**
Generate QR code (CZK) and save them to local storage.
*/
require_once __DIR__.'/../lib/QrStart.php';

$data=[
	'amount' => 1000,
	'currency' => 'CZK',
	'date' => date("Ymd"),
	'account' => '1234567890/6666',
	'note' => 'QR Platba',
	'variable' => '20210001',
	'size' => 150,
	'tag' => 'Order 20210001'
];

$qrstart = new QrStart('your-api-key');
$response = $qrstart->qrCode($data);
$result = json_decode($response, true);

if ($result['success'] === true) {
	// path to save qr code
	$save = __DIR__.'/save-path/qrcode.png',
	// save
	$ch = curl_init();
	$fp = fopen($save, "w");
	curl_setopt($ch, CURLOPT_URL, $result['url']);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_TIMEOUT, 20);
	curl_setopt($ch, CURLOPT_FILE, $fp);
	curl_exec($ch);
	$errorCode = curl_errno($ch);
	if (empty($errorCode)) {
		echo "QR Code saved to ".$save;
	} else {
		echo "Download error: ".curl_error($ch);
	}
	curl_close($ch);
	fclose($fp);
} else {
	echo "API error: ".$result['message'];
}
