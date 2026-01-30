# Admin Account Management Guide

This document outlines how to manage the Admin account, including updating profile details and resetting the password via email.

## 1. Login to Admin Panel
*   **URL:** `/admin/login.php`
*   **Default Username:** `admin`
*   **Default Email:** `labpc4472@gmail.com`

---

## 2. Managing Admin Profile (Username, Email, Password)
Once logged in, you can update your credentials from the **Admin Profile** page.

### Steps:
1.  Log in to the **Admin Panel**.
2.  Click on the **Profile Icon** (User Avatar) in the top-right corner.
3.  Select **My Profile** from the dropdown menu.
4.  **To Update Details:**
    *   **Username:** Edit the username field.
    *   **Email:** Edit the email field. This email is used for password recovery.
5.  **To Change Password (Optional):**
    *   **New Password:** Enter your new desired password.
    *   **Confirm New Password:** Re-enter the new password.
    *   *Leave these blank if you do not want to change your password.*
6.  **Verify & Save:**
    *   **Current Password:** You **MUST** enter your current password in the red-bordered box at the bottom to authorize any changes.
    *   Click **Save Changes**.

---

## 3. Reset Password (Forgot Password)
If you have forgotten your password, you can reset it using an OTP sent to your registered email.

### Steps:
1.  Go to the **Login Page** (`/login.php`).
2.  Click the **Admin Password Reset** link located below the "Active Account" link.
3.  **Step 1: Request OTP**
    *   Enter your **Admin Username**.
    *   Click **Send OTP**.
    *   Check your email inbox (e.g., `labpc4472@gmail.com`) for a 6-digit code.
4.  **Step 2: Reset Password**
    *   **Enter OTP:** Input the 6-digit code you received.
    *   **New Password:** Enter your new password.
    *   **Confirm New Password:** Re-enter it to confirm.
    *   Click **Reset Password**.
5.  You will be redirected to the login page to sign in with your new credentials.

---

## Troubleshooting
*   **"Unknown column 'email'" Error:**
    *   This means the database update script has not run.
    *   Visit: `http://localhost/hs/db_update_admin_email.php` in your browser once to fix this.
*   **OTP Email Not Received:**
    *   Check your **Spam/Junk** folder.
    *   Ensure the SMTP configuration in `php/send_email.php` is correct and the sender account (`0samsung...`) is active.
