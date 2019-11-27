-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 22, 2019 at 08:55 AM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.1.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `science_media_dev`
--

-- --------------------------------------------------------

--
-- Table structure for table `banner`
--

CREATE TABLE `banner` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `url` text NOT NULL,
  `klicks` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `blacklist`
--

CREATE TABLE `blacklist` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(5) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `description` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=ascii;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`) VALUES
(12, 'Computer Sciences', ''),
(13, 'Economics', ''),
(14, 'Engineering Sciences', ''),
(15, 'Humanities & Social Sciences', ''),
(16, 'Life Sciences', ''),
(17, 'Medicine', ''),
(18, 'Natural Sciences', '');

-- --------------------------------------------------------

--
-- Table structure for table `ciddb`
--

CREATE TABLE `ciddb` (
  `id` int(10) UNSIGNED NOT NULL,
  `cid` varchar(30) NOT NULL,
  `typeOfConference` enum('Colloquium','Workshop','Conference','Seminar') NOT NULL,
  `idOfContactSMN` int(11) NOT NULL COMMENT 'id des Kontaktes aus der userAccountsDB vonSMN',
  `contactFirstName` varchar(255) NOT NULL,
  `contactLastName` varchar(255) NOT NULL,
  `contactEMail` varchar(255) NOT NULL,
  `billingAffiliation` varchar(255) NOT NULL,
  `billingStreet` varchar(255) NOT NULL,
  `billingStreetNr` varchar(255) NOT NULL,
  `billingCity` varchar(255) NOT NULL,
  `billingPostalCode` varchar(255) NOT NULL,
  `billingState` varchar(255) NOT NULL,
  `billingCountry` varchar(255) NOT NULL,
  `conferenceTitle` varchar(255) NOT NULL,
  `conferenceSerie` varchar(255) NOT NULL,
  `bezahlt` int(1) NOT NULL DEFAULT '0',
  `paypalEmail` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `conferences`
--

CREATE TABLE `conferences` (
  `id` int(11) NOT NULL,
  `CID` varchar(255) DEFAULT NULL,
  `userID` int(11) NOT NULL COMMENT 'ID des hosts der die Konferenz angelegt hat',
  `confTitle` text COMMENT 'Titel der Konferenz',
  `confSeries` text NOT NULL COMMENT 'Konferenzserie',
  `organizingInstitutions` text NOT NULL,
  `confLocation` text NOT NULL COMMENT 'Konferenzort',
  `startDate` int(11) DEFAULT NULL,
  `endDate` int(11) DEFAULT NULL,
  `venue` varchar(150) DEFAULT NULL,
  `abstract` text,
  `category` varchar(255) NOT NULL,
  `subcategory` varchar(255) NOT NULL,
  `altCategory1` varchar(255) NOT NULL,
  `altSubCategory1` varchar(255) NOT NULL,
  `veterinary` tinyint(1) DEFAULT NULL,
  `altVeterinary` tinyint(1) DEFAULT NULL,
  `keynoteSpeakers` text COMMENT 'Trennung durch ;',
  `programme` text,
  `LOC` text COMMENT 'Trennung durch ;',
  `SOC` text COMMENT 'Trennung durch ;',
  `registrationPayment` text NOT NULL,
  `importantDates` text NOT NULL,
  `hotelInfos` text NOT NULL,
  `travelInformation` text,
  `twitterHashTag` varchar(100) DEFAULT NULL,
  `twitterWidgetID` varchar(100) DEFAULT NULL,
  `filenameBanner_original` varchar(256) DEFAULT NULL,
  `filenamePoster_original` varchar(256) DEFAULT NULL,
  `filenameProgramme_original` varchar(256) DEFAULT NULL,
  `filenameAbstractBook_original` varchar(256) DEFAULT NULL,
  `filenameConfPhoto_original` varchar(256) DEFAULT NULL,
  `views` int(11) NOT NULL DEFAULT '0',
  `registrationOpen` int(11) NOT NULL,
  `abstractSubmissionOpen` tinyint(4) DEFAULT NULL,
  `allowClosedAccess` tinyint(4) DEFAULT '0',
  `fee` decimal(12,2) NOT NULL DEFAULT '0.00',
  `status` enum('unpaid','paid','active') NOT NULL,
  `paypalEmail` varchar(255) DEFAULT NULL,
  `showParticipation` int(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `conference_abstracts`
--

CREATE TABLE `conference_abstracts` (
  `ID` int(11) NOT NULL,
  `CID` varchar(50) NOT NULL,
  `userID` int(11) NOT NULL,
  `talk` int(11) NOT NULL,
  `poster` int(11) NOT NULL,
  `title` text NOT NULL,
  `coAuthors` text NOT NULL,
  `affiliations` text NOT NULL,
  `text` text NOT NULL,
  `dateOfSubmission` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `conference_abstractsubmissiontool`
--

CREATE TABLE `conference_abstractsubmissiontool` (
  `id` int(11) NOT NULL,
  `CID` varchar(30) DEFAULT NULL,
  `abstractSubmissionStart` varchar(20) DEFAULT NULL,
  `abstractSubmissionEnd` varchar(20) DEFAULT NULL,
  `abstractSubmissionText` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `conference_elements`
--

CREATE TABLE `conference_elements` (
  `ID` int(11) NOT NULL,
  `CID` text NOT NULL,
  `type` text NOT NULL COMMENT 'video, paper, poster or presentation',
  `elementID` int(11) NOT NULL COMMENT 'id in typespecific DB',
  `approved` int(11) NOT NULL,
  `session` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `conference_loc`
--

CREATE TABLE `conference_loc` (
  `id` int(11) NOT NULL,
  `CID` varchar(23) DEFAULT NULL,
  `SMN_ID` int(11) DEFAULT NULL,
  `active` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `conference_permissions`
--

CREATE TABLE `conference_permissions` (
  `id` int(11) NOT NULL,
  `code` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `userID` int(11) NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `confID` int(11) NOT NULL,
  `CID` varchar(30) NOT NULL,
  `editConference` int(1) NOT NULL DEFAULT '0',
  `editRegistration` int(1) NOT NULL DEFAULT '0',
  `editAbstracts` int(1) NOT NULL DEFAULT '0',
  `editRestrict` int(1) NOT NULL DEFAULT '0',
  `editContributions` int(1) NOT NULL DEFAULT '0',
  `status` enum('Pending','Accept') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Pending',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `conference_registrations`
--

CREATE TABLE `conference_registrations` (
  `ID` int(11) NOT NULL,
  `CID` text NOT NULL,
  `userID` int(11) NOT NULL,
  `recName` varchar(150) NOT NULL COMMENT 'Name on receipt',
  `recStreet` varchar(150) NOT NULL COMMENT 'Street name and number',
  `recPostalCode` varchar(10) NOT NULL,
  `recState` varchar(150) NOT NULL,
  `recCountry` varchar(150) NOT NULL,
  `recCity` varchar(150) NOT NULL,
  `additionalInfo` text COMMENT 'Zusatzinfos zur Registrierung',
  `holdPresentation` int(11) NOT NULL,
  `presentPoster` int(11) NOT NULL,
  `attendConfDinner` tinyint(4) DEFAULT '0',
  `publishName` tinyint(4) DEFAULT NULL,
  `dateOfRegistration` varchar(10) DEFAULT NULL,
  `optionalCheckbox1` text NOT NULL,
  `optionalCheckbox2` text NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'Free',
  `saleID` varchar(100) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `conference_registrationtool`
--

CREATE TABLE `conference_registrationtool` (
  `id` int(11) NOT NULL,
  `CID` varchar(30) DEFAULT NULL,
  `registrationStart` varchar(20) DEFAULT NULL,
  `registrationEnd` varchar(20) DEFAULT NULL,
  `registrationText` text,
  `registerForDinner` text NOT NULL,
  `optionalCheckbox1` text NOT NULL,
  `optionalCheckbox2` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `conference_sessions`
--

CREATE TABLE `conference_sessions` (
  `ID` int(11) NOT NULL,
  `CID` text NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `domain_blacklist`
--

CREATE TABLE `domain_blacklist` (
  `id` int(11) NOT NULL,
  `domain` varchar(50) NOT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `domain_blacklist`
--

INSERT INTO `domain_blacklist` (`id`, `domain`, `updated_at`, `created_at`) VALUES
(1, 'hotmail', '2019-09-26 09:08:46', '2019-09-26 08:14:38'),
(2, 'gmail', '2019-09-26 08:14:38', '2019-09-26 08:14:38'),
(3, 'mailinator', '2019-09-26 08:14:38', '2019-09-26 08:14:38'),
(4, 'email', '2019-09-26 08:14:38', '2019-09-26 08:14:38'),
(5, '\\.tst', '2019-09-26 08:14:38', '2019-09-26 08:14:38'),
(6, 'yahoo', '2019-09-26 08:14:38', '2019-09-26 08:14:38'),
(7, 'yandex', '2019-09-26 08:14:38', '2019-09-26 08:14:38'),
(8, 'mail.ru', '2019-09-26 08:14:38', '2019-09-26 08:14:38'),
(9, 'outlook', '2019-09-26 09:08:39', '2019-09-26 08:14:38');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `invoiceID` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `userID` int(11) NOT NULL,
  `CID` varchar(30) DEFAULT NULL,
  `PID` varchar(50) DEFAULT NULL,
  `transactionID` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `subTotal` decimal(12,2) NOT NULL,
  `tax` decimal(12,2) NOT NULL,
  `paymentAmount` decimal(12,2) NOT NULL,
  `paymentStatus` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `address` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `keyword_blacklist`
--

CREATE TABLE `keyword_blacklist` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` int(10) NOT NULL,
  `code` varchar(4) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `code`, `name`) VALUES
