<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = Company::latest()->paginate(10);
        return view('pages.companies.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.companies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:companies,email|max:255',
            'logo'     => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // Allow images only
            'website'  => 'nullable|url|max:255',
        ]);

        // Handle File Upload (if provided)
        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
        }

        // Create Company
        Company::create([
            'name'    => $request->name,
            'email'   => $request->email,
            'logo'    => $logoPath,
            'website' => $request->website,
        ]);

        // Redirect back with success message
        return redirect()->route('companies.index')->with('success', 'Company created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        //
    }

    //Update a Company
    public function edit($id)
    {
        $company = Company::findOrFail($id);
        return view('pages.companies.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     */



    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'logo' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);

        $company = Company::findOrFail($id);

        $company->name = $request->input('name');
        $company->email = $request->input('email');
        $company->website = $request->input('website');

        // Handle logo upload if provided
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
            $company->logo = $logoPath;
        }
        $company->save();

        return redirect()->route('companies.index')->with('success', 'Company updated successfully!');
    }


    //Delete a Company
    public function destroy($id)
    {

        $company = Company::findOrFail($id);


        $company->delete();


        return redirect()->route('companies.index')->with('success', 'Company deleted successfully!');
    }
}
