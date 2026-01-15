<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sleepy Panda</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #20223F;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px;
        }

         html,
        body {
            scroll-behavior: smooth;
            overflow-y: auto;
            overflow-x: hidden;
        }

        body::-webkit-scrollbar {
            display: none;
        }
        
        .login-container {
            background: #20223F;
            border: 2px solid #4a5a75;
            padding: 60px 35px;
            width: 100%;
            max-width: 385px;
            min-height: 650px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        
        .logo-container {
            text-align: center;
            margin-bottom: 50px;
            padding-top: 20px;
        }
        
        .logo-container img {
            width: 140px;
            height: 140px;
        }
        
        .logo-container h2 {
            color: #ffffff;
            font-size: 32px;
            font-weight: 600;
            margin: 0;
            letter-spacing: 0.5px;
        }
        
        .subtitle {
            color: #b8c5d6;
            font-size: 15px;
            text-align: center;
            margin-bottom: 50px;
            line-height: 1.6;
            padding: 0 10px;
        }
        
        .btn-masuk {
            background-color: #20b2aa;
            color: #ffffff;
            padding: 8px;
            font-size: 14px;
            font-weight: 500;
            border-radius: 8px;
            width: 100%;
            margin-bottom: 10px;
            transition: all 0.3s;
        }
        
        .btn-masuk:hover {
            background-color: #1a9690;
        }
        
        .btn-daftar {
            background-color: #ffffff;
            border: 2px solid #ffffff;
            color: black;
            padding: 8px;
            font-size: 14px;
            font-weight: 500;
            border-radius: 8px;
            width: 100%;
            transition: all 0.3s;
        }
        
        .btn-daftar:hover {
            background-color: rgba(255, 255, 255, 0.1);
            border-color: #ffffff;
        }
        
        .content-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        
        .button-group {
            margin-top: auto;
            padding-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="content-wrapper">
            <div class="logo-container">
                <!-- Ganti src dengan path gambar panda Anda -->
                <img src="/images/logo.png" alt="Sleepy Panda">
                <h2>Sleepy Panda</h2>
            </div>
            
            <p class="subtitle">
                Mulai dengan masuk atau<br>mendaftar untuk melihat analisa<br>tidur mu
            </p>
        </div>
        
        <div class="button-group">
            <a href="{{ route('login') }}" class="btn btn-masuk text-decoration-none">
                Masuk
            </a>
            <a href="{{ route('register') }}" class="btn btn-daftar text-decoration-none">
                Daftar
            </a>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>