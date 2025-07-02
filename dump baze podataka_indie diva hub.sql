-- SQL Dump za Indie Diva Hub
-- Verzija baze: MySQL/MariaDB
-- Kodna stranica: utf8mb4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
SET NAMES utf8mb4;

-- ------------------------
-- Tablica: korisnici
-- ------------------------
CREATE TABLE `korisnici` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `korisnicko_ime` VARCHAR(50) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `lozinka` VARCHAR(255) NOT NULL,
  `uloga` ENUM('admin','user') NOT NULL,
  `kreirano` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `korisnicko_ime` (`korisnicko_ime`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `korisnici` (`id`, `korisnicko_ime`, `email`, `lozinka`, `uloga`) VALUES
(1, 'admin', 'admin@example.com', '25e4ee4e9229397b6b17776bfceaf8e7', 'admin'),
(2, 'johndoe', 'john@example.com', '5ebe2294ecd0e0f08eab7690d2a6ee69', 'user');

-- ------------------------
-- Tablica: umjetnice
-- ------------------------
CREATE TABLE `umjetnice` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `ime` VARCHAR(100) NOT NULL,
  `biografija` TEXT,
  `kontakt` VARCHAR(100),
  `slika_url` VARCHAR(255),
  `genius_url` VARCHAR(255),
  `datum_dodavanja` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `umjetnice` (`id`, `ime`, `biografija`, `kontakt`, `slika_url`, `genius_url`, `datum_dodavanja`) VALUES
(1, 'Caroline Polachek', 'Caroline Polachek je umjetnica poznata po svom alternativnom pop zvuku.', NULL, 'https://media.pitchfork.com/photos/638e25b9050dcbdc83fd7926/1:1/w_320,c_limit/Caroline-Polachek.jpg', 'https://genius.com/artists/Caroline-polachek', NOW()),
(2, 'Lorde', 'Lorde je novozelandska pjevačica i tekstopisac koja je stekla međunarodnu slavu.', NULL, 'https://imageio.forbes.com/b-i-forbesimg/stevenbertoni/files/2013/11/Lorde.jpeg?format=jpg&height=900&width=1600&fit=bounds', 'https://genius.com/artists/Lorde', NOW()),
(3, 'Lana Del Rey', 'Lana Del Rey je američka pjevačica poznata po svom cinematic popu.', NULL, 'https://media.npr.org/assets/img/2019/12/09/04-music19-lanadelrey2_wide-e59edf7b74b38e355c899acd46e9a1f6400fe682.jpg', 'https://genius.com/artists/Lana-del-rey', NOW()),
(4, 'Björk', 'Björk je islandska umjetnica poznata po svom eksperimentalnom pristupu glazbi.', NULL, 'https://upload.wikimedia.org/wikipedia/commons/thumb/0/0f/Bjork_Orkestral_Paris_%28cropped%29.png/800px-Bjork_Orkestral_Paris_%28cropped%29.png', 'https://genius.com/artists/Bjork', NOW()),
(5, 'Florence Welch', 'Florence Welch je britanska pjevačica poznata po emotivnom rock/pop stilu.', NULL, 'https://cdn-images.dzcdn.net/images/artist/7fa361bc6201b3edae6b74c08da3922f/1900x1900-000000-80-0-0.jpg', 'https://genius.com/artists/Florence-welch', NOW()),
(6, 'Grimes', 'Grimes je kanadska umjetnica poznata po svom eksperimentalnom pristupu elektronskoj glazbi i alternativnom popu.', NULL, 'https://nypost.com/wp-content/uploads/sites/2/2021/10/grimes-01.jpg?quality=90&strip=all', 'https://genius.com/artists/Grimes', NOW()),
(7, 'Clairo', 'Clairo je mlada američka pjevačica i tekstopisac koja donosi svjež pristup indie pop žanru.', NULL, 'https://media.newyorker.com/photos/668dabf86b5fa018becc0c7d/1:1/w_2182,h_2182,c_limit/r44564.jpg', 'https://genius.com/artists/Clairo', NOW()),
(8, 'Billie Eilish', 'Billie Eilish je američka umjetnica poznata po svom jedinstvenom glazbenom stilu i alternativnoj pop produkciji.', NULL, 'https://i.guim.co.uk/img/media/70f6cbdd9735d555838d285f8092951aa795b044/336_536_3086_1851/master/3086.jpg?width=1200&height=1200&quality=85&auto=format&fit=crop&s=f830c8a0cb0e550f1882669be4915dd3', 'https://genius.com/artists/Billie-eilish', NOW()),
(9, 'FKA twigs', 'FKA twigs je britanska umjetnica poznata po svom eksperimentalnom R&B i alternativnom popu.', NULL, 'https://assets.vogue.com/photos/66c746172df9777a1129ad19/2:3/w_2222,h_3333,c_limit/2167639297', 'https://genius.com/artists/FKA-twigs', NOW()),
(10, 'St. Vincent', 'St. Vincent je američka pjevačica i multi-instrumentalist poznata po svom inovativnom pristupu rock i alternativnoj glazbi.', NULL, 'https://media.gq.com/photos/663d598d5ab5678bbac40e73/master/pass/unnamed-2024-04-23T134834.069-scaled.jpg', 'https://genius.com/artists/St-vincent', NOW());

-- ------------------------
-- Tablica: albumi
-- ------------------------
CREATE TABLE `albumi` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `umjetnica_id` INT NOT NULL,
  `naslov` VARCHAR(150) NOT NULL,
  `godina_izdanja` INT,
  `naslovnica` VARCHAR(255),
  `opis` TEXT,
  `genius_url` VARCHAR(255),
  PRIMARY KEY (`id`),
  KEY `umjetnica_id` (`umjetnica_id`),
  CONSTRAINT `fk_albumi_umjetnice` FOREIGN KEY (`umjetnica_id`) REFERENCES `umjetnice`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `albumi` (`id`, `umjetnica_id`, `naslov`, `godina_izdanja`, `naslovnica`, `opis`, `genius_url`) VALUES
(1, 1, 'Pang', 2019, 'https://upload.wikimedia.org/wikipedia/en/f/f1/Caroline_Polachek_-_Pang.png', 'Album “Pang” autorice Caroline Polachek.', 'https://genius.com/albums/Caroline-polachek/Pang'),
(2, 2, 'Melodrama', 2017, 'https://assets.vogue.com/photos/58b9984661298051ac278def/master/w_2560%2Cc_limit/00-holding-lorde-album-art.jpg', 'Album “Melodrama” autorice Lorde.', 'https://genius.com/albums/Lorde/Melodrama'),
(3, 3, 'Norman Fucking Rockwell!', 2019, 'https://upload.wikimedia.org/wikipedia/hu/9/9e/Lana_Del_Rey_-_Norman_Fucking_Rockwell_%28album_cover%29.png', 'Album “Norman Fucking Rockwell!” autorice Lane Del Rey.', 'https://genius.com/albums/Lana-del-rey/Norman-fucking-rockwell'),
(4, 4, 'Homogenic', 1997, 'https://upload.wikimedia.org/wikipedia/en/a/af/Bj%C3%B6rk_-_Homogenic.png', 'Album “Homogenic” autorice Björk.', 'https://genius.com/albums/Bjork/Homogenic'),
(5, 5, 'Lungs', 2009, 'https://upload.wikimedia.org/wikipedia/en/thumb/2/26/Florence_and_the_Machine_-_Lungs.png/250px-Florence_and_the_Machine_-_Lungs.png', 'Album “Lungs” autorice Florence Welch.', 'https://genius.com/albums/Florence-welch/Lungs'),
(6, 6, 'Art Angels', 2015, 'https://upload.wikimedia.org/wikipedia/en/d/d9/Grimes_-_Art_Angels.png', 'Album “Art Angels” autorice Grimes.', 'https://genius.com/albums/Grimes/Art-angels'),
(7, 7, 'Immunity', 2019, 'https://upload.wikimedia.org/wikipedia/en/5/56/Clairo_-_Immunity.png', 'Album “Immunity” autorice Clairo.', 'https://genius.com/albums/Clairo/Immunity'),
(8, 8, 'When We All Fall Asleep, Where Do We Go?', 2019, 'https://upload.wikimedia.org/wikipedia/en/3/38/When_We_All_Fall_Asleep%2C_Where_Do_We_Go%3F.png', 'Album “When We All Fall Asleep, Where Do We Go?” autorice Billie Eilish.', 'https://genius.com/albums/Billie-eilish/When-we-all-fall-asleep-where-do-we-go'),
(9, 9, 'LP1', 2014, 'https://upload.wikimedia.org/wikipedia/en/7/77/FKA_twigs_-_LP1.png', 'Album “LP1” autorice FKA twigs.', 'https://genius.com/albums/FKA-twigs/LP1'),
(10, 10, 'Masseduction', 2017, 'https://upload.wikimedia.org/wikipedia/en/9/90/St_Vincent_-_Masseduction.png', 'Album “Masseduction” autorice St. Vincent.', 'https://genius.com/albums/St-vincent/Masseduction');

-- ------------------------
-- Tablica: recenzije
-- ------------------------
CREATE TABLE `recenzije` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `korisnik_id` INT NOT NULL,
  `umjetnica_id` INT,
  `album_id` INT,
  `ocjena` INT NOT NULL,
  `komentar` TEXT,
  `kreirano` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `korisnik_id` (`korisnik_id`),
  KEY `umjetnica_id` (`umjetnica_id`),
  KEY `album_id` (`album_id`),
  CONSTRAINT `fk_recenzije_korisnici` FOREIGN KEY (`korisnik_id`) REFERENCES `korisnici`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_recenzije_umjetnice` FOREIGN KEY (`umjetnica_id`) REFERENCES `umjetnice`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_recenzije_albumi` FOREIGN KEY (`album_id`) REFERENCES `albumi`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------
-- Tablica: prijedlozi
-- ------------------------
CREATE TABLE `prijedlozi` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `ime_umjetnice` VARCHAR(100) NOT NULL,
  `opis` TEXT,
  `kontakt` VARCHAR(100),
  `slika_url` VARCHAR(255),
  `status` ENUM('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `poslao_id` INT,
  `poslano` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `poslao_id` (`poslao_id`),
  CONSTRAINT `fk_prijedlozi_korisnici` FOREIGN KEY (`poslao_id`) REFERENCES `korisnici`(`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

COMMIT;
