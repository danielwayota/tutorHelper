-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: mysql-server
-- Tiempo de generación: 08-08-2018 a las 12:11:42
-- Versión del servidor: 5.7.21
-- Versión de PHP: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tutorHelper`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Config`
--

DROP TABLE IF EXISTS `Config`;
CREATE TABLE IF NOT EXISTS `Config` (
  `BasePrice` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `Config`
--

INSERT INTO `Config` (`BasePrice`) VALUES
(10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ConfigSchedules`
--

DROP TABLE IF EXISTS `ConfigSchedules`;
CREATE TABLE IF NOT EXISTS `ConfigSchedules` (
  `IdConfigSchedule` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `IsDefault` tinyint(1) NOT NULL,
  PRIMARY KEY (`IdConfigSchedule`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `ConfigSchedules`
--

INSERT INTO `ConfigSchedules` (`IdConfigSchedule`, `Name`, `IsDefault`) VALUES
(1, 'LunAJue', 1),
(2, 'Vie', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ConfigSchedulesHours`
--

DROP TABLE IF EXISTS `ConfigSchedulesHours`;
CREATE TABLE IF NOT EXISTS `ConfigSchedulesHours` (
  `IdConfigSchedule` int(11) NOT NULL,
  `IdHour` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `ConfigSchedulesHours`
--

INSERT INTO `ConfigSchedulesHours` (`IdConfigSchedule`, `IdHour`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(2, 1),
(2, 2),
(2, 3),
(2, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Days`
--

DROP TABLE IF EXISTS `Days`;
CREATE TABLE IF NOT EXISTS `Days` (
  `IdDay` int(11) NOT NULL AUTO_INCREMENT,
  `DayDate` date NOT NULL,
  `Locked` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`IdDay`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `DaysUsersHours`
--

DROP TABLE IF EXISTS `DaysUsersHours`;
CREATE TABLE IF NOT EXISTS `DaysUsersHours` (
  `IdDay` int(11) NOT NULL,
  `IdUser` int(11) DEFAULT NULL,
  `IdHour` int(11) NOT NULL,
  KEY `IdDay` (`IdDay`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Hours`
--

DROP TABLE IF EXISTS `Hours`;
CREATE TABLE IF NOT EXISTS `Hours` (
  `IdHour` int(11) NOT NULL AUTO_INCREMENT,
  `HourString` varchar(12) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`IdHour`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `Hours`
--

INSERT INTO `Hours` (`IdHour`, `HourString`) VALUES
(1, '3:30'),
(2, '4:30'),
(3, '5:30'),
(4, '6:30'),
(5, '7:30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Pages`
--

DROP TABLE IF EXISTS `Pages`;
CREATE TABLE IF NOT EXISTS `Pages` (
  `IdPage` int(11) NOT NULL AUTO_INCREMENT,
  `Title` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `Content` text COLLATE utf8_spanish_ci NOT NULL,
  `Position` int(11) NOT NULL,
  PRIMARY KEY (`IdPage`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Users`
--

DROP TABLE IF EXISTS `Users`;
CREATE TABLE IF NOT EXISTS `Users` (
  `IdUser` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `Email` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `Password` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `Enabled` tinyint(1) NOT NULL DEFAULT '1',
  `IsSuperAdmin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`IdUser`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `Users`
--

INSERT INTO `Users` (`IdUser`, `Name`, `Email`, `Password`, `Enabled`, `IsSuperAdmin`) VALUES
(1, 'Admin', 'admin@admin.es', 'dc647eb65e6711e155375218212b3964', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `UsersData`
--

DROP TABLE IF EXISTS `UsersData`;
CREATE TABLE IF NOT EXISTS `UsersData` (
  `IdUserData` int(11) NOT NULL AUTO_INCREMENT,
  `IdUser` int(11) NOT NULL,
  `Comments` text COLLATE utf8_spanish_ci,
  `PriceOverride` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`IdUserData`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `DaysUsersHours`
--
ALTER TABLE `DaysUsersHours`
  ADD CONSTRAINT `DaysUsersHours_ibfk_1` FOREIGN KEY (`IdDay`) REFERENCES `Days` (`IdDay`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
