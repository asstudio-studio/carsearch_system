-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2023-01-04 12:56:37
-- 伺服器版本： 10.4.24-MariaDB
-- PHP 版本： 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `carsearch`
--

-- --------------------------------------------------------

--
-- 資料表結構 `car`
--

CREATE TABLE `car` (
  `CarID` bigint(15) NOT NULL,
  `Brand` varchar(255) NOT NULL,
  `AreaCode` varchar(255) NOT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `Displacement` bigint(15) NOT NULL,
  `Price` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `car`
--

INSERT INTO `car` (`CarID`, `Brand`, `AreaCode`, `Name`, `Displacement`, `Price`) VALUES
(1, 'Lamborghini', 'Taipei', '2020 Lamborghini Aventador S Roadster V12', 6498, '28000000'),
(2, 'BMW', 'Taipei', 'BWM M8', 4000, '5000000'),
(3, 'BMW', 'Taipei', 'BWM M6', 3000, '4000000'),
(4, 'Benz', 'Taipei', 'C200', 2000, '1200000'),
(22, 'BMW', 'Taichung', '2018 BMW 6-Series Gran Coupe M6 Competition', 4395, '7700000'),
(52, 'Toyota', 'Kaohsiung ', '2022 Toyota Corolla Altis 1.8 經典', 1798, '715000');

-- --------------------------------------------------------

--
-- 資料表結構 `carbrand`
--

CREATE TABLE `carbrand` (
  `Brand` varchar(255) NOT NULL,
  `Website` varchar(255) NOT NULL,
  `Location` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `carbrand`
--

INSERT INTO `carbrand` (`Brand`, `Website`, `Location`) VALUES
('BMW', 'https://www.bmw.com.tw/zh/index.html', 'Germany'),
('Lamborghini', 'https://www.lamborghini.com/cn-en', 'Italy'),
('Toyota', 'https://www.toyota.com.tw/showroom/COROLLA_\r\nCROSS/', 'Japan');

-- --------------------------------------------------------

--
-- 資料表結構 `store`
--

CREATE TABLE `store` (
  `AreaCode` varchar(255) NOT NULL,
  `BusinessHour` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `store`
--

INSERT INTO `store` (`AreaCode`, `BusinessHour`) VALUES
('Kaohsiung ', '12:00~21:00'),
('Taichung', '11:00~17:00'),
('Taipei', '10:00~20:00');

-- --------------------------------------------------------

--
-- 資料表結構 `user`
--

CREATE TABLE `user` (
  `user_id` int(30) NOT NULL,
  `username` varchar(255) NOT NULL,
  `display_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_level` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `user`
--

INSERT INTO `user` (`user_id`, `username`, `display_name`, `password`, `user_level`) VALUES
(1, 'yu', 'AA', '00933103', 's'),
(2, '', '', '', 'u');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `car`
--
ALTER TABLE `car`
  ADD PRIMARY KEY (`CarID`),
  ADD KEY `AreaCode` (`AreaCode`);

--
-- 資料表索引 `carbrand`
--
ALTER TABLE `carbrand`
  ADD PRIMARY KEY (`Brand`);

--
-- 資料表索引 `store`
--
ALTER TABLE `store`
  ADD PRIMARY KEY (`AreaCode`);

--
-- 資料表索引 `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 已傾印資料表的限制式
--

--
-- 資料表的限制式 `car`
--
ALTER TABLE `car`
  ADD CONSTRAINT `car_ibfk_1` FOREIGN KEY (`AreaCode`) REFERENCES `store` (`AreaCode`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
