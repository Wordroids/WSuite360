<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\Company;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::with('company')->latest()->paginate(10);
        return view('pages.clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::all(); // Fetch all companies
        return view('pages.clients.create', compact('companies'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:clients,email|max:255',
            'phone'      => 'required|string|max:20',
            'address'    => 'required|string|max:500',
            'company_id' => 'required|exists:companies,id',
        ]);

        // Create Client
        Client::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'address'    => $request->address,
            'company_id' => $request->company_id,
        ]);

        // Redirect back with success message
        return redirect()->route('clients.index')->with('success', 'Client created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $client = Client::findOrFail($id);
        $companies = Company::all();
        return view('pages.clients.edit', compact('client', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     */
    // Update the client details
    public function update(Request $request, $id)
    {

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email,' . $id, // Allow the same email for this client
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:500',
            'company_id' => 'required|exists:companies,id',
        ]);

        $client = Client::findOrFail($id);
        $client->update($validatedData);


        return redirect()->route('clients.index')->with('success', 'Client updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $client = Client::findOrFail($id);


        $client->delete();


        return redirect()->route('clients.index')->with('success', 'Client deleted successfully!');
    }
}
