-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-11-2024 a las 02:29:42
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `usuario`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `adopcion`
--

CREATE TABLE `adopcion` (
  `ID_ADOPCION` int(11) NOT NULL,
  `ID_USUARIO` int(11) NOT NULL,
  `ID_PERRO` int(11) NOT NULL,
  `FECHA_ADOPCION` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `adopcion`
--

INSERT INTO `adopcion` (`ID_ADOPCION`, `ID_USUARIO`, `ID_PERRO`, `FECHA_ADOPCION`) VALUES
(1, 0, 2, '2024-11-07'),
(2, 1, 2, '2024-11-07');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dueño`
--

CREATE TABLE `dueño` (
  `ID_ADOPTA` int(100) NOT NULL,
  `DNI` varchar(100) NOT NULL DEFAULT '100',
  `APELLIDO` varchar(100) NOT NULL,
  `NOMBRE` varchar(100) NOT NULL,
  `FECHA_ADOPCION` date NOT NULL,
  `EMAIL` varchar(100) NOT NULL,
  `CLAVE` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `dueño`
--

INSERT INTO `dueño` (`ID_ADOPTA`, `DNI`, `APELLIDO`, `NOMBRE`, `FECHA_ADOPCION`, `EMAIL`, `CLAVE`) VALUES
(0, '22396138', 'OJEDA', 'JUAN CARLOS', '2024-11-14', 'TARAGUI@GMAIL.COM', ''),
(1, '100', 'VALENZUEL', 'DAVID', '2024-11-07', 'RODOCROCITA@GMAIL.COM', ''),
(2, '26396138', 'ROMERO', 'ARIEL FABIAN', '2024-11-14', 'ROMERO@GMAIL.COM', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perro`
--

CREATE TABLE `perro` (
  `ID_PERRO` int(100) NOT NULL,
  `FECHA_INGRESO` date NOT NULL,
  `COLOR` text NOT NULL,
  `FECHA _ADOPCION` date NOT NULL,
  `ESTADO` enum('''DISPONIBLE''','''ADOPTADO''','','') NOT NULL DEFAULT '''ADOPTADO'''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `perro`
--

INSERT INTO `perro` (`ID_PERRO`, `FECHA_INGRESO`, `COLOR`, `FECHA _ADOPCION`, `ESTADO`) VALUES
(1, '2023-11-01', 'MARRON', '0000-00-00', '\'DISPONIBLE\''),
(2, '2024-11-01', 'BLANCO Y NEGRO', '2024-11-07', '\'ADOPTADO\'');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `adopcion`
--
ALTER TABLE `adopcion`
  ADD PRIMARY KEY (`ID_ADOPCION`),
  ADD UNIQUE KEY `ID_USUARIO` (`ID_USUARIO`);

--
-- Indices de la tabla `dueño`
--
ALTER TABLE `dueño`
  ADD PRIMARY KEY (`ID_ADOPTA`),
  ADD UNIQUE KEY `DNI` (`DNI`),
  ADD UNIQUE KEY `EMAIL` (`EMAIL`);

--
-- Indices de la tabla `perro`
--
ALTER TABLE `perro`
  ADD PRIMARY KEY (`ID_PERRO`),
  ADD UNIQUE KEY `FECHA _ADOPCION` (`FECHA _ADOPCION`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `adopcion`
--
ALTER TABLE `adopcion`
  MODIFY `ID_ADOPCION` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `dueño`
--
ALTER TABLE `dueño`
  MODIFY `ID_ADOPTA` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22641767;

--
-- AUTO_INCREMENT de la tabla `perro`
--
ALTER TABLE `perro`
  MODIFY `ID_PERRO` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
