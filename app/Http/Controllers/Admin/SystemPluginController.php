<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Setting;

class SystemPluginController extends Controller
{
    private $cspFields = [
        'base_uri', 'script_src', 'style_src', 'img_src',
        'connect_src', 'frame_src', 'font_src', 'media_src',
        'object_src', 'manifest_src', 'worker_src', 'frame_ancestors'
    ];

    private $cspDefaults = [
        'base_uri' => "'self'",
        'script_src' => "'self' 'unsafe-inline' 'unsafe-eval' *.google.com *.gstatic.com",
        'style_src' => "'self' 'unsafe-inline' *.bootstrapcdn.com *.googleapis.com",
        'img_src' => "'self' data:",
        'connect_src' => "'self' slims.web.id",
        'frame_src' => "'self' *.google.com",
        'font_src' => "'self' *.gstatic.com",
        'media_src' => "'self'",
        'object_src' => "'self'",
        'manifest_src' => "'self'",
        'worker_src' => "'self'",
        'frame_ancestors' => "'self'",
    ];

    public function cspIndex()
    {
        $keys = array_map(fn($k) => 'csp_' . $k, $this->cspFields);
        $settings = Setting::whereIn('setting_name', $keys)->pluck('setting_value', 'setting_name')->toArray();

        $csp = [];
        foreach ($this->cspFields as $field) {
            $csp[$field] = $settings['csp_' . $field] ?? $this->cspDefaults[$field];
        }

        return view('admin.sistem.plugin.csp', compact('csp'));
    }

    public function cspStore(Request $request)
    {
        foreach ($this->cspFields as $key) {
            $settingName = 'csp_' . $key;
            $settingValue = $request->input($key, "'self'");

            Setting::updateOrCreate(
                ['setting_name' => $settingName],
                ['setting_value' => $settingValue]
            );
        }

        return back()->with('success', 'Pengaturan Content Security Policy (CSP) berhasil disimpan.');
    }
}
