<!DOCTYPE html>
<html>
<head>
    <title>Password Reset Code</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            background-color: #ffffff;
            margin: 20px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .header {
            padding: 10px 0;
            border-bottom: 2px solid #ddd;
        }
        .header h2 {
            color: #333;
        }
        .content {
            padding: 20px;
        }
        .content p {
            font-size: 16px;
            color: #555;
        }
        .code-box {
            font-size: 24px;
            font-weight: bold;
            background-color: #007bff;
            color: #ffffff;
            padding: 12px 20px;
            display: inline-block;
            border-radius: 5px;
            letter-spacing: 4px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            font-size: 14px;
            color: #777;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="header">
            <h2>Password Reset Code</h2>
        </div>
        <div class="content">
            <p>Hello,</p>
            <p>You requested a password reset. Use the following verification code to reset your password:</p>
            <div class="code-box">{{ $code }}</div>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} TicketHub. All rights reserved.</p>
        </div>
    </div>

</body>
</html>
