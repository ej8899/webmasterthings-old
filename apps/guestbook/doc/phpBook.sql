# --------------------------------------------------------
#
# Table structure for table 'badwords'
#

CREATE TABLE badwords (
   badword varchar(25) NOT NULL
);

#
# Dumping data for table 'badwords'
#

INSERT INTO badwords VALUES ( 'fuck');
INSERT INTO badwords VALUES ( 'schweinehund');
INSERT INTO badwords VALUES ( 'fucking');
INSERT INTO badwords VALUES ( 'shit');
INSERT INTO badwords VALUES ( 'piss');
INSERT INTO badwords VALUES ( 'cock');

# --------------------------------------------------------
#
# Table structure for table 'banned_ips'
#

CREATE TABLE banned_ips (
   banned_ip varchar(15) NOT NULL,
   PRIMARY KEY (banned_ip)
);

#
# Dumping data for table 'banned_ips'
#

INSERT INTO banned_ips VALUES ( '0.0.0.0');



# --------------------------------------------------------
#
# Table structure for table 'guestbook'
#

CREATE TABLE guestbook (
   id int(5) DEFAULT '0' NOT NULL auto_increment,
   name varchar(25) NOT NULL,
   email varchar(35) NOT NULL,
   icq int(11) DEFAULT '0' NOT NULL,
   http varchar(50) NOT NULL,
   message mediumtext NOT NULL,
   timestamp int(11) DEFAULT '0' NOT NULL,
   ip varchar(15) NOT NULL,
   location varchar(35) NOT NULL,
   browser varchar(150) NOT NULL,
   comment mediumtext,
   PRIMARY KEY (id)
);

#
# Dumping data for table 'guestbook'
#

INSERT INTO guestbook VALUES ( '1', 'Webmaster', 'webmaster@netone.at', '0', 'www.netone.at', 'Hi dear User <img src=images/smilies/smile.gif>
<BR>
<BR>The phpBook is great <img src=images/smilies/bounce.gif> leave us a Message in our Guestbook 
<BR>
<BR>by(t)e Webmaster', '981136586', '0.0.0.0', 'A - Wien', 'Mozilla/4.0 (compatible; MSIE 5.5; Windows NT 5.0)','');


# --------------------------------------------------------
#
# Table structure for table 'smilies'
#

CREATE TABLE smilies (
   code char(3) NOT NULL,
   file varchar(15) NOT NULL,
   name varchar(25) NOT NULL
);

#
# Dumping data for table 'smilies'
#

INSERT INTO smilies VALUES ( ':)', 'smile.gif', 'Smile');                                                                           
INSERT INTO smilies VALUES ( ':-)', 'smile.gif', 'Smile');                                                                          
INSERT INTO smilies VALUES ( ':))', 'lol.gif', 'LOL');                                                                              
INSERT INTO smilies VALUES ( ';)', 'wink.gif', 'Winkywinky');                                                                       
INSERT INTO smilies VALUES ( ';-)', 'wink.gif', 'Winkywinky');                                                                      
INSERT INTO smilies VALUES ( ':(', 'frown.gif', 'Frown');                                                                           
INSERT INTO smilies VALUES ( ':-(', 'frown.gif', 'Frown');                                                                          
INSERT INTO smilies VALUES ( ':[', 'mad.gif', 'Mad');                                                                               
INSERT INTO smilies VALUES ( ':z)', 'grazy.gif', 'Grazy');                                                                          
INSERT INTO smilies VALUES ( ':y)', 'crying.gif', 'Crying');                                                                        
INSERT INTO smilies VALUES ( ':o)', 'sleepy.gif', 'Sleepy');                                                                        
INSERT INTO smilies VALUES ( ':a)', 'alien.gif', 'Alien');                                                                          
INSERT INTO smilies VALUES ( ':s)', 'smokie.gif', 'Smokie');                                                                        
INSERT INTO smilies VALUES ( ':l)', 'love.gif', 'Loooove');                                                                         
INSERT INTO smilies VALUES ( ':L)', 'love2.gif', 'Loooooooooove');                                                                  
INSERT INTO smilies VALUES ( ':]', 'biggrin.gif', 'Big Smile');                                                                     
INSERT INTO smilies VALUES ( ':-/', 'bounce.gif', 'Bounce');                                                                        
INSERT INTO smilies VALUES ( ':b)', 'burnout.gif', 'Burnout');                                                                      
INSERT INTO smilies VALUES ( ':&)', 'clown.gif', 'Clown');                                                                          
INSERT INTO smilies VALUES ( ':?)', 'confused.gif', 'Confused');                                                                    
INSERT INTO smilies VALUES ( ':c)', 'cool.gif', 'Cooooooool');                                                                      
INSERT INTO smilies VALUES ( ':e)', 'eek.gif', 'Eeeeeeek');                                                                         
INSERT INTO smilies VALUES ( ':f)', 'flash.gif', 'Flash');                                                                          
INSERT INTO smilies VALUES ( ':g)', 'girl.gif', 'Girl');                                                                            
INSERT INTO smilies VALUES ( ':i)', 'idee.gif', 'Idea');                                                                            
INSERT INTO smilies VALUES ( ':r)', 'redface.gif', 'Redface');                                                                      
INSERT INTO smilies VALUES ( ':8)', 'rolleyes.gif', 'RollEyes');                                                                    
INSERT INTO smilies VALUES ( ':}', 'tongue.gif', 'Tongue');                                                                         
INSERT INTO smilies VALUES ( ':t)', 'tasty.gif', 'Tasty');                                                                          

