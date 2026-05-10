ALTER TABLE `service`
ADD COLUMN `base_price` DECIMAL(10,2) NOT NULL DEFAULT 0.00 AFTER `service_name`;

UPDATE `service` s
LEFT JOIN (
    SELECT service_id, AVG(CAST(price AS DECIMAL(10,2))) AS avg_price
    FROM sp_service
    GROUP BY service_id
) p ON p.service_id = s.service_id
SET s.base_price = COALESCE(p.avg_price, 0.00);

CREATE TABLE IF NOT EXISTS `pricing_rules` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `service_id` INT NULL,
  `area_id` INT NOT NULL,
  `rule_type` ENUM('zone','time','demand','urgency','availability') NOT NULL DEFAULT 'zone',
  `multiplier` DECIMAL(5,2) NOT NULL DEFAULT 1.00,
  `status` ENUM('active','inactive') NOT NULL DEFAULT 'active',
  `description` VARCHAR(255) NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_pricing_rules_lookup` (`status`, `rule_type`, `area_id`, `service_id`),
  CONSTRAINT `fk_pricing_rules_service` FOREIGN KEY (`service_id`) REFERENCES `service` (`service_id`) ON DELETE SET NULL,
  CONSTRAINT `fk_pricing_rules_area` FOREIGN KEY (`area_id`) REFERENCES `area` (`area_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `order_master`
ADD COLUMN `area_id` INT NULL AFTER `pincode`,
ADD COLUMN `urgency_level` ENUM('normal','urgent','emergency') NOT NULL DEFAULT 'normal' AFTER `pay_mode`,
ADD COLUMN `base_total` DECIMAL(10,2) NULL AFTER `total`,
ADD COLUMN `dynamic_multiplier_total` DECIMAL(8,4) NULL AFTER `base_total`,
ADD COLUMN `dynamic_breakdown` LONGTEXT NULL AFTER `dynamic_multiplier_total`,
ADD CONSTRAINT `fk_order_master_area` FOREIGN KEY (`area_id`) REFERENCES `area` (`area_id`) ON DELETE SET NULL;

ALTER TABLE `user_order`
ADD COLUMN `base_price` DECIMAL(10,2) NULL AFTER `price`,
ADD COLUMN `final_price` DECIMAL(10,2) NULL AFTER `base_price`,
ADD COLUMN `price_breakdown` LONGTEXT NULL AFTER `final_price`;
