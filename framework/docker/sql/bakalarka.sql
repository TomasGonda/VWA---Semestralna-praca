-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hostiteľ: 127.0.0.1:3307
-- Čas generovania: Sun 15.Nov 2026, 09:25
-- Verzia serveru: 10.4.32-MariaDB
-- Verzia PHP: 8.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáza: `bakalarka`
--

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` varchar(35) NOT NULL DEFAULT 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Sťahujem dáta pre tabuľku `admins`
--

INSERT INTO `admins` (`id`, `username`, `password_hash`, `created_at`, `role`) VALUES
(1, 'admin', '$2y$12$BZMOglQoB4IkFIXOWEkeFOsVe/7kxOOqiEP7CQNi31ueLXxrdSAQu', '2026-11-08 15:17:38', 'admin'),
(2, 'dev', '$2y$12$nERB5U.Hx9DnQBGv2Akf7uxHsGnaQqP0dly1wZBpNPRnFPxQNHTFS', '2026-11-14 15:53:46', 'dev');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(25) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `gdpr_consent` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_resolved` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Sťahujem dáta pre tabuľku `contact`
--

INSERT INTO `contact` (`id`, `first_name`, `last_name`, `email`, `phone`, `note`, `gdpr_consent`, `created_at`, `is_resolved`) VALUES
(7, 'meho', 'dawdawd', 'gmail@gmail.com', '+421907123456', 'dawd', 1, '2026-11-12 18:43:44', 0),
(8, 'mrkva', 'zelena', 'gmail@gmail.com', '+421907123456', 'esgaw', 1, '2026-11-12 18:49:08', 0),
(9, 'test', 'fero', 'gmaio@lfr.sk', '+987546424', 'fawfawfaw', 1, '2026-11-12 21:31:49', 0);

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `document`
--

