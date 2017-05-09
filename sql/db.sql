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
  create_time timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY(id)
);
CREATE UNIQUE INDEX index_store_name ON store(name);
