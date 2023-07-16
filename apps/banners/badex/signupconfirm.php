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

include("config.php");
?><html><head><title><? echo"$exchange_name"; ?> - Sign up!</title><LINK REL=stylesheet HREF="style.css" TYPE="text/css">
</head>
<body>
<?
	$imagestuff = getimagesize($bannerurl);
	$imagewidth = $imagestuff[0];
	$imageheight = $imagestuff[1];
	$error=0;
	if($submit){

		// Validate the Name
		if(strlen(trim($name)) < 2){
			$error = 1;
			$error_html .= "The information you submitted in the Name field is invalid. (should be more than 2 characters).<br><br>\n";
		}
		if(strlen(trim($name)) > 100){
			$error = 1;
			$error_html .= "The information you submitted in the Name field is invalid. (should be less than 100 characters).<br><br>\n";
		}

		// Validate the Login
		if(strlen(trim($login)) > 20){
			$error = 1;
			$error_html .= "The information you submitted in the Login field is invalid. (should be less than 20 characters in length).<br><br>\n";
		}
		if(strlen(trim($login)) < 2){
			$error = 1;
			$error_html .= "The information you submitted in the Login field is invalid. (should be at least 2 characters in length).<br><br>\n";
		}
		$check_login=mysql_query("select * from wt_banneruser where login='$login'");
		$get_login=@mysql_fetch_array($check_login);
		$exists=$get_login[login];
		if($exists == $login){
			$error = 1;
			$error_html .= "The Login you are trying to use is already in use.<br><br>\n";
		}
				// Validate the Site URL
			if(!$get_url=@fopen($url,"r")){
				$error = 1;
				$error_html .= "Site URL is invalid. Please make sure you include the filename (index.html, for example) or a trailing slash (http://www.somesite.com/)!<br><br>\n";
		}

				// Validate the Banner Width and Height
			if($imagewidth==''){
				$error = 1;
				$error_html .= "The system was unable to locate your banner image with the URL you provided. This is because it's either not an image, or does not exist at the URL you provided (<b>$bannerurl</b>).  Please check the URL and try again.  Please note that if you are on a free host such as Geocities or Angelfire, you might need to include your banner somewhere on your own page in order for it to be allowed to be remotely linked. Some services don't allow remote linking at all.<br><br>\n";
		}
			if($imagewidth != $banner_width){
				$error=1;
				$error_html .= "Your banner is invalid because it is <b>$imagewidth</b> pixels wide. Banners for this exchange should be $banner_width pixels wide.<br><br>\n";
		}
			if($imageheight != $banner_height){
				$error=1;
				$error_html .= "Your banner is invalid because it is <b>$imageheight</b> pixels high. Banners for this exchange should be $banner_height pixels high.<br><br>\n";
		}

			// Validate the Email Address
			if(!ereg("^([a-z0-9_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,4}\$",$email)){
			$error = 1;
			$error_html .= "The system was unable to validate your email address because it contains special characters. Please contact the administrator for assistance.<br><br>\n";
		}

		// Validate the Password
		if(strlen(trim($pass)) < 4){
			$error = 1;
			$error_html .= "The information you submitted in the password field is invalid. (should be at least 4 characters in length).<br><br>\n";
	    }

				if($error=="1"){
					echo "<br><font color=\"#FF0000\"><b>We could not create your account for the following reasons:</b></font>";
					echo "<blockquote>".$error_html."</blockquote>\n";
					echo "Please <a href=\"javascript:history.go(-1)\">go back</a> and try again.";
				} else {
					$insert=mysql_query("insert into wt_banneruser values ('','$login','$pass','$name','$email','$url','0','$starting_credits','0','0','0','0','','')",$db);
					$get_id=mysql_query("select id from wt_banneruser where login='$login' AND pass='$pass'");
					$get_rows=mysql_fetch_array($get_id);
					$insert_banner=mysql_query("insert into wt_bannerurls values ('','$bannerurl','$get_rows[id]')");
					?>
<center><h3>Thanks for signing up!</h3></center>
You will be added into the banner rotation in the next couple of days.<br><br>
We have also sent an email to <?echo"$email"; ?> with your login and password. You should keep this in a safe place for future reference.  You may also login by clicking on the "Login" button below, or by going to the <a href="index.php">Stats Login page</a> at any time.  This panel will allow you to add banners, check your stats, change your URL, change your password, etc.<br><br>You will also need to add the following code to your page in order to start accumulating credits on your account:<br><br>
<center><?
	if($show_beimage=='N'){
	?>
<center><b>HTML Code</b><br><br>
<TABLE width="400" class="windowbg">
<TR><TD>
&lt;!--Begin <? echo "$exchange_name"; ?> code --&gt;<br>
&lt;iframe align=top width=<? echo "$banner_width"; ?> height=<? echo "$banner_height"; ?> marginwidth=0 marginheight=0 hspace=0 
vspace=0 frameborder=0 scrolling=no src=&quot;<? echo "$base_url"; 
?>/view.php?uid=<? echo "$get_rows[id]"; ?>&quot;&gt;
&lt;ilayer align=top width=<? echo "$banner_width"; ?> height=<? echo "$banner_height"; ?> src=&quot;<? echo "$base_url"; 
?>/view.php?uid=<? echo "$get_rows[id]"; ?>&quot;&gt;&lt;/ILAYER&gt;
&lt;/iframe&gt;&lt;br&gt;&lt;a href=&quot;<?echo"$base_url"; ?>&quot;&gt;<? 
echo "$exchange_name"; ?>&lt;/a&gt;&lt;/center&gt;<br>
&lt;!--End <? echo "$exchange_name"; ?> code --&gt;
</TD></TR>
</TABLE>
<?
}else{
?>
<center><b>HTML Code</b><br><br>
<TABLE width="400" class="windowbg">
<TR><TD>
&lt;!--Begin <? echo "$exchange_name"; ?> code --&gt;<br>
&lt;a href=&quot;<? echo "$base_url"; ?>&quot;&gt;&lt;img src=&quot;<? echo "$be_image"; ?>&quot; border=&quot;0&quot;&gt;&lt;/a&gt;&lt;iframe align=top width=<? echo "$banner_width"; ?> height=<? echo "$banner_height"; ?> marginwidth=0 marginheight=0 hspace=0 
vspace=0 frameborder=0 scrolling=no src=&quot;<? echo "$base_url"; 
?>/view.php?uid=<? echo "$get_rows[id]"; ?>&quot;&gt;
&lt;ilayer align=top width=<? echo "$banner_width"; ?> height=<? echo "$banner_height"; ?> src=&quot;<? echo "$base_url"; 
?>/view.php?uid=<? echo "$get_rows[id]"; ?>&quot;&gt;&lt;/ILAYER&gt;
&lt;/iframe&gt;&lt;br&gt;&lt;a href=&quot;<?echo"$base_url"; ?>&quot;&gt;<? 
echo "$exchange_name"; ?>&lt;/a&gt;&lt;/center&gt;<br>
&lt;!--End <? echo "$exchange_name"; ?> code --&gt;
</TD></TR>
</TABLE>
	<?
}
?>
<br><br>
						<form method="POST" action="<? echo"$base_url"; ?>/client/stats.php">
						<input type=hidden name=login value=<? echo "$login"; ?>>
						<input type=hidden name=pass value=<? echo "$pass"; ?>>
						<input type="submit" value="Login"></center>
						<?
					if($admin_mail=="Y"){
					$subject = "New Banner Exchange Account!";
					$content = "There is a new banner exchange account awaiting approval! Go here: ".$base_url."/admin/";
					mail($owner_email,$subject,$content,"From: $email");
						}else{
						}
					$usrsubject = "Welcome to ".$exchange_name."!";
					$usrcontent = "You are recieving this email because someone used this email account to sign up for ".$exchange_name.".  If you did not sign up for this service or did not request this information, please accept our apologies.\n\nYour login ID is: $login\nYour Password is: $pass\n\nYou may log on to check your stats, get your HTML code, add and remove banners, and other administrative functions at any time by going to:\n   $base_url\n\nThank you for your interest!\n\n$owner_name.";
					mail($email,$usrsubject,$usrcontent,"From: $owner_email");
				}
}
?>
<? include("footer.php"); ?>