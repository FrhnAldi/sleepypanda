<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Sleepy Panda</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        html {
            overflow-x: hidden;
            overflow-y: scroll;
        }
        
        html, body {
            width: 100%;
            height: 100%;
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
        
        body {
            background: #20223F;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px;
            overflow: hidden;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        }
        
        body.modal-open {
            overflow: hidden !important;
        }
        
        .login-container {
            background: #20223F;
            border: 2px solid #4a5a75;
            padding: 60px 35px;
            width: 100%;
            max-width: 320px;
            min-height: 650px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            position: relative;
            z-index: 1;
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
        
        .input-wrapper {
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
            pointer-events: none;
            z-index: 1;
        }
        
        .form-control {
            background-color: rgba(255, 255, 255, 0.05);
            border: 1px solid #4a5a75;
            border-radius: 8px;
            color: #ffffff;
            padding: 10px 15px 10px 45px;
            font-size: 15px;
            width: 100%;
            display: block;
            position: relative;
            z-index: 2;
        }
        
        .form-control:focus {
            background-color: rgba(255, 255, 255, 0.08);
            border-color: #20b2aa;
            color: #ffffff;
            outline: none;
            box-shadow: 0 0 0 0.2rem rgba(32, 178, 170, 0.25);
        }
        
        .form-control::placeholder {
            color: #6b7a8f;
        }
        
        .form-control.is-invalid {
            border-color: #dc3545;
        }
        
        .forgot-password {
            text-align: right;
            margin-top: -10px;
            margin-bottom: 30px;
        }
        
        .forgot-link {
            background: none;
            border: none;
            padding: 0;
            color: #20b2aa;
            text-decoration: none;
            font-size: 13px;
            cursor: pointer;
            display: inline-block;
        }
        
        .forgot-link:hover {
            text-decoration: underline;
        }
        
        .btn-masuk {
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
            cursor: pointer;
        }
        
        .btn-masuk:hover:not(:disabled) {
            background-color: #1a9690;
        }
        
        .btn-masuk:disabled {
            background-color: #6b7a8f;
            cursor: not-allowed;
            opacity: 0.6;
        }
        
        .register-link {
            text-align: center;
            color: #b8c5d6;
            font-size: 10px;
        }
        
        .register-link a {
            color: #20b2aa;
            text-decoration: none;
            font-weight: bold;
        }
        
        .register-link a:hover {
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
        
        /* Modal Styles */
        .modal {
            display: none;
            overflow: hidden !important;
        }
        
        .modal.show {
            display: flex !important;
            align-items: flex-end !important;
            overflow: hidden !important;
        }
        
        .modal-backdrop {
            display: none !important;
        }
        
        .modal.fade .modal-dialog {
            transform: translateY(100%);
            transition: transform 0.3s ease-out;
        }
        
        .modal.show .modal-dialog {
            transform: translateY(0);
        }
        
        .modal-dialog {
            margin: 0 auto 0 auto;
            max-width: 320px;
            width: 320px;
        }
        
        .modal-content {
            background: #20223F;
            border: 2px solid #4a5a75;
            border-radius: 20px 20px 0 0;
            border-bottom: none;
            width: 100%;
            padding: 15px 25px 30px;
            position: relative;
            transition: transform 0.3s cubic-bezier(0.4, 0.0, 0.2, 1);
            will-change: transform;
        }
        
        .modal-drag-handle {
            width: 40px;
            height: 4px;
            background-color: #6b7a8f;
            border-radius: 2px;
            margin: 0 auto 20px;
            cursor: grab;
            transition: background-color 0.2s ease;
            user-select: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
        }
        
        .modal-drag-handle:hover {
            background-color: #8a9aaf;
        }
        
        .modal-drag-handle:active {
            cursor: grabbing;
            background-color: #20b2aa;
        }
        
        .modal-header {
            border-bottom: none;
            padding: 0;
            position: relative;
            margin-bottom: 15px;
        }
        
        .modal-body {
            padding: 0;
        }
        
        .modal-title {
            color: #ffffff;
            font-size: 20px;
            font-weight: 600;
            text-align: center;
            width: 100%;
            margin-bottom: 0;
        }
        
        .btn-close {
            display: none;
        }
        
        .forgot-icon {
            display: none;
        }
        
        .forgot-description {
            color: #b8c5d6;
            font-size: 13px;
            text-align: center;
            line-height: 1.6;
            margin-bottom: 20px;
            padding: 0;
        }
        
        .btn-reset {
            background-color: #20b2aa;
            border: none;
            color: white;
            padding: 10px;
            font-size: 14px;
            font-weight: 500;
            border-radius: 8px;
            width: 100%;
            transition: background-color 0.3s;
            cursor: pointer;
        }
        
        .btn-reset:hover:not(:disabled) {
            background-color: #1a9690;
        }
        
        .btn-reset:disabled {
            background-color: #6b7a8f;
            cursor: not-allowed;
            opacity: 0.6;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo-container">
            <img src="/images/pandalo.png" alt="Sleepy Panda">
            <p>Masuk menggunakan akun yang<br>sudah kamu daftarkan</p>
        </div>
        
        <!-- Alert untuk error dari server -->
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
        
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
        
        <form method="POST" action="{{ route('login.post') }}" id="loginForm">
            @csrf
            
            <div class="error-message" id="emailError">username/password incorrect.</div>
            <div class="input-wrapper">
                <i class="bi bi-envelope input-icon"></i>
                <input type="email" 
                       class="form-control" 
                       id="email" 
                       name="email" 
                       placeholder="Email"
                       value="{{ old('email') }}"
                       autocomplete="email">
            </div>
            
            <div class="error-message" id="passwordError">Password harus lebih dari 8 karakter</div>
            <div class="input-wrapper">
                <i class="bi bi-lock input-icon"></i>
                <input type="password" 
                       class="form-control" 
                       id="password" 
                       name="password" 
                       placeholder="Password"
                       autocomplete="current-password">
            </div>
            
            <div class="forgot-password">
                <a href="#" class="forgot-link" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal">Lupa password?</a>
            </div>
            
            <button type="submit" class="btn btn-masuk" id="submitBtn" disabled>Masuk</button>
        </form>
        
        <div class="register-link">
            Belum memiliki akun? <a href="{{ route('register') }}">Daftar sekarang</a>
        </div>
    </div>

    <!-- Modal Forgot Password -->
    <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true" data-bs-backdrop="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-drag-handle"></div>
                <div class="modal-header">
                    <h5 class="modal-title" id="forgotPasswordModalLabel">Lupa password?</h5>
                </div>
                <div class="modal-body">
                    <p class="forgot-description">
                        Instruksi untuk melakukan reset password akan dikirim melalui email yang kamu gunakan untuk mendaftar
                    </p>
                    
                    <form method="POST" action="#" id="forgotPasswordForm">
                        
                        <div class="error-message" id="modalEmailError">Email Anda Salah</div>
                        <div class="input-wrapper">
                            <i class="bi bi-envelope input-icon"></i>
                            <input type="email" 
                                   class="form-control" 
                                   id="modalEmail" 
                                   name="email" 
                                   placeholder="Email"
                                   autocomplete="email">
                        </div>
                        
                        <button type="submit" class="btn btn-reset" id="resetBtn" disabled>Reset Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Tunggu sampai DOM siap
        document.addEventListener('DOMContentLoaded', function() {
            
            // Login Form Elements
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const submitBtn = document.getElementById('submitBtn');
            const emailError = document.getElementById('emailError');
            const passwordError = document.getElementById('passwordError');
            
            // Modal Form Elements
            const modalEmailInput = document.getElementById('modalEmail');
            const resetBtn = document.getElementById('resetBtn');
            const modalEmailError = document.getElementById('modalEmailError');
            
            // Domain yang diperbolehkan
            const allowedDomains = ['gmail.com'];
            
            // Fungsi validasi email
            function validateEmail(email) {
                if (!email || email.trim() === '') {
                    return { valid: false, message: 'username/password incorrect.' };
                }
                
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email)) {
                    return { valid: false, message: 'username/password incorrect.' };
                }
                
                const domain = email.split('@')[1];
                if (!allowedDomains.includes(domain.toLowerCase())) {
                    return { valid: false, message: 'username/password incorrect.' };
                }
                
                return { valid: true, message: '' };
            }
            
            // Fungsi validasi email untuk modal
            function validateModalEmail(email) {
                if (!email || email.trim() === '') {
                    return { valid: false, message: 'Email Anda Salah' };
                }
                
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email)) {
                    return { valid: false, message: 'Email Anda Salah' };
                }
                
                const domain = email.split('@')[1];
                if (!allowedDomains.includes(domain.toLowerCase())) {
                    return { valid: false, message: 'Email Anda Salah' };
                }
                
                return { valid: true, message: '' };
            }
            
            // Fungsi validasi password
            function validatePassword(password) {
                if (!password || password.trim() === '') {
                    return { valid: false, message: 'Password harus lebih dari 8 karakter' };
                }
                
                if (password.length < 8) {
                    return { valid: false, message: 'Password harus lebih dari 8 karakter' };
                }
                
                return { valid: true, message: '' };
            }
            
            // Update status tombol login
            function updateSubmitButton() {
                const emailValidation = validateEmail(emailInput.value);
                const passwordValidation = validatePassword(passwordInput.value);
                
                // Error untuk email
                if (emailInput.value && !emailValidation.valid) {
                    emailInput.classList.add('is-invalid');
                    emailError.textContent = emailValidation.message;
                    emailError.classList.add('show');
                } else {
                    emailInput.classList.remove('is-invalid');
                    emailError.classList.remove('show');
                }
                
                // Error untuk password
                if (passwordInput.value && !passwordValidation.valid) {
                    passwordInput.classList.add('is-invalid');
                    passwordError.textContent = passwordValidation.message;
                    passwordError.classList.add('show');
                } else {
                    passwordInput.classList.remove('is-invalid');
                    passwordError.classList.remove('show');
                }
                
                // Enable/disable tombol
                submitBtn.disabled = !(emailValidation.valid && passwordValidation.valid);
            }
            
            // Update status tombol reset
            function updateResetButton() {
                const emailValidation = validateModalEmail(modalEmailInput.value);
                
                if (modalEmailInput.value && !emailValidation.valid) {
                    modalEmailInput.classList.add('is-invalid');
                    modalEmailError.textContent = emailValidation.message;
                    modalEmailError.classList.add('show');
                } else {
                    modalEmailInput.classList.remove('is-invalid');
                    modalEmailError.classList.remove('show');
                }
                
                resetBtn.disabled = !emailValidation.valid;
            }
            
            // Event listeners untuk login form
            emailInput.addEventListener('input', updateSubmitButton);
            emailInput.addEventListener('blur', updateSubmitButton);
            passwordInput.addEventListener('input', updateSubmitButton);
            passwordInput.addEventListener('blur', updateSubmitButton);
            
            // Event listeners untuk modal form
            modalEmailInput.addEventListener('input', updateResetButton);
            modalEmailInput.addEventListener('blur', updateResetButton);
            
            // Submit handler untuk login - HAPUS ALERT, LANGSUNG SUBMIT
            document.getElementById('loginForm').addEventListener('submit', function(e) {
                const emailValidation = validateEmail(emailInput.value);
                const passwordValidation = validatePassword(passwordInput.value);
                
                // Hanya prevent jika validasi gagal
                if (!emailValidation.valid || !passwordValidation.valid) {
                    e.preventDefault();
                    updateSubmitButton();
                }
                // Jika valid, biarkan form submit ke server (tidak ada e.preventDefault())
            });
            
            // Submit handler untuk forgot password
            document.getElementById('forgotPasswordForm').addEventListener('submit', function(e) {
                e.preventDefault();
                
                const emailValidation = validateModalEmail(modalEmailInput.value);
                
                if (emailValidation.valid) {
                    const email = modalEmailInput.value;
                    
                    // Disable button dan ubah text
                    resetBtn.disabled = true;
                    resetBtn.textContent = 'Mengirim...';
                    
                    // Kirim request ke backend untuk generate dan kirim OTP
                    fetch('/api/forgot-password', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                        },
                        body: JSON.stringify({
                            email: email
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Kode OTP telah dikirim ke email Anda: ' + email);
                            
                            const modalInstance = bootstrap.Modal.getInstance(modal);
                            if (modalInstance) {
                                modalInstance.hide();
                            }
                        } else {
                            alert(data.message || 'Gagal mengirim OTP. Silakan coba lagi.');
                        }
                        
                        // Reset button
                        resetBtn.disabled = false;
                        resetBtn.textContent = 'Reset Password';
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan. Silakan coba lagi.');
                        
                        // Reset button
                        resetBtn.disabled = false;
                        resetBtn.textContent = 'Reset Password';
                    });
                }
            });
            
            // Reset modal saat ditutup
            const modal = document.getElementById('forgotPasswordModal');
            modal.addEventListener('hidden.bs.modal', function() {
                modalEmailInput.value = '';
                modalEmailInput.classList.remove('is-invalid');
                modalEmailError.classList.remove('show');
                resetBtn.disabled = true;
            });
            
            // Auto focus modal email saat dibuka
            modal.addEventListener('shown.bs.modal', function() {
                setTimeout(function() {
                    modalEmailInput.focus();
                }, 100);
            });
            
            // Swipe down to close modal
            const dragHandle = document.querySelector('.modal-drag-handle');
            const modalContent = document.querySelector('#forgotPasswordModal .modal-content');
            const modalDialog = document.querySelector('#forgotPasswordModal .modal-dialog');
            let startY = 0;
            let currentY = 0;
            let isDragging = false;
            
            // Touch events
            dragHandle.addEventListener('touchstart', function(e) {
                startY = e.touches[0].clientY;
                isDragging = true;
                modalContent.style.transition = 'none';
                document.body.style.overflow = 'hidden';
                document.documentElement.style.overflow = 'hidden';
            }, { passive: false });
            
            document.addEventListener('touchmove', function(e) {
                if (!isDragging) return;
                
                e.preventDefault();
                e.stopPropagation();
                
                currentY = e.touches[0].clientY;
                const deltaY = currentY - startY;
                
                if (deltaY > 0) {
                    modalDialog.style.transform = `translateY(${deltaY}px)`;
                }
                
                return false;
            }, { passive: false });
            
            document.addEventListener('touchend', function(e) {
                if (!isDragging) return;
                isDragging = false;
                
                document.body.style.overflow = '';
                document.documentElement.style.overflow = '';
                
                const deltaY = currentY - startY;
                modalDialog.style.transition = 'transform 0.3s cubic-bezier(0.4, 0.0, 0.2, 1)';
                
                if (deltaY > 80) {
                    modalDialog.style.transform = 'translateY(100%)';
                    setTimeout(function() {
                        const modalInstance = bootstrap.Modal.getInstance(modal);
                        if (modalInstance) {
                            modalInstance.hide();
                        }
                    }, 300);
                } else {
                    modalDialog.style.transform = 'translateY(0)';
                }
                
                setTimeout(function() {
                    modalContent.style.transition = 'transform 0.3s cubic-bezier(0.4, 0.0, 0.2, 1)';
                }, 50);
            }, { passive: false });
            
            // Mouse events for desktop
            dragHandle.addEventListener('mousedown', function(e) {
                startY = e.clientY;
                isDragging = true;
                modalContent.style.transition = 'none';
                document.body.style.overflow = 'hidden';
                document.documentElement.style.overflow = 'hidden';
                e.preventDefault();
                e.stopPropagation();
            });
            
            document.addEventListener('mousemove', function(e) {
                if (!isDragging) return;
                
                e.preventDefault();
                e.stopPropagation();
                
                currentY = e.clientY;
                const deltaY = currentY - startY;
                
                if (deltaY > 0) {
                    modalDialog.style.transform = `translateY(${deltaY}px)`;
                }
                
                return false;
            });
            
            document.addEventListener('mouseup', function(e) {
                if (!isDragging) return;
                isDragging = false;
                
                document.body.style.overflow = '';
                document.documentElement.style.overflow = '';
                
                const deltaY = currentY - startY;
                modalDialog.style.transition = 'transform 0.3s cubic-bezier(0.4, 0.0, 0.2, 1)';
                
                if (deltaY > 80) {
                    modalDialog.style.transform = 'translateY(100%)';
                    setTimeout(function() {
                        const modalInstance = bootstrap.Modal.getInstance(modal);
                        if (modalInstance) {
                            modalInstance.hide();
                        }
                    }, 300);
                } else {
                    modalDialog.style.transform = 'translateY(0)';
                }
                
                setTimeout(function() {
                    modalContent.style.transition = 'transform 0.3s cubic-bezier(0.4, 0.0, 0.2, 1)';
                }, 50);
            });
            
            // Reset transform when modal is hidden
            modal.addEventListener('hidden.bs.modal', function() {
                modalDialog.style.transform = 'translateY(0)';
                modalDialog.style.transition = 'transform 0.3s cubic-bezier(0.4, 0.0, 0.2, 1)';
                document.body.style.overflow = '';
                document.documentElement.style.overflow = '';
            });
            
            // Initial update
            updateSubmitButton();
            updateResetButton();
        });
    </script>
</body>
</html>