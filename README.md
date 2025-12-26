# libphonenumber
google libphonenumber for E164 format

A PHP wrapper library for `giggsey/libphonenumber-for-php` providing a unified interface for phone number operations.

## Features

The `PhoneNumberWrapper` class provides the following functionality:

- **PhoneNumber Util** - Parse, format, validate, and get information about phone numbers
- **ShortNumber Info** - Validate and check short numbers
- **Phone Number Geolocation** - Get geographic location information for phone numbers
- **Phone Number to Carrier Mapping** - Identify carrier/operator for phone numbers
- **Phone Number to Timezone Mapping** - Get timezone information for phone numbers
- **Phone Number Matcher** - Find and extract phone numbers from text
- **As You Type Formatter** - Format phone numbers as users type

## Installation

```bash
composer require uktech/fh-libphonenumber
```

## Usage

```php
<?php

use Uktech\FhLibphonenumber\PhoneNumberWrapper;

$wrapper = new PhoneNumberWrapper();

// Parse a phone number
$phoneNumber = $wrapper->parse('+14155552671', 'US');

// Format in E164 format
$e164 = $wrapper->formatE164($phoneNumber); // +14155552671

// Validate phone number
if ($wrapper->isValidNumber($phoneNumber)) {
    // Get geolocation
    $location = $wrapper->getGeolocation($phoneNumber); // e.g., "California"
    
    // Get carrier
    $carrier = $wrapper->getCarrier($phoneNumber); // e.g., "Verizon"
    
    // Get timezones
    $timezones = $wrapper->getTimeZones($phoneNumber); // e.g., ["America/Los_Angeles"]
}

// Find phone numbers in text
$text = "Call me at +1-415-555-2671 or 020 7946 0958";
$matches = $wrapper->findNumbers($text, 'US');

// Format as you type
$formatted = $wrapper->formatAsYouType('14155552671', 'US'); // (415) 555-2671
```

## Docker Commands

### Docker Run (single container)
```bash
docker run -it --rm -v /Users/dev/workspace/projects/libphonenumber:/app -w /app composer bash
```

### Docker Compose
```bash
# Start container
docker-compose up -d

# Stop container
docker-compose down
```

composer init 
package name : uktech/fh-libphonenumber

..
..
composer dump-autoload
