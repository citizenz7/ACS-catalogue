-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mar. 18 août 2020 à 09:04
-- Version du serveur :  10.4.10-MariaDB
-- Version de PHP :  7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `catalogue`
--

-- --------------------------------------------------------

--
-- Structure de la table `artiste`
--

DROP TABLE IF EXISTS `artiste`;
CREATE TABLE IF NOT EXISTS `artiste` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `genre` varchar(255) NOT NULL,
  `pays_origine` varchar(255) NOT NULL,
  `presentation` text NOT NULL,
  `biographie` text NOT NULL,
  `discographie` text NOT NULL,
  `active` varchar(255) NOT NULL,
  `label` varchar(255) NOT NULL,
  `site_web` varchar(255) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `image` varchar(255) DEFAULT NULL,
  `youtube` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `artiste`
--

INSERT INTO `artiste` (`id`, `nom`, `genre`, `pays_origine`, `presentation`, `biographie`, `discographie`, `active`, `label`, `site_web`, `date`, `image`, `youtube`) VALUES
(1, 'The ACS', 'Chanson Francaise', 'france', '', 'acs promo 41', 'The ACS', 'oui', 'auto production', 'https://promo-41.codeur.online/', '2020-07-31 09:31:06', NULL, NULL),
(2, 'The pas ACS', 'Funk, goove', 'france', '', 'pas acs', '', '', '', 'https://www.google.fr', '2020-08-17 10:05:42', NULL, NULL),
(3, 'Jinjer', 'metalcore, death metal, metal progressif', 'Ukraine', 'Jinjer est a l\'origine un groupe de groove metal ukrainien forme en 2009. Combinant brutalite, vitesse, groove et melodie, de nos jours Jinjer se presente lui-meme plutet comme un groupe de progressive groove metal. Bien que les musiciens soient de langue maternelle russe, la langue parlee dans l\'est de l\'Ukraine, le chant, tantet guttural, tantet clair, est en anglais (e l\'exception d\'un titre de l\'album Cloud Factory, Желаю значит получу, \"I want it I\'ll get it\", chante en russe).', 'Debuts et Inhale, Do Not Breathe (2009-2012)\r\nBest Ukrainian Metal Band et Cloud Factory (2013-2015)\r\nNapalm Records et King of Everything (2016-2018)\r\nMicro et Macro (2019)', '    Inhale, Do Not Breathe (reedition) (2013) - The Leaders Records\r\n    Cloud Factory (2014) - The Leaders Records\r\n    King of Everything (2016) - Napalm Records\r\n    Cloud Factory (reedition) (2018) - Napalm Records\r\n    Macro (2019) - Napalm Records', '2009-2020', 'Napalm Records', 'http://jinjer-metal.com/', '2020-08-17 11:34:12', 'jinjer.jpg', 'https://www.youtube.com/watch?v=SQNtGoM3FVU');

-- --------------------------------------------------------

--
-- Structure de la table `membres`
--

DROP TABLE IF EXISTS `membres`;
CREATE TABLE IF NOT EXISTS `membres` (
  `MemberID` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`MemberID`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `membres`
--

INSERT INTO `membres` (`MemberID`, `username`, `password`, `email`) VALUES
(1, 'citizenz7', '$2y$10$g13tR5lU7MeRBp.HxvnVPOskDZwcqykkAFpPkw8Z7ldd3uM53VWFW', 'o.prieur@codeur.online'),
(2, 'oswald', '$2y$10$vtB37xTfiTgw1.UuX.hfPO7fu3a66eY9Fcpnit7fO0waIuMuZ9kR.', 'o.quevillart.codeur.online'),
(3, 'yacine', '$2y$10$.Q00/LycRT8anGlaqY1KtOFy4XzSzAGr0i1vNdUUayY3NbPIs1uV2', 'y.sbaÃ¯@codeur.online');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
