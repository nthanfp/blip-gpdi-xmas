-- set_menu definition

CREATE TABLE `set_menu` (
	`set_menuid` SMALLINT NOT NULL,
	`parent_set_menuid` SMALLINT NULL,
	`name` VARCHAR(30) NULL,
	`path` VARCHAR(30) NULL,
	`suspended` SMALLINT NULL,
	`order` SMALLINT NULL,
	`icon` VARCHAR(50) NULL,
	PRIMARY KEY (`set_menuid`)
) ENGINE=InnoDB;
