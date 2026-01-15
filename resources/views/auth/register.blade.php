<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Sleepy Panda</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
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
        
        .register-container {
            background: #20223F;
            border: 2px solid #4a5a75;
            padding: 60px 35px;
            width: 100%;
            max-width: 320px;
            min-height: 650px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }
        
        .logo-container {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .logo-container img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            margin-bottom: 20px;
        }
        
        .logo-container p {
            color: #b8c5d6;
            font-size: 14px;
            line-height: 1.5;
            margin: 0;
        }
        
        .input-group {
            position: relative;
            margin-bottom: 20px;
        }
        
        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6b7a8f;
            font-size: 16px;
            z-index: 10;
        }
        
        .form-control {
            background-color: rgba(255, 255, 255, 0.05);
            border: 1px solid #4a5a75;
            border-radius: 8px !important;
            color: #ffffff;
            padding: 10px 15px 10px 45px;
            font-size: 15px;
            width: 100%;
        }
        
        .form-control:focus {
            background-color: rgba(255, 255, 255, 0.08);
            border-color: #20b2aa;
            color: #ffffff;
            box-shadow: 0 0 0 0.2rem rgba(32, 178, 170, 0.25);
        }
        
        .form-control::placeholder {
            color: #6b7a8f;
        }
        
        .form-control.is-invalid {
            border-color: #dc3545;
        }
        
        .btn-daftar {
            background-color: #20b2aa;
            border: none;
            color: white;
            padding: 10px;
            font-size: 14px;
            font-weight: 500;
            border-radius: 8px;
            width: 100%;
            margin-top: 20px;
            margin-bottom: 20px;
            transition: background-color 0.3s, opacity 0.3s;
        }
        
        .btn-daftar:hover:not(:disabled) {
            background-color: #1a9690;
        }
        
        .btn-daftar:disabled {
            background-color: #6b7a8f;
            cursor: not-allowed;
            opacity: 0.6;
        }
        
        .login-link {
            text-align: center;
            color: #b8c5d6;
            font-size: 10px;
        }
        
        .login-link a {
            color: #20b2aa;
            text-decoration: none;
            font-weight: bold;
        }
        
        .login-link a:hover {
            text-decoration: underline;
        }
        
        .error-message {
            color: #dc3545;
            font-size: 12px;
            margin-bottom: 5px;
            display: none;
        }
        
        .error-message.show {
            display: block;
        }
        
        .alert {
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="logo-container">
            <img src="/images/pandalo.png" alt="Sleepy Panda">
            <p>Daftar menggunakan email yang<br>valid</p>
        </div>
        
        <!-- Alert untuk error message (akan muncul jika ada error) -->
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
        
        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
        
        <form method="POST" action="{{ route('register.post') }}" id="registerForm">
            @csrf
            
            <div class="error-message" id="emailError">username/password incorrect.</div>
            <div class="input-group">
                <i class="bi bi-envelope input-icon"></i>
                <input type="email" class="form-control" id="email" name="email" 
                       placeholder="Email" value="{{ old('email') }}" required>
            </div>
            
            <div class="error-message" id="passwordError">Password harus lebih dari 8 karakter</div>
            <div class="input-group">
                <i class="bi bi-lock input-icon"></i>
                <input type="password" class="form-control" id="password" name="password" 
                       placeholder="Password" required>
            </div>
            
            <button type="submit" class="btn btn-daftar" id="submitBtn" disabled>Daftar</button>
        </form>
        
        <div class="login-link">
            Sudah memiliki akun? <a href="{{ route('login') }}">Masuk sekarang</a>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        const submitBtn = document.getElementById('submitBtn');
        const emailError = document.getElementById('emailError');
        const passwordError = document.getElementById('passwordError');
        
        // Domain yang dilarang (blacklist) - hanya gmail.com yang diperbolehkan
        const allowedDomains = ['gmail.com'];
        
        // Fungsi validasi email
        function validateEmail(email) {
            // Cek jika kosong
            if (!email || email.trim() === '') {
                return { valid: false, message: 'username/password incorrect.' };
            }
            
            // Cek format email dasar
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                return { valid: false, message: 'username/password incorrect.' };
            }
            
            // Ekstrak domain dari email
            const domain = email.split('@')[1];
            
            // Cek apakah domain BUKAN gmail.com
            if (!allowedDomains.includes(domain.toLowerCase())) {
                return { valid: false, message: 'username/password incorrect.' };
            }
            
            return { valid: true, message: '' };
        }
        
        // Fungsi validasi password
        function validatePassword(password) {
            // Cek jika kosong
            if (!password || password.trim() === '') {
                return { valid: false, message: 'Password harus lebih dari 8 karakter' };
            }
            
            // Cek panjang password
            if (password.length < 8) {
                return { valid: false, message: 'Password harus lebih dari 8 karakter' };
            }
            
            return { valid: true, message: '' };
        }
        
        // Fungsi untuk mengupdate status tombol daftar
        function updateSubmitButton() {
            const emailValidation = validateEmail(emailInput.value);
            const passwordValidation = validatePassword(passwordInput.value);
            
            // Tampilkan/sembunyikan error email
            if (emailInput.value && !emailValidation.valid) {
                emailInput.classList.add('is-invalid');
                emailError.textContent = emailValidation.message;
                emailError.classList.add('show');
            } else {
                emailInput.classList.remove('is-invalid');
                emailError.classList.remove('show');
            }
            
            // Tampilkan/sembunyikan error password
            if (passwordInput.value && !passwordValidation.valid) {
                passwordInput.classList.add('is-invalid');
                passwordError.textContent = passwordValidation.message;
                passwordError.classList.add('show');
            } else {
                passwordInput.classList.remove('is-invalid');
                passwordError.classList.remove('show');
            }
            
            // Enable/disable tombol submit
            if (emailValidation.valid && passwordValidation.valid) {
                submitBtn.disabled = false;
            } else {
                submitBtn.disabled = true;
            }
        }
        
        // Event listeners
        emailInput.addEventListener('input', updateSubmitButton);
        emailInput.addEventListener('blur', updateSubmitButton);
        passwordInput.addEventListener('input', updateSubmitButton);
        passwordInput.addEventListener('blur', updateSubmitButton);
        
        // Validasi saat form disubmit
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const emailValidation = validateEmail(emailInput.value);
            const passwordValidation = validatePassword(passwordInput.value);
            
            if (!emailValidation.valid || !passwordValidation.valid) {
                e.preventDefault();
                updateSubmitButton();
            }
        });
        
        // Inisialisasi validasi saat halaman dimuat
        updateSubmitButton();
    </script>
</body>
</html>