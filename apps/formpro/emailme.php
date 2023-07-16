
<?php

	// info passed to this file is:
	//	wt_owner (owner #)
	//  emailto (email addy who its for)

	// get WebmasterThings database info
	require ("../wtuserinfo.php");



if($wtdb[headerfile])
{
	$fd = fopen( "$wtdb[headerfile]", "r" ); 
	$contents = fread( $fd, 20000 ); 
	fclose( $fd ); 
	echo "$contents";
}	
else
{
	echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\"><html><head><title>Email Me!</title><meta name=\"MSSmartTagsPreventParsing\" content=\"TRUE\"></head><body><div align=center><table border=0 width=550><tr><td>";
}

?>

<BR><font face=arial size=3>Use this form to send your email message to <b><?php echo "$emailto";?></b>!</font>
<br>
<form action="http://www.webmasterthings.com/apps/formpro/formpro.php" method="POST">
<input type=hidden name=wt_owner value="<?php echo "$wt_owner";?>">
<input type=hidden name=to value="<?php echo "$emailto";?>">

<table>
<tr>
	<td><font face=arial size=2>Your Name:</font></td>
	<td><input type="Text" name="realname" size="35"></td>
</tr>
<tr>
	<td><font face=arial size=2>Your Email Address:</font></td>
	<td><input type="Text" name="email" size=35></td>
</tr>
<tr>
	<td><font face=arial size=2>Message Subject:</font></td>
	<td><input type=text name=subject value="" size=35></td>
<tr>
	<td valign=top><font face=arial size=2>Your Message:</font></td>
	<td><textarea name="message" cols="35" rows="3" wrap="VIRTUAL"></textarea></td>
</tr>
<tr>
	<td></td>
	<td><input type="Submit" name="submit" value="Send Message"></td>
</tr>
</table>

</P>
</form>


<?php
if($wtdb[footerfile])
{
	$fd = fopen( "$wtdb[footerfile]", "r" ); 
	$contents = fread( $fd, 20000 ); 
	fclose( $fd ); 
	print $contents;
}
else
{
	echo "</td></tr></table></div></body></html>";
}
?>
