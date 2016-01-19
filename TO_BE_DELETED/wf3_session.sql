-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Jeu 07 Janvier 2016 à 17:27
-- Version du serveur :  5.6.25
-- Version de PHP :  5.6.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `wf3_session`
--

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `email` varchar(60) CHARACTER SET utf8 NOT NULL,
  `password` varchar(256) CHARACTER SET utf8 NOT NULL,
  `token` varchar(100) CHARACTER SET utf8 NOT NULL,
  `expire_token` datetime NOT NULL,
  `created_at` datetime NOT NULL COMMENT 'date création user',
  `updated_at` datetime NOT NULL COMMENT 'date modification'
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `token`, `expire_token`, `created_at`, `updated_at`) VALUES
(1, 'ae@toto.com', '$2y$10$h0v2zUxOj57WMnjQYEqyDOOiit6cEYF7FnStTBYLn2/Hxydhtarra', '', '0000-00-00 00:00:00', '2016-01-06 14:30:10', '2016-01-06 14:30:10'),
(2, 'azeaz@gdfg.com', '$2y$10$vZrg5pldtf3y1hsZb33v2OenOgiMc4g6qRKsO1xSJpXNC0fY6JxlS', '', '0000-00-00 00:00:00', '2016-01-06 14:33:33', '2016-01-06 14:33:33'),
(3, 'eazea@dsfs.com', '$2y$10$2GcA5eYUozGOdWgxGRbDX.O4mNTUeRItV6y5yqUxNwdyf3fL48Xhm', '', '0000-00-00 00:00:00', '2016-01-06 14:34:05', '2016-01-06 14:34:05'),
(4, 'sdsD@TOTO.COM', '$2y$10$tJhPqfGYBzG3Y7bvjdiV8eZ2H4xzaWoTu/RyKrCFTxPyZjz7tMcFW', '', '0000-00-00 00:00:00', '2016-01-06 14:37:31', '2016-01-06 14:37:31'),
(5, 'dqsdqsd@toto.com', '$2y$10$uDpP0CruV08YZgRzJh7LzeieKmDqtZEZQR37raNFxMfkuVBAUSFJe', '', '0000-00-00 00:00:00', '2016-01-06 14:42:57', '2016-01-06 14:42:57'),
(6, 'iuiy@tt.com', '$2y$10$TOTxog.YkuvvvBTlJck2.eoRjwUqJfl9L.8yRaNZwqfq6ThGq1BZu', '', '0000-00-00 00:00:00', '2016-01-06 14:44:23', '2016-01-06 14:44:23'),
(7, 'kjpmjp@fds.com', '$2y$10$tBBRrHrj9tjk.wXlTNsoyeaakgoNdzgmKI1XjnG6qh7ecmm550S.y', '', '0000-00-00 00:00:00', '2016-01-06 14:53:29', '2016-01-06 14:53:29'),
(8, 'QSqs@REZ.COM', '', '', '0000-00-00 00:00:00', '2016-01-06 14:56:02', '2016-01-06 14:56:02'),
(9, 'Romain@chezmoi.com', '$2y$10$Dij5Z.l7N0Kl0EfPR34KO.JRyfOKAh2E91Pw3FpTmn0eElQ1HLWFG', 'd8579a62fccc6766a36fcf9330e1caab', '2016-01-08 14:27:57', '2016-01-06 15:28:52', '2016-01-07 14:27:57'),
(10, 'romain.treppoz@laposte.net', '$2y$10$ZrnqV/A2weZrK7FlDcfJy.mWEvmRjUPKkLDt19VvGEfvNh04JgHVW', '6dde94056cb04b1e824533920cd24d3c', '2016-01-08 17:03:57', '2016-01-06 16:09:52', '2016-01-07 17:03:57'),
(11, 'romaintreppoz@gmail.com', '$2y$10$WCP7zK3s7EGBjA45osHn6OQFTQWBIBTq/YgAiuIGjrQY0a96EwP76', '084f55a8dd25a4e3e2e1c77569f3416e', '2016-01-08 16:55:45', '2016-01-07 14:41:37', '2016-01-07 16:55:45'),
(12, 'Joe.Dalton@gmail.com', '$2y$10$Kl0IMosz5pcwmKaMpJ4qYu.5GMm7B6UKOL5twgqkrBGWdWekw3yUG', '', '0000-00-00 00:00:00', '2016-01-07 15:09:53', '2016-01-07 15:09:53');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
