<?php

namespace App\Http\Controllers;

use App\Models\EmployeeDocument;
use App\Models\EmployeeProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EmployeeDocumentController extends Controller
{
    public function index(EmployeeProfile $employee)
    {
        $documents = $employee->documents()->paginate(10);

        return view('pages.employees.documents.index', compact('employee', 'documents'));
    }

    public function create(EmployeeProfile $employee)
    {
        return view('pages.employees.documents.create', compact('employee'));
    }

    public function store(Request $request, EmployeeProfile $employee)
    {
        $request->validate([
            'document_type' => 'required|string|max:100',
            'document' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048',
            'description' => 'nullable|string',
        ]);

        $file = $request->file('document');
        $path = $file->store('employee_documents');

        EmployeeDocument::create([
            'employee_id' => $employee->id,
            'document_type' => $request->document_type,
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $path,
            'mime_type' => $file->getClientMimeType(),
            'file_size' => $file->getSize(),
            'description' => $request->description,
            'uploaded_by' => Auth::id(),
        ]);

        return redirect()->route('employees.documents.index', $employee)
            ->with('success', 'Document uploaded successfully.');
    }

    public function show(EmployeeProfile $employee, EmployeeDocument $document)
    {
        return Storage::download($document->file_path, $document->file_name);
    }

    public function destroy(EmployeeProfile $employee, EmployeeDocument $document)
    {
        Storage::delete($document->file_path);
        $document->delete();

        return redirect()->route('employees.documents.index', $employee)
            ->with('success', 'Document deleted successfully.');
    }
}
