# Brevo (Sendinblue) Setup Guide

**Brevo** (formerly Sendinblue) is a professional email service. It is far better than Gmail for websites because it is designed to send automated emails (like OTPs) without blocking them.

## Why Brevo helps you
1.  **It Works:** It doesn't block "Unknown Devices" like Gmail does.
2.  **It's Free:** You can send 300 emails per day for free.
3.  **It's Simple:** You get one "Key" and it works forever. No need to change passwords properly.

## How to Set It Up (3 Minutes)

### Step 1: Create a Free Account
1.  Go to **[https://www.brevo.com/](https://www.brevo.com/)**.
2.  Click **"Sign Up Free"**.
3.  Fill in your details. (You can skip "Company" details by putting "Personal Project").

### Step 2: Get Your SMTP Key
1.  Once logged in, click your **Profile Icon** (top right) -> **SMTP & API**.
    *   *Or go to this link:* [https://app.brevo.com/settings/keys/smtp](https://app.brevo.com/settings/keys/smtp).
2.  Click on the **SMTP** tab (Not API Keys).
3.  Click **"Generate a new SMTP key"**.
4.  Name it "MyProject".
5.  **COPY THE PASSWORD IMMEDIATELY.** You will not see it again.
    *   It will look like a long string of random letters: `xsmtpsib-a1b2c3d4...`

### Step 3: Use it in your Code
Open `php/send_otp.php` or `php/test_smtp.php` and use these details:

*   **Host:** `smtp-relay.brevo.com`
*   **Port:** `587`
*   **Username:** (The email you used to Login to Brevo)
*   **Password:** (The long Key you just copied)

---

> [!TIP]
> **Important:** Your "Username" is your **Brevo Login Email**, NOT "Project Name".
> The "Password" is the **SMTP Key**, NOT your Brevo Account Password.
