-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Июл 19 2012 г., 19:39
-- Версия сервера: 5.5.25
-- Версия PHP: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `stroykaprices`
--

-- --------------------------------------------------------

--
-- Структура таблицы `attribute`
--

DROP TABLE IF EXISTS `attribute`;
CREATE TABLE IF NOT EXISTS `attribute` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `group_id` int(11) unsigned NOT NULL,
  `in_brief` tinyint(1) DEFAULT '0',
  `type` tinyint(3) unsigned NOT NULL,
  `grouporder` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `dimension` varchar(50) DEFAULT NULL,
  `brieforder` tinyint(3) unsigned DEFAULT '1',
  `in_filter` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Дамп данных таблицы `attribute`
--

INSERT INTO `attribute` (`id`, `name`, `group_id`, `in_brief`, `type`, `grouporder`, `dimension`, `brieforder`, `in_filter`) VALUES
(1, 'Тип', 46, 1, 1, 1, '', 1, 1),
(4, 'Область применения', 47, 0, 7, 1, '', 1, 0),
(5, 'Расход', 48, 1, 1, 1, 'кг/м2 на см толщины', 1, 0),
(6, 'Толщина штукатурного слоя', 48, 0, 1, 2, 'мм', 1, 0),
(7, 'Жизнеспособность раствора', 48, 0, 1, 3, '', 1, 0),
(8, 'Время полного высыхания', 48, 0, 1, 4, 'суток', 1, 0),
(9, 'Технические характеристики', 48, 0, 7, 5, '', 1, 0),
(10, 'Подготовка основания', 49, 0, 7, 1, '', 1, 0),
(11, 'Применение', 49, 0, 7, 1, '', 1, 0),
(12, 'Упаковка', 50, 0, 7, 1, '', 1, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `attributegroup`
--

DROP TABLE IF EXISTS `attributegroup`;
CREATE TABLE IF NOT EXISTS `attributegroup` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `category_id` int(10) unsigned NOT NULL,
  `name` varchar(100) NOT NULL,
  `position` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ATTRIBUTEGROUPI01` (`parent_id`),
  KEY `position` (`position`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=51 ;

--
-- Дамп данных таблицы `attributegroup`
--

INSERT INTO `attributegroup` (`id`, `parent_id`, `category_id`, `name`, `position`) VALUES
(0, NULL, 0, 'Корень', 0),
(46, 0, 0, 'Общие характеристики', 1),
(47, 0, 0, 'Область применения', 2),
(48, 0, 0, 'Технические характеристики', 3),
(49, 0, 0, 'Порядок работ', 4),
(50, 0, 0, 'Упаковка', 5);

-- --------------------------------------------------------

--
-- Структура таблицы `attrvaluelist`
--

DROP TABLE IF EXISTS `attrvaluelist`;
CREATE TABLE IF NOT EXISTS `attrvaluelist` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `attr_id` int(11) unsigned NOT NULL,
  `value` varchar(500) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `attr_id` (`attr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `authassignment`
--

DROP TABLE IF EXISTS `authassignment`;
CREATE TABLE IF NOT EXISTS `authassignment` (
  `itemname` varchar(64) NOT NULL,
  `userid` int(11) NOT NULL,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`itemname`,`userid`),
  KEY `userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `authassignment`
--

INSERT INTO `authassignment` (`itemname`, `userid`, `bizrule`, `data`) VALUES
('Administrator', 1, '', 's:0:"";'),
('Authorizer', 1, '', 's:0:"";'),
('User', 1, '', 's:0:"";'),
('User', 2, '', 's:0:"";');

-- --------------------------------------------------------

--
-- Структура таблицы `authitem`
--

DROP TABLE IF EXISTS `authitem`;
CREATE TABLE IF NOT EXISTS `authitem` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `authitem`
--

INSERT INTO `authitem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES
('Authorizer', 2, NULL, NULL, NULL),
('Administrator', 2, NULL, NULL, NULL),
('User', 2, NULL, NULL, NULL),
('Product Category Create', 0, '', '', 's:0:"";'),
('Product Category Delete', 0, '', '', 's:0:"";'),
('Product Category Read', 0, '', '', 's:0:"";'),
('Product Category Update', 0, '', '', 's:0:"";'),
('Product Category Management', 1, '', '', 's:0:"";'),
('Product Category Read-only', 1, '', '', 's:0:"";');

-- --------------------------------------------------------

--
-- Структура таблицы `authitemchild`
--

DROP TABLE IF EXISTS `authitemchild`;
CREATE TABLE IF NOT EXISTS `authitemchild` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `authitemchild`
--

INSERT INTO `authitemchild` (`parent`, `child`) VALUES
('Administrator', 'Product Category Management'),
('Product Category Management', 'Product Category Create'),
('Product Category Management', 'Product Category Delete'),
('Product Category Management', 'Product Category Read'),
('Product Category Management', 'Product Category Update'),
('Product Category Read-only', 'Product Category Read'),
('User', 'Product Category Read-only');

-- --------------------------------------------------------

--
-- Структура таблицы `brand`
--

DROP TABLE IF EXISTS `brand`;
CREATE TABLE IF NOT EXISTS `brand` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `brand`
--

INSERT INTO `brand` (`id`, `name`) VALUES
(1, 'Mapei'),
(2, 'Ivsil'),
(3, 'Knauf'),
(4, 'Юнис (UNIS)'),
(5, 'Старатели');

-- --------------------------------------------------------

--
-- Структура таблицы `categoryattribute`
--

DROP TABLE IF EXISTS `categoryattribute`;
CREATE TABLE IF NOT EXISTS `categoryattribute` (
  `category_id` int(11) NOT NULL,
  `attribute_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`category_id`,`attribute_id`),
  KEY `attribute_id` (`attribute_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `categoryattribute`
--

INSERT INTO `categoryattribute` (`category_id`, `attribute_id`) VALUES
(1, 1),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(1, 10),
(1, 11),
(1, 12);

-- --------------------------------------------------------

--
-- Структура таблицы `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `categoryid` int(11) DEFAULT NULL,
  `description` mediumtext NOT NULL,
  `smallpic` varchar(100) DEFAULT NULL,
  `largepic` varchar(100) DEFAULT NULL,
  `manual` varchar(100) DEFAULT NULL COMMENT 'Manual file path',
  `avg_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'Average price',
  `min_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'Minimum price',
  `max_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'Maximal price',
  PRIMARY KEY (`id`),
  KEY `PRODUCTI01` (`categoryid`),
  KEY `brand_id` (`brand_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `product`
--

INSERT INTO `product` (`id`, `name`, `brand_id`, `categoryid`, `description`, `smallpic`, `largepic`, `manual`, `avg_price`, `min_price`, `max_price`) VALUES
(3, 'Nivoplan', 1, 2, '<p><span style="font-family: arial,helvetica,sans-serif; font-size: small;">Nivoplan&nbsp;- серый или белый порошок, состоящий из цемента, фракционированного песка и синтетических смол.</span><br /><span style="font-family: arial,helvetica,sans-serif; font-size: small;">При смешивании&nbsp;Nivoplan&nbsp;с водой получается легко наносимый на вертикальные поверхности раствор.</span><br /><span style="font-family: arial,helvetica,sans-serif; font-size: small;">После схватывания&nbsp;Nivoplan&nbsp;образует плотную штукатурку, устойчивую к влажности и морозу.</span></p>', '/images/products/small/04/WsMjhD6m.jpg', '/images/products/large/04/WsMjhD6m.jpg', 'Infolist_Rotband_Screen57.pdf', '372.50', '367.00', '378.00'),
(4, 'Knauf Унтерпутц', 3, 2, '<span style="color: #000000; font-family: arial,helvetica,sans-serif; font-size: small;">Штукатурка цементная фасадная КНАУФ-Унтерпутц&nbsp;&mdash; идеальная основа под декоративные покрытия фасадов.</span>\r\n<ul style="margin-top: 0px; margin-bottom: 1em; color: #869197; font-family: Arial,sans-serif; font-size: 12px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 14px; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px;">\r\n<li><span style="color: #000000; font-family: arial,helvetica,sans-serif; font-size: small;">Повышает водоудерживающую способность поверхности.</span></li>\r\n<li><span style="color: #000000; font-family: arial,helvetica,sans-serif; font-size: small;">Пластичность и&nbsp;возможность тонкослойного нанесения раствора.</span></li>\r\n<li><span style="color: #000000; font-family: arial,helvetica,sans-serif; font-size: small;">Смесь не&nbsp;дает усадки и&nbsp;не&nbsp;образует трещин при высыхании.</span></li>\r\n</ul>', '/images/products/small/05/6qFoc81b.jpg', '/images/products/large/05/6qFoc81b.jpg', '', '0.00', '0.00', '0.00'),
(5, 'Юнис (UNIS) Алебастр, 5кг', 4, 7, '<span style="color: #000000; font-family: arial,helvetica,sans-serif; font-size: 12px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 15px; orphans: 2; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; background-color: #ffffff; display: inline ! important; float: none;">Предназначен для ремонтных работ внутри помещений: заполнение трещин, раковин в строительных конструкциях. Изготовление лепных и рельефных деталей. Изготовлен из экологически чистого природного сырья.</span>', NULL, '', '', '0.00', '0.00', '0.00');

-- --------------------------------------------------------

--
-- Структура таблицы `productattrvalue`
--

DROP TABLE IF EXISTS `productattrvalue`;
CREATE TABLE IF NOT EXISTS `productattrvalue` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL,
  `attr_id` int(10) unsigned NOT NULL,
  `attrlistvalue_id` int(10) unsigned DEFAULT NULL,
  `value` varchar(16000) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_attr_ui01` (`product_id`,`attr_id`),
  KEY `attrlistvalue_id` (`attrlistvalue_id`),
  KEY `attr_id` (`attr_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

--
-- Дамп данных таблицы `productattrvalue`
--

INSERT INTO `productattrvalue` (`id`, `product_id`, `attr_id`, `attrlistvalue_id`, `value`) VALUES
(11, 3, 1, NULL, 'Цементно-полимерный состав для выравнивания стен и потолков внутри и снаружи помещений'),
(13, 3, 5, NULL, '14'),
(14, 3, 6, NULL, '2-30'),
(15, 3, 7, NULL, '2-3 часа'),
(16, 3, 8, NULL, '14'),
(17, 3, 12, NULL, 'Nivoplan поставляется в многослойных бумажных мешках 25 кг (серый). При хранении в сухом месте сохраняет свои характеристики не менее 12 месяцев.'),
(18, 3, 4, NULL, '<p><span style="font-family: comic sans ms,sans-serif; font-size: medium;"><code class="focusRow subFocusRow "><span style="font-family: arial, helvetica, sans-serif;"><strong>Nivoplan&nbsp;</strong><span>особенно удобен для оштукатуривания и выравнивания внутренних и наружных стен и потолков толщиной от 2 до 30 мм.&nbsp;</span><strong>Nivoplan&nbsp;</strong><span>делает поверхность подходящей для укладки керамической плитки и окраски.</span></span></code></span></p>'),
(19, 3, 9, NULL, '<table border="0" cellspacing="0" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td colspan="2" valign="top">\r\n<div><strong>Технические характеристики материала</strong></div>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td colspan="2" valign="top">\r\n<div><strong>Отличительные свойства материала</strong></div>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td valign="top">\r\n<div><strong>Консистенция</strong></div>\r\n</td>\r\n<td valign="top">\r\n<div>порошок</div>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td valign="top">\r\n<div><strong>Цвет</strong></div>\r\n</td>\r\n<td valign="top">\r\n<div>серый или белый</div>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td valign="top">\r\n<div><strong>Плотность (г/м<sup>3</sup>)</strong></div>\r\n</td>\r\n<td valign="top">\r\n<div>1.4</div>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td valign="top">\r\n<div><strong>pH смеси</strong></div>\r\n</td>\r\n<td valign="top">\r\n<div>около 12</div>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td valign="top">\r\n<div><strong>Содержание твердого остатка(%)</strong></div>\r\n</td>\r\n<td valign="top">\r\n<div>100</div>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td valign="top">\r\n<div><strong>Гарантийный срок и условия хранения</strong></div>\r\n</td>\r\n<td valign="top">\r\n<div>12 месяцев в сухом месте в оригинальной упаковке</div>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td valign="top">\r\n<div><strong>Опасность для здоровья согласно EEC 88/379</strong></div>\r\n</td>\r\n<td valign="top">\r\n<div>отсутствует</div>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td valign="top">\r\n<div><strong>Таможенный код</strong></div>\r\n</td>\r\n<td valign="top">\r\n<div>3824 50 90</div>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td colspan="2" valign="top">\r\n<div><strong>Прикладные данные (при +23&deg;C и относительной влажности 50%)</strong></div>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td valign="top">\r\n<div><strong>Консистенция</strong></div>\r\n</td>\r\n<td valign="top">\r\n<div>Очень вязкая</div>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td valign="top">\r\n<div><strong>Соотношение замеса</strong></div>\r\n</td>\r\n<td valign="top">\r\n<div>22 части воды на 100 частей Nivoplan по весу</div>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td valign="top">\r\n<div><strong>Плотность смеси (г/см<sup>3)</sup></strong></div>\r\n</td>\r\n<td valign="top">\r\n<div>1.83</div>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td valign="top">\r\n<div><strong>Температура применения</strong></div>\r\n</td>\r\n<td valign="top">\r\n<div>от +5&deg;C до +30&deg;C</div>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td valign="top">\r\n<div><strong>Толщина нанесения за один слой</strong></div>\r\n</td>\r\n<td valign="top">\r\n<div>от 2 до 30 мм</div>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td valign="top">\r\n<div><strong>Жизнеспособность</strong></div>\r\n</td>\r\n<td valign="top">\r\n<div>2-3 часа</div>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td valign="top">\r\n<div><strong>Время готовности к укладке</strong></div>\r\n</td>\r\n<td valign="top">\r\n<div>4-5 часов</div>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td valign="top">\r\n<div><strong>Время полного отверждения</strong></div>\r\n</td>\r\n<td valign="top">\r\n<div>через 14 дней минут</div>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td valign="top">\r\n<div><strong>Стойкость к растворителям</strong></div>\r\n</td>\r\n<td valign="top">\r\n<div>отличная</div>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td valign="top">\r\n<div><strong>Устойчивость к маслам</strong></div>\r\n</td>\r\n<td valign="top">\r\n<div>отличная (слабая к растительным маслам)</div>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td valign="top">\r\n<div><strong>Устойчивость к щелочам</strong></div>\r\n</td>\r\n<td valign="top">\r\n<div>отличная</div>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td valign="top">\r\n<div><strong>Температура эксплуатации</strong></div>\r\n</td>\r\n<td valign="top">\r\n<div>от -30&deg;C до +90&deg;C</div>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td valign="top">\r\n<div><strong>Совместимость с клеями</strong></div>\r\n</td>\r\n<td valign="top">\r\n<div>отличная</div>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td valign="top">\r\n<div><strong>Прочность при изгибе</strong></div>\r\n</td>\r\n<td valign="top">\r\n<div>3.5 Н/мм<sup>2</sup></div>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td valign="top">\r\n<div><strong>Прочность на сжатие</strong></div>\r\n</td>\r\n<td valign="top">\r\n<div>6.0 Н/мм<sup>2</sup></div>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(20, 3, 10, NULL, '<span>Основание должно быть прочным и очищенным от пыли, незакрепленной штукатурки, растворителей, масла, жира, старой краски и клея.&nbsp;</span><strong>Nivoplan</strong><span>может наносится на влажные поверхности, но время отверждения в этом случае немного увеличивается. При применении Nivoplan на очень поглощающих поверхностях (кирпич, газобетон) рекомендуется предварительно увлажнять стены, особенно при нанесении тонких (менее 3 мм) слоев&nbsp;</span><strong>Nivoplan</strong><span>. При нанесении&nbsp;</span><strong>Nivoplan&nbsp;</strong><span>на гипсовые и гипсосодержащие поверхности требуется их одно- или двукратная грунтовка составом&nbsp;</span><strong>Primer G</strong>'),
(21, 3, 11, NULL, '<div><strong>Nivoplan&nbsp;</strong>затворяют чистой водой (5-5,5 л на мешок 25 кг), перемешивая, желательно механической мешалкой до получения однородной массы.</div>\r\n<div>25-килограммовый мешок&nbsp;<strong>Nivoplan&nbsp;</strong>должен быть смешан с 5-5,5 литрами воды или 3,5 литрами воды и 2 литрами&nbsp;<strong>Planicrete</strong>. Жизнеспособность раствора после перемешивания &mdash; 2 часа.<br />\r\n<div>Покройте тонким слоем&nbsp;<strong>Nivoplan&nbsp;</strong>всю обрабатываемую поверхность основания для полного смачивания и затем сразу же после этого нанесите слой, необходимый для выравнивания (не более 3 см за один слой). Наносите&nbsp;<strong>Nivoplan&nbsp;</strong>штукатурной машиной или шпателем, в случае толстого слоя для обеспечения хорошего связывания с основанием разровняйте его рейкой под сильным давлением. Наносить раствор при температуре ниже +5&deg;С не рекомендуется.</div>\r\n<div>Время готовности к последующей укладке плитки при толщине слоя 1 см и нормальной температуре, влажности и поглощающей способности основания &mdash; от 4 до 5 часов. При понижении температуры это время увеличивается, при повышении &mdash; сокращается. Если выравниваемая стена находится под воздействием солнца или ветра рекомендуется увлажнить поверхность основания для предотвращения преждевременного схватывания.</div>\r\n&nbsp;</div>'),
(22, 4, 1, NULL, 'Cухая штукатурная смесь на основе цемента, фракционированного песка и специальных добавок.'),
(23, 4, 4, NULL, '<p style="margin-top: 0.5em; margin-bottom: 1em; display: block; color: #869197; font-family: Arial,sans-serif; font-size: 12px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 14px; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px;"><span style="color: #000000;">Применяется при наружных и&nbsp;внутренних работах.</span></p>\r\n<p style="margin-top: 0.5em; margin-bottom: 1em; display: block; color: #869197; font-family: Arial,sans-serif; font-size: 12px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 14px; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px;"><span style="color: #000000;">Может наноситься вручную и&nbsp;с&nbsp;помощью непрерывно работающих высокопроизводительных растворосмесительных насосов, например, G4,&nbsp;G5,&nbsp;Monojet фирмы &laquo;ПФТ&raquo; (PFT).</span></p>\r\n<p style="margin-top: 0.5em; margin-bottom: 1em; display: block; color: #869197; font-family: Arial,sans-serif; font-size: 12px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 14px; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px;"><span style="color: #000000;">Предназначена для высококачественного оштукатуривания фасадов, а также обычных твердых оснований в&nbsp;помещениях с&nbsp;повышенной влажностью (подвалы, прачечные, производственные помещения и&nbsp;т.п.) под последующее нанесение на&nbsp;них декоративных покрытий (декоративных штукатурок КНАУФ-Диамант, краски, облицовочной плитки и&nbsp;т.п.).</span></p>'),
(24, 4, 5, NULL, '17'),
(25, 4, 6, NULL, '10-35'),
(26, 4, 7, NULL, '1,5-2 часа'),
(27, 4, 9, NULL, '<table style="margin-top: 0px; margin-bottom: 1em; font-size: 12px; width: 100%; border-collapse: collapse; color: #869197; font-family: Arial,sans-serif; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 14px; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px;" border="1">\r\n<tbody>\r\n<tr>\r\n<td style="font-size: 1em; vertical-align: top; text-align: left; padding: 8px; border-top: 1px solid #efefef; border-color: #efefef; background-color: white;"><strong>Показатели</strong></td>\r\n<td style="font-size: 1em; vertical-align: top; text-align: left; padding: 8px; border-top: 1px solid #efefef; border-color: #efefef; background-color: white;"><strong>Значения</strong></td>\r\n</tr>\r\n<tr>\r\n<td style="font-size: 1em; vertical-align: top; text-align: left; padding: 8px; border-top: 1px solid #efefef; border-color: #efefef; background-color: white;">Толщина штукатурки</td>\r\n<td style="font-size: 1em; vertical-align: top; text-align: left; padding: 8px; border-top: 1px solid #efefef; border-color: #efefef; background-color: white;">10-35 мм</td>\r\n</tr>\r\n<tr>\r\n<td style="font-size: 1em; vertical-align: top; text-align: left; padding: 8px; border-top: 1px solid #efefef; border-color: #efefef; background-color: white;">\r\n<ul style="margin-top: 0px; margin-bottom: 1em;">\r\n<li>максимальная (одного слоя)</li>\r\n</ul>\r\n</td>\r\n<td style="font-size: 1em; vertical-align: top; text-align: left; padding: 8px; border-top: 1px solid #efefef; border-color: #efefef; background-color: white;">20 мм</td>\r\n</tr>\r\n<tr>\r\n<td style="font-size: 1em; vertical-align: top; text-align: left; padding: 8px; border-top: 1px solid #efefef; border-color: #efefef; background-color: white;">\r\n<ul style="margin-top: 0px; margin-bottom: 1em;">\r\n<li>минимальная</li>\r\n</ul>\r\n</td>\r\n<td style="font-size: 1em; vertical-align: top; text-align: left; padding: 8px; border-top: 1px solid #efefef; border-color: #efefef; background-color: white;">10 мм</td>\r\n</tr>\r\n<tr>\r\n<td style="font-size: 1em; vertical-align: top; text-align: left; padding: 8px; border-top: 1px solid #efefef; border-color: #efefef; background-color: white;">Зернистость</td>\r\n<td style="font-size: 1em; vertical-align: top; text-align: left; padding: 8px; border-top: 1px solid #efefef; border-color: #efefef; background-color: white;">до 1,25 мм</td>\r\n</tr>\r\n<tr>\r\n<td style="font-size: 1em; vertical-align: top; text-align: left; padding: 8px; border-top: 1px solid #efefef; border-color: #efefef; background-color: white;">Водоудерживающая способность</td>\r\n<td style="font-size: 1em; vertical-align: top; text-align: left; padding: 8px; border-top: 1px solid #efefef; border-color: #efefef; background-color: white;">не менее 98 %</td>\r\n</tr>\r\n<tr>\r\n<td style="font-size: 1em; vertical-align: top; text-align: left; padding: 8px; border-top: 1px solid #efefef; border-color: #efefef; background-color: white;">Жизнеспособность раствора</td>\r\n<td style="font-size: 1em; vertical-align: top; text-align: left; padding: 8px; border-top: 1px solid #efefef; border-color: #efefef; background-color: white;">1,5-2,0 часа</td>\r\n</tr>\r\n<tr>\r\n<td style="font-size: 1em; vertical-align: top; text-align: left; padding: 8px; border-top: 1px solid #efefef; border-color: #efefef; background-color: white;">Прочность на сжатие</td>\r\n<td style="font-size: 1em; vertical-align: top; text-align: left; padding: 8px; border-top: 1px solid #efefef; border-color: #efefef; background-color: white;">?2,5 МПа</td>\r\n</tr>\r\n<tr>\r\n<td style="font-size: 1em; vertical-align: top; text-align: left; padding: 8px; border-top: 1px solid #efefef; border-color: #efefef; background-color: white;">Адгезия</td>\r\n<td style="font-size: 1em; vertical-align: top; text-align: left; padding: 8px; border-top: 1px solid #efefef; border-color: #efefef; background-color: white;">?0,4 МПа</td>\r\n</tr>\r\n<tr>\r\n<td style="font-size: 1em; vertical-align: top; text-align: left; padding: 8px; border-top: 1px solid #efefef; border-color: #efefef; background-color: white;">Коэффициент паропроницаемости</td>\r\n<td style="font-size: 1em; vertical-align: top; text-align: left; padding: 8px; border-top: 1px solid #efefef; border-color: #efefef; background-color: white;">? 0,1 мг/(м час Па)</td>\r\n</tr>\r\n<tr>\r\n<td style="font-size: 1em; vertical-align: top; text-align: left; padding: 8px; border-top: 1px solid #efefef; border-color: #efefef; background-color: white;">Морозостойкость</td>\r\n<td style="font-size: 1em; vertical-align: top; text-align: left; padding: 8px; border-top: 1px solid #efefef; border-color: #efefef; background-color: white;">?25 циклов</td>\r\n</tr>\r\n<tr>\r\n<td style="font-size: 1em; vertical-align: top; text-align: left; padding: 8px; border-top: 1px solid #efefef; border-color: #efefef; background-color: white;">Фасовка</td>\r\n<td style="font-size: 1em; vertical-align: top; text-align: left; padding: 8px; border-top: 1px solid #efefef; border-color: #efefef; background-color: white;">Бумажный мешок, 25 кг</td>\r\n</tr>\r\n<tr>\r\n<td style="font-size: 1em; vertical-align: top; text-align: left; padding: 8px; border-top: 1px solid #efefef; border-color: #efefef; background-color: white;">Упаковка</td>\r\n<td style="font-size: 1em; vertical-align: top; text-align: left; padding: 8px; border-top: 1px solid #efefef; border-color: #efefef; background-color: white;">Поддон, 30 мешков Контейнеры-силосы Мягкие полимерконтейнеры &laquo;Биг-Бэг&raquo;</td>\r\n</tr>\r\n<tr>\r\n<td style="font-size: 1em; vertical-align: top; text-align: left; padding: 8px; border-top: 1px solid #efefef; border-color: #efefef; background-color: white;">Срок хранения</td>\r\n<td style="font-size: 1em; vertical-align: top; text-align: left; padding: 8px; border-top: 1px solid #efefef; border-color: #efefef; background-color: white;">12 мес. в неповрежденной упаковке</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(28, 4, 11, NULL, '<p style="margin-top: 0.5em; margin-bottom: 1em; display: block; color: #869197; font-family: Arial,sans-serif; font-size: 12px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 14px; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px;"><span style="color: #000000; font-family: arial,helvetica,sans-serif;"><strong><em>Процесс применения</em></strong><span class="Apple-converted-space">&nbsp;</span>включает следующие этапы работ:</span></p>\r\n<ul style="margin-top: 0px; margin-bottom: 1em; color: #869197; font-family: Arial,sans-serif; font-size: 12px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 14px; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px;">\r\n<li><span style="color: #000000; font-family: arial,helvetica,sans-serif;">Подготовку поверхности основания.</span></li>\r\n<li><span style="color: #000000; font-family: arial,helvetica,sans-serif;">Приготовление раствора.</span></li>\r\n<li><span style="color: #000000; font-family: arial,helvetica,sans-serif;">Нанесение раствора. Расход сухой смеси КНАУФ-Унтерпутц для оштукатуривания 1&nbsp;кв.м поверхности толщиной 10&nbsp;мм&nbsp;(без учета потерь) около 17&nbsp;кг/м<sup>2</sup>.</span></li>\r\n<li><span style="color: #000000; font-family: arial,helvetica,sans-serif;">Армирование.</span></li>\r\n</ul>'),
(29, 4, 12, NULL, '<span style="color: #000000; font-family: Arial,sans-serif; font-size: 12px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 14px; orphans: 2; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; background-color: #ffffff; display: inline ! important; float: none;">Бумажный мешок, 25 кг</span>');

-- --------------------------------------------------------

--
-- Структура таблицы `productbysupplier`
--

DROP TABLE IF EXISTS `productbysupplier`;
CREATE TABLE IF NOT EXISTS `productbysupplier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `supplierid` int(11) NOT NULL COMMENT 'CONSTRAINT FOREIGN KEY (supplierid) REFERENCES Supplier(id)',
  `productid` int(11) unsigned NOT NULL COMMENT 'CONSTRAINT FOREIGN KEY (productid) REFERENCES Product(id)',
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `PRODUCTBYSUPPLIERUI01` (`supplierid`,`productid`),
  KEY `PRODUCTBYSUPPLIERI02` (`productid`),
  KEY `PRODUCTBYSUPPLIERI01` (`supplierid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `productbysupplier`
--

INSERT INTO `productbysupplier` (`id`, `supplierid`, `productid`, `price`) VALUES
(1, 4, 3, '367.00'),
(2, 5, 3, '378.00');

-- --------------------------------------------------------

--
-- Структура таблицы `productcategory`
--

DROP TABLE IF EXISTS `productcategory`;
CREATE TABLE IF NOT EXISTS `productcategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parentid` int(11) DEFAULT NULL,
  `lft` int(11) unsigned DEFAULT NULL,
  `rgt` int(11) unsigned DEFAULT NULL,
  `depth` smallint(5) unsigned DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `inherit_attrs_from_parent` tinyint(3) unsigned DEFAULT '0' COMMENT 'Defines whether category inherits attributes from parent category or not',
  PRIMARY KEY (`id`),
  KEY `PRODUCTCATEGORIESI01` (`parentid`),
  KEY `lft` (`lft`,`rgt`),
  KEY `depth` (`depth`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Дамп данных таблицы `productcategory`
--

INSERT INTO `productcategory` (`id`, `parentid`, `lft`, `rgt`, `depth`, `name`, `inherit_attrs_from_parent`) VALUES
(0, NULL, 1, 28, 1, 'Корень', 0),
(1, 0, 3, 8, 3, 'Штукатурки', 0),
(2, 0, 4, 5, 4, 'Цементные штукатурки', 1),
(5, 0, 6, 7, 4, 'Гипсовые штукатурки', 1),
(6, 0, 2, 15, 2, 'Сухие смеси', 0),
(7, 0, 9, 10, 3, 'Алебастр', 0),
(8, 0, 11, 12, 3, 'Затирки', 0),
(9, 0, 13, 14, 3, 'Шпатлевка', 0),
(10, 0, 16, 21, 2, 'Утеплители, пароизоляция', 0),
(11, 0, 17, 18, 3, 'Утеплители', 0),
(12, 0, 19, 20, 3, 'Звукоизоляция', 0),
(13, 0, 22, 27, 2, 'Металлопрокат, металлическая сетка', 0),
(14, 0, 23, 24, 3, 'Арматура', 0),
(15, 0, 25, 26, 3, 'Металлическая сетка', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `productfeedback`
--

DROP TABLE IF EXISTS `productfeedback`;
CREATE TABLE IF NOT EXISTS `productfeedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `productid` int(11) unsigned NOT NULL,
  `dateadded` date NOT NULL,
  `rating` smallint(6) NOT NULL,
  `feedback` varchar(4000) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `PRODUCTFEEDBACKI01` (`productid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `productrating`
--

DROP TABLE IF EXISTS `productrating`;
CREATE TABLE IF NOT EXISTS `productrating` (
  `productid` int(11) unsigned NOT NULL,
  `averating` decimal(10,2) NOT NULL,
  `ratecounter` int(11) NOT NULL,
  PRIMARY KEY (`productid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `product_alsoviewed`
--

DROP TABLE IF EXISTS `product_alsoviewed`;
CREATE TABLE IF NOT EXISTS `product_alsoviewed` (
  `id_current` int(10) unsigned NOT NULL,
  `id_possible` int(10) unsigned NOT NULL,
  `probability` decimal(10,2) NOT NULL DEFAULT '0.00',
  KEY `id_current` (`id_current`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Will contain matrix of probabilities build "also viewed products" list';

-- --------------------------------------------------------

--
-- Структура таблицы `product_views`
--

DROP TABLE IF EXISTS `product_views`;
CREATE TABLE IF NOT EXISTS `product_views` (
  `product_id` int(10) unsigned NOT NULL COMMENT 'Product id',
  `views` int(10) unsigned NOT NULL COMMENT 'Views count',
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `product_views`
--

INSERT INTO `product_views` (`product_id`, `views`) VALUES
(3, 0),
(4, 0),
(5, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `profiles`
--

DROP TABLE IF EXISTS `profiles`;
CREATE TABLE IF NOT EXISTS `profiles` (
  `user_id` int(11) NOT NULL,
  `lastname` varchar(50) NOT NULL DEFAULT '',
  `firstname` varchar(50) NOT NULL DEFAULT '',
  `birthday` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `profiles`
--

INSERT INTO `profiles` (`user_id`, `lastname`, `firstname`, `birthday`) VALUES
(1, 'Nepotachev', 'Georgy', '1985-04-18'),
(2, 'Demo', 'Demo', '0000-00-00');

-- --------------------------------------------------------

--
-- Структура таблицы `profiles_fields`
--

DROP TABLE IF EXISTS `profiles_fields`;
CREATE TABLE IF NOT EXISTS `profiles_fields` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `varname` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `field_type` varchar(50) NOT NULL,
  `field_size` int(3) NOT NULL DEFAULT '0',
  `field_size_min` int(3) NOT NULL DEFAULT '0',
  `required` int(1) NOT NULL DEFAULT '0',
  `match` varchar(255) NOT NULL DEFAULT '',
  `range` varchar(255) NOT NULL DEFAULT '',
  `error_message` varchar(255) NOT NULL DEFAULT '',
  `other_validator` varchar(5000) NOT NULL DEFAULT '',
  `default` varchar(255) NOT NULL DEFAULT '',
  `widget` varchar(255) NOT NULL DEFAULT '',
  `widgetparams` varchar(5000) NOT NULL DEFAULT '',
  `position` int(3) NOT NULL DEFAULT '0',
  `visible` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `varname` (`varname`,`widget`,`visible`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `profiles_fields`
--

INSERT INTO `profiles_fields` (`id`, `varname`, `title`, `field_type`, `field_size`, `field_size_min`, `required`, `match`, `range`, `error_message`, `other_validator`, `default`, `widget`, `widgetparams`, `position`, `visible`) VALUES
(1, 'lastname', 'Last Name', 'VARCHAR', 50, 3, 1, '', '', 'Incorrect Last Name (length between 3 and 50 characters).', '', '', '', '', 1, 3),
(2, 'firstname', 'First Name', 'VARCHAR', 50, 3, 1, '', '', 'Incorrect First Name (length between 3 and 50 characters).', '', '', '', '', 0, 3),
(3, 'birthday', 'Birthday', 'DATE', 0, 0, 2, '', '', '', '', '0000-00-00', 'UWjuidate', '{"ui-theme":"redmond"}', 3, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` char(32) NOT NULL,
  `expire` int(11) NOT NULL,
  `data` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Will store session details as defined by Yii CDBHttpSession';

--
-- Дамп данных таблицы `sessions`
--

INSERT INTO `sessions` (`id`, `expire`, `data`) VALUES
('u6cnrequ7i5riok05gbqo97522', 1342713284, '');

-- --------------------------------------------------------

--
-- Структура таблицы `supplier`
--

DROP TABLE IF EXISTS `supplier`;
CREATE TABLE IF NOT EXISTS `supplier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `address` varchar(200) NOT NULL,
  `url` varchar(100) NOT NULL,
  `description` varchar(16000) NOT NULL,
  `dateadded` date NOT NULL,
  `juridicname` varchar(200) NOT NULL,
  `ogrn` int(11) NOT NULL,
  `juridicaddress` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `supplier`
--

INSERT INTO `supplier` (`id`, `name`, `address`, `url`, `description`, `dateadded`, `juridicname`, `ogrn`, `juridicaddress`) VALUES
(2, 'StroyBrat', 'N/A', 'http://www.stroybrat.ru', 'Магазин Stroy Brat', '2012-03-31', '', 0, 0),
(4, 'Epool', '111524, Москва, ул. Электродная,11', 'http://www.epool.ru', 'Epool.ru - Бассейны и оборудование', '2012-06-16', 'ООО «ВВТ»', 0, 111524),
(5, 'Маркет Красок', '117218, г. Москва, Нахимовский проспект, дом 24, ТВК "Экспострой"', 'http://www.market-krasok.ru', 'Маркет Красок', '2012-06-16', '', 0, 117218);

-- --------------------------------------------------------

--
-- Структура таблицы `supplierfeedback`
--

DROP TABLE IF EXISTS `supplierfeedback`;
CREATE TABLE IF NOT EXISTS `supplierfeedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `supplierid` int(11) NOT NULL,
  `dateadded` date NOT NULL,
  `rating` smallint(6) NOT NULL,
  `feedback` varchar(4000) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `SUPPLIERFEEDBACKI01` (`supplierid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `supplierrating`
--

DROP TABLE IF EXISTS `supplierrating`;
CREATE TABLE IF NOT EXISTS `supplierrating` (
  `supplierid` int(11) NOT NULL,
  `averating` decimal(10,2) NOT NULL,
  `ratecounter` int(11) NOT NULL,
  PRIMARY KEY (`supplierid`),
  UNIQUE KEY `supplierid` (`supplierid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_lily_account`
--

DROP TABLE IF EXISTS `tbl_lily_account`;
CREATE TABLE IF NOT EXISTS `tbl_lily_account` (
  `aid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `service` varchar(255) NOT NULL,
  `id` varchar(255) NOT NULL,
  `hidden` tinyint(1) DEFAULT NULL,
  `data` blob,
  `created` int(11) DEFAULT NULL,
  PRIMARY KEY (`aid`),
  UNIQUE KEY `service_id` (`service`,`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `tbl_lily_account`
--

INSERT INTO `tbl_lily_account` (`aid`, `uid`, `service`, `id`, `hidden`, `data`, `created`) VALUES
(1, 1, 'onetime', '1', 0, 0x4e3b, 1342422486),
(2, 1, 'vkontakte', '13437480', 0, 0x4f3a383a22737464436c617373223a333a7b733a323a226964223b693a31333433373438303b733a343a226e616d65223b733a33333a22d093d0b5d0bed180d0b3d0b8d0b920d09dd0b5d0bfd0bed182d0b0d187d0b5d0b2223b733a333a2275726c223b733a33303a22687474703a2f2f766b6f6e74616b74652e72752f69643133343337343830223b7d, 1342422487),
(3, 2, 'onetime', '2', 0, 0x4e3b, 1342424566),
(4, 2, 'google_oauth', '116516908996477708118', 0, 0x4f3a383a22737464436c617373223a333a7b733a323a226964223b733a32313a22313136353136393038393936343737373038313138223b733a343a226e616d65223b733a31373a2247656f726765204e65706f746163686576223b733a333a2275726c223b733a34353a2268747470733a2f2f706c75732e676f6f676c652e636f6d2f313136353136393038393936343737373038313138223b7d, 1342424566);

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_lily_email_account_activation`
--

DROP TABLE IF EXISTS `tbl_lily_email_account_activation`;
CREATE TABLE IF NOT EXISTS `tbl_lily_email_account_activation` (
  `code_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `created` int(11) DEFAULT NULL,
  PRIMARY KEY (`code_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_lily_onetime`
--

DROP TABLE IF EXISTS `tbl_lily_onetime`;
CREATE TABLE IF NOT EXISTS `tbl_lily_onetime` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `token` varchar(255) NOT NULL,
  `created` int(11) DEFAULT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_lily_session`
--

DROP TABLE IF EXISTS `tbl_lily_session`;
CREATE TABLE IF NOT EXISTS `tbl_lily_session` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `aid` int(11) DEFAULT NULL,
  `data` blob,
  `ssid` varchar(255) NOT NULL,
  `created` int(11) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_lily_user`
--

DROP TABLE IF EXISTS `tbl_lily_user`;
CREATE TABLE IF NOT EXISTS `tbl_lily_user` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `deleted` int(11) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `inited` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `tbl_lily_user`
--

INSERT INTO `tbl_lily_user` (`uid`, `deleted`, `active`, `inited`) VALUES
(1, 0, 1, 0),
(2, 0, 1, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_migration`
--

DROP TABLE IF EXISTS `tbl_migration`;
CREATE TABLE IF NOT EXISTS `tbl_migration` (
  `version` varchar(255) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tbl_migration`
--

INSERT INTO `tbl_migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1329929078),
('m120131_112629_lily_tables_create', 1329929087);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(128) NOT NULL,
  `salt` varchar(128) DEFAULT NULL,
  `email` varchar(128) NOT NULL,
  `activkey` varchar(128) NOT NULL DEFAULT '',
  `createtime` int(10) NOT NULL DEFAULT '0',
  `lastvisit` int(10) NOT NULL DEFAULT '0',
  `superuser` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `service` varchar(50) DEFAULT NULL,
  `identity` varchar(100) DEFAULT NULL,
  `profile_name` varchar(255) DEFAULT NULL,
  `email_entered` int(1) DEFAULT '0' COMMENT 'Flags whether email was entered or generated',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `status` (`status`),
  KEY `superuser` (`superuser`),
  KEY `identity` (`identity`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=36 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `salt`, `email`, `activkey`, `createtime`, `lastvisit`, `superuser`, `status`, `service`, `identity`, `profile_name`, `email_entered`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', NULL, 'xloading@mail.ru', '9a24eff8c15a6a141ece27eb6947da0f', 1261146094, 1346587966, 1, 1, NULL, NULL, NULL, 0),
(2, 'demo', 'fe01ce2a7fbac8fafaed7c982a04e229', NULL, 'demo@example.com', '099f825543f7850cc038b90aaff39fac', 1261146096, 1321171929, 0, 1, NULL, NULL, NULL, 0),
(34, 'xloading', '7b7be30c7b536341ceb397fab025df0a', '504357f4aeab28.33487117', 'g.nepotachev@gmail.com', '7e6d6a5d33464704d722bd83e0efee11', 1346590708, 1346604985, 0, 1, NULL, NULL, NULL, 0),
(35, '92f3d30e@null.io', 'd5154367b3a8a71b8f17c8280b7daad0', '504f85b9a3c9f2.08369031', '92f3d30e@null.io', '', 0, 0, 0, 1, NULL, '13437480', NULL, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `user_connections`
--

DROP TABLE IF EXISTS `user_connections`;
CREATE TABLE IF NOT EXISTS `user_connections` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `service_user_id` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Connections for userConnections module' AUTO_INCREMENT=1 ;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `attribute`
--
ALTER TABLE `attribute`
  ADD CONSTRAINT `attribute_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `attributegroup` (`id`);

--
-- Ограничения внешнего ключа таблицы `attributegroup`
--
ALTER TABLE `attributegroup`
  ADD CONSTRAINT `attributegroup_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `attributegroup` (`id`);

--
-- Ограничения внешнего ключа таблицы `attrvaluelist`
--
ALTER TABLE `attrvaluelist`
  ADD CONSTRAINT `attrvaluelist_ibfk_1` FOREIGN KEY (`attr_id`) REFERENCES `attribute` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `categoryattribute`
--
ALTER TABLE `categoryattribute`
  ADD CONSTRAINT `categoryattribute_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `productcategory` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `categoryattribute_ibfk_2` FOREIGN KEY (`attribute_id`) REFERENCES `attribute` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`categoryid`) REFERENCES `productcategory` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`brand_id`) REFERENCES `brand` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `productattrvalue`
--
ALTER TABLE `productattrvalue`
  ADD CONSTRAINT `productattrvalue_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `productattrvalue_ibfk_2` FOREIGN KEY (`attr_id`) REFERENCES `attribute` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `productattrvalue_ibfk_3` FOREIGN KEY (`attrlistvalue_id`) REFERENCES `attrvaluelist` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Ограничения внешнего ключа таблицы `productbysupplier`
--
ALTER TABLE `productbysupplier`
  ADD CONSTRAINT `productbysupplier_ibfk_1` FOREIGN KEY (`supplierid`) REFERENCES `supplier` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `productbysupplier_ibfk_3` FOREIGN KEY (`productid`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `productcategory`
--
ALTER TABLE `productcategory`
  ADD CONSTRAINT `productcategory_ibfk_1` FOREIGN KEY (`parentid`) REFERENCES `productcategory` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Ограничения внешнего ключа таблицы `productfeedback`
--
ALTER TABLE `productfeedback`
  ADD CONSTRAINT `productfeedback_ibfk_1` FOREIGN KEY (`productid`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `productrating`
--
ALTER TABLE `productrating`
  ADD CONSTRAINT `productrating_ibfk_1` FOREIGN KEY (`productid`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `product_views`
--
ALTER TABLE `product_views`
  ADD CONSTRAINT `product_views_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `supplierfeedback`
--
ALTER TABLE `supplierfeedback`
  ADD CONSTRAINT `supplierfeedback_ibfk_1` FOREIGN KEY (`supplierid`) REFERENCES `supplier` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `supplierrating`
--
ALTER TABLE `supplierrating`
  ADD CONSTRAINT `supplierrating_ibfk_1` FOREIGN KEY (`supplierid`) REFERENCES `supplier` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user_connections`
--
ALTER TABLE `user_connections`
  ADD CONSTRAINT `user_connections_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
