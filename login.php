<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
        }

        .login-box {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .login-box h2 {
            margin-bottom: 20px;
        }

        .user-box {
            margin-bottom: 20px;
            position: relative;
        }

        .user-box input {
            width: 100%;
            padding: 10px;
            background: none;
            border: none;
            border-bottom: 1px solid #000;
            outline: none;
            color: #000;
        }

        .user-box label {
            position: absolute;
            top: 10px;
            left: 10px;
            pointer-events: none;
            transition: 0.5s;
        }

        .user-box input:focus ~ label,
        .user-box input:valid ~ label {
            top: -20px;
            left: 0;
            color: #03a9f4;
            font-size: 12px;
        }

        button {
            background-color: #03a9f4;
            border: none;
            padding: 10px 20px;
            color: #fff;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0288d1;
        }

        .hidden {
            display: none;
        }

        #welcomeMessage {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Login</h2>
        <form id="loginForm">
            <div class="user-box">
                <input type="text" id="username" required>
                <label>Username</label>
            </div>
            <div class="user-box">
                <input type="password" id="password" required>
                <label>Password</label>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
    <div id="welcomeMessage" class="hidden">
        <h2>Welcome, <span id="userName"></span>!</h2>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;

            // For demonstration purposes, we'll assume any non-empty username and password is valid.
            if (username && password) {
                document.querySelector('.login-box').classList.add('hidden');
                document.getElementById('userName').textContent = username;
                document.getElementById('welcomeMessage').classList.remove('hidden');
            } else {
                alert('Please enter both username and password');
            }
        });
    </script>
</body>
</html>
