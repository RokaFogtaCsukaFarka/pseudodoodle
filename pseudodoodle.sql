-- phpMyAdmin SQL Dump
-- version 4.0.3
-- http://www.phpmyadmin.net
--
-- Hoszt: 127.0.0.1
-- Létrehozás ideje: 2013. Okt 22. 17:30
-- Szerver verzió: 5.6.11-log
-- PHP verzió: 5.5.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Adatbázis: `pseudo_doodle`
--
CREATE DATABASE IF NOT EXISTS `pseudo_doodle` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `pseudo_doodle`;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `sz_idopont`
--

CREATE TABLE IF NOT EXISTS `sz_idopont` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `szavazas_id` int(11) NOT NULL COMMENT 'connection \\w table szavazasok: id',
  `idopont_d` date NOT NULL,
  `idopont_t` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `szavazas`
--

CREATE TABLE IF NOT EXISTS `szavazas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cim` varchar(30) CHARACTER SET utf16 COLLATE utf16_hungarian_ci NOT NULL,
  `hely` varchar(30) CHARACTER SET utf16 COLLATE utf16_hungarian_ci NOT NULL,
  `leiras` varchar(256) CHARACTER SET utf16 COLLATE utf16_hungarian_ci NOT NULL,
  `nev` varchar(30) CHARACTER SET utf16 COLLATE utf16_hungarian_ci NOT NULL,
  `letrehozo_emailcim` varchar(30) NOT NULL,
  `beallitasok` tinyint(4) DEFAULT NULL COMMENT 'binárisan kódolt értékek',
  `inditas_datum` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=65 ;


-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `szavazo`
--

CREATE TABLE IF NOT EXISTS `szavazo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nev` varchar(30) CHARACTER SET utf16 COLLATE utf16_hungarian_ci NOT NULL,
  `szavazo_emailcim` varchar(30) NOT NULL,
  `szavazas_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `valasztott_idopont`
--

CREATE TABLE IF NOT EXISTS `valasztott_idopont` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `szavazo_id` int(11) NOT NULL,
  `idopont_d` date NOT NULL,
  `idopont_t` time NOT NULL,
  `szavazas_id` int(1) NOT NULL,
  `idopont_id` int(11) NOT NULL,
  `valasztott` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
