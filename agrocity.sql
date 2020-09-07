-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Creato il: Set 07, 2020 alle 13:26
-- Versione del server: 5.7.31
-- Versione PHP: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `agrocity`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `grades`
--

DROP TABLE IF EXISTS `grades`;
CREATE TABLE IF NOT EXISTS `grades` (
  `user_id` int(11) NOT NULL,
  `skill_name` varchar(50) COLLATE utf8_bin NOT NULL,
  `grade` tinyint(4) NOT NULL,
  `week` tinyint(4) NOT NULL,
  KEY `user_id` (`user_id`,`skill_name`),
  KEY `grades_ibfk_2` (`skill_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dump dei dati per la tabella `grades`
--

INSERT INTO `grades` (`user_id`, `skill_name`, `grade`, `week`) VALUES
(27, 'HTML', 8, 1),
(27, 'CSS', 7, 1),
(27, 'Tailwind', 2, 1),
(27, 'Javascript', 6, 1),
(27, 'VueJS', 2, 1),
(27, 'PHP', 7, 1),
(27, 'Laravel', 7, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `skills`
--

DROP TABLE IF EXISTS `skills`;
CREATE TABLE IF NOT EXISTS `skills` (
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  `type` enum('soft','hard') COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dump dei dati per la tabella `skills`
--

INSERT INTO `skills` (`name`, `type`) VALUES
('CSS', 'hard'),
('Comunicare', 'soft'),
('Creativitate', 'soft'),
('Flexibilitate', 'soft'),
('Gandire logica', 'soft'),
('HTML', 'hard'),
('Javascript', 'hard'),
('Laravel', 'hard'),
('Organizare', 'soft'),
('PHP', 'hard'),
('Proactivitate', 'soft'),
('Punctualitate', 'soft'),
('Spirit de echipa', 'soft'),
('Tailwind', 'hard'),
('VueJS', 'hard');

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(30) COLLATE utf8_bin NOT NULL,
  `lastName` varchar(30) COLLATE utf8_bin NOT NULL,
  `email` varchar(50) COLLATE utf8_bin NOT NULL,
  `password` varchar(255) COLLATE utf8_bin NOT NULL,
  `registerDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`id`, `firstName`, `lastName`, `email`, `password`, `registerDate`) VALUES
(27, 'Vicentiu', 'Bota', 'magovins@gmail.com', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', '2020-09-04 22:33:26');

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grades_ibfk_2` FOREIGN KEY (`skill_name`) REFERENCES `skills` (`name`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `grades_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
