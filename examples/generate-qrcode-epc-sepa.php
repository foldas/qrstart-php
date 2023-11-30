<?php
/**
Generate EPC QR code
*/
require_once __DIR__.'/../lib/QrStart.php';

$data=[
	'bank' => 'SEPA',
	'amount' => 100,
	'currency' => 'EUR',
	'iban' => 'CZ1234000000000000999999',
	'beneficiary' => 'John Doe',
	'reference' => 'Invoice 666'
];

$qrstart = new QrStart('your-api-key');
$response = $qrstart->qrCode($data);
$result = json_decode($response, true);

$qrstart = new QrStart('your-api-key');
$response = $qrstart->qrCode($data);
$result = json_decode($response, true);

if ($result['success'] === true) {
	echo "<img src=\"".$result['url']."\" alt=\"QR code\">";
} else {
	echo "API error: ".$result['message'];
}
