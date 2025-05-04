-- Database backup of db_cvsu created on 20250504082843



-- Creating table accounts --
CREATE TABLE `accounts` (
  `account_id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` varchar(45) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `fullname` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `role` varchar(45) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `date_created` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`account_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;


-- Inserting data into accounts --
INSERT INTO `accounts` (account_id,employee_id,password,fullname,email,role,status,token,date_created) VALUES ('1','EMP-00001','$2y$10$sf7jtcnnk.Qip0/ZyIjEBewJ7Smpg.EcFgmH.anA4Oh5Axv4qkZkG','Administrator','admin@gmail.com','Super-admin','1','gjj232w2j2344hqq423423hq2312434','2025-05-03');


-- Creating table logs --
CREATE TABLE `logs` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) DEFAULT NULL,
  `activities` longtext,
  `page` varchar(45) DEFAULT NULL,
  `datetime` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;


-- Inserting data into logs --
INSERT INTO `logs` (log_id,account_id,activities,page,datetime) VALUES ('1','1','Logged On','Login page','2025-05-03 02:28:20 pm');
INSERT INTO `logs` (log_id,account_id,activities,page,datetime) VALUES ('2','1','Logged Out','Login page','2025-05-03 02:56:44 pm');
INSERT INTO `logs` (log_id,account_id,activities,page,datetime) VALUES ('3','1','Logged On','Login page','2025-05-03 08:05:43 pm');
INSERT INTO `logs` (log_id,account_id,activities,page,datetime) VALUES ('4','1','Logged Out','Login page','2025-05-03 10:14:18 pm');
INSERT INTO `logs` (log_id,account_id,activities,page,datetime) VALUES ('5','1','Logged On','Login page','2025-05-04 03:06:26 pm');
INSERT INTO `logs` (log_id,account_id,activities,page,datetime) VALUES ('6','1','Logged Out','Login page','2025-05-04 03:35:01 pm');
INSERT INTO `logs` (log_id,account_id,activities,page,datetime) VALUES ('7','1','Logged On','Login page','2025-05-04 03:41:38 pm');


-- Creating table students --
CREATE TABLE `students` (
  `student_id` int(11) NOT NULL AUTO_INCREMENT,
  `school_id` varchar(45) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `first_name` varchar(45) DEFAULT NULL,
  `middle_name` varchar(45) DEFAULT NULL,
  `surname` varchar(45) DEFAULT NULL,
  `suffix` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `is_enroll` int(11) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `date_created` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`student_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;


-- Inserting data into students --
INSERT INTO `students` (student_id,school_id,password,first_name,middle_name,surname,suffix,email,status,is_enroll,photo,token,date_created) VALUES ('1','ABC-00001','$2y$10$85SOYLifmyFMQAG/h9dIEux6HeM1EHagBvBv.aJhReESo8J99awcG','Juan','D','Dela Cruz','','juan.delacruz@gmail.com','1','','','iuy23242yt232834242','2025-05-03');
