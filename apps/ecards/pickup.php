<?PHP
include("postcardconfigure.inc");




// CHECK FOR PICKUP_ID AND SHOW INPUT FORM IF MISSING

if (empty($pickup_id)) {
   	echo "$wt_header";
   	echo "<FORM METHOD=\"post\" ACTION=$PHP_SELF>";
   	echo "Pickup ID #: <INPUT type=\"text\" NAME=\"pickup_id\" MAXLENGTH=\"22\">";
   	echo "<input type=\"submit\" value=\"Submit\" name=\"1\">";
   	echo "</FORM>";
  } 
  else 
  {
  
  
// CHECK PICKUP ID FOR FORM, LENGTH AND ALLOWABLE CHARACTERS

if (!ereg ("^[a-z0-9]{20}$", $pickup_id)) {
   die ("<B>Bad ID #:</B> Your pickup ID number is in an improper format. Please check the email message you received to get the proper pickup number. <p align=center><input type='submit' value='Back' onclick='history.go(-1)'></p>");
} else
  

// SELECT CARD SETTINGS FROM DATABASE

  mysql_connect($host,$user,$password);
  @mysql_select_db("$db") or die("Unable to open database");
  $query = "SELECT * FROM $table WHERE pickup_id='$pickup_id'";
  $result=@mysql_query($query);
  $rows = mysql_num_rows($result);
 
 if ($rows == 0) {
 echo "That Card pickup number doesn't exist. Please try again.";
 die ("<p align=center><input type='submit' value='Back' onclick='history.go(-1)'></p>");
 } else

$cardData = mysql_fetch_array($result);  // data fields stored in $cardData array

$id = $cardData[id];
$pic = $cardData[pic];
$sound = $cardData[sound];
$pbcolor = $cardData[pbcolor];
$hbcolor = $cardData[hbcolor];
$htcolor = $cardData[htcolor];
$hfont = $cardData[hfont];
$htext = $cardData[htext];
$mbcolor = $cardData[mbcolor];
$mtcolor = $cardData[mtcolor];
$mfont = $cardData[mfont];
$message = $cardData[message];
$sname = $cardData[sname];
$smail = $cardData[smail];
$rname = $cardData[rname];
$rmail = $cardData[rmail];
$date = $cardData[date];
$markedread = $cardData[markedread];
$belongsto=$cardData[belongsto];

$htext = stripslashes("$htext");
$message = stripslashes("$message");
$message = nl2br("$message");
$sname = stripslashes("$sname");
$smail = stripslashes("$smail");
$rname = stripslashes("$rname");
$rmail = stripslashes("$rmail");
$wt_owner=stripslashes("$belongsto");


echo "$wt_header";

//
// here we should have a 'card found click here to see it (content warning too)' page
// this way the next page will load with the original wt_owners layout
//
if($rrx!='y')
{
	// show the found your card page
	echo "<BR><BR><a href=$PHP_SELF?rrx=y&pickup_id=$pickup_id&wt_owner=$wt_owner>click here to get the card from $sname</a><BR><BR>";

	if($cardData[contentrating]=='x')
	{
		echo "This card contains explicit adult content... you must be 18 years of age to continue!<BR><BR>";
	}

	if($cardData[adfile])
	{
		include "$cardData[adfile]";
	}	
	
	echo "$wt_footer";
	die();
}

// else show the ecard



   // ADD SMILIES
   
   if ($emoticons == 1) {
   $message = str_replace (":)", "<img src=\"$emoticonpath/smile.gif\" border=0>",$message);
   $message = str_replace (":(", "<img src=\"$emoticonpath/frown.gif\" border=0>",$message);
   $message = str_replace (";)", "<img src=\"$emoticonpath/wink.gif\" border=0>", $message);
   }
   
   
   // NOTIFY SENDER ON PICKUP
   
   if ($notifysender == 1 && $markedread == N) {
   $mailsender = "From:  $rname <$rmail>";
$subject = "Your friend has picked-up the greeting card sent from $wtdb[sitename];";
$mailmessage = "Hello $sname!\n\n $rname <$rmail> has picked-up the virtual greeting card you sent from $wtdb[sitename]\n(URL: $wtdb[siteurl]; )\n\n
Thanks for visiting $wtdb[sitename]; and you're always welcome to stop back at $wtdb[siteurl]; to send more virtual greeting cards";

mail($smail, $subject, $mailmessage, $mailsender);
   }
   
   
   // MARK THE CARD AS READ TO PREVENT MULTIPLE NOTIFICATIONS
      if ($markedread == N) 
   {
   		mysql_connect($host,$user,$password);
   		@mysql_select_db("$db") or die("Unable to open database");
   		$change = "UPDATE $table SET markedread='Y' WHERE pickup_id='$pickup_id'";
   		$changed=@mysql_query($change);
  }
  
   
   // PLAY BACKGROUND MUSIC
   
   if (!empty($sound)) 
echo "<embed src='sounds/$sound' AUTOSTART='true' HIDDEN='true'>";

	$pictureLinkData="";
	if($cardData[picturelink] && $cardData[picturetext])
	{
		$pictureLinkData="<br clear=all><div align=center><a href=\"$cardData[picturelink]\" target=piclink><font face=arial size=2><b><i>$cardData[picturetext]</i></b></font></a></div>";
	}
 
?>

<DIV ALIGN="center">
<P><BR><P>
<FONT face=arial size=3>
<b>Hello <font color=maroon><?PHP echo $rname ?></font>,<BR>
This e-greeting card was sent to you by <?PHP echo $sname ?> (<A HREF="http://www.webmasterthings.com/apps/formpro/emailme.php?emailto=<?PHP echo $smail ?>&wt_owner=<?php echo "$wt_owner";?>">email them here</a>).
</b></FONT>
</DIV>

<BR><BR>

<div align=center>
<table border=0 cellpadding=2 cellspacing=0 bgcolor=black><tr><td valign=center align=center>
<TABLE ALIGN="center" CELLSPACING="0" CELLPADDING="10" BORDER="0" RULES="none">
<Tr>
    <TD BGCOLOR="#<?PHP echo $hbcolor ?>">
	<FONT SIZE="+2" FACE="<?PHP echo $hfont ?>" COLOR="#<?PHP echo $htcolor ?>">
	<CENTER>
    <?PHP echo $htext ?>
    </CENTER>
</FONT>
	</TD>
</tr>
<TR>
    <TD align=center BGCOLOR="#<?PHP echo $pbcolor ?>"><IMG SRC="<?PHP echo $pic ?>" BORDER="0"><?PHP echo $pictureLinkData ?></TD>
</TR>
<TR>
    <TD BGCOLOR="#<?PHP echo $mbcolor ?>" align=justify>
<FONT SIZE="+1" FACE="<?PHP echo $mfont ?>" COLOR="#<?PHP echo $mtcolor ?>">
<?PHP echo $message ?>
</FONT>
	</TD>
</TR>
</TABLE></td></tr></table>
</div>
<BR>

<DIV ALIGN="center"><font face=arial size=2>
<A HREF="<?PHP echo $installpath ?>/makecard.php?pic=<?PHP echo $pic ?>&wt_owner=<?php echo $wt_owner ?>">Send this card to a friend</A> | <A HREF="<?PHP echo $wtdb[siteurl] ?>">Send a different card</A></font>
</DIV>


<?PHP

	if($cardData[adfile])
	{
		echo "<BR><BR>";
		include "$cardData[adfile]";
		echo "<BR>";
	}
}
echo "$wt_footer";
?>
