-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Dim 05 Février 2017 à 22:06
-- Version du serveur :  10.1.19-MariaDB
-- Version de PHP :  5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `godevis`
--

-- --------------------------------------------------------

--
-- Structure de la table `go_client`
--

CREATE TABLE `go_client` (
  `id` int(11) NOT NULL,
  `raison_sociale` varchar(128) NOT NULL,
  `adresse1` varchar(64) DEFAULT NULL,
  `adresse2` varchar(64) DEFAULT NULL,
  `adresse3` varchar(64) DEFAULT NULL,
  `code_postal` varchar(5) DEFAULT NULL,
  `ville` varchar(64) DEFAULT NULL,
  `telephone` varchar(16) DEFAULT NULL,
  `fax` varchar(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `go_client`
--

INSERT INTO `go_client` (`id`, `raison_sociale`, `adresse1`, `adresse2`, `adresse3`, `code_postal`, `ville`, `telephone`, `fax`) VALUES
(1, 'Coyote Systems', NULL, NULL, NULL, '92150', 'Suresness', NULL, NULL),
(2, 'Cartonnage Gauthier Belier', NULL, NULL, NULL, '78500', 'Sartrouville', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `go_contact`
--

CREATE TABLE `go_contact` (
  `id` int(11) NOT NULL,
  `nom` varchar(32) DEFAULT NULL,
  `prenom` varchar(32) DEFAULT NULL,
  `go_client_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `go_contact`
--

INSERT INTO `go_contact` (`id`, `nom`, `prenom`, `go_client_id`) VALUES
(1, 'Coignet', 'Julien', 1),
(2, 'Machin', 'Bidule', 1),
(3, 'Truc', NULL, 1),
(4, 'Dupond', NULL, 2);

-- --------------------------------------------------------

--
-- Structure de la table `go_utilisateur`
--

CREATE TABLE `go_utilisateur` (
  `id` int(11) NOT NULL,
  `login` varchar(32) NOT NULL,
  `password` varchar(88) NOT NULL,
  `salt` varchar(23) NOT NULL,
  `email` varchar(64) DEFAULT NULL,
  `role` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `go_utilisateur`
--

INSERT INTO `go_utilisateur` (`id`, `login`, `password`, `salt`, `email`, `role`) VALUES
(1, 'JohnDoe', '$2y$13$F9v8pl5u5WMrCorP9MLyJeyIsOLj.0/xqKd/hqa5440kyeB7FQ8te', 'YcM=A$nsYzkyeDVjEUa7W9K', NULL, 'ROLE_USER'),
(3, 'admin', '$2y$13$A8MQM2ZNOi99EW.ML7srhOJsCaybSbexAj/0yXrJs4gQ/2BqMMW2K', 'EDDsl&fBCJB|a5XUtAlnQN8', NULL, 'ROLE_ADMIN');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `go_client`
--
ALTER TABLE `go_client`
  ADD PRIMARY KEY (`id`),
  ADD KEY `raison_sociale` (`raison_sociale`),
  ADD KEY `code_postal` (`code_postal`),
  ADD KEY `ville` (`ville`);

--
-- Index pour la table `go_contact`
--
ALTER TABLE `go_contact`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nom` (`nom`),
  ADD KEY `go_client_id` (`go_client_id`);

--
-- Index pour la table `go_utilisateur`
--
ALTER TABLE `go_utilisateur`
  ADD PRIMARY KEY (`id`),
  ADD KEY `login` (`login`),
  ADD KEY `email` (`email`),
  ADD KEY `role` (`role`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `go_client`
--
ALTER TABLE `go_client`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `go_contact`
--
ALTER TABLE `go_contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `go_utilisateur`
--
ALTER TABLE `go_utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `go_contact`
--
ALTER TABLE `go_contact`
  ADD CONSTRAINT `go_contact_ibfk_1` FOREIGN KEY (`go_client_id`) REFERENCES `go_client` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
