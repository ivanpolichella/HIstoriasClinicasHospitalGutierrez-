-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 23-07-2018 a las 23:57:22
-- Versión del servidor: 10.1.25-MariaDB
-- Versión de PHP: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `grupo8`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE `configuracion` (
  `cantidad_listado` int(100) NOT NULL,
  `habilitado` varchar(2) NOT NULL,
  `titulo` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `descripcionHospital` text NOT NULL,
  `descripcionEspecialidades` text NOT NULL,
  `descripcionGuardia` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`cantidad_listado`, `habilitado`, `titulo`, `email`, `descripcionHospital`, `descripcionEspecialidades`, `descripcionGuardia`) VALUES
(4, 'si', '      Hospital Dr. Ricardo GutiÃ©rrez       ', 'hospital@gutierrez.com', 'Este es el centro de salud tiene un programa de residencias de primer nivel en el paÃ­s. Se ofrecen oportunidades de prÃ¡ctica intensiva y supervisada en Ã¡mbitos profesionales y por la misma -por supuesto- se recibe un salario mensual, acorde a lo que la regulaciÃ³n mÃ©dica profesional lo indica en cada momento.', 'Acorde a una respetable trayectoria en materia de medicina y salud, en Hospital Dr. Ricardo Gutierrez de La Plata podemos encontrar profesionales de las principales especialidades de salud. Del mismo modo, se brinca atencion programada y de urgencias se realizan estudios m&amp;amp;amp;amp;amp;amp;amp;amp;eacute;dicos y se brinda soporte en muchas de las ramas comunes de la medicina moderna.', 'Hospital Dr. Ricardo GutiÃ©rrez de La Plata dispone de un sofisticado servicio de guardias mÃ©dicas las 24 horas para la atenciÃ³n de distintas urgencias. La administraciÃ³n de la instituciÃ³n hace viable una eficiente separaciÃ³n de los pacientes segÃºn el nivel de seriedad y tipo de patologÃ­a.\r\n\r\n');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `controlSalud`
--

