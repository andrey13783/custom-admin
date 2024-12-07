-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Дек 08 2024 г., 00:44
-- Версия сервера: 5.6.51
-- Версия PHP: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `base`
--

-- --------------------------------------------------------

--
-- Структура таблицы `adm_fields`
--

DROP TABLE IF EXISTS `adm_fields`;
CREATE TABLE `adm_fields` (
  `id` int(11) NOT NULL,
  `field` varchar(50) NOT NULL,
  `title` varchar(50) NOT NULL,
  `alt` text NOT NULL,
  `type` varchar(10) NOT NULL,
  `class` varchar(50) NOT NULL DEFAULT 'main_fields',
  `many` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `adm_fields`
--

INSERT INTO `adm_fields` (`id`, `field`, `title`, `alt`, `type`, `class`, `many`) VALUES
(1, 'title', 'Заголовок', '', '', 'main_fields', 0),
(2, 'text', 'Полное описание', '', '', 'text_fields', 0),
(3, 'header', 'Заголовок', '', '', 'properties_fields', 0),
(4, 'id', 'ID', '', '', 'main_fields', 0),
(5, 'description', 'Краткое описание', '', '', 'seo_fields', 0),
(6, 'keywords', 'Ключ. слова', '', '', 'seo_fields', 0),
(7, 'm_image', 'Картинки', '', '', 'properties_fields', 0),
(8, 'image', 'Картинка', 'Картинка (иконка) для записи.', '', 'properties_fields', 0),
(9, 'sh', 'Показ на сайте', '', '', 'main_fields', 0),
(11, 'sort', 'Порядок', '', '', 'main_fields', 0),
(12, 'level', 'Вложенность', '', '', 'main_fields', 0),
(13, 'url', 'Код элемента', '', '', 'main_fields', 0),
(18, 'mail', 'Адрес e-mail', '', '', 'main_fields', 0),
(19, 'phone', 'Телефон', '', '', 'main_fields', 0),
(20, 'access', 'Доступ', '', '', 'main_fields', 0),
(22, 'user_id', 'ID пользователя', '', '', 'main_fields', 0),
(23, 'number', 'Номер', '', '', 'main_fields', 0),
(25, 'total', 'Итого', '', '', 'main_fields', 0),
(26, 'status', 'Статус', '', '', 'main_fields', 0),
(30, 'password', 'Пароль', '', '', 'main_fields', 0),
(31, 'date', 'Дата', '', '', 'main_fields', 0),
(32, 'title_pub', 'Публикация', '', '', 'main_fields', 0),
(33, 'source', 'Источник', '', '', 'main_fields', 0),
(34, 'sh_menu', 'Показ в меню', '', '', 'main_fields', 0),
(36, 'meta_title', 'Заголовок META', '', '', 'seo_fields', 0),
(45, 'link', 'Ссылка', '', '', 'main_fields', 0),
(39, 'value', 'Значение', '', '', 'main_fields', 0),
(40, 'templates', 'Шаблон', '', '', 'main_fields', 0),
(41, 'languages', 'Язык', '', '', 'main_fields', 0),
(43, 'adm_access', 'Права доступа', '', '', 'main_fields', 1),
(47, 'user', 'Пользователь', '', '', 'main_fields', 1),
(49, 'price', 'Цена', '', '', 'properties_fields', 0),
(82, 'preview', 'Анонс', '', '', 'text_fields', 0),
(51, 'inc_table', 'Подкл. таблицу', '', '', 'properties_fields', 0),
(52, 'class', 'CSS класс', '', '', 'css_fields', 0),
(58, 'css', 'CSS описание', '', '', 'css_fields', 0),
(61, 'source', 'Код источника', '', '', 'code_fields', 0),
(63, 'canonical', 'Канонический URL', 'Если страница дублирующая, указать URL основной', '', 'seo_fields', 0),
(65, 'path', 'Путь', '', '', 'main_fields', 0),
(66, 'tables', 'Подкл. раздел', '', '', 'main_fields', 0),
(67, 'catalog', 'Каталог', '', '', 'main_fields', 0),
(69, 'icon', 'Иконка', '', '', 'properties_fields', 0),
(70, 'input_types', 'Тип поля', '', '', 'main_fields', 0),
(71, 'sh_index', 'Открыто для ПС', '', '', 'seo_fields', 0),
(72, 'documents', 'Документы', '', '', 'properties_fields', 0),
(74, 'date_reg', 'Дата регистрации', '', '', 'main_fields', 0),
(75, 'sh_access', 'Доступ', 'Разрешить доступ незарегистрированным пользователям', '', 'main_fields', 0),
(83, 'code', 'Код', '', '', 'main_fields', 0),
(84, 'address', 'Адрес', '', '', 'main_fields', 0),
(85, 'section', 'Раздел', '', '', 'main_fields', 0),
(86, 'alt', 'Подсказка', '', '', 'properties_fields', 0),
(87, 'short_title', 'Краткий заголовок', '', '', 'properties_fields', 1),
(88, 'min_price', 'Цена от', '', '', 'properties_fields', 0),
(89, 'rate', 'Тариф', '', '', 'properties_fields', 0),
(94, 'subheader', 'Подзаголовок', '', '', 'properties_fields', 0),
(95, 'tpl', 'Шаблон', '', '', 'main_fields', 0),
(96, 'bread_crumb', 'Хлебная крошка', '', '', 'seo_fields', 0),
(97, 'rating', 'Рейтинг', '', '', 'properties_fields', 0),
(98, 'sh_access', 'Ограничен доступ', 'Если включено, доступ к этой записи будут иметь только авторизированные пользователи', '', 'main_fields', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `adm_fields_groups`
--

DROP TABLE IF EXISTS `adm_fields_groups`;
CREATE TABLE `adm_fields_groups` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `url` varchar(50) NOT NULL,
  `sort` int(11) NOT NULL,
  `sh` int(11) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `adm_fields_groups`
--

INSERT INTO `adm_fields_groups` (`id`, `title`, `url`, `sort`, `sh`) VALUES
(1, 'Основное', 'main', 10, 1),
(2, 'Дополнительно', 'properties', 30, 1),
(6, 'Описание', 'text', 15, 1),
(3, 'SEO', 'seo', 40, 1),
(4, 'Изображение', 'image', 25, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `adm_menu`
--

DROP TABLE IF EXISTS `adm_menu`;
CREATE TABLE `adm_menu` (
  `id` int(11) NOT NULL,
  `title` varchar(255) CHARACTER SET cp1251 NOT NULL DEFAULT '',
  `text` varchar(255) CHARACTER SET cp1251 NOT NULL,
  `link` varchar(150) CHARACTER SET cp1251 NOT NULL,
  `page` varchar(255) CHARACTER SET cp1251 NOT NULL DEFAULT '',
  `image` varchar(255) CHARACTER SET cp1251 NOT NULL DEFAULT '',
  `icon` varchar(20) CHARACTER SET cp1251 NOT NULL,
  `filters` varchar(255) NOT NULL,
  `level` int(11) NOT NULL DEFAULT '0',
  `adm_access` varchar(15) CHARACTER SET cp1251 DEFAULT '0',
  `sh` int(11) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `adm_menu`
--

INSERT INTO `adm_menu` (`id`, `title`, `text`, `link`, `page`, `image`, `icon`, `filters`, `level`, `adm_access`, `sh`) VALUES
(36, 'Настройки', '', '', '', '', 'fa-cog', '', 0, '1', 1),
(15, 'Страницы', '', '', 'content', '', '', '', 1, '1 2', 1),
(34, 'Пользователи ПУ', '', '', 'adm_users', '', '', '', 36, '1', 1),
(1, 'Сайт', '', '', '', '', ' fa-file-text', '', 0, '1 2', 1),
(80, 'Настройки сайта', '', '', 'settings', '', '', '', 36, '1', 1),
(86, 'Меню', '', '', 'menu', '', '', '', 1, '1', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `adm_users`
--

DROP TABLE IF EXISTS `adm_users`;
CREATE TABLE `adm_users` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `level` int(11) NOT NULL,
  `password` varchar(255) NOT NULL DEFAULT '',
  `access` int(1) NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

--
-- Дамп данных таблицы `adm_users`
--

INSERT INTO `adm_users` (`id`, `title`, `level`, `password`, `access`, `sort`) VALUES
(1, 'ehoho', 0, 'admin', 1, 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `adm_fields`
--
ALTER TABLE `adm_fields`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `adm_fields_groups`
--
ALTER TABLE `adm_fields_groups`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `adm_menu`
--
ALTER TABLE `adm_menu`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `adm_users`
--
ALTER TABLE `adm_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `adm_fields`
--
ALTER TABLE `adm_fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT для таблицы `adm_fields_groups`
--
ALTER TABLE `adm_fields_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `adm_menu`
--
ALTER TABLE `adm_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT для таблицы `adm_users`
--
ALTER TABLE `adm_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
