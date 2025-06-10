<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
<link rel="icon" type="image/jpg" sizes="96x96" href="https://stegbackdotcomcdn.b-cdn.net/root/storage/media/2024_09_11/1726063492-0.jpg">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login - Admin Panel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Styles -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #4a154b 0%, #1a5f7a 100%);
        }

        .login-container {
            background: white;
            padding: 2.5rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            margin: 1rem;
        }

        .logoimg {
            display: flex;

            margin-bottom: 1.5rem;
        }

        .logoimg img {
            height: 25px;
        }

        h1 {
            font-size: 24px;
            font-weight: 600;
            color: #212b36;
            margin: 0 0 0.5rem;
        }

        .subtitle {
            font-size: 14px;
            color: #637381;
            margin-bottom: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #212b36;
            margin-bottom: 0.5rem;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 0.75rem;
            font-size: 14px;
            border: 1px solid #c4cdd5;
            border-radius: 4px;
            box-sizing: border-box;
            transition: border-color 0.15s ease;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #5c6ac4;
            box-shadow: 0 0 0 1px #5c6ac4;
        }

        .btn-primary {
            display: block;
            width: 100%;
            padding: 0.75rem;
            background-color: #404040;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.15s ease;
            margin-top: 2rem;
        }

        .btn-primary:hover {
            background-color: #2c2c2c;
        }

        .footer {
            display: flex;
            justify-content: space-between;
            margin-top: 2rem;
            font-size: 12px;
        }

        .footer a {
            color: #637381;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="mb-2 logoimg">
            <!-- <img src="{{ asset('images/logo.png') }}" alt="Logo"> -->
            <img src="https://portal-stegback.b-cdn.net/development/gallery/1738073117490sbq6qb.png" alt="Logo">
        </div>
        
        <h1>Log in</h1>
        <p class="subtitle">Continue to <b>Stegback Console</b></p>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required autofocus>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit" class="btn-primary">Log in</button>
        </form>

        <div class="footer">
            <div>
                <a href="#">Help</a>
                <span style="margin: 0 0.5rem;">·</span>
                <a href="#">Privacy</a>
                <span style="margin: 0 0.5rem;">·</span>
                <a href="#">Terms</a>
            </div>
        </div>
    </div>
</body>

</html>
