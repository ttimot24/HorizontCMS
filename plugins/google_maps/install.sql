CREATE TABLE IF NOT EXISTS @__google_maps (id int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,location_name varchar(255),latitude varchar(255),longitude varchar(255),active int(1));

INSERT INTO @__settings VALUES(default,'gmaps_api_key',NULL,1);
INSERT INTO @__settings VALUES(default,'gmaps_zoom',NULL,1);
INSERT INTO @__settings VALUES(default,'gmaps_type','ROADMAP',1);