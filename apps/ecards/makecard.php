<?PHP
include("postcardconfigure.inc");
echo "$wt_header";

//
// support createfrom data
//
if($photo)
	{	$pic=$photo; }
if($adblock)
	{ 	$adfile=$adblock; }
	
?>

<BR><CENTER>
<FORM method="POST" action="preview.php">
<TABLE bgcolor=orange ALIGN="left" CELLSPACING="0" CELLPADDING="5" ><tr><td>
<TABLE bgcolor="#6a61de" align="center" CELLSPACING="0" CELLPADDING="10" BORDER="3">
<tr>
   <TD>
   <b>Heading</b> Background Color:<BR>
   <SELECT NAME="hbcolor">
   <OPTION VALUE="000000">BLACK
   <OPTION VALUE="FFFFFF">WHITE
   <OPTION VALUE="FF0000">RED
   <OPTION VALUE="00FF00">LIME GREEN
   <OPTION VALUE="339999">TEAL
   <OPTION VALUE="0000FF">BLUE
   <OPTION VALUE="99FFFF">LIGHT BLUE
   <OPTION SELECTED VALUE="000080">NAVY BLUE
   <OPTION VALUE="FFFF33">YELLOW
   <OPTION VALUE="9933FF">PURPLE
   <OPTION VALUE="FF9933">ORANGE
   <OPTION VALUE="FF00FF">FUCHSIA
   <OPTION VALUE="E6E6E6">LIGHT GRAY
   </SELECT>
   <P>
   <b>Heading</b> Text Color:<BR>
   <SELECT NAME="htcolor">
   <OPTION VALUE="000000">BLACK
   <OPTION SELECTED VALUE="FFFFFF">WHITE
   <OPTION VALUE="FF0000">RED
   <OPTION VALUE="00FF00">LIME GREEN
   <OPTION VALUE="339999">TEAL
   <OPTION VALUE="0000FF">BLUE
   <OPTION VALUE="99FFFF">LIGHT BLUE
   <OPTION VALUE="000080">NAVY BLUE
   <OPTION VALUE="FFFF33">YELLOW
   <OPTION VALUE="9933FF">PURPLE
   <OPTION VALUE="FF9933">ORANGE
   <OPTION VALUE="FF00FF">FUCHSIA
   <OPTION VALUE="E6E6E6">LIGHT GRAY
   </SELECT>
   <P>
   <b>Heading</b> Font:<BR>
   <SELECT NAME="hfont">
   <OPTION VALUE="Arial">Arial
   <OPTION SELECTED VALUE="Comic Sans MS">Comic Sans MS
   <OPTION VALUE="Courier">Courier
   <OPTION VALUE="MS Sans Serif">MS Sans Serif
   <OPTION VALUE="Tahoma">Tahoma
   <OPTION VALUE="Times New Roman">Times New Roman
   <OPTION VALUE="Trebuchet MS">Trebuchet MS
   <OPTION VALUE="Verdana">Verdana
   </SELECT>
   <P>
   <b>Heading</b> Message:&nbsp;<FONT SIZE="+1" COLOR="red">*</FONT><BR>
   <TEXTAREA NAME="htext" WRAP="VIRTUAL" ROWS="4"></TEXTAREA><BR>
	</TD>
	    <TD VALIGN=TOP>
   	<FONT SIZE=+1 COLOR="#0000FF">To:</FONT><BR>
	  &nbsp;&nbsp;<B>Name: &nbsp;&nbsp;</B><input type="text" NAME="rname"><FONT SIZE="+1" COLOR="red">*</FONT><BR>
	  &nbsp;&nbsp;<B>E-Mail: </B><input type="text" NAME="rmail"><FONT SIZE="+1" COLOR="red">*</FONT><BR><BR>
	<FONT SIZE=+1 COLOR="#0000FF">From: </FONT><BR>
	  &nbsp;&nbsp;<B>Name: &nbsp;&nbsp;</B><input type="text"  NAME="sname"><FONT SIZE="+1" COLOR="red">*</FONT><BR>
	  &nbsp;&nbsp;<B>E-Mail: </B><input type="text" NAME="smail"><FONT SIZE="+1" COLOR="red">*</FONT><BR><BR>


   Picture Background Color:<BR>
   <SELECT NAME="pbcolor">
   <OPTION VALUE="000000">BLACK
   <OPTION SELECTED VALUE="FFFFFF">WHITE
   <OPTION VALUE="FF0000">RED
   <OPTION VALUE="00FF00">LIME GREEN
   <OPTION VALUE="339999">TEAL
   <OPTION VALUE="0000FF">BLUE
   <OPTION VALUE="99FFFF">LIGHT BLUE
   <OPTION VALUE="000080">NAVY BLUE
   <OPTION VALUE="FFFF33">YELLOW
   <OPTION VALUE="9933FF">PURPLE
   <OPTION VALUE="FF9933">ORANGE
   <OPTION VALUE="FF00FF">FUCHSIA
   <OPTION VALUE="E6E6E6">LIGHT GRAY
   </SELECT>
   
   <?PHP
   
   if ($enablesounds == 1) {
   echo "<BR>";
   echo "Optional Background Music:<BR>";
   echo "<SELECT NAME=sound>";
   echo "<OPTION>";
   echo "<OPTION VALUE=\"grailthm.mid\">Holy Grail Theme";
   echo "<OPTION VALUE=\"happybdy.mid\">Happy Birthday to You";
   echo "<OPTION VALUE=\"christmas.mid\">We Wish You a Merry Christmas";
   echo "</SELECT>";
   }
   
   ?>
	</TD>
