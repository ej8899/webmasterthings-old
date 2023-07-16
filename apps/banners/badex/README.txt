/////////////////////////////////////////////////
//              phpBannerExchange              //
//              A Free Script by:              //
//                                             //
// darkrose - darkrose@internetunderground.com //
//       lazurus - lazurus@rustedgate.com      //
//                                             //
// Updates and future versions can be found at://
// http://www.internetunderground.com/scripts/ //
//                                             //
// This script is covered under the GNU GPL.   //
//                                             //
// If you modify this script, please make your //
// code available to us! We are not programmers//
// by trade, so there's bound to be bugs and   //
// inefficient code, but we're trying!         //
/////////////////////////////////////////////////

OVERVIEW:
There's probably quite a few bugs and flakiness going on in this script: I tried to weed out all that I could before releasing it, but I'm sure a few slipped by.  If you run across one, please be so kind as to email me at darkrose@internetunderground.com and let me know.  If email isn't your thing, there's a forum set up at http://www.internetunderground.com/forums/board.php?boardid=14 where you can post away with the bug reports.  I plan on releasing better versions with better features when I can, but for now, this is a fully functional banner exchange with multiple banner per account support, which is really what I was after.

Also, if you like this script, please let me know.  Likewise, if you're moving from one of those... "other" .. exchange scripts, please let me know if there's a feature you especially miss, and I'll see what I can do about adding it.

~Darkrose~
-----------------------------------------

SYSTEM REQUIREMENTS:
PHP - PHP 4.0.5 or better is now *REQUIRED*. If you do not meet this requirement, nobody will be able to join your exchange.  You should use version 1.1.
mySQL - I purposefully did NOT use the 'order by RAND()' function in mySQL 3.23.x+ versions because..well, my host doesn't support it.. *grin*
A Web Server - ...that'll support PHP and mySQL
-----------------------------------------

INSTALLATION:
If you are upgrading from 1.0, please see the "UPGRADE.txt" file.

1.) Change the "config.php" and "style.css" files to your liking (more on that later).
2.) Upload all the .php and .css files onto your server.
3.) Run the install.php file located in the root exchange directory and pray it works. If it does not, I have included a mysql.sql file with the necessary table setups you'll need to run. If you use the mysql file, your username and password for the admin section will be "admin" and "pass", and you will DEFINATELY need to change the password once you log in.
4.) DELETE THE INSTALL.PHP SCRIPT!!!!

That's pretty much it as far as installation..
-----------------------------------------

QUIRKS
~You will need to set at least 1 banner as a default banner.  This is really important, as if there are no eligible banners to display (ie, member has any credits available), the script will display a "default account" chosen at random if there's more than one.

~Right now, there's a 1:1 ratio hard coded into the exchange.  I could probably go fractions without a problem, but I think 1:1 ratio banner exchanges are better than some of the higher ratios. If you want a different ratio, you'll need to alter the queries in the "view.php" file (see the "RATIOS" section below).

~Laz and I are planning on adding a whole bunch of new features (yeah, we've just released this script, and we're already planning for 2.0) including an "email all members" option with a user selected "don't mail me bullshit" type option (so the admin could override it and send them email anyways), automatic non-image banners (ie: flash), stuff like that.  Again, let me know if you're wanting a particular feature.

~A word about the anti cheat cookies.  It would probably be easiest if I explain how it works.  Suppose Exchange member ID 1 puts a banner on the bottom of his/her page.  Surfer A comes along and visits the page. A cookie is dropped on Surfer A's computer that expires in (by default, you can change this) 3 minutes.  Exchange member ID 1 will not get any credit for subsequent views until the cookie expires.  If Surfer A goes to another exchange member 2's page, the cookie is overwritten and theoretically, Surfer A could hit the back button and give Exchange Member ID 1 another credit.

The cookies work peachy in IE6 because I included some compact privacy code, which basically shoves the cookie down the browser's throat. :)

-----------------------------------------
ABOUT CONFIG.PHP:
The config.php setup is fairly simple.  Below, I have broken the variables down:

$dbhost - The name of your host. It'll probably be OK to leave this as "localhost". We use this to connect to the database.

$dbuser - Your mySQL login name. We use this to connect to the database.

$dbpasswd - Your mySQL password. We use this to connect to the database.

$db - Leave this line alone. It's the connection routine for the database.

$db_name - The name of the Database you would like to use for the exchange. We use this to connect to the database.

$admin_mail - using a "Y" in this field will notify the admin (using the $owner_email variable below) when a new account is created.  Selecting "N" will turn off this email function.  Make sure you use a capital letter when making your selection.

$base_url - The path to the root exchange directory. (http://www.foo.com/exchange). Do not use a trailing slash.

$owner_email - Your email address.

$owner_name - your name or alias or whatever you want to be known as.

$exchange_name - What you would like to call your exchange. Something like "Commercial-Free Banner Exchange" would be appropriate here. This is called for branding in the "title" tags in the script code and the link back to the exchange on the actual user banner code.

$site_name - this is used for the "conditions of use" page the user sees when he/she is signing up. You can just use the same name as the "$exchange_name" variable if you are not affiliated with another site.

$banner_height - The height, in pixels, of the banners you wish to support.

$banner_width - The Width, in pixels, of the banners you wish to support.

$cookie_expire - How long cookies will last for the banner that the user is currently viewing (in seconds).  

$show_beimage - Choose "Y" if you want to display a small (60x60) image to the left of the banner.  This is usually used to link back to the exchange. Choose "N" to turn this off. Make sure you use a capital letter.

$be_image - The full URL to the image you would like to use as the image described in the above variable.  It is safe to leave this blank if you set the "$show_beimage" variable to "N".

$script_version - Script versioning.  Used in the footer.  Please do not change.
-----------------------------------------

STYLE.CSS

We have included a basic "dark" style.css in the root banner exchange directory. If you don't like the style, feel free to alter it.