<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="utf-8">
    <title>Vacation Houses</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            height: 100vh;
            background: 
                linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)),
                url('https://images.unsplash.com/photo-1566073771259-6a8506099945') center/cover no-repeat;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .welcome-container {
            text-align: center;
            color: #fff;
        }

        .welcome-container h1 {
            font-size: 64px;
            margin-bottom: 10px;
        }

        .welcome-container p {
            font-size: 20px;
            margin-bottom: 40px;
            opacity: 0.9;
        }

        .buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
        }

        .btn {
            padding: 14px 40px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 500;
            transition: 0.3s;
        }

        .btn-login {
            background: #ffffff;
            color: #333;
        }

        .btn-register {
            background: transparent;
            border: 2px solid #fff;
            color: #fff;
        }

        .btn:hover {
            transform: translateY(-3px);
            opacity: 0.9;
        }
    </style>
</head>
<body>

<div class="welcome-container">
    <h1>Къщи за почивка</h1>
    <p>Намери идеалното място за своята почивка</p>

    <div class="buttons">
        <a href="{{ route('login') }}" class="btn btn-login">Login</a>
        <a href="{{ route('register') }}" class="btn btn-register">Register</a>
    </div>
</div>

</body>
</html>
