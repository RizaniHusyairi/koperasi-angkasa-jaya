<?php

namespace App\Http\Controllers\AdminMiniMarket;

use App\Http\Controllers\Controller;
use App\Models\MiniMarketSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvoiceSettingController extends Controller
{
    public function index()
    {
        $setting = MiniMarketSetting::first();
        return view('admin-mini-market.settings.invoice.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'company_address' => 'nullable|string',
            'company_email' => 'nullable|email',
            'company_phone' => 'nullable|string',
            'company_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $setting = MiniMarketSetting::first();

        if (!$setting) {
            $setting = new MiniMarketSetting();
        }

        $setting->company_name = $request->company_name;
        $setting->company_address = $request->company_address;
        $setting->company_email = $request->company_email;
        $setting->company_phone = $request->company_phone;

        if ($request->hasFile('company_logo')) {
            // Delete old logo if exists
            if ($setting->company_logo && Storage::disk('public')->exists($setting->company_logo)) {
                Storage::disk('public')->delete($setting->company_logo);
            }

            $path = $request->file('company_logo')->store('company-logos', 'public');
            $setting->company_logo = $path;
        }

        $setting->save();

        return redirect()->route('admin-mini-market.settings.invoice.index')->with('success', 'Pengaturan invoice berhasil disimpan.');
    }
}
