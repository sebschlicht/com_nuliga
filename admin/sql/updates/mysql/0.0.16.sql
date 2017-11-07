CREATE TABLE `#__nuliga_leagueteams` (
  `id`    INT(11) NOT NULL AUTO_INCREMENT,
  `tabid` INT(11) NOT NULL,
  `rank` TINYINT NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `numMatches` TINYINT NOT NULL DEFAULT 0,
  `numWins` TINYINT NOT NULL DEFAULT 0,
  `numDraws` TINYINT NOT NULL DEFAULT 0,
  `numLosses` TINYINT NOT NULL DEFAULT 0,
  `goals` VARCHAR(64) NOT NULL,
  `goalDiff` VARCHAR(32) NOT NULL,
  `points` VARCHAR(32) NOT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE =MyISAM
  AUTO_INCREMENT =0
  DEFAULT CHARSET =utf8;

INSERT INTO `#__nuliga_leagueteams` (`tabid`, `rank`, `name`, `numMatches`, `numWins`, `numDraws`, `numLosses`, `goals`, `goalDiff`, `points`) VALUES
  (1, 1, 'TestTeam', 1, 1, 0, 0, '33:32', '+1', '2:0');
