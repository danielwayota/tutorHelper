SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


DROP TABLE IF EXISTS `Config`;
CREATE TABLE `Config` (
  `BasePrice` float NOT NULL,
  `MaxPeoplePerDay` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `Config` (`BasePrice`, `MaxPeoplePerDay`) VALUES
(10, 8);

DROP TABLE IF EXISTS `ConfigSchedules`;
CREATE TABLE `ConfigSchedules` (
  `IdConfigSchedule` int(11) NOT NULL,
  `Name` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `IsDefault` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `ConfigSchedules` (`IdConfigSchedule`, `Name`, `IsDefault`) VALUES
(1, 'LunAJue', 1),
(2, 'Vie', 0);

DROP TABLE IF EXISTS `ConfigSchedulesHours`;
CREATE TABLE `ConfigSchedulesHours` (
  `IdConfigSchedule` int(11) NOT NULL,
  `IdHour` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

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

DROP TABLE IF EXISTS `Days`;
CREATE TABLE `Days` (
  `IdDay` int(11) NOT NULL,
  `DayDate` date NOT NULL,
  `MaxPeopleOverride` int(11) NOT NULL DEFAULT '0',
  `Locked` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

DROP TABLE IF EXISTS `Hours`;
CREATE TABLE `Hours` (
  `IdHour` int(11) NOT NULL,
  `HourString` varchar(12) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `Hours` (`IdHour`, `HourString`) VALUES
(1, '3:30'),
(2, '4:30'),
(3, '5:30'),
(4, '6:30'),
(5, '7:30');

DROP TABLE IF EXISTS `Pages`;
CREATE TABLE `Pages` (
  `IdPage` int(11) NOT NULL,
  `Title` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `Content` text COLLATE utf8_spanish_ci NOT NULL,
  `Position` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

DROP TABLE IF EXISTS `Users`;
CREATE TABLE `Users` (
  `IdUser` int(11) NOT NULL,
  `Name` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `Email` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `Password` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `Enabled` tinyint(1) NOT NULL DEFAULT '1',
  `IsSuperAdmin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `Users` (`IdUser`, `Name`, `Email`, `Password`, `Enabled`, `IsSuperAdmin`) VALUES
(1, 'Admin', 'admin@admin.es', 'dc647eb65e6711e155375218212b3964', 1, 1);

DROP TABLE IF EXISTS `UsersData`;
CREATE TABLE `UsersData` (
  `IdUserData` int(11) NOT NULL,
  `IdUser` int(11) NOT NULL,
  `Comments` text COLLATE utf8_spanish_ci,
  `PriceOverride` float NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `DaysUsers`
--

DROP TABLE IF EXISTS `DaysUsersHours`;
CREATE TABLE `DaysUsersHours` (
  `IdDay` int(11) NOT NULL,
  `IdUser` int(11) DEFAULT NULL,
  `IdHour` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


ALTER TABLE `ConfigSchedules`
  ADD PRIMARY KEY (`IdConfigSchedule`);

ALTER TABLE `Days`
  ADD PRIMARY KEY (`IdDay`);

ALTER TABLE `Hours`
  ADD PRIMARY KEY (`IdHour`);

ALTER TABLE `Pages`
  ADD PRIMARY KEY (`IdPage`);

ALTER TABLE `Users`
  ADD PRIMARY KEY (`IdUser`);

ALTER TABLE `UsersData`
  ADD PRIMARY KEY (`IdUserData`);


ALTER TABLE `ConfigSchedules`
  MODIFY `IdConfigSchedule` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `Days`
  MODIFY `IdDay` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `Hours`
  MODIFY `IdHour` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

ALTER TABLE `Pages`
  MODIFY `IdPage` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `Users`
  MODIFY `IdUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `UsersData`
  MODIFY `IdUserData` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
