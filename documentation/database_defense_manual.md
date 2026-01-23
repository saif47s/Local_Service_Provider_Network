# Database Defense Manual (Easy Explanation)

Yeh document aapko database ka defense dene mein madad karega. Ismein har table ka maqsad aur aapas mein connection bataya gaya hai.

## 1. Database Overview
Is project ka database **MySQL (MariaDB)** hai. Iska naam `hs` (Home Services) hai. Ismein total **11 main tables** hain jo ek doosre se judi hui hain (Relational Database).

### Key Concept: Relationships
Sabse pehle yeh samjhein ke data juda kaise hai:
1.  **Users:** `login` table mein sab users (Admin, SP, Customer) hain. `role` table batata hai kaun kya hai.
2.  **Location:** Har `sp` aur `customer` ek `city` aur `area` se juda hai.
3.  **Services:** Pehle `category` hoti hai (e.g. Cleaning), phir uske andar `service` hoti hai (e.g. Sofa Cleaning).
4.  **Gigs:** `sp_service` woh table hai jahan pata chalta hai "Kaunsa SP kaunsi Service de raha hai aur kitne mein".
5.  **Orders:** Order `order_master` mein banta hai, aur uske andar kya items hain woh `user_order` mein save hote hain.

---

## 2. Table Breakdown (One by One)

### A. Core Tables (Login & Users)
| Table Name | Description | Key Columns |
| :--- | :--- | :--- |
| **`role`** | Batata hai user ki type kya hai (1=Admin, 2=SP, 3=Customer). | `role_id` (PK), `role_name` |
| **`login`** | Sabka username aur password yahan save hota hai. | `login_id` (PK), `username`, `password` |
| **`customer`** | Customer ki personal details. `login_id` se link hota hai. | `customer_id` (PK), `login_id` (FK), `phone`, `address` |
| **`sp`** | Service Provider ki details aur **Wallet Balance**. | `sp_id` (PK), `login_id` (FK), `wallet_balance` |

### B. Location Tables
| Table Name | Description | Key Columns |
| :--- | :--- | :--- |
| **`city`** | Shehron ke naam (e.g., Karachi, Lahore). | `city_id` (PK), `city_name` |
| **`area`** | Har city ke andar ke areas. | `area_id` (PK), `city_id` (FK) |

### C. Services & Gigs
| Table Name | Description | Key Columns |
| :--- | :--- | :--- |
| **`category`** | Bari categories (e.g., Plumbing, Electrician). | `category_id` (PK) |
| **`service`** | Specific kaam (e.g., Fan Repair, Tap Leakage). | `service_id` (PK), `category_id` (FK) |
| **`sp_service`** | **(Important)** Yeh table jodta hai SP ko Service se. Isse pata chalta hai ke SP specific kaam kitne paise mein kar raha hai. | `sp_id`, `service_id`, `price` |

### D. Ordering System (Imp for Defense)
Examiner poochega: *"Order kaise save hota hai?"*
Jawab: *"Order do hisson mein save hota hai: Master aur Detail."*

1.  **`order_master`**: Ismein order ki **Head** details hoti hain (Kis customer ne diya, kab diya, total bill kya hai).
    *   *Columns:* `order_id` (PK), `customer_id`, `total`, `order_date`, `status`.
2.  **`user_order`**: Ismein order ki **Items** hoti hain (Kya mangwaya, kitni quantity, kis SP se).
    *   *Columns:* `order_id` (FK), `service_id`, `sp_id`, `qty`, `price`.

### E. Finance (Wallet)
| Table Name | Description | Key Columns |
| :--- | :--- | :--- |
| **`wallet_transactions`** | SP ke wallet ki history (Recharge ya Commission deduction). | `transaction_id`, `sp_id`, `amount`, `type` (credit/debit) |

---

## 3. Important Design Concepts (Defense Questions)

**Q1: Primary Key (PK) aur Foreign Key (FK) kya hai?**
*   **PK:** Table ki har line ko unique banata hai (Jaise Roll Number). E.g., `customer_id`.
*   **FK:** Doosre table ki PK hoti hai jo link karne ke liye use hoti hai. E.g., `customer` table mein `city_id` ek FK hai jo `city` table se aayi hai.

**Q2: Normalization kya hai?**
*   **Answer:** "Data ko duplication se bachane ke liye tables ko todna."
*   **Example:** Humne customer table mein shehar ka naam baar baar likhne ke bajaye `city_id` likha hai aur naam alag `city` table mein rakha hai. Isse spelling mistakes nahi hotin aur space bachti hai.

**Q3: 1 to 1 aur 1 to Many relationship kahan hai?**
*   **1 to 1:** `login` table aur `customer` table. (Ek login ka ek hi customer profile hai).
*   **1 to Many:** `city` aur `area`. (Ek city mein bohot se area ho sakte hain).
*   **Many to Many:** `sp` aur `service`. (Ek SP bohot services de sakta hai, aur ek service bohot se SP de sakte hain). Isliye humne beech mein `sp_service` table banaya.

---

## 4. One-Liner Defense Lines

*   "Sir, maine database ko **3NF (Third Normal Form)** tak normalize kiya hai taake data repeat na ho."
*   "Maine **Integrity Constraints** (Foreign Keys) use kiye hain taake agar 'City' delete ho toh uske 'Areas' ka data inconsistent na ho (Cascade Delete)."
*   "Security ke liye passwords ko `hash` kar ke store kiya hai, plain text mein nahi."
