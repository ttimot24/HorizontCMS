CREATE TABLE IF NOT EXISTS @__settings (id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,setting VARCHAR(255) NOT NULL UNIQUE,value TEXT,more INT(8),UNIQUE(setting));
				
CREATE TABLE IF NOT EXISTS @__socialmedia (id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,social_media VARCHAR(255),link VARCHAR(255),more INT(8));

CREATE TABLE IF NOT EXISTS @__blogpost (id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,title VARCHAR(255) NOT NULL UNIQUE,summary VARCHAR(700),text TEXT,date int(11),author int(8),category int(8),image VARCHAR(255));
				
CREATE TABLE IF NOT EXISTS @__blogpost_category (id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,name VARCHAR(255));
				
CREATE TABLE IF NOT EXISTS @__blogpost_comment (id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,blogpost_id INT(8) NOT NULL,user_id INT(8) NOT NULL,date int(32),comment TEXT);		

CREATE TABLE IF NOT EXISTS @__user (id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,name VARCHAR(255) NOT NULL,username VARCHAR(255) NOT NULL UNIQUE,password VARCHAR(255) NOT NULL,rank INT(8),email VARCHAR(255),session int(8),reg_date int(11),visits INT(8),active INT(8),image VARCHAR(255));

CREATE TABLE IF NOT EXISTS @__page (id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,name VARCHAR(255) NOT NULL UNIQUE,url VARCHAR(255),visibility INT(8),parent INT(8),queue INT(8),page TEXT,image VARCHAR(255));

CREATE TABLE IF NOT EXISTS @__user_rank (id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,name VARCHAR(255) NOT NULL,permission INT(8),rights TEXT);

CREATE TABLE IF NOT EXISTS @__visits (id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,date int(32) NOT NULL,ip INT(8), hostname VARCHAR(255));

CREATE TABLE IF NOT EXISTS @__plugin (id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,name varchar(255),dir varchar(255),area INT(4),permission int(11),table_name varchar(255),active int(11) DEFAULT 0);

CREATE TABLE IF NOT EXISTS @__header_image (id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,title VARCHAR(255),image VARCHAR(255));

CREATE TABLE IF NOT EXISTS @__gallery (id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,name VARCHAR(255), directory VARCHAR(255), active INT(8));

INSERT INTO @__blogpost_category VALUES(default,'default');

INSERT INTO @__user_rank VALUES(default,'Public',0,NULL);
INSERT INTO @__user_rank VALUES(default,'User',1,NULL);	
INSERT INTO @__user_rank VALUES(default,'Member',2,NULL);
INSERT INTO @__user_rank VALUES(default,'Editor',3,NULL);
INSERT INTO @__user_rank VALUES(default,'Manager',4,'{
														\"admin_area\":\"1\",
														\"blogpost\":\"1\",
														\"user\":\"1\",
														\"page\":\"1\",
														\"media\":\"1\",
														\"themes&apps\":\"1\",
														\"settings\":\"1\"
														}');
INSERT INTO @__user_rank VALUES(default,'Admin',5,'{
														\"admin_area\":\"1\",
														\"blogpost\":\"1\",
														\"user\":\"1\",
														\"page\":\"1\",
														\"media\":\"1\",
														\"themes&apps\":\"1\",
														\"settings\":\"1\"
														}');