(1, 'en', 'English'),
(2, 'aa', 'Afar'),
(3, 'ab', 'Abkhazian'),
(4, 'af', 'Afrikaans'),
(5, 'am', 'Amharic'),
(6, 'ar', 'Arabic'),
(7, 'as', 'Assamese'),
(8, 'ay', 'Aymara'),
(9, 'az', 'Azerbaijani'),
(10, 'ba', 'Bashkir'),
(11, 'be', 'Belarusian'),
(12, 'bg', 'Bulgarian'),
(13, 'bh', 'Bihari'),
(14, 'bi', 'Bislama'),
(15, 'bn', 'Bengali/Bangla'),
(16, 'bo', 'Tibetan'),
(17, 'br', 'Breton'),
(18, 'ca', 'Catalan'),
(19, 'co', 'Corsican'),
(20, 'cs', 'Czech'),
(21, 'cy', 'Welsh'),
(22, 'da', 'Danish'),
(23, 'de', 'German'),
(24, 'dz', 'Bhutani'),
(25, 'el', 'Greek'),
(26, 'eo', 'Esperanto'),
(27, 'es', 'Spanish'),
(28, 'et', 'Estonian'),
(29, 'eu', 'Basque'),
(30, 'fa', 'Persian'),
(31, 'fi', 'Finnish'),
(32, 'fj', 'Fiji'),
(33, 'fo', 'Faeroese'),
(34, 'fr', 'French'),
(35, 'fy', 'Frisian'),
(36, 'ga', 'Irish'),
(37, 'gd', 'Scots/Gaelic'),
(38, 'gl', 'Galician'),
(39, 'gn', 'Guarani'),
(40, 'gu', 'Gujarati'),
(41, 'ha', 'Hausa'),
(42, 'hi', 'Hindi'),
(43, 'hr', 'Croatian'),
(44, 'hu', 'Hungarian'),
(45, 'hy', 'Armenian'),
(46, 'ia', 'Interlingua'),
(47, 'ie', 'Interlingue'),
(48, 'ik', 'Inupiak'),
(49, 'in', 'Indonesian'),
(50, 'is', 'Icelandic'),
(51, 'it', 'Italian'),
(52, 'iw', 'Hebrew'),
(53, 'ja', 'Japanese'),
(54, 'ji', 'Yiddish'),
(55, 'jw', 'Javanese'),
(56, 'ka', 'Georgian'),
(57, 'kk', 'Kazakh'),
(58, 'kl', 'Greenlandic'),
(59, 'km', 'Cambodian'),
(60, 'kn', 'Kannada'),
(61, 'ko', 'Korean'),
(62, 'ks', 'Kashmiri'),
(63, 'ku', 'Kurdish'),
(64, 'ky', 'Kirghiz'),
(65, 'la', 'Latin'),
(66, 'ln', 'Lingala'),
(67, 'lo', 'Laothian'),
(68, 'lt', 'Lithuanian'),
(69, 'lv', 'Latvian/Lettish'),
(70, 'mg', 'Malagasy'),
(71, 'mi', 'Maori'),
(72, 'mk', 'Macedonian'),
(73, 'ml', 'Malayalam'),
(74, 'mn', 'Mongolian'),
(75, 'mo', 'Moldavian'),
(76, 'mr', 'Marathi'),
(77, 'ms', 'Malay'),
(78, 'mt', 'Maltese'),
(79, 'my', 'Burmese'),
(80, 'na', 'Nauru'),
(81, 'ne', 'Nepali'),
(82, 'nl', 'Dutch'),
(83, 'no', 'Norwegian'),
(84, 'oc', 'Occitan'),
(85, 'om', '(Afan)/Oromoor/Oriya'),
(86, 'pa', 'Punjabi'),
(87, 'pl', 'Polish'),
(88, 'ps', 'Pashto/Pushto'),
(89, 'pt', 'Portuguese'),
(90, 'qu', 'Quechua'),
(91, 'rm', 'Rhaeto-Romance'),
(92, 'rn', 'Kirundi'),
(93, 'ro', 'Romanian'),
(94, 'ru', 'Russian'),
(95, 'rw', 'Kinyarwanda'),
(96, 'sa', 'Sanskrit'),
(97, 'sd', 'Sindhi'),
(98, 'sg', 'Sangro'),
(99, 'sh', 'Serbo-Croatian'),
(100, 'si', 'Singhalese'),
(101, 'sk', 'Slovak'),
(102, 'sl', 'Slovenian'),
(103, 'sm', 'Samoan'),
(104, 'sn', 'Shona'),
(105, 'so', 'Somali'),
(106, 'sq', 'Albanian'),
(107, 'sr', 'Serbian'),
(108, 'ss', 'Siswati'),
(109, 'st', 'Sesotho'),
(110, 'su', 'Sundanese'),
(111, 'sv', 'Swedish'),
(112, 'sw', 'Swahili'),
(113, 'ta', 'Tamil'),
(114, 'te', 'Telugu'),
(115, 'tg', 'Tajik'),
(116, 'th', 'Thai'),
(117, 'ti', 'Tigrinya'),
(118, 'tk', 'Turkmen'),
(119, 'tl', 'Tagalog'),
(120, 'tn', 'Setswana'),
(121, 'to', 'Tonga'),
(122, 'tr', 'Turkish'),
(123, 'ts', 'Tsonga'),
(124, 'tt', 'Tatar'),
(125, 'tw', 'Twi'),
(126, 'uk', 'Ukrainian'),
(127, 'ur', 'Urdu'),
(128, 'uz', 'Uzbek'),
(129, 'vi', 'Vietnamese'),
(130, 'vo', 'Volapuk'),
(131, 'wo', 'Wolof'),
(132, 'xh', 'Xhosa'),
(133, 'yo', 'Yoruba'),
(134, 'zh', 'Chinese'),
(135, 'zu', 'Zulu');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `ID` int(11) NOT NULL,
  `name` text NOT NULL,
  `parentID` int(11) NOT NULL,
  `link` text NOT NULL,
  `alias` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `moviesdb`
