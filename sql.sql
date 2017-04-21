-- Table: public.users

-- DROP TABLE public.users;

CREATE TABLE public.users
(
    name character varying(100) COLLATE pg_catalog."default",
    email character varying(100) COLLATE pg_catalog."default",
    password character varying(100) COLLATE pg_catalog."default",
    last_login timestamp(6) without time zone,
    authcode character varying(100) COLLATE pg_catalog."default",
    uuid uuid NOT NULL DEFAULT uuid_in((md5((random())::text))::cstring),
    id integer NOT NULL DEFAULT nextval('users_id_seq'::regclass),
    CONSTRAINT id PRIMARY KEY (id)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.users
    OWNER to timetracking;

-- Table: public.projects

-- DROP TABLE public.projects;

CREATE TABLE public.projects
(
    id integer NOT NULL DEFAULT nextval('projects_id_seq'::regclass),
    name character varying(100) COLLATE pg_catalog."default",
    uuid uuid,
    created_at timestamp(6) without time zone,
    active boolean DEFAULT true,
    CONSTRAINT projects_pkey PRIMARY KEY (id)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.projects
    OWNER to timetracking;

-- Index: fki_uuid

-- DROP INDEX public.fki_uuid;

CREATE INDEX fki_uuid
    ON public.projects USING btree
    (uuid)
    TABLESPACE pg_default;

    -- Table: public.time_log

-- DROP TABLE public.time_log;

CREATE TABLE public.time_log
(
    id integer NOT NULL DEFAULT nextval('time_log_id_seq'::regclass),
    project_id smallint NOT NULL,
    "from" timestamp(6) without time zone NOT NULL,
    "to" timestamp(6) without time zone,
    CONSTRAINT time_log_pkey PRIMARY KEY (id),
    CONSTRAINT "project id" FOREIGN KEY (project_id)
        REFERENCES public.projects (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE CASCADE
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.time_log
    OWNER to timetracking;

-- Index: fki_project id

-- DROP INDEX public."fki_project id";

CREATE INDEX "fki_project id"
    ON public.time_log USING btree
    (project_id)
    TABLESPACE pg_default;
