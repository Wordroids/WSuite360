<?php

namespace App\Http\Controllers;

use App\Models\CompanySettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompanySettingController extends Controller
{

    public function companySettings()
    {
        $company = CompanySettings::first(); // Assuming only one record exists
        return view('pages.settings.company_settings.index', compact('company'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'nullable|email|max:255',
            'phone'       => 'nullable|string|max:255',
            'address'     => 'nullable|string',
            'vat_number'  => 'nullable|string|max:255',
            'logo'        => 'nullable|image|max:2048', // max 2MB
        ]);

        $company = CompanySettings::first(); // Single record assumption

        if (!$company) {
            $company = new CompanySettings();
        }

        $company->name        = $request->name;
        $company->email       = $request->email;
        $company->phone       = $request->phone;
        $company->address     = $request->address;
        $company->vat_number  = $request->vat_number;

        if ($request->hasFile('logo')) {
            // Delete old logo if exists in both locations
            if ($company->logo && Storage::disk('public')->exists($company->logo)) {
                Storage::disk('public')->delete($company->logo);

                $publicPath = public_path($company->logo);
                if (file_exists($publicPath)) {
                    unlink($publicPath);
                }
            }

            // Store in 'storage/app/public/uploads/company_logos'
            $path = $request->file('logo')->store('uploads/company_logos', 'public');
            $company->logo = $path;

            // Also copy it to 'public/uploads/company_logos'
            $sourcePath = storage_path("app/public/{$path}");
            $destinationPath = public_path($path);
            @mkdir(dirname($destinationPath), 0777, true); // Ensure directory exists
            copy($sourcePath, $destinationPath);
        }

        $company->save();

        return redirect()->route('company.settings')->with('success', 'Company settings updated successfully.');
    }
}
