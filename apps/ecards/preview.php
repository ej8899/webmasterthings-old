<?PHP
include("postcardconfigure.inc");
echo "$wt_header";


// MAKE SURE REQUIRED FIELDS ARE FILLED OUT

if ( (empty($htext)) or (empty($message)) or
     (empty($sname)) or (empty($rname)) or
	 (empty($smail)) or (empty($rmail))
   ) { 
echo "<CENTER><FONT SIZE=\"+1\">Please enter all required information</FONT></CENTER>";
echo "<p align=center><input type='button' value='Back' onclick='history.go(-1)'></p>";

} else {

// CHECK EMAIL ADDRESSES FOR PROPER FORM

   if(!(eregi('^[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+'.'@'.'[-!#$%&\'*+\\/0-9=?A-Z^_`a-z{|} 
~]+\.'.'[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+$', $smail))):
    echo "<B>There was something wrong with the senders email address you entered. It might not be in the proper form. Email addresses must follow the standard format of:<P>";
    echo "name@domain.com <P> Please go back and check it again.</B>";
    echo "<p align=center><input type='button' value='Back' onclick='history.go(-1)'></p>"; 
    exit;
endif;
if(!(eregi('^[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+'.'@'.'[-!#$%&\'*+\\/0-9=?A-Z^_`a-z{|} 
~]+\.'.'[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+$', $rmail))):
    echo "<B>There was something wrong with the recipients email address you entered. It might not be in the proper form. Email addresses must follow the standard format of:<P>";
    echo "name@domain.com <P> Please go back and check it again.</B>";
    echo "<p align=center><input type='button' value='Back' onclick='history.go(-1)'></p>"; 
    exit;
endif;


// CLEAN THINGS UP

$htext = strip_tags(stripslashes("$htext"));
$message = strip_tags(stripslashes("$message"));
$message = nl2br("$message");
$sname = strip_tags(stripslashes("$sname"));
$smail = strip_tags(stripslashes("$smail"));
$rname = strip_tags(stripslashes("$rname"));
$rmail = strip_tags(stripslashes("$rmail"));


// ADD SMILIES FOR PREVIEW
   
   if ($emoticons == 1) {
   $messagepreview = str_replace (":)", "<img src=\"$emoticonpath/smile.gif\" border=0>", $message);
   $messagepreview = str_replace (":(", "<img src=\"$emoticonpath/frown.gif\" border=0>", $messagepreview);
   $messagepreview = str_replace (";)", "<img src=\"$emoticonpath/wink.gif\" border=0>", $messagepreview);
   }


// PLAY BACKGROUND SOUND

if (!empty($sound)) 
echo "<embed src='sounds/$sound' AUTOSTART='true' HIDDEN='true'>";

?>


<BR><FORM METHOD="POST" ACTION="sendcard.php">
<TABLE ALIGN="center" CELLSPACING="0" CELLPADDING="10" BORDER="2" RULES="none">
<tr>    <TD BGCOLOR="#<?PHP echo $hbcolor ?>">
	<FONT SIZE="+2" FACE="<?PHP echo $hfont ?>" COLOR="#<?PHP echo $htcolor ?>">
	<CENTER>
    <?PHP echo $htext ?>
    </CENTER>
</FONT>
	</TD></tr>
<TR>
    <TD BGCOLOR="#<?PHP echo $pbcolor ?>"><IMG SRC="<?PHP echo $pic ?>" BORDER="0"></TD>
</TR>
<TR>
    <TD BGCOLOR="#<?PHP echo $mbcolor ?>">
	
<FONT SIZE="+1" FACE="<?PHP echo $mfont ?>" COLOR="#<?PHP echo $mtcolor ?>">
<?PHP echo $messagepreview ?>
</FONT>

	
	</TD>
</TR>
</TABLE>
<BR><BR>

<div align=center><table border=0 width=550><tr><td align=justify><font face=arial size=2>
<B>
The card you see above is exactly what the person you send it to will see. If you like the way it looks, just click 'Send Card' and the recipient will be told where to pick it up. If you want to make any changes to the picture, the wording, or the colors, just hit your browsers 'back' button. Also, Please double check your email address and the address of the person receiving the card before you send it. If the addresses are wrong the card cannot be delivered
<P>
Your email address is: <font color=maroon><?PHP echo $smail ?></font><BR>
The card is being sent to: <font color=maroon><?PHP echo $rmail ?></font>
<P>
If those addresses are not correct please go back and make the changes now.
</font></td></tr></table></div><BR>

<?PHP

// PREPARE HIDDEN FIELDS

$htext = urlencode("$htext");
$message = urlencode("$message");
$sname = urlencode("$sname");
$rname = urlencode("$rname");
$smail = urlencode("$smail");
$rmail = urlencode("$rmail");

?>

<INPUT TYPE=HIDDEN VALUE="<?PHP echo $pic ?>" NAME="pic">
<INPUT TYPE=HIDDEN VALUE="<?PHP echo $sound ?>" NAME="sound">
<INPUT TYPE=HIDDEN VALUE="<?PHP echo $pbcolor ?>" NAME="pbcolor">
<INPUT TYPE=HIDDEN VALUE="<?PHP echo $hbcolor ?>" NAME="hbcolor">
<INPUT TYPE=HIDDEN VALUE="<?PHP echo $htcolor ?>" NAME="htcolor">
<INPUT TYPE=HIDDEN VALUE="<?PHP echo $hfont ?>" NAME="hfont">
<INPUT TYPE=HIDDEN VALUE="<?PHP echo $htext ?>" NAME="htext">
<INPUT TYPE=HIDDEN VALUE="<?PHP echo $mbcolor ?>" NAME="mbcolor">
<INPUT TYPE=HIDDEN VALUE="<?PHP echo $mtcolor ?>" NAME="mtcolor">
<INPUT TYPE=HIDDEN VALUE="<?PHP echo $mfont ?>" NAME="mfont">
<INPUT TYPE=HIDDEN VALUE="<?PHP echo $message ?>" NAME="message">
<INPUT TYPE=HIDDEN VALUE="<?PHP echo $sname ?>" NAME="sname">
<INPUT TYPE=HIDDEN VALUE="<?PHP echo $smail ?>" NAME="smail">
<INPUT TYPE=HIDDEN VALUE="<?PHP echo $rname ?>" NAME="rname">
<INPUT TYPE=HIDDEN VALUE="<?PHP echo $rmail ?>" NAME="rmail">

	<input type="hidden" value="<?PHP echo $wt_owner ?>" name="wt_owner">
	<input type="hidden" value="<?PHP echo $exitpage ?>" name="exitpage">
    <input type="hidden" value="<?PHP echo $contentrating ?>" name="contentrating">
    <input type="hidden" value="<?PHP echo $wt_owner ?>" name="belongsto">
    <input type="hidden" value="<?PHP echo $adfile ?>" name="adfile">	
    <input type="hidden" value="<?PHP echo $picturelink ?>" name="picturelink">
    <input type="hidden" value="<?PHP echo $picturetext ?>" name="picturetext">

<DIV ALIGN="center">
If you want to make changes:<BR>
<P>
<input type="button" value="Edit Card" onclick="history.go(-1)">
<P><BR><P>
If you're happy and would like to send this card:<P>
<?PHP 
if ($usecron == 1) {
include ("dateform.php");
}
?>
<INPUT TYPE="submit" VALUE="Send Card!">
</DIV>

</FORM>

<?PHP
 }

echo "$wt_footer";
?>

