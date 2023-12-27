SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `mahellart`;
USE `mahellart`;

-- Structure de la table `contacts`
DROP TABLE IF EXISTS `contacts`;
CREATE TABLE `contacts` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `lastname` varchar(50) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `objet` varchar(50) NOT NULL,
  `message` longtext NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Structure de la table `realisations`
DROP TABLE IF EXISTS `realisations`;
CREATE TABLE `realisations` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `photoGallery` varchar(60) DEFAULT NULL,
  `Themes_Id` int NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `Themes_Id` (`Themes_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Structure de la table `themes`
DROP TABLE IF EXISTS `themes`;
CREATE TABLE `themes` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Structure de la table `users`
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `password` varchar(60) NOT NULL,
  `admin` tinyint DEFAULT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `EMail` (`mail`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Structure de la table `user_likes`
DROP TABLE IF EXISTS `user_likes`;
CREATE TABLE `user_likes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `realisation_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `realisation_id` (`realisation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Contraintes pour les tables
ALTER TABLE `realisations`
  ADD CONSTRAINT `realisations_ibfk_1` FOREIGN KEY (`Themes_Id`) REFERENCES `themes` (`Id`) ON DELETE CASCADE;

ALTER TABLE `user_likes`
  ADD CONSTRAINT `user_likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`Id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_likes_ibfk_2` FOREIGN KEY (`realisation_id`) REFERENCES `realisations` (`Id`) ON DELETE CASCADE;

COMMIT;
