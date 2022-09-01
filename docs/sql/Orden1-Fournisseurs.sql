-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Sep 01, 2022 at 12:14 AM
-- Server version: 5.6.39
-- PHP Version: 8.0.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_cardil`
--

-- --------------------------------------------------------

--
-- Table structure for table `Fournisseurs`
--

CREATE TABLE `Fournisseurs` (
  `Id` int(11) NOT NULL,
  `NomCommercial` varchar(60) NOT NULL,
  `RaisonSociale` varchar(60) NOT NULL,
  `Adresse1` varchar(120) NOT NULL,
  `Adresse2` varchar(120) DEFAULT NULL,
  `CodePostale` varchar(6) NOT NULL,
  `Ville` varchar(60) NOT NULL,
  `Pays_Id` int(11) NOT NULL,
  `Tel` varchar(15) DEFAULT NULL,
  `Fax` varchar(15) DEFAULT NULL,
  `Email` varchar(120) NOT NULL,
  `SIRET` varchar(20) DEFAULT NULL,
  `TVAIntraComm` varchar(30) NOT NULL,
  `TVA` double NOT NULL DEFAULT '0',
  `Etat` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Fournisseurs`
--

INSERT INTO `Fournisseurs` (`Id`, `NomCommercial`, `RaisonSociale`, `Adresse1`, `Adresse2`, `CodePostale`, `Ville`, `Pays_Id`, `Tel`, `Fax`, `Email`, `SIRET`, `TVAIntraComm`, `TVA`, `Etat`) VALUES
(1, 'AutoDiscount', 'PromoGroup S.p.A', 'Via A.Ressi 17', '', '', 'Milan', 3, '+39.02.509944.9', '', 'cc_english@autodiscount.it', '', '', 21, 1),
(2, 'Excellent Car Rent', 'Excellent Car Retailers', 'A12 - Boomsesteenweg 934', '', '02610', 'Antwerp (Wilrijk)', 2, '+32 3 870 76 71', '+32 3 870 76 70', 'dirk@ecrent.be', 'BE-473 718 801 ', 'BE1234567891213', 0, 1),
(4, 'Alphicars', 'Alphicars SPRL', '20, rue de l\'industrie', '', '7080', 'LA BOUVERIE', 2, '0032.65.43.00.3', '', '', '', 'BE 0896 362 647', 21, 1),
(5, 'IMEXSO', 'IMEXSO', 'ChaussÃ©e de Mons (coin Zuiderstraat 1)', '', '1502', 'Lembeek', 2, '32 (2) 365 08 2', '32 (2) 365 08 2', 'info@imexso.com', '', '', 0, 1),
(6, 'Citroen Verhelst', 'Citroen Verhelst', '', '', '', 'Tielt', 2, '', '', '', '', '', 21, 1),
(8, 'Peugeot Coussement', '', '', '', '', '', 2, '', '', '', '', '', 0, 1),
(9, 'ALD LUX SA', 'ALD LUX SA', '30, rue des Scilas', '', '2529', 'HOWALD', 5, '0607323252', '', '', 'B68629', 'LU17830437', 15, 1),
(10, 'AUTODROM', 'AUTODROM', '', '', '', '', 1, '', '', '', '', '', 0, 1),
(11, 'Interlease', 'Interlease s.a.', 'Antwerpsesteenweg, 124 ', '', 'B-2630', 'Aartselaar', 2, '+32.3.877.20.55', '+32.3.877.38.84', 'info@interlease.be', '', '', 0, 1),
(12, 'Carconnex', 'Carconnex', 'Grijpenlaan 19', '', '3300', 'Tienen', 2, '+32-495-573047', '+32-16 30 93 91', 'contact@carconnex.be', '', 'BE 0860.353.277', 0, 1),
(13, 'Cardoen', 'Datos nv', '950 Boomsesteenweg', '', '2610', 'Anvers', 2, '+32 3 870 75 43', '+32 3 870 75 44', 'info@cardoen.be', '', '', 0, 1),
(14, 'DK Belgium', 'DK Belgium', '', '', '1480', 'Tubize', 2, '', '', '', '', '', 0, 1),
(15, 'IDEAL IMPORT-EXPORT', 'IDEAL IMPORT-EXPORT SAS', '5, rue de l\'Oberlach', 'Zone Artisanale', '68520', 'BURNHAUPT LE BAS', 1, '03.89.52.66.66', '03.89.52.83.29', 'virginie@idealimport.fr', '403305022', 'FR31403305022', 0, 1),
(16, 'Peugeot Weiland', 'Peugeot Weiland', '', '', '', '', 6, '', '', '', '', '', 19, 1),
(17, 'Citroen OLOT', 'Citroen OLOT', '', '', '', 'Olot', 4, '', '', '', '', '', 0, 1),
(18, 'Citroen Alava LASCARAY', 'Citroen Alava LASCARAY', '', '', '', 'Vitoria', 4, '', '', '', '', '', 0, 1),
(19, 'Nawrot', 'Nawrot', '', '', '', '', 2, '', '', '', '', '', 0, 1),
(20, 'Renault Guitard', 'NEGOCE EUROPE', '', '', '', '', 4, '', '', '', '', '', 0, 1),
(21, 'LOGISTIQUE SERVICE (PEUGEOT)', 'LOGISTIQUE SERVICE', '36 rue des PoncÃ©es ', '', '88200 ', 'Saint Etienne les Remiremont', 6, '03 29 22 15 34', '', 'log.servmarie@orange.fr', '439 519 745 ', 'FR 29 439 519 745 ', 0, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Fournisseurs`
--
ALTER TABLE `Fournisseurs`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Fournisseurs`
--
ALTER TABLE `Fournisseurs`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
