-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mar 12 Janvier 2016 à 11:22
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
  `latitude` decimal(10,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `role` varchar(20) COLLATE utf16_unicode_ci NOT NULL DEFAULT 'member'
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `lastname`, `firstname`, `address`, `zipcode`, `town`, `phone`, `latitude`, `longitude`, `role`) VALUES
(6, 'ducreuxr@gmail.com', '$2y$10$tm.pKQZavrDX2YMsyRlyw.xY7yk8rybleC7sPLGGp82vYeocI1yNi', 'Ducreux', 'Romain', '1 p de chaalis', '77400', 'Thorigny', '0666666666', '48.88413070', '2.70700950', 'member');

--
-- Index pour les tables exportées
--

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
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
