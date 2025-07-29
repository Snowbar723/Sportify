-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2025-07-29 18:08:42
-- 伺服器版本： 10.4.32-MariaDB
-- PHP 版本： 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `db`
--

-- --------------------------------------------------------

--
-- 資料表結構 `event`
--

CREATE TABLE `event` (
  `event_id` int(11) NOT NULL,
  `user_id` int(5) NOT NULL,
  `sport` varchar(50) NOT NULL,
  `post_Time` timestamp NOT NULL DEFAULT current_timestamp(),
  `event_Time` timestamp NOT NULL DEFAULT current_timestamp(),
  `location` varchar(50) NOT NULL,
  `people_Needed` int(100) NOT NULL,
  `ability` varchar(50) NOT NULL,
  `memo` varchar(100) NOT NULL,
  `state` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `event`
--

INSERT INTO `event` (`event_id`, `user_id`, `sport`, `post_Time`, `event_Time`, `location`, `people_Needed`, `ability`, `memo`, `state`) VALUES
(1, 1, '籃球', '2025-07-29 08:46:00', '2025-07-29 11:00:00', '體育館籃球場', 3, '基礎即可', '', 'success'),
(4, 2, '羽球', '2025-07-29 12:51:00', '2025-07-29 07:00:00', '羽球館', 1, '都可以', '', 'success'),
(5, 3, '羽球', '2025-07-29 15:15:00', '2025-07-30 03:20:00', '羽球館', 2, '希望可以中等以上', '', 'OK'),
(6, 4, '瑜珈', '2025-07-29 15:17:00', '2025-09-01 02:30:00', '第一韻律教室', 1, '不限', '', 'OK'),
(7, 4, '瑜珈', '2025-07-29 15:17:00', '2025-09-03 02:30:00', '第一韻律教室', 1, '不限', '', 'ING'),
(8, 1, '慢跑', '2025-07-29 15:28:00', '2025-08-14 23:00:00', '河畔公園', 1, '不限', '', 'ING'),
(9, 2, '桌球', '2025-07-29 15:33:00', '2025-08-18 06:00:00', '第一桌球室', 1, '強', '', 'ING'),
(10, 1, '健走', '2025-07-29 16:05:00', '2025-06-20 07:00:00', '校門口', 1, '不限', '', 'fail'),
(11, 3, '羽球', '2025-07-29 16:07:00', '2025-08-07 02:00:00', '振興羽球館', 2, '中上', '', 'ING');

-- --------------------------------------------------------

--
-- 資料表結構 `queue`
--

CREATE TABLE `queue` (
  `queue_id` int(11) NOT NULL,
  `event_id` int(100) NOT NULL,
  `state` varchar(50) NOT NULL,
  `waiting_id` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `queue`
--

INSERT INTO `queue` (`queue_id`, `event_id`, `state`, `waiting_id`) VALUES
(1, 1, 'picked', 2),
(2, 4, 'picked', 1),
(3, 4, 'unpicked', 3),
(4, 5, 'picked', 4),
(5, 5, 'unpicked', 1),
(7, 6, 'picked', 1),
(8, 1, 'picked', 3),
(9, 7, 'waiting', 3),
(10, 5, 'picked', 2),
(11, 1, 'picked', 4);

-- --------------------------------------------------------

--
-- 資料表結構 `review`
--

CREATE TABLE `review` (
  `review_id` int(11) NOT NULL,
  `event_id` int(100) NOT NULL,
  `user_id_From` int(100) NOT NULL,
  `user_id_To` int(100) NOT NULL,
  `score` int(10) NOT NULL,
  `content` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `review`
--

INSERT INTO `review` (`review_id`, `event_id`, `user_id_From`, `user_id_To`, `score`, `content`) VALUES
(3, 1, 1, 2, 4, '技術還好，體力需要加強'),
(4, 1, 1, 3, 5, '怎麼還沒當上籃球隊長~~~'),
(5, 1, 1, 4, 5, '長得很可愛但動作好快，反差感！'),
(6, 1, 2, 1, 5, 'Great:)'),
(7, 1, 2, 3, 5, ''),
(8, 1, 2, 4, 5, ''),
(9, 1, 3, 1, 5, ''),
(10, 1, 3, 2, 5, ''),
(11, 1, 3, 4, 5, ''),
(12, 1, 4, 1, 5, ''),
(13, 1, 4, 2, 5, ''),
(14, 1, 4, 3, 5, ''),
(15, 4, 2, 1, 5, '很強~'),
(16, 4, 1, 2, 5, '很會接殺球>:O');

-- --------------------------------------------------------

--
-- 資料表結構 `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_Acc` varchar(30) NOT NULL,
  `user_Pwd` varchar(30) NOT NULL,
  `user_Name` varchar(30) NOT NULL,
  `user_Nickname` varchar(30) NOT NULL,
  `gender` varchar(15) NOT NULL,
  `sport_Prefer` varchar(50) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `adress` varchar(100) NOT NULL,
  `school` varchar(30) NOT NULL,
  `major` varchar(30) NOT NULL,
  `birthday` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `user`
--

INSERT INTO `user` (`user_id`, `user_Acc`, `user_Pwd`, `user_Name`, `user_Nickname`, `gender`, `sport_Prefer`, `phone`, `adress`, `school`, `major`, `birthday`) VALUES
(1, 'Snowbar23', '123', 'Vivian Wu', '雪霸', 'female', '籃球', '0097978129', '我家', '政大', '資管系', '2003-07-23'),
(2, 'test1', '123', '測試', '阿明', 'male', '足球', '0092255566', '同學家', '政大', '資管系', '2004-05-28'),
(3, 'test2', '123', '女同學', '女同學', 'female', '羽球', '0966444888', '女同學的家', '政治大學', '會計', '2002-04-23'),
(4, 'test3', '123', '可愛女同學', '莉莉', 'female', '羽球', '0966555222', '莉莉的家', '政治大學', '英文系', '2006-08-23');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`event_id`);

--
-- 資料表索引 `queue`
--
ALTER TABLE `queue`
  ADD PRIMARY KEY (`queue_id`);

--
-- 資料表索引 `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`review_id`);

--
-- 資料表索引 `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `event`
--
ALTER TABLE `event`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `queue`
--
ALTER TABLE `queue`
  MODIFY `queue_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `review`
--
ALTER TABLE `review`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
