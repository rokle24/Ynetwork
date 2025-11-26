<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Your Password</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif;">
<table align="center" width="100%" cellpadding="0" cellspacing="0" style="max-width: 600px; margin: auto;">
    <tr>
        <td align="center" style="padding: 40px 0;">
            <h1 style="font-size: 36px; font-weight: bold;">Ynetwork</h1>
            <img src="{{ $message->embed(public_path('images/Logo2.png')) }}" alt="Logo" width="128" height="160">
        </td>
    </tr>
    <tr>
        <td align="center" style="padding: 20px;">
            <p style="font-size: 18px;">Here is your link to reset your password:</p>
            <a href="{{ $resetUrl }}" style="
                    display: inline-block;
                    background-color: #000;
                    color: #fff;
                    text-decoration: none;
                    padding: 12px 24px;
                    border-radius: 25px;
                    font-weight: bold;
                    margin-top: 20px;
                ">Click Here</a>
        </td>
    </tr>
    <tr>
        <td align="center" style="padding:30px;font-size:14px;color:#777;">
            © {{ date('Y') }} Ynetwork. All rights reserved.
        </td>
    </tr>
</table>
</body>
</html>
