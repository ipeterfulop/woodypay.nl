CREATE SCHEMA `__DBNAME__` CHARACTER SET utf8 COLLATE utf8_general_ci;
CREATE USER '__USERNAME__'@'localhost' IDENTIFIED BY '__PASSWORD__';
GRANT ALL ON `__DBNAME__`.* TO '__USERNAME__'@'localhost';

/*
 CREATE SCHEMA `woodpaydb` CHARACTER SET utf8 COLLATE utf8_general_ci;
CREATE USER 'woodpayuser'@'localhost' IDENTIFIED BY 'abc123';
GRANT ALL ON `woodpaydb`.* TO 'woodpayuser'@'localhost';
 */


