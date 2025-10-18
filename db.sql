-- InvestKosovo Hub Database Schema
-- MySQL Script

CREATE DATABASE IF NOT EXISTS investkosovo;
USE investkosovo;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 18, 2025 at 01:42 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `investkosovo`
--

-- --------------------------------------------------------

--
-- Table structure for table `analytics_data`
--

CREATE TABLE `analytics_data` (
  `data_id` int(11) NOT NULL,
  `sector_id` int(11) DEFAULT NULL,
  `source` varchar(100) DEFAULT NULL,
  `data_type` varchar(100) DEFAULT NULL,
  `value` decimal(10,2) NOT NULL,
  `year` year(4) NOT NULL,
  `region` varchar(100) DEFAULT NULL,
  `fetched_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cms_content`
--

CREATE TABLE `cms_content` (
  `content_id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `slug` varchar(150) DEFAULT NULL,
  `content` text NOT NULL,
  `type` enum('news','report','legal','guide') NOT NULL,
  `published_at` datetime DEFAULT current_timestamp(),
  `author_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `company_profiles`
--

CREATE TABLE `company_profiles` (
  `company_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(150) NOT NULL,
  `size` enum('micro','small','medium','large') NOT NULL,
  `investment_type` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `company_profiles`
--

INSERT INTO `company_profiles` (`company_id`, `user_id`, `name`, `size`, `investment_type`, `location`, `created_at`) VALUES
(1, 7, 'Rar', 'large', 'Private Equity', 'https://www.youtubr.com', '2025-05-25 20:54:19'),
(2, 1, 'urf6', 'large', 'Angel Investing', 'https://www.y8.com', '2025-07-30 09:56:48');

-- --------------------------------------------------------

--
-- Table structure for table `incentives`
--

CREATE TABLE `incentives` (
  `incentive_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `sector_id` int(11) DEFAULT NULL,
  `eligibility_criteria` text NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `investment_opportunities`
--

CREATE TABLE `investment_opportunities` (
  `opportunity_id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `sector_id` int(11) DEFAULT NULL,
  `capital_min` decimal(15,2) NOT NULL,
  `capital_max` decimal(15,2) NOT NULL,
  `risk_level` enum('low','medium','high') NOT NULL,
  `timeline_months` int(11) NOT NULL,
  `description` text NOT NULL,
  `contact_email` varchar(150) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `money_raised` decimal(15,2) DEFAULT 0.00,
  `goal` decimal(15,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `investment_opportunities`
--

INSERT INTO `investment_opportunities` (`opportunity_id`, `title`, `sector_id`, `capital_min`, `capital_max`, `risk_level`, `timeline_months`, `description`, `contact_email`, `created_at`, `money_raised`, `goal`) VALUES
(1, 'Kosovo Tech Hub Development', 1, 150000.00, 500000.00, '', 36, 'Kosovo Tech Hub Development is a visionary project aimed at creating a vibrant, innovation-driven ecosystem in Pristina, Kosovo\'s capital. This initiative focuses on establishing a co-working space and startup accelerator that supports local tech entrepreneurs and connects them to global markets.', 'gashi.1rron@gmail.com', '2025-05-24 15:52:15', 0.00, 0.00),
(2, 'Bajgora Wind Farm Expansion', 2, 8000000.00, 12000000.00, '', 48, 'Kosovo is rich in natural resources, including water, wind, and solar potential. The country aims to increase renewable energy capacity to 35% of electricity consumption by 2031. Notable projects include the Bajgora Wind Farm (102.6 MW) and the Kitka Wind Farm (32.4 MW). The government is also promoting solar energy initiatives, such as JAHA Solar, the first producer of solar panels in the Western Balkans.', 'ilir.berisha@example.com', '2025-05-24 15:52:15', 0.00, 0.00),
(3, 'Prizren Eco-Resort & Cultural Center', 3, 1200000.00, 2500000.00, '', 30, 'Kosovo\'s rich cultural heritage and natural landscapes offer significant potential for tourism development. Destinations like Peja, Prizren, and the Brezovica ski resort attract visitors interested in hiking, cultural experiences, and winter sports. Investments in hospitality, tour operations, and infrastructure can capitalize on this growing sector.', 'asddsad@gmail.commmmmmmmmmmmm', '2025-05-24 15:52:15', 0.00, 0.00),
(4, 'Organic Food Processing Plant (Ferizaj)', 4, 500000.00, 1000000.00, '', 24, 'Agriculture remains a cornerstone of Kosovo\'s economy, with fertile land suitable for cultivating cereals, fruits, and vegetables. Investments in modern farming techniques, organic produce, and food processing can enhance value chains and meet both local and export market demands.', 'asihbahafhdlahsbgk@ufvaoufgsid.net', '2025-05-24 15:52:15', 0.00, 0.00),
(5, 'Private Specialty Clinic (Orthopedics)', 5, 350000.00, 750000.00, '', 18, 'There is a growing demand for quality healthcare services in Kosovo, with many citizens seeking medical care abroad. This gap presents opportunities for investment in private hospitals, clinics, and specialized medical services. The government has been encouraging private-sector involvement to meet this demand.', 'asdlhjvgfkasdvfj@mileniumi3.net', '2025-05-24 15:52:15', 0.00, 0.00),
(6, 'fdshkifldjks', 1, 10000000000.00, 1.00, '', 1, 'DAHGSAGFIL', 'gashi.1rron@gmail.com', '2025-05-25 16:22:13', 0.00, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `leads`
--

CREATE TABLE `leads` (
  `lead_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `source` varchar(100) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `status` enum('new','contacted','closed') DEFAULT 'new',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `legal_frameworks`
--

CREATE TABLE `legal_frameworks` (
  `legal_id` int(11) NOT NULL,
  `country` varchar(100) NOT NULL,
  `sector_id` int(11) DEFAULT NULL,
  `tax_summary` text NOT NULL,
  `investment_procedures` text NOT NULL,
  `legal_notes` text DEFAULT NULL,
  `updated_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `location_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `type` enum('tech_park','industrial_zone','renewable_site','financial_center') NOT NULL,
  `latitude` decimal(10,6) NOT NULL,
  `longitude` decimal(10,6) NOT NULL,
  `infrastructure` text DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sectors`
--

CREATE TABLE `sectors` (
  `sector_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sectors`
--

INSERT INTO `sectors` (`sector_id`, `name`, `description`) VALUES
(1, 'ICT', 'The project aims to bridge the digital and business skills gap in a sustainable way that meets the needs of the market and increases the competitiveness of Kosovo’s digital and traditional businesses and to increase the export of Kosovar ICT and traditional businesses through the use of ICT.'),
(2, 'Renewable Energy', 'Kosovo is putting its energy sector on a sustainable path through investing in and developing its renewable energy potential, improving energy efficiency, and moving toward a decarbonized energy future.'),
(3, 'Tourism', 'Kosovo is an emerging tourist destination in the Balkans, offering a blend of cultural, historical, and natural attractions. It\'s experiencing a growth in tourism, with foreign visitor numbers increasing year after year. The country boasts a rich heritage, including archaeological sites, ancient religious buildings, and diverse landscapes like mountains and waterfalls.'),
(4, 'Agriculture & Processing', 'Based on the activities of agricultural businesses for 2022, the activity of processing food products led with a turnover of 490.2 million. €, followed by the beverage production activity, with a turnover of 156.5 million. €, crop and animal production activity, hunting and related services with a turnover of 92.3 mil.'),
(5, 'Healthcare Services', 'Kosovo\'s healthcare system is structured into three levels: primary, secondary, and tertiary. Primary care in Pristina is provided through Family Medicine Centers and Ambulatory Care Units, while secondary care is decentralized in Regional Hospitals, Wikipedia. Pristina utilizes the University Clinical Center of Kosovo for some secondary care services'),
(6, 'gegedsfsdf', 'grdthygfmtyubjkug,'),
(7, 'usdhkdufsakdhuifsa', 'gfddgfgdf'),
(8, 'ireaygcs8ny', 'oumsifdbixzklij');

-- --------------------------------------------------------

--
-- Table structure for table `success_stories`
--

CREATE TABLE `success_stories` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` between 0 and 5)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `success_stories`
--

INSERT INTO `success_stories` (`id`, `user_id`, `title`, `description`, `rating`) VALUES
(1, 1, '', '\"Kosovo\'s organic agriculture sector is a hidden gem. We\'ve been able to source premium raw materials at competitive prices for our European markets.\"', 5),
(2, 2, '', '\"This website is terrific!\"', 5);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `user_type` enum('investor','admin','expert') DEFAULT 'investor',
  `created_at` datetime DEFAULT current_timestamp(),
  `last_login` datetime DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `total_value` decimal(50,2) DEFAULT NULL,
  `total_invested` decimal(50,2) NOT NULL,
  `risk_profile` varchar(50) DEFAULT NULL,
  `investments_made` int(11) DEFAULT 0,
  `email_verified` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `full_name`, `email`, `password_hash`, `user_type`, `created_at`, `last_login`, `address`, `phone`, `city`, `country`, `profile_picture`, `total_value`, `total_invested`, `risk_profile`, `investments_made`, `email_verified`) VALUES
(1, 'Rron Gashi', 'gashi.1rron@gmail.com', '$2y$10$2kK/YQd2WIYy70DvmJcCuOTh2iyec6aA.fSEhnh8ZkyGmX5DsIsJa', 'admin', '2025-05-24 20:00:13', '2025-05-25 16:17:28', 'nanannnsanhfdsukavsd', '+38349976412', 'Pristina', 'Kosovo', 'uploads/profile_1.gif', 0.01, 11000100000000000000000000.00, NULL, 0, 0),
(2, 'Arben Gashi', 'gashibeni@gmail.com', '$2y$10$7HbxAMGryD.i0OWFx2iIQ.ux5VofsWR77/tu4LDxRlMsay0m7Thpu', 'admin', '2025-05-25 16:34:08', NULL, '', '+38344138747', 'Prishtina', 'Montenegro', 'images.jpg', 0.00, 321582387.00, NULL, 0, 0),
(7, 'q q', 'q@q.q', '$2y$10$SMRXRHn25G3JC2x.oCgw4utcwARDBCGwCXaU8YuNOnkaYOsQXbyg6', 'investor', '2025-05-25 20:46:51', NULL, NULL, NULL, NULL, 'Switzerland', NULL, 0.00, 34.00, NULL, 0, 0),
(8, 'Arben Gashi', 'ilir.berisha@example.com', '$2y$10$fxzVk24MldhVYLfQ20ssqe0D5qmWw5VzOtrmf4EkwuZP/ph6fan.O', 'expert', '2025-05-25 23:18:18', NULL, '', '', '', 'Montenegro', NULL, 0.00, 0.00, NULL, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `analytics_data`
--
ALTER TABLE `analytics_data`
  ADD PRIMARY KEY (`data_id`),
  ADD KEY `sector_id` (`sector_id`);

--
-- Indexes for table `cms_content`
--
ALTER TABLE `cms_content`
  ADD PRIMARY KEY (`content_id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `author_id` (`author_id`);

--
-- Indexes for table `company_profiles`
--
ALTER TABLE `company_profiles`
  ADD PRIMARY KEY (`company_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `incentives`
--
ALTER TABLE `incentives`
  ADD PRIMARY KEY (`incentive_id`),
  ADD KEY `sector_id` (`sector_id`);

--
-- Indexes for table `investment_opportunities`
--
ALTER TABLE `investment_opportunities`
  ADD PRIMARY KEY (`opportunity_id`),
  ADD KEY `sector_id` (`sector_id`);

--
-- Indexes for table `leads`
--
ALTER TABLE `leads`
  ADD PRIMARY KEY (`lead_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `legal_frameworks`
--
ALTER TABLE `legal_frameworks`
  ADD PRIMARY KEY (`legal_id`),
  ADD KEY `sector_id` (`sector_id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`location_id`);

--
-- Indexes for table `sectors`
--
ALTER TABLE `sectors`
  ADD PRIMARY KEY (`sector_id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `success_stories`
--
ALTER TABLE `success_stories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `analytics_data`
--
ALTER TABLE `analytics_data`
  MODIFY `data_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cms_content`
--
ALTER TABLE `cms_content`
  MODIFY `content_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company_profiles`
--
ALTER TABLE `company_profiles`
  MODIFY `company_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `incentives`
--
ALTER TABLE `incentives`
  MODIFY `incentive_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `investment_opportunities`
--
ALTER TABLE `investment_opportunities`
  MODIFY `opportunity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `leads`
--
ALTER TABLE `leads`
  MODIFY `lead_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `legal_frameworks`
--
ALTER TABLE `legal_frameworks`
  MODIFY `legal_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `location_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sectors`
--
ALTER TABLE `sectors`
  MODIFY `sector_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `success_stories`
--
ALTER TABLE `success_stories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `analytics_data`
--
ALTER TABLE `analytics_data`
  ADD CONSTRAINT `analytics_data_ibfk_1` FOREIGN KEY (`sector_id`) REFERENCES `sectors` (`sector_id`);

--
-- Constraints for table `cms_content`
--
ALTER TABLE `cms_content`
  ADD CONSTRAINT `cms_content_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `company_profiles`
--
ALTER TABLE `company_profiles`
  ADD CONSTRAINT `company_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `incentives`
--
ALTER TABLE `incentives`
  ADD CONSTRAINT `incentives_ibfk_1` FOREIGN KEY (`sector_id`) REFERENCES `sectors` (`sector_id`);

--
-- Constraints for table `investment_opportunities`
--
ALTER TABLE `investment_opportunities`
  ADD CONSTRAINT `investment_opportunities_ibfk_1` FOREIGN KEY (`sector_id`) REFERENCES `sectors` (`sector_id`);

--
-- Constraints for table `leads`
--
ALTER TABLE `leads`
  ADD CONSTRAINT `leads_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `legal_frameworks`
--
ALTER TABLE `legal_frameworks`
  ADD CONSTRAINT `legal_frameworks_ibfk_1` FOREIGN KEY (`sector_id`) REFERENCES `sectors` (`sector_id`);

--
-- Constraints for table `success_stories`
--
ALTER TABLE `success_stories`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
