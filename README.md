# QR Start API client for PHP

PHP client for [qrstart.eu](https://www.qrstart.eu/) services.

## Usage

**Request:**

````php
$data = [
	'amount' => 1000,
	'currency' => 'CZK',
	'date' => '20210101',
	'account' => '123456789/6666',
	'note' => 'QR Platba',
	'variable' => '2021',
	'size' => 150
]
$qrstart = new QrStart('your-api-key');
$response = $qrstart->qrCode($data);
````

**Response:**

````js
{
	'success': true,
	'image': 'https://api.qrstart.eu/files/abcdefghijklmn.png'
}
````

Download QR code (PNG) from our storage to you. Generated images are deleted continuously.

````js
{
	'success': false,
	'message': 'error message'
}
````

### Input parameters

- `amount` - the amount (int or float)
	- *required*
- `currency` - CZK or EUR
	- *required*
- `account` - whole account number exclude bank code (123-456789123/4567)
	- *required for CZK currency*
- `iban` - IBAN
	- *required for EUR currency*
- `swift` - SWIFT code (BIC)
	- *required for EUR currency*
- `variable` - variable symbol
- `constant` - constant symbol
- `specific` - specific symbol
- `note` - note for the payer
- `date` - due date (YYYYMMDD)
- `size` - size of generated png image in pixels (default 150)
- `tag` - internal note (visible in the dashboard, max. 50 chars)
