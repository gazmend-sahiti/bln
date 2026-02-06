# Ideogram Image Generation Example

This is a simple PHP example demonstrating how to generate an image using the Ideogram API.

## Requirements

* PHP 8+
* Composer

## Installation

1. Install dependencies via Composer:

```bash
composer require gazmend-sahiti/bln
```

2. Make sure `vendor/autoload.php` is included in your project.

## Usage

```php
<?php

use GazmendS\BLN\Ideogram;

require 'vendor/autoload.php';

// Replace with your actual API key
$apiKey = 'YOUR_API_KEY_HERE';

$ideogram = Ideogram::make($apiKey);

// $prompt = 'black pretty eyes';
$prompt = 'an Asian street bar in mid July with neon signs, 2 people sitting at stools, and bartenders serving drinks';

$image = $ideogram->generateImage($prompt);

if ($image['success']) {
    echo '<img src="'.$image['data']['url'].'" />';
}
```

## Notes

* Replace `'YOUR_API_KEY_HERE'` with your actual Ideogram API key.
* The `$image` variable contains the needed data.
