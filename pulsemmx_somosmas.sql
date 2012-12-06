-- phpMyAdmin SQL Dump
-- version 3.3.10.2
-- http://www.phpmyadmin.net
--
-- Servidor: 10.33.143.3
-- Tiempo de generación: 13-02-2012 a las 17:26:33
-- Versión del servidor: 5.0.77
-- Versión de PHP: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `pulsemmx_somosmas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `about`
--

CREATE TABLE IF NOT EXISTS `about` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nombre` varchar(255) NOT NULL,
  `src` varchar(255) default '',
  `intro` text,
  `descripcion` text,
  `created` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Volcar la base de datos para la tabla `about`
--

INSERT INTO `about` (`id`, `nombre`, `src`, `intro`, `descripcion`, `created`) VALUES
(1, 'Somos m&aacute;s haciendo paz', 'upload/banner0113274444811.jpg', '<p>Cada vez somos m&aacute;s las personas involucradas en programas que contribuyan a la prevenci&oacute;n de la violencia y la delincuencia!!</p>', '<p><span>Programa p&uacute;blico, para capacitar, formar, crear espacios.&nbsp;</span>Campa&ntilde;a preventiva de accidentes en j&oacute;venes inicia hasta febrero de 2012, consiste en un programa de capacitaci&oacute;n.&nbsp;Programa &nbsp;de prevenci&oacute;n social &nbsp;de la violencia y delincuencia y de fortalecimiento de la cohesi&oacute;n social y comunitaria en grupos de j&oacute;venes que se encuentren en situaci&oacute;n de riesgo. 4 Documentos, videos, blogs, foros, presentaciones, etc.</p>\r\n<p><span><br /></span></p>', '2012-01-24 16:25:29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `achievementimgs`
--

CREATE TABLE IF NOT EXISTS `achievementimgs` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `achievement_id` int(10) unsigned default NULL,
  `src` varchar(255) NOT NULL,
  `portada` tinyint(1) default '0',
  `descripcion` text,
  `orden` int(10) unsigned default '0',
  `created` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `achievementimgs`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `achievements`
--

CREATE TABLE IF NOT EXISTS `achievements` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `category_id` int(10) unsigned NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `layout` enum('Izquierda','Derecha','Centro') default 'Derecha',
  `descripcion` text,
  `activo` tinyint(1) default '1',
  `comment_count` int(11) default '0',
  `achievementimg_count` int(11) default '0',
  `created` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `achievements`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `albumimgs`
--

CREATE TABLE IF NOT EXISTS `albumimgs` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `album_id` int(10) unsigned default NULL,
  `src` varchar(255) NOT NULL,
  `portada` tinyint(1) default '0',
  `descripcion` text,
  `orden` int(10) unsigned default '0',
  `created` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=46 ;

--
-- Volcar la base de datos para la tabla `albumimgs`
--

INSERT INTO `albumimgs` (`id`, `album_id`, `src`, `portada`, `descripcion`, `orden`, `created`) VALUES
(8, 6, 'upload/dsc00417.jpg', 0, NULL, 0, '2012-01-30 13:10:08'),
(9, 6, 'upload/dsc00419.jpg', 0, NULL, 0, '2012-01-30 13:10:08'),
(14, 8, 'upload/dsc00538.jpg', 1, NULL, 0, '2012-01-31 13:56:59'),
(15, 8, 'upload/dsc00535.jpg', 0, NULL, 0, '2012-01-31 13:56:59'),
(10, 6, 'upload/dsc00421.jpg', 0, NULL, 0, '2012-01-30 13:10:08'),
(11, 6, 'upload/dsc00437.jpg', 1, NULL, 0, '2012-01-30 13:10:08'),
(12, 6, 'upload/dsc00442.jpg', 0, NULL, 0, '2012-01-30 13:10:08'),
(16, 8, 'upload/dsc00550.jpg', 0, NULL, 0, '2012-01-31 13:56:59'),
(17, 9, 'upload/img_0932.jpg', 1, NULL, 0, '2012-02-06 15:05:00'),
(18, 9, 'upload/img_0933.jpg', 0, NULL, 0, '2012-02-06 15:05:00'),
(19, 9, 'upload/img_0936.jpg', 0, NULL, 0, '2012-02-06 15:05:00'),
(20, 9, 'upload/img_0937.jpg', 0, NULL, 0, '2012-02-06 15:05:00'),
(21, 9, 'upload/img_0938.jpg', 0, NULL, 0, '2012-02-06 15:05:00'),
(22, 9, 'upload/img_0939.jpg', 0, NULL, 0, '2012-02-06 15:05:00'),
(23, 10, 'upload/img_0960.jpg', 1, NULL, 0, '2012-02-06 15:07:50'),
(24, 10, 'upload/img_0962.jpg', 0, NULL, 0, '2012-02-06 15:07:50'),
(25, 10, 'upload/img_0969.jpg', 0, NULL, 0, '2012-02-06 15:07:50'),
(26, 10, 'upload/img_0973.jpg', 0, NULL, 0, '2012-02-06 15:07:50'),
(27, 10, 'upload/img_0978.jpg', 0, NULL, 0, '2012-02-06 15:07:50'),
(28, 10, 'upload/img_0980.jpg', 0, NULL, 0, '2012-02-06 15:07:50'),
(29, 11, 'upload/img_0993.jpg', 1, NULL, 0, '2012-02-06 15:09:51'),
(30, 11, 'upload/img_0999.jpg', 0, NULL, 0, '2012-02-06 15:09:51'),
(31, 11, 'upload/img_1004.jpg', 0, NULL, 0, '2012-02-06 15:09:51'),
(32, 11, 'upload/img_1007.jpg', 0, NULL, 0, '2012-02-06 15:09:51'),
(33, 11, 'upload/img_1010.jpg', 0, NULL, 0, '2012-02-06 15:09:51'),
(34, 11, 'upload/img_1013.jpg', 0, NULL, 0, '2012-02-06 15:09:51'),
(35, 12, 'upload/24012012084.jpg', 1, NULL, 0, '2012-02-06 15:24:54'),
(36, 12, 'upload/24012012090.jpg', 0, NULL, 0, '2012-02-06 15:24:54'),
(37, 12, 'upload/24012012095.jpg', 0, NULL, 0, '2012-02-06 15:24:54'),
(38, 12, 'upload/24012012092.jpg', 0, NULL, 0, '2012-02-06 15:24:55'),
(39, 12, 'upload/2401201209013285634951.jpg', 0, NULL, 0, '2012-02-06 15:24:55'),
(40, 13, 'upload/dsc00508.jpg', 1, NULL, 0, '2012-02-06 15:27:34'),
(41, 14, 'upload/376154_307573012599202_281359901887180_1027427_1894940594_n.jpg', 1, NULL, 0, '2012-02-06 15:32:16'),
(42, 14, 'upload/376295_307575339265636_281359901887180_1027431_1764796145_n.jpg', 0, NULL, 0, '2012-02-06 15:32:17'),
(43, 14, 'upload/378376_307575222598981_281359901887180_1027430_1429670450_n.jpg', 0, NULL, 0, '2012-02-06 15:32:17'),
(44, 14, 'upload/380542_307575455932291_281359901887180_1027432_1440443349_a.jpg', 0, NULL, 0, '2012-02-06 15:32:17'),
(45, 14, 'upload/388860_307575039265666_281359901887180_1027428_890619735_n.jpg', 0, NULL, 0, '2012-02-06 15:32:17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `albums`
--

CREATE TABLE IF NOT EXISTS `albums` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `category_id` int(10) unsigned NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `tipo` enum('Fotos','Video') default 'Fotos',
  `src` varchar(255) default '',
  `url` varchar(255) default '',
  `descripcion` text NOT NULL,
  `activo` tinyint(1) default '1',
  `comment_count` int(11) default '0',
  `albumimg_count` int(11) default NULL,
  `created` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Volcar la base de datos para la tabla `albums`
--

INSERT INTO `albums` (`id`, `category_id`, `nombre`, `slug`, `tipo`, `src`, `url`, `descripcion`, `activo`, `comment_count`, `albumimg_count`, `created`) VALUES
(8, 32, 'Capacitaci&oacute;n en la primaria Educaci&oacute;n y patria', '8_capacitacion-en-la-primaria-educacion-y-patria', 'Fotos', '', '', '<p>Capacitaci&oacute;n en la primaria Educaci&oacute;n y patria en temas relativos a la prevenci&oacute;n de la violencia escolar</p>', 1, 0, 3, '2012-01-31 13:51:00'),
(9, 31, 'Pl&aacute;ticas en Vergel I', '9_platicas-en-vergel-i', 'Fotos', '', '', '<p>Pl&aacute;ticas impartidas a mujeres en la Colonia Vergel I. &nbsp;Previniendo la violencia intrafamiliar.&nbsp;</p>', 1, 0, 6, '2012-02-06 15:01:00'),
(6, 32, 'Capacitaci&oacute;n en la primaria Nueva vida', '6_capacitacion-en-la-primaria-nueva-vida', 'Fotos', '', '', '<p>Capacitaci&oacute;n en la primaria nueva vida en temas relativos a la prevenci&oacute;n de la violencia escolar</p>', 1, 0, 5, '2012-01-30 11:45:00'),
(10, 31, 'Pl&aacute;ticas en la Col. Nueva Kukulcan', '10_platicas-en-la-col-nueva-kukulcan', 'Fotos', '', '', '<p>Pl&aacute;ticas en prevenci&oacute;n de la violencia intrafamiliar en la Col. Nueva Kukulc&aacute;n</p>', 1, 0, 6, '2012-02-06 15:06:00'),
(11, 31, 'Pl&aacute;ticas en la Sede Acuaparque', '11_platicas-en-la-sede-acuaparque', 'Fotos', '', '', '<p>Pl&aacute;ticas en prevenci&oacute;n de la violencia intrafamiliar en la Sede Acuaparque.&nbsp;</p>', 1, 0, 6, '2012-02-06 15:08:00'),
(12, 9, 'Capacitaci&oacute;n al comit&eacute; de polic&iacute;a vecinal de la Garc&iacute;a Generes y Petronila. ', '12_capacitacion-al-comite-de-policia-vecinal-de-la-garcia-generes-y-petronila', 'Fotos', '', '', '<p><span>Capacitaci&oacute;n al&nbsp;comit&eacute;&nbsp;de&nbsp;polic&iacute;a&nbsp;vecinal de la&nbsp;Garc&iacute;a&nbsp;Generes&nbsp;y Petronila.&nbsp;</span></p>', 1, 0, 5, '2012-02-06 15:18:00'),
(13, 32, 'Capacitaci&oacute;n en la primaria &quot;EDUCREA&quot;', '13_capacitacion-en-la-primaria-educrea', 'Fotos', '', '', '<p>Capacitaci&oacute;n en temas relativos a la prevenci&oacute;n de la violencia escolar en "EDUCREA"</p>', 1, 0, 1, '2012-02-06 15:25:00'),
(14, 9, 'pl&aacute;ticas polic&iacute;a vecinal', '14_platicas-policia-vecinal', 'Fotos', '', '', '<p>Programa "polic&iacute;a vecinal"</p>', 1, 0, 5, '2012-02-06 15:28:00'),
(15, 26, 'Video &quot;somos m&aacute;s haciendo paz&quot;', '15_video-somos-mas-haciendo-paz', 'Video', '', 'http://www.youtube.com/watch?v=kjuwd_m_qBI', '<p>Video "Somos m&aacute;s haciendo paz"</p>', 1, 0, NULL, '2012-02-06 15:52:00'),
(16, 32, 'Spot &quot;Violencia Bullying&quot;', '16_spot-violencia-bullying', 'Fotos', '', 'http://www.youtube.com/watch?v=Nep3YReT0r4', '<p>Cada vez somos m&aacute;s haciendo paz!!</p>', 1, 0, NULL, '2012-02-06 15:56:00'),
(17, 31, 'Spot &quot;Violencia intrafamiliar&quot;', '17_spot-violencia-intrafamiliar', 'Video', '', 'http://www.youtube.com/watch?v=OguXVw-39Eg&amp;feature=related', '<p>Cada vez somos m&aacute;s haciendo paz!!</p>', 1, 0, NULL, '2012-02-06 15:58:00'),
(18, 11, 'prevenci&oacute;n de la delincuencia juvenil', '18_prevencion-de-la-delincuencia-juvenil', 'Video', '', 'http://www.youtube.com/watch?v=0pSbvMnkV0Y&amp;feature=mfu_in_order&amp;list=UL', '<p>Cada vez somos m&aacute;s previniendo la delincuencia juvenil!!</p>', 1, 0, NULL, '2012-02-06 16:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `answers`
--

CREATE TABLE IF NOT EXISTS `answers` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `question_id` int(10) unsigned NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `votos` int(10) unsigned default '0',
  `orden` int(10) unsigned default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=60 ;

--
-- Volcar la base de datos para la tabla `answers`
--

INSERT INTO `answers` (`id`, `question_id`, `nombre`, `votos`, `orden`) VALUES
(1, 1, 'Si', 2, 1),
(2, 1, 'No', 0, 0),
(3, 2, 'Me gusta M&aacute;s', 0, 1),
(4, 2, 'Me gusta menos', 0, 0),
(5, 3, 'Es cuando todos los alumnos conviven en armon&iacute;a.', 2, 2),
(6, 3, 'Es cuando los alumnos tienen bajo rendimiento escolar.', 0, 1),
(7, 3, 'Es un comportamiento agresivo que da&ntilde;a y se da entre compa&ntilde;eros.', 1, 0),
(8, 4, 'La escuela', 3, 2),
(9, 4, 'La casa', 0, 1),
(10, 4, 'La calle', 0, 0),
(11, 5, 'Violencia psicol&oacute;gica', 2, 2),
(12, 5, 'Violencia f&iacute;sica', 1, 1),
(13, 5, 'Violencia verbal', 0, 0),
(14, 6, 'El agredido y sus padres', 2, 2),
(15, 6, 'Los maestros y los padres', 0, 1),
(16, 6, 'Agresor, agredido y los espectadores', 1, 0),
(17, 7, 'Devolver la agresi&oacute;n', 2, 2),
(18, 7, 'Cont&aacute;rselo a un maestro o persona de confianza.', 1, 1),
(19, 7, 'Esconderse por tener miedo', 0, 0),
(20, 8, 'S&iacute;', 1, 0),
(30, 9, 'No', 0, 0),
(22, 8, 'No', 0, 0),
(38, 11, 'No', 0, 0),
(24, 8, 'Tal vez', 0, 0),
(26, 8, 'No me interesa el tema', 0, 0),
(28, 9, 'S&iacute;', 1, 0),
(46, 13, 'No', 0, 0),
(32, 9, 'Tal vez', 0, 0),
(34, 9, 'No me interesa el tema', 0, 0),
(36, 11, 'S&iacute;', 1, 0),
(54, 15, 'No', 0, 0),
(40, 11, 'Tal vez', 0, 0),
(42, 11, 'No me interesa el tema', 0, 0),
(44, 13, 'S&iacute;', 0, 0),
(48, 13, 'Tal vez', 1, 0),
(50, 13, 'No me interesa el tema', 0, 0),
(52, 15, 'S&iacute;', 0, 0),
(56, 15, 'Tal vez', 0, 0),
(58, 15, 'No me interesa el tema', 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `banners`
--

CREATE TABLE IF NOT EXISTS `banners` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nombre` varchar(255) NOT NULL,
  `src` varchar(255) NOT NULL,
  `enlace` varchar(255) default NULL,
  `activo` tinyint(1) default '1',
  `caducidad` date default NULL,
  `orden` int(10) unsigned default '0',
  `created` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Volcar la base de datos para la tabla `banners`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `boards`
--

CREATE TABLE IF NOT EXISTS `boards` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nombre` varchar(255) NOT NULL,
  `enlace` varchar(255) default '',
  `src` varchar(255) default '',
  `descripcion` text,
  `activo` tinyint(1) default '1',
  `created` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Volcar la base de datos para la tabla `boards`
--

INSERT INTO `boards` (`id`, `nombre`, `enlace`, `src`, `descripcion`, `activo`, `created`) VALUES
(1, 'CENTRO DE ARTES VISUALES', 'http://www.culturayucatan.com/index.php?option=com_content&amp;view=category&amp;layout=blog&amp;id=24&amp;Itemid=234', 'upload/cav2.jpg', '<p><span>Se ubica en lo que era la antigua escuela Andr&eacute;s Quintana Roo en el a&ntilde;o 2004 para dar cabida a la 2&ordf; Bienal Nacional de Artes Visuales Yucat&aacute;n, gracias a la generosa donaci&oacute;n de parte de la Secretar&iacute;a de Educaci&oacute;n P&uacute;blica.</span></p>', 1, '2012-01-30 12:50:44'),
(2, 'visite la p&aacute;gina de psicjurid!', 'http://www.psicjurid.com', 'upload/logo_psicjurid.jpg', '<p>P&aacute;gina del instituo interdisciplinario de psicolog&iacute;a jur&iacute;dica.</p>', 1, '2012-01-31 14:07:01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carousels`
--

CREATE TABLE IF NOT EXISTS `carousels` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nombre` varchar(255) NOT NULL,
  `src` varchar(255) NOT NULL,
  `enlace` varchar(255) default NULL,
  `descripcion` text,
  `activo` tinyint(1) default '1',
  `orden` int(10) unsigned default '0',
  `created` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Volcar la base de datos para la tabla `carousels`
--

INSERT INTO `carousels` (`id`, `nombre`, `src`, `enlace`, `descripcion`, `activo`, `orden`, `created`) VALUES
(1, '', 'upload/banner01.jpg', NULL, NULL, 1, 1, '2012-01-24 11:46:25'),
(2, '', 'upload/banner02.jpg', NULL, NULL, 1, 2, '2012-01-24 11:46:25'),
(3, '', 'upload/banner03.jpg', NULL, NULL, 1, 3, '2012-01-24 11:46:25'),
(5, '', 'upload/banner05.jpg', NULL, NULL, 1, 5, '2012-01-24 11:46:25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `parent_id` int(11) default NULL,
  `nombre` varchar(255) NOT NULL,
  `nombre_corto` varchar(255) NOT NULL,
  `src` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `lft` int(10) unsigned default NULL,
  `rght` int(10) unsigned default NULL,
  `orden` int(10) unsigned default '0',
  `created` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=35 ;

--
-- Volcar la base de datos para la tabla `categories`
--

INSERT INTO `categories` (`id`, `parent_id`, `nombre`, `nombre_corto`, `src`, `slug`, `lft`, `rght`, `orden`, `created`) VALUES
(2, NULL, 'Prevenci&oacute;n de la violencia ', '', '', '2_prevencion-de-la-violencia', 1, 10, 1, '2012-01-24 11:57:43'),
(3, NULL, 'Participaci&oacute;n ciudadana', '', '', '3_participacion-ciudadana', 11, 24, 2, '2012-01-24 11:57:43'),
(4, NULL, 'Capacitaci&oacute;n a funcionarios', '', '', '4_capacitacion-a-funcionarios', 25, 30, 3, '2012-01-24 11:57:43'),
(5, NULL, 'J&oacute;venes  y delincuencia', '', '', '5_jovenes--y-delincuencia', 31, 40, 4, '2012-01-24 11:57:43'),
(8, 2, 'Diagn&oacute;stico local ', 'Pro de la paz', '', '8_diagnostico-local', 2, 3, 3, '2012-01-24 12:11:03'),
(9, 3, 'Redes Ciudadanas', 'Red Ciudadana', '', '9_redes-ciudadanas', 12, 13, 5, '2012-01-24 12:12:06'),
(10, 4, 'Prevenci&oacute;n social de la violencia.', 'Capacitaci&oacute;n no violencia', '', '10_prevencion-social-de-la-violencia', 26, 27, 2, '2012-01-24 12:16:21'),
(11, 5, 'Convivencia pac&iacute;fica y no violencia ', 'Capacitaci&oacute;n a Policias', '', '11_convivencia-pacifica-y-no-violencia', 32, 33, 3, '2012-01-24 12:19:09'),
(24, 5, 'Participaci&oacute;n activa de grupos juveniles', '', '', '24_participacion-activa-de-grupos-juveniles', 38, 39, 0, '2012-02-06 12:52:33'),
(23, 5, 'J&oacute;venes que participan en pandillas', '', '', '23_jovenes-que-participan-en-pandillas', 36, 37, 1, '2012-02-06 12:52:33'),
(22, 5, 'prevenci&oacute;n de riesgos de accidentes en j&oacute;venes', '', '', '22_prevencion-de-riesgos-de-accidentes-en-jovenes', 34, 35, 2, '2012-02-06 12:52:33'),
(25, 3, 'Demandas ciudadanas', '', '', '25_demandas-ciudadanas', 14, 15, 4, '2012-02-06 13:11:51'),
(26, 3, 'Valores culturales y c&iacute;vicos', '', '', '26_valores-culturales-y-civicos', 16, 17, 3, '2012-02-06 13:11:51'),
(27, 3, 'Creaci&oacute;n de redes de mujeres en barrios y colonias', '', '', '27_creacion-de-redes-de-mujeres-en-barrios-y-colonias', 18, 19, 2, '2012-02-06 13:11:51'),
(28, 3, 'Consejos de participaci&oacute;n ciudadana municipales', '', '', '28_consejos-de-participacion-ciudadana-municipales', 20, 21, 1, '2012-02-06 13:11:51'),
(29, 3, 'Observatorios ciudadanos', '', '', '29_observatorios-ciudadanos', 22, 23, 0, '2012-02-06 13:11:51'),
(30, 2, 'Plan Municipal de Prevenci&oacute;n Social de la Violencia y la Delincuencia', '', '', '30_plan-municipal-de-prevencion-social-de-la-violencia-y-la-delincuencia', 4, 5, 2, '2012-02-06 13:21:00'),
(31, 2, 'Atenci&oacute;n integral de la violencia intrafamiliar y contra las mujeres', '', '', '31_atencion-integral-de-la-violencia-intrafamiliar-y-contra-las-mujeres', 6, 7, 1, '2012-02-06 13:21:00'),
(32, 2, 'Atenci&oacute;n integral de la violencia escolar', '', '', '32_atencion-integral-de-la-violencia-escolar', 8, 9, 0, '2012-02-06 13:21:00'),
(34, 4, 'Unidades especializadas de la polic&iacute;a ', '', '', '34_unidades-especializadas-de-la-policia', 28, 29, 1, '2012-02-06 13:22:22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clinks`
--

CREATE TABLE IF NOT EXISTS `clinks` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `category_id` int(10) unsigned NOT NULL,
  `linkcategory_id` int(10) unsigned NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `enlace` varchar(255) NOT NULL,
  `src` varchar(255) default '',
  `descripcion` text,
  `activo` tinyint(1) default '1',
  `orden` int(10) unsigned default '0',
  `created` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Volcar la base de datos para la tabla `clinks`
--

INSERT INTO `clinks` (`id`, `category_id`, `linkcategory_id`, `nombre`, `enlace`, `src`, `descripcion`, `activo`, `orden`, `created`) VALUES
(1, 6, 0, 'Cuentos de bullying', 'http://cuentosparadormir.com/infantiles/cuentos-de-bullying', 'upload/images_1.jpg', '<p><span>Lista con todos nuestros cuentos en los que se habla de bullying. Simp&aacute;ticos cuentos cortos para educar en valores. Recursos para padres y maestros</span></p>', 1, 0, '2012-01-26 13:07:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `parent` varchar(255) NOT NULL,
  `parent_id` int(10) unsigned default NULL,
  `autor` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `web` varchar(255) default NULL,
  `descripcion` text NOT NULL,
  `created` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `comments`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doccategories`
--

CREATE TABLE IF NOT EXISTS `doccategories` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `parent_id` int(11) default NULL,
  `nombre` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `lft` int(10) unsigned default NULL,
  `rght` int(10) unsigned default NULL,
  `orden` int(10) unsigned default '0',
  `created` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Volcar la base de datos para la tabla `doccategories`
--

INSERT INTO `doccategories` (`id`, `parent_id`, `nombre`, `slug`, `lft`, `rght`, `orden`, `created`) VALUES
(2, NULL, 'fotos jovenes', '2_fotos-jovenes', 1, 2, 0, '2012-01-31 18:29:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documents`
--

CREATE TABLE IF NOT EXISTS `documents` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `category_id` int(11) default NULL,
  `doccategory_id` int(11) default NULL,
  `nombre` varchar(255) NOT NULL,
  `src` varchar(255) NOT NULL,
  `activo` tinyint(1) default '1',
  `created` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Volcar la base de datos para la tabla `documents`
--

INSERT INTO `documents` (`id`, `category_id`, `doccategory_id`, `nombre`, `src`, `activo`, `created`) VALUES
(4, 29, 2, 'Convocatoria para publicar trabajos en la p&aacute;gina del Observatorio para la Prevenci&oacute;n de la Violencia y Delincuencia en M&eacute;rida, Yucat&aacute;n. ', 'docs/convocatoria_observatorio_1.pdf', 1, '2012-02-06 15:41:00'),
(3, 10, 2, 'ficha de inscripci&oacute;n al Diplomado &ldquo;Intervenci&oacute;n Primaria y Secundaria de la Violencia&rdquo;', 'docs/ficha_de_inscripcion.docx', 1, '2012-01-31 13:42:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventimgs`
--

CREATE TABLE IF NOT EXISTS `eventimgs` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `event_id` int(10) unsigned default NULL,
  `src` varchar(255) NOT NULL,
  `portada` tinyint(1) default '0',
  `descripcion` text,
  `orden` int(10) unsigned default '0',
  `created` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Volcar la base de datos para la tabla `eventimgs`
--

INSERT INTO `eventimgs` (`id`, `event_id`, `src`, `portada`, `descripcion`, `orden`, `created`) VALUES
(1, 2, 'upload/images.jpg', 1, NULL, 0, '2012-01-24 12:34:16'),
(5, 5, 'upload/oprevidem_tw.jpg', 1, NULL, 0, '2012-02-06 15:41:08'),
(3, 3, 'upload/dsc00439.jpg', 1, NULL, 0, '2012-01-30 14:16:55'),
(4, 4, 'upload/psicologiajuridica.jpg', 1, NULL, 0, '2012-01-31 12:34:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `category_id` int(10) unsigned NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `layout` enum('Izquierda','Derecha','Centro') default 'Derecha',
  `descripcion` text,
  `activo` tinyint(1) default '1',
  `created` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Volcar la base de datos para la tabla `events`
--

INSERT INTO `events` (`id`, `category_id`, `nombre`, `slug`, `layout`, `descripcion`, `activo`, `created`) VALUES
(5, 29, 'Convocatoria para publicar trabajos en la p&aacute;gina del Observatorio de M&eacute;rida Yucat&aacute;n', '5_convocatoria-para-publicar-trabajos-en-la-pagina-del-observatorio-de-merida-yucatan', 'Izquierda', '<p><a href="http://www.psicjurid.com/2012/02/06/descargue-la-convocatoria-para-publicar-trabajos-en-el-observatorio-de-la-ciudad-de-merida/"></a></p>\r\n<p><a href="http://www.psicjurid.com/2012/02/06/descargue-la-convocatoria-para-publicar-trabajos-en-el-observatorio-de-la-ciudad-de-merida/"></a></p>\r\n<p><a href="http://www.psicjurid.com/2012/02/06/descargue-la-convocatoria-para-publicar-trabajos-en-el-observatorio-de-la-ciudad-de-merida/"></a></p>\r\n<p><a href="http://www.psicjurid.com/2012/02/06/descargue-la-convocatoria-para-publicar-trabajos-en-el-observatorio-de-la-ciudad-de-merida/"></a></p>\r\n<p><a href="http://www.psicjurid.com/2012/02/06/descargue-la-convocatoria-para-publicar-trabajos-en-el-observatorio-de-la-ciudad-de-merida/"></a></p>\r\n<p><a href="http://www.psicjurid.com/2012/02/06/descargue-la-convocatoria-para-publicar-trabajos-en-el-observatorio-de-la-ciudad-de-merida/"></a></p>\r\n<p><a href="http://www.psicjurid.com/2012/02/06/descargue-la-convocatoria-para-publicar-trabajos-en-el-observatorio-de-la-ciudad-de-merida/"></a></p>\r\n<p><a href="http://www.psicjurid.com/2012/02/06/descargue-la-convocatoria-para-publicar-trabajos-en-el-observatorio-de-la-ciudad-de-merida/"></a></p>\r\n<p>Consulte las bases para publicar trabajos en la p&aacute;gina del Observatorio de la Violencia y delincuencia de la ciudad de M&eacute;rida:</p>\r\n<p><a href="http://www.psicjurid.com/2012/02/06/descargue-la-convocatoria-para-publicar-trabajos-en-el-observatorio-de-la-ciudad-de-merida/">http://www.psicjurid.com/2012/02/06/descargue-la-convocatoria-para-publicar-trabajos-en-el-observatorio-de-la-ciudad-de-merida/</a></p>\r\n<p><a href="http://www.psicjurid.com/2012/02/06/descargue-la-convocatoria-para-publicar-trabajos-en-el-observatorio-de-la-ciudad-de-merida/"></a></p>\r\n<p><a href="http://www.psicjurid.com/2012/02/06/descargue-la-convocatoria-para-publicar-trabajos-en-el-observatorio-de-la-ciudad-de-merida/"></a></p>\r\n<p><a href="http://www.psicjurid.com/2012/02/06/descargue-la-convocatoria-para-publicar-trabajos-en-el-observatorio-de-la-ciudad-de-merida/"></a></p>\r\n<p><a href="http://www.psicjurid.com/2012/02/06/descargue-la-convocatoria-para-publicar-trabajos-en-el-observatorio-de-la-ciudad-de-merida/"></a></p>', 1, '2012-02-06 15:36:00'),
(2, 8, 'Mujeres contra la violencia', '2_mujeres-contra-la-violencia', 'Izquierda', '<div>Promover la participaci&oacute;n y organizaci&oacute;n de las mujeres, a trav&eacute;s de la conformaci&oacute;n de grupos que fomenten la solidaridad, la seguridad ciudadana y la cohesi&oacute;n social, con el objeto de prevenir la violencia.<strong id="internal-source-marker_0.14878441020846367"><br /></strong></div>', 1, '2012-01-27 12:29:00'),
(3, 32, 'Capacitaci&oacute;n a Maestros y ni&ntilde;os en prevenci&oacute;n de la violencia escolar. ', '3_capacitacion-a-maestros-y-ninos-en-prevencion-de-la-violencia-escolar', 'Izquierda', '<p>El Instituto Interdisciplinario de Psicolog&iacute;a Jur&iacute;dica ha estado llevando a cabo, pl&aacute;ticas de prevenci&oacute;n de la violencia escolar, las cuales han sido impartidas a Maestros y alumnos "patrulleros escolares".&nbsp;</p>', 1, '2012-01-30 14:13:00'),
(4, 10, 'Diplomado &ldquo;ESTRATEGIAS DE INTERVENCION PRIMARIA Y SECUNDARIA DE LA VIOLENCIA&rdquo;', '4_diplomado-estrategias-de-intervencion-primaria-y-secundaria-de-la-violencia', 'Izquierda', '<p><strong>Duraci&oacute;n total:</strong> 120 horas.</p>\r\n<p>&nbsp;</p>\r\n<p><strong>Objetivo:</strong> Formar a servidores p&uacute;blicos en materia de Intervenci&oacute;n primaria y secundar&iacute;a de la violencia con la finalidad de sensibilizarlos respecto a las necesidades y problemas de los ciudadanos, que sean capaces de resolver conflictos a trav&eacute;s de un enfoque integral de la violencia y la delincuencia.</p>\r\n<p><strong>&nbsp;</strong></p>\r\n<p><strong>Metodolog&iacute;a: </strong>La capacitaci&oacute;n se llevar&aacute; a cabo a trav&eacute;s de dos estrategias, las cuales dar&aacute;n inicio de manera simult&aacute;nea:</p>\r\n<ol start="1">\r\n<li>Modalidad Presencial: Se abordar&aacute;n los contenidos te&oacute;ricos y/o pr&aacute;cticos para la validaci&oacute;n de desarrollo de los conocimientos y habilidades de los participantes.</li>\r\n<li>Modalidad Virtual: Se abordar&aacute;n contenidos te&oacute;ricos, presentaci&oacute;n de lecturas, videos demostrativos, clases virtuales, as&iacute; como ejercicios de los temas abordados.</li>\r\n</ol>\r\n<p><strong>&nbsp;</strong></p>\r\n<p><strong>Rubros tem&aacute;ticos del diplomado:</strong></p>\r\n<p><strong>&nbsp;</strong></p>\r\n<p>A) Intervenci&oacute;n del Perito en el &aacute;mbito Jur&iacute;dico</p>\r\n<p>B) Criminolog&iacute;a</p>\r\n<p>&bull;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Definici&oacute;n cient&iacute;fica basada en un marco conceptual</p>\r\n<p>&bull;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Teor&iacute;as explicativas</p>\r\n<p>&bull;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Aplicaciones que tiene la criminolog&iacute;a y su relaci&oacute;n con la Psicolog&iacute;a y el Derecho.</p>\r\n<p>C) Psicolog&iacute;a Jur&iacute;dica</p>\r\n<p>&bull;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Definici&oacute;n cient&iacute;fica</p>\r\n<p>&bull;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Ramas o subdivisiones que competen a la Psicolog&iacute;a Jur&iacute;dica y las delimitaciones que tiene cada una</p>\r\n<p>&bull;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Aplicaciones que tiene la Psicolog&iacute;a Jur&iacute;dica</p>\r\n<p>D) Derecho (Enfocado a un nuevo sistema acusatorio)</p>\r\n<p>&bull;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Penal</p>\r\n<p>&bull;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Civil</p>\r\n<p>&bull;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Menores</p>\r\n<p>E)&nbsp; Derechos Humanos</p>\r\n<p>F)&nbsp; Violencia</p>\r\n<p>&bull;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Definici&oacute;n</p>\r\n<p>&bull;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Tipos de Violencia</p>\r\n<p>&bull;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Comportamiento Delictivo</p>\r\n<p>G)&nbsp; Psicopatolog&iacute;a</p>\r\n<p>&bull;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Principales implicaciones psicol&oacute;gicas forenses de los trastornos mentales m&aacute;s comunes</p>\r\n<p>H) Habilidades de Evaluaci&oacute;n</p>\r\n<p>&bull;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; T&eacute;cnicas de Entrevista.</p>\r\n<p>&bull;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Instrumentos de Predicci&oacute;n de Riesgo (Protocolos de&nbsp;&nbsp;&nbsp; Evaluaci&oacute;n).</p>\r\n<p>&bull;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Evaluaci&oacute;n Psicom&eacute;trica</p>\r\n<p>&bull;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Evaluaci&oacute;n Psicofisiol&oacute;gica</p>\r\n<p>&bull;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; An&aacute;lisis del discurso</p>\r\n<p>I)&nbsp; Medios de Prueba</p>\r\n<p>J)&nbsp; Proceso de Evaluaci&oacute;n Psicol&oacute;gica y elaboraci&oacute;n del&nbsp; Informe Pericial.</p>\r\n<p>K) Consideraciones &Eacute;ticas del Psic&oacute;logo en el &aacute;mbito Jur&iacute;dico</p>\r\n<p>L) Juicios Orales</p>\r\n<p>&nbsp;</p>\r\n<p><strong>Poblaci&oacute;n a la que va dirigida:</strong> Psic&oacute;logos.</p>\r\n<p>&nbsp;</p>\r\n<p><strong>Condiciones de participaci&oacute;n:</strong></p>\r\n<ul>\r\n<li>Carta expedida por dependencia que valide la participaci&oacute;n y promoci&oacute;n del participante.</li>\r\n<li>Encontrarse inscrito al Colegio de Psic&oacute;logos del Estado de Yucat&aacute;n A.C.</li>\r\n</ul>\r\n<p>&nbsp;</p>\r\n<p>A continuaci&oacute;n se brinda el detalle de las fechas de impartici&oacute;n.</p>\r\n<p>&nbsp;</p>\r\n<table style="background-color: #ffffff; border-width: 1px; border-color: #ffffff; border-style: solid;" border="1" cellspacing="0" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td colspan="2" valign="top" width="611">\r\n<p align="center">FECHAS (2012)</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td valign="top" width="306">\r\n<p align="center">PRESENCIAL</p>\r\n</td>\r\n<td valign="top" width="306">\r\n<p align="center">VIRTUAL</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td valign="top" width="306">\r\n<p>Viernes 3 de febrero</p>\r\n</td>\r\n<td rowspan="6" valign="top" width="306">\r\n<p>Se realizar&aacute; del viernes 3 de febrero al s&aacute;bado 17 de marzo.</p>\r\n<p>La din&aacute;mica de capacitaci&oacute;n virtual se precisar&aacute; en la sesi&oacute;n 1.</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td valign="top" width="306">\r\n<p>S&aacute;bado 4 de febrero</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td valign="top" width="306">\r\n<p>Viernes 24 de febrero</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td valign="top" width="306">\r\n<p>S&aacute;bado 25 de febrero</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td valign="top" width="306">\r\n<p>Viernes 16 de marzo</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td valign="top" width="306">\r\n<p>S&aacute;bado 17 de marzo</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>', 1, '2012-01-31 12:29:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `linkcategories`
--

CREATE TABLE IF NOT EXISTS `linkcategories` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `parent_id` int(11) default NULL,
  `nombre` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `lft` int(10) unsigned default NULL,
  `rght` int(10) unsigned default NULL,
  `orden` int(10) unsigned default '0',
  `created` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Volcar la base de datos para la tabla `linkcategories`
--

INSERT INTO `linkcategories` (`id`, `parent_id`, `nombre`, `slug`, `lft`, `rght`, `orden`, `created`) VALUES
(2, NULL, 'Fotos', '2_fotos', 1, 2, 0, '2012-01-31 18:31:10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `links`
--

CREATE TABLE IF NOT EXISTS `links` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nombre` varchar(255) NOT NULL,
  `enlace` varchar(255) NOT NULL,
  `src` varchar(255) default '',
  `descripcion` text,
  `activo` tinyint(1) default '1',
  `orden` int(10) unsigned default '0',
  `created` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Volcar la base de datos para la tabla `links`
--

INSERT INTO `links` (`id`, `nombre`, `enlace`, `src`, `descripcion`, `activo`, `orden`, `created`) VALUES
(1, 'Contra el bullying', 'http://contraelbullying.org/', 'upload/descarga_113274416381.jpg', '<p><span>Grupo de profesiona</span></p>', 1, 0, '2012-01-24 15:47:18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `polls`
--

CREATE TABLE IF NOT EXISTS `polls` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `category_id` int(10) unsigned NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `activo` tinyint(1) default '0',
  `question_count` int(10) unsigned default NULL,
  `created` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Volcar la base de datos para la tabla `polls`
--

INSERT INTO `polls` (`id`, `category_id`, `nombre`, `activo`, `question_count`, `created`) VALUES
(4, 10, 'Encuesta de opini&oacute;n', 1, 5, '2012-02-07 13:38:19'),
(3, 32, 'prevenci&oacute;n de la violencia escolar', 1, 5, '2012-01-31 13:00:16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `postimgs`
--

CREATE TABLE IF NOT EXISTS `postimgs` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `post_id` int(10) unsigned default NULL,
  `src` varchar(255) NOT NULL,
  `portada` tinyint(1) default '0',
  `descripcion` text,
  `orden` int(10) unsigned default '0',
  `created` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Volcar la base de datos para la tabla `postimgs`
--

INSERT INTO `postimgs` (`id`, `post_id`, `src`, `portada`, `descripcion`, `orden`, `created`) VALUES
(1, 1, 'upload/twoboys13274310671.jpg', 1, NULL, 0, '2012-01-24 12:51:07');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `category_id` int(10) unsigned NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `layout` enum('Izquierda','Derecha','Centro') default 'Derecha',
  `descripcion` text NOT NULL,
  `activo` tinyint(1) default '1',
  `comment_count` int(11) default '0',
  `postimg_count` int(11) default '0',
  `created` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Volcar la base de datos para la tabla `posts`
--

INSERT INTO `posts` (`id`, `category_id`, `nombre`, `slug`, `layout`, `descripcion`, `activo`, `comment_count`, `postimg_count`, `created`) VALUES
(1, 6, 'Cobra bullying el primer suicidio en Chihuahua', '1_cobra-bullying-el-primer-suicidio-en-chihuahua', 'Izquierda', '<div>Leocadio Pe&ntilde;a del Instituto Mexicano contra el bullying dio a conocer que este tipo de acoso es un problema grave que ya se presenta en la entidad y que a finales de 2011 cobr&oacute; el primer suicidio en la ciudad, el cual fue de un jovencito de secundaria que sufr&iacute;a acoso psicol&oacute;gico por parte de sus compa&ntilde;eros.</div>\r\n<p>Por lo anterior, dio a conocer que las autoridades ya est&aacute;n emprendiendo acciones en contra de esta problem&aacute;tica social pues este lunes dieron inicio talleres contra el bullying que se impartir&aacute;n a docentes de 17 escuelas secundarias de la ciudad, para luego presentar los cursos a los padres de familia y finalmente a los j&oacute;venes.</p>\r\n<p>Aunque reconoci&oacute; que este fen&oacute;meno se presenta sin respetar edad, sexo, posici&oacute;n social o econ&oacute;mica, es m&aacute;s frecuente en la juventud ya que las personas que pasan por esta etapa padecen una amplia necesidad de "aceptaci&oacute;n" y por ello golpea m&aacute;s al autoestima este acoso.</p>\r\n<p>Indic&oacute; que lamentablemente en 7 de cada 10 escuelas se padece bullying en donde al menos 3 de cada 10 ni&ntilde;os son v&iacute;ctimas, 4 de cada 10 son acosadores y 7 de cada 10 son testigos los cuales sufren igual o m&aacute;s que la v&iacute;ctima, ya que sienten la impotencia de no poder ayudar.</p>\r\n<p>En el Distrito Federal tan s&oacute;lo en 2010 la Procuradur&iacute;a General de la Rep&uacute;blica (PGR) registr&oacute; 190 suicidios, de los cuales el Instituto en menci&oacute;n, se&ntilde;al&oacute; que al menos el 50% pudieran haberse propiciado por el padecimiento de bullying, mientras que en el estado al menos 10 son los suicidios ocurridos por esta situaci&oacute;n.</p>\r\n<p>De acuerdo con estudios recientes existen al menos 7 tipos de bullying siendo estos; intimidaciones verbales, intimidaciones psicol&oacute;gicas, agresiones f&iacute;sicas, acoso por medio de las tecnolog&iacute;as de la informaci&oacute;n conocido como "ciberbullying", acoso discriminatorio u homof&oacute;bico, acoso sexual y aislamiento social.</p>\r\n<p>"Es realmente importante para los j&oacute;venes la aceptaci&oacute;n y por ello las burlas, insultos o acusaciones, pueden orillarlos a tomar decisiones extremas, entre ellas quitarse la vida", por lo anterior, indic&oacute; que las pl&aacute;ticas permitir&aacute;n salvar a los j&oacute;venes y ni&ntilde;os que pasan por este problema.</p>\r\n<p>Algunos de los s&iacute;ntomas de quien padece bullying son; mal sue&ntilde;o, insomnio, pesadillas, aparici&oacute;n de enfermedades psicol&oacute;gicas, padecimiento de migra&ntilde;as, bipolaridad, cuadros fuertes de dolores f&iacute;sicos y re&uacute;so por acudir a la escuela o a ciertos lugares.</p>\r\n<p>A las personas que deseen adquirir m&aacute;s informaci&oacute;n acerca de este problema pueden visitar la p&aacute;gina www.altoalbullying.org . Aqu&iacute; encontrar&aacute;n una amplia gama de informaci&oacute;n respecto al tema.</p>', 1, 0, 0, '2012-01-26 12:48:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `questions`
--

CREATE TABLE IF NOT EXISTS `questions` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `poll_id` int(10) unsigned NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `orden` int(10) unsigned default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Volcar la base de datos para la tabla `questions`
--

INSERT INTO `questions` (`id`, `poll_id`, `nombre`, `orden`) VALUES
(8, 4, ' &iquest;A mejor capacitaci&oacute;n a funcionarios de las instituciones p&uacute;blicas; mejores decisiones  para los ciudadanos?', 0),
(3, 3, '&iquest;Qu&eacute; es el bullying?', 4),
(4, 3, 'El bullying ocurre en:', 3),
(5, 3, 'Tipo de violencia que generalmente ejercen los alumnos varones:', 2),
(6, 3, 'En el bullying intervienen:', 1),
(7, 3, '&iquest;Qu&eacute; medidas se deben de tomar en caso de violencia escolar?', 0),
(9, 4, '&iquest;Crees que la capacitaci&oacute;n en prevenci&oacute;n de violencia a los funcionarios de las instituciones p&uacute;blicas es un tema prioritario?', 0),
(11, 4, 'Si estuvieras en una situaci&oacute;n de violencia, &iquest;te gustar&iacute;a recibir ayuda de una persona capacitada en el tema?', 0),
(13, 4, '&iquest;Participar en  talleres y grupos de apoyo dirigidos a la prevenci&oacute;n de la violencia,  ayudar&iacute;a en el combate de la violencia?', 0),
(15, 4, '&iquest;Si los funcionarios p&uacute;blicos est&aacute;n mejor capacitados, podr&aacute;n realizar mejores programas de intervenci&oacute;n para los grupos vulnerables a la violencia intrafamiliar?', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `timelines`
--

CREATE TABLE IF NOT EXISTS `timelines` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `parent` varchar(255) NOT NULL,
  `parent_id` int(10) unsigned default NULL,
  `created` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

--
-- Volcar la base de datos para la tabla `timelines`
--

INSERT INTO `timelines` (`id`, `parent`, `parent_id`, `created`) VALUES
(19, 'Album', 9, '2012-02-06 15:01:00'),
(2, 'Event', 2, '2012-01-27 12:29:00'),
(3, 'Post', 1, '2012-01-26 12:48:00'),
(14, 'Event', 3, '2012-01-30 14:13:00'),
(6, 'Clink', 1, '2012-01-26 13:07:00'),
(27, 'Album', 15, '2012-02-06 15:52:00'),
(15, 'Event', 4, '2012-01-31 12:29:00'),
(12, 'Album', 6, '2012-01-30 11:45:00'),
(26, 'Document', 4, '2012-02-06 15:41:00'),
(17, 'Document', 3, '2012-01-31 13:42:00'),
(18, 'Album', 8, '2012-01-31 13:51:00'),
(20, 'Album', 10, '2012-02-06 15:06:00'),
(21, 'Album', 11, '2012-02-06 15:08:00'),
(22, 'Album', 12, '2012-02-06 15:18:00'),
(23, 'Album', 13, '2012-02-06 15:25:00'),
(24, 'Album', 14, '2012-02-06 15:28:00'),
(25, 'Event', 5, '2012-02-06 15:36:00'),
(28, 'Album', 16, '2012-02-06 15:56:00'),
(29, 'Album', 17, '2012-02-06 15:58:00'),
(30, 'Album', 18, '2012-02-06 16:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nombre` varchar(255) default NULL,
  `apellidos` varchar(255) default NULL,
  `master` tinyint(1) default '0',
  `created` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Volcar la base de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `nombre`, `apellidos`, `master`, `created`) VALUES
(1, 'admin.somo', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'Vero', '', 1, '2010-01-01 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `visitors`
--

CREATE TABLE IF NOT EXISTS `visitors` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `ip` decimal(39,0) unsigned default NULL,
  `item` enum('Question','Poll') default 'Question',
  `item_id` int(10) unsigned default NULL,
  `created` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- Volcar la base de datos para la tabla `visitors`
--

INSERT INTO `visitors` (`id`, `ip`, `item`, `item_id`, `created`) VALUES
(1, '0', 'Question', 1, '2012-01-30 13:43:41'),
(2, '3147175954', 'Question', 1, '2012-01-31 10:10:32'),
(3, '3147509679', 'Question', 3, '2012-01-31 16:31:03'),
(4, '3147509679', 'Question', 4, '2012-01-31 16:31:06'),
(5, '3147509679', 'Question', 5, '2012-01-31 16:31:08'),
(6, '3147509679', 'Question', 6, '2012-01-31 16:31:10'),
(7, '3147509679', 'Question', 7, '2012-01-31 16:31:12'),
(8, '3147509679', 'Poll', 3, '2012-01-31 16:31:12'),
(9, '3180825509', 'Question', 3, '2012-02-01 11:36:16'),
(10, '3180825509', 'Question', 4, '2012-02-01 11:36:19'),
(11, '3180825509', 'Question', 5, '2012-02-01 11:36:21'),
(12, '3180825509', 'Question', 6, '2012-02-01 11:36:23'),
(13, '3180825509', 'Question', 7, '2012-02-01 11:36:24'),
(14, '3180825509', 'Poll', 3, '2012-02-01 11:36:24'),
(15, '3184152079', 'Question', 3, '2012-02-03 17:30:11'),
(16, '3184152079', 'Question', 4, '2012-02-03 17:30:15'),
(17, '3184152079', 'Question', 5, '2012-02-03 17:30:20'),
(18, '3184152079', 'Question', 6, '2012-02-03 17:30:25'),
(19, '3184152079', 'Question', 7, '2012-02-03 17:30:31'),
(20, '3184152079', 'Poll', 3, '2012-02-03 17:30:31'),
(21, '3180824217', 'Question', 8, '2012-02-08 13:34:33'),
(22, '3180824217', 'Question', 9, '2012-02-08 13:34:40'),
(23, '3180824217', 'Question', 11, '2012-02-08 13:35:48'),
(24, '3180824217', 'Question', 13, '2012-02-08 13:35:52');
