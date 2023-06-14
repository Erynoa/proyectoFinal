-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-06-2023 a las 17:54:36
-- Versión del servidor: 10.1.38-MariaDB
-- Versión de PHP: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dawsport`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `codCategoria` int(10) NOT NULL,
  `nombreCat` varchar(20) NOT NULL,
  `descripcionCat` varchar(200) NOT NULL,
  `tipo` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`codCategoria`, `nombreCat`, `descripcionCat`, `tipo`) VALUES
(1, 'Ropa', 'Conjunto de prendas de vestir.', 'gen'),
(2, 'Calzado', 'Prenda de vestir que cubre y resguarda el pie y a veces también parte de la pierna.', 'gen'),
(3, 'Baño', 'Prenda de vestir elástica que se usa para bañarse o para tomar el sol.', 'gen'),
(4, 'Accesorios', 'Objetos útiles para la realización de ejercicio', 'gen'),
(5, 'Ciclismo', 'Deporte o ejercicio que se practica en bicicleta y que engloba diversas modalidades, como las de carretera, montaña y pista; en las pruebas ciclistas se compite en velocidad, habilidad o resistencia.', 'dep'),
(6, 'Fútbol', 'Deporte que se practica entre dos equipos de once jugadores que tratan de introducir un balón en la portería del contrario impulsándolo con los pies o la cabeza principalmente.', 'dep'),
(7, 'Baloncesto', 'Deporte que se practica, en una cancha rectangular, entre dos equipos de cinco jugadores que tratan de introducir el balón en la canasta contraria valiéndose solo de las manos.', 'dep'),
(8, 'Voleibol', 'Deporte que se practica entre dos equipos de seis jugadores en una cancha rectangular dividida por una red. El objetivo es golpear el balón con manos o brazos para pasarlo al otro lado y marcar.', 'dep'),
(9, 'Fútbol sala', 'Variante del fútbol que se practica entre dos equipos de cinco jugadores con un balón más duro y más pequeño', 'dep'),
(10, 'Rugby', 'Deporte que se practica entre dos equipos de quince jugadores que tratan de llevar un balón ovalado más allá de una línea de meta del equipo contrario o de pasarlo por la portería', 'dep'),
(11, 'Tenis', 'Deporte que se practica entre dos jugadores o dos parejas consiste en impulsar una pelota con una raqueta por encima de la red intentando que bote en el campo contrario.', 'dep'),
(12, 'Esquí', 'Deporte que consiste en deslizarse con estos patines sobre la nieve.', 'dep'),
(13, 'Snowboard', 'Modalidad de esquí que consiste en descender por la nieve sobre una sola tabla y sin bastones.', 'dep'),
(14, 'Balonmano', 'Deporte que se practica, en una cancha rectangular, entre dos equipos de siete jugadores que, utilizando solo las manos, intentan introducir el balón en el arco del adversario', 'dep'),
(15, 'Running', 'Correr', 'dep'),
(16, 'Musculación', 'Desarrollo o aumento del volumen de los músculos del cuerpo.', 'dep'),
(18, 'Pilates', 'Conjunto de ejercicios físicos en los que se entrena la musculatura, la resistencia, la flexibilidad y el control de la respiración y de la mente.', 'dep');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagenes`
--

