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
 $result = mysql_query("select * from banneruser where login='$login' AND pass='$pass'");
$get_userinfo=@mysql_fetch_array($result);
$uid=$get_userinfo[id];
$udblogin=$get_userinfo[login];
$udbpass=$get_userinfo[pass];
    if($udblogin=="" AND $udbpass=="" OR $udbpass=="") {
?><html><head><title><? echo"$exchange_name"; ?> - LOGIN ERROR!</title><LINK REL=stylesheet HREF="../style.css" TYPE="text/css">
</head>
<body>
<br><br>&nbsp;
    <center><b>LOGIN ERROR!</b><br><br>The information you entered was incorrect or not found in the database! Please <a href="../index.php">go back</a> and try again!<br><br>
<? include("../footer.php");
}else {

include("../config.php");
?><html><head><title><? echo"$exchange_name"; ?> - Get HTML Codes</title><LINK REL=stylesheet HREF="../style.css" TYPE="text/css">
</head>
<body>
<?
	if($show_beimage=='N'){
	?>
<center><b>HTML Code</b><br><br>
<TABLE width="400" class="windowbg">
<TR><TD>
&lt;!--Begin <? echo "$exchange_name"; ?> code --&gt;<br>
&lt;iframe align=top width=<? echo "$banner_width"; ?> height=<? echo "$banner_height"; ?> marginwidth=0 marginheight=0 hspace=0 
vspace=0 frameborder=0 scrolling=no src=&quot;<? echo "$base_url"; 
?>/view.php?uid=<? echo "$uid"; ?>&quot;&gt;
&lt;ilayer align=top width=<? echo "$banner_width"; ?> height=<? echo "$banner_height"; ?> src=&quot;<? echo "$base_url"; 
?>/view.php?uid=<? echo "$uid"; ?>&quot;&gt;&lt;/ILAYER&gt;
&lt;/iframe&gt;&lt;br&gt;&lt;a href=&quot;<?echo"$base_url"; ?>&quot;&gt;<? 
echo "$exchange_name"; ?>&lt;/a&gt;&lt;/center&gt;<br>
&lt;!--End <? echo "$exchange_name"; ?> code --&gt;
</TD></TR>
</TABLE>
<br><br>
<form method="POST" action="stats.php">
<input type=hidden name=login value=<? echo "$login"; ?>>
<input type=hidden name=pass value=<? echo "$pass"; ?>>
<br><br><input type="submit" value="Back to Stats" name="submit">
</form>
<?
}else{
?>
<center><b>HTML Code</b><br><br>
<TABLE width="400" class="windowbg">
<TR><TD>
&lt;!--Begin <? echo "$exchange_name"; ?> code --&gt;<br>
&lt;a href=&quot;<? echo "$base_url"; ?>&quot;&gt;&lt;img src=&quot;<? echo "$be_image"; ?>&quot; border=&quot;0&quot;&gt;&lt;/a&gt;&lt;iframe align=top width=<? echo "$banner_width"; ?> height=<? echo "$banner_height"; ?> marginwidth=0 marginheight=0 hspace=0 
vspace=0 frameborder=0 scrolling=no src=&quot;<? echo "$base_url"; 
?>/view.php?uid=<? echo "$uid"; ?>&quot;&gt;
&lt;ilayer align=top width=<? echo "$banner_width"; ?> height=<? echo "$banner_height"; ?> src=&quot;<? echo "$base_url"; 
?>/view.php?uid=<? echo "$uid"; ?>&quot;&gt;&lt;/ILAYER&gt;
&lt;/iframe&gt;&lt;br&gt;&lt;a href=&quot;<?echo"$base_url"; ?>&quot;&gt;<? 
echo "$exchange_name"; ?>&lt;/a&gt;&lt;/center&gt;<br>
&lt;!--End <? echo "$exchange_name"; ?> code --&gt;
</TD></TR>
</TABLE>
<br><br>
<form method="POST" action="stats.php">
<input type=hidden name=login value=<? echo "$login"; ?>>
<input type=hidden name=pass value=<? echo "$pass"; ?>>
<br><br><input type="submit" value="Back to Stats" name="submit">
</form>
<? 
}
}
include("../footer.php"); ?>