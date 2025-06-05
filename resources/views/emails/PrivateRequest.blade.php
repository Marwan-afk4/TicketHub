<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>New Private Request</title>
</head>
<body style="margin:0; padding:0; font-family: Arial, sans-serif; background-color: #f5f5f5;">
  <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f5f5f5; padding: 20px 0;">
    <tr>
      <td align="center">
        <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 8px; overflow: hidden;">
          <tr>
            <td style="background-color: #007BFF; padding: 20px; color: white; text-align: center;">
              <h2 style="margin: 0;">New Private Request Notification</h2>
            </td>
          </tr>
          <tr>
            <td style="padding: 30px;">
              <p>Dear Agent,</p>
              <p><strong>{{ $private_request_data['user_name'] }}</strong> has just booked a private request. Here are the private request details:</p>

              <table cellpadding="10" cellspacing="0" width="100%" style="border-collapse: collapse; margin-top: 20px;">
                <tr style="background-color: #f0f0f0;">
                  <td><strong>From</strong></td>
                  <td>{{ $private_request_data['from'] }}</td>
                </tr>
                <tr style="background-color: #f0f0f0;">
                  <td><strong>To </strong></td>
                  <td>{{ $private_request_data['to'] }}</td>
                </tr>
                <tr style="background-color: #f0f0f0;">
                  <td><strong>Travelers </strong></td>
                  <td>{{ $private_request_data['travelers'] }}</td>
                </tr>
                <tr>
                  <td><strong>Date</strong></td>
                  <td>{{ $private_request_data['date'] }}</td>
                </tr> 
              </table>

              <p style="margin-top: 30px;">Please follow up with the user for further details.</p>
              <p>Thank you!</p>
            </td>
          </tr>
          <tr>
            <td style="background-color: #f0f0f0; padding: 15px; text-align: center; font-size: 12px; color: #666;">
              &copy; {{ date('Y') }} Tickethub. All rights reserved.
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>
