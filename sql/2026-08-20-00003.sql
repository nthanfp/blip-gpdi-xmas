-- public.mst_admin definition

-- Drop table

-- DROP TABLE public.mst_admin;

CREATE TABLE public.mst_admin (
	mst_adminid int4 NOT NULL,
	username varchar(30) NULL,
	"password" varchar(200) NULL,
	suspended int2 NULL,
	created_by varchar(30) NULL,
	created_date timestamp(6) NULL,
	modified_by varchar(30) NULL,
	modified_date timestamp(6) NULL,
	email varchar(50) NULL,
	force_logout_at timestamp NULL,
	CONSTRAINT mst_admin_pk PRIMARY KEY (mst_adminid),
	CONSTRAINT mst_admin_unique UNIQUE (username)
);

-- public.seq_mst_admin definition

-- DROP SEQUENCE public.seq_mst_admin;

CREATE SEQUENCE public.seq_mst_admin
	INCREMENT BY 1
	MINVALUE 1
	MAXVALUE 9223372036854775807
	START 1
	NO CYCLE;