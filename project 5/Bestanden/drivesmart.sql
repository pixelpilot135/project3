-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 08 apr 2025 om 10:48
-- Serverversie: 10.4.32-MariaDB
-- PHP-versie: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `drivesmart`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `autos`
--

CREATE TABLE `autos` (
  `id` int(11) NOT NULL,
  `merk` varchar(100) DEFAULT NULL,
  `model` varchar(100) DEFAULT NULL,
  `kenteken` varchar(15) NOT NULL,
  `status` enum('beschikbaar','onderhoud','verwijderd') DEFAULT 'beschikbaar',
  `kilometerstand` int(11) DEFAULT NULL,
  `toegewezen_aan` int(11) DEFAULT NULL,
  `aangemaakt_op` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `autos`
--

INSERT INTO `autos` (`id`, `merk`, `model`, `kenteken`, `status`, `kilometerstand`, `toegewezen_aan`, `aangemaakt_op`) VALUES
(3, 'Audi', 'A4', 'AB-123-CD', 'beschikbaar', 120000, NULL, '0000-00-00 00:00:00'),
(4, 'BMW', '3 Serie', 'XY-456-ZY', 'beschikbaar', 85000, NULL, '2025-04-06 07:15:00'),
(5, 'Mercedes', 'C-Klasse', 'CD-789-EF', 'beschikbaar', 65000, NULL, '2025-04-05 12:50:00'),
(6, 'Volkswagen', 'Golf', 'EF-321-GH', 'beschikbaar', 45000, NULL, '2025-04-04 08:05:00'),
(7, 'Toyota', 'Corolla', 'GH-654-IJ', 'beschikbaar', 175000, NULL, '2025-04-03 14:20:00'),
(8, 'Ford', 'Focus', 'IJ-987-KL', 'beschikbaar', 95000, NULL, '2025-04-02 11:00:00'),
(9, 'Renault', 'Clio', 'KL-543-MN', 'beschikbaar', 120000, NULL, '2025-04-01 09:25:00'),
(10, 'Peugeot', '208', 'MN-321-OP', 'beschikbaar', 70000, NULL, '2025-03-31 10:10:00');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gebruikers`
--

CREATE TABLE `gebruikers` (
  `id` int(11) NOT NULL,
  `gebruikersnaam` varchar(100) NOT NULL,
  `wachtwoord` varchar(255) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `rol` enum('admin','instructeur','leerling') NOT NULL,
  `ingelogd` tinyint(1) DEFAULT 0,
  `aangemaakt_op` timestamp NOT NULL DEFAULT current_timestamp(),
  `stad` varchar(250) NOT NULL,
  `geboortedatum` datetime DEFAULT NULL,
  `telefoon` int(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `gebruikers`
--

INSERT INTO `gebruikers` (`id`, `gebruikersnaam`, `wachtwoord`, `email`, `rol`, `ingelogd`, `aangemaakt_op`, `stad`, `geboortedatum`, `telefoon`) VALUES
(4, 'admin', '$2y$10$nS76UkpcIZ6YG8Id7r6k0.ya7clppFhhzTWdFnq7uXxGDTDqTi3fK', 'm@gmail.com', 'admin', 0, '2025-04-08 08:40:38', '', NULL, 0),
(5, 'leerling', '$2y$10$KGVgSm1ZSy3ByOcjKLLcL.RU6/GaU10pysInn49fO1oCkPPKJmsG6', 'n@gmail.com', 'leerling', 0, '2025-04-08 08:41:40', 'amsterdam', '2025-04-17 10:45:31', 37837873),
(6, 'instructeur', '$2y$10$XTyFELw8F9CQlrT0xsUfqe21Rk.XNwEpyBwssJLmNpPmFerKDEv3y', 'i@gmail.com', 'instructeur', 0, '2025-04-08 08:41:59', '', NULL, 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `lessen`
--

CREATE TABLE `lessen` (
  `id` int(11) NOT NULL,
  `leerling_id` int(11) DEFAULT NULL,
  `instructeur_id` int(11) DEFAULT NULL,a
  `auto_id` int(11) DEFAULT NULL,
  `les_datum` datetime DEFAULT NULL,
  `onderwerp` varchar(255) DEFAULT NULL,
  `status` enum('gepland','afgerond','geannuleerd') DEFAULT 'gepland',
  `opmerkingen` text DEFAULT NULL,
  `aangemaakt_op` timestamp NOT NULL DEFAULT current_timestamp(),
  `reden` text DEFAULT NULL,
  `Locatie` varchar(70) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `mededelingen`
--

CREATE TABLE `mededelingen` (
  `id` int(11) NOT NULL,
  `bericht` text NOT NULL,
  `gebruiker_id` int(11) DEFAULT NULL,
  `aangemaakt_op` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `opmerkingen`
--

CREATE TABLE `opmerkingen` (
  `id` int(11) NOT NULL,
  `les_id` int(11) DEFAULT NULL,
  `gebruiker_id` int(11) DEFAULT NULL,
  `opmerking` text DEFAULT NULL,
  `aangemaakt_op` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `roosters`
--

CREATE TABLE `roosters` (
  `id` int(11) NOT NULL,
  `gebruiker_id` int(11) DEFAULT NULL,
  `dag` date DEFAULT NULL,
  `start_tijd` time DEFAULT NULL,
  `eind_tijd` time DEFAULT NULL,
  `locatie` varchar(255) DEFAULT NULL,
  `onderwerp` varchar(255) DEFAULT NULL,
  `aangemaakt_op` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `autos`
--
ALTER TABLE `autos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `autos_ibfk_1` (`toegewezen_aan`);

--
-- Indexen voor tabel `gebruikers`
--
ALTER TABLE `gebruikers`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `lessen`
--
ALTER TABLE `lessen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lessen_ibfk_1` (`leerling_id`),
  ADD KEY `lessen_ibfk_2` (`instructeur_id`),
  ADD KEY `lessen_ibfk_3` (`auto_id`);

--
-- Indexen voor tabel `mededelingen`
--
ALTER TABLE `mededelingen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mededelingen_ibfk_1` (`gebruiker_id`);

--
-- Indexen voor tabel `opmerkingen`
--
ALTER TABLE `opmerkingen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `les_id` (`les_id`),
  ADD KEY `gebruiker_id` (`gebruiker_id`);

--
-- Indexen voor tabel `roosters`
--
ALTER TABLE `roosters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gebruiker_id` (`gebruiker_id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `autos`
--
ALTER TABLE `autos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT voor een tabel `gebruikers`
--
ALTER TABLE `gebruikers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT voor een tabel `lessen`
--
ALTER TABLE `lessen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT voor een tabel `mededelingen`
--
ALTER TABLE `mededelingen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT voor een tabel `opmerkingen`
--
ALTER TABLE `opmerkingen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT voor een tabel `roosters`
--
ALTER TABLE `roosters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `autos`
--
ALTER TABLE `autos`
  ADD CONSTRAINT `autos_ibfk_1` FOREIGN KEY (`toegewezen_aan`) REFERENCES `gebruikers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `lessen`
--
ALTER TABLE `lessen`
  ADD CONSTRAINT `lessen_ibfk_1` FOREIGN KEY (`leerling_id`) REFERENCES `gebruikers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lessen_ibfk_2` FOREIGN KEY (`instructeur_id`) REFERENCES `gebruikers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lessen_ibfk_3` FOREIGN KEY (`auto_id`) REFERENCES `autos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `mededelingen`
--
ALTER TABLE `mededelingen`
  ADD CONSTRAINT `mededelingen_ibfk_1` FOREIGN KEY (`gebruiker_id`) REFERENCES `gebruikers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `opmerkingen`
--
ALTER TABLE `opmerkingen`
  ADD CONSTRAINT `opmerkingen_ibfk_1` FOREIGN KEY (`les_id`) REFERENCES `lessen` (`id`),
  ADD CONSTRAINT `opmerkingen_ibfk_2` FOREIGN KEY (`gebruiker_id`) REFERENCES `gebruikers` (`id`);

--
-- Beperkingen voor tabel `roosters`
--
ALTER TABLE `roosters`
  ADD CONSTRAINT `roosters_ibfk_1` FOREIGN KEY (`gebruiker_id`) REFERENCES `gebruikers` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
