
-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 06, 2023 at 11:59 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


CREATE TABLE comments (
    id varchar(20) PRIMARY KEY,
    content_id varchar(20),
    student_id varchar(20),
    teacher_id varchar(20),
    comment varchar(1000),
    date date DEFAULT current_timestamp(),
    INDEX(content_id),
    INDEX(student_id),
    INDEX(teacher_id)
);

CREATE TABLE contact (
    roll_id INT(4) NOT NULL,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(100) NOT NULL,
    class VARCHAR(100) NOT NULL,
    mgs VARCHAR(255) NOT NULL,
    Creationdate TIMESTAMP DEFAULT current_timestamp(),
    PRIMARY KEY (roll_id)
);

CREATE TABLE student (
    id INT(11) NOT NULL AUTO_INCREMENT,
    first_name VARCHAR(50) COLLATE utf8mb4_general_ci NOT NULL,
    last_name VARCHAR(50) COLLATE utf8mb4_general_ci NOT NULL,
    birthday DATE NOT NULL,
    gender ENUM('Male', 'Female', 'Other') COLLATE utf8mb4_general_ci NOT NULL,
    email VARCHAR(100) COLLATE utf8mb4_general_ci NOT NULL,
    phone_number VARCHAR(20) COLLATE utf8mb4_general_ci NOT NULL,
    role_id INT(11) NOT NULL,
    registration_date DATE DEFAULT NULL,
    username VARCHAR(50) COLLATE utf8mb4_general_ci NOT NULL,
    password VARCHAR(255) COLLATE utf8mb4_general_ci NOT NULL,
    subjectid INT(11) DEFAULT NULL,
    PRIMARY KEY (id),
    KEY fk_student_subject (subjectid)
);

CREATE TABLE tblclasses (
    id INT(11) NOT NULL AUTO_INCREMENT,
    ClassName VARCHAR(80) COLLATE latin1_swedish_ci DEFAULT NULL,
    ClassNameNumeric INT(4) NOT NULL,
    Section VARCHAR(5) COLLATE latin1_swedish_ci NOT NULL,
    CreationDate TIMESTAMP NOT NULL DEFAULT current_timestamp(),
    UpdationDate TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP(),
    PRIMARY KEY (id)
);

CREATE TABLE tblresult (
    id INT(11) NOT NULL AUTO_INCREMENT,
    StudentId INT(11),
    ClassId INT(11),
    SubjectId INT(11),
    marks INT(11),
    PostingDate TIMESTAMP DEFAULT current_timestamp(),
    UpdationDate TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(),
    PRIMARY KEY (id)
);

CREATE TABLE tblsubjectcombination (
    id INT(11) NOT NULL AUTO_INCREMENT,
    ClassId INT(11),
    SubjectId INT(11),
    status INT(1),
    CreationDate TIMESTAMP DEFAULT current_timestamp(),
    Updationdate TIMESTAMP DEFAULT current_timestamp() ON UPDATE CURRENT_TIMESTAMP(),
    PRIMARY KEY (id)
);

CREATE TABLE tblsubjects (
    id INT(11) NOT NULL AUTO_INCREMENT,
    SubjectName VARCHAR(100),
    SubjectCode VARCHAR(100),
    Creationdate TIMESTAMP DEFAULT current_timestamp(),
    UpdationDate TIMESTAMP DEFAULT current_timestamp() ON UPDATE CURRENT_TIMESTAMP(),
    teacher_id INT(11),
    PRIMARY KEY (id),
    INDEX FK_Subject_Teacher (teacher_id)
);

CREATE TABLE teacher (
    id INT(11) NOT NULL AUTO_INCREMENT,
    first_name VARCHAR(255),
    last_name VARCHAR(255),
    birthday DATE,
    gender ENUM('Male', 'Female', 'Other'),
    email VARCHAR(255),
    phone_number VARCHAR(20),
    subject VARCHAR(255),
    registration_date DATE,
    username VARCHAR(50),
    password VARCHAR(255),
    PRIMARY KEY (id)
);

CREATE TABLE video (
    id INT(11) NOT NULL AUTO_INCREMENT,
    ClassId INT(11),
    SubjectId INT(11),
    title VARCHAR(20),
    thumbnail VARCHAR(100),
    video VARCHAR(100),
    description VARCHAR(250),
    CreationDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Updationdate TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    subjectCombination VARCHAR(100),
    teacher_id INT(11),
    PRIMARY KEY (id),
    FOREIGN KEY (teacher_id) REFERENCES teacher(id)
);


ALTER TABLE comments CHANGE COLUMN content_id video_id int(11);
