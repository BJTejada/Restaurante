-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-11-2024 a las 04:26:17
-- Versión del servidor: 8.0.40
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `restaurante`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `idcategoria` int NOT NULL,
  `categoria` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`idcategoria`, `categoria`) VALUES
(1, 'bebida'),
(2, 'plato'),
(3, 'entrada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `idcliente` int NOT NULL,
  `nombres` varchar(150) NOT NULL,
  `apellidos` varchar(150) NOT NULL,
  `correo` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`idcliente`, `nombres`, `apellidos`, `correo`) VALUES
(1, 'JUAN PEPE', 'CALVO CALVITO', 'juanito@gmail.com'),
(2, 'PEPE PELOS', 'DE LA O', 'pepepelitos@gmail.com'),
(3, 'MANUEL DE JESUS', 'TEJADA PINEDA', 'manuchus@gmail.com'),
(4, 'JEFERSON ALEXIS', 'TEJADA PINEDA', 'jefito@gmail.com'),
(5, 'KARINA YESENIA', 'TEJADA PINEDA', 'karinyes@gmail.com'),
(6, 'LUCY YESENIA ', 'PINEDA DE TEJADA', 'lucipineda@gmail.com'),
(7, 'MARCO ANTONIO', 'SOLIS', 'marcoantonio@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallefactura`
--

CREATE TABLE `detallefactura` (
  `iddetallefactura` int NOT NULL,
  `idfactura` int DEFAULT NULL,
  `idmenu` int DEFAULT NULL,
  `cantidad` int DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `detallefactura`
--

INSERT INTO `detallefactura` (`iddetallefactura`, `idfactura`, `idmenu`, `cantidad`, `subtotal`) VALUES
(1, 1, 1, 2, 19.50),
(26, 2, 1, 2, 19.00),
(27, 2, 3, 2, 1.80),
(39, 3, 5, 2, 9.00),
(40, 3, 2, 2, 20.00),
(48, 3, 5, 3, 13.50),
(49, 2, 3, 2, 1.80),
(51, 11, 2, 2, 20.00),
(52, 11, 3, 2, 1.80),
(53, 11, 5, 3, 13.50),
(54, 12, 1, 3, 28.50),
(55, 13, 2, 1, 10.00),
(56, 14, 1, 2, 19.00),
(57, 15, 4, 4, 12.00),
(58, 16, 1, 2, 19.00),
(59, 16, 5, 1, 4.50),
(60, 17, 1, 12, 114.00),
(61, 18, 2, 2, 20.00),
(62, 18, 4, 1, 3.00),
(63, 18, 5, 2, 9.00),
(64, 18, 1, 3, 28.50),
(65, 18, 2, 2, 20.00),
(68, 19, 4, 1, 3.00),
(69, 19, 5, 2, 9.00),
(70, 19, 1, 2, 19.00),
(71, 20, 3, 3, 2.70),
(72, 20, 5, 2, 9.00),
(73, 20, 1, 2, 19.00),
(74, 21, 3, 1, 0.90),
(75, 21, 1, 3, 28.50),
(76, 21, 3, 2, 1.80),
(77, 22, 3, 4, 3.60),
(78, 22, 5, 2, 9.00),
(79, 22, 1, 4, 38.00),
(80, 24, 4, 1, 3.00),
(81, 24, 1, 4, 38.00),
(82, 25, 4, 1, 3.00),
(83, 25, 1, 2, 19.00),
(84, 26, 1, 3, 28.50),
(85, 26, 3, 3, 2.70),
(86, 26, 5, 3, 13.50),
(87, 27, 3, 2, 1.80),
(88, 27, 4, 1, 3.00),
(89, 27, 5, 2, 9.00),
(90, 27, 1, 4, 38.00),
(91, 28, 3, 3, 2.70),
(92, 28, 5, 3, 13.50),
(93, 28, 1, 3, 28.50),
(94, 29, 3, 4, 3.60),
(95, 29, 5, 2, 9.00),
(96, 29, 1, 4, 38.00),
(97, 30, 4, 1, 3.00),
(98, 30, 5, 2, 9.00),
(99, 30, 1, 4, 38.00),
(100, 31, 6, 1, 1.25),
(101, 31, 5, 1, 4.50),
(102, 31, 1, 4, 38.00),
(103, 32, 3, 2, 1.80),
(104, 32, 5, 2, 9.00),
(105, 32, 1, 3, 28.50),
(106, 33, 3, 2, 1.80),
(107, 33, 5, 2, 9.00),
(108, 33, 1, 3, 28.50);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `idempleado` int NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `dui` varchar(15) NOT NULL,
  `salario` varchar(10) NOT NULL,
  `usuario` varchar(20) NOT NULL,
  `psw` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `rol` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`idempleado`, `nombre`, `apellido`, `dui`, `salario`, `usuario`, `psw`, `rol`) VALUES
(1, 'JUAN', 'CALIDONIO', '20394859-1', '250', 'JUANITO', '$2y$10$CNE3xO55APP56sVdUPHuBuIcn1sMVckhNPV6li5zosp5lfyc6WqQe', 2),
(2, 'MARIO', 'TORRES', '3929304-9', '500', 'ADMIN', '$2y$10$U2tlIV8NlzwfGNpAXW9Vge8bbDOnY8fH9cBnOcpoAviT6wiqPgP8C', 1),
(3, 'BYRON JOSÉ', 'TEJADA PINEDA', '02390459-4', '340', 'BJTP', '$2y$10$c24zVOEh.nsQjIjanvPrwe5mr4G.kSOSLakKaQatnTmeJDMXMFHhS', 2),
(4, 'STEVEN DAVID ', 'HERNANDEZ', '29304930-1', '300.22', 'STEVEN', '$2y$10$r9N4zNzokDZTnDjROvcg1uByTD7NDRTgF9MWPjgiC0O.Y0M9NSHn6', 2),
(5, 'PATRICIO ROSADO', ' DEL MAR ESTRELLA', '28389240-4', '50.23', 'PATRICIO', '$2y$10$Rv/g4feztq9HhpuY91jU/O4NyK/U14xhCD1teC45ogj3qsuBt2NIe', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `idfactura` int NOT NULL,
  `idcliente` int DEFAULT NULL,
  `idmesa` int DEFAULT NULL,
  `direccionDelivery` varchar(250) DEFAULT NULL,
  `idempleado` int DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `total` decimal(20,3) DEFAULT NULL,
  `estadofactura` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `factura`
--

INSERT INTO `factura` (`idfactura`, `idcliente`, `idmesa`, `direccionDelivery`, `idempleado`, `fecha`, `total`, `estadofactura`) VALUES
(1, 4, 7, NULL, 1, '2024-11-16', 20.800, 'finalizada'),
(2, 3, 4, NULL, 1, '2024-11-16', 22.600, 'finalizada'),
(3, 4, 2, NULL, 1, '2024-11-16', 42.500, 'finalizada'),
(11, 2, 3, NULL, 1, '2024-11-17', 35.300, 'finalizada'),
(12, 2, 8, NULL, 1, '2024-11-17', 28.500, 'finalizada'),
(13, 5, 9, NULL, 1, '2024-11-17', 10.000, 'finalizada'),
(14, 1, 9, NULL, 1, '2024-11-17', 19.000, 'finalizada'),
(15, 2, 9, NULL, 1, '2024-11-17', 12.000, 'finalizada'),
(16, 1, 9, NULL, 1, '2024-11-17', 23.500, 'finalizada'),
(17, 1, 9, NULL, 1, '2024-11-18', 114.000, 'finalizada'),
(18, 7, 2, NULL, 1, '2024-11-19', 80.500, 'finalizada'),
(19, 5, 9, NULL, 1, '2024-11-19', 31.000, 'finalizada'),
(20, 5, 9, NULL, 1, '2024-11-20', 30.700, 'finalizada'),
(21, 7, 9, NULL, 1, '2024-11-20', 31.200, 'finalizada'),
(22, 5, 2, NULL, 1, '2024-11-20', 50.600, 'finalizada'),
(23, 6, 9, NULL, 1, '2024-11-20', 0.000, 'finalizada'),
(24, 3, 7, NULL, 1, '2024-11-20', 41.000, 'finalizada'),
(25, 2, 3, NULL, 1, '2024-11-20', 22.000, 'finalizada'),
(26, 4, 9, NULL, 1, '2024-11-20', 44.700, 'finalizada'),
(27, 6, 9, NULL, 1, '2024-11-20', 51.800, 'finalizada'),
(28, 5, 8, NULL, 1, '2024-11-20', 44.700, 'finalizada'),
(29, 6, 9, NULL, 1, '2024-11-20', 50.600, 'finalizada'),
(30, 1, 9, NULL, 1, '2024-11-20', 50.000, 'finalizada'),
(31, 6, 9, NULL, 1, '2024-11-20', 43.750, 'finalizada'),
(32, 6, 9, NULL, 1, '2024-11-20', 39.300, 'finalizada'),
(33, 7, 9, NULL, 1, '2024-11-20', 39.300, 'finalizada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu`
--

CREATE TABLE `menu` (
  `idmenu` int NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `idcategoria` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `menu`
--

INSERT INTO `menu` (`idmenu`, `nombre`, `descripcion`, `precio`, `idcategoria`) VALUES
(1, 'hamburguesa', 'doble carne, papas y soda', 9.50, 2),
(2, 'alitas bbq', '15 alitas y orden de papas', 10.00, 2),
(3, 'coca cola', 'lata', 0.90, 1),
(4, 'fanta 3lt', '2.5 lt', 3.00, 1),
(5, 'pan con ajo', 'queso y oregano', 4.50, 3),
(6, 'coca cola', 'embase', 1.25, 1),
(7, 'pizza suprema', 'peperoni, jamon, hongos, carne, queso y chorizo', 17.00, 2),
(8, 'nachos ', 'nachos con queso, jalapeño, chili, frijoles y adereso', 5.00, 3),
(9, 'salchipapa', 'papas con salchicha, chorizo, queso, y aderezos', 6.00, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesa`
--

CREATE TABLE `mesa` (
  `idmesa` int NOT NULL,
  `numero` int NOT NULL,
  `zona` varchar(50) NOT NULL,
  `capacidad` int NOT NULL,
  `estadoMesa` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `mesa`
--

INSERT INTO `mesa` (`idmesa`, `numero`, `zona`, `capacidad`, `estadoMesa`) VALUES
(2, 2, 'mirador', 4, 'disponible'),
(3, 3, 'barra', 2, 'disponible'),
(4, 4, 'planta baja', 4, 'disponible'),
(5, 5, 'planta alta', 2, 'disponible'),
(6, 6, 'planta alta', 6, 'disponible'),
(7, 7, 'terrasa', 6, 'disponible'),
(8, 9, 'bar', 5, 'disponible'),
(9, 1, 'mirador', 4, 'disponible');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reserva`
--

CREATE TABLE `reserva` (
  `idreserva` int NOT NULL,
  `fecha` date DEFAULT NULL,
  `personas` int NOT NULL,
  `estado` int NOT NULL,
  `idmesa` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`idcategoria`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`idcliente`);

--
-- Indices de la tabla `detallefactura`
--
ALTER TABLE `detallefactura`
  ADD PRIMARY KEY (`iddetallefactura`),
  ADD KEY `idfactura` (`idfactura`),
  ADD KEY `idmenu` (`idmenu`);

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`idempleado`);

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`idfactura`),
  ADD KEY `idcliente` (`idcliente`),
  ADD KEY `idmesa` (`idmesa`),
  ADD KEY `idempleado` (`idempleado`);

--
-- Indices de la tabla `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`idmenu`),
  ADD KEY `idcategoria` (`idcategoria`);

--
-- Indices de la tabla `mesa`
--
ALTER TABLE `mesa`
  ADD PRIMARY KEY (`idmesa`);

--
-- Indices de la tabla `reserva`
--
ALTER TABLE `reserva`
  ADD PRIMARY KEY (`idreserva`),
  ADD KEY `idmesa` (`idmesa`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `idcategoria` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `idcliente` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `detallefactura`
--
ALTER TABLE `detallefactura`
  MODIFY `iddetallefactura` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT de la tabla `empleado`
--
ALTER TABLE `empleado`
  MODIFY `idempleado` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `idfactura` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `menu`
--
ALTER TABLE `menu`
  MODIFY `idmenu` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `mesa`
--
ALTER TABLE `mesa`
  MODIFY `idmesa` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `reserva`
--
ALTER TABLE `reserva`
  MODIFY `idreserva` int NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detallefactura`
--
ALTER TABLE `detallefactura`
  ADD CONSTRAINT `detallefactura_ibfk_1` FOREIGN KEY (`idfactura`) REFERENCES `factura` (`idfactura`),
  ADD CONSTRAINT `detallefactura_ibfk_2` FOREIGN KEY (`idmenu`) REFERENCES `menu` (`idmenu`);

--
-- Filtros para la tabla `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `factura_ibfk_1` FOREIGN KEY (`idcliente`) REFERENCES `cliente` (`idcliente`),
  ADD CONSTRAINT `factura_ibfk_2` FOREIGN KEY (`idmesa`) REFERENCES `mesa` (`idmesa`),
  ADD CONSTRAINT `factura_ibfk_3` FOREIGN KEY (`idempleado`) REFERENCES `empleado` (`idempleado`);

--
-- Filtros para la tabla `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`idcategoria`) REFERENCES `categoria` (`idcategoria`);

--
-- Filtros para la tabla `reserva`
--
ALTER TABLE `reserva`
  ADD CONSTRAINT `reserva_ibfk_1` FOREIGN KEY (`idmesa`) REFERENCES `mesa` (`idmesa`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
