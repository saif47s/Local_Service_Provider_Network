# Software Requirements Specification (SRS)
**Project Name:** Hyper Local Service Provider
**Version:** 1.1
**Date:** 2026-01-17
**Status:** Completed

---

## 1. Introduction

### 1.1 Purpose
The purpose of this document is to present a detailed description of the **Hyper Local Service Provider** system. It explains the purpose, features, interfaces, and logical constraints of the system. This document serves as the "A to Z" reference for the implemented solution.

### 1.2 Scope
The **Hyper Local Service Provider** is a web-based marketplace designed to connect service providers (plumbers, electricians, beauty experts, etc.) with customers in Pakistan. The system facilitates:
*   **Service Discovery:** Customers can browse/search for services by category.
*   **Booking Management:** Secure booking with Cash on Delivery (COD) payment.
*   **Provider Management:** SPs can register, list services, and manage orders.
*   **Revenue Generation:** A 5% platform commission is automatically calculated and deducted from the Service Provider's wallet upon order placement.
*   **Localization:** Tailored for Pakistani users with local currency (Rs.), cities, and manual area entry.
*   **Mobile Access:** Android App (Webview) provided for easy access.

### 1.3 Definitions, Acronyms, and Abbreviations
*   **SRS:** Software Requirements Specification
*   **SP:** Service Provider
*   **COD:** Cash On Delivery
*   **Admin:** System Administrator
*   **Wallet:** Digital balance maintained by SPs to pay platform fees.

---

## 2. Overall Description

### 2.1 Product Perspective
This system is a comprehensive web application running on a LAMP/XAMPP stack (Windows/Apache/MySQL/PHP). It operates as a centralized platform where multiple independent Service Providers list their services, and Customers book them. The codebase is organized with a centralized `DataBase` folder for connection management.

### 2.2 User Characteristics
1.  **Administrator:** Tech-savvy user responsible for platform oversight, SP approval, wallet recharge approval, and revenue monitoring.
2.  **Service Provider (SP):** Professionals offering home services. They manage their Gigs and Wallet.
3.  **Customer:** General public looking for home services. Uses a simple Cart and Checkout interface.

---

## 3. System Features (Functional Requirements)

### 3.1 Customer Module
#### 3.1.1 Registration & Authentication
*   **REQ-C-1:** Users register with Name, Email, Phone, Address, City, Area, and Pincode.
*   **REQ-C-2:** Secure Login using Username and Password.

#### 3.1.2 Service Discovery
*   **REQ-C-3:** Services are categorized (e.g., Cleaning, Plumbing) and searchable.
*   **REQ-C-4:** Users view "Starts at" pricing in **Rs.** currency.
*   **REQ-C-5:** **SP Location Display:** Service listings show the Provider's City and Area for better decision making.

#### 3.1.3 Booking & Cart
*   **REQ-C-6:** Users can add multiple services to a Cart.
*   **REQ-C-7:** **Platform Fee:** The Cart automatically adds a **5% Platform Fee** to the Order Total.
*   **REQ-C-8:** **Checkout:** Users confirm details (Name, Phone, Address) and select Service Date/Time.
*   **REQ-C-9:** **Order Placement:** Upon confirmation, the order is saved to the database (`order.php`), and the system:
    *   Generates a unique Order ID.
    *   Saves order items in `user_order`.
    *   **Deducts Commission** from the Service Provider's Wallet.

### 3.2 Service Provider (SP) Module
#### 3.2.1 Registration & Profile
*   **REQ-SP-1:** SPs register with professional details (Category, Location, Phone).
*   **REQ-SP-2:** **Verification:** SPs must provide a Transaction ID (Easypaisa/JazzCash) during signup.
*   **REQ-SP-3:** New accounts require **Admin Approval** before activation.

#### 3.2.2 Service & Order Management
*   **REQ-SP-4:** SPs can Create, Read, Update, and Delete (CRUD) their service gigs.
*   **REQ-SP-5:** **Order Management:** View incoming orders with status (Pending, Completed).
*   **REQ-SP-6:** **Dashboard Stats:** View Total Income, Pending Orders, and Wallet Balance.

#### 3.2.3 Wallet System
*   **REQ-SP-7:** **Digital Wallet:** Every SP has a wallet balance to pay the platform commission.
*   **REQ-SP-8:** **Recharge:** SPs can request a wallet recharge by entering an Amount and Manual Transaction ID (e.g., Bank Transfer Ref).
*   **REQ-SP-9:** **History:** View detailed transaction history (Credits via Recharge, Debits via Commission).
*   **REQ-SP-10:** **Auto-Debit:** When a customer places an order, the 5% commission is automatically debited from the SP's wallet.

