-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2019-03-03 13:43:56
-- 服务器版本： 5.7.18
-- PHP 版本： 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `lianmilite`
--

-- --------------------------------------------------------

--
-- 表的结构 `feed`
--

CREATE TABLE `feed` (
  `id` int(11) NOT NULL,
  `content` mediumtext,
  `author_uid` int(11) NOT NULL DEFAULT '0',
  `author_openid` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `rt_id` int(11) NOT NULL DEFAULT '0',
  `rt_uid` int(11) NOT NULL DEFAULT '0',
  `rt_openid` varchar(255) DEFAULT NULL,
  `rt_content` varchar(255) DEFAULT NULL,
  `rt_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `follow`
--

CREATE TABLE `follow` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `fans_uid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `message`
--

CREATE TABLE `message` (
  `id` int(11) UNSIGNED NOT NULL,
  `uid` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '本条记录持有人',
  `from_uid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `to_uid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `text` text,
  `created_at` datetime DEFAULT NULL,
  `is_read` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `message_group`
--

CREATE TABLE `message_group` (
  `id` int(11) UNSIGNED NOT NULL,
  `uid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `from_uid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `to_uid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `text` text,
  `created_at` datetime DEFAULT NULL,
  `is_read` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='每个 from_uid 的最新一条消息聚合';

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `openid` varchar(32) NOT NULL,
  `nickname` varchar(32) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `follow_count` int(11) NOT NULL DEFAULT '0',
  `fans_count` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转储表的索引
--

--
-- 表的索引 `feed`
--
ALTER TABLE `feed`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author_uid` (`author_uid`);

--
-- 表的索引 `follow`
--
ALTER TABLE `follow`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uid` (`uid`,`fans_uid`);

--
-- 表的索引 `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `message_group`
--
ALTER TABLE `message_group`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNI` (`uid`,`from_uid`,`to_uid`);

--
-- 表的索引 `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `openid` (`openid`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `feed`
--
ALTER TABLE `feed`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `follow`
--
ALTER TABLE `follow`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `message_group`
--
ALTER TABLE `message_group`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
