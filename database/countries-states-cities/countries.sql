-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 25, 2016 at 12:21 PM
-- Server version: 5.7.13-0ubuntu0.16.04.2
-- PHP Version: 7.0.8-0ubuntu0.16.04.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `alpha`
--

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS countries;

CREATE TABLE `countries` (
  `id` int(10) UNSIGNED NOT NULL,
  `shortname` varchar(3) NOT NULL,
  `name` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `shortname`, `name`) VALUES
(1, 'XX', 'None'),
(2, 'AF', 'Afghanistan'),
(3, 'AL', 'Albania'),
(4, 'DZ', 'Algeria'),
(5, 'AS', 'American Samoa'),
(6, 'AD', 'Andorra'),
(7, 'AO', 'Angola'),
(8, 'AI', 'Anguilla'),
(9, 'AQ', 'Antarctica'),
(10, 'AG', 'Antigua And Barbuda'),
(11, 'AR', 'Argentina'),
(12, 'AM', 'Armenia'),
(13, 'AW', 'Aruba'),
(14, 'AU', 'Australia'),
(15, 'AT', 'Austria'),
(16, 'AZ', 'Azerbaijan'),
(17, 'BS', 'Bahamas The'),
(18, 'BH', 'Bahrain'),
(19, 'BD', 'Bangladesh'),
(20, 'BB', 'Barbados'),
(21, 'BY', 'Belarus'),
(22, 'BE', 'Belgium'),
(23, 'BZ', 'Belize'),
(24, 'BJ', 'Benin'),
(25, 'BM', 'Bermuda'),
(26, 'BT', 'Bhutan'),
(27, 'BO', 'Bolivia'),
(28, 'BA', 'Bosnia and Herzegovina'),
(29, 'BW', 'Botswana'),
(30, 'BV', 'Bouvet Island'),
(31, 'BR', 'Brazil'),
(32, 'IO', 'British Indian Ocean Territory'),
(33, 'BN', 'Brunei'),
(34, 'BG', 'Bulgaria'),
(35, 'BF', 'Burkina Faso'),
(36, 'BI', 'Burundi'),
(37, 'KH', 'Cambodia'),
(38, 'CM', 'Cameroon'),
(39, 'CA', 'Canada'),
(40, 'CV', 'Cape Verde'),
(41, 'KY', 'Cayman Islands'),
(42, 'CF', 'Central African Republic'),
(43, 'TD', 'Chad'),
(44, 'CL', 'Chile'),
(45, 'CN', 'China'),
(46, 'CX', 'Christmas Island'),
(47, 'CC', 'Cocos (Keeling) Islands'),
(48, 'CO', 'Colombia'),
(49, 'KM', 'Comoros'),
(50, 'CG', 'Congo'),
(51, 'CD', 'Congo The Democratic Republic Of The'),
(52, 'CK', 'Cook Islands'),
(53, 'CR', 'Costa Rica'),
(54, 'CI', 'Cote D\'Ivoire (Ivory Coast)'),
(55, 'HR', 'Croatia (Hrvatska)'),
(56, 'CU', 'Cuba'),
(57, 'CY', 'Cyprus'),
(58, 'CZ', 'Czech Republic'),
(59, 'DK', 'Denmark'),
(60, 'DJ', 'Djibouti'),
(61, 'DM', 'Dominica'),
(62, 'DO', 'Dominican Republic'),
(63, 'TP', 'East Timor'),
(64, 'EC', 'Ecuador'),
(65, 'EG', 'Egypt'),
(66, 'SV', 'El Salvador'),
(67, 'GQ', 'Equatorial Guinea'),
(68, 'ER', 'Eritrea'),
(69, 'EE', 'Estonia'),
(70, 'ET', 'Ethiopia'),
(71, 'XA', 'External Territories of Australia'),
(72, 'FK', 'Falkland Islands'),
(73, 'FO', 'Faroe Islands'),
(74, 'FJ', 'Fiji Islands'),
(75, 'FI', 'Finland'),
(76, 'FR', 'France'),
(77, 'GF', 'French Guiana'),
(78, 'PF', 'French Polynesia'),
(79, 'TF', 'French Southern Territories'),
(80, 'GA', 'Gabon'),
(81, 'GM', 'Gambia The'),
(82, 'GE', 'Georgia'),
(83, 'DE', 'Germany'),
(84, 'GH', 'Ghana'),
(85, 'GI', 'Gibraltar'),
(86, 'GR', 'Greece'),
(87, 'GL', 'Greenland'),
(88, 'GD', 'Grenada'),
(89, 'GP', 'Guadeloupe'),
(90, 'GU', 'Guam'),
(91, 'GT', 'Guatemala'),
(92, 'XU', 'Guernsey and Alderney'),
(93, 'GN', 'Guinea'),
(94, 'GW', 'Guinea-Bissau'),
(95, 'GY', 'Guyana'),
(96, 'HT', 'Haiti'),
(97, 'HM', 'Heard and McDonald Islands'),
(98, 'HN', 'Honduras'),
(99, 'HK', 'Hong Kong S.A.R.'),
(100, 'HU', 'Hungary'),
(101, 'IS', 'Iceland'),
(102, 'IN', 'India'),
(103, 'ID', 'Indonesia'),
(104, 'IR', 'Iran'),
(105, 'IQ', 'Iraq'),
(106, 'IE', 'Ireland'),
(107, 'IL', 'Israel'),
(108, 'IT', 'Italy'),
(109, 'JM', 'Jamaica'),
(110, 'JP', 'Japan'),
(111, 'XJ', 'Jersey'),
(112, 'JO', 'Jordan'),
(113, 'KZ', 'Kazakhstan'),
(114, 'KE', 'Kenya'),
(115, 'KI', 'Kiribati'),
(116, 'KP', 'Korea North'),
(117, 'KR', 'Korea South'),
(118, 'KW', 'Kuwait'),
(119, 'KG', 'Kyrgyzstan'),
(120, 'LA', 'Laos'),
(121, 'LV', 'Latvia'),
(122, 'LB', 'Lebanon'),
(123, 'LS', 'Lesotho'),
(124, 'LR', 'Liberia'),
(125, 'LY', 'Libya'),
(126, 'LI', 'Liechtenstein'),
(127, 'LT', 'Lithuania'),
(128, 'LU', 'Luxembourg'),
(129, 'MO', 'Macau S.A.R.'),
(130, 'MK', 'Macedonia'),
(131, 'MG', 'Madagascar'),
(132, 'MW', 'Malawi'),
(133, 'MY', 'Malaysia'),
(134, 'MV', 'Maldives'),
(135, 'ML', 'Mali'),
(136, 'MT', 'Malta'),
(137, 'XM', 'Man (Isle of)'),
(138, 'MH', 'Marshall Islands'),
(139, 'MQ', 'Martinique'),
(140, 'MR', 'Mauritania'),
(141, 'MU', 'Mauritius'),
(142, 'YT', 'Mayotte'),
(143, 'MX', 'Mexico'),
(144, 'FM', 'Micronesia'),
(145, 'MD', 'Moldova'),
(146, 'MC', 'Monaco'),
(147, 'MN', 'Mongolia'),
(148, 'MS', 'Montserrat'),
(149, 'MA', 'Morocco'),
(150, 'MZ', 'Mozambique'),
(151, 'MM', 'Myanmar'),
(152, 'NA', 'Namibia'),
(153, 'NR', 'Nauru'),
(154, 'NP', 'Nepal'),
(155, 'AN', 'Netherlands Antilles'),
(156, 'NL', 'Netherlands The'),
(157, 'NC', 'New Caledonia'),
(158, 'NZ', 'New Zealand'),
(159, 'NI', 'Nicaragua'),
(160, 'NE', 'Niger'),
(161, 'NG', 'Nigeria'),
(162, 'NU', 'Niue'),
(163, 'NF', 'Norfolk Island'),
(164, 'MP', 'Northern Mariana Islands'),
(165, 'NO', 'Norway'),
(166, 'OM', 'Oman'),
(167, 'PK', 'Pakistan'),
(168, 'PW', 'Palau'),
(169, 'PS', 'Palestinian Territory Occupied'),
(170, 'PA', 'Panama'),
(171, 'PG', 'Papua new Guinea'),
(172, 'PY', 'Paraguay'),
(173, 'PE', 'Peru'),
(174, 'PH', 'Philippines'),
(175, 'PN', 'Pitcairn Island'),
(176, 'PL', 'Poland'),
(177, 'PT', 'Portugal'),
(178, 'PR', 'Puerto Rico'),
(179, 'QA', 'Qatar'),
(180, 'RE', 'Reunion'),
(181, 'RO', 'Romania'),
(182, 'RU', 'Russia'),
(183, 'RW', 'Rwanda'),
(184, 'SH', 'Saint Helena'),
(185, 'KN', 'Saint Kitts And Nevis'),
(186, 'LC', 'Saint Lucia'),
(187, 'PM', 'Saint Pierre and Miquelon'),
(188, 'VC', 'Saint Vincent And The Grenadines'),
(189, 'WS', 'Samoa'),
(190, 'SM', 'San Marino'),
(191, 'ST', 'Sao Tome and Principe'),
(192, 'SA', 'Saudi Arabia'),
(193, 'SN', 'Senegal'),
(194, 'RS', 'Serbia'),
(195, 'SC', 'Seychelles'),
(196, 'SL', 'Sierra Leone'),
(197, 'SG', 'Singapore'),
(198, 'SK', 'Slovakia'),
(199, 'SI', 'Slovenia'),
(200, 'XG', 'Smaller Territories of the UK'),
(201, 'SB', 'Solomon Islands'),
(202, 'SO', 'Somalia'),
(203, 'ZA', 'South Africa'),
(204, 'GS', 'South Georgia'),
(205, 'SS', 'South Sudan'),
(206, 'ES', 'Spain'),
(207, 'LK', 'Sri Lanka'),
(208, 'SD', 'Sudan'),
(209, 'SR', 'Suriname'),
(210, 'SJ', 'Svalbard And Jan Mayen Islands'),
(211, 'SZ', 'Swaziland'),
(212, 'SE', 'Sweden'),
(213, 'CH', 'Switzerland'),
(214, 'SY', 'Syria'),
(215, 'TW', 'Taiwan'),
(216, 'TJ', 'Tajikistan'),
(217, 'TZ', 'Tanzania'),
(218, 'TH', 'Thailand'),
(219, 'TG', 'Togo'),
(220, 'TK', 'Tokelau'),
(221, 'TO', 'Tonga'),
(222, 'TT', 'Trinidad And Tobago'),
(223, 'TN', 'Tunisia'),
(224, 'TR', 'Turkey'),
(225, 'TM', 'Turkmenistan'),
(226, 'TC', 'Turks And Caicos Islands'),
(227, 'TV', 'Tuvalu'),
(228, 'UG', 'Uganda'),
(229, 'UA', 'Ukraine'),
(230, 'AE', 'United Arab Emirates'),
(231, 'GB', 'United Kingdom'),
(232, 'US', 'United States'),
(233, 'UM', 'United States Minor Outlying Islands'),
(234, 'UY', 'Uruguay'),
(235, 'UZ', 'Uzbekistan'),
(236, 'VU', 'Vanuatu'),
(237, 'VA', 'Vatican City State (Holy See)'),
(238, 'VE', 'Venezuela'),
(239, 'VN', 'Vietnam'),
(240, 'VG', 'Virgin Islands (British)'),
(241, 'VI', 'Virgin Islands (US)'),
(242, 'WF', 'Wallis And Futuna Islands'),
(243, 'EH', 'Western Sahara'),
(244, 'YE', 'Yemen'),
(245, 'YU', 'Yugoslavia'),
(246, 'ZM', 'Zambia'),
(247, 'ZW', 'Zimbabwe');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=257;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
