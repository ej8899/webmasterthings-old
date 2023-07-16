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

include("../config.php");
?><html><head><title><? echo"$exchange_name"; ?> - Sign up!</title><LINK REL=stylesheet HREF="../style.css" TYPE="text/css">
</head>
<body>


<CENTER>
<TABLE>
<TR><TD>

<?
	$error=0;
	if($submit){

		// Validate the Name
		if(strlen(trim($name)) < 2){
			$error = 1;
			$error_html .= "Name is invalid, (should be at least 2 characters in length).<br><br>\n";
		}
		if(strlen(trim($name)) > 100){
			$error = 1;
			$error_html .= "Name is invalid, (should be less than 100 characters in length).<br><br>\n";
		}

		// Validate the Login
		if(strlen(trim($login)) > 15){
			$error = 1;
			$error_html .= "Login is invalid, (should be less than 15 characters in length).<br><br>\n";
		}
		if(strlen(trim($login)) < 2){
			$error = 1;
			$error_html .= "Login is invalid, (should be at least 2 characters in length).<br><br>\n";
		}
		if($oldlogin == $login){
		}else{
			$check_login=mysql_query("select * from banneruser where login='$login'");
		$get_login=@mysql_fetch_array($check_login);
		$exists=$get_login[login];
		if($exists == $login){
			$error = 1;
			$error_html .= "Login is invalid, (already in use).<br><br>\n";
		}
		}
		
		// Validate the Email Address
		if(!ereg("^([a-z0-9_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,4}\$",$email)){
			$error = 1;
			$error_html .= "Email Address is invalid.<br><br>\n";
		}
// Validate the Password
		if(strlen(trim($pass)) < 4){
			$error = 1;
			$error_html .= "Password is invalid, (should be at least 4 characters in length).<br><br>\n";
	}
				if($error=="1"){
					echo "<br><font color=\"#FF0000\"><b>Your submission is incomplete for the following reasons:</b></font>";
					echo "<blockquote>".$error_html."</blockquote>\n";
					echo "Please <a href=\"javascript:history.go(-1)\">go back</a> and try again.";
				} else {
					$get_info=mysql_query("select * from banneruser where id='$uid'");
					$get_rows=@mysql_fetch_array($get_info);
					$url=$get_rows[url];
					$exposures=$get_rows[exposures];
					$credits=$get_rows[credits];
					$clicks=$get_rows[clicks];
					$siteclicks=$get_rows[siteclicks];
					$approved=$get_rows[approved];
$update=mysql_query("update banneruser set login='$login',pass='$pass',name='$name',email='$email' where id='$uid'");
					echo "<br>Submission Complete. <br><br>";
					echo "<br><br>Name: $name<br>Login: $login<br>Password: $pass<br>Email: $email<br>uid: $uid<br><br>";
					echo "$url $exposures $credits $clicks $siteclicks $approved";
					?>
						<form method="POST" action="<? echo"$base_url"; ?>/client/stats.php">
						<input type=hidden name=login value=<? echo "$login"; ?>>
						<input type=hidden name=pass value=<? echo "$pass"; ?>>
						<input type="submit" value="Login">
						<?

				}
}
?>
</cENTER>
</TD></TR>
</TABLE>