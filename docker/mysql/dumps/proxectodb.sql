-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: JuanCastro1-mysql
-- Tiempo de generación: 06-12-2025 a las 16:02:13
-- Versión del servidor: 8.4.7
-- Versión de PHP: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `proxectodb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `canchas`
--

CREATE TABLE `canchas` (
  `id` int NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `ubicacion` varchar(200) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `tipo` enum('exterior','interior') DEFAULT 'exterior',
  `estado` enum('disponible','mantenimiento') DEFAULT 'disponible'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `canchas`
--

INSERT INTO `canchas` (`id`, `nombre`, `ubicacion`, `imagen`, `tipo`, `estado`) VALUES
(1, 'Parque Lourido – Pista de Baloncesto', 'Camiño do Outeiro, Pontevedra 36163', 'pista_parque_lourido.jpg', 'exterior', 'disponible'),
(3, 'Pistas da Praia de Samil', 'Av. Samil 71A, Vigo, Pontevedra', 'pista_samil.jpg', 'exterior', 'disponible'),
(5, 'Avenida Castelao – Cancha Urbana', 'Av. de Castelao 6-28, Vigo', 'pista_avenida_castelao.jpg', 'exterior', 'disponible'),
(7, 'Pistas deportivas Salceda', 'Salceda de Caselas', 'cancha_1763576263.jpeg', 'exterior', 'mantenimiento'),
(9, 'Chancha Terra de Porto', 'Rúa Rons, 5, 36980 O Grove', 'cancha_1765036007.jpg', 'exterior', 'disponible'),
(10, 'Pistas deportivas de Campolongo', 'Marquesina Bus Praza de Galicia, 36001 Pontevedra', 'cancha_1765036157.jpg', 'exterior', 'disponible');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos`
--

