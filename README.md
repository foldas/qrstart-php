## QR Start API client for PHP

PHP client for [qrstart.eu](https://www.qrstart.eu/) services.

### Installation

Download by hand **lib** folder:
````html
https://github.com/foldas/qrstart-php/archive/main.zip
````
By composer:
````html
composer require foldas/qrstart-php
````

### Usage

**Request for QR Code:**

````php
$data = [
	'type' => 'bank',
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

**Response for QR Code:**

````js
{
	'success': true,
	'url': 'https://api.qrstart.eu/files/abcdefghijklmn.png'
}
````

**Request for QR Code added into PDF file:**

````php
$data = [
	'type' => 'bank',
	'amount' => 1000,
	'currency' => 'CZK',
	'date' => '20210101',
	'account' => '123456789/6666',
	'note' => 'QR Platba',
	'variable' => '2021',
	'size' => 100,
	'file' => '/var/www/your-site/file.pdf',
	'top' => 10,
	'right' => 10
]
$qrstart = new QrStart('your-api-key');
$response = $qrstart->qrCode($data);
````
**Response for PDF file with QR Code:**

````js
{
	'success': true,
	'url': 'https://api.qrstart.eu/files/abcdefghijklmn.pdf'
}
````

Download QR code (PNG) or PDF file from our storage to you. Generated files are deleted continuously.

**False response:**

````js
{
	'success': false,
	'message': 'error message'
}
````

#### Input parameters

- `type` - type of code
	- possible values are **bank**, **ean13**, **code128**, **text** (default bank)

- type **bank**:
	- `amount` - the amount (int or float)
		- *required*
	- `currency` - CZK or EUR
		- *required* for CZ/SK bank
		- for SEPA bank, the currency is automatically EUR
	- `bank` - CZ or SK or SEPA
		- CZ for czech QR code, SK for slovak QR code (it means CZ for czech bank app, SK for slovak bank app)
		- SEPA means EPC SEPA format
		- if empty, CZ for CZK currency and SK for EUR currency will be used
	- `account` - whole account number include bank code (123-456789123/4567)
		- *for CZK currency*
	- `iban` - IBAN
		- *required for EUR currency (or for CZK, if you don't want to fill account)*
	- `swift` - SWIFT code (BIC)
	- `variable` - variable symbol
	- `constant` - constant symbol
	- `specific` - specific symbol
	- `note` - note for the payer
	- `date` - due date (format YYYYMMDD)
	- `size` - size of generated png image in pixels (min. 50, max. 600, default 150)
		- for pdf the size is in mm
	- `margin` - image margin in pixels (default 2)
	- `tag` - internal note (visible in the dashboard, max. 50 chars)
	- `reference` - payer reference
		- for SK bank EUR currency (variable and constant and specific must be empty)
		- for SEPA bank
	- `beneficiary` - beneficiary name
		- for SEPA bank only
	- `remittance` - remittance text
		- for SEPA bank only (reference must be empty)

- type **ean13**:
	- `code` - EAN-13 code
		- *required*
	- `size` - 1-5 (int) (default 2)
		- for pdf the size is in mm
	- `tag` - internal note (visible in the dashboard, max. 50 chars)

- type **code128**:
	- `code` - some text
		- *required*
	- `size` - 1-5 (int) (default 2)
		- for pdf the size is in mm
	- `tag` - internal note (visible in the dashboard, max. 50 chars)

- type **text**:
	- `code` - some text
		- *required*
	- `size` - size of generated png image in pixels (min. 50, max. 600, default 150)
		- for pdf the size is in mm
	- `margin` - image margin in pixels (default 2)
	- `tag` - internal note (visible in the dashboard, max. 50 chars)

- if you want put QR Code to you pdf file, add following parameters
	- `file` - location of pdf file on server
	- `top` - position from top in mm
	- `bottom` - position from bottom in mm
		- in one request use top or bottom
	- `left` - position from left in mm
	- `right` - position from right in mm
		- in one request use left or right
	- `page` - the page on which the image is saved (default 1)
		- for last page use value -1

- by default the QR code image is generated as PNG, but you can also generate it as JPG/WEBP
	- `output` - jpg or webp
		- jpg value creates an image in JPG format
		- webp value creates an image in WEBP format

#### Help

Please check the **examples** folder.
