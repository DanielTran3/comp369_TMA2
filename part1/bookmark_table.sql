DROP TABLE bookmarks;
CREATE TABLE bookmarks (
	username VARCHAR(30) NOT NULL , 
	url VARCHAR(256) NOT NULL,
    name VARCHAR(50) NOT NULL,
    hits INT NOT NULL,
	FOREIGN KEY (username) REFERENCES credentials(username),
	PRIMARY KEY(username, url));