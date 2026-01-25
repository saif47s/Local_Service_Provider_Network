# Software Requirements Specification (SRS)
**Project Name:** Hyper Local Service Provider
**Version:** 3.0 (Major Update)
**Date:** 2026-01-25
**Status:** Live & Production Ready
**Maintained By:** Antigravity (AI Agent)

---

## 1. Introduction

### 1.1 Purpose
The purpose of this document is to provide a comprehensive, detailed "A to Z" reference for the **Hyper Local Service Provider** application. It documents every module, feature, function, database entity, and technical implementation detail to serve as the single source of truth for developers and stakeholders.

### 1.2 Project Scope
**Hyper Local Service Provider** is a web-based platform designed to bridge the gap between skilled service professionals (plumbers, electricians, cleaners, etc.) and local customers.
-   **Customers** can search, view, and book services for their homes.
-   **Service Providers (SPs)** can register, list their gigs (services), and manage incoming orders.
-   **Administrators** oversee the entire ecosystem, approving professionals and managing categories.

The system features robust authentication, email verification, wallet management, and order tracking.

---

## 2. Technical Architecture

### 2.1 Technology Stack
*   **Operating System:** Windows (Development), Linux (Production compatible).
*   **Server Environment:** XAMPP (Apache HTTP Server).
*   **Backend Language:** PHP 7.4+ (Procedural & Object-Oriented Hybrid).
*   **Database:** MariaDB / MySQL (Relational Database Management System).
*   **Frontend Interface:** HTML5, CSS3, Bootstrap 4, JavaScript (ES6), jQuery.
*   **Email Engine:** PHPMailer 6.x (SMTP).
*   **PDF Engine:** mPDF (Composer Dependency).

### 2.2 Directory Structure
*   **`/` (Root):** Core entry points (`index.php`, `login.php`, `signup.php`).
*   **`admin/`:** Restricted portal for System Administrators.
*   **`customer/`:** Dashboard and features for end-users.
*   **`serviceprovider/`:** Workspace for professionals.
*   **`DataBase/`:** SQL schemas and `dbconnect.php`.
*   **`php/`:** Backend logic scripts (`send_email.php`, `invoice.php`).
*   **`includes/`:** Reusable UI components (`header.php`, `navbar.php`, `footer.php`).
*   **`ForgotPassword/`:** Dedicated module for password recovery.

---

## 3. Module-Wise Functional Requirements

### 3.1 Authentication & Security Module (Global)
This module acts as the gatekeeper for the entire application.

*   **REQ-AUTH-01: Dual-Layer Login System**
    *   **File:** `login.php`
    *   **Logic:** Accepts Username & Password.
    *   **Verification:** Checks credentials against `login` table.
    *   **Routing:** 
        *   If `role_id = 1` -> Redirect to `admin/`.
        *   If `role_id = 2` -> Redirect to `serviceprovider/`.
        *   If `role_id = 3` -> Redirect to `customer/`.
*   **REQ-AUTH-02: User Registration (Customer)**
    *   **File:** `signup.php`
    *   **Input:** Name, Email, Phone, Address, City (Ajax fetch), Area, Username, Password.
    *   **Security:** Password hashing via `password_hash()` (Bcrypt).
    *   **Verification:** Generates a secure random 32-char token.
*   **REQ-AUTH-03: Service Provider Registration**
    *   **File:** `sp_signup.php`
    *   **Input:** SP Name, Contact Info, Service City.
    *   **Payment:** Requires `transaction_id` for wallet verification (Easypaisa/JazzCash).
    *   **Default Status:** `deactive` (Requires Admin Approval).
*   **REQ-AUTH-04: Token-Based Email Verification**
    *   **Mechanism:** When a user signs up, a unique Hex Token is generated.
    *   **Email:** A "Verify Account" link is sent via SMTP (`php/send_email.php`).
    *   **Verification:** Clicking the link triggers `verify_email.php`, which validates the token and updates `is_verified = 1` in the database.
*   **REQ-AUTH-05: Forgot Password System**
    *   **File:** `ForgotPassword/Email/email.php`
    *   **Logic:** Confirms Username matches Email.
    *   **OTP:** Generates a 4-digit numeric OTP.
    *   **Email:** Sends OTP using the shared `sendEmail()` function.
    *   **Reset:** Verifies OTP and allows password update (`password_hash` updated in DB).

### 3.2 Customer Module
*   **REQ-CUS-01: Smart Search & Filtering**
    *   **Global Search:** Keyword-based search bar in header.
    *   **Category Filter:** Browse by 'Plumbing', 'Beauty', 'Cleaning', etc.
*   **REQ-CUS-02: Cart Management**
    *   **Files:** `manage_cart.php`, `mycart.php`.
    *   **Logic:** Session-based cart (`$_SESSION['cart']`). Supports Adding, Removing, and preventing duplicate items.
