-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-07-2018 a las 22:21:44
-- Versión del servidor: 10.1.31-MariaDB
-- Versión de PHP: 5.6.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `kq000525_tp`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caja`
--

CREATE TABLE `caja` (
  `id` int(11) NOT NULL,
  `empleado` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `fecha` date NOT NULL,
  `mesa` int(11) NOT NULL,
  `cliente` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `codigoPedido` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `importe` float NOT NULL,
  `estado` varchar(30) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `caja`
--

INSERT INTO `caja` (`id`, `empleado`, `fecha`, `mesa`, `cliente`, `codigoPedido`, `importe`, `estado`) VALUES
(1000, 'admin', '2018-07-09', 4, 'leandro', '4UPBW', 1100, 'ok'),
(1001, 'admin', '2018-07-09', 9, 'Rodolfo', '9UWBP', 200, 'ok'),
(1002, 'admin', '2018-07-10', 6, 'Juan Perez', 'B9PL8', 300, 'ok'),
(1003, 'admin', '2018-07-10', 4, 'Juan Pelotas', '4UPBW', 180, 'ok'),
(1004, 'admin', '2018-07-10', 4, 'Juan Pelotas', '4UPBW', 180, 'ok'),
(1005, 'admin', '2018-07-10', 4, 'Juan Pelotas', '4UPBW', 180, 'ok'),
(1006, 'admin', '2018-07-10', 4, 'Juan Pelotas', '4UPBW', 180, 'ok'),
(1007, 'admin', '2018-07-10', 4, 'Juan Pelotas', '4UPBW', 180, 'ok');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carta`
--

CREATE TABLE `carta` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `precio` float NOT NULL,
  `sector` varchar(30) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `carta`
--

INSERT INTO `carta` (`id`, `descripcion`, `precio`, `sector`) VALUES
(100, 'asado', 250, 'cocineros'),
(101, 'milanesa', 80, 'cocineros'),
(102, 'revioles', 100, 'cocineros'),
(103, 'churrasco', 120, 'cocineros'),
(104, 'hamburguesa', 90, 'cocineros'),
(200, 'vino', 300, 'bartender'),
(201, 'gaseosa', 100, 'bartender'),
(202, 'soda', 80, 'bartender'),
(203, 'agua', 70, 'bartender'),
(204, 'aperitivo', 150, 'bartender'),
(300, 'jarra', 200, 'cerveceros'),
(301, 'chop', 150, 'cerveceros'),
(302, 'pinta', 120, 'cerveceros'),
(303, '1/2 pinta', 80, 'cerveceros'),
(304, 'lata', 70, 'cerveceros');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `tipo` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `pass` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `estado` varchar(30) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id`, `nombre`, `tipo`, `pass`, `estado`) VALUES
(21, 'admin', 'socios', 'admin', 'activo'),
(22, 'admin1', 'socios', 'admin1', 'activo'),
(23, 'leandro', 'cocineros', 'lea123', 'activo'),
(24, 'pepe', 'mozos', 'pepe123', 'activo'),
(25, 'jose', 'bartender', 'jose123', 'activo'),
(26, 'carlos', 'cerveceros', 'carlos123', 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encuesta`
--

