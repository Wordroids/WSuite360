<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    public function index()
    {
        $tenants = Tenant::all();
        return view('central.tenants.index', compact('tenants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('central.tenants.create');
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'id' => 'required|string|max:255|regex:/^[a-zA-Z0-9_-]+$/|unique:tenants',
            'tier' => 'required|string|in:free,basic,pro,enterprise',
            'domain' => 'required|string|max:255|regex:/^[a-zA-Z0-9\._-]+$/|unique:domains',
        ]);

        $tenant = Tenant::create([
            'id' => $request->id,
            'name' => $request->name,
            'tier' => $request->tier
        ]);

        $tenant->domains()->create([
            'domain' => $request->domain
        ]);

        return redirect()->route('tenants.index')->with('success', 'Tenant created successfully!');
    }

    public function show(Tenant $tenant)
    {
        dd($tenant);
    }

    public function edit(Tenant $tenant)
    {
        return view('central.tenants.edit', compact('tenant'));
    }

    public function update(Request $request, Tenant $tenant)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'id' => 'required|string|max:255|regex:/^[a-zA-Z0-9_-]+$/|unique:tenants,id,' . $tenant->id,
            'tier' => 'required|string|in:free,basic,pro,enterprise',
            'domain' => 'required|string|max:255|regex:/^[a-zA-Z0-9\._-]+$/|unique:domains,domain,' . $tenant->domains()->first()->id,
        ]);

        $tenant->update([
            'id' => $request->id,
            'name' => $request->name,
            'tier' => $request->tier
        ]);

        $tenant->domains()->first()->update([
            'domain' => $request->domain
        ]);

        return redirect()->route('tenants.edit', compact('tenant'))->with('success', 'Tenant updated successfully!');
    }

    public function destroy(Tenant $tenant)
    {
        $tenant->delete();
        return redirect()->route('tenants.index')->with('success', 'Tenant deleted successfully!');
    }

}
