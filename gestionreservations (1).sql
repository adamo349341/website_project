-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 19 jan. 2025 à 20:48
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestionreservations`
--

-- --------------------------------------------------------

--
-- Structure de la table `administrateurs`
--

CREATE TABLE `administrateurs` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `administrateurs`
--

INSERT INTO `administrateurs` (`id`, `nom`, `prenom`, `email`, `mot_de_passe`) VALUES
(2, 'Mentagui', 'Adam', 'adam@gmail.com', '$2y$10$M3Hn3PGEx6R0RyfLKyJFC.ib2AdD68vj2J0sgUGdyCcTAh7DfGHIW');

-- --------------------------------------------------------

--
-- Structure de la table `hotels`
--

CREATE TABLE `hotels` (
  `id` int(11) NOT NULL,
  `nom` varchar(150) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `ville` varchar(100) NOT NULL,
  `code_postal` varchar(20) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `hotels`
--

INSERT INTO `hotels` (`id`, `nom`, `adresse`, `ville`, `code_postal`, `telephone`, `description`, `date_creation`) VALUES
(1, 'jdfsdkjfsdh', 'dsofsfdfo', 'jfsdsdjfl', '00000', '0603661652', 'ggdfgg', '2025-01-17 23:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `utilisateur_id` int(11) NOT NULL,
  `type_etablissement` enum('hotel','restaurant','salle') NOT NULL,
  `etablissement_id` int(11) NOT NULL,
  `date_reservation` date NOT NULL,
  `heure_reservation` time DEFAULT NULL,
  `statut` enum('en_attente','confirmée','annulée') DEFAULT 'en_attente',
  `date_creation_res` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `reservations`
--

INSERT INTO `reservations` (`id`, `utilisateur_id`, `type_etablissement`, `etablissement_id`, `date_reservation`, `heure_reservation`, `statut`, `date_creation_res`) VALUES
(13, 2, 'hotel', 1, '2025-01-21', '17:43:00', 'confirmée', '2025-01-19 16:40:36'),
(14, 2, 'restaurant', 1, '2025-01-24', '22:40:00', 'confirmée', '2025-01-19 16:40:58'),
(15, 2, 'salle', 3, '2025-01-20', '20:41:00', 'confirmée', '2025-01-19 16:41:10'),
(16, 2, 'salle', 1, '2025-01-23', '20:41:00', 'confirmée', '2025-01-19 16:41:22'),
(17, 2, 'hotel', 1, '2025-01-16', '20:41:00', 'confirmée', '2025-01-19 16:41:34'),
(18, 2, 'restaurant', 1, '2025-01-17', '17:46:00', 'confirmée', '2025-01-19 16:43:16');

-- --------------------------------------------------------

--
-- Structure de la table `restaurants`
--

CREATE TABLE `restaurants` (
  `id` int(11) NOT NULL,
  `nom` varchar(150) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `ville` varchar(100) NOT NULL,
  `code_postal` varchar(20) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `restaurants`
--

INSERT INTO `restaurants` (`id`, `nom`, `adresse`, `ville`, `code_postal`, `telephone`, `description`, `date_creation`) VALUES
(2, 'YOUSSEF MISAOUI', 'TAZA', 'Fés', '321567', '0603661652', 'sdkfsklfsjkfsdjhk', '2025-01-21 23:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `salles`
--

CREATE TABLE `salles` (
  `id` int(11) NOT NULL,
  `nom` varchar(150) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `ville` varchar(100) NOT NULL,
  `code_postal` varchar(20) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `capacite` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `salles`
--

INSERT INTO `salles` (`id`, `nom`, `adresse`, `ville`, `code_postal`, `telephone`, `capacite`, `description`, `date_creation`) VALUES
(1, 'jdfsdkjfsdh', 'dsofsfdfo', '', '00000', '0603661652', 1234, 'sdkfsklfsjkfsdjhk', '2024-12-31 23:00:00'),
(2, 'jdfsdkjfsdh', 'dsofsfdfo', '', '00000', '0603661652', 1234, 'sdkfsklfsjkfsdjhk', '2024-12-31 23:00:00'),
(3, 'youssef', 'TAZA', '', '321567', '0603661652', 30, 'ggdfgg', '2025-01-12 23:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `nom`, `prenom`, `email`, `mot_de_passe`) VALUES
(1, 'Dupont', 'Jean', 'aa@gmail.com', '$2y$10$V3pek.ouxlsmNyJdu.h2vOZMSsMNMO/VhSM2jdAAGIhTWu75AAvle'),
(2, 'Misaoui', 'Youssef', 'youssef@gmail.com', '$2y$10$Zno3Vr6SnnpOp7vMate8gu7QoFEbD9PQQ0Eq/4vrmV0NtH06YJ4qW');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `administrateurs`
--
ALTER TABLE `administrateurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `hotels`
--
ALTER TABLE `hotels`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `restaurants`
--
ALTER TABLE `restaurants`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `salles`
--
ALTER TABLE `salles`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `administrateurs`
--
ALTER TABLE `administrateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `hotels`
--
ALTER TABLE `hotels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `restaurants`
--
ALTER TABLE `restaurants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `salles`
--
ALTER TABLE `salles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