*   **REQ-CUS-03: Checkout & Ordering**
    *   **File:** `order.php`.
    *   **Process:** 
        *   Summarizes Total.
        *   Adds **5% Platform Commission**.
        *   Captures Delivery Address.
        *   Saves Order Master & Order Items to DB.
*   **REQ-CUS-04: Booking History & Invoices**
    *   **Dashboard:** View Active and Past orders.
    *   **Invoice:** Generate PDF Receipt (`invoice.php`) with breakdown of services and taxes.

### 3.3 Service Provider (SP) Module
*   **REQ-SP-01: Dashboard Overview**
    *   **Real-time Stats:** Pending Orders, Completed Jobs, Wallet Balance.
*   **REQ-SP-02: Gig (Service) Management**
    *   **Create:** Add new service listing -> Select Category -> Set Title -> Set Price.
    *   **Manage:** Toggle Availability (On/Off), Edit Description.
*   **REQ-SP-03: Order Fulfillment**
    *   **Action:** Accept or Reject incoming bookings.
    *   **Status Update:** Mark jobs as "Completed" upon finishing.
*   **REQ-SP-04: Digital Wallet System**
    *   **Commission Model:** 5% commission is auto-deducted from Wallet when an order is placed.
    *   **Recharge:** Admin-verified manual recharge requests.

### 3.4 Admin Module
*   **REQ-ADM-01: User Management**
    *   View all Customers and Service Providers.
    *   **Approve/Block** Service Providers based on documents/payment.
*   **REQ-ADM-02: Master Data Management**
    *   Add/Edit **Cities** and **Areas**.
    *   Add/Edit **Service Categories**.
*   **REQ-ADM-03: Financial Oversight**
    *   View all Orders.
    *   Monitor Wallet Transactions.

---

## 4. Database Schema ('A to Z')
Database Name: `hs`

### 4.1 Master Entity Tables
1.  **`role`**
    *   `role_id` (PK), `role_name` (admin, serviceprovider, customer).
2.  **`city`**
    *   `city_id` (PK), `city_name`.
3.  **`area`**
    *   `area_id` (PK), `city_id` (FK), `area_name`.
4.  **`category`**
    *   `category_id` (PK), `category_name`.
5.  **`service`** (Global Service Types)
    *   `service_id` (PK), `category_id` (FK), `service_name`, `service_availibility` (Bool).

### 4.2 Auth & User Data Tables
6.  **`login`** (Central Auth)
    *   `login_id` (PK)
    *   `username` (Unique)
    *   `password` (VARCHAR 255 - Hashed)
    *   `role_id` (FK)
    *   `is_verified` (TinyInt)
    *   `verification_code` (VARCHAR 255 - Token)
7.  **`customer`**
    *   `customer_id` (PK), `login_id` (FK), `first_name`, `last_name`, `email`, `phone`, `address`, `city_id`, `area`.
8.  **`sp`** (Service Provider Profile)
    *   `sp_id` (PK)
    *   `login_id` (FK)
    *   `sp_name`, `email`, `phone`, `city_id`
    *   `status` (active/deactive)
    *   `wallet_balance` (DECIMAL 10,2) - **Critical for Commission Logic**.

### 4.3 Transactional Tables
9.  **`sp_service`** (Specific Gigs listed by SPs)
    *   `sp_id` (FK), `service_id` (FK) - Composite PK.
    *   `service_title`, `price`, `description`, `availability`.
10. **`order_master`** (Order Header)
    *   `order_id` (PK), `customer_id` (FK), `total`, `commission`, `order_date`, `due_date`.
11. **`user_order`** (Order Line Items)
    *   `order_id` (FK), `service_id` (FK), `sp_id` (FK), `price`, `status` (pending/completed).

---

## 5. Security Implementations

### 5.1 Password Security
*   **Algorithm:** BCRYPT.
*   **Implementation:** `password_hash($pass, PASSWORD_DEFAULT)` on signup/reset.
*   **Validation:** `password_verify($input, $hash)` on login.

### 5.2 Input Sanitation
*   **XSS Protection:** Usage of `htmlentities()` on user inputs (e.g., in `email.php` and registration).
*   **SQL Injection:** Use of `mysqli_real_escape_string` (Legacy parts) or Prepared Statements (Newer modules).

### 5.3 Session Security
*   **Access Control:** Every sensitive page checks `$_SESSION` for role authorization.
*   **Session Fixation:** `session_start()` is called globally in header.

---

## 6. Email Configuration (Technical)

*   **Library:** PHPMailer 6.x.
*   **Core Logic:** `php/send_email.php`.
*   **Functions:**
    1.  `sendEmail($to, $subject, $body)`: Generic wrapper for sending HTML emails.
    2.  `sendVerificationEmail($to, $token)`: Generates dynamic verification link.
*   **SMTP Settings:**
    *   Host: `smtp.gmail.com`
    *   Port: `587`
    *   Encryption: `TLS`
    *   Auth: OAuth/App Password.

---
*End of Specification*
