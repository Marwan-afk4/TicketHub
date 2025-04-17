<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Verification Code</title>
  </head>
  <body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">
    <table align="center" width="100%" cellpadding="0" cellspacing="0" style="background-color: #f4f4f4; padding: 20px 0;">
      <tr>
        <td>
          <table align="center" width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
            <tr>
              <td style="text-align: center;">
                <h2 style="color: #333333;">Email Verification</h2>
                <p style="color: #666666; font-size: 16px;">Use the code below to verify your email address:</p>
                <div style="margin: 30px 0;">
                  <span style="display: inline-block; background-color: #007BFF; color: white; font-size: 24px; font-weight: bold; padding: 15px 30px; border-radius: 8px; letter-spacing: 4px;">
                    {{ $code }}
                  </span>
                </div>
                <p style="color: #999999; font-size: 14px;">If you did not request this code, you can safely ignore this email.</p>
                <p style="color: #999999; font-size: 14px;">This code will expire in 10 minutes.</p>
              </td>
            </tr>
          </table>
          <p style="text-align: center; color: #aaaaaa; font-size: 12px; margin-top: 20px;">&copy; 2025 Your Company. All rights reserved.</p>
        </td>
      </tr>
    </table>
  </body>
</html>
