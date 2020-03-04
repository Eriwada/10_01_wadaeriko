-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 
-- サーバのバージョン： 10.4.11-MariaDB
-- PHP のバージョン: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `gsacfd05_01`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `account`
--

CREATE TABLE `account` (
  `id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `purchase` int(11) NOT NULL,
  `sale` int(11) NOT NULL,
  `profit` int(11) NOT NULL,
  `image` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updatedby` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- テーブルのデータのダンプ `account`
--

INSERT INTO `account` (`id`, `year`, `purchase`, `sale`, `profit`, `image`, `updatedby`) VALUES
(2, 2007, 550000, 800000, 250000, '', NULL),
(3, 2008, 678000, 1065000, 387000, '', 'aaa'),
(4, 2009, 787000, 1278500, 491500, '', 'aaa'),
(5, 2010, 895600, 1456000, 560400, '', 'aaa'),
(6, 2011, 967150, 1675600, 708450, '', 'aaa'),
(7, 2012, 1065850, 1701542, 635692, '', 'aaa'),
(8, 2013, 1105600, 1895000, 789400, '', 'aaa'),
(9, 2014, 1465000, 2256500, 791500, '', 'aaa'),
(10, 2015, 1674500, 2530000, 855500, '', 'ccc'),
(11, 2016, 2050000, 3160000, 1110000, '', 'vvv'),
(12, 2017, 680000, 1000000, 320000, '', 'mmm'),
(17, 2018, 2050000, 3160000, 1110000, 'upload/20200225170929d41d8cd98f00b204e9800998ecf8427e.jpg', 'sss');

-- --------------------------------------------------------

--
-- テーブルの構造 `todo_table`
--

CREATE TABLE `todo_table` (
  `id` int(12) NOT NULL,
  `task` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `deadline` date NOT NULL,
  `comment` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- テーブルのデータのダンプ `todo_table`
--

INSERT INTO `todo_table` (`id`, `task`, `deadline`, `comment`, `image`, `created_at`, `updated_at`) VALUES
(4, 'カード書く', '2020-02-13', 'カーズのカード', NULL, '2020-02-01 15:46:30', '2020-02-13 19:58:19'),
(6, '飾り付け', '2020-02-28', '風船', NULL, '2020-02-01 15:48:19', '2020-02-09 17:09:44'),
(7, '動画作成', '2020-02-05', 'おばあちゃん用', NULL, '2020-02-01 15:48:58', '2020-02-13 19:58:29'),
(8, 'お店予約', '2020-02-05', '希望きいてから', NULL, '2020-02-01 15:50:11', '2020-02-13 19:58:38'),
(9, '旅費申請', '2020-02-01', '領収書も添付', NULL, '2020-02-01 15:51:13', '2020-02-13 19:58:48'),
(10, 'ハンドソープ買う', '2020-02-15', '薬局', NULL, '2020-02-01 15:54:28', '2020-02-13 19:58:56'),
(19, 'aaa', '2020-02-15', 'aaa', NULL, '2020-02-06 18:46:44', '2020-02-06 18:46:44'),
(20, 'aa', '2020-02-14', 'aa', NULL, '2020-02-06 20:30:30', '2020-02-06 20:30:30'),
(21, 'aaa', '2020-02-21', 'ｑｑｑ', NULL, '2020-02-06 20:42:16', '2020-02-06 20:42:16'),
(22, '空にしてみる', '2020-02-06', 'どうかな', NULL, '2020-02-06 20:43:19', '2020-02-06 20:43:19'),
(23, '並べ替え', '2020-02-06', 'うまくいかない', NULL, '2020-02-06 20:52:59', '2020-02-06 20:52:59'),
(28, 'hhh', '2020-02-13', 'hhh', 'upload/20200215083141d41d8cd98f00b204e9800998ecf8427e.jpg', '2020-02-15 16:31:41', '2020-02-15 16:31:41');

-- --------------------------------------------------------

--
-- テーブルの構造 `users_table`
--

CREATE TABLE `users_table` (
  `id` int(12) NOT NULL,
  `user_id` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `is_admin` int(1) NOT NULL,
  `is_deleted` int(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- テーブルのデータのダンプ `users_table`
--

INSERT INTO `users_table` (`id`, `user_id`, `password`, `is_admin`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'eri', 'test', 0, 0, '2020-03-02 06:52:46', '2020-03-02 06:52:46'),
(2, 'test', 'test', 0, 0, '2020-03-03 05:11:41', '2020-03-03 05:11:41'),
(4, 'eri', 'eri', 0, 0, '2020-03-03 06:05:11', '2020-03-03 06:05:11');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `todo_table`
--
ALTER TABLE `todo_table`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `users_table`
--
ALTER TABLE `users_table`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルのAUTO_INCREMENT
--

--
-- テーブルのAUTO_INCREMENT `account`
--
ALTER TABLE `account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- テーブルのAUTO_INCREMENT `todo_table`
--
ALTER TABLE `todo_table`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- テーブルのAUTO_INCREMENT `users_table`
--
ALTER TABLE `users_table`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
