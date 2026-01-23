SET FOREIGN_KEY_CHECKS=0;

-- 1. Get Chakwal City ID
SET @chakwal_id = (SELECT city_id FROM city WHERE city_name = 'Chakwal' LIMIT 1);

-- 2. Clear existing areas for Chakwal to avoid duplicates/confusion and ensure fresh list
DELETE FROM `area` WHERE `city_id` = @chakwal_id;

-- 3. Insert Comprehensive List of Areas
INSERT INTO `area` (`city_id`, `area_name`) VALUES 
-- Tehsils
(@chakwal_id, 'Chakwal Tehsil'),
(@chakwal_id, 'Choa Saidan Shah Tehsil'),
(@chakwal_id, 'Kallar Kahar Tehsil'),
(@chakwal_id, 'Lawa Tehsil'),
(@chakwal_id, 'Talagang Tehsil'),

-- Main Towns and Notable Areas
(@chakwal_id, 'Bhaun'),
(@chakwal_id, 'Bhagwal'),
(@chakwal_id, 'Bhon'),
(@chakwal_id, 'Bilalabad'),
(@chakwal_id, 'Budhial'),
(@chakwal_id, 'Danda Shah Bilawal'),
(@chakwal_id, 'Dharyala Kahoon'),
(@chakwal_id, 'Dhoda Town'),
(@chakwal_id, 'Dhudial'),
(@chakwal_id, 'Dulla'),
(@chakwal_id, 'Dulmial'),
(@chakwal_id, 'Jand Awan'),
(@chakwal_id, 'Kallar Kahar'),
(@chakwal_id, 'Khanpur'),
(@chakwal_id, 'Lawa'),
(@chakwal_id, 'Mulhal Mughlan'),
(@chakwal_id, 'Mureed'),
(@chakwal_id, 'Neela Dullah'),
(@chakwal_id, 'Ratta Sharif'),
(@chakwal_id, 'Sarkal kassar'),
(@chakwal_id, 'Sohawa'),
(@chakwal_id, 'Surhali'),
(@chakwal_id, 'Tamman'),
(@chakwal_id, 'Thaneel Kamal'),

-- Union Councils (selected)
(@chakwal_id, 'Ara'),
(@chakwal_id, 'Basharat'),
(@chakwal_id, 'Bheen'),
(@chakwal_id, 'Bhekarl Kalan'),
(@chakwal_id, 'Bigal'),
(@chakwal_id, 'Blokassar'),
(@chakwal_id, 'Chak Malook'),
(@chakwal_id, 'Chak Umra'),
(@chakwal_id, 'Choa Ganj Ali Shah'),
(@chakwal_id, 'Dab'),
(@chakwal_id, 'Dalwal Mah Badshah Pur'),
(@chakwal_id, 'Dandot'),
(@chakwal_id, 'Dhoular'),
(@chakwal_id, 'Dhumman'),
(@chakwal_id, 'Jabirpur'),
(@chakwal_id, 'Jand'),
(@chakwal_id, 'Karsal'),
(@chakwal_id, 'Karyala'),
(@chakwal_id, 'Khal'),
(@chakwal_id, 'Khair Pur'),
(@chakwal_id, 'Khotian'),
(@chakwal_id, 'Kot Chaudhrian'),
(@chakwal_id, 'Lehr Sultan Pur'),
(@chakwal_id, 'Mengan'),
(@chakwal_id, 'Mogla'),
(@chakwal_id, 'Odherwal'),
(@chakwal_id, 'Padshahan'),
(@chakwal_id, 'Salol'),
(@chakwal_id, 'Saral'),
(@chakwal_id, 'Warwal');

SET FOREIGN_KEY_CHECKS=1;
