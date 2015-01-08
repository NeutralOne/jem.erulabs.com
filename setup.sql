CREATE DATABASE jemdb;

USE jemdb;

CREATE USER 'jem'@'localhost' IDENTIFIED BY 'sometatas';

GRANT ALL PRIVILEGES ON jemdb.* TO 'jem'@'localhost';

CREATE TABLE visitData(
	IP VARCHAR(16),	
	visits INT(32),
	id INT(11) NOT NULL auto_increment,
	primary KEY(id)
);

CREATE TABLE comments(
	name VARCHAR(32),
	words TEXT,
	id INT(11) NOT NULL auto_increment,
	primary KEY(id)
);
