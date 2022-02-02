-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 01 fév. 2022 à 10:15
-- Version du serveur : 10.4.21-MariaDB
-- Version de PHP : 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `hospitale2n`
--

-- --------------------------------------------------------

--
-- Structure de la table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `dateHour` datetime NOT NULL,
  `idPatients` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `appointments`
--

INSERT INTO `appointments` (`id`, `dateHour`, `idPatients`) VALUES
(18, '2022-02-01 10:30:00', 10),
(22, '2022-02-22 10:30:00', 34);

-- --------------------------------------------------------

--
-- Structure de la table `patients`
--

CREATE TABLE `patients` (
  `id` int(11) NOT NULL,
  `lastname` varchar(25) NOT NULL,
  `firstname` varchar(25) NOT NULL,
  `birthdate` date NOT NULL,
  `phone` varchar(25) DEFAULT NULL,
  `mail` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `patients`
--

INSERT INTO `patients` (`id`, `lastname`, `firstname`, `birthdate`, `phone`, `mail`) VALUES
(9, 'DELAPLACE', 'PIERRE', '1979-08-12', '5555555555', 'PIERRE.DELAPLACE@EMAILTEST.COM'),
(10, 'DUPOND', 'PAUL', '1988-08-12', '1111111111', 'PAUL-DUPOND@EMAILTEST.COM'),
(11, 'DUPOND', 'PIERRE', '1990-01-25', '2222222222', 'DUPOND.PIERRE@EMAILTEST.COM'),
(12, 'NETO', 'ROSE', '2000-01-01', '3333333333', 'ROSE_NETO@EMAILTEST.COM'),
(28, 'PROUST', 'MARCEL', '1871-07-10', '5555555555', 'MARCEL.PROUST@TESTEMAIL.COM'),
(29, 'DALI', 'SALVADOR', '1904-05-11', '8888888888', 'SALVADOR.DALI@TESTMAIL.COM'),
(30, 'GAUGUIN', 'PAUL', '1848-06-07', '6666666666', 'PAUL.GAUGUIN@POSTIMPRESSIONNISTE.COM'),
(31, 'HUGO', 'VICTOR', '1802-02-26', '1212121212', 'VICTOR.HUGO@LESMISERABLES.COM'),
(32, 'DE BEAUVOIR', 'SIMONE', '1908-01-09', '7575757575', 'SIMONE.BEAUVOIR@TESTEMAIL.COM'),
(34, 'VERNE', 'JULES', '1828-02-08', '5656565656', 'JULES.VERNE@TOURDUMONDE.COM'),
(35, 'IONESCO', 'EUGÈNE', '1909-11-26', '3131313131', 'EUGENE.IONESCO@TESTMAIL.COM');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_appointments_id_patients` (`idPatients`);

--
-- Index pour la table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT pour la table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `FK_appointments_id_patients` FOREIGN KEY (`idPatients`) REFERENCES `patients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
