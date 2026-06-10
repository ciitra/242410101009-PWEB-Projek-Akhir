<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Reset Password Studio LensArt</title>
</head>
<body style="margin:0; padding:0; background:#f6f1ee; font-family:Arial, sans-serif; color:#3f2b2b;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f6f1ee; padding:30px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:18px; overflow:hidden; box-shadow:0 8px 24px rgba(0,0,0,0.08);">

                    <tr>
                        <td style="background:#5a3434; padding:28px 32px; text-align:center;">
                            <h1 style="margin:0; color:#ffffff; font-size:28px; letter-spacing:0.5px;">
                                Studio LensArt
                            </h1>
                            <p style="margin:8px 0 0; color:#fff7f2; font-size:14px;">
                                Modern Photo Studio Reservation
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:34px 38px;">
                            <h2 style="margin:0 0 14px; color:#5a3434; font-size:24px;">
                                Reset Password
                            </h2>

                            <p style="font-size:15px; line-height:1.7; margin:0 0 16px;">
                                Halo,
                            </p>

                            <p style="font-size:15px; line-height:1.7; margin:0 0 16px;">
                                Kami menerima permintaan untuk melakukan reset password pada akun Studio LensArt Anda.
                                Silakan klik tombol di bawah ini untuk membuat password baru.
                            </p>

                            <div style="text-align:center; margin:30px 0;">
                                <a href="{{ $resetUrl }}"
                                   style="display:inline-block; background:#d48363; color:#ffffff; text-decoration:none; padding:13px 26px; border-radius:10px; font-weight:bold; font-size:15px;">
                                    Reset Password
                                </a>
                            </div>

                            <p style="font-size:14px; line-height:1.7; margin:0 0 14px; color:#6f615d;">
                                Link reset password ini hanya berlaku selama 60 menit.
                            </p>

                            <p style="font-size:14px; line-height:1.7; margin:0 0 14px; color:#6f615d;">
                                Jika Anda tidak merasa meminta reset password, abaikan email ini. Password akun Anda tidak akan berubah.
                            </p>

                            <hr style="border:none; border-top:1px solid #eadbd4; margin:26px 0;">

                            <p style="font-size:13px; line-height:1.7; margin:0; color:#8c7b75;">
                                Jika tombol tidak dapat diklik, salin dan buka link berikut di browser:
                            </p>

                            <p style="font-size:13px; line-height:1.7; word-break:break-all; color:#d48363;">
                                {{ $resetUrl }}
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td style="background:#fff7f2; padding:20px 32px; text-align:center;">
                            <p style="margin:0; color:#7a6761; font-size:13px;">
                                Salam hangat,<br>
                                <strong style="color:#5a3434;">Studio LensArt</strong>
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
