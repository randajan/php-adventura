-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Počítač: localhost
-- Vytvořeno: Úte 30. kvě 2023, 22:33
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
  `state` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabulky `vstr_scenes`
--

CREATE TABLE `vstr_scenes` (
  `id` varchar(16) NOT NULL,
  `title` varchar(32) NOT NULL,
  `description` text NOT NULL,
  `is_start` int(1) NOT NULL,
  `is_end` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `vstr_scenes`
--

INSERT INTO `vstr_scenes` (`id`, `title`, `description`, `is_start`, `is_end`) VALUES
('bathroom', 'Koupelna', 'Po odemčení a vstoupení do koupelny se svítílnou, nacházíš pachatele zločinu.\r\nHra byla úspěšně dokončena.\r\n', 0, 1),
('building', 'Budova', 'Právě si vstoupil do budovy.\r\nPřed temnou místností vlevo leží [kabelka](?stuff=handbag).\r\n', 0, 0),
('office', 'Kancelář Vyšetřovatele', 'Právě se nacházíš ve své kanceláři plných polic se spisy a knihami.\r\nPřišel [dopis](?stuff=letter) s informacemi o zločinu, který se stal v parku nedalekého města.\r\nMusíš otevřít dopis a vyšetřit to.', 1, 0),
('park', 'Temný park', 'Nacházíš se v temném parku, kde s největší pravděpodobností se zločin začal odehrávat. Na zemi u lavičky \r\nleží rozbitý [mobil](?stuff=phone) s kapkami krve. Dále vedle mobilu leží černá [maska](?stuff=mask).\r\nMobil pečlivě prohlédni, jestli v něm nezůstali nějaké důležité zprávy, které by ti mohli pomoci ve\r\nvyštřování.', 0, 0);

-- --------------------------------------------------------

--
-- Struktura tabulky `vstr_stuffs`
--

CREATE TABLE `vstr_stuffs` (
  `id` varchar(16) NOT NULL,
  `title` varchar(32) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `vstr_stuffs`
--

INSERT INTO `vstr_stuffs` (`id`, `title`, `description`) VALUES
('handbag', 'Kabelka', 'Uvnitř kabelky se nachází [svítilna](?stuff=light), žvýkačky, zrcátko a klíče.\r\n'),
('letter', 'Dopis', '[V parku](?scene=park) byla přepadena žena, která utrpěla lehká zranění, když ji\r\nzločinec vytrhl kabelku z ruky. Pachatel neznámý. Je potřeba aby to bylo prošetřeno.'),
('light', 'Svítilna', 'Na svítilně jsou připnuty klíče od [koupelny](?scene=bathroom).'),
('mask', 'Maska', 'Černá maska pachatele.'),
('phone', 'Mobil', 'SMS Zpráva\r\nVem všechny věci a setkáme se v [budově](?scene=building) vedle parku. Místnost 2.');

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
  ADD KEY `fk_characters_user` (`user`);

--
-- Klíče pro tabulku `vstr_scenes`
--
ALTER TABLE `vstr_scenes`
  ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `vstr_stuffs`
--
ALTER TABLE `vstr_stuffs`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pro tabulku `vstr_users`
--
ALTER TABLE `vstr_users`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `vstr_characters`
--
ALTER TABLE `vstr_characters`
  ADD CONSTRAINT `fk_characters_user` FOREIGN KEY (`user`) REFERENCES `vstr_users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