CREATE TABLE `imagenes` (
  `codImagen` varchar(15) NOT NULL,
  `nombreImg` varchar(20) NOT NULL,
  `fecha` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `imagenes`
--

INSERT INTO `imagenes` (`codImagen`, `nombreImg`, `fecha`) VALUES
('CAT1', 'CAT1.jpg', '2023-05-21'),
('CAT10', 'CAT10.jpg', '2023-05-21'),
('CAT11', 'CAT11.jpg', '2023-05-21'),
('CAT12', 'CAT12.jpg', '2023-05-21'),
('CAT13', 'CAT13.jpg', '2023-05-21'),
('CAT14', 'CAT14.jpg', '2023-05-21'),
('CAT15', 'CAT15.jpg', '2023-05-21'),
('CAT16', 'CAT16.jpg', '2023-05-21'),
('CAT17', 'CAT17.jpg', '2023-05-21'),
('CAT18', 'CAT18.jpg', '2023-05-21'),
('CAT2', 'CAT2.jpg', '2023-05-21'),
('CAT3', 'CAT3.jpg', '2023-05-21'),
('CAT4', 'CAT4.jpg', '2023-05-21'),
('CAT5', 'CAT5.jpg', '2023-05-21'),
('CAT6', 'CAT6.jpg', '2023-05-21'),
('CAT7', 'CAT7.jpg', '2023-05-21'),
('CAT8', 'CAT8.jpg', '2023-05-21'),
('CAT9', 'CAT9.jpg', '2023-05-21'),
('PROD1', 'PROD1.jpg', '2023-05-21'),
('PROD2', 'PROD2.jpg', '2023-05-21'),
('PROD3', 'PROD3.jpg', '2023-05-21'),
('PROD4', 'PROD4.jpg', '2023-05-21'),
('PROD5', 'PROD5.jpg', '2023-05-21'),
('PROD6', 'PROD6.jpg', '2023-05-21'),
('PROD7', 'PROD7.jpg', '2023-05-21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lineas`
--

CREATE TABLE `lineas` (
  `numLinea` int(11) NOT NULL,
  `numPedido` int(4) NOT NULL,
  `codProducto` int(10) NOT NULL,
  `precio` double(7,2) NOT NULL,
  `cantidad` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `lineas`
--

INSERT INTO `lineas` (`numLinea`, `numPedido`, `codProducto`, `precio`, `cantidad`) VALUES
(4, 9, 1, 39.99, 1),
(5, 9, 2, 39.99, 1),
(6, 9, 3, 79.99, 1),
(7, 10, 3, 79.99, 1),
(8, 11, 1, 39.99, 1),
(9, 11, 6, 11.99, 1),
(10, 12, 3, 79.99, 1),
(11, 12, 6, 11.99, 1),
(12, 13, 3, 79.99, 11),
(13, 14, 3, 79.99, 1),
(14, 16, 3, 79.99, 85),
(15, 17, 1, 39.99, 1),
(16, 17, 6, 11.99, 10),
(17, 18, 2, 39.99, 1),
(18, 19, 2, 39.99, 1),
(19, 20, 2, 39.99, 6),
(20, 21, 6, 11.99, 3),
(21, 22, 2, 39.99, 1),
(22, 23, 2, 39.99, 1),
(23, 22, 2, 39.99, 1),
(24, 23, 2, 39.99, 1),
(25, 24, 1, 39.99, 1),
(26, 25, 5, 24.99, 1),
(27, 26, 2, 39.99, 1),
(28, 27, 2, 39.99, 1),
(29, 28, 1, 39.99, 1),
(30, 29, 2, 39.99, 1),
(31, 30, 1, 39.99, 1),
(32, 30, 5, 24.99, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `numPedido` int(4) NOT NULL,
  `cliente` int(5) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`numPedido`, `cliente`, `fecha`) VALUES
(9, 2, '2023-05-27'),
(10, 2, '2023-05-27'),
(11, 2, '2023-05-27'),
(12, 2, '2023-05-27'),
(13, 2, '2023-05-27'),
(14, 2, '2023-05-27'),
(15, 2, '2023-05-27'),
(16, 2, '2023-05-27'),
(17, 2, '2023-05-27'),
(18, 2, '2023-05-27'),
(19, 2, '2023-05-27'),
(20, 2, '2023-05-27'),
(21, 2, '2023-05-27'),
(22, 2, '2023-05-31'),
(23, 2, '2023-05-31'),
(24, 2, '2023-06-13'),
(25, 2, '2023-06-13'),
(26, 2, '2023-06-13'),
(27, 2, '2023-06-13'),
(28, 2, '2023-06-13'),
(29, 2, '2023-06-13'),
(30, 2, '2023-06-13');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `codBarras` int(10) NOT NULL,
  `denominacionProd` varchar(20) NOT NULL,
  `descripcionProd` varchar(200) NOT NULL,
  `disponibilidad` varchar(1) NOT NULL,
  `categoria` int(10) NOT NULL,
  `categoriaDepor` int(10) DEFAULT NULL,
  `stock` int(5) NOT NULL,
  `precio` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`codBarras`, `denominacionProd`, `descripcionProd`, `disponibilidad`, `categoria`, `categoriaDepor`, `stock`, `precio`) VALUES
(1, 'Casco bicicleta carr', 'Casco concebido para ciclistas que buscan un casco compacto, bien ventilado y muy cómodo gracias al nuevo sistema de ajuste concebido por nuestro equipo de ingenieros de nuestro centro DHEC.', 's', 4, 5, 293, '39.99'),
(2, 'Maillot ciclismo MTB', 'Disfruta de su resistencia, de su transpirabilidad y de su capacidad para llevar los objetos necesarios para XC y XCM gracias a sus bolsillos y su forma optimizada para máxima libertad de movimientos.', 's', 1, 5, 487, '39.99'),
(3, 'Zapatillas ciclismo', 'Zapatillas ligeras con un diseño sin costuras de la entresuela, las RC3 están provistas de una rueda de ajuste BOA. Exterior de piel sintética y suela de nailon y fibra de vidrio.', 'n', 2, 5, 0, '79.99'),
(4, 'Bañador Mujer nataci', 'Este bañador de 1 pieza para mujer tiene tirantes anchos y espalda en V que garantizan una excelente sujeción y favorecen una gran libertad de movimientos.', 'n', 3, NULL, 0, '24.99'),
(5, 'Balón Liga española ', 'Réplica del balón oficial utilizado durante el campeonato de España. El estilo clásico de PUMA al servicio de los mejores jugadores de España. Se convertirá rápidamente en un Clásico.', 's', 4, 6, 898, '24.99'),
(6, 'Camiseta de fútbol E', 'Diseñada para el joven aficionado apasionado que quiere mostrar con orgullo los colores de su país y de su equipo en cualquier circunstancia', 'n', 1, 6, 0, '11.99'),
(7, 'Pantalón Corto de Fú', 'Este pantalón corto de fútbol adidas Entrada 22 es la elección perfecta para cualquier situación. Diseño estilizado y clásico.', 'n', 1, 6, 0, '11.99');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `codUsuario` int(5) NOT NULL,
  `dni` varchar(9) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `direccion` varchar(60) NOT NULL,
  `provincia` varchar(20) NOT NULL,
  `localidad` varchar(20) NOT NULL,
  `cp` int(5) NOT NULL,
  `email` varchar(30) NOT NULL,
  `usuario` varchar(10) NOT NULL,
  `pass` varchar(20) NOT NULL,
  `tipo` varchar(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`codUsuario`, `dni`, `nombre`, `apellidos`, `direccion`, `provincia`, `localidad`, `cp`, `email`, `usuario`, `pass`, `tipo`) VALUES
(1, '12345678A', 'Sandra', 'Durán Méndez', 'Plaza de Parma 17', 'Sevilla', 'Dos Hermanas', 41089, 'sandra13opft@gmail.com', 'sdurmen678', 'sandra', 'administrador'),
(2, '98765432B', 'Paco', 'Pérez López', 'Calle Tranquila 13', 'Sevilla', 'Alcalá del Rio', 41200, 'pepepaco@gmail.com', 'pperlop432', 'paco', 'cliente'),
(4, '12345111A', 'Macarena', 'López Ruíz', 'Calle Estrecha 3', 'Sevilla', 'Arahal', 41600, 'maloru@gmail.com', 'mloprui416', 'macarena', 'cliente'),
(5, '33345111A', 'Luis', 'Ponce García', 'Calle Ancha 10', 'Sevilla', 'Dos Hermanas', 41700, 'lpongar@gmail.com', 'lpongar333', 'luis', 'cliente'),
(6, '30695896A', 'Maria', 'Roldán Rodríguez', 'Calle Nueva 3', 'Sevilla', 'Dos Hermanas', 41089, 'rolmar90@gmail.com', 'mrolrod987', 'maria', 'cliente'),
(8, '123321123', 'Ana', 'Lopez Perez', 'Plaza nueva', 'Madrid', 'Madrid', 28001, 'analo@gmail.com', 'alopper908', 'ana', 'cliente'),
(9, '852258852', 'Luisa', 'Martin Matin', 'Callecita 1', 'Sevilla', 'Dos Hermanas', 41089, 'lmarmar908@gmail.com', 'lmarmar908', 'luisa', 'cliente');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`codCategoria`),
  ADD UNIQUE KEY `uniqueNombre` (`nombreCat`);

--
-- Indices de la tabla `imagenes`
--
ALTER TABLE `imagenes`
  ADD PRIMARY KEY (`codImagen`);

--
-- Indices de la tabla `lineas`
--
ALTER TABLE `lineas`
  ADD PRIMARY KEY (`numLinea`),
  ADD KEY `lineas_ibfk_1` (`numPedido`),
  ADD KEY `lineas_ibfk_2` (`codProducto`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`numPedido`),
  ADD KEY `cliente` (`cliente`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`codBarras`),
  ADD UNIQUE KEY `uniqueDenominacion` (`denominacionProd`),
  ADD KEY `cat_fk` (`categoria`),
  ADD KEY `fk_catdep` (`categoriaDepor`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`codUsuario`),
  ADD UNIQUE KEY `uniqueDni` (`dni`),
  ADD UNIQUE KEY `uniqueUser` (`usuario`),
  ADD UNIQUE KEY `uniEmail` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `codCategoria` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `lineas`
--
ALTER TABLE `lineas`
  MODIFY `numLinea` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `numPedido` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `codBarras` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `codUsuario` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `lineas`
--
ALTER TABLE `lineas`
  ADD CONSTRAINT `lineas_ibfk_1` FOREIGN KEY (`numPedido`) REFERENCES `pedidos` (`numPedido`),
  ADD CONSTRAINT `lineas_ibfk_2` FOREIGN KEY (`codProducto`) REFERENCES `productos` (`codBarras`);

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`cliente`) REFERENCES `usuarios` (`codUsuario`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `cat_fk` FOREIGN KEY (`categoria`) REFERENCES `categorias` (`codCategoria`),
  ADD CONSTRAINT `fk_catdep` FOREIGN KEY (`categoriaDepor`) REFERENCES `categorias` (`codCategoria`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
