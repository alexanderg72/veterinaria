-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 21-11-2025 a las 20:37:16
-- Versión del servidor: 8.4.3
-- Versión de PHP: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `vet_clinic_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `appointments`
--

CREATE TABLE `appointments` (
  `id` int NOT NULL,
  `client_id` int NOT NULL,
  `pet_id` int NOT NULL,
  `date_time` datetime NOT NULL,
  `reason` text NOT NULL,
  `status` enum('pending','confirmed','canceled','completed') DEFAULT 'pending',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `appointments`
--

INSERT INTO `appointments` (`id`, `client_id`, `pet_id`, `date_time`, `reason`, `status`, `created_at`) VALUES
(1, 1, 1, '2025-11-24 13:34:38', 'Vacunación anual y desparasitación.', 'pending', '2025-11-21 13:34:38'),
(2, 1, 2, '2025-11-28 13:34:38', 'Revisión por tos persistente.', 'confirmed', '2025-11-21 13:34:38'),
(3, 4, 3, '2025-12-23 12:30:00', 'Dolor estomacal', 'pending', '2025-11-21 14:21:17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pets`
--

CREATE TABLE `pets` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `species` varchar(50) NOT NULL,
  `breed` varchar(50) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `pets`
--

INSERT INTO `pets` (`id`, `user_id`, `name`, `species`, `breed`, `birthdate`, `created_at`) VALUES
(1, 1, 'Max', 'Perro', 'Labrador', '2020-05-15', '2025-11-21 13:34:38'),
(2, 1, 'Luna', 'Gato', 'Siamés', '2021-11-20', '2025-11-21 13:34:38'),
(3, 4, 'terrie', 'Perro', 'pitbull', '2022-01-23', '2025-11-21 14:16:12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('client','admin','sales') NOT NULL DEFAULT 'client',
  `phone` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password_hash`, `role`, `phone`, `created_at`) VALUES
(1, 'Cliente Demo', 'demo@clinic.com', '$2y$10$w81qWqL9q4jW2Hq5uYg1k.8P3F0iE.yX9bS5.T2D5J.zD0T3V4G5S', 'client', '555-1234', '2025-11-21 13:34:38'),
(2, 'Administrador Principal', 'admin@clinic.com', '$2y$10$a33o/fiayDq/JrZpvohEquCUfjvumTkOSUFknUMX33vaJeBeI2Eui', 'admin', '555-0001', '2025-11-21 13:35:28'),
(3, 'Vendedor Recepción', 'seller@clinic.com', '$2y$10$a33o/fiayDq/JrZpvohEquCUfjvumTkOSUFknUMX33vaJeBeI2Eui', 'sales', '555-0002', '2025-11-21 13:35:28'),
(4, 'mauricio', 'alexandergrana72581@gmail.com', '$2y$10$a33o/fiayDq/JrZpvohEquCUfjvumTkOSUFknUMX33vaJeBeI2Eui', 'client', NULL, '2025-11-21 14:00:54'),
(5, 'Cruz Roja Salvadoreña', 'alexandergran72581@gmail.com', '$2y$10$a33o/fiayDq/JrZpvohEquCUfjvumTkOSUFknUMX33vaJeBeI2Eui', 'client', NULL, '2025-11-21 14:21:53'),
(7, 'mauri', 'tecnico_comunitario.salud@cruzrojasal.org.sv', '$2y$10$th9g2j5Mx9rs7Ly8F7r6v.u2aLfYxAQUdLVjBTiDoN0sBLyTSSPTS', 'client', '79321059', '2025-11-21 14:36:14');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `pet_id` (`pet_id`);

--
-- Indices de la tabla `pets`
--
ALTER TABLE `pets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `pets`
--
ALTER TABLE `pets`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`pet_id`) REFERENCES `pets` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `pets`
--
ALTER TABLE `pets`
  ADD CONSTRAINT `pets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
