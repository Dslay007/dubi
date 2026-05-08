<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function itemPattern()
    {
        $setting = Setting::where('setting_name', 'batch_item_code_pattern')->first();
        $patterns = [];
        if ($setting && !empty($setting->setting_value)) {
            $patterns = @unserialize($setting->setting_value) ?: [];
        }
        return view('admin.setting.item_pattern', compact('patterns'));
    }

    public function storeItemPattern(Request $request)
    {
        $validated = $request->validate([
            'pattern' => 'required|string|max:255',
        ]);

        $setting = Setting::firstOrNew(['setting_name' => 'batch_item_code_pattern']);
        $patterns = [];
        if (!empty($setting->setting_value)) {
            $patterns = @unserialize($setting->setting_value) ?: [];
        }
        
        if (!in_array($validated['pattern'], $patterns)) {
            $patterns[] = $validated['pattern'];
        }
        
        $setting->setting_value = serialize($patterns);
        $setting->save();

        return back()->with('success', 'Pola kode eksemplar berhasil ditambahkan.');
    }

    public function destroyItemPattern(Request $request)
    {
        $setting = Setting::where('setting_name', 'batch_item_code_pattern')->first();
        if ($setting) {
            $patterns = @unserialize($setting->setting_value) ?: [];
            $patternToDelete = $request->input('pattern');
            
            if (($key = array_search($patternToDelete, $patterns)) !== false) {
                unset($patterns[$key]);
                $setting->setting_value = serialize(array_values($patterns));
                $setting->save();
            }
        }
        return back()->with('success', 'Pola kode eksemplar berhasil dihapus.');
    }
}
