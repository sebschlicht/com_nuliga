ALTER TABLE `#__nuliga_leagueteams`
  DROP PRIMARY KEY,
  ADD PRIMARY KEY (`tabid`, `name`);

DROP TABLE IF EXISTS `#__nuliga_matches`;

CREATE TABLE `#__nuliga_matches` (
  `tabid` INT(11) NOT NULL,
  `weekday` VARCHAR(3) NOT NULL,
  `date` DATE NOT NULL,
  `time` TIME NOT NULL,
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
