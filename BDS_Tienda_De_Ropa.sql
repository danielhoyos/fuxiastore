-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-09-2016 a las 18:05:36
-- Versión del servidor: 10.1.13-MariaDB
-- Versión de PHP: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bds_tienda_de_ropa`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_categoria`
--

CREATE TABLE `tbl_categoria` (
  `CAT_Id` int(11) NOT NULL,
  `CAT_Nombre` varchar(50) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_marca`
--

CREATE TABLE `tbl_marca` (
  `mar_id` int(11) NOT NULL,
  `mar_nombre` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `prov_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_persona`
--

CREATE TABLE `tbl_persona` (
  `PK_PSN_Id` int(11) NOT NULL,
  `PSN_Id_Tipo_Identificacion` int(11) DEFAULT NULL,
  `PSN_Identificacion` varchar(15) NOT NULL,
  `PSN_Nombre` varchar(30) NOT NULL,
  `PSN_Apellido` varchar(30) NOT NULL,
  `PSN_Fecha_Nacimiento` date DEFAULT NULL,
  `PSN_Telefono` varchar(25) NOT NULL,
  `PSN_Rol` enum('administrador','vendedor','cliente') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_producto`
--

CREATE TABLE `tbl_producto` (
  `PRO_Id` int(11) NOT NULL,
  `PRO_Nombre` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `PRO_Talla` enum('XS','S','M','L','XL','XXL','6','8','10','12','14','16','32','33','34','35','36','37','38','39','40') COLLATE latin1_spanish_ci NOT NULL,
  `PRO_Precio_Compra` int(11) NOT NULL,
  `PRO_Precio_Venta` int(11) NOT NULL,
  `FK_CAT_Id` int(11) NOT NULL,
  `FK_SUC_Id` int(11) NOT NULL,
  `PRO_Estado` enum('disponible','vendido','no disponible','separado','devolución') COLLATE latin1_spanish_ci NOT NULL,
  `PRO_Fecha_Ingreso` date NOT NULL,
  `FK_MAR_Id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_proveedor`
--

CREATE TABLE `tbl_proveedor` (
  `prov_id` int(11) NOT NULL,
  `prov_nombre` varchar(50) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_separado`
--

CREATE TABLE `tbl_separado` (
  `SEP_Id` int(11) NOT NULL,
  `FK_PRO_Id` int(11) NOT NULL,
  `SEP_Valor` int(11) NOT NULL,
  `SEP_Fecha` date NOT NULL,
  `SEP_Estado` enum('separado','abonado','retirado') COLLATE latin1_spanish_ci NOT NULL,
  `FK_VEN_Id` int(11) NOT NULL,
  `FK_CLI_Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_sucursal`
--

CREATE TABLE `tbl_sucursal` (
  `SUC_Id` int(11) NOT NULL,
  `SUC_Nit` varchar(20) COLLATE latin1_spanish_ci NOT NULL,
  `SUC_Nombre` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `SUC_Direccion` varchar(50) COLLATE latin1_spanish_ci DEFAULT NULL,
  `SUC_Telefono` varchar(25) COLLATE latin1_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_tipo_identificacion`
--

CREATE TABLE `tbl_tipo_identificacion` (
  `TI_id` int(11) NOT NULL,
  `TI_nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_usuario`
--

CREATE TABLE `tbl_usuario` (
  `USR_Id` int(11) NOT NULL,
  `USR_Usuario` varchar(30) NOT NULL,
  `USR_Password` varchar(50) NOT NULL,
  `USR_Fecha_Modificacion` text NOT NULL,
  `USR_Avatar` varchar(35) NOT NULL,
  `USR_Portada` varchar(50) NOT NULL,
  `USR_Id_Persona` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_venta`
--

CREATE TABLE `tbl_venta` (
  `VEN_Id` int(11) NOT NULL,
  `VEN_CLI_Id` int(11) NOT NULL,
  `VEN_VEND_Id` int(11) NOT NULL,
  `VEN_Fecha_Venta` date NOT NULL,
  `VEN_Total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_venta_producto`
--

CREATE TABLE `tbl_venta_producto` (
  `VEP_id` int(11) NOT NULL,
  `PRO_Id` int(11) NOT NULL,
  `VEN_Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl_categoria`
--
ALTER TABLE `tbl_categoria`
  ADD PRIMARY KEY (`CAT_Id`),
  ADD UNIQUE KEY `CAT_Nombre` (`CAT_Nombre`);

--
-- Indices de la tabla `tbl_marca`
--
ALTER TABLE `tbl_marca`
  ADD PRIMARY KEY (`mar_id`),
  ADD KEY `prov_id` (`prov_id`);

--
-- Indices de la tabla `tbl_persona`
--
ALTER TABLE `tbl_persona`
  ADD PRIMARY KEY (`PK_PSN_Id`),
  ADD UNIQUE KEY `PSN_Identificacion` (`PSN_Identificacion`),
  ADD KEY `PSN_Id_Tipo_Identificacion` (`PSN_Id_Tipo_Identificacion`),
  ADD KEY `PSN_Id_Tipo_Identificacion_2` (`PSN_Id_Tipo_Identificacion`);

--
-- Indices de la tabla `tbl_producto`
--
ALTER TABLE `tbl_producto`
  ADD PRIMARY KEY (`PRO_Id`),
  ADD KEY `CAT_Id` (`FK_CAT_Id`),
  ADD KEY `SUC_Id` (`FK_SUC_Id`),
  ADD KEY `mar_id` (`FK_MAR_Id`);

--
-- Indices de la tabla `tbl_proveedor`
--
ALTER TABLE `tbl_proveedor`
  ADD PRIMARY KEY (`prov_id`);

--
-- Indices de la tabla `tbl_separado`
--
ALTER TABLE `tbl_separado`
  ADD PRIMARY KEY (`SEP_Id`),
  ADD KEY `FK_PRO_Id` (`FK_PRO_Id`),
  ADD KEY `FK_PSN_Id` (`FK_VEN_Id`),
  ADD KEY `FK_CLI_Id` (`FK_CLI_Id`);

--
-- Indices de la tabla `tbl_sucursal`
--
ALTER TABLE `tbl_sucursal`
  ADD PRIMARY KEY (`SUC_Id`),
  ADD UNIQUE KEY `SUC_Nit` (`SUC_Nit`);

--
-- Indices de la tabla `tbl_tipo_identificacion`
--
ALTER TABLE `tbl_tipo_identificacion`
  ADD PRIMARY KEY (`TI_id`);

--
-- Indices de la tabla `tbl_usuario`
--
ALTER TABLE `tbl_usuario`
  ADD PRIMARY KEY (`USR_Id`),
  ADD UNIQUE KEY `USR_Usuario` (`USR_Usuario`),
  ADD KEY `USR_Id_Persona` (`USR_Id_Persona`);

--
-- Indices de la tabla `tbl_venta`
--
ALTER TABLE `tbl_venta`
  ADD PRIMARY KEY (`VEN_Id`),
  ADD KEY `VEN_CLI_Id` (`VEN_CLI_Id`),
  ADD KEY `VEN_CLI_Id_2` (`VEN_CLI_Id`),
  ADD KEY `VEN_VEND_Id` (`VEN_VEND_Id`);

--
-- Indices de la tabla `tbl_venta_producto`
--
ALTER TABLE `tbl_venta_producto`
  ADD PRIMARY KEY (`VEP_id`),
  ADD KEY `PRO_Id` (`PRO_Id`),
  ADD KEY `VEN_Id` (`VEN_Id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbl_categoria`
--
ALTER TABLE `tbl_categoria`
  MODIFY `CAT_Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `tbl_marca`
--
ALTER TABLE `tbl_marca`
  MODIFY `mar_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `tbl_persona`
--
ALTER TABLE `tbl_persona`
  MODIFY `PK_PSN_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de la tabla `tbl_producto`
--
ALTER TABLE `tbl_producto`
  MODIFY `PRO_Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `tbl_proveedor`
--
ALTER TABLE `tbl_proveedor`
  MODIFY `prov_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `tbl_separado`
--
ALTER TABLE `tbl_separado`
  MODIFY `SEP_Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `tbl_sucursal`
--
ALTER TABLE `tbl_sucursal`
  MODIFY `SUC_Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `tbl_tipo_identificacion`
--
ALTER TABLE `tbl_tipo_identificacion`
  MODIFY `TI_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `tbl_usuario`
--
ALTER TABLE `tbl_usuario`
  MODIFY `USR_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `tbl_venta`
--
ALTER TABLE `tbl_venta`
  MODIFY `VEN_Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `tbl_venta_producto`
--
ALTER TABLE `tbl_venta_producto`
  MODIFY `VEP_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tbl_marca`
--
ALTER TABLE `tbl_marca`
  ADD CONSTRAINT `fk_marca_proveedor` FOREIGN KEY (`prov_id`) REFERENCES `tbl_proveedor` (`prov_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tbl_persona`
--
ALTER TABLE `tbl_persona`
  ADD CONSTRAINT `FK_Persona_Tipos_Identificacion` FOREIGN KEY (`PSN_Id_Tipo_Identificacion`) REFERENCES `tbl_tipo_identificacion` (`TI_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tbl_producto`
--
ALTER TABLE `tbl_producto`
  ADD CONSTRAINT `FK_Producto_Categoria` FOREIGN KEY (`FK_CAT_Id`) REFERENCES `tbl_categoria` (`CAT_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Producto_Sucursal` FOREIGN KEY (`FK_SUC_Id`) REFERENCES `tbl_sucursal` (`SUC_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tbl_separado`
--
ALTER TABLE `tbl_separado`
  ADD CONSTRAINT `fk_separado_cliente` FOREIGN KEY (`FK_CLI_Id`) REFERENCES `tbl_persona` (`PK_PSN_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_separado_producto` FOREIGN KEY (`FK_PRO_Id`) REFERENCES `tbl_producto` (`PRO_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_separado_vendedor` FOREIGN KEY (`FK_VEN_Id`) REFERENCES `tbl_persona` (`PK_PSN_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tbl_usuario`
--
ALTER TABLE `tbl_usuario`
  ADD CONSTRAINT `FK_Usuario_Persona` FOREIGN KEY (`USR_Id_Persona`) REFERENCES `tbl_persona` (`PK_PSN_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tbl_venta_producto`
--
ALTER TABLE `tbl_venta_producto`
  ADD CONSTRAINT `fk_venta_producto_producto` FOREIGN KEY (`PRO_Id`) REFERENCES `tbl_producto` (`PRO_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_venta_producto_venta` FOREIGN KEY (`VEN_Id`) REFERENCES `tbl_venta` (`VEN_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
