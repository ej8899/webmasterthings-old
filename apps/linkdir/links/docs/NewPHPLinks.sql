# *******************************************************************
#  admin/phpLinks2.sql
# *******************************************************************

# Last Updated July 29, 2001  (2.1.2) */

CREATE TABLE wtlinks_sessions (
   id varchar(32) NOT NULL,
   data text NOT NULL,
   expire int(11) unsigned DEFAULT '0' NOT NULL,
   PRIMARY KEY (id)
);

CREATE TABLE wtlinks_categories (
   ID smallint(5) unsigned NOT NULL auto_increment,
   Category varchar(32) NOT NULL,
   PID smallint(5) unsigned DEFAULT '0' NOT NULL,
   Children enum('Top','Rand','Desc','Vert') DEFAULT 'Top' NOT NULL,
   TopChildren tinyint(3) unsigned DEFAULT '3' NOT NULL,
   AllowSites enum('Y','N') DEFAULT 'Y' NOT NULL,
   ShowSiteCount enum('Y','N') DEFAULT 'Y' NOT NULL,
   Description blob NOT NULL,
   PRIMARY KEY (ID),
   KEY Category (Category),
   KEY TopChildren (TopChildren),
   KEY Children (Children),
   KEY PID (PID)
);

CREATE TABLE wtlinks_links (
   ID smallint(5) unsigned NOT NULL auto_increment,
   wtOwner smallint(5) NOT NULL,
   SiteName varchar(100) NOT NULL,
   SiteURL varchar(100) NOT NULL,
   LastUpdate timestamp(14),
   Added varchar(14),
   Description blob NOT NULL,
   Category smallint(5) unsigned DEFAULT '0' NOT NULL,
   Country varchar(100) DEFAULT 'United_States.gif' NOT NULL,
   UserName varchar(16) NOT NULL,
   Password varchar(16) NOT NULL,
   Hint varchar(50) NOT NULL,
   Email varchar(50) NOT NULL,
   HitsIn smallint(5) unsigned DEFAULT '0' NOT NULL,
   HitsOut smallint(5) unsigned DEFAULT '0' NOT NULL,
   InIP varchar(15) NOT NULL,
   OutIP varchar(15) NOT NULL,
   PRIMARY KEY (ID),
   KEY Category (Category)
);

CREATE TABLE wtlinks_related (
   id smallint(5) unsigned NOT NULL auto_increment,
   cat_id smallint(5) unsigned DEFAULT '0' NOT NULL,
   rel_id smallint(5) unsigned DEFAULT '0' NOT NULL,
   PRIMARY KEY (id)
);

CREATE TABLE wtlinks_reviews (
   ID smallint(5) unsigned NOT NULL auto_increment,
   SiteID smallint(5) unsigned DEFAULT '0' NOT NULL,
   ReviewTitle varchar(100) NOT NULL,
   Review blob NOT NULL,
   Reviewer varchar(50) NOT NULL,
   ReviewerEmail varchar(50) NOT NULL,
   ReviewerURL varchar(100) NOT NULL,
   Rating tinyint(2) unsigned DEFAULT '0' NOT NULL,
   Status enum('New','Show','Hide') DEFAULT 'New' NOT NULL,
   Added timestamp(14),
   PRIMARY KEY (ID),
   KEY Rating (Rating)
);

CREATE TABLE wtlinks_settings (
   ID tinyint(4) unsigned NOT NULL auto_increment,
   SiteTitle varchar(50) DEFAULT 'phpLinks' NOT NULL,
   Theme varchar(16) DEFAULT 'original' NOT NULL,
   Language varchar(16) DEFAULT 'english' NOT NULL,
   Name varchar(50) NOT NULL,
   Email varchar(50) NOT NULL,
   DateFormat varchar(16) DEFAULT 'M j, Y' NOT NULL,
   DefaultCountry varchar(50) DEFAULT 'United States' NOT NULL,
   ColCount enum('2','3','4'),
   ManuallyValidate enum('Y','N') DEFAULT 'Y' NOT NULL,
   URLValidate enum('Y','N') DEFAULT 'Y' NOT NULL,
   NewSubmissionEmail enum('Y','N') DEFAULT 'Y' NOT NULL,
   SiteAdditionEmail enum('Y','N') DEFAULT 'Y' NOT NULL,
   SiteDeletionEmail enum('Y','N') DEFAULT 'Y' NOT NULL,
   PerPage tinyint(3) DEFAULT '10' NOT NULL,
   NavLinks tinyint(3) DEFAULT '3' NOT NULL,
   BaseURL varchar(50) NOT NULL,
   BasePath varchar(50) NOT NULL,
   OuterFrame enum('Y','N') DEFAULT 'Y' NOT NULL,
   PRIMARY KEY (ID)
);

