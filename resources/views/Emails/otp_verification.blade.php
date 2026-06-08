<!DOCTYPE html>
<html>
<head>
    <title>Verifikasi OTP</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f9fafb; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background: #ffffff; padding: 30px; border-radius: 10px; text-align: center;">
        <h2 style="color: #076f60;">Halo, {{ $userName }}!</h2>
        <p style="color: #4b5563; font-size: 16px;">Terima kasih telah mendaftar di Arena. Berikut adalah kode OTP verifikasi Anda:</p>
        
        <div style="margin: 30px 0; padding: 20px; background-color: #e6f4f1; border-radius: 8px;">
            <h1 style="color: #076f60; margin: 0; font-size: 36px; letter-spacing: 5px;">{{ $otpCode }}</h1>
        </div>

        <p style="color: #6b7280; font-size: 14px;">Kode ini hanya berlaku selama 10 menit. Jangan berikan kode ini kepada siapa pun.</p>
        <hr style="border: none; border-top: 1px solid #e5e7eb; margin: 30px 0;">
        <p style="color: #9ca3af; font-size: 12px;">Jika Anda tidak merasa mendaftar di Arena, abaikan email ini.</p>
    </div>
</body>
</html>