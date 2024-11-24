<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Balance Reminder</title>
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
            color: #fff;
        }
        .content {
            padding: 20px;
            font-size: 16px;
        }
        .content p {
            margin-bottom: 15px;
        }
        .balance {
            font-size: 20px;
            font-weight: bold;
            color: #d9534f; /* Red color for balance */
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
            <h1>Balance Reminder</h1>
        </div>

        <div class="content">
            <p>Dear {{ $student->first_name }},</p>

            <p>We hope you're doing well! This is a friendly reminder that you have an outstanding balance on your account. The current balance is:</p>

            <p class="balance">₱{{ number_format($balance, 2) }}</p>

            <p>We kindly request that you settle this balance at your earliest convenience to avoid any disruption to your services.</p>

            <p>If you have already made the payment, please disregard this message. If you have any questions, feel free to reach out to us.</p>
        </div>

        <div class="footer">
            <p>Thank you for choosing TeamAces Driving Academy!</p>
            <p>If you need assistance, don't hesitate to contact us.</p>
        </div>
    </div>

</body>
</html>
