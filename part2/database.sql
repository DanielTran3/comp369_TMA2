CREATE DATABASE IF NOT EXISTS Learnatorium;
USE Learnatorium;

DROP TABLE IF EXISTS usersCourses;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS lessonObjects;
DROP TABLE IF EXISTS quizzes;
DROP TABLE IF EXISTS lessons;
DROP TABLE IF EXISTS units;
DROP TABLE IF EXISTS courses;

CREATE TABLE users (
	username VARCHAR(20) NOT NULL,
    password VARCHAR(20) NOT NULL,
    admin bool NOT NULL,
    PRIMARY KEY (username)
);

CREATE TABLE usersCourses (
	username VARCHAR(20) NOT NULL , 
	courseID int NOT NULL,
	FOREIGN KEY (username) REFERENCES users(username),
	PRIMARY KEY(username, courseID)
);

INSERT INTO users (username, password, admin) VALUES ("admin", "password", true);

CREATE TABLE courses (
	ID int NOT NULL AUTO_INCREMENT,
    name VARCHAR(64) NOT NULL,
    PRIMARY KEY (ID)
);

CREATE TABLE units (
	ID int NOT NULL AUTO_INCREMENT,
    course int NOT NULL,
    name VARCHAR(64) NOT NULL,
    PRIMARY KEY (ID),
    FOREIGN KEY (course) REFERENCES courses(ID)
);

CREATE TABLE lessons (
	ID int NOT NULL AUTO_INCREMENT,
    unit int NOT NULL,
    name VARCHAR(64) NOT NULL,
    content TEXT NOT NULL,
    PRIMARY KEY (ID),
    FOREIGN KEY (unit) REFERENCES units(ID)
);

CREATE TABLE quizzes (
	ID int NOT NULL AUTO_INCREMENT,
	lesson int NOT NULL,
    content TEXT NOT NULL,
    PRIMARY KEY (ID),
    FOREIGN KEY (lesson) REFERENCES lessons(ID)
);

CREATE TABLE learningObjects (
    course int NOT NULL,
    type VARCHAR(32) NOT NULL,
	filename VARCHAR(256) NOT NULL,
    location VARCHAR(512) NOT NULL,
    PRIMARY KEY (course, filename),
    FOREIGN KEY (course) REFERENCES courses(ID)
);