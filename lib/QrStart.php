<?php
namespace Qr;
/**
 * Class QrStart.
 */
class QrStart {
	/** @var string The QRStart API key to be used for requests. */
	protected $apiKey;
	/** @var int Request timeout in seconds. */
	private $timeout;
    /**
     * @param string $apiKey
     * @param int $timeout
     */
	public function __construct($apiKey=NULL,$timeout=30) {
		$this->apiKey = $apiKey;
		$this->timeout = $timeout;
	}
    /**
     * @param array $params
     * @return string JSON
     */
	public function qrCode($params=NULL) {
		if (empty($params)) {
			$result=[
				'success' => false,
				'message' => 'empty params'
			];
		} else {
			if (!empty($params['file'])) {
				$upload = $this->uploadFile($params['file']);
				if ($upload['success'] === true) {
					$params = array_merge($params, ['apikey' => $this->apiKey, 'fingerprint' => $upload['fingerprint']]);
					$result = $this->startCode($params);
				} else {
					$result = $upload;
				}
			} else {
				$result = $this->startCode(array_merge($params, ['apikey' => $this->apiKey]));
			}
		}
		return json_encode($result);
	}
    /**
     * @param string $filename
     * @return array
     */
	public function uploadFile($filename=NULL) {
		if (class_exists('CURLFile')) {
			$file = new CURLFile($filename);
		} else {
			$file = '@' . $filename;
		}
		$data = [
			'apiKey' => $this->apiKey,
			'file' => $file
		];
		$ch=curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://upload.qrstart.eu');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
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
			$result = json_decode($response, true);
		}
		return $result;
	}
    /**
     * @param array $data
     * @return array
     */
	public function startCode($data=NULL) {
		$ch=curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL, 'https://api.qrstart.eu');
		curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept: application/json', 'Content-Type: application/json']);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
		curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
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
					'url' => $transform['url']
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