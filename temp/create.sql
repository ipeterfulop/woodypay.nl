CREATE SCHEMA `__DBNAME__` CHARACTER SET utf8 COLLATE utf8_general_ci;
CREATE USER '__USERNAME__'@'localhost' IDENTIFIED BY '__PASSWORD__';
GRANT ALL ON `__DBNAME__`.* TO '__USERNAME__'@'localhost';

/*
 DROP DATABASE IF EXISTS `woodypaydb`;
 DROP USER IF EXISTS `woodypayuser`;
CREATE SCHEMA `woodypaydb` CHARACTER SET utf8 COLLATE utf8_general_ci;
CREATE USER `woodypayuser`@localhost IDENTIFIED BY 'abc123';
GRANT ALL ON `woodypaydb`.* TO `woodypayuser`@localhost;
 */



