-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mer 13 Janvier 2016 à 10:03
-- Version du serveur :  5.6.25
-- Version de PHP :  5.6.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `wf3_gameloc`
--

-- --------------------------------------------------------

--
-- Structure de la table `games`
--

CREATE TABLE IF NOT EXISTS `games` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `url_img` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `published_at` datetime NOT NULL,
  `game_time` int(11) NOT NULL,
  `is_available` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `plateform_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `games`
--

INSERT INTO `games` (`id`, `name`, `url_img`, `description`, `published_at`, `game_time`, `is_available`, `created_at`, `updated_at`, `plateform_id`) VALUES
(3, 'Call of Duty', 'public/img/black-ops.jpg', 'jhgkjg', '2016-01-06 00:00:00', 15, 0, '2016-01-11 17:05:36', '2016-01-11 17:05:36', 2),
(4, 'Assassin''s Creed Syndicate', 'public/img/unity.jpg', '<wdgsqrh', '2016-01-02 12:11:10', 12, 0, '2016-01-12 12:09:27', '2016-01-12 12:09:27', 3),
(5, 'Batman', 'public/img/batman.jpg', 'FKJQSFKUG', '2016-01-05 00:00:00', 12, 0, '2016-01-12 12:21:12', '2016-01-12 12:21:12', 1),
(6, 'Bloodborn', 'public/img/bloodborn.png', 'hfhtjudtjtj', '2016-01-02 00:00:00', 8, 1, '2016-01-12 12:22:43', '2016-01-12 12:22:43', 2),
(7, 'Dota 2', 'public/img/dota.jpg', ',jgxjfykjykjkj', '2016-01-08 00:00:00', 15, 1, '2016-01-12 12:23:41', '2016-01-12 12:23:41', 3),
(8, 'Fallout 4', 'public/img/fallout.jpg', 'x,jkjkjikjxj bhfdhhdh', '2016-01-05 00:00:00', 25, 1, '2016-01-12 12:24:44', '2016-01-12 12:24:44', 1),
(9, 'Halo 5', 'public/img/halo.jpg', 'jddkdykkkd', '2016-01-01 00:00:00', 8, 1, '2016-01-12 12:25:36', '2016-01-12 12:25:36', 2),
(10, 'Battlefield', 'public/img/hardline.jpg', 'kl<dgs<gljgklj', '2016-01-12 00:00:00', 15, 1, '2016-01-12 12:26:49', '2016-01-12 12:26:49', 3),
(11, 'Just Cause 3', 'public/img/just-cause.jpg', ';gjshrkjqshkliq(yhe', '2016-01-01 00:00:00', 12, 1, '2016-01-12 12:27:36', '2016-01-12 12:27:36', 1),
(12, 'League of legends', 'public/img/league-of-legends.jpg', 'ghughoiqgoirq', '2016-01-10 00:00:00', 20, 1, '2016-01-12 12:28:48', '2016-01-12 12:28:48', 1);

-- --------------------------------------------------------

--
-- Structure de la table `plateforms`
--

CREATE TABLE IF NOT EXISTS `plateforms` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `plateforms`
--

INSERT INTO `plateforms` (`id`, `name`) VALUES
(1, 'Xbox'),
(2, 'PS4'),
(3, 'PC');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `email` varchar(60) CHARACTER SET utf8 NOT NULL,
  `password` varchar(256) CHARACTER SET utf8 NOT NULL,
  `lastname` varchar(100) COLLATE utf16_unicode_ci NOT NULL,
  `firstname` varchar(100) COLLATE utf16_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf16_unicode_ci NOT NULL,
  `zipcode` varchar(5) COLLATE utf16_unicode_ci NOT NULL,
  `town` varchar(50) COLLATE utf16_unicode_ci NOT NULL DEFAULT 'Paris',
  `phone` varchar(10) COLLATE utf16_unicode_ci NOT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `role` varchar(20) CHARACTER SET utf8 NOT NULL DEFAULT 'member'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `lastname`, `firstname`, `address`, `zipcode`, `town`, `phone`, `latitude`, `longitude`, `role`) VALUES
(1, 'renaud.tedaldi@hotmail.fr', '$2y$10$IjnzxYNSm4RjTX4Rh9v6beyJxBgBwzZGEwK.O53K0lOytDB2u5V7q', 'ren', 'ted', 'rhqhh', '75001', 'paris', '0144444444', '48.86404930', '2.33105260', 'member');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`),
  ADD KEY `plateform_id` (`plateform_id`);

--
-- Index pour la table `plateforms`
--
ALTER TABLE `plateforms`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `games`
--
ALTER TABLE `games`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT pour la table `plateforms`
--
ALTER TABLE `plateforms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `games`
--
ALTER TABLE `games`
  ADD CONSTRAINT `fk_plateform` FOREIGN KEY (`plateform_id`) REFERENCES `plateforms` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