--

CREATE TABLE `moviesdb` (
  `id` int(20) NOT NULL,
  `sid` varchar(50) CHARACTER SET utf8 NOT NULL COMMENT 'ShortLink',
  `idAuthor` int(10) NOT NULL,
  `coAuthors` varchar(1000) CHARACTER SET utf8 DEFAULT NULL,
  `title` varchar(250) CHARACTER SET utf8 NOT NULL,
  `videoAffiliation` varchar(250) CHARACTER SET utf8 NOT NULL COMMENT 'Affiliation an der das Video entstanden ist',
  `furtherReading` varchar(250) CHARACTER SET utf8 DEFAULT NULL,
  `caption` varchar(800) CHARACTER SET utf8 NOT NULL,
  `description` varchar(3000) CHARACTER SET utf8 NOT NULL,
  `category` varchar(256) CHARACTER SET utf8 NOT NULL,
  `subcategory` varchar(256) CHARACTER SET utf8 NOT NULL,
  `altCategory1` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT 'Alternative Kategorie',
  `altSubCategory1` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT 'Alternative Subkategorie',
  `veterinary` tinyint(1) DEFAULT NULL,
  `altVeterinary` tinyint(1) DEFAULT NULL COMMENT 'Flag für die Veterinärmedizin bei den Alternativkategorien',
  `dateOfUpload` int(11) DEFAULT NULL,
  `views` int(10) UNSIGNED DEFAULT NULL,
  `path` varchar(150) CHARACTER SET ascii NOT NULL,
  `ext` varchar(10) NOT NULL,
  `filesize` int(20) NOT NULL,
  `filename_original` varchar(50) CHARACTER SET utf8 NOT NULL,
  `status` int(2) NOT NULL COMMENT '0 = uploaded, 1 = conversion success, 2 = conversion failed',
  `dateOfConversion` varchar(255) NOT NULL,
  `featuredVideo` tinyint(1) DEFAULT NULL COMMENT 'Null - noch nicht präsentiert, 0 - bereits gezeigt, 1 - wird gerade präsentiert',
  `doi` varchar(50) CHARACTER SET utf8 NOT NULL,
  `doiYear` int(4) NOT NULL,
  `language` varchar(10) CHARACTER SET utf8 NOT NULL,
  `closedAccess` tinyint(4) DEFAULT NULL,
  `featured` int(2) NOT NULL DEFAULT '0',
  `public` int(10) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `orderpid`
--

CREATE TABLE `orderpid` (
  `id` int(11) NOT NULL,
  `pid` varchar(255) NOT NULL,
  `idUser` int(11) NOT NULL,
  `contactFirstName` varchar(255) NOT NULL,
  `contactLastName` varchar(255) NOT NULL,
  `billingAffiliation` varchar(255) NOT NULL,
  `billingStreet` varchar(255) NOT NULL,
  `billingStreetNr` varchar(255) NOT NULL,
  `billingCity` varchar(255) NOT NULL,
  `billingPostalCode` varchar(255) NOT NULL,
  `billingCountry` varchar(255) NOT NULL,
  `billingState` varchar(255) NOT NULL,
  `identifierPID` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `contactEMail` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` enum('unpaid','paid','created') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'created'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `paperdb`
--

CREATE TABLE `paperdb` (
  `id` int(20) NOT NULL,
  `sid` varchar(50) CHARACTER SET utf8 NOT NULL COMMENT 'ShortLink',
  `idAuthor` int(10) NOT NULL,
  `coAuthors` varchar(1000) CHARACTER SET utf8 DEFAULT NULL,
  `paperTitle` varchar(250) CHARACTER SET utf8 NOT NULL,
  `paperAffiliation` varchar(250) CHARACTER SET utf8 NOT NULL COMMENT 'Affiliation an der das Poster entstanden ist',
  `furtherReading` varchar(250) CHARACTER SET utf8 DEFAULT NULL,
  `caption` varchar(3000) CHARACTER SET utf8 NOT NULL,
  `description` varchar(3000) CHARACTER SET utf8 NOT NULL,
  `category` varchar(256) CHARACTER SET utf8 NOT NULL,
  `subcategory` varchar(256) CHARACTER SET utf8 NOT NULL,
  `altCategory1` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT 'Alternative Kategorie',
  `altSubCategory1` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT 'Alternative Subkategorie',
  `veterinary` tinyint(1) DEFAULT NULL,
  `altVeterinary` tinyint(1) DEFAULT NULL COMMENT 'Flag für die Veterinärmedizin bei den Alternativkategorien',
  `dateOfUpload` int(11) NOT NULL,
  `views` int(10) UNSIGNED DEFAULT NULL,
  `path` varchar(150) CHARACTER SET ascii NOT NULL,
  `ext` varchar(10) NOT NULL,
  `filesize` int(20) NOT NULL,
  `filename_original` varchar(50) CHARACTER SET utf8 NOT NULL,
  `featuredPaper` tinyint(1) DEFAULT NULL COMMENT 'Null - noch nicht präsentiert, 0 - bereits gezeigt, 1 - wird gerade präsentiert',
  `doi` varchar(50) CHARACTER SET utf8 NOT NULL,
  `doiYear` int(4) NOT NULL,
  `language` varchar(10) CHARACTER SET utf8 NOT NULL,
  `closedAccess` tinyint(4) DEFAULT NULL,
  `featured` int(2) NOT NULL DEFAULT '0',
  `hide` tinyint(4) DEFAULT NULL,
  `public` int(10) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `posterdb`
--

CREATE TABLE `posterdb` (
  `id` int(20) NOT NULL,
  `sid` varchar(50) CHARACTER SET utf8 NOT NULL COMMENT 'ShortLink',
  `idAuthor` int(10) NOT NULL,
  `coAuthors` varchar(1000) CHARACTER SET utf8 DEFAULT NULL,
  `posterTitle` varchar(250) CHARACTER SET utf8 NOT NULL,
  `posterAffiliation` varchar(250) CHARACTER SET utf8 NOT NULL COMMENT 'Affiliation an der das Poster entstanden ist',
  `furtherReading` varchar(250) CHARACTER SET utf8 DEFAULT NULL,
  `caption` varchar(3000) CHARACTER SET utf8 NOT NULL,
  `description` varchar(3000) CHARACTER SET utf8 NOT NULL,
  `category` varchar(256) CHARACTER SET utf8 NOT NULL,
  `subcategory` varchar(256) CHARACTER SET utf8 NOT NULL,
  `altCategory1` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT 'Alternative Kategorie',
  `altSubCategory1` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT 'Alternative Subkategorie',
  `veterinary` tinyint(1) DEFAULT NULL,
  `altVeterinary` tinyint(1) DEFAULT NULL COMMENT 'Flag für die Veterinärmedizin bei den Alternativkategorien',
  `dateOfUpload` int(11) NOT NULL,
  `views` int(10) UNSIGNED DEFAULT NULL,
  `path` varchar(150) CHARACTER SET ascii NOT NULL,
  `ext` varchar(10) NOT NULL,
  `filesize` int(20) NOT NULL,
  `filename_original` varchar(50) CHARACTER SET utf8 NOT NULL,
  `featuredPoster` tinyint(1) DEFAULT NULL COMMENT 'Null - noch nicht präsentiert, 0 - bereits gezeigt, 1 - wird gerade präsentiert',
  `doi` varchar(50) CHARACTER SET utf8 NOT NULL,
  `doiYear` int(4) NOT NULL,
  `language` varchar(10) CHARACTER SET utf8 NOT NULL,
  `closedAccess` tinyint(4) DEFAULT NULL,
  `featured` int(2) NOT NULL DEFAULT '0',
  `public` int(10) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `presentationdb`
--

CREATE TABLE `presentationdb` (
  `id` int(20) NOT NULL,
  `sid` varchar(50) CHARACTER SET utf8 NOT NULL COMMENT 'ShortLink',
  `idAuthor` int(10) NOT NULL,
  `firstName` varchar(150) CHARACTER SET utf8 DEFAULT NULL,
  `lastName` varchar(150) CHARACTER SET utf8 DEFAULT NULL,
  `coAuthors` varchar(1000) CHARACTER SET utf8 DEFAULT NULL,
  `presTitle` varchar(250) CHARACTER SET utf8 NOT NULL,
  `presAffiliation` varchar(250) CHARACTER SET utf8 NOT NULL COMMENT 'Affiliation an der das Poster entstanden ist',
  `furtherReading` varchar(250) CHARACTER SET utf8 DEFAULT NULL,
  `caption` varchar(3000) CHARACTER SET utf8 NOT NULL,
  `description` varchar(3000) CHARACTER SET utf8 NOT NULL,
  `category` varchar(256) CHARACTER SET utf8 NOT NULL,
  `subcategory` varchar(256) CHARACTER SET utf8 NOT NULL,
  `altCategory1` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT 'Alternative Kategorie',
  `altSubCategory1` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT 'Alternative Subkategorie',
  `veterinary` tinyint(1) DEFAULT NULL,
  `altVeterinary` tinyint(1) DEFAULT NULL COMMENT 'Flag für die Veterinärmedizin bei den Alternativkategorien',
  `dateOfUpload` int(11) NOT NULL,
  `views` int(10) UNSIGNED DEFAULT NULL,
  `path` varchar(150) CHARACTER SET ascii NOT NULL,
  `extPDF` varchar(10) NOT NULL,
  `filesizePDF` int(20) NOT NULL,
  `filename_original_PDF` varchar(50) CHARACTER SET utf8 NOT NULL,
  `extPres` varchar(5) CHARACTER SET utf8 DEFAULT NULL,
  `filesizePres` int(20) DEFAULT NULL,
  `filename_original_Pres` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `featuredPres` tinyint(1) DEFAULT NULL COMMENT 'Null - noch nicht präsentiert, 0 - bereits gezeigt, 1 - wird gerade präsentiert',
  `doi` varchar(50) CHARACTER SET utf8 NOT NULL,
  `doiYear` int(4) NOT NULL,
  `language` varchar(10) CHARACTER SET utf8 NOT NULL,
  `closedAccess` tinyint(4) DEFAULT NULL,
  `featured` int(2) NOT NULL DEFAULT '0',
  `public` int(10) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `project_membership`
--

CREATE TABLE `project_membership` (
  `id` int(11) NOT NULL,
  `opprojectUserID` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `identifierPID` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `pid` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `firstName` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `lastName` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `host` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `reminders`
--

CREATE TABLE `reminders` (
  `id` int(10) NOT NULL,
  `email` varchar(100) NOT NULL,
  `sid` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `subcategories`
--

CREATE TABLE `subcategories` (
  `id` int(5) NOT NULL,
  `parent_id` int(5) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `description` varchar(50) CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci;

--
-- Dumping data for table `subcategories`
--

INSERT INTO `subcategories` (`id`, `parent_id`, `name`, `description`) VALUES
(54, 12, 'Algorithms', ''),
(55, 12, 'Artificial intelligence', ''),
(56, 12, 'Computational sciences', ''),
(57, 12, 'Computer architecture', ''),
(58, 12, 'Data structure', ''),
(59, 12, 'Database', ''),
(60, 12, 'Grapics and visualization ', ''),
(61, 12, 'Networks', ''),
(62, 12, 'Security and cryptography', ''),
(63, 12, 'Software engineering', ''),
(64, 13, 'Accounting', ''),
(65, 13, 'Change Management', ''),
(66, 13, 'CSR', ''),
(67, 13, 'Finance', ''),
(68, 13, 'General Management', ''),
(69, 13, 'Human Ressource', ''),
(70, 13, 'Innovation', ''),
(71, 13, 'Marketing', ''),
(72, 13, 'Operational Management', ''),
(73, 13, 'Strategy', ''),
(74, 14, 'Construction Engineering and Architecture', ''),
(75, 14, 'Electrical Engineering', ''),
(76, 14, 'Heat Energy Technology, Thermal Machines, Fluid Mechanics', ''),
(77, 14, 'Materials Engineering', ''),
(78, 14, 'Mechanics and Constructive Mechanical Engineering ', ''),
(79, 14, 'Process Engineering, Technical Chemistry', ''),
(80, 14, 'Production Technology', ''),
(81, 14, 'Systems Engineering', ''),
(82, 15, 'Ancient Cultures', ''),
(83, 15, 'Economics', ''),
(84, 15, 'Education Sciences', ''),
(85, 15, 'Fine Arts, Music, Theater and Media Studies', ''),
(86, 15, 'History', ''),
(87, 15, 'Jurisprudence', ''),
(88, 15, 'Languages', ''),
(89, 15, 'Linguistics', ''),
(90, 15, 'Literary Studies', ''),
(91, 15, 'Philosophy', ''),
(92, 15, 'Psychology', ''),
(93, 15, 'Religious Studies', ''),
(94, 15, 'Social and Cultural Anthropology', ''),
(95, 15, 'Social Sciences', ''),
(96, 15, 'Theology', ''),
(97, 16, 'Agriculture, Forestry, Horticulture', ''),
(98, 16, 'Basic Biological and Medical Research', ''),
(99, 16, 'Medicine', ''),
(100, 16, 'Microbiology, Virology, and Immunology', ''),
(101, 16, 'Neurosciences', ''),
(102, 16, 'Plant Sciences', ''),
(103, 16, 'Veterinary Medicine', ''),
(104, 16, 'Zoology', ''),
(105, 17, 'Anaesthesiology', ''),
(106, 17, 'Biomedical Technology and Medical Physics', ''),
(107, 17, 'Cardiology, Angiology', ''),
(108, 17, 'Cardiothoracic Surgery', ''),
(109, 17, 'Clinical Chemistry and Pathobiochemistry', ''),
(110, 17, 'Dentistry, Oral Surgery', ''),
(111, 17, 'Dermatology', ''),
(112, 17, 'Epidemiology, Medical Biometry, Medical Informatics', ''),
(113, 17, 'Endocrinology, Diabetology', ''),
(114, 17, 'Gastroenterology, Metabolism', ''),
(115, 17, 'Gerontology and Geriatric Medicine', ''),
(116, 17, 'Gynaecology and Obstetrics', ''),
(117, 17, 'Hematology, Oncology, Transfusion Medicine', ''),
(118, 17, 'Human Genetics', ''),
(119, 17, 'Nephrology', ''),
(120, 17, 'Nutritional Sciences', ''),
(121, 17, 'Otolaryngology', ''),
(122, 17, 'Pharmacology', ''),
(123, 17, 'Pharmacy', ''),
(124, 17, 'Pathology and Forensic Medicine', ''),
(125, 17, 'Pediatric and Adolescent Medicine', ''),
(126, 17, 'Physiology', ''),
(127, 17, 'Pneumology, Clinical Infectiology, Intensive Care Medicine', ''),
(128, 17, 'Public Health, Health Services Research, Social Medicine', ''),
(129, 17, 'Radiation Oncology and Radiobiology', ''),
(130, 17, 'Radiology and Nuclear Medicine', ''),
(131, 17, 'Reproductive Medicine/Biology', ''),
(132, 17, 'Rheumatology, Clinical Immunology, Allergology', ''),
(133, 17, 'Toxicology and Occupational Medicine', ''),
(134, 17, 'Traumatology and Orthopaedics', ''),
(135, 17, 'Urology', ''),
(136, 17, 'Vascular and Visceral Surgery', ''),
(137, 18, 'Analytical Chemistry, Method Development (Chemistry)', ''),
(138, 18, 'Astrophysics and Astrononmy', ''),
(139, 18, 'Atmospheric Science and Oceanography', ''),
(140, 18, 'Biological Chemistry and Food Chemistry', ''),
(141, 18, 'Biological Physics', ''),
(142, 18, 'Chemical Solid State and Surface Research', ''),
(143, 18, 'Condensed Matter Physics', ''),
(144, 18, 'Geochemistry, Mineralogy and Crystallography', ''),
(145, 18, 'Geography', ''),
(146, 18, 'Geology and Paleontology', ''),
(147, 18, 'Geophysics and Geodesy', ''),
(148, 18, 'Mathematics', ''),
(149, 18, 'Molecular Chemistry', ''),
(150, 18, 'Nonlinear Dynamics', ''),
(151, 18, 'Optics, Quantum Optics', ''),
(152, 18, 'Particle, Nuclei, and Fields', ''),
(153, 18, 'Physical and Theoretical Chemistry', ''),
(154, 18, 'Physics of Atoms, Molecules and Plasmas', ''),
(155, 18, 'Polymer Research', ''),
(156, 18, 'Statistical Physics, Soft Matter ', ''),
(157, 18, 'Water Research', '');

-- --------------------------------------------------------

--
-- Table structure for table `useraccounts`
--

CREATE TABLE `useraccounts` (
  `id` int(10) NOT NULL,
  `sid` varchar(50) NOT NULL,
  `firstName` text NOT NULL,
  `lastName` text NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `affiliation` varchar(70) NOT NULL,
  `department` varchar(100) DEFAULT NULL,
  `position` varchar(30) NOT NULL,
  `streetNumber` int(10) NOT NULL,
  `address` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `postalCode` varchar(10) NOT NULL,
  `country` varchar(50) NOT NULL,
  `category` varchar(50) NOT NULL,
  `subcategory` varchar(50) NOT NULL,
  `active` int(1) NOT NULL,
  `doiApproved` int(1) NOT NULL,
  `emailApproved` int(20) NOT NULL DEFAULT '1',
  `dateOfRegistration` varchar(10) NOT NULL,
  `autoCreate` int(1) DEFAULT NULL,
  `api_key` varchar(255) DEFAULT NULL,
  `user_op_ID` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `videoqueue`
--

CREATE TABLE `videoqueue` (
  `job_id` int(20) NOT NULL,
  `author_id` int(20) NOT NULL,
  `video_id` int(20) NOT NULL,
  `filesize` int(20) NOT NULL,
  `dateOfUpload` int(11) NOT NULL,
  `conversionStarted` tinyint(1) NOT NULL,
  `mp4_status` tinyint(1) DEFAULT NULL,
  `flv_status` tinyint(1) DEFAULT NULL,
  `webm_status` tinyint(1) DEFAULT NULL,
  `success` tinyint(1) DEFAULT NULL,
  `dateOfConversion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blacklist`
--
ALTER TABLE `blacklist`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ciddb`
--
ALTER TABLE `ciddb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conferences`
--
ALTER TABLE `conferences`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `conferences` ADD FULLTEXT KEY `confTitle` (`confTitle`);
ALTER TABLE `conferences` ADD FULLTEXT KEY `confSeries` (`confSeries`);
ALTER TABLE `conferences` ADD FULLTEXT KEY `confLocation` (`confLocation`);
ALTER TABLE `conferences` ADD FULLTEXT KEY `CID` (`CID`);
ALTER TABLE `conferences` ADD FULLTEXT KEY `abstract` (`abstract`);
ALTER TABLE `conferences` ADD FULLTEXT KEY `LOC` (`LOC`);
ALTER TABLE `conferences` ADD FULLTEXT KEY `SOC` (`SOC`);
ALTER TABLE `conferences` ADD FULLTEXT KEY `keynoteSpeakers` (`keynoteSpeakers`);
ALTER TABLE `conferences` ADD FULLTEXT KEY `venue` (`venue`);
ALTER TABLE `conferences` ADD FULLTEXT KEY `organizingInstitutions` (`organizingInstitutions`);
ALTER TABLE `conferences` ADD FULLTEXT KEY `travelInformation` (`travelInformation`);
ALTER TABLE `conferences` ADD FULLTEXT KEY `venue_2` (`venue`);
ALTER TABLE `conferences` ADD FULLTEXT KEY `abstract_2` (`abstract`);
ALTER TABLE `conferences` ADD FULLTEXT KEY `confTitle_2` (`confTitle`);

--
-- Indexes for table `conference_abstracts`
--
ALTER TABLE `conference_abstracts`
  ADD UNIQUE KEY `ID` (`ID`);

--
-- Indexes for table `conference_abstractsubmissiontool`
--
ALTER TABLE `conference_abstractsubmissiontool`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conference_elements`
--
ALTER TABLE `conference_elements`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `conference_loc`
--
ALTER TABLE `conference_loc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conference_permissions`
--
ALTER TABLE `conference_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conference_registrations`
--
ALTER TABLE `conference_registrations`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `conference_registrationtool`
--
ALTER TABLE `conference_registrationtool`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conference_sessions`
--
ALTER TABLE `conference_sessions`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `domain_blacklist`
--
ALTER TABLE `domain_blacklist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `keyword_blacklist`
--
ALTER TABLE `keyword_blacklist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `moviesdb`
--
ALTER TABLE `moviesdb`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `moviesdb` ADD FULLTEXT KEY `coAuthors` (`coAuthors`,`title`,`furtherReading`,`caption`,`description`);
ALTER TABLE `moviesdb` ADD FULLTEXT KEY `videoAffiliation` (`videoAffiliation`);

--
-- Indexes for table `orderpid`
--
ALTER TABLE `orderpid`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `paperdb`
--
ALTER TABLE `paperdb`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `paperdb` ADD FULLTEXT KEY `coAuthors` (`coAuthors`,`paperTitle`,`furtherReading`,`caption`,`description`);
ALTER TABLE `paperdb` ADD FULLTEXT KEY `videoAffiliation` (`paperAffiliation`);
ALTER TABLE `paperdb` ADD FULLTEXT KEY `paperTitle` (`paperTitle`);
ALTER TABLE `paperdb` ADD FULLTEXT KEY `paperAffiliation` (`paperAffiliation`);
ALTER TABLE `paperdb` ADD FULLTEXT KEY `furtherReading` (`furtherReading`);
ALTER TABLE `paperdb` ADD FULLTEXT KEY `caption` (`caption`);

--
-- Indexes for table `posterdb`
--
ALTER TABLE `posterdb`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `posterdb` ADD FULLTEXT KEY `coAuthors` (`coAuthors`,`posterTitle`,`furtherReading`,`caption`,`description`);
ALTER TABLE `posterdb` ADD FULLTEXT KEY `videoAffiliation` (`posterAffiliation`);

--
-- Indexes for table `presentationdb`
--
ALTER TABLE `presentationdb`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `presentationdb` ADD FULLTEXT KEY `coAuthors` (`coAuthors`,`presTitle`,`furtherReading`,`caption`,`description`);
ALTER TABLE `presentationdb` ADD FULLTEXT KEY `videoAffiliation` (`presAffiliation`);
ALTER TABLE `presentationdb` ADD FULLTEXT KEY `firstName` (`firstName`,`lastName`);

--
-- Indexes for table `project_membership`
--
ALTER TABLE `project_membership`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reminders`
--
ALTER TABLE `reminders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `useraccounts`
--
ALTER TABLE `useraccounts`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `useraccounts` ADD FULLTEXT KEY `Names` (`firstName`,`lastName`);
ALTER TABLE `useraccounts` ADD FULLTEXT KEY `affiliation` (`affiliation`);

--
-- Indexes for table `videoqueue`
--
ALTER TABLE `videoqueue`
  ADD PRIMARY KEY (`job_id`),
  ADD UNIQUE KEY `video_id` (`video_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banner`
--
ALTER TABLE `banner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blacklist`
--
ALTER TABLE `blacklist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `ciddb`
--
ALTER TABLE `ciddb`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT for table `conferences`
--
ALTER TABLE `conferences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT for table `conference_abstracts`
--
ALTER TABLE `conference_abstracts`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `conference_abstractsubmissiontool`
--
ALTER TABLE `conference_abstractsubmissiontool`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `conference_elements`
--
ALTER TABLE `conference_elements`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `conference_loc`
--
ALTER TABLE `conference_loc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conference_permissions`
--
ALTER TABLE `conference_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `conference_registrations`
--
ALTER TABLE `conference_registrations`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `conference_registrationtool`
--
ALTER TABLE `conference_registrationtool`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `conference_sessions`
--
ALTER TABLE `conference_sessions`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `domain_blacklist`
--
ALTER TABLE `domain_blacklist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `keyword_blacklist`
--
ALTER TABLE `keyword_blacklist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `moviesdb`
--
ALTER TABLE `moviesdb`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=331;

--
-- AUTO_INCREMENT for table `orderpid`
--
ALTER TABLE `orderpid`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `paperdb`
--
ALTER TABLE `paperdb`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1200;

--
-- AUTO_INCREMENT for table `posterdb`
--
ALTER TABLE `posterdb`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- AUTO_INCREMENT for table `presentationdb`
--
ALTER TABLE `presentationdb`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=458;

--
-- AUTO_INCREMENT for table `project_membership`
--
ALTER TABLE `project_membership`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `reminders`
--
ALTER TABLE `reminders`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=158;

--
-- AUTO_INCREMENT for table `useraccounts`
--
ALTER TABLE `useraccounts`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1035;

--
-- AUTO_INCREMENT for table `videoqueue`
--
ALTER TABLE `videoqueue`
  MODIFY `job_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
