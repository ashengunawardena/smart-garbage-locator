-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 03, 2019 at 07:54 AM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sgl`
--

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `heading` varchar(100) NOT NULL,
  `content` varchar(4000) DEFAULT NULL,
  `submitDate` datetime DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `heading`, `content`, `submitDate`, `username`) VALUES
(36, 'Article on Garbage Collection', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque a nibh non sem viverra viverra. Integer non rhoncus turpis. Sed et quam nulla. In pulvinar tortor ut blandit pellentesque. Mauris dignissim, mauris a suscipit tempus, lorem eros gravida diam, non elementum tortor arcu sit amet elit. Pellentesque nec arcu porta, tincidunt magna vitae, mollis arcu. Aliquam quis dolor viverra, aliquet ipsum non, placerat ipsum. Aenean quis fringilla purus. Cras consequat nisl ullamcorper augue finibus, nec scelerisque justo cursus. Ut malesuada placerat lacus, quis lacinia quam finibus eget. Sed euismod lectus nec orci accumsan, eget auctor quam faucibus. Vivamus ligula leo, congue nec pharetra vel, aliquet et purus. Sed ac lacus mauris. Nam malesuada mauris quam, quis mattis nunc eleifend sed. Nulla sed augue eu nibh pellentesque dignissim ut aliquam mauris. Duis auctor augue justo, eget sagittis neque venenatis a. Proin tincidunt dictum suscipit. Integer eu neque congue, hendrerit diam id, dictum arcu. Phasellus congue commodo est, ut maximus nisl convallis non. In in fringilla urna. Sed gravida est massa, a volutpat purus ultricies ut. Curabitur hendrerit faucibus tortor, sit amet pulvinar ex tempor consequat. Sed posuere aliquam odio eu iaculis. Cras auctor cursus blandit. Proin fermentum nibh sem, ac auctor dui aliquet eu. In consequat semper leo eget suscipit. Maecenas interdum bibendum tincidunt. Quisque a est eu lorem facilisis hendrerit. In viverra libero nec diam laoreet congue. Ut congue nulla vitae ornare luctus. Proin sed mauris dictum, dictum tellus eget, luctus ipsum. Donec porttitor placerat quam, sit amet mollis sem accumsan sodales. Sed a tincidunt lacus. Praesent id neque sit amet nulla imperdiet vestibulum. Pellentesque vel nulla in lectus gravida vehicula vitae at sapien. Phasellus dictum massa quis urna mattis, at pretium massa dignissim. Pellentesque ultrices diam a augue tristique, non pellentesque ex faucibus. Fusce ligula tellus, pretium vel dui sit amet, consequat tincidunt ipsum. Nullam lectus ipsum, faucibus eget mi at, gravida gravida risus. Praesent euismod, urna vitae ullamcorper convallis, dolor ipsum vestibulum velit, et mollis nisi purus ac arcu. Ut feugiat metus in risus pharetra imperdiet. Aliquam gravida dolor at orci condimentum laoreet. Pellentesque accumsan aliquet ex, nec laoreet tortor sagittis a. Mauris vitae risus sit amet odio bibendum efficitur ac id orci. Fusce augue risus, elementum a nisi vel, hendrerit cursus urna. Etiam lacinia rhoncus sapien in egestas. Curabitur venenatis orci diam, ac efficitur neque euismod sit amet. Mauris consequat libero et aliquam lobortis. Praesent urna ante, congue eu sem viverra, pulvinar molestie tortor. Sed ullamcorper dolor quis imperdiet vestibulum. Mauris pulvinar congue lectus aliquet consequat. Sed ipsum ex, euismod et eros sed, malesuada faucibus massa. Phasellus venenatis viverra ex, eu luctus erat aliquet id. Fusce commodo molestie pellentesque. Mauris ante quam, tristique vel fermentum sed, rutrum sit amet urna. In hac habitasse platea dictumst. Praesent eu mauris molestie, imperdiet lacus nec, suscipit sem. Curabitur sollicitudin posuere elit, eu tincidunt sapien laoreet ut. Vestibulum eget quam nibh.', '2018-12-31 05:09:52', 'Ashen Gunwardena'),
(40, 'Towards a green environment', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque a nibh non sem viverra viverra. Integer non rhoncus turpis. Sed et quam nulla. In pulvinar tortor ut blandit pellentesque. Mauris dignissim, mauris a suscipit tempus, lorem eros gravida diam, non elementum tortor arcu sit amet elit. Pellentesque nec arcu porta, tincidunt magna vitae, mollis arcu. Aliquam quis dolor viverra, aliquet ipsum non, placerat ipsum. Aenean quis fringilla purus. Cras consequat nisl ullamcorper augue finibus, nec scelerisque justo cursus. Ut malesuada placerat lacus, quis lacinia quam finibus eget. Sed euismod lectus nec orci accumsan, eget auctor quam faucibus. Vivamus ligula leo, congue nec pharetra vel, aliquet et purus. Sed ac lacus mauris. Nam malesuada mauris quam, quis mattis nunc eleifend sed. Nulla sed augue eu nibh pellentesque dignissim ut aliquam mauris. Duis auctor augue justo, eget sagittis neque venenatis a. Proin tincidunt dictum suscipit. Integer eu neque congue, hendrerit diam id, dictum arcu. Phasellus congue commodo est, ut maximus nisl convallis non. In in fringilla urna. Sed gravida est massa, a volutpat purus ultricies ut. Curabitur hendrerit faucibus tortor, sit amet pulvinar ex tempor consequat. Sed posuere aliquam odio eu iaculis. Cras auctor cursus blandit. Proin fermentum nibh sem, ac auctor dui aliquet eu. In consequat semper leo eget suscipit. Maecenas interdum bibendum tincidunt. Quisque a est eu lorem facilisis hendrerit. In viverra libero nec diam laoreet congue. Ut congue nulla vitae ornare luctus. Proin sed mauris dictum, dictum tellus eget, luctus ipsum. Donec porttitor placerat quam, sit amet mollis sem accumsan sodales. Sed a tincidunt lacus. Praesent id neque sit amet nulla imperdiet vestibulum. Pellentesque vel nulla in lectus gravida vehicula vitae at sapien. Phasellus dictum massa quis urna mattis, at pretium massa dignissim. Pellentesque ultrices diam a augue tristique, non pellentesque ex faucibus. Fusce ligula tellus, pretium vel dui sit amet, consequat tincidunt ipsum. Nullam lectus ipsum, faucibus eget mi at, gravida gravida risus. Praesent euismod, urna vitae ullamcorper convallis, dolor ipsum vestibulum velit, et mollis nisi purus ac arcu. Ut feugiat metus in risus pharetra imperdiet. Aliquam gravida dolor at orci condimentum laoreet. Pellentesque accumsan aliquet ex, nec laoreet tortor sagittis a. Mauris vitae risus sit amet odio bibendum efficitur ac id orci. Fusce augue risus, elementum a nisi vel, hendrerit cursus urna. Etiam lacinia rhoncus sapien in egestas. Curabitur venenatis orci diam, ac efficitur neque euismod sit amet. Mauris consequat libero et aliquam lobortis. Praesent urna ante, congue eu sem viverra, pulvinar molestie tortor. Sed ullamcorper dolor quis imperdiet vestibulum. Mauris pulvinar congue lectus aliquet consequat. Sed ipsum ex, euismod et eros sed, malesuada faucibus massa. Phasellus venenatis viverra ex, eu luctus erat aliquet id. Fusce commodo molestie pellentesque. Mauris ante quam, tristique vel fermentum sed, rutrum sit amet urna. In hac habitasse platea dictumst. Praesent eu mauris molestie, imperdiet lacus nec, suscipit sem. Curabitur sollicitudin posuere elit, eu tincidunt sapien laoreet ut. Vestibulum eget quam nibh.', '2019-01-01 02:19:44', 'Ashen Gunwardena');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `GoogleID` varchar(150) DEFAULT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(50) DEFAULT NULL,
  `Fname` varchar(20) DEFAULT NULL,
  `Lname` varchar(30) DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `isAdmin` int(11) DEFAULT NULL,
  `isManager` int(11) DEFAULT NULL,
  `isStaff` int(11) DEFAULT NULL,
  `sendMail` int(11) DEFAULT NULL,
  `imageLocation` varchar(300) DEFAULT NULL,
  `dateJoined` date DEFAULT NULL,
  `noReports` int(11) DEFAULT '0',
  `lastLogin` datetime DEFAULT NULL,
  `lastLogout` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`GoogleID`, `Username`, `Password`, `Fname`, `Lname`, `Email`, `isAdmin`, `isManager`, `isStaff`, `sendMail`, `imageLocation`, `dateJoined`, `noReports`, `lastLogin`, `lastLogout`) VALUES
('102452053552533725657', 'Ashen', '$1$XgER5723$zjoFzv6oIMiQX/h7xtl/G1', 'Ashen', 'Gunwardena', 'smartgarbagelocator2@gmail.com', 1, NULL, NULL, NULL, '', '2017-12-28', 18, '2019-01-03 11:23:33', '2019-01-03 11:24:20'),
(NULL, 'ashmini321', '$1$XgER5723$AqqEzYkaQWGyudc1KtVqk0', 'Ashmini', 'Liyanage', 'liyanage321@gmail.com', NULL, NULL, NULL, NULL, NULL, '2019-01-03', 1, '2019-01-03 11:14:17', '2019-01-03 11:15:43'),
(NULL, 'dinesh321', '$1$XgER5723$AqqEzYkaQWGyudc1KtVqk0', 'Dinesh', 'Amarathunga', 'dineshamara321@gmail.com', NULL, NULL, 1, NULL, NULL, '2019-01-03', 0, '2019-01-03 11:24:34', '2019-01-03 11:23:27'),
('106040507348339451078', 'wasanthi halpe', '$1$XgER5723$VWnltwBPloHlUaCAA4oKK1', 'wasanthi', 'halpe', 'wasanthihalpe@gmail.com', NULL, 1, NULL, NULL, 'https://lh5.googleusercontent.com/-q_UzIrqqYfk/AAAAAAAAAAI/AAAAAAAAAAA/AKxrwcbZ_qonsaq6wcb-wKC0aLydelwzgw/s96-c/photo.jpg', '2019-01-03', 0, '2019-01-03 11:22:30', '2019-01-03 11:22:39');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `image1` varchar(100) DEFAULT NULL,
  `image2` varchar(100) DEFAULT NULL,
  `image3` varchar(100) DEFAULT NULL,
  `image4` varchar(100) DEFAULT NULL,
  `image5` varchar(100) DEFAULT NULL,
  `description` varchar(2000) DEFAULT NULL,
  `coordinates` varchar(60) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `submitDate` datetime DEFAULT NULL,
  `isApproved` int(11) DEFAULT '0',
  `profilePicLoc` varchar(100) DEFAULT NULL,
  `imageCount` int(11) DEFAULT NULL,
  `flagColor` varchar(10) DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`image1`, `image2`, `image3`, `image4`, `image5`, `description`, `coordinates`, `username`, `submitDate`, `isApproved`, `profilePicLoc`, `imageCount`, `flagColor`, `id`) VALUES
('GarbageLocations/garbage image 1.jpg', 'GarbageLocations/garbage image 2.jpg', 'GarbageLocations/garbage image 3.jpg', NULL, NULL, 'This garbage has been around for about 2 days, also it makes the surrounding very stinky this attracts many dogs and crows. Please kindly remove this garbage as soon as possible. ', '6.795170939,80.003805041', 'Ashmini Liyanage', '2019-01-03 11:14:39', 1, 'ProfileImages/defaultPic.jpg', 3, 'red', 46),
('GarbageLocations/garbage image 4.jpg', 'GarbageLocations/garbage image 5.jpg', 'GarbageLocations/garbage image 6.jpg', 'GarbageLocations/garbage image 7.jpg', 'GarbageLocations/garbage image 8.jpg', 'This garbage location attracts a lot of dogs and crows, also it makes my neighborhood very smelly. Please remove this garbage soon.', '6.893343258,79.902181506', 'Ashen Gunwardena', '2019-01-03 11:18:07', 0, 'ProfileImages/defaultPic.jpg', 5, NULL, 47);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `heading` (`heading`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`Username`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
