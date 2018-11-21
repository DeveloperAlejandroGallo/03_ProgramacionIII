-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.34-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for 20181112_parcial
DROP DATABASE IF EXISTS `20181112_parcial`;
CREATE DATABASE IF NOT EXISTS `20181112_parcial` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish2_ci */;
USE `20181112_parcial`;

-- Dumping structure for table 20181112_parcial.compras
DROP TABLE IF EXISTS `compras`;
CREATE TABLE IF NOT EXISTS `compras` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idUsuario` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `marca` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `modelo` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `fecha` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_usuarios` (`idUsuario`),
  CONSTRAINT `FK_usuarios` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- Dumping data for table 20181112_parcial.compras: ~8 rows (approximately)
DELETE FROM `compras`;
/*!40000 ALTER TABLE `compras` DISABLE KEYS */;
INSERT INTO `compras` (`id`, `idUsuario`, `marca`, `modelo`, `precio`, `fecha`) VALUES
	(1, 'ag@gmail.com', 'samsung', 's7', 20000.00, '2018-11-18 23:22:42'),
	(2, 'dg@gmail.com', 'samsung', 's8', 30000.00, '2018-11-18 23:22:42'),
	(3, 'jf@gmail.com', 'nokia', '1100', 500.00, '2018-11-18 23:22:42'),
	(4, 'mp@gmail.com', 'huaweii', 'p9', 30000.00, '2018-11-18 23:22:42'),
	(5, 'ag@gmail.com', 'nokia', 'N85', 9000.00, '2018-11-18 23:22:42'),
	(6, 'dg@gmail.com', 'huaweii', 'p10', 30000.00, '2018-11-18 23:22:42'),
	(7, 'jf@gmail.com', 'htc', 'z12', 20000.00, '2018-11-18 23:22:42'),
	(13, 'ag@gmail.com', 'hwawei', 'p20-Lite', 30999.00, '2018-11-15 22:22:22'),
	(14, 'ag@gmail.com', 'hwawei', 'p20-Lite', 30999.00, '2018-11-15 22:22:22'),
	(15, 'ag@gmail.com', 'hwawei', 'p20-Lite', 30999.00, '2018-11-15 22:22:22'),
	(16, 'ag@gmail.com', 'hwawei', 'p20-Lite', 30999.00, '2018-11-15 22:22:22'),
	(17, 'ag@gmail.com', 'hwawei', 'p20-Lite', 30999.00, '2018-11-15 22:22:22'),
	(18, 'ag@gmail.com', 'hwawei', 'p20-Lite', 30999.00, '2018-11-15 22:22:22'),
	(19, 'ag@gmail.com', 'hwawei', 'p20-Lite', 30999.00, '2018-11-15 22:22:22'),
	(20, 'ag@gmail.com', 'hwawei', 'p20-Lite', 30999.00, '2018-11-15 22:22:22'),
	(21, 'ag@gmail.com', 'hwawei', 'p20-Lite', 30999.00, '2018-11-15 22:22:22'),
	(22, 'ag@gmail.com', 'hwawei', 'p20-Lite', 30999.00, '2018-11-15 22:22:22'),
	(23, 'ag@gmail.com', 'apple', '6s', 40000.00, '2018-11-20 21:22:23'),
	(24, 'ag@gmail.com', 'apple', '6s', 40000.00, '2018-11-20 21:22:23'),
	(25, 'ag@gmail.com', 'apple', '6s', 40000.00, '2018-11-20 21:22:23'),
	(26, 'ag@gmail.com', 'apple', '6s', 40000.00, '2018-11-20 21:22:23'),
	(27, 'ag@gmail.com', 'apple', '6s', 40000.00, '2018-11-20 21:22:23'),
	(28, 'ag@gmail.com', 'apple', '6s', 40000.00, '2018-11-20 21:22:23'),
	(29, 'ag@gmail.com', 'apple', '6s', 40000.00, '2018-11-20 21:22:23'),
	(30, 'dg@gmail.com', 'apple', '6s', 40000.00, '2018-11-20 21:22:23');
/*!40000 ALTER TABLE `compras` ENABLE KEYS */;

-- Dumping structure for procedure 20181112_parcial.getComprasUsuarios
DROP PROCEDURE IF EXISTS `getComprasUsuarios`;
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `getComprasUsuarios`(
	id_usuario varchar(30)
)
begin

	select * from usuarios u
	inner join compras c on c.idUsuario = u.email
	inner join productos p on p.id = c.idProducto
	where u.email = id_usuario ;

end//
DELIMITER ;

-- Dumping structure for table 20181112_parcial.logs
DROP TABLE IF EXISTS `logs`;
CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(30) COLLATE utf8_spanish2_ci NOT NULL DEFAULT '0',
  `metodo` varchar(30) COLLATE utf8_spanish2_ci NOT NULL DEFAULT '0',
  `ruta` varchar(100) COLLATE utf8_spanish2_ci NOT NULL DEFAULT '0',
  `hora` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- Dumping data for table 20181112_parcial.logs: ~15 rows (approximately)
