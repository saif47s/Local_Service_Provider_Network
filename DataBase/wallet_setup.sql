-- Add wallet_balance to sp table
ALTER TABLE `sp` ADD `wallet_balance` DECIMAL(10,2) NOT NULL DEFAULT '0.00';

-- Create wallet_transactions table
CREATE TABLE `wallet_transactions` (
  `transaction_id` int(11) NOT NULL AUTO_INCREMENT,
  `sp_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `type` enum('credit','debit') NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `manual_txn_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`transaction_id`),
  KEY `sp_id` (`sp_id`),
  CONSTRAINT `wallet_transactions_ibfk_1` FOREIGN KEY (`sp_id`) REFERENCES `sp` (`sp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
