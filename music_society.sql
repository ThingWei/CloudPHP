-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2024 at 11:25 PM
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
-- Database: `music_society`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `adminName` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `adminPw` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adminName`, `email`, `adminPw`) VALUES
('Jeffery Hussain', 'jeffery@gmail.com', '$2y$10$WUMWQWQmR2F8CGt0noEUberECOh6gbptEUilmydwcPaWqB5UlnH4q'),
('Abel Kaw', 'missabel1995@yahoo.com', '$2y$10$Yc8eQmedCXItpDIp9261bOv32/6pCFkQG.yT/dCzxNOC/RyYqx5wS'),
('Nur Siti Modh', 'nursiti@gmail.com', '$2y$10$JiWBbknOlyPS48ItuRTRPOPK14v4as.ml.s19MR8BOfvofYH4niKy'),
('Tan Seng Hui', 'tansh@hotmail.com', '$2y$10$iH/8alYAmx4wMPR4oOfA.O8G8.nC5M.BSuURrLWm6FUUXI4F/ZWIq');

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `eventName` varchar(50) NOT NULL,
  `headline` varchar(300) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `eventBanner` varchar(200) NOT NULL,
  `dateOfEvent` varchar(20) NOT NULL,
  `time` varchar(12) NOT NULL,
  `location` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`eventName`, `headline`, `description`, `eventBanner`, `dateOfEvent`, `time`, `location`) VALUES
('Jazz Day Festival', 'Join Us for an Electrifying day of Jazz, where smooth melodies and soulful rhythms collide in a mesmerizing fusion of sound!', 'Our Rizzy Tempo Music Society is thrilled <br>\r\n                        to announce the upcoming Jazz Day Festival,<br>\r\n                        a celebration of the rich heritage and vibrant spirit of jazz music.<br>\r\n                        Mark your calendars for <b>12 MARCH 2024</b> as we prepare to immerse ourselves in the melodious\r\n                        rhythms and soulful melodies that define this beloved genre.\r\n                        The Jazz Day Festival promises an unforgettable experience for music enthusiasts of all ages.\r\n                        Whether you\'re a seasoned jazz aficionado or a newcomer eager to explore the genre,\r\n                        there\'s something for everyone at this event.', 'img/event1.jpg', '2024-06-15', '8pm - 10pm', 'Loft 29'),
('Karaoke Compensation', 'Join Us for a musical fun, where you can unleash your inner superstar and create unforgettable memories with fellow music lovers!', 'Join us for a celebration of music, talent, and camaraderie at the Karaoke Competition Festival,\r\n                        hosted by Rizzy Tempo Music Society! Whether you\'re a seasoned karaoke aficionado or someone who\r\n                        loves to sing just for fun, this festival is your opportunity to shine on stage and showcase\r\n                        your vocal prowess.', 'img/event6.jpg', '2024-07-15', '8pm - 10pm', 'Dewan Sri Pinang'),
('Karaoke Party', 'Come and Sing Along with your best buddies around you.', 'Come and Join Us as we discover all the hidden angelic voices that has been hiding their potential! ', 'img/karaokeparty.jpg', '2024-08-15', '6PM - 10PM', 'Music Clubhouse'),
('Retro Music Festival', 'Relive the magic of bygone eras with nostalgic tunes, funky beats and a vintage of atmosphere that will bring you to another decade!', 'Get ready to travel back in time and groove to the timeless beats of yesteryears at the Retro\r\n                        Music Festival, brought to you by Rizzy Tempo Music Society! <br>\r\n                        Immerse yourself in the nostalgic melodies, vibrant rhythms, and unforgettable vibes of the past\r\n                        as we celebrate the golden era of music.', 'img/event5.jpg', '2025-03-10', '8PM - 10PM', 'Loft 29'),
('Rock Festival', 'Experience a high-energy showcase featuring unforgettable vibes that will have u rocking all day all night!', 'Get ready to rock out at the most electrifying event of the year!\r\n                        The Rizzy Tempo Music Society proudly presents its highly anticipated Rock Festival,\r\n                        a celebration of raw energy, pulsating rhythms, and unforgettable melodies.<br>\r\n                        Join us as we pay homage to the legends of rock music and showcase the incredible talents within\r\n                        our music society.<br>\r\n                        From classic anthems to modern hits, this festival promises an eclectic mix of genres that will\r\n                        have you headbanging and air guitaring all night long.', 'img/event4.jpg', '2024-05-23', '8PM - 10PM', 'Esplande');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `rating` int(1) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `description` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`rating`, `username`, `email`, `description`) VALUES
(5, 'wenghin', 'wenghin@gmail.com', 'ok good i will continue buy from here soon'),
(3, 'wenghin', 'wenghin@gmail.com', 'good good'),
(4, 'Xiao Wei', 'tswei@yahoo.com', 'nice website i love u 💑 but no me like de event');

-- --------------------------------------------------------

--
-- Table structure for table `jazz_day_festival`
--

CREATE TABLE `jazz_day_festival` (
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `gender` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jazz_day_festival`
--

