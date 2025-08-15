<?php

// app/Http/Controllers/DesignationController.php
namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Designation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DesignationController extends Controller
{
    public function index(Department $department)
    {
        $designations = $department->designations()->withCount('employees')->paginate(10);
        return view('pages.departments.designations.index', compact('department', 'designations'));
    }

    public function create(Department $department)
    {
        return view('pages.departments.designations.create', compact('department'));
    }

    public function store(Request $request, Department $department)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('designations')->where('department_id', $department->id)
            ],
            'description' => 'nullable|string',
        ]);

        $department->designations()->create($validated);

        return redirect()->route('departments.designations.index', $department)
            ->with('success', 'Designation created successfully.');
    }

    public function edit(Department $department, Designation $designation)
    {
        return view('pages.departments.designations.edit', compact('department', 'designation'));
    }

    public function update(Request $request, Department $department, Designation $designation)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('designations')
                    ->where('department_id', $department->id)
                    ->ignore($designation->id)
            ],
            'description' => 'nullable|string',
        ]);

        $designation->update($validated);

        return redirect()->route('departments.designations.index', $department)
            ->with('success', 'Designation updated successfully.');
    }

    public function destroy(Department $department, Designation $designation)
    {
        if ($designation->employees()->count() > 0) {
            return redirect()->route('departments.designations.index', $department)
                ->with('error', 'Cannot delete designation with assigned employees.');
        }

        $designation->delete();

        return redirect()->route('departments.designations.index', $department)
            ->with('success', 'Designation deleted successfully.');
    }
}
