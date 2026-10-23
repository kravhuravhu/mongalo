<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SettingController extends Controller
{
    // ─── SHOW ───
    public function index()
    {
        return view('admin.settings.index');
    }

    // ─── SAVE ───
    public function update(Request $request)
    {
        $request->validate([
            'site_currency_symbol' => 'nullable|string|max:10',
            'site_currency_code'   => 'nullable|string|max:10',
            'site_support_email'   => 'nullable|email|max:180',
            'site_support_whatsapp'=> 'nullable|string|max:40',
            'site_delivery_notice' => 'nullable|string|max:500',
        ]);

        // ─── FORM FIELD NAME  →  DB SETTING KEY ───
        // ─── (underscores in HTML, dots in the database) ───
        $map = [
            // ─── GENERAL ───
            'site_currency_symbol'   => ['key' => 'site.currency_symbol',   'type' => 'string',  'group' => 'general'],
            'site_currency_code'     => ['key' => 'site.currency_code',     'type' => 'string',  'group' => 'general'],
            'site_support_email'     => ['key' => 'site.support_email',     'type' => 'string',  'group' => 'general'],
            'site_support_whatsapp'  => ['key' => 'site.support_whatsapp',  'type' => 'string',  'group' => 'general'],
            'site_delivery_notice'   => ['key' => 'site.delivery_notice',   'type' => 'text',    'group' => 'general'],

            // ─── SHIPPING REGIONS 1-4 ───
            'shipping_region_1_key'   => ['key' => 'shipping.region_1_key',   'type' => 'string', 'group' => 'shipping'],
            'shipping_region_1_label' => ['key' => 'shipping.region_1_label', 'type' => 'string', 'group' => 'shipping'],
            'shipping_region_1_fee'   => ['key' => 'shipping.region_1_fee',   'type' => 'number', 'group' => 'shipping'],
            'shipping_region_1_days'  => ['key' => 'shipping.region_1_days',  'type' => 'string', 'group' => 'shipping'],

            'shipping_region_2_key'   => ['key' => 'shipping.region_2_key',   'type' => 'string', 'group' => 'shipping'],
            'shipping_region_2_label' => ['key' => 'shipping.region_2_label', 'type' => 'string', 'group' => 'shipping'],
            'shipping_region_2_fee'   => ['key' => 'shipping.region_2_fee',   'type' => 'number', 'group' => 'shipping'],
            'shipping_region_2_days'  => ['key' => 'shipping.region_2_days',  'type' => 'string', 'group' => 'shipping'],

            'shipping_region_3_key'   => ['key' => 'shipping.region_3_key',   'type' => 'string', 'group' => 'shipping'],
            'shipping_region_3_label' => ['key' => 'shipping.region_3_label', 'type' => 'string', 'group' => 'shipping'],
            'shipping_region_3_fee'   => ['key' => 'shipping.region_3_fee',   'type' => 'number', 'group' => 'shipping'],
            'shipping_region_3_days'  => ['key' => 'shipping.region_3_days',  'type' => 'string', 'group' => 'shipping'],

            'shipping_region_4_key'   => ['key' => 'shipping.region_4_key',   'type' => 'string', 'group' => 'shipping'],
            'shipping_region_4_label' => ['key' => 'shipping.region_4_label', 'type' => 'string', 'group' => 'shipping'],
            'shipping_region_4_fee'   => ['key' => 'shipping.region_4_fee',   'type' => 'number', 'group' => 'shipping'],
            'shipping_region_4_days'  => ['key' => 'shipping.region_4_days',  'type' => 'string', 'group' => 'shipping'],

            // ─── FREE RESOURCES POLICY ───
            'resources_hardcopy_enabled' => ['key' => 'resources.hardcopy_enabled', 'type' => 'boolean', 'group' => 'resources'],
            'resources_hardcopy_paid'    => ['key' => 'resources.hardcopy_paid',    'type' => 'boolean', 'group' => 'resources'],
            'resources_hardcopy_fee'     => ['key' => 'resources.hardcopy_fee',     'type' => 'number',  'group' => 'resources'],
            'resources_hardcopy_note'    => ['key' => 'resources.hardcopy_note',    'type' => 'text',    'group' => 'resources'],

            // ─── BOOKS POLICY ───
            'books_hardcopy_global_on'        => ['key' => 'books.hardcopy_global_on',        'type' => 'boolean', 'group' => 'books'],
            'books_hardcopy_includes_digital' => ['key' => 'books.hardcopy_includes_digital', 'type' => 'boolean', 'group' => 'books'],
        ];

        // ─── CHECKBOX FIELDS ───
        $booleanFields = [
            'resources_hardcopy_enabled',
            'resources_hardcopy_paid',
            'books_hardcopy_global_on',
            'books_hardcopy_includes_digital',
        ];

        $payload = [];

        foreach ($map as $field => $meta) {
            if (in_array($field, $booleanFields, true)) {
                $payload[$meta['key']] = [
                    'value' => $request->has($field) ? '1' : '0',
                    'type'  => 'boolean',
                    'group' => $meta['group'],
                ];
            } else {
                $payload[$meta['key']] = [
                    'value' => (string) $request->input($field, ''),
                    'type'  => $meta['type'],
                    'group' => $meta['group'],
                ];
            }
        }

        Setting::setMany($payload);

        Log::info('Settings updated by admin', [
            'admin_id'   => session('admin_id'),
            'admin_name' => session('admin_name'),
            'ip'         => $request->ip(),
        ]);

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Settings saved successfully.');
    }
}