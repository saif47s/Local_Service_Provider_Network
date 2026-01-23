SET FOREIGN_KEY_CHECKS=0;

TRUNCATE TABLE city;
INSERT INTO city (city_id, city_name) VALUES
(1, 'Karachi'),
(2, 'Lahore'),
(3, 'Islamabad'),
(4, 'Rawalpindi'),
(5, 'Faisalabad'),
(6, 'Multan'),
(7, 'Peshawar'),
(8, 'Quetta');

-- Update Provider Nayan -> Ali Ahmed
UPDATE login SET username = 'ali' WHERE username = 'nayan';
UPDATE sp SET sp_name = 'Ali Ahmed' WHERE sp_name = 'Nayan';

-- Update addresses for users to be generic Pakistani
UPDATE customer SET address = 'House 123, Street 4, F-10, Islamabad' WHERE customer_id = 6;
UPDATE customer SET address = 'Flat 4, Clifton, Karachi' WHERE customer_id = 7;

SET FOREIGN_KEY_CHECKS=1;
