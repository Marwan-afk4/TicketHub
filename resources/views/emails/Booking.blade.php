<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>New Trip Booking</title>
</head>
<body style="margin:0; padding:0; font-family: Arial, sans-serif; background-color: #f5f5f5;">
  <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f5f5f5; padding: 20px 0;">
    <tr>
      <td align="center">
        <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 8px; overflow: hidden;">
          <tr>
            <td style="background-color: #007BFF; padding: 20px; color: white; text-align: center;">
              <h2 style="margin: 0;">New Trip Booking Notification</h2>
            </td>
          </tr>
          <tr>
            <td style="padding: 30px;">
              <p>Dear Agent,</p>
              <p><strong>{{ $trip['user_name'] }}</strong> has just booked a trip. Here are the trip details:</p>

              <table cellpadding="10" cellspacing="0" width="100%" style="border-collapse: collapse; margin-top: 20px;">
                <tr style="background-color: #f0f0f0;">
                  <td><strong>Trip</strong></td>
                  <td>{{ $trip['trip_name'] }}</td>
                </tr>
                <tr style="background-color: #f0f0f0;">
                  <td><strong>Pickup Station </strong></td>
                  <td>{{ $trip['pickup'] }}</td>
                </tr>
                <tr style="background-color: #f0f0f0;">
                  <td><strong>Dropoff Station </strong></td>
                  <td>{{ $trip['dropoff'] }}</td>
                </tr>
                <tr>
                  <td><strong>Date</strong></td>
                  <td>{{ $trip['date'] }}</td>
                </tr>
                <tr>
                  <td><strong>Departure Time</strong></td>
                  <td>{{ $trip['deputre_time'] }}</td>
                </tr>
                <tr style="background-color: #f0f0f0;">
                  <td><strong>Return Date</strong></td>
                  <td>{{ $trip['arrival_time'] }}</td>
                </tr>
                <tr>
                  <td><strong>Number of Travelers</strong></td>
                  <td>{{ $trip['traveller_number'] }}</td>
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
