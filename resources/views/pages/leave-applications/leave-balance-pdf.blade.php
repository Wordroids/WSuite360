<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Leave Balance Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .negative {
            color: red;
        }
    </style>
</head>

<body>
    <h1>Leave Balance Report</h1>
    <p>Generated on: {{ now()->format('d M Y H:i') }}</p>

    @if (
        (isset($filters['department_id']) && $filters['department_id']) ||
            (isset($filters['leave_type_id']) && $filters['leave_type_id']) ||
            (isset($filters['start_date']) && $filters['start_date']) ||
            (isset($filters['end_date']) && $filters['end_date']))
        <h3>Filters Applied:</h3>
        <ul>
            @if (isset($filters['department_id']) && $filters['department_id'])
                <li>Department: {{ $departmentName }}</li>
            @endif
            @if (isset($filters['leave_type_id']) && $filters['leave_type_id'])
                <li>Leave Type: {{ $leaveTypeName }}</li>
            @endif
            @if (isset($filters['start_date']) && $filters['start_date'])
                <li>From: {{ \Carbon\Carbon::parse($filters['start_date'])->format('d M Y') }}</li>
            @endif
            @if (isset($filters['end_date']) && $filters['end_date'])
                <li>To: {{ \Carbon\Carbon::parse($filters['end_date'])->format('d M Y') }}</li>
            @endif
        </ul>
    @endif

    <table>
        <thead>
            <tr>
                <th>Employee</th>
                <th>Department</th>
                <th>Leave Type</th>
                <th>Allocated</th>
                <th>Used</th>
                <th>Remaining</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $employee)
                @if ($employee->leave_breakdown && $employee->leave_breakdown->count() > 0)
                    @foreach ($employee->leave_breakdown as $balance)
                        <tr>
                            <td>{{ $employee->full_name }}</td>
                            <td>{{ $employee->department->name ?? 'N/A' }}</td>
                            <td>{{ $balance['leave_type'] }}</td>
                            <td>{{ $balance['allocated'] }}</td>
                            <td>{{ $balance['used'] }}</td>
                            <td class="{{ $balance['remaining'] < 0 ? 'negative' : '' }}">{{ $balance['remaining'] }}
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6">No leave balance information available for {{ $employee->full_name }}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</body>

</html>
