-- act_admin_notifications definition

CREATE TABLE `act_admin_notifications` (
    `act_admin_notificationid` INT NOT NULL AUTO_INCREMENT,
    `type` VARCHAR(50) DEFAULT 'redeem' NOT NULL,
    `title` VARCHAR(255) DEFAULT '' NOT NULL,
    `message` TEXT DEFAULT NULL,
    `related_id` INT NULL,
    `is_read` SMALLINT DEFAULT 0 NULL,
    `created_date` DATETIME DEFAULT CURRENT_TIMESTAMP NULL,
    `mst_adminid` INT NULL,
    PRIMARY KEY (`act_admin_notificationid`),
    CONSTRAINT `fk_notif_admin` FOREIGN KEY (`mst_adminid`) REFERENCES `mst_admin`(`mst_adminid`)
) ENGINE=InnoDB;

CREATE INDEX `idx_notif_admin` ON `act_admin_notifications` (`mst_adminid`);
