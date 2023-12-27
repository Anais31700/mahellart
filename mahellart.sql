-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 27 déc. 2023 à 16:27
-- Version du serveur : 8.0.35
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `mahellart`
--

-- --------------------------------------------------------

--
-- Structure de la table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
CREATE TABLE IF NOT EXISTS `contacts` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `lastname` varchar(50) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `objet` varchar(50) NOT NULL,
  `message` longtext NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `contacts`
--

INSERT INTO `contacts` (`Id`, `lastname`, `firstname`, `mail`, `objet`, `message`, `created_at`) VALUES
(4, 'PREMIER', 'Test', 'premiertest@test.com', 'Ceci est le premier test', 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Repellat atque iste esse inventore veniam. Quaerat repellat eligendi porro amet alias! In ea quasi dolore voluptatum, alias ipsam iste perferendis inventore qui placeat! Molestias quo rem, natus id perspiciatis nobis alias hic quos tempora nam soluta a impedit aliquam doloremque nisi atque vitae \r\nobcaecati ex minima ipsum voluptate facere! Veritatis magnam eum dolor \r\npraesentium. Quam ipsam molestias ut voluptate minus expedita hic sit quod \r\ndistinctio illum amet error assumenda tempora perspiciatis culpa nostrum, \r\naliquid recusandae nemo consequuntur sint animi quia. Quia ratione quibusdam \r\nmolestias voluptas! Deleniti nemo nulla laboriosam reiciendis accusantium architecto fugiat suscipit. ', '2021-03-22 19:36:35'),
(5, 'DEUXIEME', 'Test', 'deuxiemetest@test.com', 'Ceci est le deuxieme test', 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Repellat atque iste esse inventore veniam. Quaerat repellat eligendi porro amet alias! In ea quasi dolore voluptatum, alias ipsam iste perferendis inventore qui placeat! Molestias quo rem, natus id perspiciatis nobis alias hic quos tempora nam soluta a impedit aliquam doloremque nisi atque vitae \\r\\nobcaecati ex minima ipsum voluptate facere! Veritatis magnam eum dolor \\r\\npraesentium. Quam ipsam molestias ut voluptate minus expedita hic sit quod \\r\\ndistinctio illum amet error assumenda tempora perspiciatis culpa nostrum, \\r\\naliquid recusandae nemo consequuntur sint animi quia. Quia ratione quibusdam \\r\\nmolestias voluptas! Deleniti nemo nulla laboriosam reiciendis accusantium architecto fugiat suscipit.', '2021-03-28 15:27:51'),
(6, 'Bataille', 'Anais', 'anais.bataille1988@gmail.com', 'coucou', 'sasa', '2022-05-23 01:06:20'),
(7, 'test', 'test', 'naruto.uzumaki@konoha.com', 'test', 'test', '2023-12-26 22:07:59');

-- --------------------------------------------------------

--
-- Structure de la table `realisations`
--

DROP TABLE IF EXISTS `realisations`;
CREATE TABLE IF NOT EXISTS `realisations` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `photoGallery` varchar(60) DEFAULT NULL,
  `Themes_Id` int NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `Themes_Id` (`Themes_Id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `realisations`
--

INSERT INTO `realisations` (`Id`, `name`, `photoGallery`, `Themes_Id`) VALUES
(18, 'Cerbère Mandragore', '18.png', 9),
(19, 'Les portes de l\'enfer', '19.png', 9),
(20, 'La nuit du Chaman', '20.png', 9),
(21, 'Un nouveau voyage', '21.png', 10),
(22, 'L\'univers dans le temps', '22.png', 10),
(23, 'Expérience : sujet N°Cœur ', '23.png', 10),
(24, 'Méduisante méduse', '24.png', 11),
(25, 'Charmeur de serpent', '25.png', 11),
(26, 'La géométrie de l\'archnide', '26.png', 11),
(27, 'Tchou-tchou dans la baleine', '27.png', 12),
(28, 'Une fiole à la mer', '28.png', 12),
(29, 'Une épopée difficile', '29.png', 12);

-- --------------------------------------------------------

--
-- Structure de la table `themes`
--

DROP TABLE IF EXISTS `themes`;
CREATE TABLE IF NOT EXISTS `themes` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `themes`
--

INSERT INTO `themes` (`Id`, `name`) VALUES
(9, 'Possessions'),
(10, 'Dans les formes'),
(11, 'Animaux mystiques'),
(12, 'Submergé par les eaux');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `password` varchar(60) NOT NULL,
  `admin` tinyint DEFAULT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `EMail` (`mail`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`Id`, `nom`, `prenom`, `mail`, `password`, `admin`) VALUES
(16, 'Doe', 'John', 'john.doe@mahellart.com', '$2y$10$AQcJCTJ.sKgg51W6F6fPy.zuq.wvnfNQSdsgKQp1pyM9bVbYVJwQG', 1);

-- --------------------------------------------------------

--
-- Structure de la table `user_likes`
--

DROP TABLE IF EXISTS `user_likes`;
CREATE TABLE IF NOT EXISTS `user_likes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `realisation_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `realisation_id` (`realisation_id`)
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `user_likes`
--

INSERT INTO `user_likes` (`id`, `user_id`, `realisation_id`) VALUES
(75, 16, 18),
(76, 16, 19),
(77, 16, 20);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `realisations`
--
ALTER TABLE `realisations`
  ADD CONSTRAINT `realisations_ibfk_1` FOREIGN KEY (`Themes_Id`) REFERENCES `themes` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `user_likes`
--
ALTER TABLE `user_likes`
  ADD CONSTRAINT `user_likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_likes_ibfk_2` FOREIGN KEY (`realisation_id`) REFERENCES `realisations` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