CREATE TABLE `encuesta` (
  `id` int(11) NOT NULL,
  `codigoMesa` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `codigoPedido` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `mesa` int(11) NOT NULL,
  `restaurante` int(11) NOT NULL,
  `mozo` int(11) NOT NULL,
  `cocinero` int(11) NOT NULL,
  `experiencia` varchar(66) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `encuesta`
--

INSERT INTO `encuesta` (`id`, `codigoMesa`, `codigoPedido`, `mesa`, `restaurante`, `mozo`, `cocinero`, `experiencia`) VALUES
(1, 'LTOX2', '2BWUP', 8, 8, 8, 8, 'egnerklñgnerqinhqerigheqrnhñlgnerqlñkgnerqgñlknerglñkgnlregnlergnr'),
(2, 'LTOX2', '2BWUP', 8, 8, 8, 8, 'egnerklñgnerqinhqerigheqrnhñlgnerqlñkgnerqgñlknerglñkgnlregnlergnr'),
(3, 'LTOX2', '2BWUP', 8, 8, 8, 8, 'egnerklñgnerqinhqerigheqrnhñlgnerqlñkgnerqgñlknerglñkgnlregnlergnr'),
(4, 'LTOX2', '2BWUP', 8, 8, 8, 5, 'egnerklñgnerqinhqerigheqrnhñlgnerqlñkgnerqgñlknerglñkgnlregnlergnr'),
(5, 'LTOX2', '2BWUP', 8, 8, 2, 5, 'fddfsfsdfsdfdssdffsddsfsdf'),
(6, 'LTOX2', '2BWUP', 8, 8, 2, 5, 'fddfsfsdfsdfdssdffsddsfsdf'),
(7, 'LTOX2', '2BWUP', 8, 8, 2, 5, 'fddfsfsdfsdfdssdffsddsfsdf'),
(8, 'LTOX2', '2BWUP', 8, 8, 2, 5, 'fddfsfsdfsdfdssdffsddsfsdf');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `idEmpleado` int(11) NOT NULL,
  `tipo` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `metodo` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `ruta` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `fecha` date NOT NULL,
  `hora` varchar(30) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `login`
--

INSERT INTO `login` (`id`, `nombre`, `idEmpleado`, `tipo`, `metodo`, `ruta`, `fecha`, `hora`) VALUES
(17, 'pepe', 24, 'mozos', 'GET', '/comanda1/mesas/', '2018-07-10', '2:21:13'),
(18, 'leandro', 23, 'cocineros', 'GET', '/comanda1/pedidos/', '2018-07-10', '2:22:21'),
(19, 'leandro', 23, 'cocineros', 'GET', '/comanda1/pedidos/', '2018-07-10', '2:23:35'),
(20, 'pepe', 24, 'mozos', 'GET', '/comanda1/pedidos/', '2018-07-10', '2:24:58'),
(21, 'pepe', 24, 'mozos', 'POST', '/comanda1/pedidos/', '2018-07-10', '2:25:48'),
(22, 'admin', 21, 'socios', 'GET', '/comanda1/caja/', '2018-07-10', '2:29:28'),
(23, 'leandro', 23, 'cocineros', 'GET', '/comanda1/pedidos/', '2018-07-10', '2:33:29'),
(24, 'admin', 21, 'socios', 'GET', '/comanda1/caja/', '2018-07-10', '2:35:49'),
(25, 'admin', 21, 'socios', 'GET', '/comanda1/empleados/', '2018-07-10', '2:35:55'),
(26, 'pepe', 24, 'mozos', 'GET', '/comanda1/pedidos/', '2018-07-10', '2:36:13'),
(27, 'leandro', 23, 'cocineros', 'GET', '/comanda1/pedidos/', '2018-07-10', '2:36:17'),
(28, 'pepe', 24, 'mozos', 'GET', '/comanda1/mesas/', '2018-07-10', '2:36:26'),
(29, 'pepe', 24, 'mozos', 'GET', '/comanda1/mesas/', '2018-07-10', '2:46:4'),
(30, 'pepe', 24, 'mozos', 'GET', '/comanda1/mesas/', '2018-07-10', '2:47:3'),
(31, 'pepe', 24, 'mozos', 'GET', '/comanda1/mesas/', '2018-07-10', '2:47:54'),
(32, 'pepe', 24, 'mozos', 'GET', '/comanda1/mesas/', '2018-07-10', '2:48:11'),
(33, 'pepe', 24, 'mozos', 'GET', '/comanda1/mesas/', '2018-07-10', '2:48:31'),
(34, 'admin', 21, 'socios', 'GET', '/comanda1/empleados/', '2018-07-10', '2:49:47'),
(35, 'admin', 21, 'socios', 'GET', '/comanda1/empleados/', '2018-07-10', '2:54:19'),
(36, 'admin', 21, 'socios', 'GET', '/comanda1/empleados/', '2018-07-10', '2:55:5'),
(37, 'admin', 21, 'socios', 'GET', '/comanda1/mesas/', '2018-07-10', '2:55:58'),
(38, 'admin', 21, 'socios', 'GET', '/comanda1/empleados/', '2018-07-10', '3:12:16'),
(39, 'admin', 21, 'socios', 'GET', '/comanda1/caja/', '2018-07-10', '3:13:19'),
(40, 'pepe', 24, 'mozos', 'GET', '/comanda1/pedidos/', '2018-07-10', '3:14:25'),
(41, 'leandro', 23, 'cocineros', 'GET', '/comanda1/pedidos/', '2018-07-10', '3:14:32'),
(42, 'pepe', 24, 'mozos', 'GET', '/comanda1/mesas/', '2018-07-10', '3:14:46'),
(43, 'admin', 21, 'socios', 'GET', '/comanda1/mesas/', '2018-07-10', '3:15:38'),
(44, 'jose', 25, 'bartender', 'GET', '/comanda1/pedidos/', '2018-07-10', '3:38:16'),
(45, 'jose', 25, 'bartender', 'GET', '/comanda1/pedidos/', '2018-07-10', '3:38:38'),
(46, 'admin', 21, 'socios', 'POST', '/comanda1/empleados/', '2018-07-10', '3:39:42'),
(47, 'carlos', 26, 'cerveceros', 'GET', '/comanda1/pedidos/', '2018-07-10', '3:40:26'),
(48, 'carlos', 26, 'cerveceros', 'GET', '/comanda1/pedidos/', '2018-07-10', '3:40:34'),
(49, 'admin', 21, 'socios', 'GET', '/comanda1/empleados/', '2018-07-10', '3:43:0'),
(50, 'jose', 25, 'bartender', 'GET', '/comanda1/pedidos/', '2018-07-10', '4:7:58'),
(51, 'admin', 21, 'socios', 'GET', '/comanda1/pedidos/', '2018-07-10', '15:29:36'),
(52, 'admin', 21, 'socios', 'GET', '/comanda1/pedidos/', '2018-07-10', '17:17:34'),
(53, 'admin', 21, 'socios', 'GET', '/comanda1/encuesta/', '2018-07-10', '18:15:16'),
(54, 'admin', 21, 'socios', 'GET', '/comanda1/encuesta/', '2018-07-10', '18:16:17'),
(55, 'admin', 21, 'socios', 'GET', '/comanda1/encuesta/', '2018-07-10', '18:16:27'),
(56, 'admin', 21, 'socios', 'GET', '/comanda1/caja/', '2018-07-10', '18:25:9'),
(57, 'admin', 21, 'socios', 'GET', '/comanda1/caja/', '2018-07-10', '18:25:28'),
(58, 'admin', 21, 'socios', 'GET', '/comanda1/caja/', '2018-07-10', '18:25:47'),
(59, 'admin', 21, 'socios', 'GET', '/comanda1/caja/', '2018-07-10', '18:26:27'),
(60, 'admin', 21, 'socios', 'GET', '/comanda1/caja/', '2018-07-10', '18:34:27'),
(61, 'admin', 21, 'socios', 'GET', '/comanda1/caja/', '2018-07-10', '18:34:47'),
(62, 'admin', 21, 'socios', 'GET', '/comanda1/pedidos/', '2018-07-10', '18:52:16'),
(63, 'admin', 21, 'socios', 'POST', '/comanda1/caja/', '2018-07-10', '18:52:39'),
(64, 'leandro', 23, 'cocineros', 'GET', '/comanda1/pedidos/', '2018-07-10', '18:53:53'),
(65, 'leandro', 23, 'cocineros', 'POST', '/comanda1/pedidos/', '2018-07-10', '18:55:2'),
(66, 'leandro', 23, 'cocineros', 'POST', '/comanda1/pedidos/', '2018-07-10', '18:55:7'),
(67, 'leandro', 23, 'cocineros', 'POST', '/comanda1/pedidos/', '2018-07-10', '18:55:31'),
(68, 'leandro', 23, 'cocineros', 'POST', '/comanda1/pedidos/', '2018-07-10', '18:56:3'),
(69, 'leandro', 23, 'cocineros', 'GET', '/comanda1/pedidos/', '2018-07-10', '18:56:9'),
(70, 'leandro', 23, 'cocineros', 'PUT', '/comanda1/pedidos/', '2018-07-10', '18:57:10'),
(71, 'leandro', 23, 'cocineros', 'PUT', '/comanda1/pedidos/', '2018-07-10', '18:58:6'),
(72, 'admin', 21, 'socios', 'POST', '/comanda1/caja/', '2018-07-10', '18:58:16'),
(73, 'admin', 21, 'socios', 'POST', '/comanda1/caja/', '2018-07-10', '18:58:19'),
(74, 'pepe', 24, 'mozos', 'GET', '/comanda1/pedidos/', '2018-07-10', '18:59:20'),
(75, 'pepe', 24, 'mozos', 'PUT', '/comanda1/pedidos/', '2018-07-10', '18:59:52'),
(76, 'admin', 21, 'socios', 'POST', '/comanda1/caja/', '2018-07-10', '18:59:59'),
(77, 'pepe', 24, 'mozos', 'GET', '/comanda1/mesas/', '2018-07-10', '19:0:38'),
(78, 'pepe', 24, 'mozos', 'PUT', '/comanda1/mesas/', '2018-07-10', '19:2:5'),
(79, 'pepe', 24, 'mozos', 'PUT', '/comanda1/mesas/', '2018-07-10', '19:2:34'),
(80, 'admin', 21, 'socios', 'POST', '/comanda1/caja/', '2018-07-10', '19:2:42'),
(81, 'admin', 21, 'socios', 'POST', '/comanda1/caja/', '2018-07-10', '19:4:34'),
(82, 'admin', 21, 'socios', 'POST', '/comanda1/caja/', '2018-07-10', '19:6:4'),
(83, 'admin', 21, 'socios', 'POST', '/comanda1/caja/', '2018-07-10', '19:7:53'),
(84, 'admin', 21, 'socios', 'POST', '/comanda1/caja/', '2018-07-10', '19:8:28'),
(85, 'admin', 21, 'socios', 'POST', '/comanda1/caja/', '2018-07-10', '19:10:32'),
(86, 'admin', 21, 'socios', 'POST', '/comanda1/caja/', '2018-07-10', '19:10:56'),
(87, 'admin', 21, 'socios', 'POST', '/comanda1/caja/', '2018-07-10', '19:12:31'),
(88, 'admin', 21, 'socios', 'POST', '/comanda1/caja/', '2018-07-10', '19:12:58'),
(89, 'admin', 21, 'socios', 'POST', '/comanda1/caja/', '2018-07-10', '19:13:6'),
(90, 'admin', 21, 'socios', 'GET', '/comanda1/caja/', '2018-07-10', '21:20:21'),
(91, 'admin', 21, 'socios', 'POST', '/comanda1/caja/', '2018-07-10', '21:27:17'),
(92, 'admin', 21, 'socios', 'POST', '/comanda1/caja/', '2018-07-10', '21:27:37'),
(93, 'admin', 21, 'socios', 'POST', '/comanda1/caja/', '2018-07-10', '21:27:46'),
(94, 'admin', 21, 'socios', 'POST', '/comanda1/caja/', '2018-07-10', '21:28:58'),
(95, 'pepe', 24, 'mozos', 'PUT', '/comanda1/mesas/', '2018-07-10', '21:29:16'),
(96, 'pepe', 24, 'mozos', 'GET', '/comanda1/pedidos/', '2018-07-10', '21:29:38'),
(97, 'leandro', 23, 'cocineros', 'GET', '/comanda1/pedidos/', '2018-07-10', '21:46:15'),
(98, 'pepe', 24, 'mozos', 'GET', '/comanda1/pedidos/', '2018-07-10', '21:46:23'),
(99, 'admin', 21, 'socios', 'GET', '/comanda1/pedidos/', '2018-07-10', '21:47:10'),
(100, 'pepe', 24, 'mozos', 'PUT', '/comanda1/mesas/', '2018-07-10', '21:47:38'),
(101, 'pepe', 24, 'mozos', 'GET', '/comanda1/mesas/', '2018-07-10', '21:47:41');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesas`
--

CREATE TABLE `mesas` (
  `id` int(11) NOT NULL,
  `codigo` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `estado` varchar(50) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `mesas`
--

INSERT INTO `mesas` (`id`, `codigo`, `estado`) VALUES
(1, 'OTXL1', 'cerrada'),
(2, 'LTOX2', 'con cliente esperando pedido'),
(3, 'LTXO3', 'cerrada'),
(4, 'OLXT4', 'cerrada'),
(5, 'TXOL5', 'cerrada'),
(6, 'XLTO6', 'cerrada'),
(7, 'TLOX7', 'cerrada'),
(8, 'XTLO8', 'cerrada'),
(9, 'OLTX9', 'cerrada'),
(10, 'AMY10', 'cerrada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `idEmpleado` int(11) NOT NULL,
  `estado` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `cliente` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `mesa` int(11) NOT NULL,
  `idArticulo` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `importe` float NOT NULL,
  `codigo` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `foto` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `estimado` int(11) NOT NULL,
  `horaInicio` datetime NOT NULL,
  `horaFin` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `idEmpleado`, `estado`, `cliente`, `mesa`, `idArticulo`, `cantidad`, `importe`, `codigo`, `foto`, `estimado`, `horaInicio`, `horaFin`) VALUES
(1, 24, 'cancelado', 'Juan Perez', 6, 300, 2, 400, 'B9PL8', 'sin foto', 0, '2018-07-08 00:00:00', '2018-07-08 00:00:00'),
(3, 24, 'pagado', 'Juan Perez', 6, 200, 1, 300, 'B9PL8', 'sin foto', 15, '2018-07-08 01:00:00', '2018-07-10 00:12:15'),
(4, 24, 'pagado', 'Pedro Lopez', 5, 103, 1, 120, 'B89LP', 'sin foto', 0, '2018-07-08 01:00:00', '2018-07-08 00:00:00'),
(5, 24, 'pagado', 'Pedro Lopez', 5, 102, 1, 100, 'B89LP', 'Pedro_Lopez_5.jpg', 30, '2018-07-08 01:00:00', '0000-00-00 00:00:00'),
(6, 24, 'pagado', 'Pedro Lopez', 5, 103, 1, 120, 'B89LP', 'sin foto', 30, '2018-07-08 01:00:00', '0000-00-00 00:00:00'),
(7, 24, 'pagado', 'Pedro Lopez', 5, 203, 1, 70, 'B89LP', 'sin foto', 0, '2018-07-08 01:00:00', '2018-07-08 00:00:00'),
(8, 24, 'pagado', 'Pedro Lopez', 5, 204, 1, 150, 'B89LP', 'sin foto', 0, '2018-07-08 01:00:00', '2018-07-08 00:00:00'),
(9, 24, 'pagado', 'Rodolfo', 8, 202, 2, 160, '89LBP', 'sin foto', 15, '2018-07-08 16:31:52', '2018-07-09 23:30:26'),
(10, 24, 'pagado', 'Rodolfo', 9, 102, 2, 200, '9UWBP', 'sin foto', 0, '2018-07-09 01:49:09', '2018-07-09 02:07:07'),
(11, 21, 'pagado', 'leandro', 4, 200, 2, 600, '4UPBW', 'sin foto', 0, '2018-07-09 14:37:26', '0000-00-00 00:00:00'),
(12, 21, 'pagado', 'leandro', 4, 100, 2, 500, '4UPBW', 'sin foto', 0, '2018-07-09 14:39:25', '0000-00-00 00:00:00'),
(13, 24, 'pagado', 'Juan Pelotas', 4, 104, 2, 180, '4UPBW', 'sin foto', 30, '2018-07-10 00:44:09', '2018-07-10 18:58:06'),
(14, 24, 'pendiente', 'Juan Carlos', 2, 100, 2, 500, '2BWUP', 'sin foto', 30, '2018-07-10 16:40:48', '0000-00-00 00:00:00'),
(15, 24, 'pendiente', 'Juan Carlos', 2, 100, 2, 500, '2BWUP', 'sin foto', 15, '2018-07-10 16:00:48', '0000-00-00 00:00:00');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `caja`
--
ALTER TABLE `caja`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `carta`
--
ALTER TABLE `carta`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `encuesta`
--
ALTER TABLE `encuesta`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mesas`
--
ALTER TABLE `mesas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `caja`
--
ALTER TABLE `caja`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1008;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `encuesta`
--
ALTER TABLE `encuesta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
