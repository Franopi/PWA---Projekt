-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `databaza`
--

-- --------------------------------------------------------

--
-- Table structure for table `korisnik`
--

CREATE TABLE `korisnik` (
  `id` int(11) NOT NULL,
  `ime` varchar(32) CHARACTER SET utf8 COLLATE utf8_croatian_ci NOT NULL,
  `prezime` varchar(32) CHARACTER SET utf8 COLLATE utf8_croatian_ci NOT NULL,
  `korisnicko_ime` varchar(32) CHARACTER SET utf8 COLLATE utf8_croatian_ci NOT NULL,
  `lozinka` varchar(255) CHARACTER SET utf8 COLLATE utf8_croatian_ci NOT NULL,
  `razina` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `korisnik`
--

INSERT INTO `korisnik` (`id`, `ime`, `prezime`, `korisnicko_ime`, `lozinka`, `razina`) VALUES
(1, 'Admin', 'Adamović', 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1),
(2, 'Gost', 'Gostić', 'gost', '$2y$10$P2t6WioMxjCFIRpInEE/VOZ56UgdlqFogWLIvpntnGanP3J4beh2K', 0);

-- --------------------------------------------------------

--
-- Table structure for table `vijesti`
--

CREATE TABLE `vijesti` (
  `id` int(11) NOT NULL,
  `datum` varchar(32) CHARACTER SET utf8 COLLATE utf8_croatian_ci NOT NULL,
  `naslov` varchar(64) CHARACTER SET latin2 COLLATE latin2_croatian_ci NOT NULL,
  `sazetak` text CHARACTER SET latin2 COLLATE latin2_croatian_ci NOT NULL,
  `tekst` text CHARACTER SET latin2 COLLATE latin2_croatian_ci NOT NULL,
  `slika` varchar(64) CHARACTER SET latin2 COLLATE latin2_croatian_ci NOT NULL,
  `kategorija` varchar(64) CHARACTER SET latin2 COLLATE latin2_croatian_ci NOT NULL,
  `arhiva` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin2 COLLATE=latin2_general_ci;

--
-- Dumping data for table `vijesti`
--

INSERT INTO `vijesti` (`id`, `datum`, `naslov`, `sazetak`, `tekst`, `slika`, `kategorija`, `arhiva`) VALUES
(1, '21.06.2026.', 'Što je Lorem Ipsum?', 'Lorem Ipsum je jednostavno probni tekst', 'Lorem Ipsum je jednostavno probni tekst koji se koristi u tiskarskoj i slovoslagarskoj industriji. Lorem Ipsum postoji kao industrijski standard još od 16-og stoljeća, kada je nepoznati tiskar uzeo tiskarsku galiju slova i posložio ih da bi napravio knjigu s uzorkom tiska. Taj je tekst ne samo preživio pet stoljeća, već se i vinuo u svijet elektronskog slovoslagarstva, ostajući u suštini nepromijenjen. Postao je popularan tijekom 1960-ih s pojavom Letraset listova s odlomcima Lorem Ipsum-a, a u skorije vrijeme sa software-om za stolno izdavaštvo kao što je Aldus PageMaker koji također sadrži varijante Lorem Ipsum-a.', 'slika1.jpg', 'Politik', 0),
(2, '21.06.2026.', 'Gdje se može nabaviti?', 'Postoje mnoge varijacije odlomaka iz Lorem Ipsum-a', 'Postoje mnoge varijacije odlomaka iz Lorem Ipsum-a, ali većina je pretrpjela kojekakve promjene s dodanim humorom, ili nasumičnim riječima koje nikako tu ne spadaju. Ako trebate koristiti Lorem Ipsum, morate biti sigurni da tekst ne sadrži skrivene nepodobne riječi ili fraze. Lorem Ipsum generatori na Internetu većinom ponavljaju zadane odlomke po potrebi, što ovaj naš čini prvim pravim generatorom na Internetu. Mi koristimo riječnik od 200 latinskih riječi, u kombinaciji s nekoliko modela rečeničnih struktura, da bi generirali Lorem Ipsum koji izgleda razumno. Stoga je Lorem Ipsum s ove stranice uvijek bez ponavljanja, bez dodanog humora ili nekaraketerističnih riječi.', 'slika2.jpg', 'Politik', 0),
(3, '21.06.2026.', 'Odakle dolazi?', 'Lorem Ipsum nije samo slučajni tekst', 'Richard McClintock, profesor latinskog jezika na Hampden-Sydney koledžu u Virginiji, potražio je jednu od čudnijijh latinskih riječi, consectetur, iz Lorem Ipsum teksta, i prolazeći kroz citate te riječi u klasičnoj književnosti, otkrio nedvojbeni izvor. Lorem Ipsum dolazi iz odlomaka 1.10.32 i 1.10.33 Ciceronovog djela pod naslovom \"de Finibus Bonorum et Malorum\" (Krajnosti dobra i zla), napisanog 45. godine pr.n.e. Ovo je djelo rasprava o teoriji etike, a bilo je vrlo popularno u Renesansi. Prvi redak Lorem Ipsum-a, \"Lorem ipsum dolor sit amet..\", dolazi iz odlomka 1.10.32.\r\n\r\nZa one koje zanima, standardni dio Lorem Ipsum-a koji se koristi od 16.-og stoljeća može se naći u nastavku na ovoj stranici. Dijelovi 1.10.32 i 1.10.33 iz djela \"de Finibus Bonorum et Malorum\" su doslovno preneseni iz originala, popraćeni engleskim prijevodom H. Rackhama iz 1914.', 'slika3.jpg', 'Politik', 0),
(4, '21.06.2026.', 'Why do we use it?', 'The point of using Lorem Ipsum is...', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).', 'slika4.jpg', 'Gesundheit', 0),
(5, '21.06.2026.', 'Neque porro quisquam est', 'Lorem ipsum dolor sit amet, consectetur adipiscing', 'Cras sollicitudin libero vel libero vulputate hendrerit non sit amet ipsum. Suspendisse et ante eu augue semper fringilla non vitae eros. Nam aliquam maximus tellus in commodo. Pellentesque commodo malesuada orci non sagittis. Aenean orci sapien, aliquam id pellentesque eget, sagittis ac neque. Praesent nec neque porta, vestibulum ex ac, fringilla odio. Cras vitae elit sagittis, maximus ipsum eu, feugiat enim. Suspendisse eget fringilla nisi, nec tempus enim. Morbi sed quam quis enim blandit ultrices. Aenean finibus est diam, dignissim finibus sem finibus ac.\r\n\r\nDuis venenatis neque id elit ornare, sed sollicitudin purus varius. In cursus elementum pellentesque. In id est felis. Sed vel interdum lacus. Quisque convallis pulvinar est vel mattis. Phasellus sollicitudin, odio a condimentum faucibus, turpis sem auctor ipsum, in placerat dui tellus id urna. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Integer eu viverra erat, vel facilisis erat. Integer quis ligula lobortis, sollicitudin nisl sollicitudin, maximus dui. Nam et erat laoreet, ultrices augue et, commodo urna. Nam et mauris ut ipsum hendrerit tincidunt.', 'slika1.jpg', 'Gesundheit', 0),
(6, '21.06.2026.', 'Donec eget nunc a magna', 'Morbi pretium magna sapien, sit amet accumsan nisi', 'Maecenas quis ante lacinia lacus condimentum consequat in eu eros. Nulla tempor porttitor orci quis vehicula. Praesent rutrum elementum massa, at luctus urna gravida ut. Praesent tincidunt, orci ut laoreet semper, nisi nulla hendrerit ipsum, ac vulputate ipsum dolor a nibh. Praesent dapibus feugiat justo sed semper. Nulla semper ut diam a varius. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.\r\n\r\nMorbi eu lectus ex. Suspendisse nisl ligula, blandit at tempor in, euismod sed ligula. Nam hendrerit, lacus a tristique gravida, tortor tortor sodales dui, nec blandit diam massa et odio. Suspendisse rhoncus purus a odio congue iaculis. Maecenas a ex non ex ultrices gravida. Aliquam erat volutpat. In tempor quam congue lectus faucibus facilisis. Nam viverra semper nisl, iaculis faucibus nisi bibendum ac.', 'slika5.jpg', 'Gesundheit', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `korisnik`
--
ALTER TABLE `korisnik`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `korisnicko_ime` (`korisnicko_ime`);

--
-- Indexes for table `vijesti`
--
ALTER TABLE `vijesti`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `korisnik`
--
ALTER TABLE `korisnik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vijesti`
--
ALTER TABLE `vijesti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
