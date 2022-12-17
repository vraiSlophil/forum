-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3307
-- Généré le : ven. 16 déc. 2022 à 08:53
-- Version du serveur : 10.6.5-MariaDB
-- Version de PHP : 7.4.26

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

DROP TABLE IF EXISTS `clients`;
CREATE TABLE IF NOT EXISTS `clients` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `pseudo` varchar(24) NOT NULL,
    `password` text NOT NULL,
    `date` date NOT NULL,
    `permission` text NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `pseudo` (`pseudo`)
    ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`id`, `pseudo`, `password`, `date`, `permission`) VALUES (1, 'administrateur', '5f4dcc3b5aa765d61d8327deb882cf99', '2022-12-09', 'administrateur');

-- --------------------------------------------------------

--
-- Structure de la table `likes`
--

DROP TABLE IF EXISTS `likes`;
CREATE TABLE IF NOT EXISTS `likes` (
    `idmessage` int(11) NOT NULL,
    `iduser` int(11) NOT NULL,
    KEY `iduser` (`iduser`),
    KEY `idmessage` (`idmessage`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `idauteur` int(11) NOT NULL,
    `idsujet` int(11) NOT NULL,
    `contenu` text NOT NULL,
    PRIMARY KEY (`id`),
    KEY `idauteur` (`idauteur`),
    KEY `idsujet` (`idsujet`)
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `sujets`
--

DROP TABLE IF EXISTS `sujets`;
CREATE TABLE IF NOT EXISTS `sujets` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `idauteur` int(11) NOT NULL,
    `titre` varchar(128) NOT NULL,
    `date` date NOT NULL,
    PRIMARY KEY (`id`),
    KEY `idauteur` (`idauteur`)
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `likes`
--
ALTER TABLE `likes`
    ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`iduser`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`idmessage`) REFERENCES `messages` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `messages`
--
ALTER TABLE `messages`
    ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`idauteur`) REFERENCES `clients` (`id`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`idsujet`) REFERENCES `sujets` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;