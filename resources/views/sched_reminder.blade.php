<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reminder: Upcoming Driving Lesson</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            background-color: #00214E;
            padding: 20px;
            color: #fff;
            border-radius: 8px 8px 0 0;
        }
        .header h1 {
            margin: 0;
            text-align: center;
            color: #fff;
        }
        .content {
            padding: 20px;
            font-size: 16px;
        }
        .content p {
            margin-bottom: 15px;
        }
        .content strong {
            color: #00214E;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #DCA47C;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
            margin-top: 20px;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #777;
            margin-top: 30px;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="header">
            <h1>Reminder: Upcoming Driving Lesson</h1>
        </div>

        <div class="content">
            <p>Dear {{ $student->first_name }},</p>

            <p>This is a reminder that you have a scheduled driving lesson on:</p>

            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($schedule->scheduled_date)->format('F d, Y h:i A') }}</p>

            <p>Please arrive on time. If you need to reschedule, contact us in advance.</p>
        </div>

        <div class="footer">
            <p>Thank you for choosing <strong>TeamACES Driving Academy</strong>.</p>
            <p>If you have any questions, feel free to reach out!</p>
        </div>
    </div>

</body>
</html>
