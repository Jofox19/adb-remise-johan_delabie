-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 08 déc. 2023 à 03:00
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `adb_login`
--

-- --------------------------------------------------------

--
-- Structure de la table `adds`
--

DROP TABLE IF EXISTS `adds`;
CREATE TABLE IF NOT EXISTS `adds` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lastname` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `notes` longtext NOT NULL,
  `id_users` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_users` (`id_users`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `adds`
--

INSERT INTO `adds` (`id`, `lastname`, `firstname`, `email`, `phone`, `address`, `notes`, `id_users`) VALUES
(1, 'Forbes', 'Katell', 'qopugor@mailinator.com', '+1 (386) 138-8034', 'Proident aliquam qu', '', 11),
(2, 'Cervantes', 'Bree', 'gevylely@mailinator.com', '+1 (395) 673-5879', 'Tempore irure offic', '', 11),
(3, 'Kelly', 'Kirby', 'cucapu@mailinator.com', '+1 (712) 508-7521', 'Expedita exercitatio', '', 11),
(4, 'Kelly', 'Kirby', 'cucapu@mailinator.com', '+1 (712) 508-7521', 'Expedita exercitatio', '', 11),
(6, 'Watts', 'Kareem', 'denikenedy@mailinator.com', '+1 (653) 159-9193', 'Et laboris repudiand', '', 12),
(7, 'Navarro', 'Chester', 'neho@mailinator.com', '+1 (903) 647-3677', 'Quo architecto sint ', '', 12),
(8, 'oiu', 'Brett', 'fujiw@mailinator.com', '+1 (905) 115-7174', 'Nisi non voluptatibu', '', 12),
(11, 'Boba fett', 'Christopher', 'kesadofyv@mailinator.com', '+1 (194) 205-9697', 'Saepe ullamco reicie', '', 15),
(12, 'Carlson', 'Damian', 'buditanyd@mailinator.com', '+1 (771) 865-8923', 'Eum esse nisi ut vo', '', 15),
(54, 'Kline', 'Fatima', 'katuquf@mailinator.com', '+1 (345) 662-9439', 'Omnis illo expedita ', 'Duis consequuntur pr', 17),
(55, 'Adams', 'Shelley', 'zugoriva@mailinator.com', '+1 (752) 267-9313', 'Facilis vel eveniet', 'Nihil culpa et dolo', 17),
(56, 'Ellis', 'Kadeem', 'fyti@mailinator.com', '+1 (339) 264-1077', 'Aut eligendi non mod', 'Similique cupiditate', 17),
(57, 'Whitney', 'Shay', 'nozupih@mailinator.com', '+1 (632) 851-8535', 'Eum nobis molestiae ', 'ououi', 17),
(58, 'Cervantes', 'Bree', 'gevylely@mailinator.com', '+1 (395) 673-5879', 'Tempore irure offic', 'Nihil culpa et dolo ', 17);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lastname` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `SecretQuestion` varchar(255) NOT NULL,
  `SecretResponse` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `lastname`, `firstname`, `username`, `email`, `SecretQuestion`, `SecretResponse`, `password`) VALUES
(4, 'Kerr', 'Rhonda', 'nemavucal', 'wiwyv@mailinator.com', 'What is your favorite movie ?', 'Ullam in nesciunt o', '$2y$10$kSeG0Dsw88rZzZbsX1RNhuAStxLqVZCftH7rtCuhBTR4jxk46ES8G'),
(5, 'Casey', 'Kelly', 'vuqeqanuli', 'bopef@mailinator.com', 'What was your first car?', 'Quos est ipsum numqu', '$2y$10$jYCUeGtOc2D...NymtQLH.2q6AdOVyFl5JUZuDeqW3frn06hSuH6y'),
(6, 'Dean', 'Alden', 'dywugav', 'qemury@mailinator.com', 'What is your mother\'s maiden name ?', 'In voluptate nihil r', '$2y$10$lP3djA6Jn07qXoHCYM2vCu/h5RDAMDTa6t1E4NSf5NMeNbHuwg8Ui'),
(7, 'Dean', 'Alden', 'dywugav', 'qemury@mailinator.com', 'What is your mother\'s maiden name ?', 'In voluptate nihil r', '$2y$10$7GIRXEXXXgLyLE82EaBac.0OyBheC0Y8MWf663.9i4a6xk31xr2vy'),
(8, 'Dean', 'Alden', 'dywugav', 'qemury@mailinator.com', 'What is your mother\'s maiden name ?', 'In voluptate nihil r', '$2y$10$JRnS6C5M5eJkeqskXPjCG.r0HXucugLa9Q9u2jGVdLrQrmuS30/6S'),
(9, 'Cortez', 'Paula', 'nalaf', 'hocereho@mailinator.com', 'What was your first car?', 'Proident dignissimo', '$2y$10$WJQyTJATPgIuvJ53pmi7hu0tdr32c2GECMnUjlFQKjwWc2NHV7T2.'),
(10, 'Brown', 'Echo', 'jofox', 'fuliqane@mailinator.com', 'What is the name of your first pet ?', 'Esse sunt corrupti', '$2y$10$zIQhuMX52LgustRHw8A9n.JPWb2cFy9aCpYp8j18QRweXgh1yMy3S'),
(11, 'Wyatt', 'Amy', 'amy', 'dymep@mailinator.com', 'What is your mother\'s maiden name ?', 'Dolorem pariatur Et', '$2y$10$uoTQg6fbDA.cIIFwXgfdcuV4cMVXgpYdkuGKpxIPKQf2j8em7pDS6'),
(12, 'Bentley', 'Mollie', 'michel', 'vugeli@mailinator.com', 'What is your favorite color ?', 'red', '$2y$10$CXGMtHuToGdfFRHvmOpv5e5P5OCtE3.RLhoD1gRGJ4SF1Tv/Fl52a'),
(13, 'Callahan', 'Sydnee', 'paposog', 'hawaquhoz@mailinator.com', 'What is the name of your first pet ?', 'Est nisi nihil quia ', '$2y$10$o82mrohsMcudQcXwfrwekuER2RujEdEwAo.ZKUj6wtXtfLi.O3xuG'),
(14, 'Bowen', 'Yen', 'Yen', 'cilob@mailinator.com', 'What is your mother\'s maiden name ?', 'In earum aspernatur ', '$2y$10$Wobva3iei/Xg4R52j21HkOC59MqopHeC75mvh4EmF1m2Snj0BEUKq'),
(15, 'Doyle', 'Otto', 'sabelot', 'wupofyp@mailinator.com', 'What is your mother\'s maiden name ?', 'Reiciendis obcaecati', '$2y$10$3yOLBF70kFERjH7IbqsVvOj390qhKl7xAoFQgkUry.F1vYG.kGlKW'),
(16, 'Wilson', 'Kaden', 'bo', 'dypeqo@mailinator.com', 'What is your favorite color ?', 'Dignissimos ab et ni', '$2y$10$aUFtGpwe5S/ox7sKZvOln.mNumQVEWCvqqCcZBBmXE8.AN3dodfjW'),
(17, 'Carson', 'Avye', 'admin', 'gitypicib@mailinator.com', 'What is your favorite color ?', 'Dolor distinctio At', '$2y$10$c6sv7Up3V0077OG1UQEUbOXAK.Ypo.SIVB7HSDC4p/ynCKBxPZ.Q2'),
(18, 'Meadows', 'Haviva', 'latotoroz', 'jine@mailinator.com', 'What is your favorite color ?', 'Mollitia cum sed vol', '$2y$10$zrHz/R3Rvc1hb/z6Jj1z2.7VlV8TUAl/w2TnugSl68PTycKDzHIle'),
(19, 'Sanford', 'Martina', 'kiqafig', 'tipepuh@mailinator.com', 'What is your favorite movie ?', 'Numquam laudantium ', '$2y$10$VkR.sc/YY/YNHlH82E8yYO/cbh3GX7U.OOJyCRyXNzHLmUldbzsem'),
(20, 'Vance', 'Vielka', 'kovok', 'cuzifub@mailinator.com', 'What is your favorite color ?', 'Ex voluptatem sunt c', '$2y$10$mwYMgPPDwjkc28yCOGz58eLfDOyzL1dw/0SDbTKkUMz2SyP7zdKa.');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `adds`
--
ALTER TABLE `adds`
  ADD CONSTRAINT `adds_ibfk_1` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
