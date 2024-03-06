<?php
/**
Generate QR code (CZK) and put it into PDF file, and save them to local storage.
*/
require_once __DIR__.'/../lib/QrStart.php';
if (!empty($_FILES['file'])) {
	move_uploaded_file($_FILES['file']['tmp_name'],"file.pdf");
	$data=[
		'amount' => 1000,
		'currency' => 'CZK',
		'date' => date("Ymd"),
		'account' => '123456789/6666',
		'note' => 'QR Platba',
		'variable' => '20210001',
		'size' => 100,
		'tag' => 'Order 20210001',
		'file' => __DIR__.'/file.pdf',
		'top' => 10,
		'right' => 10
	];
	$qrstart = new Qr\QrStart('your-api-key');
	$response = $qrstart->qrCode($data);
	$result = json_decode($response, true);
	if ($result['success'] === true) {
		// path to save pdf code
		$save = __DIR__.'/file-with-qr.pdf';
		// save
		$ch = curl_init();
		$fp = fopen($save, "w");
		curl_setopt($ch, CURLOPT_URL, $result['url']);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_FILE, $fp);
		curl_exec($ch);
		$errorCode = curl_errno($ch);
		if (empty($errorCode)) {
			echo "File saved to ".$save;
		} else {
			echo "Download error: ".curl_error($ch);
		}
		curl_close($ch);
		fclose($fp);
	} else {
		echo "API error: ".$result['message'];
	}
} else {
    echo "POST error: empty file";
}
