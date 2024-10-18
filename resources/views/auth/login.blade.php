<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | TeamAces Driving Academy</title>

    <!-- Font Awesome & Google Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background-color: #f0f2f5;
            overflow: hidden;
        }

        .background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #141820, #2e3a4f);
            z-index: -1;
        }

        .background::before,
        .background::after {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            opacity: 0.2;
        }

        .background::before {
            background-color: #3498db;
            top: -100px;
            left: -100px;
            animation: float 8s ease-in-out infinite;
        }

        .background::after {
            background-color: #e74c3c;
            bottom: -100px;
            right: -100px;
            animation: float 10s ease-in-out infinite reverse;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(30px, 30px); }
        }

        .login-container {
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 1000px;
            height: 600px;
            display: flex;
            overflow: hidden;
            position: relative;
            z-index: 1;
        }

        .login-content {
            flex: 1;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background-color: #141820;
            color: #ffffff;
            position: relative;
            overflow: hidden;
        }

        .login-content::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
            transform: rotate(30deg);
            z-index: -1;
        }

        .logo-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 2rem;
        }

        .logo {
            width: 200px;
            height: auto;
        }

        .login-form {
            flex: 1;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: #ffffff;
            position: relative;
            overflow: hidden;
        }

        .login-form::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(20,24,32,0.03) 0%, rgba(20,24,32,0) 70%);
            transform: rotate(-30deg);
            z-index: -1;
        }

        .input-group {
            margin-bottom: 1.5rem;
        }

        .input-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #333;
            font-weight: 500;
        }

        .input-group input {
            width: 100%;
            padding: 0.75rem;
            background-color: #f7f9fc;
            border: 1px solid #e1e5ee;
            border-radius: 8px;
            font-size: 1rem;
            color: #333;
            transition: all 0.3s ease;
        }

        .input-group input:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }

        .login-button {
            width: 100%;
            padding: 0.75rem;
            background-color: #3498db;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .login-button:hover {
            background-color: #2980b9;
        }

        .login-button:active {
            transform: translateY(1px);
        }

        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                height: auto;
                margin: 10px;
            }

            .login-content,
            .login-form {
                padding: 2rem;
            }

            .logo {
                width: 150px;
            }

            .login-form {
                padding: 2rem 1.5rem;
            }
        }

        @media (max-width: 480px) {
            .login-content,
            .login-form {
                padding: 1.5rem;
            }

            .logo {
                width: 120px;
            }

            .input-group input {
                font-size: 0.9rem;
            }

            .login-button {
                padding: 0.6rem;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <div class="background"></div>
    <div class="login-container">
        <div class="login-content">
            <div class="logo-container">
                <img src="images/admin/logoaces.png" alt="DriveEase Logo" class="logo">
            </div>
            <div class="login-header">
                <h2>Welcome Back</h2>
                <p>Access your admin panel to manage our driving school efficiently.</p>
            </div>
        </div>
        <div class="login-form">
            <form id="loginForm" method="POST" action="{{ route('login.submit') }}">
                @csrf <!-- Include CSRF token -->
                <div class="input-group">
                    <label for="form1Example13">Email</label>
                    <input type="email" id="form1Example13" name="email" placeholder="Enter email" required />
                </div>
                <div class="input-group">
                    <label for="form1Example23">Password</label>
                    <input type="password" id="form1Example23" name="password" placeholder="Password" required />
                </div>
                <button type="submit" class="login-button">Sign in</button>
            </form>
        </div>
    </div>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json().then(data => {
                if (!response.ok) {
                    return Promise.reject(data);
                }
                return data;
            }))
            .then(data => {
                if (data.redirect) {
                    window.location.href = data.redirect;
                }
            })
            .catch(error => {
                Swal.fire({
                    title: 'Error!',
                    text: error.message || 'There was an issue processing your request.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
        });
    </script>
</body>
</html>
