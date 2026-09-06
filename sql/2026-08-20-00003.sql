-- mst_admin definition

CREATE TABLE `mst_admin` (
	`mst_adminid` INT NOT NULL,
	`username` VARCHAR(30) NULL,
	`password` VARCHAR(200) NULL,
	`suspended` SMALLINT NULL,
	`created_by` VARCHAR(30) NULL,
	`created_date` DATETIME(6) NULL,
	`modified_by` VARCHAR(30) NULL,
	`modified_date` DATETIME(6) NULL,
	`email` VARCHAR(50) NULL,
	`force_logout_at` DATETIME NULL,
	PRIMARY KEY (`mst_adminid`),
	UNIQUE KEY `mst_admin_unique` (`username`)
) ENGINE=InnoDB;