DELETE FROM `logs`;
/*!40000 ALTER TABLE `logs` DISABLE KEYS */;
INSERT INTO `logs` (`id`, `usuario`, `metodo`, `ruta`, `hora`) VALUES
	(1, 'ag@gmail.com', 'listarEsta', 'mirtutahttp', '2018-11-18 20:29:48'),
	(2, 'ag@gmail.com', 'GET', 'compra/marca', '2018-11-18 21:25:22'),
	(3, 'ag@gmail.com', 'GET', 'compra/marca', '2018-11-18 21:26:07'),
	(4, 'ag@gmail.com', 'POST', 'compra', '2018-11-18 21:26:24'),
	(5, 'ag@gmail.com', 'GET', 'usuario', '2018-11-18 21:26:29'),
	(6, 'Sin loguear', 'POST', 'login', '2018-11-18 21:26:34'),
	(7, 'Usuario inválido', 'GET', 'compra', '2018-11-18 22:01:11'),
	(8, 'Sin loguear', 'POST', 'login', '2018-11-18 22:01:23'),
	(9, 'ag@gmail.com', 'GET', 'compra', '2018-11-18 22:01:57'),
	(10, 'Sin loguear', 'POST', 'login', '2018-11-18 23:16:42'),
	(11, 'ag@gmail.com', 'POST', 'compra', '2018-11-18 23:17:26'),
	(12, 'ag@gmail.com', 'POST', 'compra', '2018-11-18 23:20:19'),
	(13, 'ag@gmail.com', 'POST', 'compra', '2018-11-18 23:20:50'),
	(14, 'ag@gmail.com', 'POST', 'compra', '2018-11-18 23:21:47'),
	(15, 'ag@gmail.com', 'POST', 'compra', '2018-11-18 23:22:49'),
	(16, 'ag@gmail.com', 'POST', 'compra', '2018-11-18 23:24:19'),
	(17, 'ag@gmail.com', 'POST', 'compra', '2018-11-18 23:25:22'),
	(18, 'ag@gmail.com', 'POST', 'compra', '2018-11-18 23:25:49'),
	(19, 'ag@gmail.com', 'POST', 'compra', '2018-11-18 23:26:16'),
	(20, 'ag@gmail.com', 'POST', 'compra', '2018-11-18 23:31:10'),
	(21, 'ag@gmail.com', 'POST', 'compra', '2018-11-18 23:32:04'),
	(22, 'ag@gmail.com', 'POST', 'compra', '2018-11-18 23:33:18'),
	(23, 'ag@gmail.com', 'POST', 'compra', '2018-11-18 23:34:18'),
	(24, 'ag@gmail.com', 'POST', 'compra', '2018-11-18 23:35:03'),
	(25, 'ag@gmail.com', 'POST', 'compra', '2018-11-18 23:35:19'),
	(26, 'ag@gmail.com', 'POST', 'compra', '2018-11-18 23:35:52'),
	(27, 'ag@gmail.com', 'POST', 'compra', '2018-11-18 23:36:36'),
	(28, 'Usuario inválido', 'POST', 'compra', '2018-11-18 23:36:58'),
	(29, 'Sin loguear', 'POST', 'login', '2018-11-18 23:37:07'),
	(30, 'ag@gmail.com', 'POST', 'compra', '2018-11-18 23:37:28'),
	(31, 'ag@gmail.com', 'POST', 'compra', '2018-11-18 23:38:19'),
	(32, 'ag@gmail.com', 'POST', 'compra', '2018-11-18 23:38:26'),
	(33, 'ag@gmail.com', 'POST', 'compra', '2018-11-18 23:40:45'),
	(34, 'ag@gmail.com', 'POST', 'compra', '2018-11-18 23:41:42'),
	(35, 'ag@gmail.com', 'POST', 'compra', '2018-11-18 23:42:50'),
	(36, 'ag@gmail.com', 'POST', 'compra', '2018-11-18 23:43:10'),
	(37, 'ag@gmail.com', 'POST', 'compra', '2018-11-18 23:43:27'),
	(38, 'ag@gmail.com', 'POST', 'compra', '2018-11-18 23:43:49'),
	(39, 'ag@gmail.com', 'POST', 'compra', '2018-11-18 23:45:44'),
	(40, 'Sin loguear', 'GET', '', '2018-11-18 23:52:34'),
	(41, 'Sin loguear', 'POST', 'login', '2018-11-18 23:52:53'),
	(42, 'ag@gmail.com', 'GET', '', '2018-11-18 23:53:05'),
	(43, 'ag@gmail.com', 'GET', '', '2018-11-18 23:53:45'),
	(44, 'Sin loguear', 'POST', 'login', '2018-11-18 23:56:47'),
	(45, 'ag@gmail.com', 'GET', 'usuario', '2018-11-18 23:57:05'),
	(46, 'ag@gmail.com', 'GET', 'compra', '2018-11-18 23:57:20'),
	(47, 'ag@gmail.com', 'GET', 'compra/marca', '2018-11-18 23:57:36'),
	(48, 'ag@gmail.com', 'POST', 'compra', '2018-11-18 23:57:52'),
	(49, 'ag@gmail.com', 'POST', 'compra', '2018-11-18 23:59:14'),
	(50, 'ag@gmail.com', 'POST', 'compra', '2018-11-18 23:59:27'),
	(51, 'ag@gmail.com', 'POST', 'compra', '2018-11-18 23:59:46'),
	(52, 'ag@gmail.com', 'POST', 'compra', '2018-11-19 00:01:21'),
	(53, 'Sin loguear', 'POST', 'usuario', '2018-11-19 00:10:10'),
	(54, 'Sin loguear', 'POST', 'usuario', '2018-11-19 00:12:11'),
	(55, 'Sin loguear', 'POST', 'usuario', '2018-11-19 00:12:35'),
	(56, 'Sin loguear', 'POST', 'usuario', '2018-11-19 00:14:55'),
	(57, 'Usuario inválido', 'POST', 'login', '2018-11-19 00:18:12'),
	(58, 'Usuario inválido', 'POST', 'usuario', '2018-11-19 00:18:18'),
	(59, 'Sin loguear', 'POST', 'usuario', '2018-11-19 00:19:34'),
	(60, 'Sin loguear', 'POST', 'login', '2018-11-19 02:01:37'),
	(61, 'Sin loguear', 'POST', 'usuario', '2018-11-19 02:01:55'),
	(62, 'Sin loguear', 'POST', 'usuario', '2018-11-19 02:07:09'),
	(63, 'Sin loguear', 'POST', 'usuario', '2018-11-19 02:07:58'),
	(64, 'Sin loguear', 'POST', 'usuario', '2018-11-19 02:08:47'),
	(65, 'Sin loguear', 'POST', 'usuario', '2018-11-19 02:09:02'),
	(66, 'Sin loguear', 'POST', 'login', '2018-11-19 02:13:58'),
	(67, 'aa@gmail.com', 'GET', 'usuario', '2018-11-19 02:14:10'),
	(68, 'Sin loguear', 'POST', 'login', '2018-11-19 02:14:50'),
	(69, 'dg@gmail.com', 'GET', 'usuario', '2018-11-19 02:15:01'),
	(70, 'dg@gmail.com', 'GET', 'compra', '2018-11-19 02:15:40'),
	(71, 'Sin loguear', 'POST', 'login', '2018-11-19 02:15:55'),
	(72, 'ag@gmail.com', 'GET', 'compra', '2018-11-19 02:16:04'),
	(73, 'Sin loguear', 'POST', 'login', '2018-11-19 02:42:43'),
	(74, 'Usuario inválido', 'GET', 'compra/marca', '2018-11-19 02:43:22'),
	(75, 'ag@gmail.com', 'GET', 'compra/marca', '2018-11-19 02:43:29'),
	(76, 'ag@gmail.com', 'GET', 'compra/marca', '2018-11-19 02:43:38'),
	(77, 'ag@gmail.com', 'GET', 'compra/marca', '2018-11-19 02:43:45'),
	(78, 'Sin loguear', 'POST', 'login', '2018-11-19 02:44:03'),
	(79, 'dg@gmail.com', 'GET', 'compra/marca', '2018-11-19 02:44:13'),
	(80, 'dg@gmail.com', 'POST', 'compra', '2018-11-19 02:44:58'),
	(81, 'dg@gmail.com', 'GET', '', '2018-11-19 02:45:11'),
	(82, 'dg@gmail.com', 'GET', 'productos', '2018-11-19 02:47:16');
