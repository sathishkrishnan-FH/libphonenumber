<?php

namespace Uktech\FhLibphonenumber;

use libphonenumber\PhoneNumberUtil;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberType;
use libphonenumber\NumberParseException;
use libphonenumber\ShortNumberInfo;
use libphonenumber\geocoding\PhoneNumberOfflineGeocoder;
use libphonenumber\PhoneNumberToCarrierMapper;
use libphonenumber\PhoneNumberToTimeZonesMapper;
use libphonenumber\PhoneNumberMatcher;
use libphonenumber\AsYouTypeFormatter;
use libphonenumber\PhoneNumber;

/**
 * Wrapper class for giggsey/libphonenumber-for-php
 * 
 * Provides a unified interface for:
 * - PhoneNumber Util
 * - ShortNumber Info
 * - Phone Number Geolocation
 * - Phone Number to Carrier Mapping
 * - Phone Number to Timezone Mapping
 * - Phone Number Matcher
 * - As You Type Formatter
 */
class PhoneNumberWrapper
{
    private PhoneNumberUtil $phoneNumberUtil;
    private ShortNumberInfo $shortNumberInfo;
    private PhoneNumberOfflineGeocoder $geocoder;
    private PhoneNumberToCarrierMapper $carrierMapper;
    private PhoneNumberToTimeZonesMapper $timeZoneMapper;

    public function __construct()
    {
        $this->phoneNumberUtil = PhoneNumberUtil::getInstance();
        $this->shortNumberInfo = ShortNumberInfo::getInstance();
        $this->geocoder = PhoneNumberOfflineGeocoder::getInstance();
        $this->carrierMapper = PhoneNumberToCarrierMapper::getInstance();
        $this->timeZoneMapper = PhoneNumberToTimeZonesMapper::getInstance();
    }

    /**
     * PhoneNumber Util - Parse a phone number string
     * 
     * @param string $number The phone number to parse
     * @param string|null $defaultRegion The default region code (e.g., 'US', 'GB')
     * @return PhoneNumber|null Parsed phone number object or null on failure
     */
    public function parse(string $number, ?string $defaultRegion = null): ?PhoneNumber
    {
        try {
            return $this->phoneNumberUtil->parse($number, $defaultRegion);
        } catch (NumberParseException $e) {
            return null;
        }
    }

