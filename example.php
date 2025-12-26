<?php

require __DIR__ . '/vendor/autoload.php';

use Uktech\FhLibphonenumber\PhoneNumberWrapper;

// Initialize wrapper
$wrapper = new PhoneNumberWrapper();

echo "=== PhoneNumber Wrapper Examples ===\n\n";

// Example 1: Parse and format phone number
echo "1. Parse and Format:\n";
$phoneNumber = $wrapper->parse('+14155552671', 'US');
if ($phoneNumber) {
    echo "   E164 Format: " . $wrapper->formatE164($phoneNumber) . "\n";
    echo "   International: " . $wrapper->formatInternational($phoneNumber) . "\n";
    echo "   National: " . $wrapper->formatNational($phoneNumber) . "\n";
    echo "   Valid: " . ($wrapper->isValidNumber($phoneNumber) ? 'Yes' : 'No') . "\n";
    echo "   Type: " . $wrapper->getNumberType($phoneNumber) . "\n";
}
echo "\n";

// Example 2: Geolocation
echo "2. Geolocation:\n";
if ($phoneNumber) {
    $location = $wrapper->getGeolocation($phoneNumber, 'en');
    echo "   Location: " . ($location ?: 'Not available') . "\n";
}
echo "\n";

// Example 3: Carrier Mapping
echo "3. Carrier Mapping:\n";
if ($phoneNumber) {
    $carrier = $wrapper->getCarrier($phoneNumber, 'en');
    echo "   Carrier: " . ($carrier ?: 'Not available') . "\n";
}
echo "\n";

// Example 4: Timezone Mapping
echo "4. Timezone Mapping:\n";
if ($phoneNumber) {
    $timezones = $wrapper->getTimeZones($phoneNumber);
    echo "   Timezones: " . (count($timezones) > 0 ? implode(', ', $timezones) : 'Not available') . "\n";
}
echo "\n";

// Example 5: Phone Number Matcher
echo "5. Phone Number Matcher:\n";
$text = "Call me at +1-415-555-2671 or 020 7946 0958 or email me";
$matches = $wrapper->findNumbers($text, 'US');
echo "   Found " . count($matches) . " phone number(s) in text:\n";
foreach ($matches as $match) {
    echo "   - " . $match['raw_string'] . " (at position " . $match['start'] . "-" . $match['end'] . ")\n";
}
echo "\n";

// Example 6: As You Type Formatter
echo "6. As You Type Formatter:\n";
$formatted = $wrapper->formatAsYouType('14155552671', 'US');
echo "   Formatted: " . $formatted . "\n";
echo "\n";

// Example 7: Short Number Info
echo "7. Short Number Info:\n";
$shortNumber = $wrapper->parse('911', 'US');
if ($shortNumber) {
    echo "   Is possible short number: " . ($wrapper->isPossibleShortNumber($shortNumber) ? 'Yes' : 'No') . "\n";
    echo "   Is valid short number: " . ($wrapper->isValidShortNumber($shortNumber) ? 'Yes' : 'No') . "\n";
}
echo "\n";

echo "=== Examples Complete ===\n";

