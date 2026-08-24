-- public.act_log_admin definition

-- Drop table

-- DROP TABLE public.act_log_admin;

CREATE TABLE public.act_log_admin (
	act_log_adminid int8 NOT NULL,
	mst_adminid int4 NULL,
	set_menuid int4 NULL,
	"action" varchar(30) NULL,
	description varchar(200) NULL,
	ip_address varchar(200) NULL,
	ua varchar(300) NULL,
	mac varchar(300) NULL,
	created_date timestamp(6) NULL,
	CONSTRAINT act_log_admin_pk PRIMARY KEY (act_log_adminid),
	CONSTRAINT act_log_admin_mst_admin_fk FOREIGN KEY (mst_adminid) REFERENCES public.mst_admin(mst_adminid),
	CONSTRAINT act_log_admin_set_menu_fk FOREIGN KEY (set_menuid) REFERENCES public.set_menu(set_menuid)
);

-- public.seq_act_log_admin definition

-- DROP SEQUENCE public.seq_act_log_admin;

CREATE SEQUENCE public.seq_act_log_admin
	INCREMENT BY 1
	MINVALUE 1
	MAXVALUE 9223372036854775807
	START 1
	NO CYCLE;