    /**
     * PhoneNumber Util - Format a phone number
     * 
     * @param PhoneNumber $phoneNumber The phone number object
     * @param PhoneNumberFormat $format Format constant (E164, INTERNATIONAL, NATIONAL, RFC3966)
     * @return string|null Formatted phone number or null on failure
     */
    public function format(PhoneNumber $phoneNumber, $format = PhoneNumberFormat::E164): ?string
    {
        try {
            return $this->phoneNumberUtil->format($phoneNumber, $format);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * PhoneNumber Util - Format phone number in E164 format
     * 
     * @param PhoneNumber $phoneNumber The phone number object
     * @return string|null E164 formatted phone number
     */
    public function formatE164(PhoneNumber $phoneNumber): ?string
    {
        return $this->format($phoneNumber, PhoneNumberFormat::E164);
    }

    /**
     * PhoneNumber Util - Format phone number in international format
     * 
     * @param PhoneNumber $phoneNumber The phone number object
     * @return string|null Internationally formatted phone number
     */
    public function formatInternational(PhoneNumber $phoneNumber): ?string
    {
        return $this->format($phoneNumber, PhoneNumberFormat::INTERNATIONAL);
    }

    /**
     * PhoneNumber Util - Format phone number in national format
     * 
     * @param PhoneNumber $phoneNumber The phone number object
     * @return string|null Nationally formatted phone number
     */
    public function formatNational(PhoneNumber $phoneNumber): ?string
    {
        return $this->format($phoneNumber, PhoneNumberFormat::NATIONAL);
    }

    /**
     * PhoneNumber Util - Check if a phone number is valid
     * 
     * @param PhoneNumber $phoneNumber The phone number object
     * @return bool True if valid, false otherwise
     */
    public function isValidNumber(PhoneNumber $phoneNumber): bool
    {
        return $this->phoneNumberUtil->isValidNumber($phoneNumber);
    }

    /**
     * PhoneNumber Util - Check if a phone number is valid for a specific region
     * 
     * @param PhoneNumber $phoneNumber The phone number object
     * @param string $regionCode The region code to validate against
     * @return bool True if valid for the region, false otherwise
     */
    public function isValidNumberForRegion(PhoneNumber $phoneNumber, string $regionCode): bool
    {
        return $this->phoneNumberUtil->isValidNumberForRegion($phoneNumber, $regionCode);
    }

    /**
     * PhoneNumber Util - Get the type of a phone number
     * 
     * @param PhoneNumber $phoneNumber The phone number object
     * @return PhoneNumberType Phone number type constant (FIXED_LINE, MOBILE, etc.)
     */
    public function getNumberType(PhoneNumber $phoneNumber): PhoneNumberType
    {
        return $this->phoneNumberUtil->getNumberType($phoneNumber);
    }

    /**
     * PhoneNumber Util - Check if number is possible (quick check)
     * 
     * @param string $number The phone number string
     * @param string|null $defaultRegion The default region code
     * @return bool True if number is possible
     */
    public function isPossibleNumber(string $number, ?string $defaultRegion = null): bool
    {
        try {
            $phoneNumber = $this->phoneNumberUtil->parse($number, $defaultRegion);
            return $this->phoneNumberUtil->isPossibleNumber($phoneNumber);
        } catch (NumberParseException $e) {
            return false;
        }
    }

    /**
     * PhoneNumber Util - Get country code from phone number
     * 
     * @param PhoneNumber $phoneNumber The phone number object
     * @return int|null Country code or null
     */
    public function getCountryCode(PhoneNumber $phoneNumber): ?int
    {
        return $phoneNumber->getCountryCode();
    }

    /**
     * PhoneNumber Util - Get region code for country code
     * 
     * @param int $countryCode The country code
     * @return string|null Region code or null
     */
    public function getRegionCodeForCountryCode(int $countryCode): ?string
    {
        return $this->phoneNumberUtil->getRegionCodeForCountryCode($countryCode);
    }

    /**
     * ShortNumber Info - Check if number is a possible short number
     * 
     * @param PhoneNumber $phoneNumber The phone number object
     * @return bool True if possible short number
     */
    public function isPossibleShortNumber(PhoneNumber $phoneNumber): bool
    {
        return $this->shortNumberInfo->isPossibleShortNumber($phoneNumber);
    }

    /**
     * ShortNumber Info - Check if number is a valid short number
     * 
     * @param PhoneNumber $phoneNumber The phone number object
     * @return bool True if valid short number
     */
    public function isValidShortNumber(PhoneNumber $phoneNumber): bool
    {
        return $this->shortNumberInfo->isValidShortNumber($phoneNumber);
    }

    /**
     * ShortNumber Info - Check if number is a valid short number for region
     * 
     * @param PhoneNumber $phoneNumber The phone number object
     * @param string $regionCode The region code
     * @return bool True if valid short number for region
     */
    public function isValidShortNumberForRegion(PhoneNumber $phoneNumber, string $regionCode): bool
    {
        return $this->shortNumberInfo->isValidShortNumberForRegion($phoneNumber, $regionCode);
    }

    /**
     * Phone Number Geolocation - Get geographic description for a phone number
     * 
     * @param PhoneNumber $phoneNumber The phone number object
     * @param string $locale Language locale (e.g., 'en', 'en_US')
     * @return string|null Geographic description or null
     */
    public function getGeolocation(PhoneNumber $phoneNumber, string $locale = 'en'): ?string
    {
        try {
            return $this->geocoder->getDescriptionForNumber($phoneNumber, $locale);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Phone Number to Carrier Mapping - Get carrier name for a phone number
     * 
     * @param PhoneNumber $phoneNumber The phone number object
     * @param string $locale Language locale (e.g., 'en', 'en_US')
     * @return string|null Carrier name or null
     */
    public function getCarrier(PhoneNumber $phoneNumber, string $locale = 'en'): ?string
    {
        try {
            return $this->carrierMapper->getNameForNumber($phoneNumber, $locale);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Phone Number to Timezone Mapping - Get timezones for a phone number
     * 
     * @param PhoneNumber $phoneNumber The phone number object
     * @return array Array of timezone identifiers (e.g., ['America/New_York'])
     */
    public function getTimeZones(PhoneNumber $phoneNumber): array
    {
        try {
            return $this->timeZoneMapper->getTimeZonesForNumber($phoneNumber);
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Phone Number Matcher - Find all phone numbers in a text string
     * 
     * @param string $text The text to search in
     * @param string|null $defaultRegion The default region code
     * @param int $leniency Matching leniency (VALID, POSSIBLE, EXACT_GROUPING, etc.)
     * @return array Array of matched phone number objects
     */
    public function findNumbers(string $text, ?string $defaultRegion = null, int $leniency = PhoneNumberMatcher::Leniency::VALID): array
    {
        $matches = [];
        try {
            $matcher = $this->phoneNumberUtil->findNumbers($text, $defaultRegion, $leniency);
            foreach ($matcher as $match) {
                $matches[] = [
                    'number' => $match->number(),
                    'raw_string' => $match->rawString(),
                    'start' => $match->start(),
                    'end' => $match->end(),
                ];
            }
        } catch (\Exception $e) {
            // Return empty array on error
        }
        return $matches;
    }

    /**
     * Phone Number Matcher - Find all phone numbers in a text string (returns phone number objects only)
     * 
     * @param string $text The text to search in
     * @param string|null $defaultRegion The default region code
     * @return array Array of phone number objects
     */
    public function findPhoneNumbers(string $text, ?string $defaultRegion = null): array
    {
        $matches = [];
        try {
            $matcher = $this->phoneNumberUtil->findNumbers($text, $defaultRegion);
            foreach ($matcher as $match) {
                $matches[] = $match->number();
            }
        } catch (\Exception $e) {
            // Return empty array on error
        }
        return $matches;
    }

    /**
     * As You Type Formatter - Format phone number as user types
     * 
     * @param string $regionCode The region code (e.g., 'US', 'GB')
     * @return AsYouTypeFormatter The formatter instance
     */
    public function getAsYouTypeFormatter(string $regionCode): AsYouTypeFormatter
    {
        return $this->phoneNumberUtil->getAsYouTypeFormatter($regionCode);
    }

    /**
     * As You Type Formatter - Format a complete number as user types
     * 
     * @param string $number The phone number string
     * @param string $regionCode The region code (e.g., 'US', 'GB')
     * @return string Formatted phone number as user types
     */
    public function formatAsYouType(string $number, string $regionCode): string
    {
        $formatter = $this->getAsYouTypeFormatter($regionCode);
        $result = '';
        foreach (str_split($number) as $digit) {
            if (ctype_digit($digit)) {
                $result = $formatter->inputDigit($digit);
            }
        }
        return $result;
    }

    /**
     * Get the underlying PhoneNumberUtil instance
     * 
     * @return PhoneNumberUtil
     */
    public function getPhoneNumberUtil(): PhoneNumberUtil
    {
        return $this->phoneNumberUtil;
    }

    /**
     * Get the underlying ShortNumberInfo instance
     * 
     * @return ShortNumberInfo
     */
    public function getShortNumberInfo(): ShortNumberInfo
    {
        return $this->shortNumberInfo;
    }

    /**
     * Get the underlying PhoneNumberOfflineGeocoder instance
     * 
     * @return PhoneNumberOfflineGeocoder
     */
    public function getGeocoder(): PhoneNumberOfflineGeocoder
    {
        return $this->geocoder;
    }

    /**
     * Get the underlying PhoneNumberToCarrierMapper instance
     * 
     * @return PhoneNumberToCarrierMapper
     */
    public function getCarrierMapper(): PhoneNumberToCarrierMapper
    {
        return $this->carrierMapper;
    }

    /**
     * Get the underlying PhoneNumberToTimeZonesMapper instance
     * 
     * @return PhoneNumberToTimeZonesMapper
     */
    public function getTimeZoneMapper(): PhoneNumberToTimeZonesMapper
    {
        return $this->timeZoneMapper;
    }
}

