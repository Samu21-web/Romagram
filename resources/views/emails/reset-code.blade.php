<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body style="margin:0; padding:0; background:#f3f4f6; font-family:Arial, sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f3f4f6; padding:40px 0;">
        <tr>
            <td align="center">
                <table width="480" cellpadding="0" cellspacing="0" style="background:white; border-radius:12px; overflow:hidden; box-shadow:0 4px 20px rgba(0,0,0,0.08);">
                    <tr>
                        <td style="background:#720e9e; padding:32px; text-align:center;">
                            <h1 style="color:white; margin:0; font-size:24px; font-weight:800;">Romagram</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:36px 32px;">
                            <h2 style="color:#111827; font-size:20px; margin:0 0 12px;">Reset your password</h2>
                            <p style="color:#6b7280; font-size:14px; line-height:1.6; margin:0 0 24px;">
                                We received a request to reset your Romagram password. Use the code below to continue:
                            </p>
                            <div style="background:#faf5ff; border:1.5px dashed #720e9e; border-radius:12px; padding:20px; text-align:center; margin-bottom:24px;">
                                <span style="font-size:32px; font-weight:800; letter-spacing:8px; color:#720e9e;">{{ $code }}</span>
                            </div>
                            <p style="color:#9ca3af; font-size:13px; line-height:1.6; margin:0;">
                                This code expires in 15 minutes. If you didn't request this, you can safely ignore this email.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="background:#f9fafb; padding:20px 32px; text-align:center;">
                            <p style="color:#9ca3af; font-size:12px; margin:0;">© {{ date('Y') }} Romagram. All rights reserved.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>