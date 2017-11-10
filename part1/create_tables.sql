USE users;

CREATE TABLE credentials (
	username VARCHAR(30) NOT NULL , 
	password VARCHAR(30) NOT NULL,
	PRIMARY KEY(username));