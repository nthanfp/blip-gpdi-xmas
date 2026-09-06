-- set_pref definition

CREATE TABLE `set_pref` (
	`set_prefid` BIGINT NOT NULL,
	`pref_name` VARCHAR(100) NOT NULL,
	`pref_label` VARCHAR(255) NOT NULL,
	`pref_value` TEXT NULL,
	`created_by` VARCHAR(100) DEFAULT '' NOT NULL,
	`created_date` DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
	`modified_by` VARCHAR(100) DEFAULT '' NOT NULL,
	`modified_date` DATETIME NULL,
	PRIMARY KEY (`set_prefid`),
	UNIQUE KEY `ux_set_pref_pref_name` (`pref_name`)
) ENGINE=InnoDB;
