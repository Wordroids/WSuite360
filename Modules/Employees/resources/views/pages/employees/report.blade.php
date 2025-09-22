<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Employee Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin-bottom: 5px;
        }

        .footer {
            margin-top: 20px;
            text-align: right;
            font-size: 10px;
        }

        .logo {
            height: 50px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="header">
        @if (file_exists(public_path('storage/logo.png')))
            <img src="{{ public_path('storage/logo.png') }}" class="logo">
        @endif
        <h1>Employee Report</h1>
        <p>Generated on: {{ now()->format('d M Y H:i:s') }}</p>
    </div>

    @if (request()->has('department_id') && ($department = \App\Models\Department::find(request('department_id'))))
        <p><strong>Department:</strong> {{ $department->name }}</p>
    @endif

    @if (request()->has('designation_id') && ($designation = \App\Models\Designation::find(request('designation_id'))))
        <p><strong>Designation:</strong> {{ $designation->name }}</p>
    @endif

    @if (request()->has('status'))
        <p><strong>Status:</strong> {{ ucfirst(request('status')) }}</p>
    @endif

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Employee Code</th>
                <th>Name</th>
                <th>Department</th>
                <th>Designation</th>
                <th>Date of Joining</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $index => $employee)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $employee->employee_code }}</td>
                    <td>{{ $employee->full_name }}</td>
                    <td>{{ $employee->department->name }}</td>
                    <td>{{ $employee->designation->name ?? 'N/A' }}</td>
                    <td>{{ $employee->date_of_joining->format('d M Y') }}</td>
                    <td>{{ ucfirst($employee->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Total Employees: {{ $employees->count() }}</p>
        <p>Printed by: {{ Auth::user()->name }}</p>
    </div>
</body>

</html>
