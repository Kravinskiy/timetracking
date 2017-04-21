--
-- PostgreSQL database dump
--

-- Dumped from database version 9.6.2
-- Dumped by pg_dump version 9.6.2

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: timetracking; Type: DATABASE; Schema: -; Owner: timetracking
--

CREATE DATABASE timetracking WITH TEMPLATE = template0 ENCODING = 'UTF8' LC_COLLATE = 'C' LC_CTYPE = 'C';


ALTER DATABASE timetracking OWNER TO timetracking;

\connect timetracking

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: projects; Type: TABLE; Schema: public; Owner: timetracking
--

CREATE TABLE projects (
    id integer NOT NULL,
    name character varying(100),
    uuid uuid,
    created_at timestamp(6) without time zone,
    active boolean DEFAULT true
);


ALTER TABLE projects OWNER TO timetracking;

--
-- Name: projects_id_seq; Type: SEQUENCE; Schema: public; Owner: timetracking
--

CREATE SEQUENCE projects_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE projects_id_seq OWNER TO timetracking;

--
-- Name: projects_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: timetracking
--

ALTER SEQUENCE projects_id_seq OWNED BY projects.id;


--
-- Name: time_log; Type: TABLE; Schema: public; Owner: timetracking
--

CREATE TABLE time_log (
    id integer NOT NULL,
    project_id smallint NOT NULL,
    "from" timestamp(6) without time zone NOT NULL,
    "to" timestamp(6) without time zone
);


ALTER TABLE time_log OWNER TO timetracking;

--
-- Name: time_log_id_seq; Type: SEQUENCE; Schema: public; Owner: timetracking
--

CREATE SEQUENCE time_log_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE time_log_id_seq OWNER TO timetracking;

--
-- Name: time_log_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: timetracking
--

ALTER SEQUENCE time_log_id_seq OWNED BY time_log.id;


--
-- Name: users; Type: TABLE; Schema: public; Owner: timetracking
--

CREATE TABLE users (
    name character varying(100),
    email character varying(100),
    password character varying(100),
    last_login timestamp(6) without time zone,
    authcode character varying(100),
    uuid uuid DEFAULT uuid_in((md5((random())::text))::cstring) NOT NULL,
    id integer NOT NULL
);


ALTER TABLE users OWNER TO timetracking;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: timetracking
--

CREATE SEQUENCE users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE users_id_seq OWNER TO timetracking;

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: timetracking
--

ALTER SEQUENCE users_id_seq OWNED BY users.id;


--
-- Name: projects id; Type: DEFAULT; Schema: public; Owner: timetracking
--

ALTER TABLE ONLY projects ALTER COLUMN id SET DEFAULT nextval('projects_id_seq'::regclass);


--
-- Name: time_log id; Type: DEFAULT; Schema: public; Owner: timetracking
--

ALTER TABLE ONLY time_log ALTER COLUMN id SET DEFAULT nextval('time_log_id_seq'::regclass);


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: timetracking
--

ALTER TABLE ONLY users ALTER COLUMN id SET DEFAULT nextval('users_id_seq'::regclass);


--
-- Name: users id; Type: CONSTRAINT; Schema: public; Owner: timetracking
--

ALTER TABLE ONLY users
    ADD CONSTRAINT id PRIMARY KEY (id);


--
-- Name: projects projects_pkey; Type: CONSTRAINT; Schema: public; Owner: timetracking
--

ALTER TABLE ONLY projects
    ADD CONSTRAINT projects_pkey PRIMARY KEY (id);


--
-- Name: time_log time_log_pkey; Type: CONSTRAINT; Schema: public; Owner: timetracking
--

ALTER TABLE ONLY time_log
    ADD CONSTRAINT time_log_pkey PRIMARY KEY (id);


--
-- Name: fki_project id; Type: INDEX; Schema: public; Owner: timetracking
--

CREATE INDEX "fki_project id" ON time_log USING btree (project_id);


--
-- Name: fki_uuid; Type: INDEX; Schema: public; Owner: timetracking
--

CREATE INDEX fki_uuid ON projects USING btree (uuid);


--
-- Name: time_log project id; Type: FK CONSTRAINT; Schema: public; Owner: timetracking
--

ALTER TABLE ONLY time_log
    ADD CONSTRAINT "project id" FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--

