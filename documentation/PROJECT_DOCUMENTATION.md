
# Hyper Local Service Provider - Complete Project Documentation (A to Z)

## 1. Project Overview
**Project Name:** Hyper Local Service Provider
**Purpose:** A comprehensive web-based marketplace connecting customers with professional service providers (SPs) for home services (Cleaning, Repair, Plumbing, etc.).
**Business Model:** The platform operates on a **5% Platform Fee** model, automatically calculated on every service.

---

## 2. Technology Stack
*   **Backend:** PHP (Native)
*   **Database:** MySQL (Database Name: `hs`)
*   **Frontend:** HTML5, CSS3, JavaScript, Bootstrap 4
*   **Server Environment:** XAMPP (Apache & MySQL)
*   **Mailing:** PHPMailer / SendGrid integration for OTPs.

---

## 3. User Roles & Modules

### A. Admin Module (Master Control)
*   **Dashboard:** Real-time stats on SPs, Customers, Orders, and Total Revenue (5% commission).
*   **User Management:** Approve/Deactivate SPs and Customers.
*   **Service & Category Control:** Full CRUD operations for service categories and monitoring all GIGs.
*   **Dynamic Fuel Price:** Admin can set the global **Fuel Price per Kilometer** from the sidebar.
*   **Profile Management:** 
    *   Secure email and password updates.
    *   **Old Password Verification:** Required to authorize any profile changes.
*   **GIG Deletion:** Admin can delete any specific service gig listed by an SP if it violates policies.
*   **Reports:** Generate detailed order and revenue reports.
*   **Wallet Management:** Approve/Reject withdrawal and top-up requests from SPs.

### B. Service Provider (SP) Module
*   **GIG Creation:** SPs can list multiple services with titles, descriptions, and custom pricing.
*   **Dashboard:** View pending orders, completed jobs, and wallet balance.
*   **Order Workflow:** Accept or Reject customer requests. Mark orders as "Completed" upon delivery.
*   **Wallet System:** 
    *   Tracks earnings minus the 5% platform fee.
    *   Automatic deduction of platform fees upon job completion.
*   **Agreement:** SPs must agree to platform fee terms during signup.

### C. Customer Module
*   **Booking Engine:** Search by category and view detailed SP profiles and GIGs.
*   **Enhanced Cart:** 
    *   **Pincode Validation:** Restricts input to 5 numeric digits.
    *   **Service Location Display:** See the SP's address directly in the cart.
    *   **Dynamic Totaling:** Real-time calculation of Item Total, Platform Fee, and Final Total.
*   **Location Filtering:**
    *   Horizontal filter bar on the service listing page.
    *   Filter by **City** and **Area** to find nearby providers.
    *   **Dynamic Areas:** Area list updates automatically based on the selected city (AJAX).
*   **Order History:** Track booking status from "Pending" to "Completed".

---

## 4. Advanced Logic & Engines

### A. Dynamic Pricing Engine (Advanced)
The system calculates the final price based on multiple real-time factors:
1.  **Base Price:** The original price set by the SP.
2.  **Specific Provider Availability:** 
    *   **Multiplier:** 1.0x (Free) or 1.5x (Busy).
    *   **Logic:** Checks the specific SP's schedule. If they have an active order on the requested date/time, a surcharge is applied.
3.  **Urgency Surcharge:**
    *   **Normal:** 1.0x
    *   **Urgent:** 1.2x
    *   **Emergency:** 1.5x
4.  **Time/Day Factors:** Weekend surcharges (Saturday/Sunday) and Peak Hour (8 PM - 12 AM) surcharges.
5.  **Zone Surcharge:** Premium multipliers based on specific areas/zones.

### B. Fuel Charge System
*   **Rate:** Set by Admin (e.g., Rs 7/km).
*   **Agreement:** Customers must check a mandatory box agreeing to pay fuel charges based on the distance from the SP to their address.
*   **Transparency:** A persistent badge in the cart displays the current fuel rate.

### C. Validation & Security
*   **Future Date/Time Picker:** Prevents users from selecting past dates or times for service.
*   **OTP Verification:** Used for "Forgot Password" to ensure account security.
*   **Admin Access:** Fixed blank-page issue for Admin Forgot Password.

---

## 5. Database Schema (Key Tables)
*   **`login`**: Stores credentials for all roles (Admin: 1, SP: 2, Customer: 3).
*   **`sp`**: Profile details, status, and address for providers.
*   **`customer`**: Profile details for users.
*   **`sp_service`**: The "GIGs" table containing service titles, prices, and availability.
*   **`order_master`**: Main order tracking table.
*   **`settings`**: Global configuration (e.g., `fuel_price`).
*   **`wallet_transactions`**: Logs for all financial movements.

---

## 6. Setup & Portability
To run this project on any system:
1.  Place files in `htdocs/BCA-home-Services-Project-master`.
2.  Import `hs_database.sql` into a MySQL database named `hs`.
3.  Configure `DataBase/dbconnect.php` with correct database credentials.
4.  Access via `localhost/BCA-home-Services-Project-master/`.

---
 Final Version 8, May 2026*
