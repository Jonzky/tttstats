

CREATE TABLE IF NOT EXISTS `ttt_report` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `steamid` text COLLATE utf8_unicode_ci NOT NULL,
  `nickname` text COLLATE utf8_unicode_ci NOT NULL,
  `lKarma` int(5) NOT NULL,
  `opKills` int(5) NOT NULL,
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  `repID` text COLLATE utf8_unicode_ci NOT NULL,
  `repNick` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=0 ;