CREATE TABLE `controlSalud` (
  `idControlSalud` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `peso` double NOT NULL,
  `vacunasCompletas` tinyint(1) NOT NULL,
  `observacionesVacuna` text NOT NULL,
  `maduracionAcorde` tinyint(1) NOT NULL,
  `observacionesMaduracion` text NOT NULL,
  `exFisicoNormal` tinyint(1) NOT NULL,
  `exFisicoObservaciones` text NOT NULL,
  `pc` int(11) NOT NULL,
  `ppc` int(11) NOT NULL,
  `talla` int(11) NOT NULL,
  `alimentacion` varchar(255) NOT NULL,
  `observacionesGenerales` text NOT NULL,
  `pacienteId` int(11) NOT NULL,
  `userId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `controlSalud`
--

INSERT INTO `controlSalud` (`idControlSalud`, `fecha`, `peso`, `vacunasCompletas`, `observacionesVacuna`, `maduracionAcorde`, `observacionesMaduracion`, `exFisicoNormal`, `exFisicoObservaciones`, `pc`, `ppc`, `talla`, `alimentacion`, `observacionesGenerales`, `pacienteId`, `userId`) VALUES
(1, '2017-11-10', 1.7, 1, 'Completo', 1, 'Excelente', 0, 'no Cumple', 55, 45, 12, 'Buena', '', 28, 1),
(3, '2017-11-02', 2.3, 2, 'Completo', 1, 'Bien', 1, 'mejorando', 12, 15, 15, 'Buena', '', 28, 1),
(4, '2017-11-09', 2.5, 3, 'completo', 1, 'Bien', 1, 'cumple', 12, 20, 22, 'Excelente', '', 28, 1),
(5, '2017-11-15', 2.9, 3, 'Completo', 1, 'Bien', 1, 'cumple', 12, 15, 15, 'Buena', '', 28, 1),
(6, '2017-11-23', 3.2, 3, 'Completo', 1, 'Bien', 1, 'cumple', 12, 20, 22, 'Excelente', '', 28, 1),
(7, '2017-11-29', 3.9, 3, 'Completo', 1, 'Bien', 1, 'cumple', 12, 15, 15, 'Buena', '', 28, 1),
(8, '2017-12-02', 4.3, 3, 'COmpleto', 1, 'Bien', 1, 'cumple', 12, 20, 22, 'Excelente', '', 28, 1),
(9, '2017-12-14', 7, 1, 'buenas', 1, 'copado', 1, 're normal', 4, 2, 7, 're piolis', 'este pibe tiene futuro', 28, 1),
(10, '2017-12-13', 4, 1, '1221', 1, '123123', 1, '123123', 12, 14, 21, '1212', '12412', 28, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datosDemograficos`
--

CREATE TABLE `datosDemograficos` (
  `idDatosDemograficos` int(11) NOT NULL,
  `mascota` tinyint(4) DEFAULT NULL,
  `tipoViviendaId` int(11) NOT NULL,
  `tipoCalefaccionId` int(11) NOT NULL,
  `tipoAguaId` int(11) NOT NULL,
  `heladera` tinyint(1) DEFAULT NULL,
  `electricidad` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `datosDemograficos`
--

INSERT INTO `datosDemograficos` (`idDatosDemograficos`, `mascota`, `tipoViviendaId`, `tipoCalefaccionId`, `tipoAguaId`, `heladera`, `electricidad`) VALUES
(45, 0, 1, 1, 1, 0, 0),
(46, 0, 1, 1, 1, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `obraSocial`
--

CREATE TABLE `obraSocial` (
  `idObraSocial` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `obraSocial`
--

INSERT INTO `obraSocial` (`idObraSocial`, `nombre`) VALUES
(1, 'Galeno'),
(2, 'OSDE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paciente`
--

CREATE TABLE `paciente` (
  `idPaciente` int(11) NOT NULL,
  `apellido` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `domicilio` varchar(255) NOT NULL,
  `tel` varchar(255) NOT NULL,
  `fechaNacimiento` date NOT NULL,
  `genero` tinytext NOT NULL,
  `datosDemograficosId` int(11) NOT NULL,
  `obraSocialId` int(11) NOT NULL,
  `tipoDocId` int(11) NOT NULL,
  `numero` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `paciente`
--

INSERT INTO `paciente` (`idPaciente`, `apellido`, `nombre`, `domicilio`, `tel`, `fechaNacimiento`, `genero`, `datosDemograficosId`, `obraSocialId`, `tipoDocId`, `numero`) VALUES
(28, 'ROLO', 'vikingo', 'falkner', '121221', '2017-12-13', 'masculino', 45, 1, 1, 6666),
(29, 'aaaggg', 'aaaa', 'dati', '12345678', '2011-11-02', 'masculino', 46, 1, 1, 1221212121);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permiso`
--

CREATE TABLE `permiso` (
  `idPermiso` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `permiso`
--

INSERT INTO `permiso` (`idPermiso`, `nombre`) VALUES
(1, 'pacienteIndex'),
(2, 'pacienteNew'),
(3, 'pacienteDestroy'),
(4, 'pacienteUpdate'),
(5, 'pacienteShow');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `idRol` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`idRol`, `nombre`) VALUES
(1, 'Administrador'),
(2, 'Pediatra'),
(3, 'Recepcionista');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rolTienePermiso`
--

CREATE TABLE `rolTienePermiso` (
  `idRol` int(11) NOT NULL,
  `idPermiso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `rolTienePermiso`
--

INSERT INTO `rolTienePermiso` (`idRol`, `idPermiso`) VALUES
(1, 3),
(2, 1),
(2, 2),
(2, 4),
(2, 5),
(3, 1),
(3, 2),
(3, 4),
(3, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipoAgua`
--

CREATE TABLE `tipoAgua` (
  `idTipoAgua` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipoAgua`
--

INSERT INTO `tipoAgua` (`idTipoAgua`, `nombre`) VALUES
(1, 'corriente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipoCalefaccion`
--

CREATE TABLE `tipoCalefaccion` (
  `idTipoCalefaccion` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipoCalefaccion`
--

INSERT INTO `tipoCalefaccion` (`idTipoCalefaccion`, `nombre`) VALUES
(1, 'electrica'),
(2, 'gas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipoDocumento`
--

CREATE TABLE `tipoDocumento` (
  `idTipoDocumento` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipoDocumento`
--

INSERT INTO `tipoDocumento` (`idTipoDocumento`, `nombre`) VALUES
(1, 'DNI');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipoVivienda`
--

CREATE TABLE `tipoVivienda` (
  `idTipoVivienda` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipoVivienda`
--

INSERT INTO `tipoVivienda` (`idTipoVivienda`, `nombre`) VALUES
(1, 'iglu'),
(2, 'hacienda');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `turno`
--

CREATE TABLE `turno` (
  `idTurno` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `dniPaciente` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `turno`
--

INSERT INTO `turno` (`idTurno`, `fecha`, `hora`, `dniPaciente`) VALUES
(1, '2017-11-16', '17:00:00', 66666666),
(2, '2017-11-16', '15:30:00', 77777777),
(3, '2017-11-17', '13:00:00', 39801478),
(11, '2017-11-18', '16:00:00', 39801478),
(12, '2017-12-15', '13:30:00', 39801478);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idUsuario` int(11) NOT NULL,
  `email` varchar(255) DEFAULT '0',
  `username` varchar(255) NOT NULL DEFAULT '0',
  `password` varchar(255) NOT NULL DEFAULT '0',
  `activo` tinyint(1) DEFAULT '0',
  `updatedAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `firstName` varchar(255) NOT NULL DEFAULT '0',
  `lastName` varchar(255) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `email`, `username`, `password`, `activo`, `updatedAt`, `createdAt`, `firstName`, `lastName`) VALUES
(1, 'ftagliero@gmail.com', 'francotagliero', '$2y$10$UCoczyppyTJKGi06qyTP1.FjrrURJ4rx9JHOYD3041wmk9S.sxAMG', 0, '2017-10-06 15:08:17', '2017-10-06 15:08:17', 'Franco', 'Taglieroo'),
(2, 'ivancete@gmail.com', 'ivan', '$2y$10$UCoczyppyTJKGi06qyTP1.FjrrURJ4rx9JHOYD3041wmk9S.sxAMG', 0, '2017-10-06 16:55:41', '2017-10-06 16:55:41', 'Ivan', 'Polichella'),
(3, 'frannsegarra@gmail.com', 'Francisco', '$2y$10$UCoczyppyTJKGi06qyTP1.FjrrURJ4rx9JHOYD3041wmk9S.sxAMG', 0, '2017-10-06 17:17:48', '2017-10-06 17:17:48', 'Francisco', 'Segarra'),
(5, 'carlitosauzqui@gmail.com', 'carlitosauzqui', '$2y$10$UCoczyppyTJKGi06qyTP1.FjrrURJ4rx9JHOYD3041wmk9S.sxAMG', 1, '2017-10-16 02:09:19', '2017-10-16 02:09:19', 'Carlos', 'Auzqui'),
(6, 'leitojara@gmail.com', 'leitojara', '$2y$10$UCoczyppyTJKGi06qyTP1.FjrrURJ4rx9JHOYD3041wmk9S.sxAMG', 0, '2017-10-16 02:17:40', '2017-10-16 02:17:40', 'Leonardo', 'Jara'),
(8, 'malandro@hotmail.com', 'Malandro', '$2y$10$qpEQLAAPWfsd8khkJhcv2uMFmqRqjVn4V0ddBxPXJGN4SqbvT857K', 0, '2017-10-31 00:12:57', '2017-10-31 00:12:57', 'malandro mala', 'malajunta'),
(9, 'ivan@hot.com', 'sadboy123', '$2y$10$VBvVQaXgFqIy6ov0XOw9JuQRjsxd0s5ZTqU1R9kgt0qpuFC7voEPi', 0, '2017-11-09 12:16:31', '2017-11-09 12:16:31', 'ivan', 'poli');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarioTieneRol`
--

CREATE TABLE `usuarioTieneRol` (
  `idUsuario` int(11) NOT NULL,
  `idRol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuarioTieneRol`
--

INSERT INTO `usuarioTieneRol` (`idUsuario`, `idRol`) VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 1),
(3, 3),
(5, 1),
(6, 1),
(8, 2),
(8, 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`titulo`);

--
-- Indices de la tabla `controlSalud`
--
ALTER TABLE `controlSalud`
  ADD PRIMARY KEY (`idControlSalud`),
  ADD KEY `FK__usuario` (`userId`),
  ADD KEY `FK_controlSalud_paciente` (`pacienteId`);

--
-- Indices de la tabla `datosDemograficos`
--
ALTER TABLE `datosDemograficos`
  ADD PRIMARY KEY (`idDatosDemograficos`),
  ADD KEY `FK_datosDemograficos_tipoVivienda` (`tipoViviendaId`),
  ADD KEY `FK_datosDemograficos_tipoCalefaccion` (`tipoCalefaccionId`),
  ADD KEY `FK_datosDemograficos_tipoAgua` (`tipoAguaId`);

--
-- Indices de la tabla `obraSocial`
--
ALTER TABLE `obraSocial`
  ADD PRIMARY KEY (`idObraSocial`);

--
-- Indices de la tabla `paciente`
--
ALTER TABLE `paciente`
  ADD PRIMARY KEY (`idPaciente`),
  ADD UNIQUE KEY `datosDemograficosId` (`datosDemograficosId`),
  ADD UNIQUE KEY `numero` (`numero`),
  ADD KEY `FK_paciente_obraSocial` (`obraSocialId`),
  ADD KEY `FK_paciente_tipoDocumento` (`tipoDocId`) USING BTREE;

--
-- Indices de la tabla `permiso`
--
ALTER TABLE `permiso`
  ADD PRIMARY KEY (`idPermiso`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`idRol`);

--
-- Indices de la tabla `rolTienePermiso`
--
ALTER TABLE `rolTienePermiso`
  ADD PRIMARY KEY (`idRol`,`idPermiso`),
  ADD KEY `FKidPermiso` (`idPermiso`);

--
-- Indices de la tabla `tipoAgua`
--
ALTER TABLE `tipoAgua`
  ADD PRIMARY KEY (`idTipoAgua`);

--
-- Indices de la tabla `tipoCalefaccion`
--
ALTER TABLE `tipoCalefaccion`
  ADD PRIMARY KEY (`idTipoCalefaccion`);

--
-- Indices de la tabla `tipoDocumento`
--
ALTER TABLE `tipoDocumento`
  ADD PRIMARY KEY (`idTipoDocumento`);

--
-- Indices de la tabla `tipoVivienda`
--
ALTER TABLE `tipoVivienda`
  ADD PRIMARY KEY (`idTipoVivienda`);

--
-- Indices de la tabla `turno`
--
ALTER TABLE `turno`
  ADD PRIMARY KEY (`idTurno`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`);

--
-- Indices de la tabla `usuarioTieneRol`
--
ALTER TABLE `usuarioTieneRol`
  ADD PRIMARY KEY (`idUsuario`,`idRol`),
  ADD KEY `rol` (`idRol`,`idUsuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `controlSalud`
--
ALTER TABLE `controlSalud`
  MODIFY `idControlSalud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `datosDemograficos`
--
ALTER TABLE `datosDemograficos`
  MODIFY `idDatosDemograficos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;
--
-- AUTO_INCREMENT de la tabla `obraSocial`
--
ALTER TABLE `obraSocial`
  MODIFY `idObraSocial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `paciente`
--
ALTER TABLE `paciente`
  MODIFY `idPaciente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT de la tabla `permiso`
--
ALTER TABLE `permiso`
  MODIFY `idPermiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `idRol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `tipoAgua`
--
ALTER TABLE `tipoAgua`
  MODIFY `idTipoAgua` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `tipoCalefaccion`
--
ALTER TABLE `tipoCalefaccion`
  MODIFY `idTipoCalefaccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `tipoDocumento`
--
ALTER TABLE `tipoDocumento`
  MODIFY `idTipoDocumento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `tipoVivienda`
--
ALTER TABLE `tipoVivienda`
  MODIFY `idTipoVivienda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `turno`
--
ALTER TABLE `turno`
  MODIFY `idTurno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `datosDemograficos`
--
ALTER TABLE `datosDemograficos`
  ADD CONSTRAINT `FK_datosDemograficos_tipoAgua` FOREIGN KEY (`tipoAguaId`) REFERENCES `tipoAgua` (`idTipoAgua`),
  ADD CONSTRAINT `FK_datosDemograficos_tipoCalefaccion` FOREIGN KEY (`tipoCalefaccionId`) REFERENCES `tipoCalefaccion` (`idTipoCalefaccion`),
  ADD CONSTRAINT `FK_datosDemograficos_tipoVivienda` FOREIGN KEY (`tipoViviendaId`) REFERENCES `tipoVivienda` (`idTipoVivienda`);

--
-- Filtros para la tabla `paciente`
--
ALTER TABLE `paciente`
  ADD CONSTRAINT `FK_idDatosDemograficos` FOREIGN KEY (`datosDemograficosId`) REFERENCES `datosDemograficos` (`idDatosDemograficos`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_paciente_datosDemograficos` FOREIGN KEY (`datosDemograficosId`) REFERENCES `datosDemograficos` (`idDatosDemograficos`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_paciente_obraSocial` FOREIGN KEY (`obraSocialId`) REFERENCES `obraSocial` (`idObraSocial`),
  ADD CONSTRAINT `FK_paciente_tipoDocumento` FOREIGN KEY (`tipoDocId`) REFERENCES `tipoDocumento` (`idTipoDocumento`),
  ADD CONSTRAINT `datosDemograficosId` FOREIGN KEY (`datosDemograficosId`) REFERENCES `datosDemograficos` (`idDatosDemograficos`) ON DELETE CASCADE;

--
-- Filtros para la tabla `rolTienePermiso`
--
ALTER TABLE `rolTienePermiso`
  ADD CONSTRAINT `FKidPermiso` FOREIGN KEY (`idPermiso`) REFERENCES `permiso` (`idPermiso`),
  ADD CONSTRAINT `FKidRol` FOREIGN KEY (`idRol`) REFERENCES `rol` (`idRol`);

--
-- Filtros para la tabla `usuarioTieneRol`
--
ALTER TABLE `usuarioTieneRol`
  ADD CONSTRAINT `FK_IDKEY` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `rol` FOREIGN KEY (`idRol`) REFERENCES `rol` (`idRol`),
  ADD CONSTRAINT `usuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