### 3.3 Admin Module
#### 3.3.1 Platform Management
*   **REQ-A-1:** **Dashboard:** Overview of Total SPs, Customers, Orders, and Revenue.
*   **REQ-A-2:** **SP Management:** Verify and Approve/Delete Service Providers.
*   **REQ-A-3:** **Category Management:** Add/Edit/Delete Service Categories.

#### 3.3.2 Financial Management
*   **REQ-A-4:** **Wallet Requests:** View pending recharge requests. Actions: **Approve** (Credits SP Wallet) or **Reject**.
*   **REQ-A-5:** **Revenue Reporting:**
    *   "Total Revenue" Widget on Dashboard links to detailed report.
    *   **Detailed View:** Table displaying Order ID, Date, Customer Name, SP Name, Service, and Commission Earned.

### 3.4 Android App (Webview)
*   **REQ-APP-1:** An Android application wrapper uses a Webview to display the responsive website.
*   **REQ-APP-2:** Allows full functionality (Login, Order, Wallet) on mobile devices.

---

## 4. Data Model (Database Schema)

The system uses a Relational Database (MySQL) with the following core entities:

### 4.1 Core Tables
1.  **`login`**: Authentication (`username`, `password`, `role_id`).
2.  **`customer`**: Customer profile (`name`, `phone`, `address`, `city_id`, `area`, `pincode`).
3.  **`sp`**: Service Provider profile (`name`, `phone`, `status`, `wallet_balance`).
    *   **New Column:** `wallet_balance` (DECIMAL 10,2).
4.  **`category`** & **`service`**: Service Taxonomy.
5.  **`sp_service`**: SP Gigs (`price`, `description`, `sp_id`).

### 4.2 Order & Financial Tables
6.  **`order_master`**:
    *   `order_id` (PK), `customer_id` (FK), `total` (Grand Total), `commission` (Revenue), `order_date`, `due_date`, `status`, `pay_mode`.
7.  **`user_order`**:
    *   Line items: `order_id`, `service_title`, `price`, `qty`, `sp_id`, `status`.
8.  **`wallet_transactions`**:
    *   Ledger for SP Wallets: `transaction_id`, `sp_id`, `amount`, `type` ('credit'/'debit'), `status`, `manual_txn_id`, `created_at`, `description`.

---

## 5. Non-Functional Requirements

### 5.1 Performance
*   Optimized database queries for fast search and listing.
*   Efficient session management for Cart and User state.

### 5.2 Usability
*   Mobile-first responsive design using Bootstrap.
*   Clear "Rs." currency formatting.
*   Simple 3-step checkout process.

### 5.3 Security
*   **Password Hashing:** `bcrypt` used for all user passwords.
*   **Session Security:** Role-based access control (Admin, SP, Customer).
*   **Input Sanitization:** Order inputs are sanitized to prevent SQL Injection.

---

## 6. Implementation Details

### 6.1 Database Organization
*   Allows cleaner project structure.
*   **Centralized Connection:** All database connections use `DataBase/dbconnect.php`.
*   **Schema Files:** All `.sql` files are stored in the `DataBase/` directory.

### 6.2 Key Workflows
*   **Ordering:** Customer Cart -> `mycart.php` -> `order.php` (Logic: Insert -> Deduct Wallet -> Log -> Success).
*   **Wallet Recharge:** SP Wallet Page -> Submit Request -> Admin Wallet Requests -> Approve -> Balance Credits.

---
*Created by Antigravity - AI Agent*



Response: PHPMailer ke alawa alternatives ye hain:

Project ko Live Host karna (Sabse Aasan): Agar aap apne project ko kisi online server (jaise 000webhost, InfinityFree, ya GoDaddy) par upload kar dete hain, to wahan default email automatic chalti hai. Aapko koi extra code ya setup nahi karna padega.
XAMPP sendmail.exe Config: Aap XAMPP ki php.ini file edit karke email chalu kar sakte hain. Lekin ismein bhi same Gmail App Password wali requirement rahegi.
Third-Party APIs (SendGrid, Mailgun): Ye professional email services hain. Inka setup PHPMailer se bhi thoda mushkil ho sakta hai (API Keys chahiye hoti hain).
Mera Mashwara (Recommendation):

Agar aap App Password generate nahi kar pa rahe, to Project ko Live Server par daal dein.
Agar localhost par hi rakhna hai, to PHPMailer hi iklauta reliable solution hai.
Ya phir abhi wala Alert Box (Popup) accept kar lein, kyunki localhost par yahi standard saving method hai.
