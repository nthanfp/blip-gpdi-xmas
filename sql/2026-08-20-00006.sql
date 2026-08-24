-- public.set_menu_admin definition

-- Drop table

-- DROP TABLE public.set_menu_admin;

CREATE TABLE public.set_menu_admin (
	set_menuid int2 NULL,
	mst_adminid int2 NULL,
	"view" int2 NULL,
	"new" int2 NULL,
	"update" int2 NULL,
	"delete" int2 NULL,
	print int2 NULL,
	export int2 NULL,
	CONSTRAINT set_menu_admin_mst_admin_fk FOREIGN KEY (mst_adminid) REFERENCES public.mst_admin(mst_adminid),
	CONSTRAINT set_menu_admin_set_menu_fk FOREIGN KEY (set_menuid) REFERENCES public.set_menu(set_menuid)
);