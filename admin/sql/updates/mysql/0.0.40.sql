-- nuliga tables have been removed
DROP TABLE IF EXISTS `#__nuliga`;

-- rebuild league team table to match new hierarchy (team 1->* leagueteam)
DROP TABLE IF EXISTS `#__nuliga_leagueteams`;

CREATE TABLE `#__nuliga_leagueteams` (
  `teamid` INT(11) NOT NULL,
  `rank` TINYINT NOT NULL,
  `name` VARCHAR(64) NOT NULL,
  `numMatches` TINYINT NOT NULL DEFAULT 0,
  `numWins` TINYINT NOT NULL DEFAULT 0,
  `numDraws` TINYINT NOT NULL DEFAULT 0,
  `numLosses` TINYINT NOT NULL DEFAULT 0,
  `goals` VARCHAR(64) NOT NULL,
  `goalDiff` VARCHAR(32) NOT NULL,
  `points` VARCHAR(32) NOT NULL,
  PRIMARY KEY (`teamid`, `name`),
  FOREIGN KEY NULIGALEAGUETEAMPARENT (`teamid`)
    REFERENCES `#__nuliga_teams`(`id`)
    ON DELETE CASCADE
)
  ENGINE =MyISAM
  AUTO_INCREMENT =0
  DEFAULT CHARSET =utf8;

-- rebuild match table to match new hierarchy (team 1->* match)
DROP TABLE IF EXISTS `#__nuliga_matches`;

CREATE TABLE `#__nuliga_matches` (
  `teamid` INT(11) NOT NULL,
  `position` INT(11) NOT NULL,
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
  PRIMARY KEY (`teamid`, `nr`),
  FOREIGN KEY NULIGAMATCHPARENT (`teamid`)
    REFERENCES `#__nuliga_teams`(`id`)
    ON DELETE CASCADE
)
  ENGINE =MyISAM
  AUTO_INCREMENT =0
  DEFAULT CHARSET =utf8;
