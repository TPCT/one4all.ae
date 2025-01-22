<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Reset Password Email</title>
    <style>
        /* Inline styles for simplicity, consider using CSS classes for larger templates */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f1f1f1;
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo img {
            max-width: 200px;
        }

        .message {
            padding: 20px;
            background-color: #ffffff;
        }

        .message p {
            margin-bottom: 10px;
        }

    </style>
</head>

<body>
<div class="container">

    <div class="message">
        <p>Dear {{ $emailData['name'] }},</p>
        <p>Please use this password <strong>{{$emailData['password']}}</strong> to login to your account</p>
    </div>

</div>
</body>

</html>