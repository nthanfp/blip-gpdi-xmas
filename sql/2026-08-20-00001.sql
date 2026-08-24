-- public.set_pref definition

-- Drop table

-- DROP TABLE public.set_pref;

CREATE TABLE public.set_pref (
	set_prefid int8 NOT NULL,
	pref_name varchar(100) NOT NULL,
	pref_label varchar(255) NOT NULL,
	pref_value text NULL,
	created_by varchar(100) DEFAULT ''::character varying NOT NULL,
	created_date timestamp DEFAULT now() NOT NULL,
	modified_by varchar(100) DEFAULT ''::character varying NOT NULL,
	modified_date timestamp NULL,
	CONSTRAINT set_pref_pkey PRIMARY KEY (set_prefid)
);
CREATE UNIQUE INDEX ux_set_pref_pref_name ON set_pref USING btree (pref_name);

-- public.seq_set_pref definition

-- DROP SEQUENCE public.seq_set_pref;

CREATE SEQUENCE public.seq_set_pref
	INCREMENT BY 1
	MINVALUE 1
	MAXVALUE 9223372036854775807
	START 1
	NO CYCLE;