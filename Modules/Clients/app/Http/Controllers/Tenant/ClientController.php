<?php


namespace Modules\Clients\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;

use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Modules\Clients\Models\Client;
class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::paginate(10);
        return view('clients::pages.clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clients::pages.clients.create');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate request
        $request->validate([
            'name'             => 'required|string|max:255',
            'email'            => 'required|email|unique:clients,email|max:255',
            'phone'            => 'required|string|max:20',
            'address'          => 'required|string|max:500',
            'website'          => 'nullable|url|max:255',
            'billing_currency' => 'nullable|string|max:10',
            'logo'             => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048', // Max 2MB
        ]);

        // Handle logo upload (if exists)
        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('client-logos', 'public');
        }

        // Create Client
        Client::create([
            'name'             => $request->name,
            'email'            => $request->email,
            'phone'            => $request->phone,
            'address'          => $request->address,
            'website'          => $request->website,
            'billing_currency' => $request->billing_currency,
            'logo'             => $logoPath,
        ]);

        // Redirect back with success message
        return redirect()->route('clients.index')->with('success', 'Client created successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {

        $client->load(['subscriptions' => function ($query) {
            $query->with('project')
                ->orderBy('created_at', 'desc');
        }]);

        return view('clients::pages.clients.show', [
            'client' => $client
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $client = Client::findOrFail($id);
        return view('clients::pages.clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    // Update the client details
    public function update(Request $request, $id)
    {
        // Find client
        $client = Client::findOrFail($id);
        // Validate input
        $validatedData = $request->validate([
            'name'             => 'required|string|max:255',
            'email'            => 'required|email|unique:clients,email,' . $id,
            'phone'            => 'required|string|max:15',
            'address'          => 'required|string|max:500',
            'website'          => 'nullable|url|max:255',
            'billing_currency' => 'nullable|string|max:10',
            'logo'             => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);
        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if it exists
            if ($client->logo && Storage::disk('public')->exists($client->logo)) {
                Storage::disk('public')->delete($client->logo);
            }
            // Upload new logo to tenant-aware public disk
            $validatedData['logo'] = $request->file('logo')->store('client-logos', 'public');
        }
        // Update client
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
