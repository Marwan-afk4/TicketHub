<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Agent Confirmation</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">
  <table width="100%" bgcolor="#f4f4f4" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center">
        <table width="600" cellpadding="0" cellspacing="0" bgcolor="#ffffff" style="margin: 20px auto; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); overflow: hidden;">
          <!-- Header -->
          <tr>
            <td bgcolor="#007bff" style="padding: 20px; color: #ffffff; text-align: center;">
              <h1 style="margin: 0;">Welcome,</h1>
            </td>
          </tr>

          <!-- Body -->
          <tr>
            <td style="padding: 30px; text-align: left; color: #333;">
              <p style="font-size: 16px; margin: 0 0 20px;">Dear {{ $agent['name'] }},</p>
              <p style="font-size: 16px; margin: 0 0 20px;">
                Congratulations! You have been successfully registered as an agent in our system.
              </p>
              <p style="font-size: 16px; margin: 0 0 20px;">
                You can now access your dashboard, manage your profile, and start using your agent privileges right away.
              </p>  

              <p style="font-size: 14px; color: #666;">Thank you,<br>The Tickethub Team</p>
            </td>
          </tr>

          <!-- Footer -->
          <tr>
            <td bgcolor="#eeeeee" style="padding: 15px; text-align: center; font-size: 12px; color: #999;">
              &copy; {{ date('Y') }} Tickethub. All rights reserved.
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>
