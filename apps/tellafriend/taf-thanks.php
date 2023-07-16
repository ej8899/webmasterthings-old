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
	echo "  <title>Thanks!</title>\n";
	echo "  <meta name=\"robots\" content=\"index, nofollow\">\n";                                                                       
	echo "  <meta name=\"revisit-after\" content=\"20 days\">\n";                                                                        
	echo " </head>\n";                                                                                                               
	echo "<body>\n";
}
?>

<CENTER>

<BR><TABLE WIDTH=550><TR><TD align=center>
<FONT FACE="ARIAL" SIZE=4 ><B>Thanks for telling your friends!</BIG></B><br>
<br>
<br><table border=0 width=80%><tr><Td>
 <FONT FACE="ARIAL" SIZE=2>
 We've sent an email to your friends with your message and a link to the web site!<BR><BR>
 <a href="<?php echo "$REFERER"; ?>">Click here to return to the original site</a>
 </FONT></td></tr></table>


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