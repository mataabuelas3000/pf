-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-05-2024 a las 23:14:09
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gym`
--
CREATE DATABASE IF NOT EXISTS `gym` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `gym`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calendar`
--

CREATE TABLE `calendar` (
  `Id_Calendar` int(10) NOT NULL,
  `Id_Day` int(1) DEFAULT NULL,
  `Id_User` int(10) DEFAULT NULL,
  `Id_Routine` int(11) DEFAULT NULL,
  `Id_Check` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `calendar`
--

INSERT INTO `calendar` (`Id_Calendar`, `Id_Day`, `Id_User`, `Id_Routine`, `Id_Check`) VALUES
(16, 1, 1077722009, 0, 0),
(24, 7, 1077722009, 0, 0),
(28, 2, 1076982371, 0, 0),
(32, 6, 1076982371, 0, 0),
(39, 1, 1076982371, 0, 0),
(40, 3, 1076982371, 0, 0),
(42, 3, 1077722009, 22, 0),
(44, 3, 1077722009, 34, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `chat_routine`
--

CREATE TABLE `chat_routine` (
  `Id_Chat_Routine` int(11) NOT NULL,
  `Name_Chat_Routine` varchar(255) DEFAULT NULL,
  `Description_Chat_Routine` varchar(255) DEFAULT NULL,
  `Duration_Chat_Routine` int(3) DEFAULT NULL,
  `Id_Difficulty` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `chat_routine`
--

INSERT INTO `chat_routine` (`Id_Chat_Routine`, `Name_Chat_Routine`, `Description_Chat_Routine`, `Duration_Chat_Routine`, `Id_Difficulty`) VALUES
(1, 'Rutina de Pectorales', 'Fortalece los músculos pectorales.', 30, 2),
(2, 'Rutina de Brazos', 'Fortalece los músculos de los brazos.', 25, 2),
(3, 'Rutina de Piernas', 'Fortalece los músculos de las piernas.', 30, 3),
(4, 'Rutina de Abdominales', 'Fortalece los músculos abdominales.', 20, 2),
(5, 'Rutina de Hombros', 'Desarrolla los músculos de los hombros.', 25, 2),
(6, 'Rutina de Espalda', 'Fortalece los músculos de la espalda.', 30, 2),
(7, 'Rutina de Ejercicios de Core', 'Fortalece los músculos del core para mejorar la estabilidad y el equilibrio.', 25, 2),
(8, 'Rutina de Ejercicios para la Espalda Baja', 'Fortalece los músculos de la espalda baja y previene lesiones.', 20, 1),
(9, 'Rutina de Estiramiento Post-Entrenamiento', 'Mejora la flexibilidad y reduce la tensión muscular después del ejercicio.', 15, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `chat_routine_exercises`
--

CREATE TABLE `chat_routine_exercises` (
  `Id_Exercise` int(11) DEFAULT NULL,
  `Id_Chat_Routine` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `chat_routine_exercises`
--

INSERT INTO `chat_routine_exercises` (`Id_Exercise`, `Id_Chat_Routine`) VALUES
(22, 1),
(23, 1),
(24, 2),
(25, 2),
(26, 3),
(27, 3),
(28, 4),
(29, 4),
(30, 5),
(31, 5),
(32, 6),
(33, 6),
(34, 7),
(35, 7),
(36, 8),
(37, 8),
(38, 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `data`
--

CREATE TABLE `data` (
  `Id_Data` int(10) NOT NULL,
  `Id_User` int(10) DEFAULT NULL,
  `Height_User` decimal(5,2) DEFAULT NULL,
  `Weight_User` decimal(5,2) DEFAULT NULL,
  `Imc_User` decimal(4,1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `data`
--

INSERT INTO `data` (`Id_Data`, `Id_User`, `Height_User`, `Weight_User`, `Imc_User`) VALUES
(1, 1076982371, 1.70, 68.00, 23.5),
(2, 1077722009, 1.67, 64.00, 22.9),
(3, 12345678, 1.90, 80.20, 22.2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `days`
--

CREATE TABLE `days` (
  `Id_Day` int(1) NOT NULL,
  `Day` varchar(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `days`
--

INSERT INTO `days` (`Id_Day`, `Day`) VALUES
(1, 'Lunes'),
(2, 'Martes'),
(3, 'Miércoles'),
(4, 'Jueves'),
(5, 'Viernes'),
(6, 'Sábado'),
(7, 'Domingo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `difficulty`
--

CREATE TABLE `difficulty` (
  `Id_Difficulty` int(1) NOT NULL,
  `Difficulty` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `difficulty`
--

INSERT INTO `difficulty` (`Id_Difficulty`, `Difficulty`) VALUES
(1, 'Fácil'),
(2, 'Intermedio'),
(3, 'Dificíl');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `exercise`
--

CREATE TABLE `exercise` (
  `Id_Exercise` int(11) NOT NULL,
  `Name_Exercise` varchar(255) DEFAULT NULL,
  `Description_Exercise` varchar(255) DEFAULT NULL,
  `Duration_Exercise` int(3) DEFAULT NULL,
  `Id_Difficulty` int(1) DEFAULT NULL,
  `Id_Muscle_Group` int(1) DEFAULT NULL,
  `url_video` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `exercise`
--

INSERT INTO `exercise` (`Id_Exercise`, `Name_Exercise`, `Description_Exercise`, `Duration_Exercise`, `Id_Difficulty`, `Id_Muscle_Group`, `url_video`) VALUES
(0, 'Flexiones de brazos', 'Ejercicio básico que trabaja los músculos pectorales y los tríceps.', 15, 2, 1, '../videos/Flexiones de brazo.mp4'),
(1, 'Aperturas con mancuernas', 'Ejercicio para trabajar la expansión de los pectorales.', 20, 1, 1, '../videos/Aperturas con mancuernas.mp4'),
(2, 'Pullover con mancuerna', 'Ejercicio que ayuda a trabajar la parte inferior de los pectorales.', 15, 1, 1, '../videos/pullover con mancuerna.mp4'),
(3, 'Flexiones diamante', 'Variante de las flexiones que enfoca más en los tríceps.', 10, 3, 1, '../videos/Flexiones diamante.mp4'),
(4, 'Curl de bíceps con barra', 'Ejercicio para trabajar los músculos del bíceps.', 15, 2, 2, '../videos/curl de biceps con mancuernas.mp4'),
(5, 'Tríceps en polea alta', 'Ejercicio para fortalecer los músculos del tríceps.', 20, 2, 2, ''),
(6, 'Curl de bíceps con mancuernas', 'Ejercicio básico para el desarrollo de los bíceps.', 15, 1, 2, '../videos/curl de biceps con mancuernas.mp4'),
(7, 'Crunch abdominal', 'Ejercicio básico para trabajar los abdominales.', 10, 1, 3, '../videos/Crunch abdominal.mp4'),
(8, 'Plancha abdominal', 'Ejercicio estático que fortalece los músculos abdominales.', 15, 1, 3, '../videos/Plancha abdominal.mp4'),
(9, 'Elevación de piernas', 'Ejercicio para trabajar la parte baja de los abdominales.', 20, 3, 3, ''),
(10, 'Rotación de tronco con balón', 'Ejercicio para fortalecer los músculos oblicuos.', 15, 3, 3, '../videos/Rotacion de tronco con balon.mp4'),
(11, 'Sentadillas', 'Ejercicio básico para fortalecer los músculos de las piernas.', 20, 2, 4, '../videos/Sentadillas.mp4'),
(12, 'Zancadas', 'Ejercicio para trabajar los cuádriceps y los glúteos.', 15, 2, 4, '../videos/Zancadas.mp4'),
(13, 'Elevación de talones', 'Ejercicio para fortalecer los músculos de la pantorrilla.', 10, 1, 4, '../videos/Elevaciones de talones.mp4'),
(14, 'Prensa de piernas', 'Ejercicio para trabajar los cuádriceps.', 20, 2, 4, ''),
(15, 'Press militar', 'Ejercicio básico para trabajar los hombros.', 20, 2, 5, '../videos/Press militar.mp4'),
(16, 'Elevaciones laterales', 'Ejercicio para trabajar los deltoides laterales.', 15, 1, 5, '../videos/Elevaciones laterales.mp4'),
(17, 'Pájaros con mancuernas', 'Ejercicio para fortalecer los deltoides posteriores.', 10, 2, 5, '../videos/Pajaros con mancuernas.mp4'),
(18, 'Press frontal con barra', 'Ejercicio para el desarrollo de los deltoides anteriores.', 20, 2, 5, ''),
(20, 'Remo con barra', 'Ejercicio para fortalecer la musculatura de la espalda baja.', 20, 2, 6, ''),
(21, 'Sentadillas sumo', 'Variante de las sentadillas para enfocarse en los glúteos.', 20, 3, 6, '../videos/Sentadillas sumo.mp4'),
(22, 'Press de Banca', 'Ejercicio de levantamiento de pesas que se centra en el desarrollo de los músculos pectorales.', 10, 2, 1, ''),
(23, 'Flexiones de Pecho', 'Ejercicio de peso corporal que fortalece los músculos pectorales, tríceps y hombros.', 10, 1, 1, '../videos/Flexiones de brazo.mp4'),
(24, 'Curl de Bíceps con Mancuernas', 'Ejercicio para trabajar los músculos bíceps utilizando mancuernas.', 7, 2, 2, '../videos/curl de biceps con mancuernas.mp4'),
(25, 'Extensiones de Tríceps con Cuerda', 'Ejercicio que se enfoca en los músculos tríceps utilizando la máquina de poleas.', 8, 2, 2, ''),
(26, 'Sentadillas con Barra', 'Ejercicio compuesto que trabaja los músculos de las piernas y glúteos.', 10, 3, 4, ''),
(27, 'Prensa de Piernas', 'Ejercicio de máquina que se enfoca en los músculos cuádriceps.', 10, 2, 4, ''),
(28, 'Plancha Frontal', 'Ejercicio de fortalecimiento del core que implica mantener el cuerpo en posición de tabla.', 7, 2, 3, ''),
(29, 'Crunches', 'Ejercicio clásico de abdominales que trabaja la parte superior del abdomen.', 8, 1, 3, '../videos/Crunches.mp4'),
(30, 'Elevaciones Laterales con Mancuernas', 'Ejercicio que trabaja los deltoides laterales.', 8, 2, 5, ''),
(31, 'Press Arnold', 'Variante del press de hombros que trabaja todo el deltoides.', 10, 2, 5, ''),
(32, 'Dominadas', 'Ejercicio compuesto que trabaja la espalda, bíceps y hombros.', 10, 3, 6, '../videos/dominadas1.mp4'),
(33, 'Remo con Barra', 'Ejercicio que se enfoca en la parte superior de la espalda y los bíceps.', 10, 2, 6, ''),
(34, 'Plancha Lateral', 'Ejercicio que fortalece los oblicuos y el core lateral.', 8, 2, 3, ''),
(35, 'Mountain Climbers', 'Ejercicio dinámico que trabaja el core y aumenta la frecuencia cardíaca.', 7, 2, 3, ''),
(36, 'Superman', 'Ejercicio que fortalece la espalda baja y los músculos paravertebrales.', 10, 1, 6, ''),
(37, 'Bird Dog', 'Ejercicio de equilibrio que fortalece el core y la espalda baja.', 10, 1, 7, ''),
(38, 'Estiramiento de Cuádriceps', 'Estiramiento de los músculos delanteros del muslo.', 5, 1, 4, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `goals`
--

CREATE TABLE `goals` (
  `Id_Calendar` int(10) NOT NULL,
  `Id_Check` int(1) NOT NULL,
  `Id_Routine` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `information`
--

CREATE TABLE `information` (
  `Id_Information` int(1) NOT NULL,
  `IMC_MIN` decimal(5,2) DEFAULT 0.00,
  `IMC_MAX` decimal(5,2) DEFAULT 0.00,
  `Description_Nutritional` varchar(255) DEFAULT 'N/A',
  `D_P` varchar(255) DEFAULT 'N',
  `D_C` varchar(255) DEFAULT 'N',
  `D_GS` varchar(255) DEFAULT 'N',
  `A_P` varchar(255) DEFAULT 'N',
  `A_C` varchar(255) DEFAULT 'N',
  `A_GS` varchar(255) DEFAULT 'N',
  `C_P` varchar(255) DEFAULT 'N',
  `C_C` varchar(255) DEFAULT 'N',
  `C_GS` varchar(255) DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `information`
--

INSERT INTO `information` (`Id_Information`, `IMC_MIN`, `IMC_MAX`, `Description_Nutritional`, `D_P`, `D_C`, `D_GS`, `A_P`, `A_C`, `A_GS`, `C_P`, `C_C`, `C_GS`) VALUES
(1, 0.00, 18.49, 'Deberías aumentar la ingesta de alimentos ricos en vitaminas y minerales de buena calidad. Evita los alimentos procesados ricos en grasas saturadas y azúcares.', 'Proteínas: 30% huevos o queso.', 'Carbohidratos: 50% arepa integral o pan de yuca.', 'Grasas saludables: 20% aguacate o mantequilla de n', 'Proteínas: 30% pollo o pescado', 'Carbohidratos: 50% arroz integral o quinoa', 'Grasas saludables: 20% aceite de oliva o nueces', 'Proteínas: 30% pollo o pescado', 'Carbohidratos: 50% arroz integral o quinoa', 'Grasas saludables: 20% aceite de oliva o nueces'),
(2, 18.50, 24.99, 'Se recomienda mantener una dieta equilibrada que incluya frutas, verduras, cereales integrales, leche y productos lácteos sin grasa o bajos en grasa. También deberías incluir una variedad de alimentos con proteínas como mariscos, carnes y huevos', 'Proteínas: 30% huevos o queso', 'Carbohidratos: 50% frutas o arepa integral', 'Grasas saludables: 20% nueces o semillas', 'Proteínas: 30% pollo o pescado', 'Carbohidratos: 50% verduras o granos enteros', 'Grasas saludables: 20% aceite de oliva o aguacate', 'Proteínas: 30% pollo o pescado', 'Carbohidratos: 50% verduras o granos enteros', 'Grasas saludables: 20% aceite de oliva o aguacate'),
(3, 25.00, 29.99, 'Deberías establecer horarios al comer y ser ordenado. Recuerda que el 50% de tu plato debe ser de verduras, el 25% de proteínas y el otro 25% de carbohidratos', 'Proteínas: 30% huevos o queso', 'Carbohidratos: 50% arepa integral o pan de yuca', 'Grasas saludables: 20% aguacate o mantequilla de n', 'Proteínas: 25% verduras, 25% pollo o pescado', 'Carbohidratos: 50% verduras, 25% arroz integral o ', 'Grasas saludables: 25% aceite de oliva o aguacate', 'Proteínas: 25% verduras, 25% pollo o pescado', 'Carbohidratos: 50% verduras, 25% arroz integral o ', 'Grasas saludables: 25% aceite de oliva o aguacate'),
(4, 30.00, 100.00, 'En este caso, es especialmente importante seguir una dieta equilibrada y hacer ejercicio regularmente. Consulta a un profesional de la salud para obtener un plan de alimentación y ejercicio personalizado.', 'Proteínas: 30% huevos o queso', 'Carbohidratos: 50% arepa integral o pan de yuca', 'Grasas saludables: 20% aguacate o mantequilla de n', 'Proteínas: 25% verduras, 25% pollo o pescado', 'Carbohidratos: 50% verduras, 25% arroz integral o ', 'Grasas saludables: 25% aceite de oliva o aguacate', 'Proteínas: 25% verduras, 25% pollo o pescado', 'Carbohidratos: 50% verduras, 25% arroz integral o ', 'Grasas saludables: 25% aceite de oliva o aguacate');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `login`
--

CREATE TABLE `login` (
  `Id_Register` int(10) NOT NULL,
  `Id_User` int(10) NOT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `Id_Role_User` int(1) DEFAULT NULL,
  `Entry_User` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `login`
--

INSERT INTO `login` (`Id_Register`, `Id_User`, `Password`, `Id_Role_User`, `Entry_User`) VALUES
(0, 123, '123', 2, '2024-04-13 00:00:00'),
(1, 1077722009, '123', 1, '2024-04-13 18:02:55'),
(2, 1076982371, '123', 1, '2024-04-13 18:10:58'),
(4, 12345678, '123', 1, '2024-04-13 23:28:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `muscle_group`
--

CREATE TABLE `muscle_group` (
  `Id_Muscle_Group` int(1) NOT NULL,
  `Name_Group` varchar(255) DEFAULT NULL,
  `Description_Group` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `muscle_group`
--

INSERT INTO `muscle_group` (`Id_Muscle_Group`, `Name_Group`, `Description_Group`) VALUES
(1, 'Pectorales', 'Grupo de músculos que se encuentran en la parte frontal del torso.'),
(2, 'Brazos', 'Grupo de músculos que se encuentran en los brazos.'),
(3, 'Abdominales', 'Grupo de músculos que se encuentran en la zona abdominal.'),
(4, 'Piernas', 'Grupo de músculos que se encuentran en las piernas.'),
(5, 'Hombros', 'Grupo de músculos que se encuentran en los hombros.'),
(6, 'Espalda', 'Grupo de músculos que se encuentran en la parte posterior del torso.'),
(7, 'Glúteos', 'Grupo de músculos que se encuentran en los glúteos.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `Id_Role_User` int(1) NOT NULL,
  `Role` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`Id_Role_User`, `Role`) VALUES
(1, 'User'),
(2, 'Entrenador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `routine`
--

CREATE TABLE `routine` (
  `Id_Routine` int(11) NOT NULL,
  `Name_routine` varchar(255) DEFAULT NULL,
  `Approach_Routine` varchar(255) DEFAULT NULL,
  `Duration_Routine` int(3) DEFAULT NULL,
  `Id_Difficulty` int(1) DEFAULT NULL,
  `Id_User` int(10) DEFAULT NULL,
  `Id_Check` tinyint(1) DEFAULT NULL,
  `completion_time` time DEFAULT NULL,
  `resume_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `routine`
--

INSERT INTO `routine` (`Id_Routine`, `Name_routine`, `Approach_Routine`, `Duration_Routine`, `Id_Difficulty`, `Id_User`, `Id_Check`, `completion_time`, `resume_time`) VALUES
(0, 'Descanso', 'Descanso', NULL, NULL, NULL, 0, NULL, NULL),
(22, 'sasa', 'ssaassa', 32, 2, 1077722009, 1, '14:09:06', '23:59:59'),
(34, 'assxzxza', 'xzxzxz', 37, NULL, 1077722009, 1, '14:09:11', '23:59:59'),
(42, 'Rutina de Piernas', 'Fortalece los músculos de las piernas.', 30, 3, 1076982371, 1, '19:48:51', '23:59:59'),
(43, 'Rutina de Pectorales', 'Fortalece los músculos pectorales.', 30, 2, 1076982371, NULL, NULL, NULL),
(44, 'Rutina de Ejercicios de Core', 'Fortalece los músculos del core para mejorar la estabilidad y el equilibrio.', 25, 2, 1076982371, 1, '21:39:53', '23:59:59'),
(51, 'j', 'df', 16, 2, 1076982371, 1, '21:42:42', '23:59:59'),
(53, 'assa', 'wqqwsa', NULL, 1, 1077722009, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rut_has_exercise`
--

CREATE TABLE `rut_has_exercise` (
  `Id_Routine` int(11) NOT NULL,
  `Id_Exercise` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rut_has_exercise`
--

INSERT INTO `rut_has_exercise` (`Id_Routine`, `Id_Exercise`) VALUES
(42, 26),
(42, 27),
(43, 22),
(43, 23),
(22, 32),
(22, 11),
(44, 34),
(44, 35),
(34, 11),
(34, 12),
(51, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_info`
--

CREATE TABLE `user_info` (
  `Id_User` int(10) NOT NULL,
  `Name_User` varchar(255) DEFAULT NULL,
  `Last_Name_User` varchar(255) DEFAULT NULL,
  `Email_User` varchar(255) DEFAULT NULL,
  `Gender_User` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `user_info`
--

INSERT INTO `user_info` (`Id_User`, `Name_User`, `Last_Name_User`, `Email_User`, `Gender_User`) VALUES
(12345678, 'dssaas saass', 'asas aassa', 'xokaj30804@laymro.com', 'M'),
(1076982371, 'pinto ass', 'assa saass', 'fewel84929@fahih.comassa', 'F'),
(1077722009, 'Jhon', 'Pinto', 'Jhonpinto008@gmail.com', 'M');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `calendar`
--
ALTER TABLE `calendar`
  ADD PRIMARY KEY (`Id_Calendar`),
  ADD KEY `fk_calendar_user` (`Id_User`),
  ADD KEY `fk_calendar_days` (`Id_Day`),
  ADD KEY `fk_calendar_routine` (`Id_Routine`);

--
-- Indices de la tabla `chat_routine`
--
ALTER TABLE `chat_routine`
  ADD PRIMARY KEY (`Id_Chat_Routine`),
  ADD KEY `Id_Difficulty` (`Id_Difficulty`);

--
-- Indices de la tabla `chat_routine_exercises`
--
ALTER TABLE `chat_routine_exercises`
  ADD KEY `Id_Exercise` (`Id_Exercise`),
  ADD KEY `Id_Chat_Routine` (`Id_Chat_Routine`);

--
-- Indices de la tabla `data`
--
ALTER TABLE `data`
  ADD PRIMARY KEY (`Id_Data`),
  ADD KEY `Id_User` (`Id_User`);

--
-- Indices de la tabla `days`
--
ALTER TABLE `days`
  ADD PRIMARY KEY (`Id_Day`);

--
-- Indices de la tabla `difficulty`
--
ALTER TABLE `difficulty`
  ADD PRIMARY KEY (`Id_Difficulty`);

--
-- Indices de la tabla `exercise`
--
ALTER TABLE `exercise`
  ADD PRIMARY KEY (`Id_Exercise`),
  ADD KEY `Id_Difficulty` (`Id_Difficulty`),
  ADD KEY `Id_Muscle_Group` (`Id_Muscle_Group`);

--
-- Indices de la tabla `goals`
--
ALTER TABLE `goals`
  ADD KEY `fk_goals_calendar` (`Id_Calendar`),
  ADD KEY `Id_Check` (`Id_Check`),
  ADD KEY `Id_Routine` (`Id_Routine`);

--
-- Indices de la tabla `information`
--
ALTER TABLE `information`
  ADD PRIMARY KEY (`Id_Information`);

--
-- Indices de la tabla `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`Id_Register`,`Id_User`),
  ADD KEY `Id_User` (`Id_User`),
  ADD KEY `Id_Role_User` (`Id_Role_User`);

--
-- Indices de la tabla `muscle_group`
--
ALTER TABLE `muscle_group`
  ADD PRIMARY KEY (`Id_Muscle_Group`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`Id_Role_User`);

--
-- Indices de la tabla `routine`
--
ALTER TABLE `routine`
  ADD PRIMARY KEY (`Id_Routine`),
  ADD KEY `Id_Difficulty` (`Id_Difficulty`),
  ADD KEY `Id_User` (`Id_User`);

--
-- Indices de la tabla `rut_has_exercise`
--
ALTER TABLE `rut_has_exercise`
  ADD KEY `Id_Routine` (`Id_Routine`),
  ADD KEY `Id_Exercise` (`Id_Exercise`);

--
-- Indices de la tabla `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`Id_User`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `calendar`
--
ALTER TABLE `calendar`
  MODIFY `Id_Calendar` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT de la tabla `chat_routine`
--
ALTER TABLE `chat_routine`
  MODIFY `Id_Chat_Routine` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `data`
--
ALTER TABLE `data`
  MODIFY `Id_Data` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `login`
--
ALTER TABLE `login`
  MODIFY `Id_Register` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `routine`
--
ALTER TABLE `routine`
  MODIFY `Id_Routine` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `calendar`
--
ALTER TABLE `calendar`
  ADD CONSTRAINT `calendar_ibfk_1` FOREIGN KEY (`Id_Routine`) REFERENCES `routine` (`Id_Routine`),
  ADD CONSTRAINT `fk_calendar_days` FOREIGN KEY (`Id_Day`) REFERENCES `days` (`Id_Day`),
  ADD CONSTRAINT `fk_calendar_user` FOREIGN KEY (`Id_User`) REFERENCES `user_info` (`Id_User`);

--
-- Filtros para la tabla `chat_routine`
--
ALTER TABLE `chat_routine`
  ADD CONSTRAINT `chat_routine_ibfk_1` FOREIGN KEY (`Id_Difficulty`) REFERENCES `difficulty` (`Id_Difficulty`);

--
-- Filtros para la tabla `chat_routine_exercises`
--
ALTER TABLE `chat_routine_exercises`
  ADD CONSTRAINT `chat_routine_exercises_ibfk_1` FOREIGN KEY (`Id_Exercise`) REFERENCES `exercise` (`Id_Exercise`),
  ADD CONSTRAINT `chat_routine_exercises_ibfk_2` FOREIGN KEY (`Id_Chat_Routine`) REFERENCES `chat_routine` (`Id_Chat_Routine`);

--
-- Filtros para la tabla `data`
--
ALTER TABLE `data`
  ADD CONSTRAINT `data_ibfk_1` FOREIGN KEY (`Id_User`) REFERENCES `user_info` (`Id_User`);

--
-- Filtros para la tabla `exercise`
--
ALTER TABLE `exercise`
  ADD CONSTRAINT `exercise_ibfk_1` FOREIGN KEY (`Id_Difficulty`) REFERENCES `difficulty` (`Id_Difficulty`),
  ADD CONSTRAINT `exercise_ibfk_2` FOREIGN KEY (`Id_Muscle_Group`) REFERENCES `muscle_group` (`Id_Muscle_Group`);

--
-- Filtros para la tabla `goals`
--
ALTER TABLE `goals`
  ADD CONSTRAINT `goals_ibfk_1` FOREIGN KEY (`Id_Routine`) REFERENCES `routine` (`Id_Routine`);

--
-- Filtros para la tabla `login`
--
ALTER TABLE `login`
  ADD CONSTRAINT `login_ibfk_1` FOREIGN KEY (`Id_Role_User`) REFERENCES `roles` (`Id_Role_User`);

--
-- Filtros para la tabla `routine`
--
ALTER TABLE `routine`
  ADD CONSTRAINT `routine_ibfk_1` FOREIGN KEY (`Id_Difficulty`) REFERENCES `difficulty` (`Id_Difficulty`),
  ADD CONSTRAINT `routine_ibfk_2` FOREIGN KEY (`Id_User`) REFERENCES `user_info` (`Id_User`);

--
-- Filtros para la tabla `rut_has_exercise`
--
ALTER TABLE `rut_has_exercise`
  ADD CONSTRAINT `rut_has_exercise_ibfk_2` FOREIGN KEY (`Id_Exercise`) REFERENCES `exercise` (`Id_Exercise`),
  ADD CONSTRAINT `rut_has_exercise_ibfk_3` FOREIGN KEY (`Id_Routine`) REFERENCES `routine` (`Id_Routine`);

--
-- Filtros para la tabla `user_info`
--
ALTER TABLE `user_info`
  ADD CONSTRAINT `user_info_ibfk_1` FOREIGN KEY (`Id_User`) REFERENCES `login` (`Id_User`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
