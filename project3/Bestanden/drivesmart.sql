-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 07 apr 2025 om 15:39
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
(1, 'a', 'aa', 'a', 'beschikbaar', 23434, 1, '2025-04-07 13:04:52'),
(2, 's', 's', 's', 'beschikbaar', 232323, 3, '2025-04-07 13:04:52');

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
  `aangemaakt_op` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `gebruikers`
--

INSERT INTO `gebruikers` (`id`, `gebruikersnaam`, `wachtwoord`, `email`, `rol`, `ingelogd`, `aangemaakt_op`) VALUES
(1, 'marouane', 'j', 'm@gmail.com', 'leerling', 0, '2025-04-07 13:02:19'),
(2, 'admin', '1', 'admin@gmail.com', 'admin', 0, '2025-04-07 13:03:19'),
(3, 'qwert', '$2y$10$hIKbwxxvc5EO78PR6vgJn..T7iDURO6bporJ3csKCZ5F4le.7fdaO', 'q@gmail.com', 'instructeur', 0, '2025-04-07 13:04:06');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `lessen`
--

CREATE TABLE `lessen` (
  `id` int(11) NOT NULL,
  `leerling_id` int(11) DEFAULT NULL,
  `instructeur_id` int(11) DEFAULT NULL,
  `auto_id` int(11) DEFAULT NULL,
  `les_datum` datetime DEFAULT NULL,
  `onderwerp` varchar(255) DEFAULT NULL,
  `status` enum('gepland','afgerond','geannuleerd') DEFAULT 'gepland',
  `opmerkingen` text DEFAULT NULL,
  `aangemaakt_op` timestamp NOT NULL DEFAULT current_timestamp(),
  `reden` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `lessen`
--

INSERT INTO `lessen` (`id`, `leerling_id`, `instructeur_id`, `auto_id`, `les_datum`, `onderwerp`, `status`, `opmerkingen`, `aangemaakt_op`, `reden`) VALUES
(16, 1, 3, 1, '2025-04-08 15:07:00', 'les', 'geannuleerd', NULL, '2025-04-07 13:07:33', '1'),
(17, 1, 3, 1, '2025-04-09 15:28:00', 'les', 'geannuleerd', NULL, '2025-04-07 13:28:34', 'ziek');

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
  ADD KEY `toegewezen_aan` (`toegewezen_aan`);

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
  ADD KEY `leerling_id` (`leerling_id`),
  ADD KEY `instructeur_id` (`instructeur_id`),
  ADD KEY `auto_id` (`auto_id`);

--
-- Indexen voor tabel `mededelingen`
--
ALTER TABLE `mededelingen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gebruiker_id` (`gebruiker_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT voor een tabel `gebruikers`
--
ALTER TABLE `gebruikers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT voor een tabel `lessen`
--
ALTER TABLE `lessen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT voor een tabel `mededelingen`
--
ALTER TABLE `mededelingen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `opmerkingen`
--
ALTER TABLE `opmerkingen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  ADD CONSTRAINT `autos_ibfk_1` FOREIGN KEY (`toegewezen_aan`) REFERENCES `gebruikers` (`id`) ON DELETE SET NULL;

--
-- Beperkingen voor tabel `lessen`
--
ALTER TABLE `lessen`
  ADD CONSTRAINT `lessen_ibfk_1` FOREIGN KEY (`leerling_id`) REFERENCES `gebruikers` (`id`),
  ADD CONSTRAINT `lessen_ibfk_2` FOREIGN KEY (`instructeur_id`) REFERENCES `gebruikers` (`id`),
  ADD CONSTRAINT `lessen_ibfk_3` FOREIGN KEY (`auto_id`) REFERENCES `autos` (`id`);

--
-- Beperkingen voor tabel `mededelingen`
--
ALTER TABLE `mededelingen`
  ADD CONSTRAINT `mededelingen_ibfk_1` FOREIGN KEY (`gebruiker_id`) REFERENCES `gebruikers` (`id`);

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
