# ********************************************************************
#  phpLinks2 Upgrade SQL
# ********************************************************************

#	Note: You will need to edit the table names before performing these queries
#	if your tables are not named the default table names.

# ********************************************************************
#  2.1.1 -> 2.1.2
# ********************************************************************

#	You must run 'admin/upgrade/convert_related_2.1.1-2.1.2.php'.

	alter table categories change Children Children enum ('Top','Rand','Desc','Vert') default 'Top' not null;
	alter table links change ID ID smallint (5) unsigned not null auto_increment;
	alter table links change Added Added char (14);
	alter table links change Category Category smallint (5) unsigned default '0' not null;
	alter table links change Password Password char (16) not null;
	alter table links change HitsIn HitsIn smallint (5) unsigned default '0' not null;
	alter table links change HitsOut HitsOut smallint (5) unsigned default '0' not null;
	alter table categories change Description Description blob not null;
	alter table reviews change ID ID smallint (5) unsigned not null auto_increment;
	alter table reviews change SiteID SiteID smallint (5) unsigned default '0' not null;
	alter table reviews change Review Review blob not null;
	alter table reviews change Rating Rating tinyint (2) unsigned default '0' not null;
	alter table reviews change Added Added timestamp (14) not null;
	alter table sessions change id id char (32) not null;
	alter table terms change Term Term varchar (32) not null;
	alter table settings add OuterFrame enum ('Y','N') default 'Y' not null;

# ********************************************************************
#  2.1 -> 2.1.1
# ********************************************************************

	create table sessions (
	   id varchar(32) not null,
	   data text not null,
	   expire int(11) unsigned default '0' not null,
	   primary key (id)
	);

# ********************************************************************
#  2.1b -> 2.1
# ********************************************************************

	alter table categories add ShowSiteCount enum ('Y','N') default 'Y' not null after AllowSites 
	alter table settings add DefaultCountry varchar (50) default 'United States' not null after DateFormat

# ********************************************************************
#  2.03 -> 2.1b
# ********************************************************************

	alter table settings add Language varchar(16) not null default "english" after Theme;
	alter table settings add DateFormat varchar(16) not null default 'M j, Y' after Email;
	alter table links change Added Added varchar(14); 
	alter table temp change Added Added varchar(14); 

# ********************************************************************
#  2.02 -> 2.03
# ********************************************************************

#	None

# ********************************************************************
#  2.01 -> 2.02
# ********************************************************************

	alter table links ADD Country VARchar (100) default 'United_States.gif' not null AFTER Category;
	alter table temp ADD Country VARchar (100) default 'United_States.gif' not null AFTER Category;

# ********************************************************************
#  2.0 -> 2.01
# ********************************************************************

#	None
