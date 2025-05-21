-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 21 mai 2025 à 16:24
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `esportify`
--

-- --------------------------------------------------------

--
-- Structure de la table `event`
--

DROP TABLE IF EXISTS `event`;
CREATE TABLE IF NOT EXISTS `event` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `date_event` datetime NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int UNSIGNED NOT NULL,
  `started` tinyint(1) NOT NULL DEFAULT '0',
  `date_end` datetime NOT NULL,
  `img` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `event_ibfk_1` (`created_by`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `event`
--

INSERT INTO `event` (`id`, `title`, `description`, `date_event`, `created_at`, `created_by`, `started`, `date_end`, `img`) VALUES
(4, 'test event', 'test tournoi', '2025-05-13 13:39:00', '2025-05-13 12:12:56', 2, 1, '2025-05-13 16:02:47', NULL),
(8, 'Warzone', 'Pour tous, amateurs ou confirmés !', '2025-05-20 14:29:00', '2025-05-20 14:09:20', 2, 1, '2025-05-22 18:37:00', 'img/warzone.jpg'),
(10, 'LoL', 'Tournoi LoL – Rift Masters 2025\r\n8 équipes, 1 trophée, 10 000€ en jeu. Rejoignez-nous le 15 juin pour le choc des titans sur la Faille de l’invocateur. Qui dominera le Rift ?', '2025-06-15 19:00:00', '2025-05-21 17:51:43', 6, 0, '2025-06-15 23:30:00', 'img/lol.jpg'),
(11, 'Valorant', 'Tournoi Valorant – Spike Clash 2025\r\n6 équipes, 1 map à la fois, réflexes affûtés. Rendez-vous le 22 juin pour une soirée explosive sur le serveur. Qui plantera le spike le plus vite ?', '2025-06-22 18:30:00', '2025-05-21 17:53:09', 6, 0, '2025-06-22 23:00:00', 'img/valorant.jpg'),
(13, 'CallOfDuty', 'Tournoi Call of Duty – Ops Arena 2025\r\n4v4, maps nerveuses, killstreaks garantis. Le 6 juillet, les escouades s\'élancent dans l’arène pour décrocher le titre de champions CoD.', '2025-07-06 11:00:00', '2025-05-21 18:07:17', 6, 0, '2025-07-06 15:59:00', 'img/cod.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `eventparticipant`
--

DROP TABLE IF EXISTS `eventparticipant`;
CREATE TABLE IF NOT EXISTS `eventparticipant` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `event_id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `joined_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `eventparticipant_ibfk_1` (`event_id`),
  KEY `eventparticipant_ibfk_2` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `eventparticipant`
--

INSERT INTO `eventparticipant` (`id`, `event_id`, `user_id`, `joined_at`, `status`) VALUES
(10, 4, 3, '2025-05-13 18:06:17', 1),
(25, 8, 3, '2025-05-20 14:12:00', 1),
(30, 8, 2, '2025-05-20 18:07:02', 1),
(33, 11, 6, '2025-05-21 17:53:32', 1),
(34, 10, 7, '2025-05-21 17:59:33', 1);

-- --------------------------------------------------------

--
-- Structure de la table `favorite_event`
--

DROP TABLE IF EXISTS `favorite_event`;
CREATE TABLE IF NOT EXISTS `favorite_event` (
  `user_id` int NOT NULL,
  `event_id` int NOT NULL,
  PRIMARY KEY (`user_id`,`event_id`),
  KEY `event_id` (`event_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `favorite_event`
--

INSERT INTO `favorite_event` (`user_id`, `event_id`) VALUES
(1, 4),
(1, 5),
(2, 6),
(2, 8),
(2, 9),
(3, 2),
(3, 5),
(3, 6),
(3, 8),
(4, 2),
(4, 6),
(4, 9),
(5, 2),
(5, 5),
(6, 11),
(6, 13),
(7, 10),
(9, 8),
(9, 13);

-- --------------------------------------------------------

--
-- Structure de la table `newsletter`
--

DROP TABLE IF EXISTS `newsletter`;
CREATE TABLE IF NOT EXISTS `newsletter` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `subscribed_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `newsletter`
--

INSERT INTO `newsletter` (`id`, `email`, `subscribed_at`) VALUES
(1, 'newsletter@test.fr', '2025-05-13 19:26:47'),
(2, 'tesdenewsletter@test.fr', '2025-05-15 23:31:42'),
(3, 'abc@def.fr', '2025-05-18 16:39:22'),
(4, 'news@newsletter.fr', '2025-05-18 16:51:43'),
(5, 'hello@free.fr', '2025-05-18 16:54:34');

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`id`, `name`) VALUES
(1, 'visiteur'),
(2, 'joueur'),
(3, 'organisateur'),
(4, 'administrateur');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `role_id` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `created_at`, `role_id`) VALUES
(2, 'admin', 'admin@mail.com', '$2y$10$6/oPzPPgF472OvnkvjyvNejWLDJgTx1.EVEawTSg/V/Ew.Jih70P2', '2025-05-09 16:34:27', 4),
(3, 'ocewan', 'ocewan@test.fr', '$2y$10$UnT/VUd5jyJPCLf9OQBJHuw6gwgySxAvB8DdmdIruTzt6HBqcHxeu', '2025-05-09 16:54:36', 2),
(6, 'Scari', 'scari@gmail.com', '$2y$10$YOAmHWX6Kz0DxzdiE3s/te1erYQeCa928qVTHxo3KQpWkpFRrXZX.', '2025-05-21 16:16:57', 4),
(7, 'Kirbs', 'kirbs@gmail.com', '$2y$10$FlGCnBYLuuEKFoVXw0v5.uOLQFIJ4S9d/VY/P.2l6XCA/VgYf0odC', '2025-05-21 17:40:39', 3),
(8, 'froGGy', 'frog@hotmail.fr', '$2y$10$6/d5nMYAOXk77QgbbFUFV.d6O2.g48qAJ.kgCe3I5YxYcx2K88j8u', '2025-05-21 17:46:06', 2),
(9, 'Valdus', 'vald@gmail.com', '$2y$10$HJmnhEhJsFGH7nKgS29Oq.Ed2RNBCNz9DK8FpUHzzIMdEm53s/og.', '2025-05-21 18:09:32', 3);

-- --------------------------------------------------------

--
-- Structure de la table `validation`
--

DROP TABLE IF EXISTS `validation`;
CREATE TABLE IF NOT EXISTS `validation` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `event_id` int UNSIGNED NOT NULL,
  `validated_by` int UNSIGNED NOT NULL,
  `validated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `validation_ibfk_1` (`event_id`),
  KEY `validation_ibfk_2` (`validated_by`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `validation`
--

INSERT INTO `validation` (`id`, `event_id`, `validated_by`, `validated_at`, `status`) VALUES
(2, 4, 2, '2025-05-13 12:13:16', 1),
(6, 8, 2, '2025-05-20 14:09:31', 1),
(8, 10, 6, '2025-05-21 17:51:53', 1),
(9, 11, 6, '2025-05-21 17:53:15', 1),
(11, 13, 6, '2025-05-21 18:07:33', 1);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `event_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `eventparticipant`
--
ALTER TABLE `eventparticipant`
  ADD CONSTRAINT `eventparticipant_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `eventparticipant_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `validation`
--
ALTER TABLE `validation`
  ADD CONSTRAINT `validation_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `validation_ibfk_2` FOREIGN KEY (`validated_by`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
