<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | TeamAces Driving Academy</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #FCF8F3; /* Background color */
        }
        .login-container {
            width: 100%;
            width: 400px;
            background-color: #FFF;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
        }
        .login-container h2 {
            text-align: center;
            color: #292566; /* Custom color for heading */
            margin-bottom: 20px;
        }
        .btn-primary {
            background-color: #5142d4;
            border-color: #1502c0;
        }
        .btn-primary:hover {
            background-color: #7161ff;
            border-color: #FFD3B6;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2><strong>Admin Login</strong></h2>
        <form method="POST" action="{{ route('login.submit') }}">
            @csrf <!-- Include CSRF token -->
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Login</button>
        </form>
    </div>


    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