CREATE TABLE `document` (
  `id_document` int(11) NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp(),
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Sťahujem dáta pre tabuľku `document`
--

INSERT INTO `document` (`id_document`, `note`, `timestamp`, `file_name`, `file_path`) VALUES
(3, 'Osobne udaje', '2026-11-14 21:43:41', 'personal_informations.pdf', '../../databaseConections/database.php5b07ff299f021353bb3e888419415037pdf');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `languages`
--

CREATE TABLE `languages` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(5) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Sťahujem dáta pre tabuľku `languages`
--

INSERT INTO `languages` (`id`, `code`, `name`) VALUES
(1, 'sk', 'Slovenčina'),
(2, 'en', 'English');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `translations`
--

CREATE TABLE `translations` (
  `id` int(10) UNSIGNED NOT NULL,
  `language_id` int(10) UNSIGNED NOT NULL,
  `translation_key` varchar(100) NOT NULL,
  `translation_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Sťahujem dáta pre tabuľku `translations`
--

INSERT INTO `translations` (`id`, `language_id`, `translation_key`, `translation_value`) VALUES
(1, 1, 'contact', 'Kontakt'),
(2, 1, 'about', 'O nás'),
(3, 2, 'contact', 'Contact'),
(4, 2, 'about', 'About us'),
(5, 1, 'title', 'Športové výsledkové tabule'),
(6, 1, 'cart', 'Košík'),
(7, 2, 'title', 'Scoreboards for all sports'),
(8, 2, 'cart', 'Cart'),
(15, 1, 'search', 'Hľadať'),
(16, 1, 'menu_sport_tables', 'Športové tabule'),
(17, 1, 'search_placeholder', 'Vyhľadávanie'),
(18, 2, 'search', 'Search'),
(19, 2, 'menu_sport_tables', 'Scoreboards'),
(20, 2, 'search_placeholder', 'Search'),
(21, 1, 'menu_stop_watch', 'Stopky'),
(22, 1, 'menu_basketball', 'Basketball'),
(23, 1, 'menu_utilities', 'Príslušenstvo'),
(24, 2, 'menu_stop_watch', 'Stop Watch'),
(25, 2, 'menu_basketball', 'Basketball'),
(26, 2, 'menu_utilities', 'Utilities'),
(27, 1, 'first_name_label', 'Meno'),
(28, 1, 'first_name_placeholder', 'Zadajte meno'),
(29, 1, 'last_name_label', 'Priezvisko'),
(30, 1, 'last_name_placeholder', 'Zadajte priezvisko'),
(31, 1, 'email_label', 'E-mail'),
(32, 1, 'email_placeholder', 'Email'),
(33, 1, 'phone_label', 'Telefón'),
(34, 1, 'phone_placeholder', '+421 900 123 456'),
(35, 1, 'note_label', 'Poznámka'),
(36, 1, 'note_placeholder', 'Poznámka pre firmu'),
(37, 1, 'submit_button', 'Odoslať'),
(38, 2, 'first_name_label', 'First name'),
(39, 2, 'first_name_placeholder', 'Enter your first name'),
(40, 2, 'last_name_label', 'Last name'),
(41, 2, 'last_name_placeholder', 'Enter your last name'),
(42, 2, 'email_label', 'E-mail'),
(43, 2, 'email_placeholder', 'Email'),
(44, 2, 'phone_label', 'Phone'),
(45, 2, 'phone_placeholder', '+421 900 123 456'),
(46, 2, 'note_label', 'Note'),
(47, 2, 'note_placeholder', 'Message for the company'),
(48, 2, 'submit_button', 'Send'),
(49, 1, 'contact_info_title', 'Kontaktujte nás'),
(50, 1, 'contact_info_address', 'Adresa:\r\nNa Stráňach 6\r\n971 01 PRIEVIDZA\r\nSlovenská republika'),
(51, 1, 'contact_info_phone', 'Telefón:\r\n+421 905 627 189'),
(52, 1, 'contact_info_email', 'E-Mail:\r\ninfo@lgr.sk'),
(53, 2, 'contact_info_title', 'Contact us'),
(54, 2, 'contact_info_address', 'Address:\r\nNa Stráňach 6\r\n971 01 PRIEVIDZA\r\nSlovakia'),
(55, 2, 'contact_info_phone', 'Phone:\r\n+421 905 627 189'),
(56, 2, 'contact_info_email', 'E-mail:\r\ninfo@lgr.sk'),
(57, 1, 'gdpr_consent', 'Súhlasím so spracovaním osobných údajov.'),
(58, 2, 'gdpr_consent', 'I agree to the processing of my personal data.'),
(59, 1, 'documents', 'Dokumenty'),
(60, 2, 'documents', 'Documents'),
(61, 1, 'contact_required', 'Vyplňte všetky povinné polia.'),
(62, 2, 'contact_required', 'Please fill in all required fields.'),
(63, 1, 'contact_invalid_email', 'Zadajte platnú e-mailovú adresu.'),
(64, 2, 'contact_invalid_email', 'Please enter a valid email address.'),
(65, 1, 'contact_gdpr_required', 'Musíte súhlasiť so spracovaním osobných údajov.'),
(66, 2, 'contact_gdpr_required', 'You must consent to the processing of personal data.'),
(67, 1, 'contact_too_long', 'Niektoré údaje sú príliš dlhé.'),
(68, 2, 'contact_too_long', 'Some of the data is too long.'),
(69, 1, 'contact_error', 'Správu sa nepodarilo odoslať. Skúste to znova.'),
(70, 2, 'contact_error', 'The message could not be sent. Please try again.'),
(71, 1, 'contact_success', 'Správa bola úspešne odoslaná.'),
(72, 2, 'contact_success', 'Your message has been sent successfully.'),
(73, 1, 'contact_invalid_phone', 'Zadajte telefónne číslo v tvare +421 907 123 456.'),
(74, 2, 'contact_invalid_phone', 'Enter a phone number in the format +421 907 123 456.'),
(75, 1, 'general_informations', 'Všeobecné informácie'),
(76, 2, 'general_imformations', 'General info'),
(77, 1, 'categories', 'Kategórie'),
(78, 1, 'hockey', 'Hokej'),
(79, 1, 'football', 'Futbal'),
(80, 1, 'basketball', 'Basketball'),
(81, 1, 'volleyball', 'Volejbal'),
(82, 2, 'categories', 'Categories'),
(83, 2, 'hockey', 'Hockey'),
(84, 2, 'football', 'Football'),
(85, 2, 'basketball', 'Basketball'),
(86, 2, 'volleyball', 'Volleyball'),
(87, 1, 'general_info', 'Všeobecné informácie'),
(88, 2, 'general_info', 'General informations'),
(89, 1, 'ski_web', 'Ski'),
(90, 2, 'ski_web', 'Ski'),
(91, 1, 'aaaa', 'aaaa');

--
-- Kľúče pre exportované tabuľky
--

--
-- Indexy pre tabuľku `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexy pre tabuľku `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pre tabuľku `document`
--
ALTER TABLE `document`
  ADD PRIMARY KEY (`id_document`);

--
-- Indexy pre tabuľku `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexy pre tabuľku `translations`
--
ALTER TABLE `translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `language_id` (`language_id`,`translation_key`);

--
-- AUTO_INCREMENT pre exportované tabuľky
--

--
-- AUTO_INCREMENT pre tabuľku `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pre tabuľku `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pre tabuľku `document`
--
ALTER TABLE `document`
  MODIFY `id_document` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pre tabuľku `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pre tabuľku `translations`
--
ALTER TABLE `translations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- Obmedzenie pre exportované tabuľky
--

--
-- Obmedzenie pre tabuľku `translations`
--
ALTER TABLE `translations`
  ADD CONSTRAINT `fk_translation_language` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
