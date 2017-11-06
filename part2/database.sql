CREATE DATABASE IF NOT EXISTS Learnatorium;
USE Learnatorium;

DROP TABLE IF EXISTS lessonObjects;
DROP TABLE IF EXISTS quizzes;
DROP TABLE IF EXISTS lessons;
DROP TABLE IF EXISTS units;
DROP TABLE IF EXISTS courses;
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
    content VARCHAR(16838) NOT NULL,
    PRIMARY KEY (ID),
    FOREIGN KEY (unit) REFERENCES units(ID)
);

CREATE TABLE quizzes (
	ID int NOT NULL AUTO_INCREMENT,
	lesson int NOT NULL,
    content VARCHAR(16838) NOT NULL,
    PRIMARY KEY (ID),
    FOREIGN KEY (lesson) REFERENCES lessons(ID)
);

CREATE TABLE lessonObjects (
	ID int NOT NULL AUTO_INCREMENT,
    lesson int NOT NULL,
    type VARCHAR(32) NOT NULL,
	objectData blob NOT NULL,
    PRIMARY KEY (ID),
    FOREIGN KEY (lesson) REFERENCES lessons(ID)
);