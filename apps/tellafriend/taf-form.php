<?
#  Header
if($wtdb[headerfile])
{
	$fd = fopen( "$wtdb[headerfile]", "r" ); 
	$contents = fread( $fd, 20000 ); 
	fclose( $fd ); 
	echo "$contents";
}	
else
{
	echo "<html>\n";                                                                                                                 
	echo " <head>\n";
	echo "  <title>Tell a Friend about $REFERER</title>\n";
	echo "  <meta name=\"robots\" content=\"index, nofollow\">\n";                                                                       
	echo "  <meta name=\"revisit-after\" content=\"20 days\">\n";                                                                        
	echo " </head>\n";                                                                                                               
	echo "<body>\n";
}
?>

<CENTER>

<BR><TABLE WIDTH=550><TR><TD align=center>
<FONT FACE="ARIAL" SIZE=4 ><B>TELL A FRIEND ABOUT THIS WEB SITE</BIG></B><br>
<font size=2><?php echo "<A HREF=\"$REFERER\">$REFERER</A>";?></FONT>
<br>
<br><table border=0 width=80%><tr><Td>
 <FONT FACE="ARIAL" SIZE=2>
  If you have a friend that you would like to recommend this page to,
  or if you just want to send yourself a reminder, here is the easy
  way to do it!
  <P>
  Simply fill in the e-mail address of the person(s) you wish to tell
  about this site, your name and e-mail address (so they do
  not think it is spam or reply to us with gracious thanks),
  and click the <B>TELL YOUR FRIENDS</B> button.
  If you want to, you can also enter a message that will be included
  on the e-mail.
 </FONT></td></tr></table>
<FORM METHOD="POST" ACTION="tellafriend.php">
   <INPUT TYPE="HIDDEN" NAME="call_by" VALUE="<?php echo "$REFERER"; ?>">
	
   <TABLE BORDER=0 CELLPADDING=1 CELLSPACING=0 >
    <TR>
    <TD>&nbsp;</TD>
    <TD ALIGN=CENTER><B>Name</B></TD>
    <TD ALIGN=CENTER><B>E-Mail Address</B><TD>
    </TR>
    <TR>
    <TD><B>You</B></TD>
    <TD><INPUT TYPE="TEXT" NAME="send_name"></TD>
    <TD><INPUT TYPE="TEXT" NAME="adminemail"></TD>
    </TR>
<?
    for ($i=1;$i<$NUMFRIENDS+1;$i++)
	{
    	echo "<TR><TD><B>Friend $i</B></TD><TD><INPUT TYPE=\"TEXT\" NAME=\"person[$i]\"></TD><TD><INPUT TYPE=\"TEXT\" NAME=\"email[$i]\"></TD></TR>";
    }
?>

   <TR>
   <TD>&nbsp;</TD>
   <TD ALIGN=CENTER COLSPAN=2>
   <B>Your Message</B><BR>
 <textarea name="message" wrap=virtual rows=5 cols=35></textarea>
    <BR>
    <INPUT TYPE="submit" VALUE="TELL YOUR FRIENDS">
    </TD>
    </TR>
  </TABLE>
   <input type="hidden" name="action" value=1>
   <input type="hidden" name="REFERER" value="<?php echo"$REFERER";?>">
   <input type="hidden" name="count" value="<?php echo"$NUMFRIENDS";?>">
   <input type=hidden name=wt_owner value="<?php echo"$wt_owner";?>">
   </FORM>
  </TD>  </TR>  </TABLE>


<?
#  Footer
if($wtdb[footerfile])
{
	$fd = fopen( "$wtdb[footerfile]", "r" ); 
	$contents = fread( $fd, 20000 ); 
	fclose( $fd ); 
	echo "$contents";
}	
else
{
	echo "</body></html>\n";
}
?>