<?PHP
echo "$wt_header";
?>

<P><BR><P>

<B>This is Version 1.2 of PHPostcards. It's available to download and use for free on non-profit websites. Below is a working demo of the script in action. It requires PHP version 3+ or 4+ and MySQL to be installed on your server, but can be adapted to work with other databases or with flat file data storage for people without MySQL. It can be easily configured to use any graphic or sound files you like. You can <A HREF="readme.txt">View the ReadMe file</A>, or <A HREF="phpostcards.zip">Download the .zip file</A>
<P>
Or, to get a feel for the script, try sending a card from the demo version below.
</B>

<FORM METHOD="POST" ACTION="makecard.php">
<CENTER>
<TABLE BORDER="1" BGCOLOR="#FFFFFF">
 <TR>
   <TD ALIGN=bottom>
     <IMG SRC="images/birthdaythumb.gif" WIDTH="107" HEIGHT="145" BORDER="0" ALT=""><BR>
     <INPUT TYPE="radio" NAME="pic" VALUE="birthday.gif" CHECKED NAME="picture"></TD>
   <TD ALIGN=bottom>
     <IMG SRC="images/xmasthumb.gif" WIDTH="102" HEIGHT="148" BORDER="0" ALT=""><BR>
     <INPUT TYPE="radio" NAME="pic" VALUE="xmas.gif"></TD>
 </TR>
</TABLE>
<P><BR><P>
<B>Select the picture you'd like to use and click the button to configure your card</B>
<BR><BR>
<INPUT TYPE="submit" VALUE="Configure">
</CENTER>

<P><BR><P>

<?PHP
echo "$wt_footer";
?>



