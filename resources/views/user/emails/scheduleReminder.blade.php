@component('mail::message')
# Reminder: Upcoming Driving Lesson

Dear {{ $student->name }},

This is a reminder that you have a scheduled driving lesson on:

**Date:** {{ \Carbon\Carbon::parse($schedule->scheduled_date)->format('F d, Y h:i A') }}

Please arrive on time. If you need to reschedule, contact us in advance.

Thank you!
TeamACES Driving Academy
@endcomponent
