-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mer. 14 déc. 2022 à 15:31
-- Version du serveur : 10.6.11-MariaDB-0ubuntu0.22.04.1
-- Version de PHP : 8.1.2-1ubuntu2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `forum_no_mb_nl`
--

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE `clients` (
                           `id` int(11) NOT NULL,
                           `pseudo` varchar(24) NOT NULL,
                           `password` text NOT NULL,
                           `date` date NOT NULL,
                           `permission` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`id`, `pseudo`, `password`, `date`, `permission`) VALUES
                                                                             (3, 'test', '5f4dcc3b5aa765d61d8327deb882cf99', '2022-12-09', 'user'),
                                                                             (9, 'Slophil', '5f4dcc3b5aa765d61d8327deb882cf99', '2022-12-09', 'user');

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE `messages` (
                            `id` int(11) NOT NULL,
                            `idauteur` int(11) NOT NULL,
                            `idsujet` int(11) NOT NULL,
                            `contenu` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`id`, `idauteur`, `idsujet`, `contenu`) VALUES
                                                                    (4, 9, 1, 'ergouyerhouerg'),
                                                                    (5, 9, 1, 'ergergererg'),
                                                                    (6, 9, 1, 'zrgergr'),
                                                                    (7, 3, 1, 'rgergrezgzgr'),
                                                                    (9, 3, 2, 'Comment faire, aidez moi !'),
                                                                    (11, 9, 2, 'brfbersbdrbder');

-- --------------------------------------------------------

--
-- Structure de la table `sujets`
--

CREATE TABLE `sujets` (
                          `id` int(11) NOT NULL,
                          `idauteur` int(11) NOT NULL,
                          `titre` varchar(128) NOT NULL,
                          `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `sujets`
--

INSERT INTO `sujets` (`id`, `idauteur`, `titre`, `date`) VALUES (1, 9, 'test', '2022-12-09'), (2, 3, 'Comment demander ma soeur en mariage ?', '2022-12-12');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `clients`
--
ALTER TABLE `clients`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pseudo` (`pseudo`);

--
-- Index pour la table `messages`
--
ALTER TABLE `messages`
    ADD PRIMARY KEY (`id`),
  ADD KEY `idauteur` (`idauteur`),
  ADD KEY `idsujet` (`idsujet`);

--
-- Index pour la table `sujets`
--
ALTER TABLE `sujets`
    ADD PRIMARY KEY (`id`),
  ADD KEY `idauteur` (`idauteur`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `clients`
--
ALTER TABLE `clients`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `sujets`
--
ALTER TABLE `sujets`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `messages`
--
ALTER TABLE `messages`
    ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`idauteur`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
    ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`idsujet`) REFERENCES `sujets` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `sujets`
--
ALTER TABLE `sujets`
    ADD CONSTRAINT `sujets_ibfk_1` FOREIGN KEY (`idauteur`) REFERENCES `clients` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