INSERT INTO `jazz_day_festival` (`username`, `email`, `gender`) VALUES
('Xiao Wei', 'tswei@yahoo.com', 'F');

-- --------------------------------------------------------

--
-- Table structure for table `karaoke_compensation`
--

CREATE TABLE `karaoke_compensation` (
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `gender` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `karaoke_compensation`
--

INSERT INTO `karaoke_compensation` (`username`, `email`, `gender`) VALUES
('Nimbo', 'nimbo@gmail.com', 'M');

-- --------------------------------------------------------

--
-- Table structure for table `karaoke_party`
--

CREATE TABLE `karaoke_party` (
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `gender` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `email` varchar(30) NOT NULL,
  `eventName` varchar(50) NOT NULL,
  `ticketType` varchar(30) NOT NULL,
  `price` decimal(6,2) NOT NULL,
  `cardNumber` varchar(21) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`email`, `eventName`, `ticketType`, `price`, `cardNumber`) VALUES
('wenghin@gmail.com', 'Rock Festival', 'VIP Ticket', 38.50, '4848100022223333'),
('wenghin@gmail.com', 'Karaoke Compensation', 'Standard Ticket', 20.00, '1234123412341234'),
('tswei@yahoo.com', 'Retro Music Festival', 'VIP Ticket', 35.00, '4848100098761234'),
('tswei@yahoo.com', 'Jazz Day Festival', 'VVVIP Ticket', 90.00, '1231231231231231'),
('nimbo@gmail.com', 'Retro Music Festival', 'VIP Ticket', 35.00, '1818292930304959'),
('nimbo@gmail.com', 'Karaoke Compensation', 'Standard Ticket', 20.00, '1234567890111213'),
('nimbo@gmail.com', 'Retro Music Festival', 'Standard Ticket', 16.50, '1234567890111213');

-- --------------------------------------------------------

--
-- Table structure for table `receipt`
--

CREATE TABLE `receipt` (
  `email` varchar(50) NOT NULL,
  `eventName` varchar(50) NOT NULL,
  `ticketType` varchar(50) NOT NULL,
  `price` decimal(6,2) NOT NULL,
  `date` varchar(20) NOT NULL,
  `time` varchar(12) NOT NULL,
  `location` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `receipt`
--

INSERT INTO `receipt` (`email`, `eventName`, `ticketType`, `price`, `date`, `time`, `location`) VALUES
('wenghin@gmail.com', 'Rock Festival', 'VIP Ticket', 38.50, '2024-05-23', '8PM - 10PM', 'Esplande'),
('wenghin@gmail.com', 'Karaoke Compensation', 'Standard Ticket', 20.00, '2024-07-15', '8pm - 10pm', 'Dewan Sri Pinang'),
('tswei@yahoo.com', 'Retro Music Festival', 'VIP Ticket', 35.00, '2025-03-10', '8PM - 10PM', 'Loft 29'),
('tswei@yahoo.com', 'Jazz Day Festival', 'VVVIP Ticket', 90.00, '2024-06-15', '8pm - 10pm', 'Loft 29'),
('nimbo@gmail.com', 'Retro Music Festival', 'VIP Ticket', 35.00, '2025-03-10', '8PM - 10PM', 'Loft 29'),
('nimbo@gmail.com', 'Karaoke Compensation', 'Standard Ticket', 20.00, '2024-07-15', '8pm - 10pm', 'Dewan Sri Pinang'),
('nimbo@gmail.com', 'Retro Music Festival', 'Standard Ticket', 16.50, '2025-03-10', '8PM - 10PM', 'Loft 29');

-- --------------------------------------------------------

--
-- Table structure for table `retro_music_festival`
--

CREATE TABLE `retro_music_festival` (
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `gender` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `retro_music_festival`
--

INSERT INTO `retro_music_festival` (`username`, `email`, `gender`) VALUES
('Xiao Wei', 'tswei@yahoo.com', 'F'),
('Nimbo', 'nimbo@gmail.com', 'M'),
('Nimbo', 'nimbo@gmail.com', 'M');

-- --------------------------------------------------------

--
-- Table structure for table `rock_festival`
--

CREATE TABLE `rock_festival` (
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `gender` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rock_festival`
--

INSERT INTO `rock_festival` (`username`, `email`, `gender`) VALUES
('wenghin', 'wenghin@gmail.com', 'M');

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE `ticket` (
  `eventTicketName` varchar(50) NOT NULL,
  `ticketType` varchar(50) NOT NULL,
  `price` decimal(6,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ticket`
--

INSERT INTO `ticket` (`eventTicketName`, `ticketType`, `price`) VALUES
('Karaoke Compensation', 'Standard Ticket', 20.00),
('Retro Music Festival', 'Standard Ticket', 16.50),
('Rock Festival', 'Standard Ticket', 20.00),
('Retro Music Festival', 'VIP Ticket', 35.00),
('Rock Festival', 'VIP Ticket', 38.50),
('Jazz Day Festival', 'VVVIP Ticket', 90.00),
('Karaoke Party', 'Standard Ticket', 20.00);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `gender` char(1) NOT NULL,
  `userPw` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `email`, `gender`, `userPw`) VALUES
('Ah Beng', 'ahbeng@hotmail.com', 'M', '$2y$10$h97ME9OIsMiof9AXhOPQIOa/JetTtFvpZDjOd1T6veMAo63M/CPQ6'),
('Ke Xing', 'kexing123@gmail.com', 'F', '$2y$10$N8.dtQsTTjaxCUtMQNp5lOeF8sZAj8xE5JO17WvuRNQzfuLRyT2pO'),
('Liu Gou', 'liugou@gmail.com', 'F', '$2y$10$8MwZUJylzVnSfD6/cB1en.bGrkedXm8zKBsl4fmUZSf3FeChknFS.'),
('Nimbo', 'nimbo@gmail.com', 'M', '$2y$10$Zq8fh8OjxPjBompUjOL8heM./u4YcY8eIxXgfACVXGQ1JJy6KoPwm'),
('Xiao Wei', 'tswei@yahoo.com', 'F', '$2y$10$HfFuuIzlry5fpLt2c5KqJOukbCbWaIepaj9tEwjkoKs64FfarHujS'),
('Weng Hin', 'wenghin@gmail.com', 'M', '$2y$10$PQWxLBrGHMLyR.eJg3fsR.0NoX9UgBlvUqlSum1BLFFDej/OsalW6');

-- --------------------------------------------------------

--
-- Table structure for table `volunteer`
--

CREATE TABLE `volunteer` (
  `username` varchar(50) NOT NULL,
  `gender` char(1) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `volunteer`
--

INSERT INTO `volunteer` (`username`, `gender`, `email`) VALUES
('Xiao Wei', 'F', 'tswei@yahoo.com'),
('Weng Hin', 'M', 'wenghin@gmail.com'),
('Nimbo', 'M', 'nimbo@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`eventName`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD KEY `email` (`email`);

--
-- Indexes for table `jazz_day_festival`
--
ALTER TABLE `jazz_day_festival`
  ADD KEY `email` (`email`);

--
-- Indexes for table `karaoke_compensation`
--
ALTER TABLE `karaoke_compensation`
  ADD KEY `email` (`email`);

--
-- Indexes for table `karaoke_party`
--
ALTER TABLE `karaoke_party`
  ADD KEY `email` (`email`);

--
-- Indexes for table `receipt`
--
ALTER TABLE `receipt`
  ADD KEY `eventName` (`eventName`),
  ADD KEY `email` (`email`);

--
-- Indexes for table `retro_music_festival`
--
ALTER TABLE `retro_music_festival`
  ADD KEY `email` (`email`);

--
-- Indexes for table `rock_festival`
--
ALTER TABLE `rock_festival`
  ADD KEY `email` (`email`);

--
-- Indexes for table `ticket`
--
ALTER TABLE `ticket`
  ADD KEY `idx_ticket_event` (`eventTicketName`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `volunteer`
--
ALTER TABLE `volunteer`
  ADD KEY `email` (`email`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`email`) REFERENCES `user` (`email`);

--
-- Constraints for table `jazz_day_festival`
--
ALTER TABLE `jazz_day_festival`
  ADD CONSTRAINT `jazz_day_festival_ibfk_1` FOREIGN KEY (`email`) REFERENCES `user` (`email`);

--
-- Constraints for table `karaoke_compensation`
--
ALTER TABLE `karaoke_compensation`
  ADD CONSTRAINT `karaoke_compensation_ibfk_1` FOREIGN KEY (`email`) REFERENCES `user` (`email`),
  ADD CONSTRAINT `karaoke_compensation_ibfk_2` FOREIGN KEY (`email`) REFERENCES `user` (`email`);

--
-- Constraints for table `karaoke_party`
--
ALTER TABLE `karaoke_party`
  ADD CONSTRAINT `karaoke_party_ibfk_1` FOREIGN KEY (`email`) REFERENCES `user` (`email`);

--
-- Constraints for table `receipt`
--
ALTER TABLE `receipt`
  ADD CONSTRAINT `receipt_ibfk_1` FOREIGN KEY (`eventName`) REFERENCES `event` (`eventName`),
  ADD CONSTRAINT `receipt_ibfk_2` FOREIGN KEY (`email`) REFERENCES `user` (`email`);

--
-- Constraints for table `retro_music_festival`
--
ALTER TABLE `retro_music_festival`
  ADD CONSTRAINT `retro_music_festival_ibfk_1` FOREIGN KEY (`email`) REFERENCES `user` (`email`);

--
-- Constraints for table `rock_festival`
--
ALTER TABLE `rock_festival`
  ADD CONSTRAINT `rock_festival_ibfk_1` FOREIGN KEY (`email`) REFERENCES `user` (`email`);

--
-- Constraints for table `ticket`
--
ALTER TABLE `ticket`
  ADD CONSTRAINT `idx_ticket_event` FOREIGN KEY (`eventTicketName`) REFERENCES `event` (`eventName`),
  ADD CONSTRAINT `ticket_ibfk_1` FOREIGN KEY (`eventTicketName`) REFERENCES `event` (`eventName`);

--
-- Constraints for table `volunteer`
--
ALTER TABLE `volunteer`
  ADD CONSTRAINT `volunteer_ibfk_1` FOREIGN KEY (`email`) REFERENCES `user` (`email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
