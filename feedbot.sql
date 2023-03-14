-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mar. 14 mars 2023 à 08:26
-- Version du serveur : 10.5.18-MariaDB-0+deb11u1
-- Version de PHP : 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `feedbot_2`
--

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

CREATE TABLE `articles` (
  `id` bigint(20) NOT NULL,
  `title` text NOT NULL,
  `excerpt` text NOT NULL,
  `url` text NOT NULL,
  `thumbnail` text NOT NULL,
  `feed_id` bigint(20) DEFAULT NULL,
  `platform` text DEFAULT NULL,
  `youtubeid` text DEFAULT NULL,
  `peertubeid` text DEFAULT NULL,
  `embed` text DEFAULT NULL,
  `id_site` bigint(20) NOT NULL,
  `date` varchar(200) NOT NULL,
  `shares_count` bigint(20) NOT NULL DEFAULT 0,
  `404_count` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `articles_published`
--

CREATE TABLE `articles_published` (
  `id` bigint(20) NOT NULL,
  `uid` bigint(20) NOT NULL,
  `article_id` bigint(20) NOT NULL,
  `site_id` bigint(20) NOT NULL,
  `feed_id` bigint(20) NOT NULL,
  `is_published` bigint(20) NOT NULL DEFAULT 0,
  `is_shared` int(11) NOT NULL DEFAULT 0,
  `bookmarked` int(11) NOT NULL DEFAULT 0,
  `telegramed` int(11) DEFAULT 0,
  `published_date` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `feeds`
--

CREATE TABLE `feeds` (
  `id` bigint(20) NOT NULL,
  `site_id` bigint(20) NOT NULL,
  `feed_title` varchar(1000) NOT NULL,
  `feed_url` text NOT NULL,
  `thumbnail` text NOT NULL,
  `language` text NOT NULL DEFAULT 'fr',
  `is_sensitive` int(11) DEFAULT NULL,
  `wiki_slug` text DEFAULT NULL,
  `subscribers` bigint(20) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `feeds_published`
--

CREATE TABLE `feeds_published` (
  `id` bigint(20) NOT NULL,
  `feed_id` bigint(20) NOT NULL,
  `uid` bigint(20) NOT NULL,
  `share_title` int(11) NOT NULL DEFAULT 0,
  `share_description` int(11) NOT NULL DEFAULT 1,
  `share_image` int(11) NOT NULL DEFAULT 0,
  `visibility` varchar(10) NOT NULL DEFAULT 'public',
  `is_sensitive` text NOT NULL DEFAULT 'false',
  `spoiler_text` text DEFAULT NULL,
  `telegram` int(11) DEFAULT 0,
  `in_mail` int(11) NOT NULL DEFAULT 0,
  `is_active` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sites`
--

CREATE TABLE `sites` (
  `id` bigint(20) NOT NULL,
  `thumbnail` text NOT NULL,
  `url` varchar(250) NOT NULL,
  `wiki_slug` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `statuses`
--

CREATE TABLE `statuses` (
  `id` bigint(20) NOT NULL,
  `uid` bigint(20) NOT NULL,
  `article_id` bigint(20) NOT NULL,
  `post_id` bigint(20) NOT NULL,
  `post_visibility` text NOT NULL,
  `url` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tasks`
--

CREATE TABLE `tasks` (
  `feeds_last_id` int(11) NOT NULL,
  `articles_last_id` int(11) NOT NULL,
  `404_last_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `username` varchar(50) NOT NULL,
  `mail` text DEFAULT NULL,
  `daily_mail` int(11) DEFAULT NULL,
  `telegram` int(11) DEFAULT NULL,
  `last_activity` int(11) NOT NULL DEFAULT 0,
  `admin` int(11) NOT NULL DEFAULT 0,
  `joined_date` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `articles_published`
--
ALTER TABLE `articles_published`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `feeds`
--
ALTER TABLE `feeds`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `feeds_published`
--
ALTER TABLE `feeds_published`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `sites`
--
ALTER TABLE `sites`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `articles_published`
--
ALTER TABLE `articles_published`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `feeds`
--
ALTER TABLE `feeds`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `feeds_published`
--
ALTER TABLE `feeds_published`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `sites`
--
ALTER TABLE `sites`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `statuses`
--
ALTER TABLE `statuses`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
