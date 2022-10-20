/*
 Navicat PostgreSQL Data Transfer

 Source Server         : AWS_wmsas
 Source Server Type    : PostgreSQL
 Source Server Version : 120012
 Source Host           : 18.223.105.203:5786
 Source Catalog        : prueba
 Source Schema         : public

 Target Server Type    : PostgreSQL
 Target Server Version : 120012
 File Encoding         : 65001

 Date: 20/10/2022 14:51:38
*/


-- ----------------------------
-- Sequence structure for seq_events
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."seq_events";
CREATE SEQUENCE "public"."seq_events" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for seq_sessions
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."seq_sessions";
CREATE SEQUENCE "public"."seq_sessions" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for seq_videos
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."seq_videos";
CREATE SEQUENCE "public"."seq_videos" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for seq_wors
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."seq_wors";
CREATE SEQUENCE "public"."seq_wors" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Table structure for events
-- ----------------------------
DROP TABLE IF EXISTS "public"."events";
CREATE TABLE "public"."events" (
  "id_events" int4 NOT NULL DEFAULT nextval('seq_events'::regclass),
  "type_event" char(1) COLLATE "pg_catalog"."default",
  "description" varchar(255) COLLATE "pg_catalog"."default",
  "dateevent" timestamp(6),
  "video_id" int4
)
;
COMMENT ON COLUMN "public"."events"."type_event" IS '1->Load Video, 2-> Answer api , 3-> Find Word';

-- ----------------------------
-- Table structure for sessions
-- ----------------------------
DROP TABLE IF EXISTS "public"."sessions";
CREATE TABLE "public"."sessions" (
  "id_session" int4 NOT NULL DEFAULT nextval('seq_sessions'::regclass),
  "alias_sesion" varchar(255) COLLATE "pg_catalog"."default",
  "datetimecreate" timestamp(6)
)
;

-- ----------------------------
-- Table structure for videos
-- ----------------------------
DROP TABLE IF EXISTS "public"."videos";
CREATE TABLE "public"."videos" (
  "id_videos" int4 NOT NULL DEFAULT nextval('seq_videos'::regclass),
  "alias_video" varchar(255) COLLATE "pg_catalog"."default",
  "text_video" json,
  "scriptvideo" varchar(255) COLLATE "pg_catalog"."default",
  "dateload" timestamp(6),
  "sessions_id" int4
)
;

-- ----------------------------
-- Table structure for word_timestamp
-- ----------------------------
DROP TABLE IF EXISTS "public"."word_timestamp";
CREATE TABLE "public"."word_timestamp" (
  "id_word" int4 NOT NULL DEFAULT nextval('seq_wors'::regclass),
  "word" varchar(255) COLLATE "pg_catalog"."default",
  "start" numeric,
  "end" numeric,
  "video_id" int4
)
;

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
SELECT setval('"public"."seq_events"', 34, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
SELECT setval('"public"."seq_sessions"', 62, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
SELECT setval('"public"."seq_videos"', 43, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
SELECT setval('"public"."seq_wors"', 1140, true);

-- ----------------------------
-- Primary Key structure for table events
-- ----------------------------
ALTER TABLE "public"."events" ADD CONSTRAINT "events_pkey" PRIMARY KEY ("id_events");

-- ----------------------------
-- Primary Key structure for table sessions
-- ----------------------------
ALTER TABLE "public"."sessions" ADD CONSTRAINT "sessions_pkey" PRIMARY KEY ("id_session");

-- ----------------------------
-- Primary Key structure for table videos
-- ----------------------------
ALTER TABLE "public"."videos" ADD CONSTRAINT "videos_pkey" PRIMARY KEY ("id_videos");

-- ----------------------------
-- Primary Key structure for table word_timestamp
-- ----------------------------
ALTER TABLE "public"."word_timestamp" ADD CONSTRAINT "word_timestamp_pkey" PRIMARY KEY ("id_word");

-- ----------------------------
-- Foreign Keys structure for table events
-- ----------------------------
ALTER TABLE "public"."events" ADD CONSTRAINT "events_video_id_fkey" FOREIGN KEY ("video_id") REFERENCES "public"."videos" ("id_videos") ON DELETE RESTRICT ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table videos
-- ----------------------------
ALTER TABLE "public"."videos" ADD CONSTRAINT "videos_sessions_id_fkey" FOREIGN KEY ("sessions_id") REFERENCES "public"."sessions" ("id_session") ON DELETE RESTRICT ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table word_timestamp
-- ----------------------------
ALTER TABLE "public"."word_timestamp" ADD CONSTRAINT "word_timestamp_video_id_fkey" FOREIGN KEY ("video_id") REFERENCES "public"."videos" ("id_videos") ON DELETE RESTRICT ON UPDATE CASCADE;
