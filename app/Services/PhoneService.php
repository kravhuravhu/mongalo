<?php

namespace App\Services;

class PhoneService
{
    /**
     * Format a phone number to E.164 format
     */
    public function formatE164(string $phone): string
    {
        // Remove all non-numeric characters
        $cleaned = preg_replace('/[^0-9]/', '', $phone);
        
        // SA numbers
        if (strlen($cleaned) === 10 && substr($cleaned, 0, 2) === '07') {
            return '+27' . substr($cleaned, 1);
        }
        
        // Already has code (27)
        if (strlen($cleaned) === 11 && substr($cleaned, 0, 2) === '27') {
            return '+' . $cleaned;
        }
        
        // International format already
        if (substr($phone, 0, 1) === '+') {
            return $phone;
        }
        
        return $phone;
    }

    /**
     * Format for display (human-readable)
     */
    public function formatDisplay(string $phone): string
    {
        $formatted = $this->formatE164($phone);
        
        // if SA number, format as +27 71 461 1401
        if (strpos($formatted, '+27') === 0) {
            $digits = preg_replace('/[^0-9]/', '', $formatted);
            if (strlen($digits) === 11) {
                return '+27 ' . substr($digits, 2, 2) . ' ' . substr($digits, 4, 3) . ' ' . substr($digits, 7, 4);
            }
        }
        
        return $formatted;
    }

    /**
     * Validate South African phone number
     */
    public function isValidSA(string $phone): bool
    {
        $cleaned = preg_replace('/[^0-9]/', '', $phone);
        
        // Check if it's a valid SA number
        if (strlen($cleaned) === 10 && preg_match('/^(0[6-8]|04|03|01)/', $cleaned)) {
            return true;
        }
        
        // Check if it has code
        if (strlen($cleaned) === 11 && substr($cleaned, 0, 2) === '27') {
            $local = substr($cleaned, 2);
            if (preg_match('/^[6-8][0-9]{8}$/', $local) || preg_match('/^[34][0-9]{8}$/', $local)) {
                return true;
            }
        }
        
        return false;
    }
}