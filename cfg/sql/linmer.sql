-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2019-12-04 00:35:38
-- 服务器版本： 5.7.26
-- PHP 版本： 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `linmer`
--

-- --------------------------------------------------------

--
-- 表的结构 `consumer`
--

CREATE TABLE `consumer` (
  `id` int(10) UNSIGNED NOT NULL,
  `notify` varchar(255) NOT NULL,
  `atime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `utime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='服务消费者，调用各项服务，当某服务下线时，需要通知消费者';

-- --------------------------------------------------------

--
-- 表的结构 `service`
--

CREATE TABLE `service` (
  `id` int(11) NOT NULL,
  `host` varchar(32) NOT NULL,
  `port` int(11) NOT NULL,
  `status` int(11) NOT NULL COMMENT '服务状态，1上次心跳正常（注意：新注册服务属于心跳正常），0~负无穷，每次心跳失败减一',
  `service_type` varchar(8) NOT NULL DEFAULT 'all' COMMENT '服务类型',
  `scheme` varchar(8) NOT NULL DEFAULT 'http' COMMENT '协议，通信方式',
  `sync` varchar(8) NOT NULL DEFAULT '' COMMENT '同步，异步',
  `data_formate` varchar(8) NOT NULL COMMENT '数据格式',
  `service_list` text NOT NULL COMMENT '提供的接口列表及版本',
  `atime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `utime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='服务提供者，向服务中心注册的，给消费者提供服务';

--
-- 转储表的索引
--

--
-- 表的索引 `consumer`
--
ALTER TABLE `consumer`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `consumer`
--
ALTER TABLE `consumer`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `service`
--
ALTER TABLE `service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
