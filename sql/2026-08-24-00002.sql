-- act_admin_fcm_tokens definition

CREATE TABLE `act_admin_fcm_tokens` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `mst_adminid` INT NOT NULL,
    `fcm_token` TEXT NOT NULL,
    `user_agent` TEXT DEFAULT NULL,
    `created_date` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_date` DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    INDEX `idx_fcm_tokens_admin` (`mst_adminid`)
) ENGINE=InnoDB;
