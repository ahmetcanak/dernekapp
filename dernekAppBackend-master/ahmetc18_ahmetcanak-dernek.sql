-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 01, 2020 at 09:54 AM
-- Server version: 10.2.26-MariaDB-cll-lve
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `okanirtis_dernek_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `authorized_list`
--

CREATE TABLE `authorized_list` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `surname` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL,
  `added_time` int(11) NOT NULL,
  `authorize_id` int(3) NOT NULL,
  `isDeleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `authorized_list`
--

INSERT INTO `authorized_list` (`id`, `name`, `surname`, `email`, `password`, `added_time`, `authorize_id`, `isDeleted`) VALUES
(1, 'Emre', 'Altınok', 'admin@admin.com', '0c7540eb7e65b553ec1ba6b20de79608', 0, 2, 0),
(2, 'deneme', 'deneme', 'deneme@deneme.com', '255895924b7f143746de137806197271', 1587951451, 1, 1),
(3, 'deneme2', 'deneme2', 'deneme@deneme.com', '255895924b7f143746de137806197271', 1587952168, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `authorize_list`
--

CREATE TABLE `authorize_list` (
  `id` int(11) NOT NULL,
  `authorize_name` varchar(128) NOT NULL,
  `export_data` int(1) NOT NULL,
  `send_notification` int(1) NOT NULL,
  `show_logs` int(1) NOT NULL,
  `show_statistics` int(1) NOT NULL,
  `add_news` int(1) NOT NULL COMMENT '1 or 0',
  `delete_news` int(1) NOT NULL,
  `add_user` int(1) NOT NULL,
  `delete_user` int(1) NOT NULL,
  `add_category` int(1) NOT NULL,
  `delete_category` int(1) NOT NULL,
  `read_messages` int(1) NOT NULL,
  `delete_messages` int(1) NOT NULL,
  `add_auth` int(1) NOT NULL,
  `delete_auth` int(1) NOT NULL,
  `add_auth_user` int(1) NOT NULL,
  `delete_auth_user` int(1) NOT NULL,
  `added_time` int(11) NOT NULL,
  `isDeleted` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `authorize_list`
--

INSERT INTO `authorize_list` (`id`, `authorize_name`, `export_data`, `send_notification`, `show_logs`, `show_statistics`, `add_news`, `delete_news`, `add_user`, `delete_user`, `add_category`, `delete_category`, `read_messages`, `delete_messages`, `add_auth`, `delete_auth`, `add_auth_user`, `delete_auth_user`, `added_time`, `isDeleted`) VALUES
(1, 'Yetkisiz', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(2, 'Yönetici', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0),
(8, 'Editör', 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1587956881, 0);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(64) NOT NULL,
  `added_time` int(11) NOT NULL,
  `isDeleted` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `added_time`, `isDeleted`) VALUES
(1, 'kategori 1', 0, 1),
(2, 'kategori 2', 0, 0),
(3, 'kategori 3', 0, 0),
(4, 'kategori 4', 0, 0),
(5, 'kategori 5', 0, 0),
(7, 'deneme', 1587217530, 0),
(8, 'deneme2', 1587217535, 0);

-- --------------------------------------------------------

--
-- Table structure for table `children_list`
--

CREATE TABLE `children_list` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `name` varchar(128) DEFAULT NULL,
  `surname` text DEFAULT NULL,
  `birth_date` int(11) DEFAULT NULL,
  `marital_status` varchar(24) DEFAULT NULL,
  `job` varchar(128) DEFAULT NULL,
  `blood_group` varchar(12) DEFAULT NULL,
  `education_status` varchar(32) DEFAULT NULL,
  `phone_number` varchar(64) DEFAULT NULL,
  `isDeleted` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `children_list`
--

INSERT INTO `children_list` (`id`, `parent_id`, `name`, `surname`, `birth_date`, `marital_status`, `job`, `blood_group`, `education_status`, `phone_number`, `isDeleted`) VALUES
(1, 17, 'Bayram', 'Alaçam', 123343132, 'Bekar', 'Yazılımcı', '0+', 'İlkokul', '555554433', 1),
(2, 17, 'Emre3', 'Altınok', 1232121212, 'Bekar', 'Öyle böyle işler', '0+', 'Hayat Okulu', '1232121212', 1),
(3, 17, 'Emre2', 'Altınok2', 199212323, 'Bekar', 'Öyle böyle işler', '0+', 'Doktora', '1232121212', 1),
(4, 17, 'Emre3', 'Altınok', 1232121212, 'Bekar', 'Öyle böyle işler', '0+', 'Hayat Okulu', '1232121212', 1),
(5, 17, 'Emre2', 'Altınok2', 199212323, 'Bekar', 'Öyle böyle işler', '0+', 'Doktora', '1232121212', 1),
(6, 17, 'Emre3', 'Altınok', 1232121212, 'Bekar', 'Öyle böyle işler', '0+', 'Hayat Okulu', '1232121212', 1),
(7, 17, 'Emre2', 'Altınok2', 199212323, 'Bekar', 'Öyle böyle işler', '0+', 'Doktora', '1232121212', 1),
(8, 17, 'Emre3', 'Altınok', 910130400, 'Bekar', 'Öyle böyle işler', '0+', 'Hayat Okulu', '1232121212', 1),
(9, 17, 'Emre2', 'Altınok2', 946677600, 'Bekar', 'Öyle böyle işler', '0+', 'Doktora', '1232121212', 1),
(10, 17, 'Emre3', 'Altınok', 910130400, 'Bekar', 'Öyle böyle işler', '0+', 'İlkokul', '1232121212', 1),
(11, 17, 'Emre2', 'Altınok2', 946677600, 'Bekar', 'Öyle böyle işler', '0+', 'Doktora', '1232121212', 1),
(12, 17, 'emre32', 'emre3223', 2147483647, 'Bekar', 'Yok', 'Bilinmiyor', 'İlkokul', '4324234234', 1),
(13, 17, 'Emre3', 'Altınok', 910130400, 'Bekar', 'Öyle böyle işler', '0+', 'İlkokul', '1232121212', 1),
(14, 17, 'Emre2', 'Altınok2', 946677600, 'Bekar', 'Öyle böyle işler', '0+', 'Doktora', '1232121212', 1),
(15, 17, 'emre32', 'emre3223', 2147483647, 'Bekar', 'Yok', 'Bilinmiyor', 'İlkokul', '4324234234', 1),
(16, 17, 'Emre3', 'Altınok', 910130400, 'Bekar', 'Öyle böyle işler', '0+', 'İlkokul', '1232121212', 1),
(17, 17, 'Emre2', 'Altınok2', 946677600, 'Bekar', 'Öyle böyle işler', '0+', 'Doktora', '1232121212', 1),
(18, 17, 'emre32', 'emre3223', 2147461200, 'Evli', 'Yok', 'Bilinmiyor', 'İlkokul', '4324234234', 1),
(19, 17, 'Emre3', 'Altınok', 910130400, 'Bekar', 'Öyle böyle işler', '0+', 'İlkokul', '1232121212', 1),
(20, 17, 'Emre2', 'Altınok2', 946677600, 'Bekar', 'Öyle böyle işler', '0+', 'Doktora', '1232121212', 1),
(21, 17, 'emre32', 'emre3223', 2147461200, 'Evli', 'Yok', 'Bilinmiyor', 'İlkokul', '4324234234', 1),
(22, 17, 'Emre3', 'Altınok', 910130400, 'Bekar', 'Öyle böyle işler', '0+', 'İlkokul', '1232121212', 0),
(23, 17, 'Emre2', 'Altınok2', 946677600, 'Bekar', 'Öyle böyle işler', '0+', 'Doktora', '1232121212', 0),
(24, 17, 'emre32', 'emre3223', 2147461200, 'Evli', 'Yok', 'Bilinmiyor', 'İlkokul', '4324234234', 0),
(25, 26, 'Emirhan', 'Alaçam', 1587934800, 'Bekar', 'Elektrik', '0+', 'Lise', '4433323434', 1),
(26, 26, 'Emirhan', 'Alaçam', 1587934800, 'Bekar', 'Elektronik', 'B+', 'Lise', '4535454544', 1),
(27, 26, 'Emirhan', 'Alaçam', 1587934800, 'Bekar', 'Elektronik', 'B+', 'Lise', '4535454544', 1),
(28, 26, 'Emirhans', 'Alaçam', 1587934800, 'Bekar', 'Elektronik', 'B+', 'Lise', '4535454544', 1),
(29, 26, 'Emirhans', 'Alaçam', 1587934800, 'Bekar', 'Elektronik', 'B+', 'Lise', '4535454544', 1),
(30, 26, 'Emirhans', 'Alaçam', 1587934800, 'Bekar', 'Elektronik', 'B+', 'Lise', '4535454544', 1),
(31, 26, 'Emirhans', 'Alaçam', 1587934800, 'Bekar', 'Elektronik', 'B+', 'Lise', '4535454544', 0),
(32, 26, 'Emre', 'Altınok', 1587934800, 'Bekar', 'Yazılım', 'AB-', 'Önlisans', '4535345345', 0);

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `log_date` int(11) NOT NULL,
  `log_text` text NOT NULL,
  `log_user_id` int(11) NOT NULL,
  `isDeleted` int(1) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `log_date`, `log_text`, `log_user_id`, `isDeleted`) VALUES
(1, 123344322, '{USER_INFO}, hesabına giriş yaptı.', 1, 0),
(2, 213394322, '{USER_INFO}, 37 numaralı haberi ekledi.', 1, 0),
(3, 223394322, '{USER_INFO}, 37 numaralı haberi düzenledi.', 1, 0),
(4, 323394322, '{USER_INFO}, çıkış yaptı.', 1, 0),
(5, 323394322, '{USER_INFO}, 2 numaralı kategoriyi ekledi.', 1, 0),
(6, 1586263107, '{USER_INFO}, hesabına giriş yaptı.', 1, 0),
(7, 1586441090, '{USER_INFO}, hesabına giriş yaptı.', 1, 0),
(8, 1586441210, '{USER_INFO}, hesabına giriş yaptı.', 1, 0),
(9, 1586445438, '{USER_INFO}, hesabına giriş yaptı.', 1, 0),
(10, 1586445901, '{USER_INFO}, çıkış yaptı.', 1, 0),
(11, 1586445914, '{USER_INFO}, giriş yaptı.', 1, 0),
(12, 1586462989, '{USER_INFO}, giriş yaptı.', 1, 0),
(13, 1586472313, '{USER_INFO}, #421 numaralı haberi sildi.', 1, 0),
(14, 1586472316, '{USER_INFO}, #420 numaralı haberi sildi.', 1, 0),
(15, 1586472325, '{USER_INFO}, #419 numaralı haberi sildi.', 1, 0),
(16, 1586472330, '{USER_INFO}, #418 numaralı haberi sildi.', 1, 0),
(17, 1586472334, '{USER_INFO}, #417 numaralı haberi sildi.', 1, 0),
(18, 1586472336, '{USER_INFO}, #416 numaralı haberi sildi.', 1, 0),
(19, 1586472341, '{USER_INFO}, #415 numaralı haberi sildi.', 1, 0),
(20, 1586472997, '{USER_INFO}, #414 numaralı haberi sildi.', 1, 0),
(21, 1586473000, '{USER_INFO}, #413 numaralı haberi sildi.', 1, 0),
(22, 1586615997, '{USER_INFO}, giriş yaptı.', 1, 0),
(23, 1586678064, '{USER_INFO}, giriş yaptı.', 1, 0),
(24, 1586704698, '{USER_INFO}, giriş yaptı.', 1, 0),
(25, 1586771025, '{USER_INFO}, giriş yaptı.', 1, 0),
(26, 1586777084, '{USER_INFO}, #1033 numaralı haberi sildi.', 1, 0),
(27, 1586777346, '{USER_INFO}, #1035 numaralı haberi oluşturdu.', 1, 0),
(28, 1586779167, '{USER_INFO}, giriş yaptı.', 1, 0),
(29, 1586779171, '{USER_INFO}, giriş yaptı.', 1, 0),
(30, 1586779218, '{USER_INFO}, #205 numaralı haberi sildi.', 1, 0),
(31, 1586779270, '{USER_INFO}, #1036 numaralı haberi oluşturdu.', 1, 0),
(32, 1586894695, '{USER_INFO}, giriş yaptı.', 1, 0),
(33, 1586967883, '{USER_INFO}, giriş yaptı.', 1, 0),
(34, 1586968514, '{USER_INFO}, giriş yaptı.', 1, 0),
(35, 1586976017, '{USER_INFO}, #1037 numaralı haberi oluşturdu.', 1, 0),
(36, 1586977288, '{USER_INFO}, #1036 numaralı haberi güncelledi.', 1, 0),
(37, 1586977298, '{USER_INFO}, #1036 numaralı haberi güncelledi.', 1, 0),
(38, 1586977308, '{USER_INFO}, #1036 numaralı haberi güncelledi.', 1, 0),
(39, 1586977318, '{USER_INFO}, #1036 numaralı haberi güncelledi.', 1, 0),
(40, 1586977370, '{USER_INFO}, #1036 numaralı haberi güncelledi.', 1, 0),
(41, 1586977384, '{USER_INFO}, #1036 numaralı haberi güncelledi.', 1, 0),
(42, 1586978226, '{USER_INFO}, #1036 numaralı haberi güncelledi.', 1, 0),
(43, 1587033200, '{USER_INFO}, giriş yaptı.', 1, 0),
(44, 1587054460, '{USER_INFO}, #1037 numaralı haberi güncelledi.', 1, 0),
(45, 1587054477, '{USER_INFO}, #1037 numaralı haberi güncelledi.', 1, 0),
(46, 1587054505, '{USER_INFO}, #1037 numaralı haberi güncelledi.', 1, 0),
(47, 1587054550, '{USER_INFO}, #1037 numaralı haberi güncelledi.', 1, 0),
(48, 1587054566, '{USER_INFO}, #1037 numaralı haberi güncelledi.', 1, 0),
(49, 1587211043, '{USER_INFO}, giriş yaptı.', 1, 0),
(50, 1587214365, '{USER_INFO}, giriş yaptı.', 1, 0),
(51, 1587216671, '{USER_INFO}, #6 numaralı kategoriyi sildi.', 1, 0),
(52, 1587217530, '{USER_INFO}, #7 numaralı kategoriyi oluşturdu.', 1, 0),
(53, 1587217535, '{USER_INFO}, #8 numaralı kategoriyi oluşturdu.', 1, 0),
(54, 1587218284, '{USER_INFO}, #7 numaralı kategoriyi güncelledi.', 1, 0),
(55, 1587218309, '{USER_INFO}, #7 numaralı kategoriyi güncelledi.', 1, 0),
(56, 1587218312, '{USER_INFO}, #7 numaralı kategoriyi güncelledi.', 1, 0),
(57, 1587234516, '{USER_INFO}, giriş yaptı.', 1, 0),
(58, 1587234637, '{USER_INFO}, #1037 numaralı haberi sildi.', 1, 0),
(59, 1587236158, '{USER_INFO}, #1 numaralı mesajı sildi.', 1, 0),
(60, 1587236171, '{USER_INFO}, #2 numaralı mesajı sildi.', 1, 0),
(61, 1587236171, '{USER_INFO}, #3 numaralı mesajı sildi.', 1, 0),
(62, 1587239239, '{USER_INFO}, #8 numaralı mesajı sildi.', 1, 0),
(63, 1587239250, '{USER_INFO}, #7 numaralı mesajı sildi.', 1, 0),
(64, 1587239254, '{USER_INFO}, #6 numaralı mesajı sildi.', 1, 0),
(65, 1587239294, '{USER_INFO}, #24 numaralı mesajı sildi.', 1, 0),
(66, 1587239294, '{USER_INFO}, #23 numaralı mesajı sildi.', 1, 0),
(67, 1587239294, '{USER_INFO}, #22 numaralı mesajı sildi.', 1, 0),
(68, 1587239294, '{USER_INFO}, #21 numaralı mesajı sildi.', 1, 0),
(69, 1587239294, '{USER_INFO}, #20 numaralı mesajı sildi.', 1, 0),
(70, 1587239294, '{USER_INFO}, #19 numaralı mesajı sildi.', 1, 0),
(71, 1587239294, '{USER_INFO}, #18 numaralı mesajı sildi.', 1, 0),
(72, 1587239294, '{USER_INFO}, #17 numaralı mesajı sildi.', 1, 0),
(73, 1587239294, '{USER_INFO}, #16 numaralı mesajı sildi.', 1, 0),
(74, 1587239294, '{USER_INFO}, #15 numaralı mesajı sildi.', 1, 0),
(75, 1587239294, '{USER_INFO}, #14 numaralı mesajı sildi.', 1, 0),
(76, 1587239294, '{USER_INFO}, #13 numaralı mesajı sildi.', 1, 0),
(77, 1587239294, '{USER_INFO}, #12 numaralı mesajı sildi.', 1, 0),
(78, 1587239294, '{USER_INFO}, #11 numaralı mesajı sildi.', 1, 0),
(79, 1587239294, '{USER_INFO}, #10 numaralı mesajı sildi.', 1, 0),
(80, 1587239294, '{USER_INFO}, #9 numaralı mesajı sildi.', 1, 0),
(81, 1587239294, '{USER_INFO}, #5 numaralı mesajı sildi.', 1, 0),
(82, 1587239294, '{USER_INFO}, #4 numaralı mesajı sildi.', 1, 0),
(83, 1587243217, '{USER_INFO}, #39 numaralı mesajı okudu.', 1, 0),
(84, 1587243451, '{USER_INFO}, #39 numaralı mesajı sildi.', 1, 0),
(85, 1587243497, '{USER_INFO}, #40 numaralı mesajı sildi.', 1, 0),
(86, 1587243505, '{USER_INFO}, #38 numaralı mesajı sildi.', 1, 0),
(87, 1587243509, '{USER_INFO}, #37 numaralı mesajı okudu.', 1, 0),
(88, 1587243740, '{USER_INFO}, #29 numaralı mesajı okudu.', 1, 0),
(89, 1587244002, '{USER_INFO}, #25 numaralı mesajı okudu.', 1, 0),
(90, 1587244005, '{USER_INFO}, #27 numaralı mesajı okudu.', 1, 0),
(91, 1587244007, '{USER_INFO}, #31 numaralı mesajı okudu.', 1, 0),
(92, 1587244010, '{USER_INFO}, #33 numaralı mesajı okudu.', 1, 0),
(93, 1587244012, '{USER_INFO}, #35 numaralı mesajı okudu.', 1, 0),
(94, 1587251240, '{USER_INFO}, #409 numaralı haberi sildi.', 1, 0),
(95, 1587251464, '{USER_INFO}, #5 numaralı kategoriyi sildi.', 1, 0),
(96, 1587251479, '{USER_INFO}, #1 numaralı kategoriyi sildi.', 1, 0),
(97, 1587251551, '{USER_INFO}, #1 numaralı kategoriyi sildi.', 1, 0),
(98, 1587251598, '{USER_INFO}, #37 numaralı mesajı okudu.', 1, 0),
(99, 1587251606, '{USER_INFO}, #37 numaralı mesajı sildi.', 1, 0),
(100, 1587251611, '{USER_INFO}, #36 numaralı mesajı sildi.', 1, 0),
(101, 1587252181, '{USER_INFO}, #13 numaralı kullanıcıyı sildi.', 1, 0),
(102, 1587252186, '{USER_INFO}, #12 numaralı kullanıcıyı sildi.', 1, 0),
(103, 1587261340, '{USER_INFO}, #23 numaralı kullanıcıyı oluşturdu.', 1, 0),
(104, 1587307950, '{USER_INFO}, giriş yaptı.', 1, 0),
(105, 1587308030, '{USER_INFO}, #26 numaralı mesajı okudu.', 1, 0),
(106, 1587308033, '{USER_INFO}, #25 numaralı mesajı okudu.', 1, 0),
(107, 1587308037, '{USER_INFO}, #27 numaralı mesajı okudu.', 1, 0),
(108, 1587308053, '{USER_INFO}, #35 numaralı mesajı sildi.', 1, 0),
(109, 1587308053, '{USER_INFO}, #34 numaralı mesajı sildi.', 1, 0),
(110, 1587326827, '{USER_INFO}, giriş yaptı.', 1, 0),
(111, 1587821427, '{USER_INFO}, giriş yaptı.', 1, 0),
(112, 1587821444, '{USER_INFO}, #42 numaralı mesajı okudu.', 1, 0),
(113, 1587821450, '{USER_INFO}, #43 numaralı mesajı okudu.', 1, 0),
(114, 1587906138, '{USER_INFO}, giriş yaptı.', 1, 0),
(115, 1587928008, '{USER_INFO}, giriş yaptı.', 1, 0),
(116, 1587939652, '{USER_INFO}, # numaralı kullanıcıyı güncelledi.', 1, 0),
(117, 1587939681, '{USER_INFO}, #17 numaralı kullanıcıyı güncelledi.', 1, 0),
(118, 1587939701, '{USER_INFO}, #17 numaralı kullanıcıyı güncelledi.', 1, 0),
(119, 1587939743, '{USER_INFO}, #17 numaralı kullanıcıyı güncelledi.', 1, 0),
(120, 1587939825, '{USER_INFO}, #17 numaralı kullanıcıyı güncelledi.', 1, 0),
(121, 1587943170, '{USER_INFO}, #4 numaralı yetki grubunu sildi.', 1, 0),
(122, 1587946223, '{USER_INFO}, #5 numaralı yetki grubunu oluşturdu.', 1, 0),
(123, 1587946278, '{USER_INFO}, #6 numaralı yetki grubunu oluşturdu.', 1, 0),
(124, 1587946285, '{USER_INFO}, #7 numaralı yetki grubunu oluşturdu.', 1, 0),
(125, 1587946306, '{USER_INFO}, #7 numaralı yetki grubunu sildi.', 1, 0),
(126, 1587946309, '{USER_INFO}, #6 numaralı yetki grubunu sildi.', 1, 0),
(127, 1587946319, '{USER_INFO}, #5 numaralı yetki grubunu sildi.', 1, 0),
(128, 1587947125, '{USER_INFO}, #2 numaralı yetki grubunu güncelledi.', 1, 0),
(129, 1587947127, '{USER_INFO}, #2 numaralı yetki grubunu güncelledi.', 1, 0),
(130, 1587947146, '{USER_INFO}, #2 numaralı yetki grubunu güncelledi.', 1, 0),
(131, 1587948395, '{USER_INFO}, #2 numaralı yetki grubunu güncelledi.', 1, 0),
(132, 1587948466, '{USER_INFO}, #2 numaralı yetki grubunu güncelledi.', 1, 0),
(133, 1587948480, '{USER_INFO}, #2 numaralı yetki grubunu güncelledi.', 1, 0),
(134, 1587948505, '{USER_INFO}, #2 numaralı yetki grubunu güncelledi.', 1, 0),
(135, 1587948521, '{USER_INFO}, #2 numaralı yetki grubunu güncelledi.', 1, 0),
(136, 1587948528, '{USER_INFO}, #2 numaralı yetki grubunu güncelledi.', 1, 0),
(137, 1587951451, '{USER_INFO}, #2 numaralı yetkiliyi oluşturdu.', 1, 0),
(138, 1587952139, '{USER_INFO}, #2 numaralı yetki grubunu sildi.', 1, 0),
(139, 1587952168, '{USER_INFO}, #3 numaralı yetkiliyi oluşturdu.', 1, 0),
(140, 1587956601, '{USER_INFO}, #3 numaralı yetkiliyi güncelledi.', 1, 0),
(141, 1587956606, '{USER_INFO}, #3 numaralı yetkiliyi güncelledi.', 1, 0),
(142, 1587956610, '{USER_INFO}, #3 numaralı yetkiliyi güncelledi.', 1, 0),
(143, 1587956638, '{USER_INFO}, #3 numaralı yetkiliyi güncelledi.', 1, 0),
(144, 1587956881, '{USER_INFO}, #8 numaralı yetki grubunu oluşturdu.', 1, 0),
(145, 1587957829, '{USER_INFO}, profilini güncelledi.', 1, 0),
(146, 1587957845, '{USER_INFO}, profilini güncelledi.', 1, 0),
(147, 1587957871, '{USER_INFO}, profilini güncelledi.', 1, 0),
(148, 1587958447, '{USER_INFO}, #3 numaralı yetkiliyi güncelledi.', 1, 0),
(149, 1587958453, '{USER_INFO}, giriş yaptı.', 3, 0),
(150, 1587960721, '{USER_INFO}, çıkış yaptı.', 3, 0),
(151, 1587964350, '{USER_INFO}, giriş yaptı.', 1, 0),
(152, 1587964367, '{USER_INFO}, #44 numaralı mesajı okudu.', 1, 0),
(153, 1587965514, '{USER_INFO}, #1 numaralı bildirimi gönderdi.', 1, 0),
(154, 1587965549, '{USER_INFO}, #2 numaralı bildirimi gönderdi.', 1, 0),
(155, 1587966397, '{USER_INFO}, #45 numaralı mesajı okudu.', 1, 0),
(156, 1587966467, '{USER_INFO}, #46 numaralı mesajı okudu.', 1, 0),
(157, 1587967179, '{USER_INFO}, #3 numaralı bildirimi gönderdi.', 1, 0),
(158, 1587967269, '{USER_INFO}, #4 numaralı bildirimi gönderdi.', 1, 0),
(159, 1587967277, '{USER_INFO}, #5 numaralı bildirimi gönderdi.', 1, 0),
(160, 1587969690, '{USER_INFO}, giriş yaptı.', 1, 0),
(161, 1588193832, '{USER_INFO}, giriş yaptı.', 1, 0),
(162, 1588193837, '{USER_INFO}, giriş yaptı.', 1, 0),
(163, 1588193855, '{USER_INFO}, #6 numaralı bildirimi gönderdi.', 1, 0),
(164, 1588193868, '{USER_INFO}, #7 numaralı bildirimi gönderdi.', 1, 0),
(165, 1588193868, '{USER_INFO}, #8 numaralı bildirimi gönderdi.', 1, 0),
(166, 1588193907, '{USER_INFO}, #0 numaralı bildirimi gönderdi.', 1, 0),
(167, 1588194041, '{USER_INFO}, #0 numaralı bildirimi gönderdi.', 1, 0),
(168, 1588254554, '{USER_INFO}, giriş yaptı.', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `subject` text NOT NULL,
  `message_text` text NOT NULL,
  `message_images` text DEFAULT NULL,
  `sended_time` int(11) NOT NULL,
  `status` int(1) NOT NULL,
  `isDeleted` int(1) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `user_id`, `subject`, `message_text`, `message_images`, `sended_time`, `status`, `isDeleted`) VALUES
(37, 11, 'deneme', 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1),
(25, 11, 'deneme', 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 0),
(26, 11, 'deneme2', 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.', '', 12132, 1, 0),
(27, 11, 'deneme', 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.', '', 1, 1, 0),
(28, 11, 'deneme2', 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.', '', 12132, 1, 0),
(29, 11, 'deneme', 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.', '', 1, 1, 0),
(30, 11, 'deneme2', 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.', '', 12132, 1, 0),
(31, 11, 'deneme', 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.', '', 1, 1, 0),
(32, 11, 'deneme2', 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.', '', 12132, 1, 0),
(33, 11, 'deneme', 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.', '', 1, 1, 0),
(34, 11, 'deneme2', 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.', '', 12132, 1, 1),
(35, 11, 'deneme', 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1),
(36, 11, 'deneme2', 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 12132, 1, 1),
(42, 17, 'denemekonuasad', 'asdasdasdasdasdasdsadasdsadsadsadasd', NULL, 1587332718, 1, 0),
(43, 17, 'denemekonuasad', 'asdasdasdasdasdasdsadasdsadsadsadasd', NULL, 1587332933, 1, 0),
(44, 26, '45t54t', '54t54t45t5', NULL, 1587964326, 1, 0),
(45, 26, 'rewrewrwerwe', 'rewaçıklamasdasaa', NULL, 1587966386, 1, 0),
(46, 26, 'rewrewrwerwe', 'rewaçıklamasdasaa', 'uploads/messages/big/MESSAGE_15879664605ea671fc0c14d.jpg', 1587966460, 1, 0),
(47, 26, 'rewrewrwerwe', 'rewaçıklamasdasaa', 'uploads/messages/big/MESSAGE_15879665335ea6724508a5b.jpg', 1587966533, 0, 0),
(48, 26, 'rewrewrwerwe', 'rewaçıklamasdasaa', 'uploads/messages/big/MESSAGE_15879665355ea67247aff78.jpg', 1587966535, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `short_description` text NOT NULL,
  `content` text NOT NULL,
  `categories` text NOT NULL,
  `thumbnail` text NOT NULL,
  `image` text NOT NULL,
  `author` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `added_time` int(11) NOT NULL,
  `last_update_time` int(11) NOT NULL,
  `isDeleted` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `short_description`, `content`, `categories`, `thumbnail`, `image`, `author`, `status`, `added_time`, `last_update_time`, `isDeleted`) VALUES
(206, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(207, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(208, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(209, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(210, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(211, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(212, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(213, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(214, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(215, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(216, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(217, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(218, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(219, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(220, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(221, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(222, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(223, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(224, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(225, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(226, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(227, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(228, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(229, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(230, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(231, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(232, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(233, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(234, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(235, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(236, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(237, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(238, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(239, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(240, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(241, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(242, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(243, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(244, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(245, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(246, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(247, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(248, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(249, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(250, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(251, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(252, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(253, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(254, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(255, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(256, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(257, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(258, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(259, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(260, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(261, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(262, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(263, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(264, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(265, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(266, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(267, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(268, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(269, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(270, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(271, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(272, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(273, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(274, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(275, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(276, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(277, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(278, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(279, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(280, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(281, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(282, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(283, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(284, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(285, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(286, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(287, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(288, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(289, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(290, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(291, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(292, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(293, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(294, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(295, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(296, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(297, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(298, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(299, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(300, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(301, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(302, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(303, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(304, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(305, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(306, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(307, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(308, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(309, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(310, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(311, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(312, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(313, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(314, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(315, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(316, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(317, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(318, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(319, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(320, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(321, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(322, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(323, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(324, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(325, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(326, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(327, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(328, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(329, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(330, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(331, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(332, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(333, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(334, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(335, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(336, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(337, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(338, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(339, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(340, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(341, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(342, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(343, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(344, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(345, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(346, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(347, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(348, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(349, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(350, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(351, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(352, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(353, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(354, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(355, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(356, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(357, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(358, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(359, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(360, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(361, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(362, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(363, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(364, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(365, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(366, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(367, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(368, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(369, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(370, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(371, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(372, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(373, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(374, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(375, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(376, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(377, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(378, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(379, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(380, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(381, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(382, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(383, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(384, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(385, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(386, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(387, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(388, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(389, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(390, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(391, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(392, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(393, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(394, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(395, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(396, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(397, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(398, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(399, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(400, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(401, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(402, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(403, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(404, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(405, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(406, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(407, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(408, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(409, 'deneme', 'deneme', '<script>Deneme</script>', '[1,2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 1),
(410, 'deneme2', 'deneme2', 'deneme', '[2,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1584874105, 12, 0),
(411, 'deneme3', 'deneme3', 'deneme', '[3,4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585474105, 12, 0),
(412, 'deneme', 'deneme', '<script>Deneme</script>', '[2]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1585874105, 12, 0),
(1034, 'asdasd', 'asdasdsa.a', 'asdasdasdsad', '[2,3]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1586777069, 1586777069, 0),
(1035, 'aaaa', 'sadasdvc', 'asdasdasd', '[4]', 'uploads/news/small/SMALL_15867773455e944d01d38f1.jpg', 'uploads/news/big/BIG_15867773455e944d01d38f1.png', 1, 1, 1586777346, 1586777346, 0),
(1036, 'Telef oldu2', 'Ah zalım gecelerA', 'Bu bir açıklamadır', '[4]', 'uploads/news/small/SMALL_15869782265e975db2808e7.jpg', 'uploads/news/big/BIG_15869782265e975db2808e7.png', 1, 1, 1586779270, 1586978226, 0);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `text` text NOT NULL,
  `image` text DEFAULT NULL,
  `sender` int(11) NOT NULL,
  `sended_time` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `title`, `text`, `image`, `sender`, `sended_time`) VALUES
(6, 'TEST RESIMSIZ', 'TEST RESIMZI ACKLAMA', NULL, 1, 1588193855),
(4, 'deneme2', 'deneme2', NULL, 1, 1587967269),
(5, 'asdasd', 'asdasdsad', 'uploads/notifications/15879672775ea6752d9c979.png', 1, 1587967277),
(7, 'TEST RESIMSIZ', 'TEST RESIMZI ACKLAMA', NULL, 1, 1588193867),
(8, 'TEST RESIMSIZ', 'TEST RESIMZI ACKLAMA', NULL, 1, 1588193868),
(9, 'TEST RESIMSLI', 'TEST RESIMILIZI ACKLAMA', 'uploads/notifications/15881939065ea9ea72f0d8e.jpg', 1, 1588193906),
(10, 'TEST RESIMSLI', 'TEST RESIMILIZI ACKLAMA', 'uploads/notifications/15881940405ea9eaf82d568.png', 1, 1588194040);

-- --------------------------------------------------------

--
-- Table structure for table `profile_data`
--

CREATE TABLE `profile_data` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tc_id` varchar(11) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `name` varchar(64) NOT NULL,
  `surname` varchar(64) NOT NULL,
  `birth_date` int(11) DEFAULT NULL,
  `education_status` varchar(32) DEFAULT NULL,
  `job` varchar(128) DEFAULT NULL,
  `blood_group` varchar(12) DEFAULT NULL,
  `father_name` varchar(64) DEFAULT NULL,
  `mother_name` varchar(64) DEFAULT NULL,
  `mothers_father_name` varchar(128) DEFAULT NULL,
  `village_nickname` varchar(128) DEFAULT NULL,
  `village_neighborhood` varchar(128) DEFAULT NULL,
  `home_address` text DEFAULT NULL,
  `job_address` text DEFAULT NULL,
  `job_phone` varchar(64) DEFAULT NULL,
  `home_phone` varchar(64) DEFAULT NULL,
  `spouse_name` varchar(64) DEFAULT NULL,
  `spouse_blood_group` varchar(12) DEFAULT NULL,
  `spouse_father` varchar(128) DEFAULT NULL,
  `isDeleted` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `profile_data`
--

INSERT INTO `profile_data` (`id`, `user_id`, `tc_id`, `email`, `name`, `surname`, `birth_date`, `education_status`, `job`, `blood_group`, `father_name`, `mother_name`, `mothers_father_name`, `village_nickname`, `village_neighborhood`, `home_address`, `job_address`, `job_phone`, `home_phone`, `spouse_name`, `spouse_blood_group`, `spouse_father`, `isDeleted`) VALUES
(2, 2, NULL, NULL, 'bayram', 'alacam', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(3, 3, NULL, NULL, 'bayram', 'alacam', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(4, 4, NULL, NULL, 'bayram', 'alaçam', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(5, 5, NULL, NULL, 'bayram', 'alaçam', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(6, 6, NULL, NULL, 'bayram', 'alaçam', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(7, 7, NULL, NULL, 'bayram', 'alaçam', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(8, 8, NULL, NULL, 'bayram', 'alaçam', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(9, 9, NULL, NULL, 'bayram', 'alaçam', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(10, 10, NULL, NULL, 'emre', 'altınok', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(11, 11, '15132354821', NULL, 'Emre', 'Altınok', NULL, 'İlkokul', NULL, '0+', NULL, NULL, NULL, 'Deli', 'DeliKent', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(12, 12, NULL, NULL, 'Bayram', 'Alaçam', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(13, 13, NULL, NULL, 'Bayram', 'Alaçam', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(14, 14, NULL, NULL, 'Bayram', 'Alaçam', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(15, 15, NULL, NULL, 'Bayram', 'Alaçam', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(16, 16, NULL, NULL, 'Bayram', 'Alaçam', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(17, 17, '15132354821', 'dfasdfsadf@eqwe.qwe', 'Emre', 'Altınok', 973288800, 'İlkokul', 'İşverenAdam', 'B+', 'Ali', 'Bahar', 'Sanane', 'DeliAdma', 'DeliKent', 'sfsdgdfsgfdsgfdsgdfsgdfs', 'dfsdgdfgfdgdfgdf', '34353453453453', '23423432423', 'dfsgdfsgdfsg', 'AB-', 'sdfgdsfgdfsgdfs', 0),
(18, 18, NULL, NULL, 'Bayram', 'Alaçam', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(19, 19, NULL, NULL, 'Bayram', 'Alaçam', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(20, 20, NULL, NULL, 'Bayram', 'Alaçam', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(21, 21, NULL, NULL, 'Bayram', 'Alaçam', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(22, 22, NULL, NULL, 'Emre', 'Altınok', -12312, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(23, 23, NULL, NULL, 'emre', 'altınok', NULL, 'Lise', NULL, '0+', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(24, 24, NULL, NULL, 'Emirhan', 'Alaçam', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(25, 25, NULL, NULL, 'Bayram', 'Alaçam', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(26, 26, '19876759875', 'bayramlcm14@gmail.com', 'asd', 'asd', 1587934800, 'Lise', 'Yazılım Uzmanı', 'B+', 'Baba', 'Anne', 'ABaba', 'lakabıbı', 'taraklı', 'sakarya', 'iş adresi', '4545454545', '5454545454', 'biricik', 'A+', 'EBaba', 0),
(27, 29, NULL, NULL, 'fıratcan', 'şahin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(28, 30, NULL, NULL, 'fıratcan', 'şahin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(29, 31, NULL, NULL, 'fıratcan', 'şahin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(30, 28, NULL, NULL, 'fıratcan', 'şahin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(31, 27, NULL, NULL, 'fıratcan', 'şahin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(32, 32, NULL, NULL, 'fıratcan', 'şahin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(33, 33, NULL, NULL, 'fıratcan', 'şahin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(34, 34, '44128368758', NULL, 'karaibis', 'seref', 333316800, 'Lisans', 'muhasebe', 'AB-', 'Kenan', 'Bagdat', 'Aziz', 'Arapoglu', 'Yukari Mahalle', 'Capa/Istanbul', NULL, NULL, NULL, 'Gulay', '0+', 'Fahri', 0);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `url` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `url`) VALUES
(1, 'https://ahmetcanak.com/dernekApp/');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `phone_number` varchar(11) NOT NULL,
  `password` varchar(256) NOT NULL,
  `register_date` int(11) NOT NULL,
  `register_ip` varchar(26) NOT NULL,
  `last_join_time` int(11) NOT NULL,
  `last_join_ip` varchar(26) NOT NULL,
  `isDeleted` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `phone_number`, `password`, `register_date`, `register_ip`, `last_join_time`, `last_join_ip`, `isDeleted`) VALUES
(2, '3333333333', 'a51c3dfd4b0c626647bfde4f708b320a', 1585809082, '176.43.210.75', 1585809082, '176.43.210.75', 0),
(3, '3333383333', 'a51c3dfd4b0c626647bfde4f708b320a', 1585809323, '176.43.210.75', 1585809323, '176.43.210.75', 0),
(4, '3339383333', 'a51c3dfd4b0c626647bfde4f708b320a', 1585809375, '176.43.210.75', 1585809375, '176.43.210.75', 0),
(5, '5554443322', 'a51c3dfd4b0c626647bfde4f708b320a', 1585846633, '176.43.210.75', 1585846633, '176.43.210.75', 0),
(6, '5553443322', 'a51c3dfd4b0c626647bfde4f708b320a', 1585863505, '176.43.211.110', 1585863505, '176.43.211.110', 0),
(7, '5553643322', 'a51c3dfd4b0c626647bfde4f708b320a', 1585865718, '176.43.211.110', 1585865718, '176.43.211.110', 0),
(8, '5553743322', 'a51c3dfd4b0c626647bfde4f708b320a', 1585865784, '176.43.211.110', 1585866132, '176.43.211.110', 0),
(9, '5553743422', 'a51c3dfd4b0c626647bfde4f708b320a', 1585866155, '176.43.211.110', 1585866155, '176.43.211.110', 0),
(10, '5554442244', 'dad11e043f2e6a5a21a203257ec85986', 1585870772, '176.33.128.108', 1585870984, '176.33.128.108', 0),
(11, '5555555555', 'dad11e043f2e6a5a21a203257ec85986', 1585871305, '176.33.128.108', 1585871305, '176.33.128.108', 0),
(12, '5349370192', '8843028fefce50a6de50acdf064ded27', 1586980064, '88.231.131.71', 1587076621, '88.231.133.135', 1),
(13, '5349370193', '8843028fefce50a6de50acdf064ded27', 1586983587, '88.231.131.71', 1586983587, '88.231.131.71', 1),
(14, '5349370194', '8843028fefce50a6de50acdf064ded27', 1586983641, '88.231.131.71', 1586983641, '88.231.131.71', 0),
(15, '5349370195', '8843028fefce50a6de50acdf064ded27', 1586983669, '88.231.131.71', 1586983669, '88.231.131.71', 0),
(16, '5349370196', '8843028fefce50a6de50acdf064ded27', 1586986871, '88.231.131.71', 1586986871, '88.231.131.71', 0),
(17, '5555555553', '889f424f62107576b7f88864d5808781', 1587047697, '176.43.210.79', 1587047697, '176.43.210.79', 0),
(18, '5349370198', '8843028fefce50a6de50acdf064ded27', 1587072345, '88.231.133.135', 1587072345, '88.231.133.135', 0),
(19, '5349370199', '8843028fefce50a6de50acdf064ded27', 1587072634, '88.231.133.135', 1587072634, '88.231.133.135', 0),
(20, '5349370200', '8843028fefce50a6de50acdf064ded27', 1587072839, '88.231.133.135', 1587072839, '88.231.133.135', 0),
(21, '5349370201', '8843028fefce50a6de50acdf064ded27', 1587072863, '88.231.133.135', 1587072863, '88.231.133.135', 0),
(22, '9999998989', '8843028fefce50a6de50acdf064ded27', 1587076651, '88.231.133.135', 1587076651, '88.231.133.135', 0),
(23, '1231231231', 'a51c3dfd4b0c626647bfde4f708b320a', 1587261340, '176.234.219.185', 1587261340, '176.234.219.185', 0),
(24, '5554443333', '8843028fefce50a6de50acdf064ded27', 1587297332, '178.240.249.136', 1587297332, '178.240.249.136', 0),
(25, '5349370192', '8843028fefce50a6de50acdf064ded27', 1587809241, '88.230.182.25', 1588193452, '88.230.175.82', 0),
(26, '5349370193', '8843028fefce50a6de50acdf064ded27', 1587905980, '88.230.182.25', 1587905980, '88.230.182.25', 0),
(27, '5550351299', '29b1e4242683ce74c96a0ca7cb31d43b', 1588197515, '95.10.203.204', 1588197515, '95.10.203.204', 0),
(28, '5550351299', '29b1e4242683ce74c96a0ca7cb31d43b', 1588197515, '95.10.203.204', 1588197515, '95.10.203.204', 0),
(29, '5550351299', 'd93a5def7511da3d0f2d171d9c344e91', 1588197515, '95.10.203.204', 1588197515, '95.10.203.204', 0),
(30, '5550351299', '29b1e4242683ce74c96a0ca7cb31d43b', 1588197515, '95.10.203.204', 1588197515, '95.10.203.204', 0),
(31, '5550351299', '29b1e4242683ce74c96a0ca7cb31d43b', 1588197515, '95.10.203.204', 1588197515, '95.10.203.204', 0),
(32, '5550351299', '29b1e4242683ce74c96a0ca7cb31d43b', 1588197515, '95.10.203.204', 1588197515, '95.10.203.204', 0),
(33, '5550351299', 'd93a5def7511da3d0f2d171d9c344e91', 1588197515, '95.10.203.204', 1588197515, '95.10.203.204', 0),
(34, '5327652661', '4782e78a74968da2ab06ec2d5def3ee2', 1588255147, '178.243.111.126', 1588255147, '178.243.111.126', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `authorized_list`
--
ALTER TABLE `authorized_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `authorize_list`
--
ALTER TABLE `authorize_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `children_list`
--
ALTER TABLE `children_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profile_data`
--
ALTER TABLE `profile_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `authorized_list`
--
ALTER TABLE `authorized_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `authorize_list`
--
ALTER TABLE `authorize_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `children_list`
--
ALTER TABLE `children_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=169;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1038;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `profile_data`
--
ALTER TABLE `profile_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
