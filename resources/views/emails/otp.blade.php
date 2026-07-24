<!DOCTYPE html>
<html>
<body style="font-family: sans-serif; background:#f5f5f5; padding:24px;">
    <div style="max-width:480px; margin:0 auto; background:#fff; border-radius:16px; padding:32px; text-align:center;">
        <h2 style="color:#111;">Kode OTP Reset Password</h2>
        <p style="color:#555; font-size:14px;">Gunakan kode berikut untuk mereset password Anda. Kode berlaku selama 10 menit.</p>
        <div style="font-size:32px; font-weight:bold; letter-spacing:8px; background:#f1f1f1; padding:16px; border-radius:12px; margin:24px 0;">
            {{ $otp }}
        </div>
        <p style="color:#999; font-size:12px;">Jika Anda tidak meminta reset password, abaikan email ini.</p>
    </div>
</body>
</html>