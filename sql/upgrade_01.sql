use gemini;

ALTER TABLE brand ADD COLUMN language VARCHAR(10) DEFAULT 'en';
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
ALTER TABLE store ADD COLUMN language VARCHAR(10) DEFAULT 'en';
ALTER TABLE strap ADD COLUMN language VARCHAR(10) DEFAULT 'en';
ALTER TABLE toe ADD COLUMN language VARCHAR(10) DEFAULT 'en';

# ignore upc, user