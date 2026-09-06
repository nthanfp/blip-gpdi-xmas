-- act_log_admin definition

CREATE TABLE `act_log_admin` (
	`act_log_adminid` BIGINT NOT NULL,
	`mst_adminid` INT NULL,
	`set_menuid` INT NULL,
	`action` VARCHAR(30) NULL,
	`description` VARCHAR(200) NULL,
	`ip_address` VARCHAR(200) NULL,
	`ua` VARCHAR(300) NULL,
	`mac` VARCHAR(300) NULL,
	`created_date` DATETIME(6) NULL,
	PRIMARY KEY (`act_log_adminid`),
	CONSTRAINT `act_log_admin_mst_admin_fk` FOREIGN KEY (`mst_adminid`) REFERENCES `mst_admin`(`mst_adminid`),
	CONSTRAINT `act_log_admin_set_menu_fk` FOREIGN KEY (`set_menuid`) REFERENCES `set_menu`(`set_menuid`)
) ENGINE=InnoDB;
