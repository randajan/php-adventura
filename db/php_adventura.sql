-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Počítač: localhost
-- Vytvořeno: Úte 30. kvě 2023, 16:40
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
-- Struktura tabulky `characters`
--

CREATE TABLE `vstr_characters` (
  `id` int(8) NOT NULL,
  `user` int(8) NOT NULL,
  `name` varchar(32) NOT NULL,
  `state` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabulky `scenes`
--

CREATE TABLE `vstr_scenes` (
  `id` varchar(16) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabulky `stuffs`
--

CREATE TABLE `vstr_stuffs` (
  `id` varchar(16) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabulky `users`
--

CREATE TABLE `vstr_users` (
  `id` int(8) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `characters`
--
ALTER TABLE `vstr_characters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_characters_user` (`user`);

--
-- Klíče pro tabulku `scenes`
--
ALTER TABLE `vstr_scenes`
  ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `stuffs`
--
ALTER TABLE `vstr_stuffs`
  ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `users`
--
ALTER TABLE `vstr_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `characters`
--
ALTER TABLE `vstr_characters`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pro tabulku `users`
--
ALTER TABLE `vstr_users`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT;

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `characters`
--
ALTER TABLE `vstr_characters`
  ADD CONSTRAINT `fk_characters_user` FOREIGN KEY (`user`) REFERENCES `vstr_users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
