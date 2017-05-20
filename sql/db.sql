DROP DATABASE IF EXISTS gemini;
CREATE DATABASE gemini;

use gemini;

DROP TABLE IF EXISTS user;
CREATE TABLE user (
  id int(20) unsigned NOT NULL AUTO_INCREMENT,
  username varchar(100) NOT NULL,
  password varchar(100) NOT NULL,
  salt CHAR(8) NOT NULL,
  create_time timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY(id)
);
CREATE UNIQUE INDEX index_user_username ON user(username);
INSERT INTO user VALUES (1, 'debug', md5(concat(md5('123456'), '12345678')), '12345678', now()), (2, 'onlymaker', md5(concat(md5('123456'), '12345678')), '12345678', now());

DROP TABLE IF EXISTS store;
CREATE TABLE store (
  id int(20) unsigned NOT NULL AUTO_INCREMENT,
  name varchar(100) NOT NULL,
  PRIMARY KEY(id)
);

DROP TABLE IF EXISTS brand;
CREATE TABLE brand (
  id int(20) unsigned NOT NULL AUTO_INCREMENT,
  name varchar(100) NOT NULL,
  PRIMARY KEY(id)
);

DROP TABLE IF EXISTS item_type;
CREATE TABLE item_type (
  id int(20) unsigned NOT NULL AUTO_INCREMENT,
  name varchar(100) NOT NULL,
  PRIMARY KEY(id)
);

DROP TABLE IF EXISTS closure;
CREATE TABLE closure (
  id int(20) unsigned NOT NULL AUTO_INCREMENT,
  name varchar(100) NOT NULL,
  PRIMARY KEY(id)
);

DROP TABLE IF EXISTS heel;
CREATE TABLE heel (
  id int(20) unsigned NOT NULL AUTO_INCREMENT,
  name varchar(100) NOT NULL,
  PRIMARY KEY(id)
);

DROP TABLE IF EXISTS height_map;
CREATE TABLE height_map (
  id int(20) unsigned NOT NULL AUTO_INCREMENT,
  name varchar(100) NOT NULL,
  PRIMARY KEY(id)
);

DROP TABLE IF EXISTS material;
CREATE TABLE material (
  id int(20) unsigned NOT NULL AUTO_INCREMENT,
  name varchar(100) NOT NULL,
  PRIMARY KEY(id)
);

DROP TABLE IF EXISTS occasion;
CREATE TABLE occasion (
  id int(20) unsigned NOT NULL AUTO_INCREMENT,
  name varchar(100) NOT NULL,
  PRIMARY KEY(id)
);

DROP TABLE IF EXISTS pattern;
CREATE TABLE pattern (
  id int(20) unsigned NOT NULL AUTO_INCREMENT,
  name varchar(100) NOT NULL,
  PRIMARY KEY(id)
);

DROP TABLE IF EXISTS strap;
CREATE TABLE strap (
  id int(20) unsigned NOT NULL AUTO_INCREMENT,
  name varchar(100) NOT NULL,
  PRIMARY KEY(id)
);

DROP TABLE IF EXISTS toe;
CREATE TABLE toe (
  id int(20) unsigned NOT NULL AUTO_INCREMENT,
  name varchar(100) NOT NULL,
  PRIMARY KEY(id)
);

DROP TABLE IF EXISTS feature;
CREATE TABLE feature (
  id int(20) unsigned NOT NULL AUTO_INCREMENT,
  name varchar(100) NOT NULL,
  PRIMARY KEY(id)
);

DROP TABLE IF EXISTS keyword;
CREATE TABLE keyword (
  id int(20) unsigned NOT NULL AUTO_INCREMENT,
  name varchar(100) NOT NULL,
  PRIMARY KEY(id)
);

DROP TABLE IF EXISTS color_map;
CREATE TABLE color_map (
  id int(20) unsigned NOT NULL AUTO_INCREMENT,
  name varchar(100) NOT NULL,
  PRIMARY KEY(id)
);

DROP TABLE IF EXISTS raw;
CREATE TABLE raw (
  id int(20) unsigned NOT NULL AUTO_INCREMENT,
  model VARCHAR(100) NOT NULL,
  store VARCHAR(100) NOT NULL,
  brand VARCHAR(100) NOT NULL,
  data TEXT,
  user VARCHAR(100),
  create_time timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY(id)
);