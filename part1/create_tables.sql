CREATE TABLE credentials (
	username VARCHAR(30) NOT NULL , 
	password VARCHAR(30) NOT NULL,
	PRIMARY KEY(username));
CREATE TABLE bookmarks (
	username VARCHAR(30) NOT NULL , 
	url VARCHAR(30) NOT NULL,
	FOREIGN KEY (username) REFERENCES credentials(username),
	UNIQUE KEY(username, url));