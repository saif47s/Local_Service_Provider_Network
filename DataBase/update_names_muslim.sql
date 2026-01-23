SET FOREIGN_KEY_CHECKS=0;

-- Update Customers
UPDATE customer SET first_name = 'Bilal', last_name = 'Khan', email = 'bilal.khan@gmail.com' WHERE customer_id = 6;
UPDATE customer SET first_name = 'Usman', last_name = 'Ahmed', email = 'usman.ahmed@gmail.com' WHERE customer_id = 7;
UPDATE login SET username = 'bilal' WHERE login_id = 355;
UPDATE login SET username = 'usman' WHERE login_id = 359;

-- Update Service Providers
UPDATE sp SET sp_name = 'Zain Malik', email = 'zain@gmail.com' WHERE sp_id = 49;
UPDATE sp SET sp_name = 'Hamza Ali', email = 'hamza@gmail.com' WHERE sp_id = 50;
UPDATE sp SET sp_name = 'Ali Ahmed', email = 'ali@gmail.com' WHERE sp_name LIKE '%Ali Ahmed%' OR sp_name LIKE '%Nayan%';
UPDATE sp SET sp_name = 'Omer Farooq', email = 'omer@gmail.com' WHERE sp_id = 56;
UPDATE sp SET sp_name = 'Hassan Raza', email = 'hassan@gmail.com' WHERE sp_id = 57;
UPDATE sp SET sp_name = 'Bilal Siddiqui', email = 'bilal.s@gmail.com' WHERE sp_id = 60;

-- Update Logins for SPs
UPDATE login SET username = 'zain' WHERE login_id = 344;
UPDATE login SET username = 'hamza' WHERE login_id = 345;
UPDATE login SET username = 'ali' WHERE login_id = 347;
UPDATE login SET username = 'omer' WHERE login_id = 351;
UPDATE login SET username = 'hassan' WHERE login_id = 354;
UPDATE login SET username = 'bilal_s' WHERE login_id = 358;

-- Update Order Master Names
UPDATE order_master SET full_name = 'Bilal Khan' WHERE customer_id = 6;
UPDATE order_master SET full_name = 'Usman Ahmed' WHERE customer_id = 7;

SET FOREIGN_KEY_CHECKS=1;
