-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Počítač: localhost
-- Vytvořeno: Čtv 08. čen 2023, 17:36
-- Verze serveru: 10.3.32-MariaDB
-- Verze PHP: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `php_adventura`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `vstr_characters`
--

CREATE TABLE `vstr_characters` (
  `id` int(8) NOT NULL,
  `user` int(8) NOT NULL,
  `name` varchar(32) NOT NULL,
  `scene` varchar(16) DEFAULT NULL,
  `focus` varchar(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabulky `vstr_characters_scenes`
--

CREATE TABLE `vstr_characters_scenes` (
  `id` int(16) NOT NULL,
  `character_id` int(16) NOT NULL,
  `scene_id` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabulky `vstr_characters_stuffs`
--

CREATE TABLE `vstr_characters_stuffs` (
  `id` int(11) NOT NULL,
  `character_id` int(16) NOT NULL,
  `stuff_id` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabulky `vstr_scenes`
--

CREATE TABLE `vstr_scenes` (
  `id` varchar(16) NOT NULL,
  `title` varchar(32) NOT NULL,
  `description` text NOT NULL,
  `is_start` int(1) NOT NULL DEFAULT 0,
  `is_end` int(1) NOT NULL DEFAULT 0,
  `scene_1` varchar(16) DEFAULT NULL,
  `scene_2` varchar(16) DEFAULT NULL,
  `stuff_1` varchar(16) DEFAULT NULL,
  `stuff_2` varchar(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `vstr_scenes`
--

INSERT INTO `vstr_scenes` (`id`, `title`, `description`, `is_start`, `is_end`, `scene_1`, `scene_2`, `stuff_1`, `stuff_2`) VALUES
('bathroom', 'Koupelna', 'Po odemčení a vstoupení do koupelny se svítílnou, nacházíš pachatele zločinu.Hra byla úspěšně dokončena.', 0, 1, NULL, NULL, NULL, NULL),
('building', 'Budova', 'Právě si vstoupil do budovy.Před temnou místností vlevo leží kabelka.', 0, 0, NULL, NULL, 'handbag', NULL),
('office', 'Kancelář Vyšetřovatele', 'Právě se nacházíš ve své kanceláři plných polic se spisy a knihami. Přišel dopis s informacemi o zločinu, který se stal v parku nedalekého města. Musíš otevřít dopis a vyšetřit to.', 1, 0, NULL, NULL, 'letter', NULL),
('park', 'Temný park', 'Nacházíš se v temném parku, kde s největší pravděpodobností se zločin začal odehrávat. Na zemi u lavičky leží rozbitý mobil s kapkami krve. Dále vedle mobilu leží černá maska.Mobil pečlivě prohlédni, jestli v něm nezůstali nějaké důležité zprávy, které by ti mohli pomoci vevyštřování.', 0, 0, NULL, NULL, 'phone', 'mask');

-- --------------------------------------------------------

--
-- Struktura tabulky `vstr_stuffs`
--

CREATE TABLE `vstr_stuffs` (
  `id` varchar(16) NOT NULL,
  `title` varchar(32) NOT NULL,
  `description` text NOT NULL,
  `scene_1` varchar(16) DEFAULT NULL,
  `scene_2` varchar(16) DEFAULT NULL,
  `stuff_1` varchar(16) DEFAULT NULL,
  `stuff_2` varchar(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `vstr_stuffs`
--

INSERT INTO `vstr_stuffs` (`id`, `title`, `description`, `scene_1`, `scene_2`, `stuff_1`, `stuff_2`) VALUES
('handbag', 'Kabelka', 'Uvnitř kabelky se nachází svítilna, žvýkačky, zrcátko a klíče.\r\n', NULL, NULL, 'light', NULL),
('letter', 'Dopis', 'V parku byla přepadena žena, která utrpěla lehká zranění, když ji\r\nzločinec vytrhl kabelku z ruky. Pachatel neznámý. Je potřeba aby to bylo prošetřeno.', 'park', NULL, NULL, NULL),
('light', 'Svítilna', 'Na svítilně jsou připnuty klíče od koupelny.', 'bathroom', NULL, NULL, NULL),
('mask', 'Maska', 'Černá maska pachatele.', NULL, NULL, NULL, NULL),
('phone', 'Mobil', 'SMS Zpráva\r\nVem všechny věci a setkáme se v budově vedle parku. Místnost 2.', 'building', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktura tabulky `vstr_users`
--

CREATE TABLE `vstr_users` (
  `id` int(8) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(128) NOT NULL,
  `is_admin` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `vstr_users`
--

INSERT INTO `vstr_users` (`id`, `username`, `password`, `is_admin`) VALUES
(5, 'admin', '$2y$10$Cvsdtf6q0oioTE9kK8ynY.WMPmxQyCCBFYEKh710m78.DdvNVkKOC', 1);

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `vstr_characters`
--
ALTER TABLE `vstr_characters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_characters_user` (`user`),
  ADD KEY `scene` (`scene`),
  ADD KEY `focus` (`focus`);

--
-- Klíče pro tabulku `vstr_characters_scenes`
--
ALTER TABLE `vstr_characters_scenes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `character_id` (`character_id`),
  ADD KEY `scene_id` (`scene_id`);

--
-- Klíče pro tabulku `vstr_characters_stuffs`
--
ALTER TABLE `vstr_characters_stuffs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `character_id` (`character_id`),
  ADD KEY `stuff_id` (`stuff_id`);

--
-- Klíče pro tabulku `vstr_scenes`
--
ALTER TABLE `vstr_scenes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `scene_1` (`scene_1`),
  ADD KEY `scene_2` (`scene_2`),
  ADD KEY `stuff_1` (`stuff_1`),
  ADD KEY `stuff_2` (`stuff_2`);

--
-- Klíče pro tabulku `vstr_stuffs`
--
ALTER TABLE `vstr_stuffs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `scene_1` (`scene_1`),
  ADD KEY `scene_2` (`scene_2`),
  ADD KEY `stuff_1` (`stuff_1`),
  ADD KEY `stuff_2` (`stuff_2`);

--
-- Klíče pro tabulku `vstr_users`
--
ALTER TABLE `vstr_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `vstr_characters`
--
ALTER TABLE `vstr_characters`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT pro tabulku `vstr_characters_scenes`
--
ALTER TABLE `vstr_characters_scenes`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pro tabulku `vstr_characters_stuffs`
--
ALTER TABLE `vstr_characters_stuffs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT pro tabulku `vstr_users`
--
ALTER TABLE `vstr_users`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `vstr_characters`
--
ALTER TABLE `vstr_characters`
  ADD CONSTRAINT `fk_characters_user` FOREIGN KEY (`user`) REFERENCES `vstr_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vstr_characters_ibfk_1` FOREIGN KEY (`scene`) REFERENCES `vstr_scenes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vstr_characters_ibfk_2` FOREIGN KEY (`focus`) REFERENCES `vstr_stuffs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `vstr_characters_scenes`
--
ALTER TABLE `vstr_characters_scenes`
  ADD CONSTRAINT `vstr_characters_scenes_ibfk_1` FOREIGN KEY (`character_id`) REFERENCES `vstr_characters` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vstr_characters_scenes_ibfk_2` FOREIGN KEY (`scene_id`) REFERENCES `vstr_scenes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `vstr_characters_stuffs`
--
ALTER TABLE `vstr_characters_stuffs`
  ADD CONSTRAINT `vstr_characters_stuffs_ibfk_1` FOREIGN KEY (`character_id`) REFERENCES `vstr_characters` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vstr_characters_stuffs_ibfk_2` FOREIGN KEY (`stuff_id`) REFERENCES `vstr_stuffs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `vstr_scenes`
--
ALTER TABLE `vstr_scenes`
  ADD CONSTRAINT `vstr_scenes_ibfk_1` FOREIGN KEY (`scene_1`) REFERENCES `vstr_scenes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vstr_scenes_ibfk_2` FOREIGN KEY (`scene_1`) REFERENCES `vstr_scenes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vstr_scenes_ibfk_3` FOREIGN KEY (`scene_2`) REFERENCES `vstr_scenes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vstr_scenes_ibfk_4` FOREIGN KEY (`stuff_1`) REFERENCES `vstr_stuffs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vstr_scenes_ibfk_5` FOREIGN KEY (`stuff_2`) REFERENCES `vstr_stuffs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vstr_scenes_ibfk_6` FOREIGN KEY (`scene_1`) REFERENCES `vstr_scenes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vstr_scenes_ibfk_7` FOREIGN KEY (`scene_2`) REFERENCES `vstr_scenes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vstr_scenes_ibfk_8` FOREIGN KEY (`stuff_1`) REFERENCES `vstr_stuffs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vstr_scenes_ibfk_9` FOREIGN KEY (`stuff_2`) REFERENCES `vstr_stuffs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `vstr_stuffs`
--
ALTER TABLE `vstr_stuffs`
  ADD CONSTRAINT `vstr_stuffs_ibfk_1` FOREIGN KEY (`scene_1`) REFERENCES `vstr_scenes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vstr_stuffs_ibfk_2` FOREIGN KEY (`scene_2`) REFERENCES `vstr_scenes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vstr_stuffs_ibfk_3` FOREIGN KEY (`stuff_1`) REFERENCES `vstr_stuffs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vstr_stuffs_ibfk_4` FOREIGN KEY (`stuff_2`) REFERENCES `vstr_stuffs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
