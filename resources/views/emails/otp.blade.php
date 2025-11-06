<!DOCTYPE html>
<html>
<head>
    <title>Kode OTP Reset Password</title>
    <style>
        .button {
            display: inline-block;
            padding: 12px 24px;
            font-size: 16px;
            font-weight: bold;
            color: #ffffff;
            background-color: #4f46e5; /* Indigo */
            text-decoration: none;
            border-radius: 8px;
            margin-top: 20px;
        }
    </style>
</head>
<body style="font-family: Arial, sans-serif; padding: 20px;">
    <h2>Reset Password Anda</h2>
    <p>Gunakan kode 4-digit berikut untuk mereset password Anda:</p>
    <h1 style="font-size: 36px; letter-spacing: 5px;">
        {{ $otp }}
    </h1>
    <p>Kode ini hanya berlaku selama 10 menit.</p>

    <p>Atau, klik tombol di bawah ini untuk pergi ke halaman reset password:</p>
    <a href="{{ route('employee.password.reset.form', ['email' => $email]) }}" class="button">
        Reset Password Sekarang
    </a>
</body>
</html>