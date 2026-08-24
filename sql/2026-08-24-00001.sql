-- public.act_admin_notifications definition
-- Drop table
-- DROP TABLE public.act_admin_notifications;
CREATE TABLE public.act_admin_notifications (
    act_admin_notificationid serial4 NOT NULL,
    "type" varchar(50) DEFAULT 'redeem' :: character varying NOT NULL,
    title varchar(255) DEFAULT '' :: character varying NOT NULL,
    message text DEFAULT '' :: text NOT NULL,
    related_id int4 NULL,
    is_read int2 DEFAULT 0 NULL,
    created_date timestamp DEFAULT now() NULL,
    mst_adminid int4 NULL,
    CONSTRAINT act_admin_notifications_pkey PRIMARY KEY (act_admin_notificationid),
    CONSTRAINT fk_notif_admin FOREIGN KEY (mst_adminid) REFERENCES public.mst_admin(mst_adminid)
);

CREATE INDEX idx_notif_admin ON act_admin_notifications USING btree (mst_adminid);

-- public.act_admin_notificationid_seq definition
-- DROP SEQUENCE public.act_admin_notificationid_seq;
CREATE SEQUENCE public.act_admin_notificationid_seq INCREMENT BY 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 NO CYCLE;