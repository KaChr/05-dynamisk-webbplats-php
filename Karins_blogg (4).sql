-- Adminer 4.3.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `post_nr` int(11) NOT NULL AUTO_INCREMENT,
  `post_title` varchar(255) NOT NULL,
  `post_author` varchar(255) NOT NULL,
  `post_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `post_text` mediumtext NOT NULL,
  `type` enum('Fundering','Livsstil','Mat','Uppfinning') DEFAULT NULL,
  PRIMARY KEY (`post_nr`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `posts` (`post_nr`, `post_title`, `post_author`, `post_date`, `post_text`, `type`) VALUES
(2,	'Hej hej',	'Tom Ekander',	'2017-11-15 13:08:01',	'hej hej',	'Fundering'),
(3,	'Ny titel',	'Karin',	'2017-11-16 16:44:32',	'Massor utav text',	'Livsstil'),
(4,	'En titel',	'Karin',	'2017-11-16 16:53:59',	'Massor med text!!!!        \r\n    ',	'Uppfinning');

DROP TABLE IF EXISTS `post_tags`;
CREATE TABLE `post_tags` (
  `id_post` int(11) NOT NULL,
  `id_tag` int(11) NOT NULL,
  KEY `id_post` (`id_post`),
  CONSTRAINT `post_tags_ibfk_1` FOREIGN KEY (`id_post`) REFERENCES `posts` (`post_nr`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `post_tags` (`id_post`, `id_tag`) VALUES
(2,	1),
(2,	2);

DROP TABLE IF EXISTS `tags`;
CREATE TABLE `tags` (
  `tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `tag_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tags` (`tag_id`, `tag_name`) VALUES
(1,	'Mumma'),
(2,	'Kaka');

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `user` (`user_id`, `firstname`, `surname`, `email`) VALUES
(1,	'miss',	'Li',	'miss_li@mail.com');

-- 2017-11-19 21:54:56
