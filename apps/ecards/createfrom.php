<?
$wt_owner=$wt_user; // to fix for a screwup in some sites of ours
require ("../wtuserinfo.php");				// get user info based on 'wt_owner field'

#print "$wt_user || $wt_owner<BR><BR>";
#print "|$wtdb[headerfile]|<BR><BR>";
$tcmHeader="$wtdb[headerfile]";
$tcmFooter="$wtdb[footerfile]";


$fd = fopen( "$tcmHeader", "r" ); 
$contents = fread( $fd, 20000 ); 
fclose( $fd ); 
print $contents;
?>
<div align=center>
<font face=arial size=4><b>Send an E-Postcard Picture!</b></font><br>
<font face=arial size=2><b>For additional ecards, be sure to have a look at our <a href="http://www.groovypostcards.com" target="fpc">GroovyPostcards</a> site!</b>
<br>
<br>
<font face=arial size=3>Verify this is the photo you wish to send, then scroll down<br>
and complete the e-postcard details!</font>
<br>


<?
print "<IMG SRC=\"$photo\" border=0><br clear=all><BR>";
if ($ad && $adurl)
{
	print "<a href=\"$adurl\" target=adpage><IMG SRC=\"$ad\" border=0>";
}
if ($adblock)
{
	$fd = fopen( "$adblock", "r" ); 
	$adcontent = fread( $fd, 20000 ); 
	fclose( $fd ); 
	print $adcontent;
}

?>
<br clear=all><BR>
<!-- ECARD INFO -->
<form action="http://www.groovypostcards.com/cgi-bin/gpc/postcard/postcard.cgi" method="post">
<input type="hidden" name="sendcardurl" value="http://www.groovypostcards.com">
<input type="hidden" name="visitthis" value="http://www.groovypostcards.com/">
<input type="hidden" name="visitthistext" value="Hundreds of exciting e-cards to send to your friends & family.">
<INPUT TYPE="hidden" name="topbanner" value="http://www.findinglove.com/468findinglove.gif"> 
<INPUT TYPE="hidden" name="topbannerurl" value="http://www.findinglove.com"> 
<input type="hidden" name="tcm.user" value="tcm@tcmd.com">

<?
print "<input type=hidden name=picture value=\"$photo\">";
?>


		
			
<table   border="0" cellpadding="2" cellspacing="0" bgcolor="#000000">
<tr>
<td><table border="0" bgcolor="#C0C0C0">
<tr>
<td align="center">
<table border="0" width=500>
<tr>
<td align="right"  valign="top"><font face=arial size=2><B>Receiver name:</B></font></td>
<td><input type="text" size="20" name="toname"></td>
<td rowspan=4><font face=arial size=2 color=maroon><b>Just fill out this form and click 'mail this postcard' and the picture (above) will be sent to the receiver!<BR><BR>What a great anytime gift idea!</b></font></td>
</tr>
<tr>
<td align="right" valign="top"><font face=arial size=2><B>their email address:</B></font></td>
<td><input type="text" size="20" name="mail"></td>
</tr>
<tr>
<td align="right" valign="top"><font face=arial size=2><B>Your name:</B></font></td>
<td><input type="text" size="20" name="from"></td>
</tr>
<tr>
<td align="right" valign="top"><font face=arial size=2><B>Your email address:</B></font></td>
<td><input type="text" size="20" name="replyto"></td>
</tr>
<tr>
<td align="right" valign="top"><font face=arial size=2><B>Message:</B></font></td>
<td colspan=2><textarea name="message" rows="3" cols="40" wrap="virtual"> </textarea></td>
</tr>
<tr><td align="right" valign="top"></td><td></td></tr>
<tr>
<td>&nbsp;</td>
<td><BR><input type="submit" name="submit" value="Mail This Postcard!" style="background-color:#ffc184;font-weight:bold"></td>
</tr>
</table></td></tr></table>
</td></tr></table>
</form>


</div>

<?
$fd = fopen( "$tcmFooter", "r" ); 
$contents = fread( $fd, 20000 ); 
fclose( $fd ); 
print $contents;
?>
