# Advanced Backend Technical Documentation & Defense Guide
## Project: Local Service Provider Network (Home Services)

This is an exhaustive guide covering every aspect of the backend development, designed for a high-level FYP defense.

---

## 1. Technology Stack (The Core)
The project is built using a **L.A.M.P / W.A.M.P** stack variant:
- **Server-Side**: PHP 8.x (Hybrid of Procedural for speed and OOP for complex logic like `Pricing.php`).
- **Database**: MySQL 8.0 (Relational DBMS).
- **Frontend-Backend Bridge**: AJAX (JavaScript `fetch` or jQuery `$.ajax`) for asynchronous data exchange.
- **Integrations**: 
    - **PHPMailer / Brevo API**: For transactional emails (OTP, Order Confirmation).
    - **JSON**: Data format for internal API communication.

---

## 2. Database Schema & Normalization
The database `hs` is designed with **3NF (Third Normal Form)** principles to ensure data integrity and zero redundancy.

### Normalization Highlights:
- **1NF**: Atomic values in all columns (e.g., separate tables for orders and order items).
- **2NF**: Removed partial dependencies. Every non-key attribute is fully dependent on the Primary Key.
- **3NF**: Removed transitive dependencies. For example, `login_id` in `customer` and `sp` tables ensures that authentication data is separate from profile data.

### Schema Structure:
- **Authentication**: `login`, `role`.
- **Profiles**: `customer`, `sp` (Service Provider), `admin`.
- **Geography**: `city`, `area`.
- **Services**: `service`, `sp_service` (Many-to-Many relationship).
- **Orders**: `order_master` (General order info), `user_order` (Individual line items/services).
- **Dynamic Logic**: `pricing_rules`.

---

## 3. Complex Queries & Data Retrieval
We use optimized SQL queries to handle complex business logic.
- **Join Queries**: Using `INNER JOIN` and `LEFT JOIN` to combine data from up to 4 tables (e.g., fetching SP details along with their city and service ratings).
- **Aggregation**: Using `AVG()` and `COUNT()` for calculating provider ratings and service demand.
- **Filtering**: Multi-level filtering by City, Area, and Category using `WHERE` clauses combined with `AND/OR` logic.

---

## 4. Security: Data Encryption & Hashing
Data protection is implemented at multiple levels:
- **Hashing**: We never store plain-text passwords. We use **Bcrypt Hashing** via PHP’s `password_hash($pass, PASSWORD_DEFAULT)`.
- **Verification**: `password_verify()` is used during login to compare the input with the stored hash.
- **Encryption (Optional for Defense)**: Mention that sensitive API keys (like Brevo) are stored in server-side variables, not in client-side code.

---

## 5. Vulnerability Protection
The system is hardened against common web attacks:
- **SQL Injection**: Prevented 100% by using **Prepared Statements** (`mysqli_prepare`) and **Parameterized Queries**.
- **XSS (Cross-Site Scripting)**: User inputs are sanitized using `mysqli_real_escape_string()` and output is escaped (e.g., using `htmlspecialchars` in UI components) to prevent malicious script injection.
- **Session Hijacking**: Using `session_start()` with secure flags and regenerating session IDs after login.

---

## 6. Authentication vs. Authorization
- **Authentication (Who are you?)**: Handled in `login.php`. It verifies the username and password.
- **Authorization (What can you do?)**: Handled via **Role-Based Access Control (RBAC)**.
    - `role_id = 1` (Admin): Full access to system settings and user management.
    - `role_id = 2` (Service Provider): Access to gig management and order fulfillment.
    - `role_id = 3` (Customer): Access to booking and profile management.

---

## 7. API Design & Integration
The backend follows a **REST-lite** API design:
- **Endpoints**: Located in the `api/` directory (e.g., `api/dynamic_pricing/calculate_price.php`).
- **Method**: Primarily `POST` for security and large data handling.
- **Response**: Always returns **JSON** objects with `success` flags and `data/message` payloads.
- **Integration**: The frontend JavaScript calls these endpoints to update prices or check availability in real-time.

---

## 8. Concurrency & Error Handling
- **Concurrency**: Handled at the database level. MySQL's **InnoDb** engine uses row-level locking to ensure that if two people book the same service, the data remains consistent.
- **Error Handling**: 
    - **Development**: Detailed errors are logged.
    - **Production**: Users see friendly "Oops" alerts while the technical error is caught via `try-catch` blocks or `if-else` checks on database queries.

---

## 9. Server Deployment & Configuration
- **Local Dev**: XAMPP / WAMP with PHP 8.x.
- **Deployment**: The project is designed to be hosted on any Linux/Windows VPS or Shared Hosting.
- **Configuration**: 
    - `.htaccess` (or `web.config` for IIS) can be used for URL rewriting.
    - `dbconnect.php` handles centralized connection settings.
    - `sync_to_xampp.bat` provides a workflow for rapid local deployment.

---

## 10. Data Security & Backups
- **Validation**: All server-side data is validated again, even if frontend validation exists (Double-Layer Validation).
- **Integrity**: Foreign key constraints in the database prevent "orphan" data (e.g., you cannot delete a service that is currently part of an active order).

---

## Defense "Pro" Tips (The 100-Mark Secret)

### Explain the "Auto-Migration" Logic:
In `DataBase/dbconnect.php`, explain that the system is **self-healing**. It automatically checks if the database schema is up-to-date and adds missing columns/tables on the fly. This shows high-level engineering skills.

### Define the "Middleware" concept:
Explain that your session checks at the top of every file act as a **Security Middleware**, blocking unauthorized access before a single line of the page is rendered.

### Scalability Answer:
If asked "How will this handle 1 million users?", say: 
> "Our modular design allows us to separate the database into a dedicated server and use a Load Balancer for the PHP application. Since we use JSON-based APIs, we can also easily build mobile apps (React Native/Flutter) that consume the same backend logic."
