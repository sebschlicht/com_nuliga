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

INSERT INTO `#__nuliga_leagueteams` (`tabid`, `rank`, `name`, `numMatches`, `numWins`, `numDraws`, `numLosses`, `goals`, `goalDiff`, `points`) VALUES
  (2, 1, 'TestTeam', 1, 1, 0, 0, '33:32', '+1', '2:0');