/*!40000 ALTER TABLE `logs` ENABLE KEYS */;

-- Dumping structure for table 20181112_parcial.productos
DROP TABLE IF EXISTS `productos`;
CREATE TABLE IF NOT EXISTS `productos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `marca` varchar(30) COLLATE utf8_spanish2_ci NOT NULL DEFAULT '',
  `modelo` varchar(30) COLLATE utf8_spanish2_ci NOT NULL DEFAULT '',
  `precio` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- Dumping data for table 20181112_parcial.productos: ~5 rows (approximately)
DELETE FROM `productos`;
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
INSERT INTO `productos` (`id`, `marca`, `modelo`, `precio`) VALUES
	(1, 'samsung', 's7', 20000.00),
	(2, 'samsung', 's7-Edge', 25000.00),
	(3, 'samsung', 's8', 30000.00),
	(4, 'samsung', 's9', 50000.00),
	(5, 'nokia', '1100', 500.00);
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;

-- Dumping structure for table 20181112_parcial.usuarios
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `email` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `clave` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `perfil` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- Dumping data for table 20181112_parcial.usuarios: ~4 rows (approximately)
DELETE FROM `usuarios`;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` (`email`, `clave`, `perfil`) VALUES
	('aa@gmail.com', '1234', 'admin'),
	('ag@gmail.com', '1234', 'admin'),
	('dg@gmail.com', '1234', 'user'),
	('ja@gmail.com', '1234', 'user'),
	('jf@gmail.com', '1234', 'admin'),
	('mp@gmail.com', '1234', 'user'),
	('xx@gmail.com', '1234', 'user'),
	('yy@gmail.com', '1234', 'user');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
