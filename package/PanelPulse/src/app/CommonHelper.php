<?php

namespace Kartikey\PanelPulse\app;

use Kartikey\PanelPulse\Services\GetCountry;

class CommonHelper
{
    function getCountryList()
    {
        return $result = (new GetCountry)->countryList();
    }

    // Helper function to add URLs with unique IDs
    function addUrlsWithIds($existingFiles, $newFiles) {
        $timestamp = now()->timestamp;

        // Normalize existing files: ensure all have keys
        $normalizedExistingFiles = [];
        foreach ($existingFiles as $key => $value) {
            if (is_array($value)) {
                // Already keyed: keep as-is
                $normalizedExistingFiles[$key] = $value;
            } elseif (is_string($value)) {
                // Not keyed: assign a key
                $normalizedExistingFiles[$timestamp . '_' . uniqid()] = $value;
            }
        }

        // Add new files with unique keys
        $newFileData = [];
        foreach ($newFiles as $file) {
            $newFileData[$timestamp . '_' . uniqid()] = $file;
        }

        // Merge existing and new files
        return array_merge($normalizedExistingFiles, $newFileData);
    }

    function price($price)
    {
        $formattedPrice = number_format((float)$price, 2, ',', '.');
        return '€'.$formattedPrice;
    }

    function encryptValue($value)
    {
        $secretKey = 'KT-24';
        $method = 'AES-128-CBC'; // Using AES encryption
        $iv = substr(hash('sha256', $secretKey), 0, 16); // Initialization vector

        $encrypted = openssl_encrypt($value, $method, $secretKey, 0, $iv);
        return base64_encode($encrypted); // Encoding to make it URL safe
    }

    function decryptValue($encryptedValue)
    {
        $secretKey = 'KT-24';

        $method = 'AES-128-CBC';
        $iv = substr(hash('sha256', $secretKey), 0, 16); // Same IV used for encryption
        $decoded = base64_decode($encryptedValue);
        return openssl_decrypt($decoded, $method, $secretKey, 0, $iv);
    }
    function formatDate($date, $format = 'Y-m-d H:i:s')
    {
        $dateTime = new \DateTime($date);
        return $dateTime->format($format);
    }



    function dateFormate($date)
    {
        echo date_format($date, 'd F Y');
        echo ' at ';
        echo date_format($date, 'h:i a');
    }


    public function getUserAddress($address)
    {

        if (is_array($address)) {
            // Handle array case (if applicable)
            $addressParts = [
                $address['Name'] ?? '',
                $address['street'] ?? '',
                $address['address'] ?? '',
                $address['city'] ?? '',
                $address['state'] ?? '',
                $address['postcode'] ?? '',
                $address['country'] ?? '',
                $address['phone'] ?? ''            ];
        } else {
            // Handle object case
            $addressParts = [
                $address->Name ?? '',
                $address->street ?? '',
                $address->address ?? '',
                $address->city ?? '',
                $address->state ?? '',
                $address->postcode ?? '',
                $address->country ?? '',
                $address->phone ?? ''
            ];
        }

        // Filter out empty or null values
        $filteredAddressParts = array_filter($addressParts, function ($part) {
            return !empty($part);
        });
        // Join the remaining parts with ', '
        return implode(', ', $filteredAddressParts) . '.';
    }
}
