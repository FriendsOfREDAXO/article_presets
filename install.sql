DROP TABLE IF EXISTS `%TABLE_PREFIX%articlepresets_profiles`;

CREATE TABLE `rex_articlepresets_profiles` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(30) NOT NULL DEFAULT '',
  `categories` MEDIUMTEXT NOT NULL,
  `templates` varchar(255) NOT NULL,
  `articlereference` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `%TABLE_PREFIX%articlepresets_profiles`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `%TABLE_PREFIX%articlepresets_profiles`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;