CREATE TABLE `eventos` (
  `id` int NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `tipo` enum('1x1','3x3','5x5','exhibicion') NOT NULL,
  `fecha` date NOT NULL,
  `descripcion` text,
  `cancha_id` int DEFAULT NULL,
  `creador_id` int DEFAULT NULL,
  `plazas` int DEFAULT '8',
  `estado` enum('abierto','cerrado') DEFAULT 'abierto',
  `imagen` varchar(255) DEFAULT NULL,
  `sponsor_id` int DEFAULT NULL,
  `sponsor_logo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `eventos`
--

INSERT INTO `eventos` (`id`, `titulo`, `tipo`, `fecha`, `descripcion`, `cancha_id`, `creador_id`, `plazas`, `estado`, `imagen`, `sponsor_id`, `sponsor_logo`) VALUES
(5, 'All Star CourtConnect', '1x1', '2026-01-02', NULL, 3, 1, 100, 'abierto', 'evento2.webp', 19, 'sponsor_693420f98cd75.png'),
(8, 'Torneo 24h Salceda', '1x1', '2025-11-27', NULL, 1, 1, 6, 'abierto', 'evento_1764267574.jpeg', 18, 'sponsor_69341c7929161.png'),
(10, '3x3 Campolongo Winter', '3x3', '2025-12-24', NULL, 10, 1, 36, 'abierto', 'evento_1765036554.jpg', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jugadores_destacados`
--

CREATE TABLE `jugadores_destacados` (
  `id` int NOT NULL,
  `usuario_id` int DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `mvp_count` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `jugadores_destacados`
--

INSERT INTO `jugadores_destacados` (`id`, `usuario_id`, `nombre`, `imagen`, `descripcion`, `mvp_count`) VALUES
(5, NULL, 'Hugo G.', 'hugog.webp', 'Jugador explosivo con capacidad atlética destacada.', 3),
(6, NULL, 'LaMelo Ball', 'lamelo.webp', 'Base creativo con visión de juego excepcional.', 5),
(8, NULL, 'Kevin Durant', 'durant.webp', 'Alero letal con gran capacidad anotadora y liderazgo en momentos clave.', 12),
(9, NULL, 'Joel Embiid', 'embiid.webp', 'Pívot dominante con potencia física, técnica ofensiva y presencia defensiva.', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `participaciones`
--

CREATE TABLE `participaciones` (
  `id` int NOT NULL,
  `evento_id` int DEFAULT NULL,
  `usuario_id` int DEFAULT NULL,
  `nombre_participante` varchar(100) NOT NULL,
  `posicion` varchar(50) NOT NULL,
  `edad` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `participaciones`
--

INSERT INTO `participaciones` (`id`, `evento_id`, `usuario_id`, `nombre_participante`, `posicion`, `edad`) VALUES
(5, 5, 9, '', 'Alero', 22),
(6, 8, 9, '', 'Escolta', 44),
(10, 8, NULL, 'Juan', 'Ala-Pívot', 22),
(22, 8, NULL, 'Cone', 'Base', 33);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `patrocinadores`
--

CREATE TABLE `patrocinadores` (
  `id` int NOT NULL,
  `usuario_id` int DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `aprobado` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `patrocinadores`
--

INSERT INTO `patrocinadores` (`id`, `usuario_id`, `nombre`, `logo`, `aprobado`) VALUES
(5, 18, 'Decathlon España', 'sponsor_693419bf91a04.png', 1),
(8, 19, 'Portalconsa', 'sponsor_693420f98cd75.png', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes_sponsor`
--

CREATE TABLE `solicitudes_sponsor` (
  `id` int NOT NULL,
  `evento_id` int NOT NULL,
  `sponsor_id` int NOT NULL,
  `nombre_empresa` varchar(120) NOT NULL,
  `email` varchar(120) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `aportacion` decimal(10,2) NOT NULL,
  `mensaje` text,
  `estado` enum('pendiente','aceptada','rechazada') DEFAULT 'pendiente',
  `fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('admin','jugador','club','visitante','sponsor') NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `fecha_registro` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `password`, `rol`, `logo`, `fecha_registro`) VALUES
(1, 'Juan', 'castro.pazo.jc@gmail.com', '$2y$10$TDEj2LniUmh4v2WjYVLlv.QH2CMhoYX/G1xeYKeZKikyVivmNify.', 'admin', NULL, '2025-11-12 18:43:24'),
(9, 'Kevin Durant', 'durant@gmail.com', '$2y$10$uRxcWsi4p8xjxjX9WR8KKeLlfMeo4IVVPaIqtDeDhGzplpivBWweu', 'jugador', NULL, '2025-11-13 16:10:54'),
(11, 'Cone', 'cone@gmail.com', '$2y$10$/ZcC1flPFQSEtaW5UnXW2.QiYWSrzANC8eMRU0F1RoAgDVmqeuwYe', 'club', NULL, '2025-12-04 17:15:06'),
(18, 'Decathlon', 'decathlon@gmail.com', '$2y$10$cwAMhQ7hRd2JRzo461qLWO76T0BJRfrcLlJN5aaSFtvXoiYvgig5.', 'sponsor', NULL, '2025-12-06 11:55:04'),
(19, 'Portalconsa', 'portalconsa@gmail.com', '$2y$10$hBigplc5Sn8I3NAl6u3qHeJnEDQ2s1MErftqYqJAFEXPiNoRR20m.', 'sponsor', NULL, '2025-12-06 12:26:02');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `canchas`
--
ALTER TABLE `canchas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cancha_id` (`cancha_id`),
  ADD KEY `creador_id` (`creador_id`);

--
-- Indices de la tabla `jugadores_destacados`
--
ALTER TABLE `jugadores_destacados`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `participaciones`
--
ALTER TABLE `participaciones`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `evento_id` (`evento_id`,`usuario_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `patrocinadores`
--
ALTER TABLE `patrocinadores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `solicitudes_sponsor`
--
ALTER TABLE `solicitudes_sponsor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `evento_id` (`evento_id`),
  ADD KEY `sponsor_id` (`sponsor_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `canchas`
--
ALTER TABLE `canchas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `eventos`
--
ALTER TABLE `eventos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `jugadores_destacados`
--
ALTER TABLE `jugadores_destacados`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `participaciones`
--
ALTER TABLE `participaciones`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `patrocinadores`
--
ALTER TABLE `patrocinadores`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `solicitudes_sponsor`
--
ALTER TABLE `solicitudes_sponsor`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD CONSTRAINT `eventos_ibfk_1` FOREIGN KEY (`cancha_id`) REFERENCES `canchas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `eventos_ibfk_2` FOREIGN KEY (`creador_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `jugadores_destacados`
--
ALTER TABLE `jugadores_destacados`
  ADD CONSTRAINT `jugadores_destacados_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `participaciones`
--
ALTER TABLE `participaciones`
  ADD CONSTRAINT `participaciones_ibfk_1` FOREIGN KEY (`evento_id`) REFERENCES `eventos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `participaciones_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `patrocinadores`
--
ALTER TABLE `patrocinadores`
  ADD CONSTRAINT `patrocinadores_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `solicitudes_sponsor`
--
ALTER TABLE `solicitudes_sponsor`
  ADD CONSTRAINT `solicitudes_sponsor_ibfk_1` FOREIGN KEY (`evento_id`) REFERENCES `eventos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `solicitudes_sponsor_ibfk_2` FOREIGN KEY (`sponsor_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
