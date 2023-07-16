# MySQL dump 4.0
#
# Host: localhost    Database: root
#--------------------------------------------------------


#
# Table structure for table 'phpostcards'
#
CREATE TABLE wt_postcards (
   id int(9) NOT NULL auto_increment,
   pic varchar(255) NOT NULL,
   sound varchar(20),
   pbcolor varchar(6) NOT NULL,
   hbcolor varchar(6) NOT NULL,
   htcolor varchar(6) NOT NULL,
   hfont varchar(20) NOT NULL,
   htext varchar(100) NOT NULL,
   mbcolor varchar(6) NOT NULL,
   mtcolor varchar(6) NOT NULL,
   mfont varchar(20) NOT NULL,
   message blob NOT NULL,
   sname varchar(50) NOT NULL,
   smail varchar(75) NOT NULL,
   rname varchar(50) NOT NULL,
   rmail varchar(75) NOT NULL,
   senddate varchar(10) NOT NULL,
   pickup_id varchar(20) NOT NULL,
   date date DEFAULT '0000-00-00' NOT NULL,
   markedread enum("N","Y") NOT NULL,

   visitthis varchar(250) NOT NULL,
   visitthistext varchar(250) NOT NULL,
   picturelink varchar(250) NOT NULL,
   picturetext varchar(250) NOT NULL,
   topbanner varchar(250) NOT NULL,
   topbannerurl varchar(250) NOT NULL,

   adfile varchar(250) NOT NULL,
   exitpage varchar(250) NOT NULL,
   contentrating varchar(1) NOT NULL,
   belongsto int(10) NOT NULL,
   sentyet varchar(3) DEFAULT 'no' NOT NULL,

   PRIMARY KEY (id),
   KEY id (id),
   UNIQUE (pickup_id)
);
