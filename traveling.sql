-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 19, 2024 at 09:05 PM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `traveling`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

DROP TABLE IF EXISTS `bookings`;
CREATE TABLE IF NOT EXISTS `bookings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `persons` int DEFAULT NULL,
  `children` int DEFAULT NULL,
  `booking_date` date DEFAULT NULL,
  `package_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_data`
--

DROP TABLE IF EXISTS `contact_data`;
CREATE TABLE IF NOT EXISTS `contact_data` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `message` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

DROP TABLE IF EXISTS `packages`;
CREATE TABLE IF NOT EXISTS `packages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `price` decimal(10,2) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `name`, `description`, `price`, `image_url`) VALUES
(1, 'Sri Lanka Package', 'Discover the unparalleled beauty of Sri Lanka with our amazing package. Explore the stunning beaches of Mirissa, go on a thrilling safari in Yala National Park, and immerse yourself in the ancient city of Anuradhapura. You\'ll be captivated by the rich culture and history of this island paradise. Our comprehensive package includes comfortable accommodations, expert-guided tours, delicious cuisine, and much more, all for an affordable price of just $1500. Book now and embark on a journey to experience the wonders of Sri Lanka!', '1541.00', 'img/sl5.jpg'),
(2, 'Korea Package', 'Uncover the wonders of Korea with our exclusive package. Wander through the bustling streets of Seoul, visit historic treasures like Gyeongbokgung, and savor the delightful flavors of Korean cuisine. Your adventure continues as you explore the breathtaking landscapes of Jeju Island, known for its volcanic beauty. Our package includes comfortable accommodations, immersive local experiences, and much more, all for just $1700. Reserve your spot now and embark on a journey through the heart of Korea!', '1750.00', 'img/p1.jpg'),
(3, 'Japan Package', 'Experience the rich culture and beauty of Japan with our enchanting package. Dive into the modern marvels of Tokyo, explore Kyoto\'s ancient temples and serene gardens, and soak in the natural splendor of Hokkaido. Delight in delectable sushi and savory ramen, and witness the grace of traditional tea ceremonies. Our comprehensive package includes comfortable accommodations, expert-guided tours, and much more, all for just $1800. Secure your journey now and immerse yourself in the magic of Japan!', '1800.00', 'img/p4.jpg'),
(4, 'Paris Package', 'Indulge in the romance of Paris with our exquisite package. Visit iconic landmarks such as the Eiffel Tower, explore the world-famous Louvre Museum, and leisurely stroll along the picturesque Seine River. Savor gourmet cuisine and experience the enchanting atmosphere of the City of Love. Our comprehensive package includes accommodation at charming Parisian hotels, expert-guided tours, and much more, all for just $2000. Reserve your dream journey now and create unforgettable memories in the heart of Paris!', '2000.00', 'img/p2.jpg'),
(6, 'package', 'ggg', '200.00', 'img/j2.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'Vihanga@2001', '2001');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
