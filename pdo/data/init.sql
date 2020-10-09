CREATE DATABASE test;

use test;

CREATE TABLE users (
	email VARCHAR(30) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
	firstname VARCHAR(30) NOT NULL,
	designation VARCHAR(30) NOT NULL,
	address1 VARCHAR(50) NOT NULL,
	address2 VARCHAR(50) ,
	city VARCHAR(20),
	livingstate VARCHAR(20)
);