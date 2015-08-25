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

--
-- A tábla adatainak kiíratása `szavazas`
--

INSERT INTO `szavazas` (`id`, `cim`, `hely`, `leiras`, `nev`, `letrehozo_emailcim`, `beallitasok`, `inditas_datum`) VALUES
(1, 'alright', '', '', 'BÃ¡lint', 'felado@gmail.com', NULL, '0000-00-00 00:00:00'),
(2, '', '', '', '', '', NULL, '0000-00-00 00:00:00'),
(3, '', '', '', '', '', NULL, '0000-00-00 00:00:00'),
(4, '', '', '', '', '', NULL, '0000-00-00 00:00:00'),
(5, '', '', '', '', '', NULL, '0000-00-00 00:00:00'),
(6, '', '', '', '', '', NULL, '0000-00-00 00:00:00'),
(7, '', '', '', '', '', NULL, '0000-00-00 00:00:00'),
(8, '', 'ppppp', '', '', '.mk@.mo', NULL, '0000-00-00 00:00:00'),
(9, '', 'ppppp', '', '', '.mk@.mo', NULL, '0000-00-00 00:00:00'),
(10, 'Valami új', '', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'Harmath Bálint', 'allright773vgmail.com', NULL, '0000-00-00 00:00:00'),
(11, 'Aszta!', '', 'iiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiii', 'Mi ez?', '', NULL, '0000-00-00 00:00:00'),
(12, 'sdasd', '', '', 'asdasd', '', NULL, '0000-00-00 00:00:00'),
(13, 'Valami új', '', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'Harmath Bálint', 'allright773vgmail.com', NULL, '0000-00-00 00:00:00'),
(14, 'Valami új', '', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'pasioefjp oj', 'allright773vgmail.com', NULL, '0000-00-00 00:00:00'),
(15, 'Valami új', '', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'pasioefjp oj', 'allright773vgmail.com', NULL, '0000-00-00 00:00:00'),
(16, 'almafa', 'Lesz megye', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'Istalan István', 'almafa12', NULL, '0000-00-00 00:00:00'),
(17, 'almafa', 'Lesz megye', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'Istalan István', 'almafa12', NULL, '0000-00-00 00:00:00'),
(18, 'almafa', 'Lesz megye', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'Istalan István', 'almafa12', NULL, '0000-00-00 00:00:00'),
(19, 'tutrtu', '', '', 'ttiz bhmb', 'hj}.ko', NULL, '0000-00-00 00:00:00'),
(20, 'Al Karabi', 'Al.gieraõpek', '', 'Leheet', 'asmdp@gmail.fe', NULL, '0000-00-00 00:00:00'),
(21, 'sdasd', '', '', 'asdasd', 'almaf@gmaIL.COM', NULL, '0000-00-00 00:00:00'),
(22, 'asodmp', '', '', 'pssodmfõp', 'psokedjfõp', NULL, '0000-00-00 00:00:00'),
(23, 'psõdompo', '', '', 'põsdgkjõá', 'õsodkgpgõopk', NULL, '0000-00-00 00:00:00'),
(24, 'Most ez egy beállás ell.', '', '', 'HBalint', 'al@gmso.gi', NULL, '0000-00-00 00:00:00'),
(25, 'spoefk', '', '', 'õswgrkõ', 'aprkg@epr.hi', NULL, '0000-00-00 00:00:00'),
(26, 'spoefk', '', '', 'õswgrkõ', 'aprkg@epr.hi', NULL, '0000-00-00 00:00:00'),
(27, 'Nézzük az integerjét!', '', '', 'Hopp!', 'amg@bmfl.hu', NULL, '0000-00-00 00:00:00'),
(28, 'Újra fetch assoc miatt', '', '', 'Már jó kell legyen', 'ak@gko.hu', NULL, '0000-00-00 00:00:00'),
(29, 'wproj', '', '', 'sprogjõprogj', 'ewporgj@gu.hu', NULL, '0000-00-00 00:00:00'),
(30, 'lj', '', '', 'kljhkljh', 'ugkou@hip.hu', NULL, '0000-00-00 00:00:00'),
(31, 'pdiofjb', '', '', 'seõrgjk', 'sddghi@eur.hu', NULL, '0000-00-00 00:00:00'),
(32, 'kugiu', '', '', 'kugkiug', 'oiugfiu@zrd.zs', NULL, '0000-00-00 00:00:00'),
(33, 'Bálint', 'Párizsi parkban', '', 'Harmath', 'email@gmail.com', NULL, '0000-00-00 00:00:00'),
(34, 'Jelentkezz aktivistának', 'Hol,', 'Ott!', 'Bálint', 'amidvan@hozddel.hu', NULL, '0000-00-00 00:00:00'),
(35, 'Jelentkezz aktivistának', 'Hol,', 'Ott!', 'Bálint', 'amidvan@hozddel.hu', NULL, '0000-00-00 00:00:00'),
(36, 'paaidsj', 'Biatorbágy', 'Elmennénk gyáratlátogatni veletek! ', 'Huawei', 'gmail@bedoakos.com', NULL, '0000-00-00 00:00:00'),
(37, 'Huawei', 'Japán, Tokyo', 'Kérlek válassz egy idõpontot!', 'George', 'mail@jovokepp.hu', NULL, '0000-00-00 00:00:00'),
(38, 'Huawei', 'BiatorbÃ¡gy', '', 'GyÃ¶rkkel', 'gmail.voidmail.hu', NULL, '0000-00-00 00:00:00'),
(39, 'Huawei', 'BiatorbÃ¡gy', '', 'GyÃ¶rkkel', 'gmail.voidmail.hu', NULL, '0000-00-00 00:00:00'),
(40, 'József nádor tér-i kávézó', 'József Nádor tér 3.', 'Mi lenne, ha meginnánk egy kávét, és megbeszélnénk a dolgokat??', 'Bálint', 'gmail.versenypalyazat@gmail.vi', NULL, '0000-00-00 00:00:00'),
(41, 'József nádor tér-i kávézó', 'József Nádor tér 3.', 'Mi lenne, ha meginnánk egy kávét, és megbeszélnénk a dolgokat??', 'Bálint', 'gmail.versenypalyazat@gmail.vi', NULL, '0000-00-00 00:00:00'),
(42, 'József nádor tér-i kávézó', 'József Nádor tér 3.', 'Mi lenne, ha meginnánk egy kávét, és megbeszélnénk a dolgokat??', 'Bálint', 'gmail.versenypalyazat@gmail.vi', NULL, '0000-00-00 00:00:00'),
(43, 'József nádor tér-i kávézó', 'József Nádor tér 3.', 'Mi lenne, ha meginnánk egy kávét, és megbeszélnénk a dolgokat??', 'Bálint', 'gmail.versenypalyazat@gmail.vi', NULL, '0000-00-00 00:00:00'),
(44, 'iut', '', '', 'kugfjzu', 'kzufkf@fgmdi.ghu', NULL, '0000-00-00 00:00:00'),
(45, 'iut', '', '', 'kugfjzu', 'kzufkf@fgmdi.ghu', NULL, '0000-00-00 00:00:00'),
(46, 'Juhé', 'Miskolc', 'Zsonglõrködés lesz itt', 'Pástor Árpád', 'hgmisd@micklsv.gu', NULL, '0000-00-00 00:00:00'),
(47, 'pwiorjgt', 'JUKKKEE', 'Svéd üdülõfaluba szeretnénk elutazni', 'JUUKKEE', 'hmihaly@gmail.com', NULL, '0000-00-00 00:00:00'),
(48, 'Nomégegyszernekiveselkedünkegy', 'Hugonnai Vilmos utca', 'Kell egy robogó', 'Kell e', 'hugionnaiv@gmail.lcom', NULL, '0000-00-00 00:00:00'),
(49, 'Sikerülni kell', 'Lake Wood', 'Menjetek', 'Jót halászni ', 'gmial.co', NULL, '0000-00-00 00:00:00'),
(50, 'Sikerülni kell', 'Lake Wood', 'Menjetek', 'Jót halászni ', 'gmial.com', NULL, '0000-00-00 00:00:00'),
(51, 'õsoek', 'õewrpkõw', '', 'õwekõwekp', 'fdgjo@gkõpw.hu', NULL, '0000-00-00 00:00:00'),
(52, 'õsoek', 'õewrpkõw', '', 'õwekõwekp', 'fdgjo@gkõpw.hu', NULL, '0000-00-00 00:00:00'),
(53, 'õsoek', 'õewrpkõw', '', 'õwekõwekp', 'fdgjo@gkõpw.hu', NULL, '0000-00-00 00:00:00'),
(54, 'pkjp', 'oiug', 'izggi', 'izgfi', 'gmial@gjpodr.uh', NULL, '0000-00-00 00:00:00'),
(55, 'oij', 'oihjöoõõ', 'oikoinen haamasullka', 'ühuj', 'haana@gmail.gu', NULL, '0000-00-00 00:00:00'),
(56, 'oikoinnen haasuui', 'Kuullkastaati', 'Deroogul Jörgen keelkki maakelkianente vainenhaasu mikainenhoosi', 'Maikineen Matti', 'ijgur@gurgiati.fi', NULL, '0000-00-00 00:00:00'),
(57, 'MIt csinálsz pénteken', 'HP', 'Gyere el istentiszteletre, mert jó', 'Harmath Bálint', 'gmail.com@gmail.com', NULL, '0000-00-00 00:00:00'),
(58, 'WESTCOAST RALLY', 'California', 'GO AND RALLY WITH US', 'Noname0', 'rally.wc@gmail.com', NULL, '0000-00-00 00:00:00'),
(59, 'NA mégegyszer...', 'Hill of the Train', 'aõpojkõõõ', 'Harmath Bálint', 'hillofthet@gmail.com', NULL, '0000-00-00 00:00:00'),
(60, 'woier', 'pwoiejpwoej', 'õpojkgú', 'wpoejõpeoj', 'õojkww@gkõpw.vo', NULL, '0000-00-00 00:00:00'),
(61, 'Mipõaeff', 'pwoiejpwoej', 'õpojkgú', 'wpoejõpeoj', 'aposjd.hu', NULL, '0000-00-00 00:00:00'),
(62, 'Mipõaeff', 'pwoiejpwoej', 'õpojkgú', 'wpoejõpeoj', 'aposjd.hu', NULL, '0000-00-00 00:00:00'),
(63, 'Harmath bálibrc', 'powkjweff', 'pokwef', 'põaekof', 'powkegf@glaei.if', NULL, '0000-00-00 00:00:00'),
(64, 'Bálint elsõ igazi tesztje :)', '', '', 'Harmath B', 'allright773@gmail.com', NULL, '0000-00-00 00:00:00');

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
