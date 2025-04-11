<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Verify Your Email</title>
</head>
<body>
    <h2>Hello, {{ $user->first_name }}!</h2>
    <p>Thank you for registering. Please verify your email by clicking the button below:</p>
    <a href="{{ $url }}" style="padding: 10px 20px; background-color: #38bdf8; color: white; text-decoration: none; border-radius: 5px;">Verify Email</a>
    <p>This link will expire in 60 minutes.</p>
</body>
</html>