INSERT INTO wtlinks_settings (ID, SiteTitle, Theme, Language, Name, Email, DateFormat, DefaultCountry, ColCount, ManuallyValidate, URLValidate, NewSubmissionEmail, SiteAdditionEmail, SiteDeletionEmail, PerPage, NavLinks, BaseURL, BasePath, OuterFrame) VALUES ( '1', 'phpLinks', 'original', 'english', 'My Name', 'webmaster@mydomain.com', 'M j, Y', 'United_States.gif', '3', 'Y', 'N', 'Y', 'Y', 'Y', '10', '4', 'http://mydomain.com/phplinks', '/path/to/phplinks', 'Y');

CREATE TABLE wtlinks_specs (
   ID tinyint(3) unsigned NOT NULL auto_increment,
   SiteNameMin tinyint(4) DEFAULT '0' NOT NULL,
   SiteNameMax tinyint(4) DEFAULT '0' NOT NULL,
   DescMin tinyint(4) DEFAULT '0' NOT NULL,
   DescMax smallint(4) DEFAULT '0' NOT NULL,
   UserNameMin tinyint(4) DEFAULT '0' NOT NULL,
   UserNameMax tinyint(4) DEFAULT '0' NOT NULL,
   PWMin tinyint(4) DEFAULT '0' NOT NULL,
   PWMax tinyint(4) DEFAULT '0' NOT NULL,
   HintMin tinyint(4) DEFAULT '0' NOT NULL,
   HintMax tinyint(4) DEFAULT '0' NOT NULL,
   EmailSpec varchar(255) DEFAULT '^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+' NOT NULL,
   ReviewTitleMin tinyint(4) DEFAULT '5' NOT NULL,
   ReviewTitleMax tinyint(4) DEFAULT '120' NOT NULL,
   ReviewerMin tinyint(4) DEFAULT '4' NOT NULL,
   ReviewerMax tinyint(4) DEFAULT '50' NOT NULL,
   ReviewMin tinyint(4) DEFAULT '50' NOT NULL,
   ReviewMax mediumint(9) DEFAULT '1000' NOT NULL,
   ReviewerEmailSpec varchar(255) DEFAULT '^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+' NOT NULL,
   PRIMARY KEY (ID)
);

INSERT INTO wtlinks_specs (ID, SiteNameMin, SiteNameMax, DescMin, DescMax, UserNameMin, UserNameMax, PWMin, PWMax, HintMin, HintMax, EmailSpec, ReviewTitleMin, ReviewTitleMax, ReviewerMin, ReviewerMax, ReviewMin, ReviewMax, ReviewerEmailSpec) VALUES ( '1', '5', '120', '32', '384', '8', '16', '8', '16', '5', '50', '^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(\\.[a-zA-Z0-9_-])+', '5', '120', '4', '50', '50', '1000', '^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(\\.[a-zA-Z0-9_-])+');

CREATE TABLE wtlinks_temp (
   ID int(7) unsigned NOT NULL auto_increment,
   SiteName varchar(100) NOT NULL,
   SiteURL varchar(100) NOT NULL,
   LastUpdate timestamp(14),
   Added varchar(14),
   Description blob NOT NULL,
   Category smallint(6) unsigned DEFAULT '0' NOT NULL,
   Country varchar(100) DEFAULT 'United_States.gif' NOT NULL,
   UserName varchar(16) NOT NULL,
   Password varchar(16) NOT NULL,
   Hint varchar(50) NOT NULL,
   Email varchar(50) NOT NULL,
   HitsIn int(7) unsigned DEFAULT '0' NOT NULL,
   HitsOut int(7) unsigned DEFAULT '0' NOT NULL,
   InIP varchar(15) NOT NULL,
   OutIP varchar(15) NOT NULL,
   PRIMARY KEY (ID),
   UNIQUE SiteURL (SiteURL)
);

CREATE TABLE wtlinks_terms (
   ID int(10) unsigned NOT NULL auto_increment,
   Term varchar(32) NOT NULL,
   PRIMARY KEY (ID),
   KEY Term (Term)
);
