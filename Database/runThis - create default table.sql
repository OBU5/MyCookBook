
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

  INSERT INTO `ingredients` (`name`, `quantity`, `unit`) VALUES
  ('rýže Arborio', '1', 'hrnek'),
  ('Vývar', '3', 'hrnky'),
  ('parmazán', 'podle', ''),
  ('cuketa', '1', ''),
  ('Mouka', '200', 'g'),
  ('Mléko', 'půl', 'litru'),
  ('Vajíčko', 'jedno', ''),
  ('Mouka', '200', 'g'),
  ('Mléko', 'půl', 'litru'),
  ('Vajíčko', 'jedno', ''),
  ('Krupice', '50', 'g'),
  ('Mléko', 'půl', 'litru'),
  ('Krupice', '50', 'g'),
  ('Mléko', 'půl', 'litru'),
  ('Krupice', '50', 'g'),
  ('Mléko', 'půl', 'litru'),
  ('Krupice', '50', 'g'),
  ('Mléko', 'půl', 'litru'),
  ('Máslo', '', 'lžíce'),
  ('Rajčatový protlak', '1', ''),
  ('hladká mouka', '', 'lžíce'),
  ('voda', '0.5', 'litru'),
  ('Máslo', '1', 'lžíce'),
  ('Rajčatový protlak', '1', ''),
  ('hladká mouka', '1', 'lžíce'),
  ('voda', '0.5', 'litru'),
  ('Máslo', '1', 'lžíce'),
  ('Rajčatový protlak', '1', ''),
  ('hladká mouka', '1', 'lžíce'),
  ('voda', '0.5', 'litru'),
  ('Těstoviny', '300', 'g'),
  ('sůl', 'špetka', ''),
  ('česnek', '2', 'stroužky'),
  ('Olivový olej', 'podle', ''),
  ('cherry rajčata', '15', 'kusů'),
  ('rukola', '80', 'g'),
  ('pesto', 'podle', ''),
  ('Těstoviny', '300', 'g'),
  ('sůl', 'špetka', ''),
  ('česnek', '2', 'stroužky'),
  ('Olivový olej', 'podle', ''),
  ('cherry rajčata', '15', 'kusů'),
  ('rukola', '80', 'g'),
  ('pesto', 'podle', ''),
  ('Těstoviny', '300', 'g'),
  ('sůl', 'špetka', ''),
  ('česnek', '2', 'stroužky'),
  ('Olivový olej', 'podle', ''),
  ('cherry rajčata', '15', 'kusů'),
  ('rukola', '80', 'g'),
  ('pesto', 'podle', ''),
  ('Těstoviny', '300', 'g'),
  ('sůl', 'špetka', ''),
  ('česnek', '2', 'stroužky'),
  ('Olivový olej', 'podle', ''),
  ('cherry rajčata', '15', 'kusů'),
  ('rukola', '80', 'g'),
  ('pesto', 'podle', ''),
  ('Mouka  dvojnulka', '200', 'g'),
  ('Mléko', 'půl', 'litr'),
  ('Vajíčko', '1', ''),
  ('sáček se slepičí polívkou', '1', 'kus'),
  ('voda', '250', 'ml'),
  ('sáček se slepičí polívkou', '1', 'kus'),
  ('voda', '250', 'ml'),
  ('sáček se slepičí polívkou', '1', 'kus'),
  ('voda', '250', 'ml');

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
  (1,	'Kouzelné palačinky',	'Vše dobře rozmícháme ponorným mixérem na hladkou hmotu. Postupně smažíme po obou stranách na pánvi. Doporučuji používat speciální pánev na palačinky s nízkým okrajem a nepřilnavým povrchem.',	'2021-01-03',	1,	1,	'Uploads/palacinky.jpg'),
  (2,	'Italské rizoto',	'Vsypeme suchou rýži, mícháme, aby se všechna zrnka obalila tukem a povrch rýže zprůsvitněl. Ihned vlijeme bílé víno, promícháme a necháme vsáknout do rýže a odpařit alkohol, to by mělo zabrat 2 nebo 3 minuty. Začneme po naběračce přilévat vývar, jemně promícháme a necháme na středním výkonu zcela vstřebat do rýže, tento proces opakujeme, dokud není rýže al dente, tedy zhruba 20–30 minut. Jakmile rýže přestane absorbovat vývar a je na skus, odstavíme hrnec a vmícháme parmezán a zbytek másla. Dochutíme solí a pepřem. Servírujeme na ploché nahřáté talíře, posypané strouhaným parmezánem.',	'2021-01-03',	1,	4,	'Uploads/ItalskeRisoto.jpg'),
  (3,	'Ondrovi roštácké palačinky',	'Vše dobře rozmícháme ponorným mixérem na hladkou hmotu. Postupně smažíme po obou stranách na pánvi. Doporučuji používat speciální pánev na palačinky s nízkým okrajem a nepřilnavým povrchem.',	'2021-01-03',	1,	1,	'Uploads/palacinky1.jpg'),
  (4,	'Neobyčejné palačinky',	'Vše dobře rozmícháme ponorným mixérem na hladkou hmotu. Postupně smažíme po obou stranách na pánvi. Doporučuji používat speciální pánev na palačinky s nízkým okrajem a nepřilnavým povrchem.',	'2021-01-03',	1,	1,	'Uploads/palacinky2.jpg'),
  (5,	'Krupicová kaše',	'Do hrnce nalijeme mléko a přivedeme k varu.\r\nPak přidáme sůl, cukr a za stálého míchání přisypeme krupici a 10 - 12 minut vaříme.\r\nPak dáme kaši na mísu, posypeme směsí cukru a skořice nebo grankem a polijeme rozpuštěným máslem.',	'2021-01-03',	1,	2,	'Uploads/krupicKase.jpg'),
  (6,	'Krupicová kaše jako od babičky',	'Do hrnce nalijeme mléko a přivedeme k varu.\r\n\r\nPak přidáme sůl, cukr a za stálého míchání přisypeme krupici a 10 - 12 minut vaříme.\r\n\r\nPak dáme kaši na mísu, posypeme směsí cukru a skořice nebo grankem a polijeme rozpuštěným máslem.',	'2021-01-03',	1,	2,	'Uploads/krupicKase1.jpg'),
  (7,	'Krupic Káša pro hladové',	'Do hrnce nalijeme mléko a přivedeme k varu.\r\nPak přidáme sůl, cukr a za stálého míchání přisypeme krupici a 10 - 12 minut vaříme.\r\nPak dáme kaši na mísu, posypeme směsí cukru a skořice nebo grankem a polijeme rozpuštěným máslem.',	'2021-01-03',	1,	2,	'Uploads/krupicKase2.jpg'),
  (8,	'Krupicová kaše, která neurazí',	'Do hrnce nalijeme mléko a přivedeme k varu.\r\nPak přidáme sůl, cukr a za stálého míchání přisypeme krupici a 10 - 12 minut vaříme.\r\nPak dáme kaši na mísu, posypeme směsí cukru a skořice nebo grankem a polijeme rozpuštěným máslem.',	'2021-01-03',	1,	2,	'Uploads/krupicKase3.jpg'),
  (9,	'Rajská polévka po Vietnamsku',	'V hrnci rozehřejeme máslo, zaprášíme hladkou moukou a připravíme světlou jíšku, kterou za stálého míchání zalijeme vodou. Vmícháme větší rajčatový protlak, osolíme a vaříme 15 minut.\r\n\r\nPolévku přivedeme k varu a vaříme 5 minut. Ochutíme podle potřeby.',	'2021-01-03',	1,	3,	'Uploads/RajskaPolevka.jpg'),
  (10,	'Čertovská polévka',	'V hrnci rozehřejeme máslo, zaprášíme hladkou moukou a připravíme světlou jíšku, kterou za stálého míchání zalijeme vodou. Vmícháme větší rajčatový protlak, osolíme a vaříme 15 minut.\r\n\r\nPolévku přivedeme k varu a vaříme 5 minut. Ochutíme podle potřeby.',	'2021-01-03',	1,	5,	'Uploads/RajskaPolevka2.jpg'),
  (11,	'Rajská polévka pro celou rodinu',	'V hrnci rozehřejeme máslo, zaprášíme hladkou moukou a připravíme světlou jíšku, kterou za stálého míchání zalijeme vodou. Vmícháme větší rajčatový protlak, osolíme a vaříme 15 minut.\r\n\r\nPolévku přivedeme k varu a vaříme 5 minut. Ochutíme podle potřeby.',	'2021-01-03',	1,	2,	'Uploads/RajskaPolevka3.jpg'),
  (12,	'Těstoviny pro hladovou Káju',	'Těstoviny uvařte podle návodu na obalu. \r\nNa pánvi orestujte nadrobno nakrájený česnek, k němu přidejte na kostičky nakrájená cherry rajčata a nechte vše společně dusit.\r\nAž budou rajčata úplně rozvařená, pokrájejte na malé kousky sušená rajčata. Nasypte je do omáčky společně s rukolou a zamíchejte. Dochuťte čerstvě namletým pepřem.',	'2021-01-03',	1,	1,	'Uploads/testoviny.jpg'),
  (13,	'Těstoviny pro nenasytné',	'Těstoviny uvařte podle návodu na obalu. \r\nNa pánvi orestujte nadrobno nakrájený česnek, k němu přidejte na kostičky nakrájená cherry rajčata a nechte vše společně dusit.\r\nAž budou rajčata úplně rozvařená, pokrájejte na malé kousky sušená rajčata. Nasypte je do omáčky společně s rukolou a zamíchejte. Dochuťte čerstvě namletým pepřem.',	'2021-01-03',	1,	6,	'Uploads/testoviny2.jpg'),
  (14,	'Nejlepšáčtější Těstoviny',	'Těstoviny uvařte podle návodu na obalu. \r\nNa pánvi orestujte nadrobno nakrájený česnek, k němu přidejte na kostičky nakrájená cherry rajčata a nechte vše společně dusit.\r\nAž budou rajčata úplně rozvařená, pokrájejte na malé kousky sušená rajčata. Nasypte je do omáčky společně s rukolou a zamíchejte. Dochuťte čerstvě namletým pepřem.',	'2021-01-03',	1,	2,	'Uploads/testoviny3.jpg'),
  (15,	'Těstoviny na rychlo',	'Těstoviny uvařte podle návodu na obalu. \r\nNa pánvi orestujte nadrobno nakrájený česnek, k němu přidejte na kostičky nakrájená cherry rajčata a nechte vše společně dusit.\r\nAž budou rajčata úplně rozvařená, pokrájejte na malé kousky sušená rajčata. Nasypte je do omáčky společně s rukolou a zamíchejte. Dochuťte čerstvě namletým pepřem.',	'2021-01-03',	1,	4,	'Uploads/testoviny4.jpg'),
  (16,	'Slepičák z pytlíku 1',	'Sáček vysypeme do hrnku, zalejeme vodou a 5 minut mícháme.',	'2021-01-04',	1,	2,	'Uploads/pytlik.jpg'),
  (17,	'Slepičák z pytlíku 2',	'Sáček vysypeme do hrnku, zalejeme vodou a 5 minut mícháme.\r\n\r\npak je hotovo',	'2021-01-04',	1,	2,	'Uploads/pytlik1.jpg'),
  (18,	'gulášovka z pytle',	'Sáček vysypeme do hrnku, zalejeme vodou a 5 minut mícháme.',	'2021-01-04',	1,	2,	'Uploads/pytlik2.jpg');

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

  INSERT INTO `recipe_ingredients` (`recipe_id`, `ingredient_id`) VALUES
  ( 1,  1),
  ( 1,  2),
  ( 1,  3),
  ( 1,  4),
  ( 2,  5),
  ( 2,  6),
  ( 2,  7),
  ( 3,  8),
  ( 3,  9),
  ( 3,  10),
  ( 4,  11),
  ( 4,  12),
  ( 5,  13),
  ( 5,  14),
  ( 6,  15),
  ( 6,  16),
  ( 7,  17),
  ( 7,  18),
  ( 8,  19),
  ( 8,  20),
  ( 8,  21),
  ( 8,  22),
  ( 9,  23),
  ( 9,  24),
  ( 9,  25),
  ( 9,  26),
  ( 10, 27),
  ( 10, 28),
  ( 10, 29),
  ( 10, 30),
  ( 11, 31),
  ( 11, 32),
  ( 11, 33),
  ( 11, 34),
  ( 11, 35),
  ( 11, 36),
  ( 11, 37),
  ( 12, 38),
  ( 12, 39),
  ( 12, 40),
  ( 12, 41),
  ( 12, 42),
  ( 12, 43),
  ( 12, 44),
  ( 13, 45),
  ( 13, 46),
  ( 13, 47),
  ( 13, 48),
  ( 13, 49),
  ( 13, 50),
  ( 13, 51),
  ( 14, 52),
  ( 14, 53),
  ( 14, 54),
  ( 14, 55),
  ( 14, 56),
  ( 14, 57),
  ( 14, 58),
  ( 15, 59),
  ( 15, 60),
  ( 15, 61),
  ( 16, 62),
  ( 16, 63),
  ( 17, 64),
  ( 17, 65),
  ( 18, 66),
  ( 18, 67);

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

  INSERT INTO `recipe_mealcategory` ( `mealCategory_id`, `recipe_id`) VALUES
  (3, 1),
  (4, 2),
  (5, 2),
  (4, 3),
  (5, 3),
  (4, 4),
  (5, 4),
  (1, 5),
  (4, 5),
  (5, 5),
  (1, 6),
  (4, 6),
  (5, 6),
  (1, 7),
  (4, 7),
  (5, 7),
  (2, 8),
  (2, 9),
  (2, 10),
  (3, 11),
  (3, 12),
  (3, 13),
  (3, 14),
  (1, 15),
  (4, 15),
  (5, 15),
  (2, 16),
  (2, 17),
  (2, 18);

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

  INSERT INTO `users` (`name`, `lastname`, `email`, `username`, `password`, `role`) VALUES
  INSERT INTO `users` (`name`, `lastname`, `email`, `username`, `password`, `role`) VALUES
  ('Ondřej',	  'Bures',	    'bures.ondrej95@gmail.com',	'OBU5',	'$2y$10$0iLL8Kcdh43bSoKrYKT.l.LT1h963eD1zxDvEcxA3Wznfqrx1eAWG',	        'Admin'),
  ('Karoína',	'Štrbová',	    'karolina101@outlook.cz',	'Koťulka101',	'$2y$10$/Z/GjSQOoW78nfw7UMwJbOHII2Ffsd972GMlW.rgtGiguNsTRCzKm',	  'Regular user'),
  ('Pepa',	    'Zdepa',	    'pepa@zwajede.cz',	        'Pepik1',	'$2y$10$Yi8uqF3w6S.ZQTJqoS4qWeidcSFDnmnTFfqcfmP0n/hXzID8SLq3m',	    'Regular user'),
  ('Pepa',	    'Zdepa',	    'pepa@zwajede.cz',	        'Pepik2',	'$2y$10$5ZSNcvtppM0XkzsPovAoauZ62mBaj46wVyJ0f18ebkZdxlFmKIoF.',	    'Regular user'),
  ('Pepa',	    'Zdepa',	    'pepa@zwajede.cz',	        'Pepik3',	'$2y$10$eTl2NL/TwIYvGfs4swxtJ.he5pzIX9WNSy7a9WndI9R2zUdKpBHMC',	    'Regular user'),
  ('Pepa',	    'Zdepa',	    'pepa@zwajede.cz',	        'Pepik4',	'$2y$10$Wd8NieebXQBObGwApW3AFuu7niSnnKjumJHNABjd93pqqwiZ1D5BW',	    'Regular user'),
  ('Pepa',	    'Zdepa',	    'pepa@zwajede.cz',	        'Pepik5',	'$2y$10$cC5EKet64jfmP8f/VLna5.84/sbQr5GHjQkkB7G2lA.HQfDyzSgFC',	    'Regular user'),
  ('Pepa',	    'Zdepa',	    'pepa@zwajede.cz',	        'Pepik6',	'$2y$10$0SoEyggGPxDBTWbqkc70cejJnLPCyJybnLTZpU2DQn6YFpZ5lC9NK',	    'Regular user'),
  ('Pepa',	    'Zdepa',	    'pepa@zwajede.cz',	        'Pepik7',	'$2y$10$EohicBicZxltmFUiOceZduFUEwvqWzBBBvIR6ZNb/fC3a2ghgx/Le',	    'Regular user'),
  ('Pepa',	    'Zdepa',	    'pepa@zwajede.cz',	        'Pepik8',	'$2y$10$6COiZt7SEYPXW6UBbbmH0OKX7kEoGqjProi/9ObQyh/TZC5TXAnYC',	    'Regular user'),
  ('Admin',	  'Admin',	    'admin@zwajede.cz',	          'admin',	'$2y$10$1d84n3QXAZOjfjWr0YLPTu4g1BgCP5aO9gEOA7tnYGDCDiAaTYwDO',	    'Admin');

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
