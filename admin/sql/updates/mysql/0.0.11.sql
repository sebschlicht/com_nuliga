DROP TABLE IF EXISTS `#__nuliga`;

CREATE TABLE `#__nuliga` (
  `id`       INT(11)     NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(25) NOT NULL,
  `url` VARCHAR(255) NOT NULL,
  `published` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
)
  ENGINE =MyISAM
  AUTO_INCREMENT =0
  DEFAULT CHARSET =utf8;
