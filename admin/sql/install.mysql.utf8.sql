DROP TABLE IF EXISTS `#__nuliga`;

CREATE TABLE `#__nuliga` (
  `id`       INT(11)     NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(25) NOT NULL,
  `type` TINYINT NOT NULL DEFAULT '1',
  `url` VARCHAR(255) NOT NULL,
  `published` tinyint(4) NOT NULL DEFAULT '1',
  `last_update` DATETIME,
  PRIMARY KEY (`id`)
)
  ENGINE =MyISAM
  AUTO_INCREMENT =0
  DEFAULT CHARSET =utf8;

DROP TABLE IF EXISTS `#__nuliga_leagueteams`;

CREATE TABLE `#__nuliga_leagueteams` (
  `tabid` INT(11) NOT NULL,
  `rank` TINYINT NOT NULL,
  `name` VARCHAR(64) NOT NULL,
  `numMatches` TINYINT NOT NULL DEFAULT 0,
  `numWins` TINYINT NOT NULL DEFAULT 0,
  `numDraws` TINYINT NOT NULL DEFAULT 0,
  `numLosses` TINYINT NOT NULL DEFAULT 0,
  `goals` VARCHAR(64) NOT NULL,
  `goalDiff` VARCHAR(32) NOT NULL,
  `points` VARCHAR(32) NOT NULL,
  PRIMARY KEY (`name`),
  FOREIGN KEY (`tabid`)
    REFERENCES `#__nuliga`(`id`)
    ON DELETE CASCADE
)
  ENGINE =MyISAM
  AUTO_INCREMENT =0
  DEFAULT CHARSET =utf8;
