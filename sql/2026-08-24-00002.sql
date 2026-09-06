-- act_admin_fcm_tokens definition

CREATE TABLE `act_admin_fcm_tokens` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `mst_adminid` INT NOT NULL,
    `fcm_token` TEXT NOT NULL,
    `user_agent` TEXT DEFAULT NULL,
    `created_date` DATETIME DEFAULT CURRENT_TIMESTAMP NULL,
    `updated_date` DATETIME DEFAULT CURRENT_TIMESTAMP NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE INDEX `idx_fcm_tokens_admin` ON `act_admin_fcm_tokens` (`mst_adminid`);
CREATE INDEX `idx_fcm_tokens_token` ON `act_admin_fcm_tokens` (`fcm_token`(191));
