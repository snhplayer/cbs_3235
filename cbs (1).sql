-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Дек 22 2023 г., 09:31
-- Версия сервера: 10.4.28-MariaDB
-- Версия PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `cbs`
--

-- --------------------------------------------------------

--
-- Структура таблицы `bookings`
--

CREATE TABLE `bookings` (
  `BookingID` int(11) NOT NULL,
  `SessionID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `RowNumber` int(11) NOT NULL,
  `SeatNumber` int(11) NOT NULL,
  `BookingTime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `movies`
--

CREATE TABLE `movies` (
  `MovieID` int(11) NOT NULL,
  `Title` varchar(100) NOT NULL,
  `Description` text DEFAULT NULL,
  `Image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `movies`
--

INSERT INTO `movies` (`MovieID`, `Title`, `Description`, `Image`) VALUES
(1, 'Бойцовский клуб', '«Бойцо́вский клуб» (англ. Fight Club) — американский психологический триллер 1999 года режиссёра Дэвида Финчера по мотивам одноимённого романа Чака Паланика, вышедшего тремя годами ранее. Главные роли исполнили Эдвард Нортон, Брэд Питт и Хелена Бонэм Картер. Нортон сыграл роль безымянного рассказчика — обезличенного обывателя, который недоволен своей жизнью в постиндустриальном обществе потребления так называемых «белых воротничков».', '1.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `sessions`
--

CREATE TABLE `sessions` (
  `SessionID` int(11) NOT NULL,
  `MovieID` int(11) NOT NULL,
  `SessionTime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `sessions`
--

INSERT INTO `sessions` (`SessionID`, `MovieID`, `SessionTime`) VALUES
(24, 1, '2023-12-22 18:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `PasswordHash` varchar(256) NOT NULL,
  `Telegram` varchar(50) DEFAULT NULL,
  `IsAdmin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`UserID`, `Username`, `PasswordHash`, `Telegram`, `IsAdmin`) VALUES
(50, 'test', 'eeb282539220fa206a1f16e69bfa9811c9dc8944bf0f04f9bcfb770366681712', 'jndscm', 0),
(51, 'test123', 'ecd71870d1963316a97e3ac3408c9835ad8cf0f3c1bc703527c30265534f75ae', 'jndscm', 0),
(52, 'test1234', '937e8d5fbb48bd4949536cd65b8d35c426b80d2f830c5c308e2cdec422ae2244', 'jndscm', 1),
(53, 'test_code', '3aa0041781f53f591089fa2aeed013200e54828311ae3f4f4f343edba87dc071', 'jndscm', 0),
(54, 'zxczxc', 'a0ec06301bf1814970a70f89d1d373afdff9a36d1ba6675fc02f8a975f4efaeb', 'jndscm', 0),
(55, 'zxcvf', '78d3ee6036eec0a3d0e128a0dd63ce53937f97831c959621a74393a0bf296c46', 'jndscm', 0),
(56, 'aaaaaahelp', '3314b29469902f5238640596bf1dabdd74ca3eeb686dc5eeb636849244aa002d', 'jndscm', 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`BookingID`),
  ADD KEY `SessionID` (`SessionID`),
  ADD KEY `UserID` (`UserID`);

--
-- Индексы таблицы `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`MovieID`);

--
-- Индексы таблицы `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`SessionID`),
  ADD KEY `MovieID` (`MovieID`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `bookings`
--
ALTER TABLE `bookings`
  MODIFY `BookingID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT для таблицы `movies`
--
ALTER TABLE `movies`
  MODIFY `MovieID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT для таблицы `sessions`
--
ALTER TABLE `sessions`
  MODIFY `SessionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`SessionID`) REFERENCES `sessions` (`SessionID`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);

--
-- Ограничения внешнего ключа таблицы `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions_ibfk_1` FOREIGN KEY (`MovieID`) REFERENCES `movies` (`MovieID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
