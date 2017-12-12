DROP TABLE IF EXISTS `#__nuliga`;

CREATE TABLE `#__nuliga` (
  `id`       INT(11)     NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(64) NOT NULL,
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
  PRIMARY KEY (`tabid`, `name`),
  FOREIGN KEY (`tabid`)
    REFERENCES `#__nuliga`(`id`)
    ON DELETE CASCADE
)
  ENGINE =MyISAM
  AUTO_INCREMENT =0
  DEFAULT CHARSET =utf8;

DROP TABLE IF EXISTS `#__nuliga_matches`;

CREATE TABLE `#__nuliga_matches` (
  `position` INT(11) NOT NULL,
  `tabid` INT(11) NOT NULL,
  `weekday` VARCHAR(3),
  `date` VARCHAR(64),
  `time` VARCHAR(16),
  `hall` VARCHAR(255) NOT NULL,
  `nr` INT(11) NOT NULL,
  `home` VARCHAR(64) NOT NULL,
  `guest` VARCHAR(64) NOT NULL,
  `goals` VARCHAR(9) NOT NULL,
  `reportUrl` VARCHAR(255) NOT NULL,
  `isPlayed` BOOL NOT NULL,
  PRIMARY KEY (`tabid`, `nr`),
  FOREIGN KEY (`tabid`)
    REFERENCES `#__nuliga`(`id`)
    ON DELETE CASCADE
)
  ENGINE =MyISAM
  AUTO_INCREMENT =0
  DEFAULT CHARSET =utf8;
