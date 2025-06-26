<div align="center">
    <h1><img src="logo.png" alt="logo.png" title="logo.png" width="300" /></h1>
</div> 

# StarDots-SDK-PHP  

[![PHP](https://github.com/stardots-io/stardots-sdk-php/actions/workflows/go.yml/badge.svg)](https://github.com/stardots-io/stardots-sdk-php/actions/workflows/php.yml)
[![CodeQL](https://github.com/stardots-io/stardots-sdk-php/actions/workflows/codeql.yml/badge.svg)](https://github.com/stardots-io/stardots-sdk-php/actions/workflows/codeql.yml)
[![codecov](https://codecov.io/github/stardots-io/stardots-sdk-php/graph/badge.svg?token=UNLOORRJHA)](https://codecov.io/github/stardots-io/stardots-sdk-php)
[![LICENSE: MIT](https://img.shields.io/github/license/stardots-io/stardots-sdk-php.svg?style=flat)](LICENSE)  

### Introduction  
This project is used to help developers quickly access the StarDots platform and is written in PHP. Compatible with PHP 5.5+.

### Requirements  
> PHP version >= 5.5.0  
> cURL extension  
> JSON extension  

### Installation  

#### Using Composer (Recommended)
```bash
composer require stardots-io/stardots-sdk-php
```

#### Manual Installation
1. Download the source code
2. Include the autoloader or manually include the files
3. Use the SDK

### Usage

#### Basic Example
```php
<?php

require_once 'vendor/autoload.php';

use StarDots\StarDots;

// Initialize the SDK
$clientKey = "Your client key";
$clientSecret = "Your client secret";
$stardots = new StarDots($clientKey, $clientSecret);

// Or use the static create method
$stardots = StarDots::create($clientKey, $clientSecret);

// Get space list
$params = [
    'page' => 1,
    'pageSize' => 20
];
$response = $stardots->getSpaceList($params);
```

#### API Examples

##### Get Space List
```php
$params = [
    'page' => 1,
    'pageSize' => 50
];
$response = $stardots->getSpaceList($params);
```

##### Create Space
```php
$params = [
    'space' => 'demo',
    'public' => true
];
$response = $stardots->createSpace($params);
```

##### Delete Space
```php
$params = [
    'space' => 'demo'
];
$response = $stardots->deleteSpace($params);
```

##### Toggle Space Accessibility
```php
$params = [
    'space' => 'demo',
    'public' => false
];
$response = $stardots->toggleSpaceAccessibility($params);
```

##### Get Space File List
```php
$params = [
    'page' => 1,
    'pageSize' => 50,
    'space' => 'demo'
];
$response = $stardots->getSpaceFileList($params);
```

##### Get File Access Ticket
```php
$params = [
    'space' => 'demo',
    'filename' => 'example.png'
];
$response = $stardots->fileAccessTicket($params);
```

##### Upload File
```php
$fileContent = file_get_contents('path/to/file.png');
$params = [
    'space' => 'demo',
    'filename' => 'example.png',
    'fileContent' => $fileContent
];
$response = $stardots->uploadFile($params);
```

##### Delete File
```php
$params = [
    'space' => 'demo',
    'filenameList' => ['example.png', 'example2.jpg']
];
$response = $stardots->deleteFile($params);
```

### Error Handling
```php
try {
    $response = $stardots->getSpaceList();
} catch (StarDots\StarDotsException $e) {
    echo "Error: " . $e->getMessage();
}
```

### Response Format
All API responses follow this format:
```php
[
    'code' => 200,
    'message' => 'Success',
    'requestId' => 'unique-request-id',
    'bool' => true,
    'ts' => 1640995200000,
    'data' => [
        // Response data
    ]
]
```

### Documentation  
[https://stardots.io/en/documentation/openapi](https://stardots.io/en/documentation/openapi)  

### Homepage  
[https://stardots.io](https://stardots.io)  