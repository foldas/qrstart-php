<?php
class QrStart {
	protected $apiKey;
	public function __construct($apiKey=NULL) {
		$this->apiKey = $apiKey;
	}
	public function qrCode($params=NULL) {
		if (empty($params)) {
			$result=[
				'success' => false,
				'message' => 'empty params'
			];
		} else {
			$result = $this->startCode(array_merge($params, ['apikey' => $this->apiKey]));
		}
		return json_encode($result);
	}
	public function startCode($data=NULL) {
		$ch=curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL, 'https://api.qrstart.eu');
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json'));
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		$response = curl_exec($ch);
		if (curl_errno($ch)) {
			$curl_error = curl_error($ch);
		}
		curl_close($ch);
		if (isset($curl_error)) {
			$result=[
				'success' => false,
				'message' => $curl_error
			];
		} else {
			$transform = json_decode($response, true);
			if ($transform['success'] === true) {
				$result=[
					'success' => true,
					'image' => $transform['image']
				];
			} else {
				$result=[
					'success' => false,
					'message' => $transform['message']
				];
			}
		}
		return $result;
	}
}