</tr>
<TR>
    <TD colspan=2>
	<CENTER>
	<IMG SRC="<?PHP echo $pic ?>">
	</td>
</tr>
<Tr>
<td>
	<P>
   Main Background Color:<BR>
   <SELECT NAME="mbcolor">
   <OPTION VALUE="000000">BLACK
   <OPTION SELECTED VALUE="FFFFFF">WHITE
   <OPTION VALUE="FF0000">RED
   <OPTION VALUE="00FF00">LIME GREEN
   <OPTION VALUE="339999">TEAL
   <OPTION VALUE="0000FF">BLUE
   <OPTION VALUE="99FFFF">LIGHT BLUE
   <OPTION VALUE="000080">NAVY BLUE
   <OPTION VALUE="FFFF33">YELLOW
   <OPTION VALUE="9933FF">PURPLE
   <OPTION VALUE="FF9933">ORANGE
   <OPTION VALUE="FF00FF">FUCHSIA
   <OPTION VALUE="E6E6E6">LIGHT GRAY
   </SELECT>
   <P>
   Main Text Color:<BR>
   <SELECT NAME="mtcolor">
   <OPTION SELECTED VALUE="000000">BLACK
   <OPTION VALUE="FFFFFF">WHITE
   <OPTION VALUE="FF0000">RED
   <OPTION VALUE="00FF00">LIME GREEN
   <OPTION VALUE="339999">TEAL
   <OPTION VALUE="0000FF">BLUE
   <OPTION VALUE="99FFFF">LIGHT BLUE
   <OPTION VALUE="000080">NAVY BLUE
   <OPTION VALUE="FFFF33">YELLOW
   <OPTION VALUE="9933FF">PURPLE
   <OPTION VALUE="FF9933">ORANGE
   <OPTION VALUE="FF00FF">FUCHSIA
   <OPTION VALUE="E6E6E6">LIGHT GRAY
   </SELECT>
   <P>
   Main Font:<BR>
   <SELECT NAME="mfont">
   <OPTION SELECTED VALUE="Arial">Arial
   <OPTION VALUE="Comic Sans MS">Comic Sans MS
   <OPTION VALUE="Courier">Courier
   <OPTION VALUE="MS Sans Serif">MS Sans Serif
   <OPTION VALUE="Tahoma">Tahoma
   <OPTION VALUE="Times New Roman">Times New Roman
   <OPTION VALUE="Trebuchet MS">Trebuchet MS
   <OPTION VALUE="Verdana">Verdana
   </SELECT>
   </td><td valign=bottom align=left>
  Main Message:&nbsp;<FONT SIZE="+1" COLOR="red">*</FONT><BR>
   <textarea name="message" cols="30" rows="5" wrap="VIRTUAL"></textarea><BR> 
	</CENTER>
	</TD>
</TR>
</TABLE>

<div align=right>
Fields marked with a <FONT SIZE="+1" COLOR="red">*</FONT> are <U><B>REQUIRED.</B></U>
    <input type="hidden" value="<?PHP echo $pic ?>" name="pic">
    <input type="hidden" value="<?PHP echo $wt_owner ?>" name="wt_owner">
	<input type="hidden" value="<?PHP echo $exitpage ?>" name="exitpage">
    <input type="hidden" value="<?PHP echo $contentrating ?>" name="contentrating">
    <input type="hidden" value="<?PHP echo $wt_owner ?>" name="belongsto">
    <input type="hidden" value="<?PHP echo $adfile ?>" name="adfile">	
    <input type="hidden" value="<?PHP echo $picturelink ?>" name="picturelink">
    <input type="hidden" value="<?PHP echo $picturetext ?>" name="picturetext">
			
    <input type="submit" value="Preview Card">
	</div>
</td></tr></table>
</FORM>
<BR><BR><BR><BR><BR>
</p>
<p>&nbsp;</p>
<?PHP
echo "$wt_footer";
?>
