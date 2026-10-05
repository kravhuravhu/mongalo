<?php

use App\Models\Setting;

if (!function_exists('settings')) {
    // ─── GET ONE SETTING ───
    function settings(string $key, $default = null)
    {
        return Setting::get($key, $default);
    }
}

if (!function_exists('shipping_regions')) {
    // ─── BUILD SHIPPING REGIONS FROM SETTINGS ───
    function shipping_regions(): array
    {
        $regions = [];

        for ($i = 1; $i <= 4; $i++) {
            $key   = settings("shipping.region_{$i}_key");
            $label = settings("shipping.region_{$i}_label");
            $fee   = settings("shipping.region_{$i}_fee");

            if (!$key || !$label) {
                continue;
            }

            $regions[$key] = [
                'label' => $label,
                'fee'   => (float) ($fee ?? 0),
                'days'  => settings("shipping.region_{$i}_days", ''),
            ];
        }

        // ─── FALL BACK TO CONFIG IF NOTHING CONFIGURED ───
        if (empty($regions)) {
            return config('shop.shipping', []);
        }

        return $regions;
    }
}

if (!function_exists('currency_symbol')) {
    // ─── GET CURRENCY SYMBOL ───
    function currency_symbol(): string
    {
        return settings('site.currency_symbol', 'R');
    }
}

if (!function_exists('money')) {
    // ─── FORMAT MONEY WITH CURRENT SYMBOL ───
    function money($amount, bool $withSpace = true): string
    {
        $symbol = currency_symbol();
        $formatted = number_format((float) $amount, 2);
        return $withSpace ? "{$symbol} {$formatted}" : "{$symbol}{$formatted}";
    }
}