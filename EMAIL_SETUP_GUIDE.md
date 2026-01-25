# How to Fix Email Sending (Gmail OTP)

The likely reason your OTP emails are not arriving is that the code is using placeholder credentials or your Gmail account is blocking the connection.

## Step 1: Generate a Gmail App Password
Because of security reasons (2FA), you cannot use your normal Gmail password. You must generate an App Password.

1.  Go to your **Google Account** settings: https://myaccount.google.com/
2.  Select **Security** from the left menu.
3.  Under **"Signing in to Google"**, make sure **2-Step Verification** is turned **ON**.
4.  Once 2FA is on, click on **2-Step Verification** and scroll to the bottom.
5.  Look for **"App passwords"** (you might need to search for it in the search bar at the top if hidden).
6.  Create a new app password:
    *   **App**: select "Mail"
    *   **Device**: select "Other (Custom name)" -> Name it "MyProject"
7.  Click **Generate**.
8.  Copy the 16-character password (e.g., `abcd efgh ijkl mnop`).

## Step 2: Update the Code
Open the file `php/send_otp.php` and update it with your email and the new App Password.

```php
// php/send_otp.php

$mail->Username = 'your_actual_email@gmail.com'; // REPLACE THIS
$mail->Password = 'abcd efgh ijkl mnop';         // PASTE YOUR APP PASSWORD HERE
```

## Step 3: Test
1.  Try signing up again.
2.  If it still fails, check the `verify_otp.php` page. It shows the "Debug OTP" in a yellow box at the top (Localhost only), so you can still log in even if email fails.
