CREATE TABLE `tcmysqlfs_dir` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(760) NOT NULL,
  `created_time` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

CREATE TABLE `tcmysqlfs_file` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dir_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `data` varchar(255) NOT NULL,
  `meta` varchar(2000) DEFAULT NULL,
  `created_time` int(11) NOT NULL DEFAULT '0',
  `updated_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `dir_id` (`dir_id`),
  KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

