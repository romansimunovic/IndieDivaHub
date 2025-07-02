-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 09, 2025 at 01:57 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `indie_diva_hub`
--

-- --------------------------------------------------------

--
-- Table structure for table `albumi`
--

CREATE TABLE `albumi` (
  `id` int(11) NOT NULL,
  `umjetnica_id` int(11) NOT NULL,
  `naslov` varchar(150) NOT NULL,
  `godina_izdanja` int(11) DEFAULT NULL,
  `naslovnica` varchar(255) DEFAULT NULL,
  `opis` text DEFAULT NULL,
  `genius_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `albumi`
--

INSERT INTO `albumi` (`id`, `umjetnica_id`, `naslov`, `godina_izdanja`, `naslovnica`, `opis`, `genius_url`) VALUES
(1, 1, 'Pang', 2019, 'https://example.com/images/pang.jpg', 'Album Pang by Caroline Polachek.', 'https://genius.com/albums/Caroline-polachek/Pang'),
(2, 2, 'Melodrama', 2017, 'https://example.com/images/melodrama.jpg', 'Album Melodrama by Lorde.', 'https://genius.com/albums/Lorde/Melodrama'),
(3, 3, 'Norman Fucking Rockwell!', 2019, 'https://example.com/images/nfr.jpg', 'Album Norman Fucking Rockwell! by Lana Del Rey.', 'https://genius.com/albums/Lana-del-rey/Norman-fucking-rockwell'),
(4, 4, 'Homogenic', 1997, 'https://example.com/images/homogenic.jpg', 'Album Homogenic by Björk.', 'https://genius.com/albums/Bjork/Homogenic'),
(5, 5, 'Lungs', 2009, 'https://example.com/images/lungs.jpg', 'Album Lungs by Florence Welch.', 'https://genius.com/albums/Florence-welch/Lungs'),
(6, 6, 'Art Angels', 2015, 'https://example.com/images/grimes_artangels.jpg', 'Album Art Angels by Grimes.', 'https://genius.com/albums/Grimes/Art-angels'),
(7, 7, 'Immunity', 2019, 'https://example.com/images/clairo_immunity.jpg', 'Album Immunity by Clairo.', 'https://genius.com/albums/Clairo/Immunity'),
(8, 8, 'When We All Fall Asleep, Where Do We Go?', 2019, 'https://example.com/images/billie_fall_asleep.jpg', 'Album When We All Fall Asleep, Where Do We Go? by Billie Eilish.', 'https://genius.com/albums/Billie-eilish/When-we-all-fall-asleep-where-do-we-go'),
(9, 9, 'LP1', 2014, 'https://example.com/images/fka_twigs_lp1.jpg', 'Album LP1 by FKA twigs.', 'https://genius.com/albums/FKA-twigs/LP1'),
(10, 10, 'Masseduction', 2017, 'https://example.com/images/st_vincent_masseduction.jpg', 'Album Masseduction by St. Vincent.', 'https://genius.com/albums/St-vincent/Masseduction');

-- --------------------------------------------------------

--
-- Table structure for table `korisnici`
--

CREATE TABLE `korisnici` (
  `id` int(11) NOT NULL,
  `korisnicko_ime` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `lozinka` varchar(255) NOT NULL,
  `uloga` enum('admin','user') NOT NULL,
  `kreirano` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `korisnici`
--

INSERT INTO `korisnici` (`id`, `korisnicko_ime`, `email`, `lozinka`, `uloga`, `kreirano`) VALUES
(1, 'admin', 'admin@example.com', '25e4ee4e9229397b6b17776bfceaf8e7', 'admin', '2025-02-09 01:44:57'),
(2, 'johndoe', 'john@example.com', '5ebe2294ecd0e0f08eab7690d2a6ee69', 'user', '2025-02-09 01:44:57');

-- --------------------------------------------------------

--
-- Table structure for table `prijedlozi`
--

CREATE TABLE `prijedlozi` (
  `id` int(11) NOT NULL,
  `ime_umjetnice` varchar(100) NOT NULL,
  `opis` text DEFAULT NULL,
  `kontakt` varchar(100) DEFAULT NULL,
  `slika_url` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `poslao_id` int(11) DEFAULT NULL,
  `poslano` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prijedlozi`
--

INSERT INTO `prijedlozi` (`id`, `ime_umjetnice`, `opis`, `kontakt`, `slika_url`, `status`, `poslao_id`, `poslano`) VALUES
(1, 'Sia', 'Sia je fenomenalna pjevačica i tekstopisac poznata po svom jedinstvenom glasu i stilu.', 'sia@example.com', NULL, 'pending', 2, '2025-02-09 01:44:57'),
(2, 'Tame Impala', 'Tame Impala je projekt Kevinja Parkera poznat po psihodeličnom rocku i alternativnoj glazbi.', 'tame@example.com', NULL, 'pending', 2, '2025-02-09 01:44:57');

-- --------------------------------------------------------

--
-- Table structure for table `recenzije`
--

CREATE TABLE `recenzije` (
  `id` int(11) NOT NULL,
  `korisnik_id` int(11) NOT NULL,
  `umjetnica_id` int(11) DEFAULT NULL,
  `album_id` int(11) DEFAULT NULL,
  `ocjena` int(11) NOT NULL,
  `komentar` text DEFAULT NULL,
  `kreirano` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recenzije`
--

INSERT INTO `recenzije` (`id`, `korisnik_id`, `umjetnica_id`, `album_id`, `ocjena`, `komentar`, `kreirano`) VALUES
(1, 2, 1, NULL, 5, 'Caroline Polachek is a visionary in modern pop music. Love her innovative approach!', '2025-02-09 01:44:57'),
(2, 2, 2, 2, 4, 'Melodrama is an emotional masterpiece, capturing the complexity of modern relationships.', '2025-02-09 01:44:57'),
(3, 2, 6, 6, 5, 'Art Angels by Grimes is a groundbreaking album that redefines pop music.', '2025-02-09 01:44:57'),
(4, 2, 9, 9, 4, 'Billie Eilish delivers a haunting and innovative sound on this album.', '2025-02-09 01:44:57'),
(5, 2, 8, NULL, 4, 'Ne sviđa mi se baš.', '2025-02-09 01:46:05');

-- --------------------------------------------------------

--
-- Table structure for table `umjetnice`
--

CREATE TABLE `umjetnice` (
  `id` int(11) NOT NULL,
  `ime` varchar(100) NOT NULL,
  `biografija` text DEFAULT NULL,
  `kontakt` varchar(100) DEFAULT NULL,
  `slika_url` varchar(255) DEFAULT NULL,
  `genius_url` varchar(255) DEFAULT NULL,
  `datum_dodavanja` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `umjetnice`
--

INSERT INTO `umjetnice` (`id`, `ime`, `biografija`, `kontakt`, `slika_url`, `genius_url`, `datum_dodavanja`) VALUES
(1, 'Caroline Polachek', 'Caroline Polachek je umjetnica poznata po svom alternativnom pop zvuku.', NULL, 'https://media.pitchfork.com/photos/638e25b9050dcbdc83fd7926/1:1/w_320,c_limit/Caroline-Polachek.jpg', 'https://genius.com/artists/Caroline-polachek', '2025-02-09 01:44:57'),
(2, 'Lorde', 'Lorde je novozelandska pjevačica i tekstopisac koja je stekla međunarodnu slavu.', NULL, 'https://imageio.forbes.com/b-i-forbesimg/stevenbertoni/files/2013/11/Lorde.jpeg?format=jpg&height=900&width=1600&fit=bounds', 'https://genius.com/artists/Lorde', '2025-02-09 01:44:57'),
(3, 'Lana Del Rey', 'Lana Del Rey je američka pjevačica poznata po svom cinematic popu.', NULL, 'https://media.npr.org/assets/img/2019/12/09/04-music19-lanadelrey2_wide-e59edf7b74b38e355c899acd46e9a1f6400fe682.jpg', 'https://genius.com/artists/Lana-del-rey', '2025-02-09 01:44:57'),
(4, 'Björk', 'Björk je islandska umjetnica poznata po svom eksperimentalnom pristupu glazbi.', NULL, 'https://upload.wikimedia.org/wikipedia/commons/thumb/0/0f/Bjork_Orkestral_Paris_%28cropped%29.png/800px-Bjork_Orkestral_Paris_%28cropped%29.png', 'https://genius.com/artists/Bjork', '2025-02-09 01:44:57'),
(5, 'Florence Welch', 'Florence Welch je britanska pjevačica poznata po emotivnom rock/pop stilu.', NULL, 'https://cdn-images.dzcdn.net/images/artist/7fa361bc6201b3edae6b74c08da3922f/1900x1900-000000-80-0-0.jpg', 'https://genius.com/artists/Florence-welch', '2025-02-09 01:44:57'),
(6, 'Grimes', 'Grimes je kanadska umjetnica poznata po svom eksperimentalnom pristupu elektronskoj glazbi i alternativnom popu.', NULL, 'https://nypost.com/wp-content/uploads/sites/2/2021/10/grimes-01.jpg?quality=90&strip=all', 'https://genius.com/artists/Grimes', '2025-02-09 01:44:57'),
(7, 'Clairo', 'Clairo je mlada američka pjevačica i tekstopisac koja donosi svjež pristup indie pop žanru.', NULL, 'https://media.newyorker.com/photos/668dabf86b5fa018becc0c7d/1:1/w_2182,h_2182,c_limit/r44564.jpg', 'https://genius.com/artists/Clairo', '2025-02-09 01:44:57'),
(8, 'Billie Eilish', 'Billie Eilish je američka umjetnica poznata po svom jedinstvenom glazbenom stilu i alternativnoj pop produkciji.', NULL, 'https://i.guim.co.uk/img/media/70f6cbdd9735d555838d285f8092951aa795b044/336_536_3086_1851/master/3086.jpg?width=1200&height=1200&quality=85&auto=format&fit=crop&s=f830c8a0cb0e550f1882669be4915dd3', 'https://genius.com/artists/Billie-eilish', '2025-02-09 01:44:57'),
(9, 'FKA twigs', 'FKA twigs je britanska umjetnica poznata po svom eksperimentalnom R&B i alternativnom popu.', NULL, 'https://assets.vogue.com/photos/66c746172df9777a1129ad19/2:3/w_2222,h_3333,c_limit/2167639297', 'https://genius.com/artists/FKA-twigs', '2025-02-09 01:44:57'),
(10, 'St. Vincent', 'St. Vincent je američka pjevačica i multi-instrumentalist poznata po svom inovativnom pristupu rock i alternativnoj glazbi.', NULL, 'https://media.gq.com/photos/663d598d5ab5678bbac40e73/master/pass/unnamed-2024-04-23T134834.069-scaled.jpg', 'https://genius.com/artists/St-vincent', '2025-02-09 01:44:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `albumi`
--
ALTER TABLE `albumi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `umjetnica_id` (`umjetnica_id`);

--
-- Indexes for table `korisnici`
--
ALTER TABLE `korisnici`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `korisnicko_ime` (`korisnicko_ime`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `prijedlozi`
--
ALTER TABLE `prijedlozi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `poslao_id` (`poslao_id`);

--
-- Indexes for table `recenzije`
--
ALTER TABLE `recenzije`
  ADD PRIMARY KEY (`id`),
  ADD KEY `korisnik_id` (`korisnik_id`),
  ADD KEY `umjetnica_id` (`umjetnica_id`),
  ADD KEY `album_id` (`album_id`);

--
-- Indexes for table `umjetnice`
--
ALTER TABLE `umjetnice`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `albumi`
--
ALTER TABLE `albumi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `korisnici`
--
ALTER TABLE `korisnici`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `prijedlozi`
--
ALTER TABLE `prijedlozi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `recenzije`
--
ALTER TABLE `recenzije`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `umjetnice`
--
ALTER TABLE `umjetnice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `albumi`
--
ALTER TABLE `albumi`
  ADD CONSTRAINT `albumi_ibfk_1` FOREIGN KEY (`umjetnica_id`) REFERENCES `umjetnice` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `prijedlozi`
--
ALTER TABLE `prijedlozi`
  ADD CONSTRAINT `prijedlozi_ibfk_1` FOREIGN KEY (`poslao_id`) REFERENCES `korisnici` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `recenzije`
--
ALTER TABLE `recenzije`
  ADD CONSTRAINT `recenzije_ibfk_1` FOREIGN KEY (`korisnik_id`) REFERENCES `korisnici` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `recenzije_ibfk_2` FOREIGN KEY (`umjetnica_id`) REFERENCES `umjetnice` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `recenzije_ibfk_3` FOREIGN KEY (`album_id`) REFERENCES `albumi` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
