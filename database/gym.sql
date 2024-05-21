-- MySQL dump 10.13  Distrib 8.0.36, for Win64 (x86_64)
--
-- Host: localhost    Database: gym
-- ------------------------------------------------------
-- Server version	8.2.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `calendar`
--

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


DROP TABLE IF EXISTS `calendar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `calendar` (
  `Id_Calendar` int NOT NULL AUTO_INCREMENT,
  `Id_Day` int DEFAULT NULL,
  `Id_User` int DEFAULT NULL,
  `Id_Routine` int DEFAULT NULL,
  `Id_Check` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id_Calendar`),
  KEY `fk_calendar_user` (`Id_User`),
  KEY `fk_calendar_days` (`Id_Day`),
  KEY `fk_calendar_routine` (`Id_Routine`),
  CONSTRAINT `calendar_ibfk_1` FOREIGN KEY (`Id_Routine`) REFERENCES `routine` (`Id_Routine`),
  CONSTRAINT `calendar_ibfk_2` FOREIGN KEY (`Id_User`) REFERENCES `user_info` (`Id_User`),
  CONSTRAINT `fk_calendar_days` FOREIGN KEY (`Id_Day`) REFERENCES `days` (`Id_Day`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `calendar`
--

LOCK TABLES `calendar` WRITE;
/*!40000 ALTER TABLE `calendar` DISABLE KEYS */;
INSERT INTO `calendar` VALUES (16,1,1077722009,0,0),(24,7,1077722009,0,0),(57,2,1077722009,63,0);
/*!40000 ALTER TABLE `calendar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chat_routine`
--

DROP TABLE IF EXISTS `chat_routine`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chat_routine` (
  `Id_Chat_Routine` int NOT NULL AUTO_INCREMENT,
  `Name_Chat_Routine` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Description_Chat_Routine` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Duration_Chat_Routine` int DEFAULT NULL,
  `Id_Difficulty` int DEFAULT NULL,
  PRIMARY KEY (`Id_Chat_Routine`),
  KEY `Id_Difficulty` (`Id_Difficulty`),
  CONSTRAINT `chat_routine_ibfk_1` FOREIGN KEY (`Id_Difficulty`) REFERENCES `difficulty` (`Id_Difficulty`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chat_routine`
--

LOCK TABLES `chat_routine` WRITE;
/*!40000 ALTER TABLE `chat_routine` DISABLE KEYS */;
INSERT INTO `chat_routine` VALUES (1,'Rutina de Pectorales','Fortalece los músculos pectorales.',30,2),(2,'Rutina de Brazos','Fortalece los músculos de los brazos.',25,2),(3,'Rutina de Piernas','Fortalece los músculos de las piernas.',30,3),(4,'Rutina de Abdominales','Fortalece los músculos abdominales.',20,2),(5,'Rutina de Hombros','Desarrolla los músculos de los hombros.',25,2),(6,'Rutina de Espalda','Fortalece los músculos de la espalda.',30,2),(7,'Rutina de Ejercicios de Core','Fortalece los músculos del core para mejorar la estabilidad y el equilibrio.',25,2),(8,'Rutina de Ejercicios para la Espalda Baja','Fortalece los músculos de la espalda baja y previene lesiones.',20,1),(9,'Rutina de Estiramiento Post-Entrenamiento','Mejora la flexibilidad y reduce la tensión muscular después del ejercicio.',15,1);
/*!40000 ALTER TABLE `chat_routine` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chat_routine_exercises`
--

DROP TABLE IF EXISTS `chat_routine_exercises`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chat_routine_exercises` (
  `Id_Exercise` int DEFAULT NULL,
  `Id_Chat_Routine` int DEFAULT NULL,
  KEY `Id_Exercise` (`Id_Exercise`),
  KEY `Id_Chat_Routine` (`Id_Chat_Routine`),
  CONSTRAINT `chat_routine_exercises_ibfk_1` FOREIGN KEY (`Id_Exercise`) REFERENCES `exercise` (`Id_Exercise`),
  CONSTRAINT `chat_routine_exercises_ibfk_2` FOREIGN KEY (`Id_Chat_Routine`) REFERENCES `chat_routine` (`Id_Chat_Routine`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chat_routine_exercises`
--

LOCK TABLES `chat_routine_exercises` WRITE;
/*!40000 ALTER TABLE `chat_routine_exercises` DISABLE KEYS */;
INSERT INTO `chat_routine_exercises` VALUES (22,1),(23,1),(24,2),(25,2),(26,3),(27,3),(28,4),(29,4),(30,5),(31,5),(32,6),(33,6),(34,7),(35,7),(36,8),(37,8),(38,9);
/*!40000 ALTER TABLE `chat_routine_exercises` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `data`
--

DROP TABLE IF EXISTS `data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `data` (
  `Id_Data` int NOT NULL AUTO_INCREMENT,
  `Id_User` int DEFAULT NULL,
  `Height_User` decimal(5,2) DEFAULT NULL,
  `Weight_User` decimal(5,2) DEFAULT NULL,
  `Imc_User` decimal(4,1) DEFAULT NULL,
  PRIMARY KEY (`Id_Data`),
  KEY `Id_User` (`Id_User`),
  CONSTRAINT `data_ibfk_1` FOREIGN KEY (`Id_User`) REFERENCES `user_info` (`Id_User`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data`
--

LOCK TABLES `data` WRITE;
/*!40000 ALTER TABLE `data` DISABLE KEYS */;
INSERT INTO `data` VALUES (2,1077722009,1.67,64.00,22.9),(9,1075798615,1.64,66.00,24.5),(10,1021392608,1.70,60.00,20.8),(12,1076982371,1.98,68.00,17.3);
/*!40000 ALTER TABLE `data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `days`
--

DROP TABLE IF EXISTS `days`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `days` (
  `Id_Day` int NOT NULL,
  `Day` varchar(9) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`Id_Day`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `days`
--

LOCK TABLES `days` WRITE;
/*!40000 ALTER TABLE `days` DISABLE KEYS */;
INSERT INTO `days` VALUES (1,'Lunes'),(2,'Martes'),(3,'Miércoles'),(4,'Jueves'),(5,'Viernes'),(6,'Sábado'),(7,'Domingo');
/*!40000 ALTER TABLE `days` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `difficulty`
--

DROP TABLE IF EXISTS `difficulty`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `difficulty` (
  `Id_Difficulty` int NOT NULL,
  `Difficulty` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`Id_Difficulty`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `difficulty`
--

LOCK TABLES `difficulty` WRITE;
/*!40000 ALTER TABLE `difficulty` DISABLE KEYS */;
INSERT INTO `difficulty` VALUES (1,'Fácil'),(2,'Intermedio'),(3,'Dificíl');
/*!40000 ALTER TABLE `difficulty` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exercise`
--

DROP TABLE IF EXISTS `exercise`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `exercise` (
  `Id_Exercise` int NOT NULL,
  `Name_Exercise` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Description_Exercise` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Duration_Exercise` int DEFAULT NULL,
  `Id_Difficulty` int DEFAULT NULL,
  `Id_Muscle_Group` int DEFAULT NULL,
  `url_video` text COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`Id_Exercise`),
  KEY `Id_Difficulty` (`Id_Difficulty`),
  KEY `Id_Muscle_Group` (`Id_Muscle_Group`),
  CONSTRAINT `exercise_ibfk_1` FOREIGN KEY (`Id_Difficulty`) REFERENCES `difficulty` (`Id_Difficulty`),
  CONSTRAINT `exercise_ibfk_2` FOREIGN KEY (`Id_Muscle_Group`) REFERENCES `muscle_group` (`Id_Muscle_Group`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exercise`
--

LOCK TABLES `exercise` WRITE;
/*!40000 ALTER TABLE `exercise` DISABLE KEYS */;
INSERT INTO `exercise` VALUES (0,'Flexiones de brazos','Ejercicio básico que trabaja los músculos pectorales y los tríceps.',15,2,1,'../videos/Flexiones de brazo.mp4'),(1,'Aperturas con mancuernas','Ejercicio para trabajar la expansión de los pectorales.',20,1,1,'../videos/Aperturas con mancuernas.mp4'),(2,'Pullover con mancuerna','Ejercicio que ayuda a trabajar la parte inferior de los pectorales.',15,1,1,'../videos/pullover con mancuerna.mp4'),(3,'Flexiones diamante','Variante de las flexiones que enfoca más en los tríceps.',10,3,1,'../videos/Flexiones diamante.mp4'),(4,'Curl de bíceps con barra','Ejercicio para trabajar los músculos del bíceps.',15,2,2,'../videos/curl de biceps con mancuernas.mp4'),(5,'Tríceps en polea alta','Ejercicio para fortalecer los músculos del tríceps.',20,2,2,'../videos/Triceps con polea alta.mp4'),(6,'Curl de bíceps con mancuernas','Ejercicio básico para el desarrollo de los bíceps.',15,1,2,'../videos/curl de biceps con mancuernas.mp4'),(7,'Crunch abdominal','Ejercicio básico para trabajar los abdominales.',10,1,3,'../videos/Crunch abdominal.mp4'),(8,'Plancha abdominal','Ejercicio estático que fortalece los músculos abdominales.',15,1,3,'../videos/Plancha abdominal.mp4'),(9,'Elevación de piernas','Ejercicio para trabajar la parte baja de los abdominales.',20,3,3,'../videos/Crunches.mp4'),(10,'Rotación de tronco con balón','Ejercicio para fortalecer los músculos oblicuos.',15,3,3,'../videos/Rotacion de tronco con balon.mp4'),(11,'Sentadillas','Ejercicio básico para fortalecer los músculos de las piernas.',20,2,4,'../videos/Sentadillas.mp4'),(12,'Zancadas','Ejercicio para trabajar los cuádriceps y los glúteos.',15,2,4,'../videos/Zancadas.mp4'),(13,'Elevación de talones','Ejercicio para fortalecer los músculos de la pantorrilla.',10,1,4,'../videos/Elevaciones de talones.mp4'),(14,'Prensa de piernas','Ejercicio para trabajar los cuádriceps.',20,2,4,'../videos/Prensa de pierna.mp4'),(15,'Press militar','Ejercicio básico para trabajar los hombros.',20,2,5,'../videos/Press militar.mp4'),(16,'Elevaciones laterales','Ejercicio para trabajar los deltoides laterales.',15,1,5,'../videos/Elevaciones laterales.mp4'),(17,'Pájaros con mancuernas','Ejercicio para fortalecer los deltoides posteriores.',10,2,5,'../videos/Pajaros con mancuernas.mp4'),(18,'Press frontal con barra','Ejercicio para el desarrollo de los deltoides anteriores.',20,2,5,'../videos/.mp4'),(21,'Sentadillas sumo','Variante de las sentadillas para enfocarse en los glúteos.',20,3,6,'../videos/Sentadilla sumo.mp4'),(22,'Press de Banca','Ejercicio de levantamiento de pesas que se centra en el desarrollo de los músculos pectorales.',10,2,1,''),(23,'Flexiones de Pecho','Ejercicio de peso corporal que fortalece los músculos pectorales, tríceps y hombros.',10,1,1,'../videos/Flexiones de brazo.mp4'),(24,'Curl de Bíceps con Mancuernas','Ejercicio para trabajar los músculos bíceps utilizando mancuernas.',7,2,2,'../videos/curl de biceps con mancuernas.mp4'),(25,'Extensiones de Tríceps con Cuerda','Ejercicio que se enfoca en los músculos tríceps utilizando la máquina de poleas.',8,2,2,'../videos/Extension de triceps.mp4'),(26,'Sentadillas con Barra','Ejercicio compuesto que trabaja los músculos de las piernas y glúteos.',10,3,4,'../videos/Sentadilla con barra.mp4'),(27,'Prensa de Piernas','Ejercicio de máquina que se enfoca en los músculos cuádriceps.',10,2,4,'../videos/Prensa de pierna.mp4'),(28,'Plancha Frontal','Ejercicio de fortalecimiento del core que implica mantener el cuerpo en posición de tabla.',7,2,3,'../videos/Plancha abdominal.mp4'),(29,'Crunches','Ejercicio clásico de abdominales que trabaja la parte superior del abdomen.',8,1,3,'../videos/Crunches.mp4'),(30,'Elevaciones Laterales con Mancuernas','Ejercicio que trabaja los deltoides laterales.',8,2,5,'../videos/Elevaciones laterales.mp4'),(31,'Press Arnold','Variante del press de hombros que trabaja todo el deltoides.',10,2,5,'../videos/Press arnold.mp4'),(32,'Dominadas','Ejercicio compuesto que trabaja la espalda, bíceps y hombros.',10,3,6,'../videos/dominadas1.mp4'),(33,'Remo con Barra','Ejercicio que se enfoca en la parte superior de la espalda y los bíceps.',10,2,6,''),(34,'Plancha Lateral','Ejercicio que fortalece los oblicuos y el core lateral.',8,2,3,'../videos/Plancha frontal.mp4'),(35,'Mountain Climbers','Ejercicio dinámico que trabaja el core y aumenta la frecuencia cardíaca.',7,2,3,'../videos/Mountain climbers.mp4'),(36,'Superman','Ejercicio que fortalece la espalda baja y los músculos paravertebrales.',10,1,6,'../videos/Superman.mp4'),(37,'Bird Dog','Ejercicio de equilibrio que fortalece el core y la espalda baja.',10,1,7,'../videos/Bird dog.mp4'),(38,'Estiramiento de Cuádriceps','Estiramiento de los músculos delanteros del muslo.',5,1,4,'../videos/Extension de cuadriceps.mp4');
/*!40000 ALTER TABLE `exercise` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `information`
--

DROP TABLE IF EXISTS `information`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `information` (
  `Id_Information` int NOT NULL,
  `IMC_MIN` decimal(5,2) DEFAULT '0.00',
  `IMC_MAX` decimal(5,2) DEFAULT '0.00',
  `Description_Nutritional` varchar(255) COLLATE utf8mb4_general_ci DEFAULT 'N/A',
  `D_P` varchar(255) COLLATE utf8mb4_general_ci DEFAULT 'N',
  `D_C` varchar(255) COLLATE utf8mb4_general_ci DEFAULT 'N',
  `D_GS` varchar(255) COLLATE utf8mb4_general_ci DEFAULT 'N',
  `A_P` varchar(255) COLLATE utf8mb4_general_ci DEFAULT 'N',
  `A_C` varchar(255) COLLATE utf8mb4_general_ci DEFAULT 'N',
  `A_GS` varchar(255) COLLATE utf8mb4_general_ci DEFAULT 'N',
  `C_P` varchar(255) COLLATE utf8mb4_general_ci DEFAULT 'N',
  `C_C` varchar(255) COLLATE utf8mb4_general_ci DEFAULT 'N',
  `C_GS` varchar(255) COLLATE utf8mb4_general_ci DEFAULT 'N',
  PRIMARY KEY (`Id_Information`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `information`
--

LOCK TABLES `information` WRITE;
/*!40000 ALTER TABLE `information` DISABLE KEYS */;
INSERT INTO `information` VALUES (1,0.00,18.49,'Deberías aumentar la ingesta de alimentos ricos en vitaminas y minerales de buena calidad. Evita los alimentos procesados ricos en grasas saturadas y azúcares.','Proteínas: 30% huevos o queso.','Carbohidratos: 50% arepa integral o pan de yuca.','Grasas saludables: 20% aguacate o mantequilla de n','Proteínas: 30% pollo o pescado','Carbohidratos: 50% arroz integral o quinoa','Grasas saludables: 20% aceite de oliva o nueces','Proteínas: 30% pollo o pescado','Carbohidratos: 50% arroz integral o quinoa','Grasas saludables: 20% aceite de oliva o nueces'),(2,18.50,24.99,'Se recomienda mantener una dieta equilibrada que incluya frutas, verduras, cereales integrales, leche y productos lácteos sin grasa o bajos en grasa. También deberías incluir una variedad de alimentos con proteínas como mariscos, carnes y huevos','Proteínas: 30% huevos o queso','Carbohidratos: 50% frutas o arepa integral','Grasas saludables: 20% nueces o semillas','Proteínas: 30% pollo o pescado','Carbohidratos: 50% verduras o granos enteros','Grasas saludables: 20% aceite de oliva o aguacate','Proteínas: 30% pollo o pescado','Carbohidratos: 50% verduras o granos enteros','Grasas saludables: 20% aceite de oliva o aguacate'),(3,25.00,29.99,'Deberías establecer horarios al comer y ser ordenado. Recuerda que el 50% de tu plato debe ser de verduras, el 25% de proteínas y el otro 25% de carbohidratos','Proteínas: 30% huevos o queso','Carbohidratos: 50% arepa integral o pan de yuca','Grasas saludables: 20% aguacate o mantequilla de n','Proteínas: 25% verduras, 25% pollo o pescado','Carbohidratos: 50% verduras, 25% arroz integral o ','Grasas saludables: 25% aceite de oliva o aguacate','Proteínas: 25% verduras, 25% pollo o pescado','Carbohidratos: 50% verduras, 25% arroz integral o ','Grasas saludables: 25% aceite de oliva o aguacate'),(4,30.00,100.00,'En este caso, es especialmente importante seguir una dieta equilibrada y hacer ejercicio regularmente. Consulta a un profesional de la salud para obtener un plan de alimentación y ejercicio personalizado.','Proteínas: 30% huevos o queso','Carbohidratos: 50% arepa integral o pan de yuca','Grasas saludables: 20% aguacate o mantequilla de n','Proteínas: 25% verduras, 25% pollo o pescado','Carbohidratos: 50% verduras, 25% arroz integral o ','Grasas saludables: 25% aceite de oliva o aguacate','Proteínas: 25% verduras, 25% pollo o pescado','Carbohidratos: 50% verduras, 25% arroz integral o ','Grasas saludables: 25% aceite de oliva o aguacate');
/*!40000 ALTER TABLE `information` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `login`
--

DROP TABLE IF EXISTS `login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `login` (
  `Id_Register` int NOT NULL AUTO_INCREMENT,
  `Id_User` int NOT NULL,
  `Password` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Id_Role_User` int DEFAULT NULL,
  `Entry_User` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id_Register`,`Id_User`),
  KEY `Id_User` (`Id_User`),
  KEY `Id_Role_User` (`Id_Role_User`),
  CONSTRAINT `login_ibfk_1` FOREIGN KEY (`Id_Role_User`) REFERENCES `roles` (`Id_Role_User`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login`
--

LOCK TABLES `login` WRITE;
/*!40000 ALTER TABLE `login` DISABLE KEYS */;
INSERT INTO `login` VALUES (0,123,'$2y$10$P2FVIaFegQJ80iwp5wj3xOcnliSTFvRybqXGoaikPI/nKFq6L0EGW',2,'2024-04-13 00:00:00'),(1,1077722009,'$2y$10$rIvT/PSY8KOcfubA/EdIIeepBjY7TfWzntv981jsxPnL6PjPM4GLO',1,'2024-04-13 18:02:55'),(10,1075798615,'$2y$10$SZn9Jo6IexP3nYNwuBksE.l2Wk.c.KPChydGd9Hb3JXX1JoYTbx3K',1,'2024-05-16 11:32:14'),(11,1021392608,'$2y$10$4afde/T5EoAskvMoCgGFwu75LkeT9jAJvfbcYV2bXn5Y0bgFvzYx.',1,'2024-05-19 21:27:25'),(12,123,'$2y$10$N9AFzN3xvYOx9s.36hvku.ifrXXI5NjgpMRmjzA5G/C4ONgCt6.B6',1,'2024-05-19 21:53:53'),(13,123,'$2y$10$EYEofkyWVLezOtmErA0xzOudVCvE0Op/20BBOmRHanPjhq8gmPgTG',1,'2024-05-19 21:56:49'),(14,1076982371,'$2y$10$BsrDJ8pO8AQXw6T4fgOhSuS6oUpm.6oidli8hLEYACxbQ.Bydufvu',1,'2024-05-19 22:00:05');
/*!40000 ALTER TABLE `login` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `muscle_group`
--

DROP TABLE IF EXISTS `muscle_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `muscle_group` (
  `Id_Muscle_Group` int NOT NULL,
  `Name_Group` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Description_Group` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`Id_Muscle_Group`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `muscle_group`
--

LOCK TABLES `muscle_group` WRITE;
/*!40000 ALTER TABLE `muscle_group` DISABLE KEYS */;
INSERT INTO `muscle_group` VALUES (1,'Pectorales','Grupo de músculos que se encuentran en la parte frontal del torso.'),(2,'Brazos','Grupo de músculos que se encuentran en los brazos.'),(3,'Abdominales','Grupo de músculos que se encuentran en la zona abdominal.'),(4,'Piernas','Grupo de músculos que se encuentran en las piernas.'),(5,'Hombros','Grupo de músculos que se encuentran en los hombros.'),(6,'Espalda','Grupo de músculos que se encuentran en la parte posterior del torso.'),(7,'Glúteos','Grupo de músculos que se encuentran en los glúteos.');
/*!40000 ALTER TABLE `muscle_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `Id_Role_User` int NOT NULL,
  `Role` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`Id_Role_User`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'User'),(2,'Entrenador');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `routine`
--

DROP TABLE IF EXISTS `routine`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `routine` (
  `Id_Routine` int NOT NULL AUTO_INCREMENT,
  `Name_routine` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Approach_Routine` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Duration_Routine` int DEFAULT NULL,
  `Id_Difficulty` int DEFAULT NULL,
  `Id_User` int DEFAULT NULL,
  `Id_Check` tinyint(1) DEFAULT NULL,
  `completion_time` time DEFAULT NULL,
  `resume_time` time DEFAULT NULL,
  PRIMARY KEY (`Id_Routine`),
  KEY `Id_Difficulty` (`Id_Difficulty`),
  KEY `Id_User` (`Id_User`),
  CONSTRAINT `routine_ibfk_1` FOREIGN KEY (`Id_Difficulty`) REFERENCES `difficulty` (`Id_Difficulty`),
  CONSTRAINT `routine_ibfk_2` FOREIGN KEY (`Id_User`) REFERENCES `user_info` (`Id_User`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `routine`
--

LOCK TABLES `routine` WRITE;
/*!40000 ALTER TABLE `routine` DISABLE KEYS */;
INSERT INTO `routine` VALUES (0,'Descanso','Descanso',NULL,NULL,NULL,0,NULL,NULL),(54,'rutina 10','hola',NULL,NULL,1075798615,NULL,NULL,NULL),(55,'rutina 9','hola',NULL,1,1075798615,NULL,NULL,NULL),(62,'wdwdadw','wadwdadwdw',16,2,1077722009,1,'13:34:22','23:59:59'),(63,'wdwdadwdsc','wadwdadwdwcd',43,3,1077722009,NULL,'11:32:44','23:59:59'),(64,'j','qw',43,3,1076982371,NULL,'22:36:33','23:59:59'),(65,'jwq','qw',NULL,3,1076982371,NULL,NULL,NULL),(66,'12','122',NULL,NULL,1021392608,NULL,NULL,NULL),(67,'wefefs','sef',NULL,1,1076982371,NULL,NULL,NULL),(70,'awaqwas','assasqw',48,3,1077722009,1,'11:31:02','23:59:59');
/*!40000 ALTER TABLE `routine` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rut_has_exercise`
--

DROP TABLE IF EXISTS `rut_has_exercise`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rut_has_exercise` (
  `Id_Routine` int NOT NULL,
  `Id_Exercise` int DEFAULT NULL,
  KEY `Id_Routine` (`Id_Routine`),
  KEY `Id_Exercise` (`Id_Exercise`),
  CONSTRAINT `rut_has_exercise_ibfk_2` FOREIGN KEY (`Id_Exercise`) REFERENCES `exercise` (`Id_Exercise`),
  CONSTRAINT `rut_has_exercise_ibfk_3` FOREIGN KEY (`Id_Routine`) REFERENCES `routine` (`Id_Routine`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rut_has_exercise`
--

LOCK TABLES `rut_has_exercise` WRITE;
/*!40000 ALTER TABLE `rut_has_exercise` DISABLE KEYS */;
INSERT INTO `rut_has_exercise` VALUES (63,21),(63,32),(63,3),(62,0),(64,3),(64,26),(64,21),(70,3),(70,10),(70,21);
/*!40000 ALTER TABLE `rut_has_exercise` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_info`
--

DROP TABLE IF EXISTS `user_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_info` (
  `Id_User` int NOT NULL,
  `Name_User` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Last_Name_User` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Email_User` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Gender_User` char(1) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`Id_User`),
  CONSTRAINT `user_info_ibfk_1` FOREIGN KEY (`Id_User`) REFERENCES `login` (`Id_User`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_info`
--

LOCK TABLES `user_info` WRITE;
/*!40000 ALTER TABLE `user_info` DISABLE KEYS */;
INSERT INTO `user_info` VALUES (123,'David David Felipe','Garcia Ortiz','davidfelipegarciaortiz@gmail.com','M'),(1021392608,'David David Felipe','Garcia Ortiz','davidfelipegarciaortiz@gmail.com','M'),(1075798615,'juan david','claros cachaya','juan_clarosca@fet.edu.co','M'),(1076982371,'Jhon Esteban','Pinto Jhon','Jhones@fet.edu','M'),(1077722009,'Jhonsasa','Pintoso','Jhonpinto008@gmail.com','M');
/*!40000 ALTER TABLE `user_info` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-05-20 13:37:47
