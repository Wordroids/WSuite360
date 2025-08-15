<!DOCTYPE html>
<html>

<head>
    <title>Leave History Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .title {
            font-size: 16px;
            font-weight: bold;
        }

        .subtitle {
            font-size: 12px;
            margin-bottom: 10px;
        }

        .filters {
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .footer {
            margin-top: 20px;
            font-size: 10px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="title">Leave History Report</div>
        <div class="subtitle">Generated on: {{ now()->format('d M Y H:i') }}</div>

        @if (!empty($filters))
            <div class="filters">
                <strong>Filters Applied:</strong>
                @if (!empty($filters['department_id']))
                    | Department: {{ $departmentName }}
                @endif
                @if (!empty($filters['leave_type_id']))
                    | Leave Type: {{ LeaveType::find($filters['leave_type_id'])->name ?? 'All' }}
                @endif
                @if (!empty($filters['status']))
                    | Status: {{ ucfirst($filters['status']) }}
                @endif
                @if (!empty($filters['start_date']))
                    | From: {{ \Carbon\Carbon::parse($filters['start_date'])->format('d M Y') }}
                @endif
                @if (!empty($filters['end_date']))
                    | To: {{ \Carbon\Carbon::parse($filters['end_date'])->format('d M Y') }}
                @endif
            </div>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Employee</th>
                <th>Department</th>
                <th>Leave Type</th>
                <th>Dates</th>
                <th>Days</th>
                <th>Status</th>
                <th>Reason</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($leaveApplications as $index => $application)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $application->employee->full_name }}</td>
                    <td>{{ $application->employee->department->name ?? 'N/A' }}</td>
                    <td>{{ $application->leaveType->name }}</td>
                    <td>
                        {{ $application->start_date->format('d M Y') }} -
                        {{ $application->end_date->format('d M Y') }}
                    </td>
                    <td>{{ $application->days_requested }}</td>
                    <td>{{ ucfirst($application->status) }}</td>
                    <td>{{ $application->reason }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Page <span class="pageNumber"></span> of <span class="totalPages"></span>
    </div>

    <script type="text/php">
        if (isset($pdf)) {
            $text = "Page {PAGE_NUM} of {PAGE_COUNT}";
            $size = 10;
            $font = $fontMetrics->getFont("Arial");
            $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
            $x = ($pdf->get_width() - $width) / 2;
            $y = $pdf->get_height() - 20;
            $pdf->page_text($x, $y, $text, $font, $size);
        }
    </script>
</body>

</html>
