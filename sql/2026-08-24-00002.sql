-- public.act_admin_fcm_tokens definition
-- Drop table
-- DROP TABLE public.act_admin_fcm_tokens;
CREATE TABLE public.act_admin_fcm_tokens (
    id serial4 NOT NULL,
    mst_adminid int4 NOT NULL,
    fcm_token text NOT NULL,
    user_agent text DEFAULT '' :: text NULL,
    created_date timestamp DEFAULT now() NULL,
    updated_date timestamp DEFAULT now() NULL,
    CONSTRAINT act_admin_fcm_tokens_pkey PRIMARY KEY (id)
);

CREATE INDEX idx_fcm_tokens_admin ON act_admin_fcm_tokens USING btree (mst_adminid);

CREATE INDEX idx_fcm_tokens_token ON act_admin_fcm_tokens USING btree (fcm_token);