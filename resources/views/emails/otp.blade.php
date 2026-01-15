<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode OTP Reset Password</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            background-color: #20223F;
            padding: 30px;
            text-align: center;
        }
        .email-header h1 {
            color: #ffffff;
            margin: 15px 0 0 0;
            font-size: 24px;
        }
        .email-body {
            padding: 40px 30px;
        }
        .email-body p {
            color: #333333;
            line-height: 1.6;
            margin-bottom: 20px;
            font-size: 15px;
        }
        .otp-box {
            background-color: #f8f9fa;
            border: 2px dashed #20b2aa;
            border-radius: 8px;
            padding: 25px;
            text-align: center;
            margin: 30px 0;
        }
        .otp-label {
            color: #666666;
            font-size: 14px;
            margin-bottom: 10px;
        }
        .otp-code {
            font-size: 36px;
            font-weight: bold;
            color: #20b2aa;
            letter-spacing: 8px;
            font-family: 'Courier New', monospace;
        }
        .warning-box {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .warning-box p {
            color: #856404;
            margin: 0;
            font-size: 14px;
        }
        .email-footer {
            background-color: #f8f9fa;
            padding: 20px 30px;
            text-align: center;
            color: #666666;
            font-size: 13px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>Sleepy Panda</h1>
        </div>
        
        <div class="email-body">
            <p>Halo {{ $userName ?? 'User' }},</p>
            
            <p>Kami menerima permintaan untuk mereset password akun Anda. Gunakan kode OTP berikut untuk melanjutkan proses reset password:</p>
            
            <div class="otp-box">
                <div class="otp-label">KODE OTP ANDA</div>
                <div class="otp-code">{{ $otp }}</div>
            </div>
            
            <div class="warning-box">
                <p><strong>⚠️ Penting:</strong> Kode OTP ini akan kadaluarsa dalam <strong>10 menit</strong>. Jangan bagikan kode ini kepada siapapun!</p>
            </div>
            
            <p>Jika Anda tidak melakukan permintaan reset password, abaikan email ini.</p>
            
            <p>Terima kasih,<br>
            <strong>Tim Sleepy Panda</strong></p>
        </div>
        
        <div class="email-footer">
            <p>Email ini dikirim otomatis, mohon tidak membalas email ini.</p>
            <p>&copy; {{ date('Y') }} Sleepy Panda. All rights reserved.</p>
        </div>
    </div>
</body>
</html>