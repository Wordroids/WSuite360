<?php

namespace Modules\Services\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Clients\Models\Client;
use Modules\Services\Models\Service;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        // Admins can see all service
        if ($user->role->name === 'admin') {
            $services = Service::with('client')->latest()->paginate(10);
        } else {
            $services = collect();
        }
        return view('services::pages.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::all();
        return view('services::pages.create', compact('clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'client_id'   => 'required|exists:clients,id',
            'start_date'  => 'nullable|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
            'budget'    => 'nullable|min:0',
        ]);

        Service::create($validated);

        return redirect()->route('services.index')->with('success', 'Service created successfully!');
    }

    /**
     * Show the specified resource.
     */
    public function show(Service $service)
    {
        return view('services::pages.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {

        $clients = Client::all();
        return view('services::pages.edit', compact('service', 'clients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'client_id' => 'required|exists:clients,id',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        $service->update($request->all());

        return redirect()->route('services.index')->with('success', 'Service updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $service = Service::findOrFail($id);

        $service->delete();

        return redirect()->route('services.index')->with('success', 'Service deleted successfully!');
    }
}
