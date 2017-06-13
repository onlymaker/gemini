use gemini;

ALTER TABLE closure ADD COLUMN language VARCHAR(10) DEFAULT 'en';
ALTER TABLE color_map ADD COLUMN language VARCHAR(10) DEFAULT 'en';
ALTER TABLE feature ADD COLUMN language VARCHAR(10) DEFAULT 'en';
ALTER TABLE generic_keyword ADD COLUMN language VARCHAR(10) DEFAULT 'en';
ALTER TABLE heel ADD COLUMN language VARCHAR(10) DEFAULT 'en';
ALTER TABLE height_map ADD COLUMN language VARCHAR(10) DEFAULT 'en';
ALTER TABLE item_type ADD COLUMN language VARCHAR(10) DEFAULT 'en';
ALTER TABLE keyword ADD COLUMN language VARCHAR(10) DEFAULT 'en';
ALTER TABLE lifestyle ADD COLUMN language VARCHAR(10) DEFAULT 'en';
ALTER TABLE material ADD COLUMN language VARCHAR(10) DEFAULT 'en';
ALTER TABLE pattern ADD COLUMN language VARCHAR(10) DEFAULT 'en';
ALTER TABLE raw ADD COLUMN language VARCHAR(10) DEFAULT 'en';
ALTER TABLE store ADD COLUMN market_unit VARCHAR(10) DEFAULT 'US';
ALTER TABLE strap ADD COLUMN language VARCHAR(10) DEFAULT 'en';
ALTER TABLE toe ADD COLUMN language VARCHAR(10) DEFAULT 'en';

DROP TABLE IF EXISTS language;
CREATE TABLE language (
  id int(20) unsigned NOT NULL AUTO_INCREMENT,
  code VARCHAR(10) NOT NULL,
  create_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY(id)
);
INSERT INTO language (code) VALUES ('en');