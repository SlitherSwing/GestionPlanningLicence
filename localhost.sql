-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 12, 2026 at 01:31 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `article`
--
CREATE DATABASE IF NOT EXISTS `article` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `article`;

-- --------------------------------------------------------

--
-- Table structure for table `Articles`
--

CREATE TABLE `Articles` (
  `id` int(3) NOT NULL,
  `titre` varchar(30) NOT NULL,
  `contenuArticle` varchar(300) NOT NULL,
  `categorie` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `Articles`
--

INSERT INTO `Articles` (`id`, `titre`, `contenuArticle`, `categorie`) VALUES
(3, 'Couteau', 'Un beau couteau ', 'Cuisine'),
(4, 'MacBook', 'Ceci est un ordinateur', 'Informatique'),
(5, 'Nike', 'Popopo téma les nikes', 'Sport'),
(6, 'Adidas', 'Abanon c pa de nikes', 'Sport'),
(7, 'test', 'Ouille ouille ouille', 'Informatique'),
(8, 'Basket', 'Elles sont moches', 'Sport');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Articles`
--
ALTER TABLE `Articles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `id_2` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Articles`
--
ALTER TABLE `Articles`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- Database: `BASE DE DONNEE CONTROLE`
--
CREATE DATABASE IF NOT EXISTS `BASE DE DONNEE CONTROLE` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `BASE DE DONNEE CONTROLE`;

-- --------------------------------------------------------

--
-- Table structure for table `CLASSE`
--

CREATE TABLE `CLASSE` (
  `NumClasse` int(11) NOT NULL,
  `LibelleClasse` varchar(20) NOT NULL,
  `EffectifClasse` tinyint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `CLASSE`
--

INSERT INTO `CLASSE` (`NumClasse`, `LibelleClasse`, `EffectifClasse`) VALUES
(1, 'Seconde 1', 25),
(2, 'Seconde 2 ', 27),
(3, 'Seconde 3', 30),
(4, 'Seconde 4', 33);

-- --------------------------------------------------------

--
-- Table structure for table `ELEVE`
--

CREATE TABLE `ELEVE` (
  `NumEleve` int(11) NOT NULL,
  `NomEleve` varchar(40) NOT NULL,
  `PrenomEleve` varchar(40) NOT NULL,
  `NumClasse` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ELEVE`
--

INSERT INTO `ELEVE` (`NumEleve`, `NomEleve`, `PrenomEleve`, `NumClasse`) VALUES
(1, 'Idasiak', 'Mikael', 2),
(2, 'Ammar', 'Fethi', 2),
(3, 'Daniel', 'Gaël', 3),
(4, 'Kintzler', 'Agnès', 4);

-- --------------------------------------------------------

--
-- Table structure for table `MEDICAMENT`
--

CREATE TABLE `MEDICAMENT` (
  `NumMedic` int(11) NOT NULL,
  `NomMedic` varchar(80) NOT NULL,
  `DoseMedic` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `MEDICAMENT`
--

INSERT INTO `MEDICAMENT` (`NumMedic`, `NomMedic`, `DoseMedic`) VALUES
(1, 'Doliprane 500', '500'),
(2, 'Doliprane 1000', '1000'),
(3, 'Spasfon', '500'),
(4, 'Advil Caps', '400');

-- --------------------------------------------------------

--
-- Table structure for table `niveau`
--

CREATE TABLE `niveau` (
  `Num_niveau` int(2) NOT NULL,
  `Libelle_niveau` varchar(15) DEFAULT NULL,
  `Effectif_classe` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `VISITE`
--

CREATE TABLE `VISITE` (
  `numVisite` int(11) NOT NULL,
  `numEleve` int(11) DEFAULT NULL,
  `motifVisite` varchar(50) DEFAULT NULL,
  `numMedic` int(11) DEFAULT NULL,
  `quantiteMedic` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `VISITE`
--

INSERT INTO `VISITE` (`numVisite`, `numEleve`, `motifVisite`, `numMedic`, `quantiteMedic`) VALUES
(1, 2, 'Mal de tête', 1, 2),
(2, 4, 'Mal de tête', 2, 1),
(3, 1, 'Mal de tête', 1, 2),
(4, 1, 'Maux de ventre', 3, 2),
(5, 1, 'Bras cassé', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `CLASSE`
--
ALTER TABLE `CLASSE`
  ADD PRIMARY KEY (`NumClasse`);

--
-- Indexes for table `ELEVE`
--
ALTER TABLE `ELEVE`
  ADD PRIMARY KEY (`NumEleve`),
  ADD KEY `fk_numClasse` (`NumClasse`);

--
-- Indexes for table `MEDICAMENT`
--
ALTER TABLE `MEDICAMENT`
  ADD PRIMARY KEY (`NumMedic`);

--
-- Indexes for table `niveau`
--
ALTER TABLE `niveau`
  ADD PRIMARY KEY (`Num_niveau`);

--
-- Indexes for table `VISITE`
--
ALTER TABLE `VISITE`
  ADD PRIMARY KEY (`numVisite`),
  ADD KEY `fk_numEleve_vis` (`numEleve`),
  ADD KEY `fk_numMedic_vis` (`numMedic`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `niveau`
--
ALTER TABLE `niveau`
  MODIFY `Num_niveau` int(2) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `VISITE`
--
ALTER TABLE `VISITE`
  MODIFY `numVisite` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ELEVE`
--
ALTER TABLE `ELEVE`
  ADD CONSTRAINT `fk_numClasse` FOREIGN KEY (`NumClasse`) REFERENCES `CLASSE` (`NumClasse`);

--
-- Constraints for table `VISITE`
--
ALTER TABLE `VISITE`
  ADD CONSTRAINT `fk_numEleve_vis` FOREIGN KEY (`numEleve`) REFERENCES `ELEVE` (`NumEleve`),
  ADD CONSTRAINT `fk_numMedic_vis` FOREIGN KEY (`numMedic`) REFERENCES `MEDICAMENT` (`NumMedic`);
--
-- Database: `Gestion Licence`
--
CREATE DATABASE IF NOT EXISTS `Gestion Licence` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `Gestion Licence`;

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `id` int(11) NOT NULL,
  `start_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `end_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `intervention_type_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `remotely` tinyint(1) NOT NULL,
  `title` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `course_instructor`
--

CREATE TABLE `course_instructor` (
  `course_id` int(11) NOT NULL,
  `instructor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `instructor`
--

CREATE TABLE `instructor` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `instructor_module`
--

CREATE TABLE `instructor_module` (
  `instructor_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `intervention_type`
--

CREATE TABLE `intervention_type` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `color` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

CREATE TABLE `module` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `hours_count` int(11) NOT NULL,
  `capstone_project` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `role` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id`),
  ADD KEY `module_id` (`module_id`),
  ADD KEY `intervention_type_id` (`intervention_type_id`);

--
-- Indexes for table `course_instructor`
--
ALTER TABLE `course_instructor`
  ADD PRIMARY KEY (`course_id`,`instructor_id`),
  ADD KEY `instructor_id` (`instructor_id`);

--
-- Indexes for table `instructor`
--
ALTER TABLE `instructor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `instructor_module`
--
ALTER TABLE `instructor_module`
  ADD PRIMARY KEY (`instructor_id`,`module_id`),
  ADD KEY `module_id` (`module_id`);

--
-- Indexes for table `intervention_type`
--
ALTER TABLE `intervention_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_module_parent` (`parent_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `instructor`
--
ALTER TABLE `instructor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `intervention_type`
--
ALTER TABLE `intervention_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `module`
--
ALTER TABLE `module`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `course`
--
ALTER TABLE `course`
  ADD CONSTRAINT `course_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `module` (`id`),
  ADD CONSTRAINT `course_ibfk_2` FOREIGN KEY (`intervention_type_id`) REFERENCES `intervention_type` (`id`);

--
-- Constraints for table `course_instructor`
--
ALTER TABLE `course_instructor`
  ADD CONSTRAINT `course_instructor_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`),
  ADD CONSTRAINT `course_instructor_ibfk_2` FOREIGN KEY (`instructor_id`) REFERENCES `instructor` (`id`);

--
-- Constraints for table `instructor`
--
ALTER TABLE `instructor`
  ADD CONSTRAINT `instructor_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `instructor_module`
--
ALTER TABLE `instructor_module`
  ADD CONSTRAINT `instructor_module_ibfk_1` FOREIGN KEY (`instructor_id`) REFERENCES `instructor` (`id`),
  ADD CONSTRAINT `instructor_module_ibfk_2` FOREIGN KEY (`module_id`) REFERENCES `module` (`id`);

--
-- Constraints for table `module`
--
ALTER TABLE `module`
  ADD CONSTRAINT `fk_module_parent` FOREIGN KEY (`parent_id`) REFERENCES `module` (`id`) ON DELETE SET NULL;
--
-- Database: `gestion_commandes_10122018`
--
CREATE DATABASE IF NOT EXISTS `gestion_commandes_10122018` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `gestion_commandes_10122018`;

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `Num_cli` int(11) NOT NULL,
  `Nom_cli` varchar(50) NOT NULL,
  `Localite_cli` varchar(500) NOT NULL,
  `compte_cli` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`Num_cli`, `Nom_cli`, `Localite_cli`, `compte_cli`) VALUES
(1, 'IDASIAK', 'SENLIS', 500),
(2, 'AMMAR', 'PARIS', 2000),
(3, 'DANIEL', 'PONTPOINT', -500),
(4, 'KINTZLER', 'LILLE', 1500),
(5, 'JULLIEN', 'APREMONT', 1000);

-- --------------------------------------------------------

--
-- Table structure for table `commande`
--

CREATE TABLE `commande` (
  `Num_com` int(11) NOT NULL,
  `Num_cli` int(11) NOT NULL,
  `Date_com` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `commande`
--

INSERT INTO `commande` (`Num_com`, `Num_cli`, `Date_com`) VALUES
(1, 1, '01/01/2018'),
(2, 1, '02/01/2018'),
(3, 1, '03/01/2018'),
(4, 2, '04/01/2018'),
(5, 3, '06/01/2018');

-- --------------------------------------------------------

--
-- Table structure for table `detail`
--

CREATE TABLE `detail` (
  `Num_com` int(11) NOT NULL,
  `Num_pro` int(11) NOT NULL,
  `Qte_pro` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `detail`
--

INSERT INTO `detail` (`Num_com`, `Num_pro`, `Qte_pro`) VALUES
(1, 1, 1),
(1, 5, 5),
(1, 6, 4),
(1, 7, 10),
(1, 9, 2),
(2, 2, 1),
(3, 3, 1),
(4, 2, 1),
(4, 9, 10),
(5, 1, 10);

-- --------------------------------------------------------

--
-- Table structure for table `produit`
--

CREATE TABLE `produit` (
  `Num_pro` int(11) NOT NULL,
  `Libelle_pro` varchar(500) NOT NULL,
  `prix_pro` float NOT NULL,
  `qstock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `produit`
--

INSERT INTO `produit` (`Num_pro`, `Libelle_pro`, `prix_pro`, `qstock`) VALUES
(1, 'SAPIN VERT', 50, 1),
(2, 'SAPIN BLANC', 55, 5),
(3, 'SAPIN PERSONNALISE', 100, 2),
(4, 'Guirlande bleue', 10, 3),
(5, 'guirlande jaune', 15, 100),
(6, 'boule bleue', 5, 10),
(7, 'boule jaune', 7, 3),
(8, 'boule blanche', 4, 10),
(9, 'boule verte', 8, 100),
(10, 'boule noire', 1, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`Num_cli`);

--
-- Indexes for table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`Num_com`),
  ADD KEY `Num_cli` (`Num_cli`);

--
-- Indexes for table `detail`
--
ALTER TABLE `detail`
  ADD PRIMARY KEY (`Num_com`,`Num_pro`),
  ADD KEY `FK_detail2` (`Num_pro`);

--
-- Indexes for table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`Num_pro`),
  ADD UNIQUE KEY `Libelle_pro` (`Libelle_pro`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `Num_cli` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `commande`
--
ALTER TABLE `commande`
  MODIFY `Num_com` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `produit`
--
ALTER TABLE `produit`
  MODIFY `Num_pro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `FK_com_cli` FOREIGN KEY (`Num_cli`) REFERENCES `client` (`Num_cli`);

--
-- Constraints for table `detail`
--
ALTER TABLE `detail`
  ADD CONSTRAINT `FK_detail1` FOREIGN KEY (`Num_com`) REFERENCES `commande` (`Num_com`),
  ADD CONSTRAINT `FK_detail2` FOREIGN KEY (`Num_pro`) REFERENCES `produit` (`Num_pro`);
--
-- Database: `gestion_commandes_17122018`
--
CREATE DATABASE IF NOT EXISTS `gestion_commandes_17122018` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `gestion_commandes_17122018`;

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `Num_cli` int(11) NOT NULL,
  `Nom_cli` varchar(50) NOT NULL,
  `Localite_cli` varchar(500) NOT NULL,
  `dept_cli` int(11) NOT NULL,
  `compte_cli` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`Num_cli`, `Nom_cli`, `Localite_cli`, `dept_cli`, `compte_cli`) VALUES
(1, 'IDASIAK', 'SENLIS', 60, 500),
(2, 'AMMAR', 'MEAUX', 75, 500),
(3, 'DANIEL', 'MARSEILLE', 60, -500),
(4, 'KINTZLER', 'LILLE', 59, 1500),
(5, 'JULLIEN', 'APREMONT', 60, 1000),
(6, 'REVELLO', 'TOULOUSE', 31, 10000);

-- --------------------------------------------------------

--
-- Table structure for table `commande`
--

CREATE TABLE `commande` (
  `Num_com` int(11) NOT NULL,
  `Num_cli` int(11) DEFAULT NULL,
  `Date_com` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `commande`
--

INSERT INTO `commande` (`Num_com`, `Num_cli`, `Date_com`) VALUES
(1, 1, '01/01/2018'),
(2, 1, '02/01/2018'),
(3, 1, '03/01/2018'),
(4, 2, '04/01/2018'),
(5, 3, '06/01/2018'),
(6, 6, '22/01/2021');

-- --------------------------------------------------------

--
-- Table structure for table `detail`
--

CREATE TABLE `detail` (
  `Num_com` int(11) NOT NULL,
  `Num_pro` int(11) NOT NULL,
  `Qte_pro` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `detail`
--

INSERT INTO `detail` (`Num_com`, `Num_pro`, `Qte_pro`) VALUES
(1, 1, 1),
(1, 5, 5),
(1, 6, 4),
(1, 7, 10),
(1, 9, 2),
(2, 2, 1),
(3, 3, 1),
(4, 2, 1),
(4, 9, 10),
(5, 1, 10);

-- --------------------------------------------------------

--
-- Table structure for table `produit`
--

CREATE TABLE `produit` (
  `Num_pro` int(11) NOT NULL,
  `Libelle_pro` varchar(500) NOT NULL,
  `prix_pro` float NOT NULL,
  `Qte_stock_pro` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `produit`
--

INSERT INTO `produit` (`Num_pro`, `Libelle_pro`, `prix_pro`, `Qte_stock_pro`) VALUES
(1, 'SAPIN VERT', 50, 50),
(2, 'SAPIN BLANC', 55, 10),
(3, 'SAPIN PERSONNALISE', 100, 10),
(4, 'Guirlande bleue', 10, 5),
(5, 'guirlande jaune', 15, 150),
(6, 'boule bleue', 5, 200),
(7, 'boule jaune', 7, 300),
(9, 'boule verte', 8, 50),
(15, 'test2', 10, 100);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`Num_cli`);

--
-- Indexes for table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`Num_com`),
  ADD KEY `Num_cli` (`Num_cli`);

--
-- Indexes for table `detail`
--
ALTER TABLE `detail`
  ADD PRIMARY KEY (`Num_com`,`Num_pro`),
  ADD KEY `FK_detail2` (`Num_pro`);

--
-- Indexes for table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`Num_pro`),
  ADD UNIQUE KEY `Libelle_pro` (`Libelle_pro`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `Num_cli` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `commande`
--
ALTER TABLE `commande`
  MODIFY `Num_com` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `produit`
--
ALTER TABLE `produit`
  MODIFY `Num_pro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `FK_comcli` FOREIGN KEY (`Num_cli`) REFERENCES `client` (`Num_cli`);

--
-- Constraints for table `detail`
--
ALTER TABLE `detail`
  ADD CONSTRAINT `FK_detail1` FOREIGN KEY (`Num_com`) REFERENCES `commande` (`Num_com`),
  ADD CONSTRAINT `FK_detail2` FOREIGN KEY (`Num_pro`) REFERENCES `produit` (`Num_pro`);
--
-- Database: `phpmyadmin`
--
CREATE DATABASE IF NOT EXISTS `phpmyadmin` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `phpmyadmin`;

-- --------------------------------------------------------

--
-- Table structure for table `pma__bookmark`
--

CREATE TABLE `pma__bookmark` (
  `id` int(11) NOT NULL,
  `dbase` varchar(255) NOT NULL DEFAULT '',
  `user` varchar(255) NOT NULL DEFAULT '',
  `label` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `query` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Bookmarks';

-- --------------------------------------------------------

--
-- Table structure for table `pma__central_columns`
--

CREATE TABLE `pma__central_columns` (
  `db_name` varchar(64) NOT NULL,
  `col_name` varchar(64) NOT NULL,
  `col_type` varchar(64) NOT NULL,
  `col_length` text DEFAULT NULL,
  `col_collation` varchar(64) NOT NULL,
  `col_isNull` tinyint(1) NOT NULL,
  `col_extra` varchar(255) DEFAULT '',
  `col_default` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Central list of columns';

-- --------------------------------------------------------

--
-- Table structure for table `pma__column_info`
--

CREATE TABLE `pma__column_info` (
  `id` int(5) UNSIGNED NOT NULL,
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `column_name` varchar(64) NOT NULL DEFAULT '',
  `comment` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `mimetype` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `transformation` varchar(255) NOT NULL DEFAULT '',
  `transformation_options` varchar(255) NOT NULL DEFAULT '',
  `input_transformation` varchar(255) NOT NULL DEFAULT '',
  `input_transformation_options` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Column information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__designer_settings`
--

CREATE TABLE `pma__designer_settings` (
  `username` varchar(64) NOT NULL,
  `settings_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Settings related to Designer';

--
-- Dumping data for table `pma__designer_settings`
--

INSERT INTO `pma__designer_settings` (`username`, `settings_data`) VALUES
('root', '{\"angular_direct\":\"direct\",\"snap_to_grid\":\"off\",\"relation_lines\":\"true\"}');

-- --------------------------------------------------------

--
-- Table structure for table `pma__export_templates`
--

CREATE TABLE `pma__export_templates` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL,
  `export_type` varchar(10) NOT NULL,
  `template_name` varchar(64) NOT NULL,
  `template_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved export templates';

-- --------------------------------------------------------

--
-- Table structure for table `pma__favorite`
--

CREATE TABLE `pma__favorite` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Favorite tables';

-- --------------------------------------------------------

--
-- Table structure for table `pma__history`
--

CREATE TABLE `pma__history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db` varchar(64) NOT NULL DEFAULT '',
  `table` varchar(64) NOT NULL DEFAULT '',
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp(),
  `sqlquery` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='SQL history for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__navigationhiding`
--

CREATE TABLE `pma__navigationhiding` (
  `username` varchar(64) NOT NULL,
  `item_name` varchar(64) NOT NULL,
  `item_type` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Hidden items of navigation tree';

-- --------------------------------------------------------

--
-- Table structure for table `pma__pdf_pages`
--

CREATE TABLE `pma__pdf_pages` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `page_nr` int(10) UNSIGNED NOT NULL,
  `page_descr` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='PDF relation pages for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__recent`
--

CREATE TABLE `pma__recent` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Recently accessed tables';

--
-- Dumping data for table `pma__recent`
--

INSERT INTO `pma__recent` (`username`, `tables`) VALUES
('root', '[{\"db\":\"Gestion Licence\",\"table\":\"course\"},{\"db\":\"users\",\"table\":\"utilisateurs\"},{\"db\":\"Gestion Licence\",\"table\":\"user\"},{\"db\":\"gestion_commandes_10122018\",\"table\":\"produit\"},{\"db\":\"gestion_commandes_10122018\",\"table\":\"client\"},{\"db\":\"Gestion Licence\",\"table\":\"module\"},{\"db\":\"Gestion Licence\",\"table\":\"instructor_module\"},{\"db\":\"Gestion Licence\",\"table\":\"course_instructor\"},{\"db\":\"Gestion Licence\",\"table\":\"instructor\"},{\"db\":\"Gestion Licence\",\"table\":\"intervention_type\"}]');

-- --------------------------------------------------------

--
-- Table structure for table `pma__relation`
--

CREATE TABLE `pma__relation` (
  `master_db` varchar(64) NOT NULL DEFAULT '',
  `master_table` varchar(64) NOT NULL DEFAULT '',
  `master_field` varchar(64) NOT NULL DEFAULT '',
  `foreign_db` varchar(64) NOT NULL DEFAULT '',
  `foreign_table` varchar(64) NOT NULL DEFAULT '',
  `foreign_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Relation table';

-- --------------------------------------------------------

--
-- Table structure for table `pma__savedsearches`
--

CREATE TABLE `pma__savedsearches` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `search_name` varchar(64) NOT NULL DEFAULT '',
  `search_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved searches';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_coords`
--

CREATE TABLE `pma__table_coords` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `pdf_page_number` int(11) NOT NULL DEFAULT 0,
  `x` float UNSIGNED NOT NULL DEFAULT 0,
  `y` float UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table coordinates for phpMyAdmin PDF output';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_info`
--

CREATE TABLE `pma__table_info` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `display_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table information for phpMyAdmin';

--
-- Dumping data for table `pma__table_info`
--

INSERT INTO `pma__table_info` (`db_name`, `table_name`, `display_field`) VALUES
('BASE DE DONNEE CONTROLE', 'ELEVE', 'NumClasse');

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_uiprefs`
--

CREATE TABLE `pma__table_uiprefs` (
  `username` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `prefs` text NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tables'' UI preferences';

-- --------------------------------------------------------

--
-- Table structure for table `pma__tracking`
--

CREATE TABLE `pma__tracking` (
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `version` int(10) UNSIGNED NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `schema_snapshot` text NOT NULL,
  `schema_sql` text DEFAULT NULL,
  `data_sql` longtext DEFAULT NULL,
  `tracking` set('UPDATE','REPLACE','INSERT','DELETE','TRUNCATE','CREATE DATABASE','ALTER DATABASE','DROP DATABASE','CREATE TABLE','ALTER TABLE','RENAME TABLE','DROP TABLE','CREATE INDEX','DROP INDEX','CREATE VIEW','ALTER VIEW','DROP VIEW') DEFAULT NULL,
  `tracking_active` int(1) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Database changes tracking for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__userconfig`
--

CREATE TABLE `pma__userconfig` (
  `username` varchar(64) NOT NULL,
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `config_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User preferences storage for phpMyAdmin';

--
-- Dumping data for table `pma__userconfig`
--

INSERT INTO `pma__userconfig` (`username`, `timevalue`, `config_data`) VALUES
('root', '2026-03-11 14:12:50', '{\"Console\\/Mode\":\"collapse\",\"NavigationWidth\":280}');

-- --------------------------------------------------------

--
-- Table structure for table `pma__usergroups`
--

CREATE TABLE `pma__usergroups` (
  `usergroup` varchar(64) NOT NULL,
  `tab` varchar(64) NOT NULL,
  `allowed` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User groups with configured menu items';

-- --------------------------------------------------------

--
-- Table structure for table `pma__users`
--

CREATE TABLE `pma__users` (
  `username` varchar(64) NOT NULL,
  `usergroup` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Users and their assignments to user groups';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pma__central_columns`
--
ALTER TABLE `pma__central_columns`
  ADD PRIMARY KEY (`db_name`,`col_name`);

--
-- Indexes for table `pma__column_info`
--
ALTER TABLE `pma__column_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `db_name` (`db_name`,`table_name`,`column_name`);

--
-- Indexes for table `pma__designer_settings`
--
ALTER TABLE `pma__designer_settings`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_user_type_template` (`username`,`export_type`,`template_name`);

--
-- Indexes for table `pma__favorite`
--
ALTER TABLE `pma__favorite`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__history`
--
ALTER TABLE `pma__history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`,`db`,`table`,`timevalue`);

--
-- Indexes for table `pma__navigationhiding`
--
ALTER TABLE `pma__navigationhiding`
  ADD PRIMARY KEY (`username`,`item_name`,`item_type`,`db_name`,`table_name`);

--
-- Indexes for table `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  ADD PRIMARY KEY (`page_nr`),
  ADD KEY `db_name` (`db_name`);

--
-- Indexes for table `pma__recent`
--
ALTER TABLE `pma__recent`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__relation`
--
ALTER TABLE `pma__relation`
  ADD PRIMARY KEY (`master_db`,`master_table`,`master_field`),
  ADD KEY `foreign_field` (`foreign_db`,`foreign_table`);

--
-- Indexes for table `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_savedsearches_username_dbname` (`username`,`db_name`,`search_name`);

--
-- Indexes for table `pma__table_coords`
--
ALTER TABLE `pma__table_coords`
  ADD PRIMARY KEY (`db_name`,`table_name`,`pdf_page_number`);

--
-- Indexes for table `pma__table_info`
--
ALTER TABLE `pma__table_info`
  ADD PRIMARY KEY (`db_name`,`table_name`);

--
-- Indexes for table `pma__table_uiprefs`
--
ALTER TABLE `pma__table_uiprefs`
  ADD PRIMARY KEY (`username`,`db_name`,`table_name`);

--
-- Indexes for table `pma__tracking`
--
ALTER TABLE `pma__tracking`
  ADD PRIMARY KEY (`db_name`,`table_name`,`version`);

--
-- Indexes for table `pma__userconfig`
--
ALTER TABLE `pma__userconfig`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__usergroups`
--
ALTER TABLE `pma__usergroups`
  ADD PRIMARY KEY (`usergroup`,`tab`,`allowed`);

--
-- Indexes for table `pma__users`
--
ALTER TABLE `pma__users`
  ADD PRIMARY KEY (`username`,`usergroup`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__column_info`
--
ALTER TABLE `pma__column_info`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__history`
--
ALTER TABLE `pma__history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  MODIFY `page_nr` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Database: `test`
--
CREATE DATABASE IF NOT EXISTS `test` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `test`;

-- --------------------------------------------------------

--
-- Table structure for table `MEDICAMENT`
--

CREATE TABLE `MEDICAMENT` (
  `NumMedic` int(11) NOT NULL,
  `NomMedic` varchar(255) NOT NULL,
  `DoseMedic` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
--
-- Database: `users`
--
CREATE DATABASE IF NOT EXISTS `users` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `users`;

-- --------------------------------------------------------

--
-- Table structure for table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `first_name`, `last_name`, `username`, `password`) VALUES
(11, 'Michel', 'Drucker', 'Mich', '$2y$10$i1yvYrUIN1TLNGYHX8.gcek3qt14V3gRcut23igJd0B12SC/ijJcK'),
(13, 'Claude', 'François', 'Claud', '$2y$10$.564PY2oMrrbRSvb6q7dUugCBlJJnzwi2G5ozkmZYeEXC0lU7ZCau'),
(14, 'Claude', 'François', 'Claud', '$2y$10$aptEzl082a0kWod.9xDFPOAjIq6rg9YRIxt6ny7/NuvOAqukV3Ayy'),
(15, 'Claude', 'François', 'Claud', '$2y$10$aWsp37Icfon0Z5DPvY/.3.TyiBh6dBzkm8k4frFzRruHHY/C5Xf.2'),
(16, 'Claude', 'François', 'Claud', '$2y$10$8RJhIe57jYIKWX08lJMKcOrbfLNhzGjJTrolsT7TLhF/KPJg05YjK'),
(17, 'Claude', 'François', 'Claud', '$2y$10$/lAHmAr08q54FShlUqNc5um0zwY1toEFPk1p.dwOhGTAUk2vdN0Ee'),
(18, 'Claude', 'François', 'Claud', '$2y$10$b79EiRXFdRwv2SLrIbrquuQ3Y649516tndqiqsrucs1S1pH/KJvyW'),
(19, 'Claude', 'François', 'Claud', '$2y$10$llSUp7L5ggJ43D2RqbPZCe/YzhA/tzwy9eF3fj27pWmeFff9rMehq');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
