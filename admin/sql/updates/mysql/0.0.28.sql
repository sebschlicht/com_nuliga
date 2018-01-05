DROP TABLE IF EXISTS `#__nuliga_teams`;

CREATE TABLE `#__nuliga_teams` (
  `id`       INT(11)     NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(64) NOT NULL,
  `urlPortrait` VARCHAR(255),
  `league` VARCHAR(255) NOT NULL,
  `urlLeague` VARCHAR(255),
  `published` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
)
  ENGINE =MyISAM
  AUTO_INCREMENT =0
  DEFAULT CHARSET =utf8;
