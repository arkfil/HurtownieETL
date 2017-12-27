-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 25 Gru 2017, 20:34
-- Wersja serwera: 10.1.26-MariaDB
-- Wersja PHP: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `ceneo_etl`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cached_html_opinions`
--

CREATE TABLE `cached_html_opinions` (
  `co_id` int(11) NOT NULL,
  `op_cp_id` int(11) NOT NULL,
  `co_data` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cached_html_products`
--

CREATE TABLE `cached_html_products` (
  `cp_id` int(11) NOT NULL,
  `cp_data` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `features`
--

CREATE TABLE `features` (
  `fea_id` int(11) NOT NULL,
  `fea_name` varchar(5000) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `fea_is_adv` smallint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `opinions`
--

CREATE TABLE `opinions` (
  `op_id` int(11) NOT NULL,
  `op_pr_id` int(11) NOT NULL,
  `op_pr_lp` int(11) NOT NULL,
  `op_date` timestamp NULL DEFAULT NULL,
  `op_summary` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `op_stars` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `op_author` varchar(5000) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `op_is_positive` smallint(1) DEFAULT NULL,
  `op_up_votes_count` int(11) DEFAULT NULL,
  `op_down_votes_count` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `opinions_features`
--

CREATE TABLE `opinions_features` (
  `opfea_op_id` int(11) NOT NULL,
  `opfea_pr_lp` int(11) NOT NULL,
  `opfea_fea_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `products`
--

CREATE TABLE `products` (
  `pr_id` int(11) NOT NULL,
  `pr_lp` int(11) NOT NULL,
  `pr_type` varchar(5000) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `pr_brand` varchar(5000) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `pr_model` varchar(5000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `remarks`
--

CREATE TABLE `remarks` (
  `rem_id` int(11) NOT NULL,
  `rem_name` varchar(5000) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `rem_pr_id` int(11) NOT NULL,
  `rem_pr_lp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `cached_html_opinions`
--
ALTER TABLE `cached_html_opinions`
  ADD PRIMARY KEY (`co_id`),
  ADD KEY `op_cp_id` (`op_cp_id`);

--
-- Indexes for table `cached_html_products`
--
ALTER TABLE `cached_html_products`
  ADD PRIMARY KEY (`cp_id`);

--
-- Indexes for table `features`
--
ALTER TABLE `features`
  ADD PRIMARY KEY (`fea_id`);

--
-- Indexes for table `opinions`
--
ALTER TABLE `opinions`
  ADD PRIMARY KEY (`op_id`,`op_pr_lp`),
  ADD KEY `op_pr_id` (`op_pr_id`,`op_pr_lp`);

--
-- Indexes for table `opinions_features`
--
ALTER TABLE `opinions_features`
  ADD PRIMARY KEY (`opfea_op_id`,`opfea_pr_lp`,`opfea_fea_id`),
  ADD KEY `fea_id` (`opfea_fea_id`),
  ADD KEY `op_id` (`opfea_op_id`,`opfea_pr_lp`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`pr_id`,`pr_lp`);

--
-- Indexes for table `remarks`
--
ALTER TABLE `remarks`
  ADD PRIMARY KEY (`rem_id`),
  ADD KEY `rem_pr_id` (`rem_pr_id`,`rem_pr_lp`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `cached_html_opinions`
--
ALTER TABLE `cached_html_opinions`
  MODIFY `co_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;
--
-- AUTO_INCREMENT dla tabeli `cached_html_products`
--
ALTER TABLE `cached_html_products`
  MODIFY `cp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT dla tabeli `features`
--
ALTER TABLE `features`
  MODIFY `fea_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3464;
--
-- AUTO_INCREMENT dla tabeli `remarks`
--
ALTER TABLE `remarks`
  MODIFY `rem_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=137;
--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `cached_html_opinions`
--
ALTER TABLE `cached_html_opinions`
  ADD CONSTRAINT `cached_html_opinions_ibfk_1` FOREIGN KEY (`op_cp_id`) REFERENCES `cached_html_products` (`cp_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `opinions`
--
ALTER TABLE `opinions`
  ADD CONSTRAINT `opinions_ibfk_1` FOREIGN KEY (`op_pr_id`,`op_pr_lp`) REFERENCES `products` (`pr_id`, `pr_lp`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `opinions_features`
--
ALTER TABLE `opinions_features`
  ADD CONSTRAINT `opinions_features_ibfk_4` FOREIGN KEY (`opfea_fea_id`) REFERENCES `features` (`fea_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `opinions_features_ibfk_5` FOREIGN KEY (`opfea_op_id`,`opfea_pr_lp`) REFERENCES `opinions` (`op_id`, `op_pr_lp`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `remarks`
--
ALTER TABLE `remarks`
  ADD CONSTRAINT `remarks_ibfk_1` FOREIGN KEY (`rem_pr_id`,`rem_pr_lp`) REFERENCES `products` (`pr_id`, `pr_lp`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
