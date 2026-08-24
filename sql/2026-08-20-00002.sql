-- public.set_menu definition

-- Drop table

-- DROP TABLE public.set_menu;

CREATE TABLE public.set_menu (
	set_menuid int2 NOT NULL,
	parent_set_menuid int2 NULL,
	"name" varchar(30) NULL,
	"path" varchar(30) NULL,
	suspended int2 NULL,
	"order" int2 NULL,
	icon varchar(50) NULL,
	CONSTRAINT set_menu_pk PRIMARY KEY (set_menuid)
);

