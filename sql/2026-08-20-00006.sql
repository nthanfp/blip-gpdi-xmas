-- set_menu_admin definition

CREATE TABLE `set_menu_admin` (
	`set_menuid` SMALLINT NULL,
	`mst_adminid` SMALLINT NULL,
	`view` SMALLINT NULL,
	`new` SMALLINT NULL,
	`update` SMALLINT NULL,
	`delete` SMALLINT NULL,
	`print` SMALLINT NULL,
	`export` SMALLINT NULL,
	CONSTRAINT `set_menu_admin_mst_admin_fk` FOREIGN KEY (`mst_adminid`) REFERENCES `mst_admin`(`mst_adminid`),
	CONSTRAINT `set_menu_admin_set_menu_fk` FOREIGN KEY (`set_menuid`) REFERENCES `set_menu`(`set_menuid`)
) ENGINE=InnoDB;
