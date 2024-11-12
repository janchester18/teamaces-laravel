<!DOCTYPE html>
<html>
<head>
    <title>Enrollment Confirmation</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
            text-align: left;
        }
        tr:nth-child(even) { background-color: #f9f9f9; }
    </style>
</head>
<body>
    <h2>Your enrollment has been confirmed!</h2>
    <p>You have paid for the course/package:
        {{ $course ? $course->name : $package->name }}.
        Amount paid: {{ $course ? $course->price - $balance : $package->price - $balance }}.
    </p>
    <p>Your portal login credentials:</p>
    <ul>
        <li>Email: {{ $student->email }}</li>
        <li>Student ID: {{ $student->id }}</li>
    </ul>
    <p>Access the portal at: <a href="https://teamaces-driving.com/portal">TeamACES Portal</a></p><br>

    <p>To make changes to your schedule, contact the staff or login to the student portal to request adjustments.</p>
    <h3>Your Initial Schedules:</h3>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Scheduled Date</th>
                <th>Scheduled Finish</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($schedules as $index => $schedule)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($schedule->scheduled_date)->format('F j, Y g:i A') }}</td>
                    <td>{{ \Carbon\Carbon::parse($schedule->schedule_finish)->format('F j, Y g:i A') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">No schedules available</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
