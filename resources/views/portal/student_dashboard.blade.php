<h1>YOU ARE LOGGED IN</h1>
<h2>Welcome, {{ $student->first_name }} {{ $student->last_name }}!</h2>

<h3>Your Schedules</h3>

@if($schedules->isEmpty())
    <p>You have no schedules at the moment.</p>
@else
    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>#</th>
                <th>Scheduled Date</th>
                <th>Finish Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($schedules as $schedule)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $schedule->scheduled_date }}</td>
                    <td>{{ $schedule->schedule_finish }}</td>
                    <td>{{ $schedule->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
