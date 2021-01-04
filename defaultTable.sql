
DROP TABLE IF EXISTS Recipe_Ingredients;
DROP TABLE IF EXISTS Ingredients;
DROP TABLE IF EXISTS OriginCountry;
DROP TABLE IF EXISTS Recipe_MealCategory;
DROP TABLE IF EXISTS MealCategory;
DROP TABLE IF EXISTS Recipes;
DROP TABLE IF EXISTS Users;


-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 04, 2021 at 11:23 AM
-- Server version: 10.4.16-MariaDB
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `ingredients`
--

CREATE TABLE `ingredients` (
  `ID` int(11) NOT NULL,
  `name` varchar(40) COLLATE utf8_bin NOT NULL,
  `quantity` varchar(40) COLLATE utf8_bin NOT NULL,
  `unit` varchar(40) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `ingredients`
--

INSERT INTO `ingredients` (`ID`, `name`, `quantity`, `unit`) VALUES
(101, 'rýže Arborio', '1', 'hrnek'),
(102, 'Vývar', '3', 'hrnky'),
(103, 'parmazán', 'podle', ''),
(104, 'cuketa', '1', ''),
(105, 'Mouka', '200', 'g'),
(106, 'Mléko', 'půl', 'litru'),
(107, 'Vajíčko', 'jedno', ''),
(108, 'Mouka', '200', 'g'),
(109, 'Mléko', 'půl', 'litru'),
(110, 'Vajíčko', 'jedno', ''),
(111, 'Krupice', '50', 'g'),
(112, 'Mléko', 'půl', 'litru'),
(115, 'Krupice', '50', 'g'),
(116, 'Mléko', 'půl', 'litru'),
(117, 'Krupice', '50', 'g'),
(118, 'Mléko', 'půl', 'litru'),
(119, 'Krupice', '50', 'g'),
(120, 'Mléko', 'půl', 'litru'),
(121, 'Máslo', '', 'lžíce'),
(122, 'Rajčatový protlak', '1', ''),
(123, 'hladká mouka', '', 'lžíce'),
(124, 'voda', '0.5', 'litru'),
(125, 'Máslo', '1', 'lžíce'),
(126, 'Rajčatový protlak', '1', ''),
(127, 'hladká mouka', '1', 'lžíce'),
(128, 'voda', '0.5', 'litru'),
(129, 'Máslo', '1', 'lžíce'),
(130, 'Rajčatový protlak', '1', ''),
(131, 'hladká mouka', '1', 'lžíce'),
(132, 'voda', '0.5', 'litru'),
(133, 'Těstoviny', '300', 'g'),
(134, 'sůl', 'špetka', ''),
(135, 'česnek', '2', 'stroužky'),
(136, 'Olivový olej', 'podle', ''),
(137, 'cherry rajčata', '15', 'kusů'),
(138, 'rukola', '80', 'g'),
(139, 'pesto', 'podle', ''),
(140, 'Těstoviny', '300', 'g'),
(141, 'sůl', 'špetka', ''),
(142, 'česnek', '2', 'stroužky'),
(143, 'Olivový olej', 'podle', ''),
(144, 'cherry rajčata', '15', 'kusů'),
(145, 'rukola', '80', 'g'),
(146, 'pesto', 'podle', ''),
(147, 'Těstoviny', '300', 'g'),
(148, 'sůl', 'špetka', ''),
(149, 'česnek', '2', 'stroužky'),
(150, 'Olivový olej', 'podle', ''),
(151, 'cherry rajčata', '15', 'kusů'),
(152, 'rukola', '80', 'g'),
(153, 'pesto', 'podle', ''),
(154, 'Těstoviny', '300', 'g'),
(155, 'sůl', 'špetka', ''),
(156, 'česnek', '2', 'stroužky'),
(157, 'Olivový olej', 'podle', ''),
(158, 'cherry rajčata', '15', 'kusů'),
(159, 'rukola', '80', 'g'),
(160, 'pesto', 'podle', ''),
(167, 'Mouka  dvojnulka', '200', 'g'),
(168, 'Mléko', 'půl', 'litr'),
(169, 'Vajíčko', '1', ''),
(175, 'sáček se slepičí polívkou', '1', 'kus'),
(176, 'voda', '250', 'ml'),
(177, 'sáček se slepičí polívkou', '1', 'kus'),
(178, 'voda', '250', 'ml'),
(191, 'sáček se slepičí polívkou', '1', 'kus'),
(192, 'voda', '250', 'ml');

-- --------------------------------------------------------

--
-- Table structure for table `mealcategory`
--

CREATE TABLE `mealcategory` (
  `ID` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `mealcategory`
--

INSERT INTO `mealcategory` (`ID`, `name`) VALUES
(1, 'Předkrm'),
(2, 'Polévka'),
(3, 'Hlavní chod'),
(4, 'Dezert'),
(5, 'Svačina');

-- --------------------------------------------------------

--
-- Table structure for table `origincountry`
--

CREATE TABLE `origincountry` (
  `ID` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `origincountry`
--

INSERT INTO `origincountry` (`ID`, `name`) VALUES
(1, 'Nenznámá'),
(2, 'Česko'),
(3, 'Vietnam'),
(4, 'Itálie'),
(5, 'Maďarsko'),
(6, 'Španělsko');

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

CREATE TABLE `recipes` (
  `ID` int(11) NOT NULL,
  `name` varchar(40) COLLATE utf8_bin NOT NULL,
  `directions` varchar(1000) COLLATE utf8_bin NOT NULL,
  `date` date NOT NULL,
  `author_id` int(11) DEFAULT NULL,
  `originCountry_id` int(11) DEFAULT NULL,
  `imgUrl` varchar(1000) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `recipes`
--

INSERT INTO `recipes` (`ID`, `name`, `directions`, `date`, `author_id`, `originCountry_id`, `imgUrl`) VALUES
(1, 'Kouzelné palačinky', 'Vše dobře rozmícháme ponorným mixérem na hladkou hmotu. Postupně smažíme po obou stranách na pánvi. Doporučuji používat speciální pánev na palačinky s nízkým okrajem a nepřilnavým povrchem.', '2021-01-03', 1, 1, 'http://localhost/MyCookBook/Uploads/palacinky.jpg'),
(2, 'Italské rizoto', 'Vsypeme suchou rýži, mícháme, aby se všechna zrnka obalila tukem a povrch rýže zprůsvitněl. Ihned vlijeme bílé víno, promícháme a necháme vsáknout do rýže a odpařit alkohol, to by mělo zabrat 2 nebo 3 minuty. Začneme po naběračce přilévat vývar, jemně promícháme a necháme na středním výkonu zcela vstřebat do rýže, tento proces opakujeme, dokud není rýže al dente, tedy zhruba 20–30 minut. Jakmile rýže přestane absorbovat vývar a je na skus, odstavíme hrnec a vmícháme parmezán a zbytek másla. Dochutíme solí a pepřem. Servírujeme na ploché nahřáté talíře, posypané strouhaným parmezánem.', '2021-01-03', 1, 4, 'http://localhost/MyCookBook/Uploads/ItalskeRisoto.jpg'),
(3, 'Ondrovi roštácké palačinky', 'Vše dobře rozmícháme ponorným mixérem na hladkou hmotu. Postupně smažíme po obou stranách na pánvi. Doporučuji používat speciální pánev na palačinky s nízkým okrajem a nepřilnavým povrchem.', '2021-01-03', 1, 1, 'http://localhost/MyCookBook/Uploads/palacinky1.jpg'),
(4, 'Neobyčejné palačinky', 'Vše dobře rozmícháme ponorným mixérem na hladkou hmotu. Postupně smažíme po obou stranách na pánvi. Doporučuji používat speciální pánev na palačinky s nízkým okrajem a nepřilnavým povrchem.', '2021-01-03', 1, 1, 'http://localhost/MyCookBook/Uploads/palacinky2.jpg'),
(5, 'Krupicová kaše', 'Do hrnce nalijeme mléko a přivedeme k varu.\r\nPak přidáme sůl, cukr a za stálého míchání přisypeme krupici a 10 - 12 minut vaříme.\r\nPak dáme kaši na mísu, posypeme směsí cukru a skořice nebo grankem a polijeme rozpuštěným máslem.', '2021-01-03', 1, 2, 'http://localhost/MyCookBook/Uploads/krupicKase.jpg'),
(6, 'Krupicová kaše jako od babičky', 'Do hrnce nalijeme mléko a přivedeme k varu.\\r\\nPak přidáme sůl, cukr a za stálého míchání přisypeme krupici a 10 - 12 minut vaříme.\\r\\nPak dáme kaši na mísu, posypeme směsí cukru a skořice nebo grankem a polijeme rozpuštěným máslem.', '2021-01-03', 1, 2, 'http://localhost/MyCookBook/Uploads/krupicKase1.jpg'),
(7, 'Krupic Káša pro hladové', 'Do hrnce nalijeme mléko a přivedeme k varu.\r\nPak přidáme sůl, cukr a za stálého míchání přisypeme krupici a 10 - 12 minut vaříme.\r\nPak dáme kaši na mísu, posypeme směsí cukru a skořice nebo grankem a polijeme rozpuštěným máslem.', '2021-01-03', 1, 2, 'http://localhost/MyCookBook/Uploads/krupicKase2.jpg'),
(8, 'Krupicová kaše, která neurazí', 'Do hrnce nalijeme mléko a přivedeme k varu.\r\nPak přidáme sůl, cukr a za stálého míchání přisypeme krupici a 10 - 12 minut vaříme.\r\nPak dáme kaši na mísu, posypeme směsí cukru a skořice nebo grankem a polijeme rozpuštěným máslem.', '2021-01-03', 1, 2, 'http://localhost/MyCookBook/Uploads/krupicKase3.jpg'),
(9, 'Rajská polévka po Vietnamsku', 'V hrnci rozehřejeme máslo, zaprášíme hladkou moukou a připravíme světlou jíšku, kterou za stálého míchání zalijeme vodou. Vmícháme větší rajčatový protlak, osolíme a vaříme 15 minut.\r\n\r\nPolévku přivedeme k varu a vaříme 5 minut. Ochutíme podle potřeby.', '2021-01-03', 1, 3, 'http://localhost/MyCookBook/Uploads/RajskaPolevka.jpg'),
(10, 'Čertovská polévka', 'V hrnci rozehřejeme máslo, zaprášíme hladkou moukou a připravíme světlou jíšku, kterou za stálého míchání zalijeme vodou. Vmícháme větší rajčatový protlak, osolíme a vaříme 15 minut.\r\n\r\nPolévku přivedeme k varu a vaříme 5 minut. Ochutíme podle potřeby.', '2021-01-03', 1, 5, 'http://localhost/MyCookBook/Uploads/RajskaPolevka2.jpg'),
(11, 'Rajská polévka pro celou rodinu', 'V hrnci rozehřejeme máslo, zaprášíme hladkou moukou a připravíme světlou jíšku, kterou za stálého míchání zalijeme vodou. Vmícháme větší rajčatový protlak, osolíme a vaříme 15 minut.\r\n\r\nPolévku přivedeme k varu a vaříme 5 minut. Ochutíme podle potřeby.', '2021-01-03', 1, 2, 'http://localhost/MyCookBook/Uploads/RajskaPolevka3.jpg'),
(12, 'Těstoviny pro hladovou Káju', 'Těstoviny uvařte podle návodu na obalu. \r\nNa pánvi orestujte nadrobno nakrájený česnek, k němu přidejte na kostičky nakrájená cherry rajčata a nechte vše společně dusit.\r\nAž budou rajčata úplně rozvařená, pokrájejte na malé kousky sušená rajčata. Nasypte je do omáčky společně s rukolou a zamíchejte. Dochuťte čerstvě namletým pepřem.', '2021-01-03', 1, 1, 'http://localhost/MyCookBook/Uploads/testoviny.jpg'),
(13, 'Těstoviny pro nenasytné', 'Těstoviny uvařte podle návodu na obalu. \r\nNa pánvi orestujte nadrobno nakrájený česnek, k němu přidejte na kostičky nakrájená cherry rajčata a nechte vše společně dusit.\r\nAž budou rajčata úplně rozvařená, pokrájejte na malé kousky sušená rajčata. Nasypte je do omáčky společně s rukolou a zamíchejte. Dochuťte čerstvě namletým pepřem.', '2021-01-03', 1, 6, 'http://localhost/MyCookBook/Uploads/testoviny2.jpg'),
(14, 'Nejlepšáčtější Těstoviny', 'Těstoviny uvařte podle návodu na obalu. \r\nNa pánvi orestujte nadrobno nakrájený česnek, k němu přidejte na kostičky nakrájená cherry rajčata a nechte vše společně dusit.\r\nAž budou rajčata úplně rozvařená, pokrájejte na malé kousky sušená rajčata. Nasypte je do omáčky společně s rukolou a zamíchejte. Dochuťte čerstvě namletým pepřem.', '2021-01-03', 1, 2, 'http://localhost/MyCookBook/Uploads/testoviny3.jpg'),
(15, 'Těstoviny na rychlo', 'Těstoviny uvařte podle návodu na obalu. \r\nNa pánvi orestujte nadrobno nakrájený česnek, k němu přidejte na kostičky nakrájená cherry rajčata a nechte vše společně dusit.\r\nAž budou rajčata úplně rozvařená, pokrájejte na malé kousky sušená rajčata. Nasypte je do omáčky společně s rukolou a zamíchejte. Dochuťte čerstvě namletým pepřem.', '2021-01-03', 1, 4, 'http://localhost/MyCookBook/Uploads/testoviny4.jpg'),
(21, 'Slepičák z pytlíku 1', 'Sáček vysypeme do hrnku, zalejeme vodou a 5 minut mícháme.', '2021-01-04', 1, 2, 'http://localhost/MyCookBook/Uploads/pytlik.jpg'),
(22, 'Slepičák z pytlíku 2', 'Sáček vysypeme do hrnku, zalejeme vodou a 5 minut mícháme.', '2021-01-04', 1, 2, 'http://localhost/MyCookBook/Uploads/pytlik1.jpg'),
(23, 'gulášovka z pytle', 'Sáček vysypeme do hrnku, zalejeme vodou a 5 minut mícháme.', '2021-01-04', 1, 2, 'http://localhost/MyCookBook/Uploads/pytlik2.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `recipe_ingredients`
--

CREATE TABLE `recipe_ingredients` (
  `ID` int(11) NOT NULL,
  `recipe_id` int(11) NOT NULL,
  `ingredient_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `recipe_ingredients`
--

INSERT INTO `recipe_ingredients` (`ID`, `recipe_id`, `ingredient_id`) VALUES
(101, 2, 101),
(102, 2, 102),
(103, 2, 103),
(104, 2, 104),
(105, 3, 105),
(106, 3, 106),
(107, 3, 107),
(108, 4, 108),
(109, 4, 109),
(110, 4, 110),
(111, 5, 111),
(112, 5, 112),
(115, 6, 115),
(116, 6, 116),
(117, 7, 117),
(118, 7, 118),
(119, 8, 119),
(120, 8, 120),
(121, 9, 121),
(122, 9, 122),
(123, 9, 123),
(124, 9, 124),
(125, 10, 125),
(126, 10, 126),
(127, 10, 127),
(128, 10, 128),
(129, 11, 129),
(130, 11, 130),
(131, 11, 131),
(132, 11, 132),
(133, 12, 133),
(134, 12, 134),
(135, 12, 135),
(136, 12, 136),
(137, 12, 137),
(138, 12, 138),
(139, 12, 139),
(140, 13, 140),
(141, 13, 141),
(142, 13, 142),
(143, 13, 143),
(144, 13, 144),
(145, 13, 145),
(146, 13, 146),
(147, 14, 147),
(148, 14, 148),
(149, 14, 149),
(150, 14, 150),
(151, 14, 151),
(152, 14, 152),
(153, 14, 153),
(154, 15, 154),
(155, 15, 155),
(156, 15, 156),
(157, 15, 157),
(158, 15, 158),
(159, 15, 159),
(160, 15, 160),
(167, 1, 167),
(168, 1, 168),
(169, 1, 169),
(175, 22, 175),
(176, 22, 176),
(177, 23, 177),
(178, 23, 178),
(191, 21, 191),
(192, 21, 192);

-- --------------------------------------------------------

--
-- Table structure for table `recipe_mealcategory`
--

CREATE TABLE `recipe_mealcategory` (
  `ID` int(11) NOT NULL,
  `mealCategory_id` int(11) NOT NULL,
  `recipe_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `recipe_mealcategory`
--

INSERT INTO `recipe_mealcategory` (`ID`, `mealCategory_id`, `recipe_id`) VALUES
(58, 3, 2),
(59, 4, 3),
(60, 5, 3),
(61, 4, 4),
(62, 5, 4),
(63, 4, 5),
(64, 5, 5),
(67, 1, 6),
(68, 4, 6),
(69, 5, 6),
(70, 1, 7),
(71, 4, 7),
(72, 5, 7),
(73, 1, 8),
(74, 4, 8),
(75, 5, 8),
(76, 2, 9),
(77, 2, 10),
(78, 2, 11),
(79, 3, 12),
(80, 3, 13),
(81, 3, 14),
(82, 3, 15),
(86, 1, 1),
(87, 4, 1),
(88, 5, 1),
(93, 2, 22),
(94, 2, 23),
(101, 2, 21);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `name` varchar(40) COLLATE utf8_bin NOT NULL,
  `lastname` varchar(40) COLLATE utf8_bin DEFAULT NULL,
  `email` varchar(40) COLLATE utf8_bin DEFAULT NULL,
  `username` varchar(40) COLLATE utf8_bin DEFAULT NULL,
  `password` varchar(100) COLLATE utf8_bin NOT NULL,
  `role` varchar(40) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `name`, `lastname`, `email`, `username`, `password`, `role`) VALUES
(1, 'Ondřej', 'Bures', 'bures.ondrej95@gmail.com', 'OBU5', '$2y$10$KaSSpWp9o5PK6i7ce1AfsefQvZZCJfeY8djuBLn6F00RlZzzIAb/6', 'Regular user'),
(2, 'Karoína', 'Štrbová', 'karolina101@outlook.cz', 'Koťulka101', '$2y$10$OBJWSb3l1F84zR66kIgoYeo2MqbnQcaJvnL.gX83It/UiP.YuUj5i', 'Regular user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ingredients`
--
ALTER TABLE `ingredients`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `mealcategory`
--
ALTER TABLE `mealcategory`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `origincountry`
--
ALTER TABLE `origincountry`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `author_id` (`author_id`);

--
-- Indexes for table `recipe_ingredients`
--
ALTER TABLE `recipe_ingredients`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `recipe_id` (`recipe_id`),
  ADD KEY `ingredient_id` (`ingredient_id`);

--
-- Indexes for table `recipe_mealcategory`
--
ALTER TABLE `recipe_mealcategory`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `mealCategory_id` (`mealCategory_id`),
  ADD KEY `recipe_id` (`recipe_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ingredients`
--
ALTER TABLE `ingredients`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=194;

--
-- AUTO_INCREMENT for table `mealcategory`
--
ALTER TABLE `mealcategory`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `origincountry`
--
ALTER TABLE `origincountry`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `recipes`
--
ALTER TABLE `recipes`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `recipe_ingredients`
--
ALTER TABLE `recipe_ingredients`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=194;

--
-- AUTO_INCREMENT for table `recipe_mealcategory`
--
ALTER TABLE `recipe_mealcategory`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `recipes`
--
ALTER TABLE `recipes`
  ADD CONSTRAINT `recipes_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `users` (`ID`);

--
-- Constraints for table `recipe_ingredients`
--
ALTER TABLE `recipe_ingredients`
  ADD CONSTRAINT `recipe_ingredients_ibfk_1` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`ID`),
  ADD CONSTRAINT `recipe_ingredients_ibfk_2` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredients` (`ID`);

--
-- Constraints for table `recipe_mealcategory`
--
ALTER TABLE `recipe_mealcategory`
  ADD CONSTRAINT `recipe_mealcategory_ibfk_1` FOREIGN KEY (`mealCategory_id`) REFERENCES `mealcategory` (`ID`),
  ADD CONSTRAINT `recipe_mealcategory_ibfk_2` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
