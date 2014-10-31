-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 31-10-2014 a las 10:16:57
-- Versión del servidor: 5.5.40-0ubuntu0.14.04.1
-- Versión de PHP: 5.5.9-1ubuntu4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `sis_fac`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aclaracion_queja`
--

CREATE TABLE IF NOT EXISTS `aclaracion_queja` (
  `id` int(6) NOT NULL,
  `fecha_recep` datetime DEFAULT NULL,
  `usuario` varchar(45) DEFAULT NULL,
  `area` varchar(45) DEFAULT NULL,
  `fecha_atenc` datetime DEFAULT NULL,
  `tipo_solic` varchar(45) DEFAULT NULL,
  `detalle_solic` varchar(45) DEFAULT NULL,
  `linea_negoc` varchar(45) DEFAULT NULL,
  `cod_cte` varchar(45) DEFAULT NULL,
  `proceso` varchar(45) DEFAULT NULL,
  `fecha_envio` datetime DEFAULT NULL,
  `fecha_cierre` datetime DEFAULT NULL,
  `estatus` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `adjuntos`
--

CREATE TABLE IF NOT EXISTS `adjuntos` (
  `idadjuntos` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `area` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_documento` int(11) NOT NULL,
  PRIMARY KEY (`idadjuntos`),
  KEY `fk_adjuntos_documento1_idx` (`id_documento`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `area`
--

CREATE TABLE IF NOT EXISTS `area` (
  `id_area` int(11) NOT NULL AUTO_INCREMENT,
  `tx_area` varchar(45) DEFAULT NULL,
  `oper_sol` int(11) DEFAULT NULL,
  `suspendido` int(11) DEFAULT '0',
  PRIMARY KEY (`id_area`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Volcado de datos para la tabla `area`
--

INSERT INTO `area` (`id_area`, `tx_area`, `oper_sol`, `suspendido`) VALUES
(1, 'DIRECCIONAMIENTO', 0, NULL),
(2, 'ASIGNACIÓN DE CONDICIONES', 0, NULL),
(3, 'ASIGNACION TEMM', 0, NULL),
(4, 'GENERACIÓN NOTA DE CRÉDITO', 0, NULL),
(5, 'GENERACIÓN FACTURA', 0, NULL),
(6, 'ENTREGA DE DOCUMENTOS', 0, NULL),
(7, 'ATENCION A CONSULTAS', 0, NULL),
(8, 'CAPITAL HUMANO', 1, NULL),
(9, 'CONTABILIDAD', 1, NULL),
(10, 'COBRANZA', 1, NULL),
(11, 'RED DE DISTRIBUCION Y ADMON COMERCIAL', 1, NULL),
(12, 'RED Y SISTEMAS', 1, NULL),
(13, 'EMPRESAS', 1, NULL),
(14, 'EXPERIENCIA DEL CLIENTE', 1, NULL),
(15, 'FISCAL', 1, NULL),
(16, 'FINANZAS', 1, NULL),
(17, 'FUNDACION TELEFONICA', 1, NULL),
(18, 'NEGOCIO MAYORISTA', 1, NULL),
(19, 'OPERACIONES COMERCIALES', 1, NULL),
(20, 'FRONT END', 1, NULL),
(21, 'GESTION MARKETING', 1, NULL),
(22, 'RECARGA Y PROYECTOS ESPECIALES', 1, NULL),
(23, 'SERVICIOS GENERALES', 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Catalogo_CFDI`
--

CREATE TABLE IF NOT EXISTS `Catalogo_CFDI` (
  `id_catalogo_cfdi` int(11) NOT NULL AUTO_INCREMENT,
  `tx_catalogo_cfdi` varchar(150) DEFAULT NULL,
  `suspendido` int(11) DEFAULT '0',
  PRIMARY KEY (`id_catalogo_cfdi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conceptos_doc`
--

CREATE TABLE IF NOT EXISTS `conceptos_doc` (
  `id_conceptos_doc` int(11) NOT NULL AUTO_INCREMENT,
  `id_codigo_concepto` varchar(45) DEFAULT NULL,
  `tx_concepto` varchar(45) DEFAULT NULL,
  `fac_unidades` varchar(45) DEFAULT NULL,
  `fac_precio_uni` varchar(45) DEFAULT NULL,
  `fac_descuento` varchar(45) DEFAULT NULL,
  `not_importe_dispo` varchar(45) DEFAULT NULL,
  `not_monto_afec` varchar(45) DEFAULT NULL,
  `documento_iddocumento` int(11) NOT NULL,
  PRIMARY KEY (`id_conceptos_doc`),
  KEY `fk_conceptos_doc_documento1_idx` (`documento_iddocumento`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documento`
--

CREATE TABLE IF NOT EXISTS `documento` (
  `id_documento` int(11) NOT NULL AUTO_INCREMENT,
  `id_codigo_cliente` varchar(45) DEFAULT NULL,
  `tipo_nc` varchar(45) DEFAULT NULL,
  `dias_vencimiento` varchar(45) DEFAULT NULL,
  `leyenda_doc` varchar(45) DEFAULT NULL,
  `compa_fac` varchar(45) DEFAULT NULL,
  `refac_folio` varchar(45) DEFAULT NULL,
  `IVA_idIVA` int(11) NOT NULL,
  `Moneda_idMoneda` int(11) NOT NULL,
  `tipo_documento_idtipo_doc` int(11) NOT NULL,
  `solicitudes_idSolicitudes` int(11) NOT NULL,
  `razon_social` varchar(45) DEFAULT NULL,
  `leyenda_mat` varchar(45) DEFAULT NULL,
  `salida` varchar(45) DEFAULT NULL,
  `entrada` varchar(45) DEFAULT NULL,
  `motivos` varchar(45) DEFAULT NULL,
  `folio_fac_origen` varchar(45) DEFAULT NULL,
  `monto_total_fac_orig` varchar(45) DEFAULT NULL,
  `monto_afectar_nc` varchar(45) DEFAULT NULL,
  `fecha_emision_nc` date DEFAULT NULL,
  `folio_nc` varchar(45) DEFAULT NULL,
  `fecha_emision_fac_or` date DEFAULT NULL,
  `importe_total` varchar(45) DEFAULT NULL,
  `codigo_cliente_afectar` varchar(45) DEFAULT NULL,
  `motivo_nc` varchar(45) DEFAULT NULL,
  `oper_plataforma` varchar(45) DEFAULT NULL,
  `oper_oficina` varchar(45) DEFAULT NULL,
  `oper_clase` varchar(45) DEFAULT NULL,
  `oper_canal` varchar(45) DEFAULT NULL,
  `oper_sector` varchar(45) DEFAULT NULL,
  `oper_tipo` varchar(45) DEFAULT NULL,
  `oper_numero` varchar(45) DEFAULT NULL,
  `fac_clasificacion` varchar(45) DEFAULT NULL,
  `fac_proceso` varchar(45) DEFAULT NULL,
  `fac_numero_folio` varchar(45) DEFAULT NULL,
  `estado_actual` int(11) DEFAULT NULL,
  `area_flujo` int(11) DEFAULT NULL,
  `area_flujo_anterior` int(11) DEFAULT NULL,
  `prioridad_flujo` int(11) DEFAULT NULL,
  `subprioridad_flujo` int(11) DEFAULT '0',
  `usuario_reserva` int(11) DEFAULT NULL,
  `reservada` int(11) DEFAULT NULL,
  `tipo_cliente` int(11) NOT NULL,
  PRIMARY KEY (`id_documento`),
  KEY `fk_documento_IVA1_idx` (`IVA_idIVA`),
  KEY `fk_documento_Moneda1_idx` (`Moneda_idMoneda`),
  KEY `fk_documento_tipo_documento1_idx` (`tipo_documento_idtipo_doc`),
  KEY `fk_documento_solicitudes1_idx` (`solicitudes_idSolicitudes`),
  KEY `fk_documento_tipo_cliente1_idx` (`tipo_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_solicitud`
--

CREATE TABLE IF NOT EXISTS `estado_solicitud` (
  `id_estado_solicitud` int(11) NOT NULL AUTO_INCREMENT,
  `estado_sol` varchar(45) DEFAULT NULL,
  `suspendido` int(11) DEFAULT '0',
  PRIMARY KEY (`id_estado_solicitud`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `estado_solicitud`
--

INSERT INTO `estado_solicitud` (`id_estado_solicitud`, `estado_sol`, `suspendido`) VALUES
(0, 'PENDIENTE', NULL),
(1, 'RECIBIDO', NULL),
(2, 'ANÁLISIS', NULL),
(3, 'LIBERADO', NULL),
(4, 'RECHAZADO', NULL),
(5, 'INCIDENCIA EN SISTEMA', NULL),
(6, 'GESTION TERCEROS', NULL),
(7, 'FINALIZADO', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `flujo_trabajo`
--

CREATE TABLE IF NOT EXISTS `flujo_trabajo` (
  `idflujo` int(11) NOT NULL AUTO_INCREMENT,
  `prioridad` int(11) DEFAULT NULL,
  `sub_prioridad` int(11) DEFAULT NULL,
  `area_id_area` int(11) NOT NULL,
  `tipo_documento_id_tipo_doc` int(11) NOT NULL,
  PRIMARY KEY (`idflujo`),
  KEY `fk_flujo_trabajo_area1_idx` (`area_id_area`),
  KEY `fk_flujo_trabajo_tipo_documento1_idx` (`tipo_documento_id_tipo_doc`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Volcado de datos para la tabla `flujo_trabajo`
--

INSERT INTO `flujo_trabajo` (`idflujo`, `prioridad`, `sub_prioridad`, `area_id_area`, `tipo_documento_id_tipo_doc`) VALUES
(1, 1, 0, 1, 1),
(2, 2, 0, 2, 1),
(3, 3, 0, 5, 1),
(4, 4, 0, 6, 1),
(5, 1, 0, 1, 2),
(6, 2, 0, 2, 2),
(7, 3, 0, 4, 2),
(8, 4, 0, 6, 2),
(9, 1, 0, 1, 3),
(10, 2, 0, 2, 3),
(11, 3, 1, 4, 3),
(12, 3, 2, 5, 3),
(13, 4, 0, 6, 3),
(14, 1, 0, 1, 4),
(15, 2, 0, 2, 4),
(16, 3, 1, 4, 4),
(17, 3, 2, 5, 4),
(18, 4, 0, 6, 4),
(19, 2, 1, 3, 1),
(20, 2, 1, 3, 2),
(21, 2, 1, 3, 3),
(22, 2, 1, 3, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_estados`
--

CREATE TABLE IF NOT EXISTS `historial_estados` (
  `id_historial` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` datetime DEFAULT NULL,
  `estado_solicitud_idestado_solicitud` int(11) NOT NULL,
  `users_id_usuario` int(11) NOT NULL,
  `area_id_area` int(11) NOT NULL,
  `id_documento` int(11) NOT NULL,
  PRIMARY KEY (`id_historial`),
  KEY `fk_historial_estados_estado_solicitud1_idx` (`estado_solicitud_idestado_solicitud`),
  KEY `fk_historial_estados_users1_idx` (`users_id_usuario`),
  KEY `fk_historial_estados_area1_idx` (`area_id_area`),
  KEY `fk_historial_estados_documento1_idx` (`id_documento`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `iva`
--

CREATE TABLE IF NOT EXISTS `iva` (
  `id_iva` int(11) NOT NULL AUTO_INCREMENT,
  `valor_tx` varchar(7) DEFAULT NULL,
  `valor_int` float DEFAULT NULL,
  `suspendido` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_iva`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `iva`
--

INSERT INTO `iva` (`id_iva`, `valor_tx`, `valor_int`, `suspendido`) VALUES
(1, 'EXCENTO', 0, NULL),
(2, '0%', 0, NULL),
(3, '11%', 0.11, NULL),
(4, '16%', 0.16, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `moneda`
--

CREATE TABLE IF NOT EXISTS `moneda` (
  `id_moneda` int(11) NOT NULL AUTO_INCREMENT,
  `moneda` varchar(5) DEFAULT NULL,
  `suspendido` int(11) DEFAULT '0',
  PRIMARY KEY (`id_moneda`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `moneda`
--

INSERT INTO `moneda` (`id_moneda`, `moneda`, `suspendido`) VALUES
(1, 'MXN', NULL),
(2, 'USD', NULL),
(3, 'EUR', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `motivos`
--

CREATE TABLE IF NOT EXISTS `motivos` (
  `id_motivos` int(11) NOT NULL AUTO_INCREMENT,
  `motivos_tx` varchar(150) DEFAULT NULL,
  `suspendido` int(11) DEFAULT '0',
  PRIMARY KEY (`id_motivos`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;

--
-- Volcado de datos para la tabla `motivos`
--

INSERT INTO `motivos` (`id_motivos`, `motivos_tx`, `suspendido`) VALUES
(1, 'DATOS FISCALES', NULL),
(2, 'DIFERENCIA FACTURA VS ACUERDO COMERCIAL', NULL),
(3, 'REGULARIZACION BAJA DISTRIBUIDOR', NULL),
(4, 'DEVOLUCIONES', NULL),
(5, 'INCENTIVOS', NULL),
(6, 'COMISION RECARGA ADICIONAL', NULL),
(7, 'PENALIZACION BAJA ANTICIPADA', NULL),
(8, 'RENTAS ANTICIPADAS O PAGADAS POR ADELANTADO', NULL),
(9, 'TRÁFICO O SERVICIOS CURSADOS Y NO FACTURADOS', NULL),
(10, 'RECARGA ELECTRÓNICA', NULL),
(11, 'DIFERENCIA COSTO EQUIPOS', NULL),
(12, 'ACUERDO COMERCIAL', NULL),
(13, 'DATOS FISCALES', NULL),
(14, 'LEYENDAS ESPECIALES', NULL),
(15, 'ERROR EN FACTURACION', NULL),
(16, 'TASA IMPOSITIVA', NULL),
(17, 'DIFERENCIA DEBIDO A ACUERDO INTERCOMPAÑIA', NULL),
(18, 'DIFERENCIA DEBIDO A ERROR EN FACTURACION', NULL),
(19, 'DIFERENCIA DEBIDO A LEYENDAS ESPECIALES', NULL),
(20, 'DIFERENCIA DEBIDO A ACUERDO COMERCIAL', NULL),
(21, 'DIFERENCIA DEBIDO A DATOS FISCALES O CAMBIO RS', NULL),
(22, 'DIFERENCIA DEBIDO A IMPUESTOS (IVA/IEPS)', NULL),
(23, 'DIFERENCIA DEBIDO A DIFERENCIA EN COSTO EQUIPOS', NULL),
(24, 'RED DE DISTRIBUCIÓN (OPERADOR LOGÍSTICO)', NULL),
(25, 'ACUERDOS INTEROCOMPAÑÍAS', NULL),
(26, 'TRÁFICO CURSADO', NULL),
(27, 'TERMINALES Y SIM''S', NULL),
(28, 'TARJETA RASCA', NULL),
(29, 'FACTURACIÓN EMPLEADOS', NULL),
(30, 'VENTAS OUTLET', NULL),
(31, 'PROYECTO NUEVO', NULL),
(32, 'PENALIZACION', NULL),
(33, 'DONATIVOS', NULL),
(34, 'RENTAS TIENDAS PROPIAS', NULL),
(35, 'ACTIVOS - INACTIVOS (CONSIGNA)', NULL),
(36, 'ACTIVO FIJO', NULL),
(37, 'INTERESES', NULL),
(38, 'SERVICIOS', NULL),
(39, 'RENTAS (VARIOS)', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `observaciones`
--

CREATE TABLE IF NOT EXISTS `observaciones` (
  `id_observaciones` int(11) NOT NULL AUTO_INCREMENT,
  `observacion` varchar(250) DEFAULT NULL,
  `fecha_observacion` datetime DEFAULT NULL,
  `users_id_usuario` int(11) NOT NULL,
  `id_documento` varchar(45) DEFAULT NULL,
  `estado` int(11) DEFAULT '0',
  `solicitudes_id_solicitudes` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_observaciones`),
  KEY `fk_observaciones_users1_idx` (`users_id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE IF NOT EXISTS `permisos` (
  `id_permisos` int(11) NOT NULL AUTO_INCREMENT,
  `permiso` int(11) DEFAULT NULL,
  `id_tipo_documento` int(11) DEFAULT NULL,
  `id_area` int(11) DEFAULT NULL,
  `id_estado_solicitud` int(11) DEFAULT NULL,
  `id_tipo_cliente` int(11) DEFAULT NULL,
  `id_moneda` int(11) DEFAULT NULL,
  `id_iva` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_permisos`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=53 ;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`id_permisos`, `permiso`, `id_tipo_documento`, `id_area`, `id_estado_solicitud`, `id_tipo_cliente`, `id_moneda`, `id_iva`, `id_usuario`) VALUES
(1, 1, 1, 20, NULL, 1, NULL, NULL, NULL),
(2, 1, 2, 20, NULL, 1, NULL, NULL, NULL),
(3, 1, 3, 20, NULL, 1, NULL, NULL, NULL),
(4, 1, 4, 20, NULL, 1, NULL, NULL, NULL),
(5, 1, 1, 20, NULL, 10, NULL, NULL, NULL),
(6, 1, 2, 20, NULL, 10, NULL, NULL, NULL),
(7, 1, 3, 20, NULL, 10, NULL, NULL, NULL),
(8, 1, 4, 20, NULL, 10, NULL, NULL, NULL),
(9, 1, NULL, 1, 0, NULL, NULL, NULL, NULL),
(10, 1, NULL, 1, 1, NULL, NULL, NULL, NULL),
(11, 1, NULL, 1, 2, NULL, NULL, NULL, NULL),
(12, 1, NULL, 1, 3, NULL, NULL, NULL, NULL),
(13, 1, NULL, 1, 4, NULL, NULL, NULL, NULL),
(14, 1, NULL, 1, 5, NULL, NULL, NULL, NULL),
(15, 1, NULL, 1, 6, NULL, NULL, NULL, NULL),
(16, 1, NULL, 2, 0, NULL, NULL, NULL, NULL),
(17, 1, NULL, 2, 1, NULL, NULL, NULL, NULL),
(18, 1, NULL, 2, 2, NULL, NULL, NULL, NULL),
(19, 1, NULL, 2, 3, NULL, NULL, NULL, NULL),
(20, 1, NULL, 2, 4, NULL, NULL, NULL, NULL),
(21, 1, NULL, 2, 5, NULL, NULL, NULL, NULL),
(22, 1, NULL, 2, 6, NULL, NULL, NULL, NULL),
(23, 1, NULL, 3, 0, NULL, NULL, NULL, NULL),
(24, 1, NULL, 3, 1, NULL, NULL, NULL, NULL),
(25, 1, NULL, 3, 2, NULL, NULL, NULL, NULL),
(26, 1, NULL, 3, 3, NULL, NULL, NULL, NULL),
(27, 1, NULL, 3, 4, NULL, NULL, NULL, NULL),
(28, 1, NULL, 3, 5, NULL, NULL, NULL, NULL),
(29, 1, NULL, 3, 6, NULL, NULL, NULL, NULL),
(30, 1, NULL, 5, 0, NULL, NULL, NULL, NULL),
(31, 1, NULL, 5, 1, NULL, NULL, NULL, NULL),
(32, 1, NULL, 5, 2, NULL, NULL, NULL, NULL),
(33, 1, NULL, 5, 3, NULL, NULL, NULL, NULL),
(34, 1, NULL, 5, 4, NULL, NULL, NULL, NULL),
(35, 1, NULL, 5, 5, NULL, NULL, NULL, NULL),
(36, 1, NULL, 5, 6, NULL, NULL, NULL, NULL),
(37, 1, NULL, 6, 0, NULL, NULL, NULL, NULL),
(38, 1, NULL, 6, 1, NULL, NULL, NULL, NULL),
(39, 1, NULL, 6, 2, NULL, NULL, NULL, NULL),
(40, 1, NULL, 6, 7, NULL, NULL, NULL, NULL),
(41, 1, NULL, 6, 4, NULL, NULL, NULL, NULL),
(42, 1, NULL, 6, 5, NULL, NULL, NULL, NULL),
(43, 1, NULL, 6, 6, NULL, NULL, NULL, NULL),
(44, 1, NULL, 4, 1, NULL, NULL, NULL, NULL),
(45, 1, NULL, 4, 2, NULL, NULL, NULL, NULL),
(46, 1, NULL, 4, 3, NULL, NULL, NULL, NULL),
(47, 1, NULL, 4, 4, NULL, NULL, NULL, NULL),
(48, 1, NULL, 4, 5, NULL, NULL, NULL, NULL),
(49, 1, NULL, 4, 6, NULL, NULL, NULL, NULL),
(50, 1, NULL, 4, 0, NULL, NULL, NULL, NULL),
(51, 1, NULL, 3, 3, NULL, NULL, NULL, NULL),
(52, 1, NULL, 3, 4, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes`
--

CREATE TABLE IF NOT EXISTS `solicitudes` (
  `id_solicitudes` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_solicitud` datetime DEFAULT NULL,
  `area_idarea` int(11) NOT NULL,
  `users_id_usuario` int(11) NOT NULL,
  PRIMARY KEY (`id_solicitudes`),
  KEY `fk_solicitudes_area1_idx` (`area_idarea`),
  KEY `fk_solicitudes_users1_idx` (`users_id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_cliente`
--

CREATE TABLE IF NOT EXISTS `tipo_cliente` (
  `id_tipo_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `tx_tipo_cliente` varchar(100) DEFAULT NULL,
  `caracteres` varchar(3) DEFAULT NULL,
  `restriccion` varchar(5) DEFAULT NULL,
  `suspendido` int(11) DEFAULT '0',
  `conexion` int(11) DEFAULT '0',
  PRIMARY KEY (`id_tipo_cliente`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Volcado de datos para la tabla `tipo_cliente`
--

INSERT INTO `tipo_cliente` (`id_tipo_cliente`, `tx_tipo_cliente`, `caracteres`, `restriccion`, `suspendido`, `conexion`) VALUES
(1, 'POSPAGO', '100', NULL, NULL, 1),
(2, 'DATA', '30', NULL, NULL, NULL),
(3, 'INTERCOMPAÑIA', '30', NULL, NULL, NULL),
(4, 'DISTRIBUIDOR', '100', NULL, NULL, 1),
(5, 'PROVEEDOR', '30', NULL, NULL, NULL),
(6, 'FABRICANTE', '30', NULL, NULL, NULL),
(7, 'CARRIER', '30', NULL, NULL, NULL),
(8, 'MVNO', '30', NULL, NULL, 1),
(9, 'MISCELÁNEO', '30', NULL, NULL, NULL),
(10, 'PREPAGO CAC', '100', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_documento`
--

CREATE TABLE IF NOT EXISTS `tipo_documento` (
  `id_tipo_doc` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_doc` varchar(45) DEFAULT NULL,
  `suspendido` int(11) DEFAULT '0',
  PRIMARY KEY (`id_tipo_doc`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `tipo_documento`
--

INSERT INTO `tipo_documento` (`id_tipo_doc`, `tipo_doc`, `suspendido`) VALUES
(1, 'FACTURA', NULL),
(2, 'NOTA DE CREDITO', NULL),
(3, 'REFACTURA CON CAMBIO', NULL),
(4, 'REFACTURA SIN CAMBIO', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) DEFAULT NULL,
  `pass` varchar(45) DEFAULT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `n_paterno` varchar(45) DEFAULT NULL,
  `n_materno` varchar(45) DEFAULT NULL,
  `mail` varchar(45) DEFAULT NULL,
  `dt_registro` date DEFAULT NULL,
  `area_idarea` int(11) NOT NULL,
  `suspendido` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`),
  KEY `fk_users_area_idx` (`area_idarea`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id_usuario`, `username`, `pass`, `nombre`, `n_paterno`, `n_materno`, `mail`, `dt_registro`, `area_idarea`, `suspendido`) VALUES
(1, 'daniel_sol', 'daniel', 'daniel', 'test', 'solicitante', 'test', '0000-00-00', 20, NULL),
(2, 'daniel_op', 'daniel', 'daniel', 'test', 'operador', 'test', '0000-00-00', 1, NULL),
(3, 'daniel_op2', 'daniel', 'daniel2', 'test', 'test', 'test', '0000-00-00', 2, NULL),
(4, 'daniel_op3', 'daniel', 'daniel', 'test', 'test', 'test', '0000-00-00', 5, NULL),
(5, 'daniel_op4', 'daniel', 'dan', 'dan', 'dan', 'test', '0000-00-00', 6, NULL),
(6, 'daniel_op33', 'daniel', 'luis daniel', 'test', 'test', 'test', '0000-00-00', 4, NULL),
(7, 'daniel_temm', 'daniel', 'luis', 'luis', 'luis', 'test', NULL, 3, NULL);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `adjuntos`
--
ALTER TABLE `adjuntos`
  ADD CONSTRAINT `fk_adjuntos_documento1` FOREIGN KEY (`id_documento`) REFERENCES `documento` (`id_documento`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `conceptos_doc`
--
ALTER TABLE `conceptos_doc`
  ADD CONSTRAINT `fk_conceptos_doc_documento1` FOREIGN KEY (`documento_iddocumento`) REFERENCES `documento` (`id_documento`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `documento`
--
ALTER TABLE `documento`
  ADD CONSTRAINT `fk_documento_IVA1` FOREIGN KEY (`IVA_idIVA`) REFERENCES `iva` (`id_iva`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_documento_Moneda1` FOREIGN KEY (`Moneda_idMoneda`) REFERENCES `moneda` (`id_moneda`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_documento_tipo_documento1` FOREIGN KEY (`tipo_documento_idtipo_doc`) REFERENCES `tipo_documento` (`id_tipo_doc`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_documento_solicitudes1` FOREIGN KEY (`solicitudes_idSolicitudes`) REFERENCES `solicitudes` (`id_solicitudes`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_documento_tipo_cliente1` FOREIGN KEY (`tipo_cliente`) REFERENCES `tipo_cliente` (`id_tipo_cliente`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `flujo_trabajo`
--
ALTER TABLE `flujo_trabajo`
  ADD CONSTRAINT `fk_flujo_trabajo_area1` FOREIGN KEY (`area_id_area`) REFERENCES `area` (`id_area`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_flujo_trabajo_tipo_documento1` FOREIGN KEY (`tipo_documento_id_tipo_doc`) REFERENCES `tipo_documento` (`id_tipo_doc`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `historial_estados`
--
ALTER TABLE `historial_estados`
  ADD CONSTRAINT `fk_historial_estados_estado_solicitud1` FOREIGN KEY (`estado_solicitud_idestado_solicitud`) REFERENCES `estado_solicitud` (`id_estado_solicitud`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_historial_estados_users1` FOREIGN KEY (`users_id_usuario`) REFERENCES `users` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_historial_estados_area1` FOREIGN KEY (`area_id_area`) REFERENCES `area` (`id_area`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_historial_estados_documento1` FOREIGN KEY (`id_documento`) REFERENCES `documento` (`id_documento`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `observaciones`
--
ALTER TABLE `observaciones`
  ADD CONSTRAINT `fk_observaciones_users1` FOREIGN KEY (`users_id_usuario`) REFERENCES `users` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD CONSTRAINT `fk_solicitudes_area1` FOREIGN KEY (`area_idarea`) REFERENCES `area` (`id_area`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_solicitudes_users1` FOREIGN KEY (`users_id_usuario`) REFERENCES `users` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_area` FOREIGN KEY (`area_idarea`) REFERENCES `area` (`id_area`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
