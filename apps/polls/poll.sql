# MySQL dump 8.12
#
# Host: localhost    Database: AdvancedPoll
#--------------------------------------------------------
# Server version	3.23.32

#
# Table structure for table 'poll_comment'
#

CREATE TABLE poll_comment (
  com_id int(9) NOT NULL auto_increment,
  poll_id int(9) NOT NULL default '0',
  time int(11) NOT NULL default '0',
  host varchar(70) NOT NULL default '',
  browser varchar(70) NOT NULL default '',
  name varchar(60) NOT NULL default '',
  email varchar(70) NOT NULL default '',
  message text NOT NULL,
  PRIMARY KEY (com_id)
) TYPE=MyISAM;

#
# Dumping data for table 'poll_comment'
#

INSERT INTO poll_comment VALUES (1,1,987527752,'localhost','Mozilla/4.0 (compatible; MSIE 5.5; Windows NT 4.0)','nobody','nobody@server.com','This is the first comment!');

#
# Table structure for table 'poll_config'
#

CREATE TABLE poll_config (
  config_id smallint(5) unsigned NOT NULL auto_increment,
  base_gif varchar(60) NOT NULL default '',
  lang varchar(20) NOT NULL default '',
  title varchar(60) NOT NULL default '',
  vote_button varchar(30) NOT NULL default '',
  result_text varchar(40) NOT NULL default '',
  total_text varchar(40) NOT NULL default '',
  voted varchar(40) NOT NULL default '',
  send_com varchar(40) NOT NULL default '',
  img_height int(5) NOT NULL default '0',
  img_length int(5) NOT NULL default '0',
  table_width varchar(6) NOT NULL default '',
  bgcolor_tab varchar(7) NOT NULL default '',
  bgcolor_fr varchar(7) NOT NULL default '',
  font_face varchar(70) NOT NULL default '',
  font_color varchar(7) NOT NULL default '',
  type varchar(10) NOT NULL default '0',
  check_ip smallint(2) NOT NULL default '0',
  lock_timeout int(9) NOT NULL default '0',
  time_offset varchar(5) NOT NULL default '0',
  entry_pp int(4) unsigned NOT NULL default '0',
  PRIMARY KEY (config_id)
) TYPE=MyISAM;

#
# Dumping data for table 'poll_config'
#

INSERT INTO poll_config VALUES (1,'http://www.proxy2.de/poll/image','english.php','Advanced Poll','Vote','View results','Total votes','You have already voted!','Send comment',10,42,'170','#FFFFFF','#006699','Verdana, Arial, Helvetica, sans-serif','#000000','percent',0,2,'0',5);

#
# Table structure for table 'poll_data'
#

CREATE TABLE poll_data (
  id int(11) NOT NULL auto_increment,
  poll_id int(11) NOT NULL default '0',
  option_id int(11) NOT NULL default '0',
  option_text varchar(100) NOT NULL default '',
  color varchar(20) NOT NULL default '',
  votes int(14) NOT NULL default '0',
  PRIMARY KEY (poll_id,option_id),
  KEY id(id)
) TYPE=MyISAM;

#
# Dumping data for table 'poll_data'
#

INSERT INTO poll_data VALUES (1,1,1,'Linux','blue',49);
INSERT INTO poll_data VALUES (2,1,2,'Solaris','yellow',12);
INSERT INTO poll_data VALUES (3,1,3,'FreeBSD','green',29);
INSERT INTO poll_data VALUES (4,1,4,'WindowsNT','brown',17);
INSERT INTO poll_data VALUES (5,1,5,'Unix','grey',10);
INSERT INTO poll_data VALUES (6,1,6,'BSD','red',15);
INSERT INTO poll_data VALUES (7,1,7,'other','purple',9);
INSERT INTO poll_data VALUES (8,2,5,'Sybase','orange',2);
INSERT INTO poll_data VALUES (9,2,4,'MS SQL','green',9);
INSERT INTO poll_data VALUES (10,2,3,'Oracle','blue',17);
INSERT INTO poll_data VALUES (11,2,2,'PostgreSQL','gold',6);
INSERT INTO poll_data VALUES (12,2,1,'MySQL','pink',23);
INSERT INTO poll_data VALUES (13,2,6,'other','brown',3);
INSERT INTO poll_data VALUES (14,2,7,'DB/2','grey',4);

#
# Table structure for table 'poll_index'
#

CREATE TABLE poll_index (
  poll_id int(11) unsigned NOT NULL auto_increment,
  question varchar(100) NOT NULL default '',
  timestamp int(11) NOT NULL default '0',
  status smallint(2) NOT NULL default '0',
  logging smallint(2) NOT NULL default '0',
  exp_time int(11) NOT NULL default '0',
  expire smallint(2) NOT NULL default '0',
  comments smallint(2) NOT NULL default '0',
  PRIMARY KEY (poll_id)
) TYPE=MyISAM;

#
# Dumping data for table 'poll_index'
#

INSERT INTO poll_index VALUES (1,'Which OS is your Website running on?',987527752,1,1,988391752,1,1);
INSERT INTO poll_index VALUES (2,'Which database engine do you prefer?',987527802,1,0,988391752,0,1);

#
# Table structure for table 'poll_ip'
#

CREATE TABLE poll_ip (
  ip_id int(11) NOT NULL auto_increment,
  poll_id int(11) NOT NULL default '0',
  ip_addr varchar(15) NOT NULL default '',
  timestamp int(11) NOT NULL default '0',
  PRIMARY KEY (ip_id)
) TYPE=MyISAM;

#
# Dumping data for table 'poll_ip'
#


#
# Table structure for table 'poll_log'
#

CREATE TABLE poll_log (
  log_id int(11) unsigned NOT NULL auto_increment,
  poll_id int(11) NOT NULL default '0',
  option_id int(11) NOT NULL default '0',
  timestamp int(11) NOT NULL default '0',
  ip_addr varchar(15) NOT NULL default '',
  host varchar(70) NOT NULL default '',
  agent varchar(80) NOT NULL default '0',
  PRIMARY KEY (log_id)
) TYPE=MyISAM;

#
# Dumping data for table 'poll_log'
#


#
# Table structure for table 'poll_user'
#

CREATE TABLE poll_user (
  user_id smallint(5) NOT NULL auto_increment,
  username varchar(30) NOT NULL default '',
  userpass varchar(30) NOT NULL default '',
  session varchar(32) NOT NULL default '',
  PRIMARY KEY (user_id)
) TYPE=MyISAM;

#
# Dumping data for table 'poll_user'
#

INSERT INTO poll_user VALUES (1,'admin','2f3f44617b0bc93d','37e196a01f94342825d6f3bb9cbc50f4');

#
# The Username is : admin
# The Password is : poll
#
