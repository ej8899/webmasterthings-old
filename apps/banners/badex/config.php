<?
/////////////////////////////////////////////////
//              phpBannerExchange              //
//              A Free Script by:              //
//                                             //
// darkrose - darkrose@internetunderground.com //
//       lazurus - lazurus@rustedgate.com      //
//                                             //
// Updates and future versons can be found at: //
// http://www.internetunderground.com/scripts/ //
//                                             //
// This script is covered under the GNU GPL.   //
//                                             //
// If you modify this script, please make your //
// code available to us! We are not programmers//
// by trade, so there's bound to be bugs and   //
// inefficient code, but we're trying!         //
/////////////////////////////////////////////////

/* Refer to README.txt for detailed information on these variables */

	// MySQL login information
	$dbhost = "localhost";
	$dbuser = "root";
	$dbpasswd = "macabre";
	$db_name="exchange12";

	// Don't change these 2 lines
	$db=mysql_connect("$dbhost","$dbuser","$dbpasswd");
	mysql_select_db($db_name,$db);

	/* Send email to admin to notify new account waiting to be validaded 
	Y=yes, send -- N=No, don't send - Needs to be CAPITAL LETTER! */
	$admin_mail="N"; 

	/* No trailing slash for any of the following urls */
	// Web Path
	$base_url="http://www.internetunderground.com/exchange";

	/* Owner Info */
	$owner_email="darkrose@localhost";
	$owner_name="darkrose";

	/* Banner Parameters */
	$exchange_name="phpBannerExchange";
	$site_name="darkrealms";
	$banner_width="468";
	$banner_height="60";
	$cookie_expire="180";

	/* Should the exchange show a small (60x60) exchange logo image to the left of the banner?  Y=yes, show -- N=No, don't show - Needs to be CAPITAL LETTER! */
	$show_beimage="N";
	// Leave blank if you're not going to show an exchange logo
	$be_image="http://www.yoursite.com/path/to/your/60x60.gif";

	/*please do not edit anything below this line*/
	$script_version="1.2";
?>
