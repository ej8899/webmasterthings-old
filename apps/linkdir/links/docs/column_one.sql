DROP TABLE IF EXISTS settings;
CREATE TABLE settings (
  ID tinyint(4) unsigned NOT NULL auto_increment,
  SiteTitle varchar(50) NOT NULL default 'phpLinks',
  Theme varchar(16) NOT NULL default 'original',
  Language varchar(16) NOT NULL default 'english',
  Name varchar(50) NOT NULL default '',
  Email varchar(50) NOT NULL default '',
  DateFormat varchar(16) NOT NULL default 'M j, Y',
  DefaultCountry varchar(50) NOT NULL default 'United States',
  ColCount enum('1','2','3','4') default NULL,
  ManuallyValidate enum('Y','N') NOT NULL default 'Y',
  URLValidate enum('Y','N') NOT NULL default 'Y',
  NewSubmissionEmail enum('Y','N') NOT NULL default 'Y',
  SiteAdditionEmail enum('Y','N') NOT NULL default 'Y',
  SiteDeletionEmail enum('Y','N') NOT NULL default 'Y',
  PerPage tinyint(3) NOT NULL default '10',
  NavLinks tinyint(3) NOT NULL default '3',
  BaseURL varchar(50) NOT NULL default '',
  BasePath varchar(50) NOT NULL default '',
  OuterFrame enum('Y','N') NOT NULL default 'Y',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;