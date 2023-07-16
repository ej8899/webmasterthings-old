<?php 

require "../wtuserinfo.php"; 

if (@$_GET["fin"] == "1") 
{ 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
	<title>post received!</title>
	<meta name="MSSmartTagsPreventParsing" content="TRUE">	
</head>

<body>

<center><FONT COLOR=\"#FF0000\">Your Post Was Successful!<BR><BR><a href="javascript:self.close();">close window</a></FONT></center>

</BODY></html>
<?php
	exit;
}
if (@$_GET["enter"] == "1")
{
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
	<title>post your message</title>
	<meta name="MSSmartTagsPreventParsing" content="TRUE">	
</head>

<body>
<!-- Here's where they fill in thier name and message -->
<FORM METHOD="post" ACTION="sbscript.php"><font face=arial size=1>
Name:<BR><INPUT TYPE="text" NAME="name" SIZE="24" MAXLENGTH="50">
<BR>
Msg:<BR>
<textarea name="msg" cols="20" rows="2" wrap="VIRTUAL"></textarea>
<BR> 
<INPUT TYPE="submit" VALUE="Post It">
<INPUT type=hidden name=wt_owner value=<?php echo "$wt_owner"; ?>>

</FORM>
</font>
</BODY></html>
<?
	exit;
}
?>



<?

// Now we pull all data from the database

$sbconnection=mysql_pconnect("$wtserver","$wtdb_user","$wtdb_pass")
or die("Your SQL Server Could Not Be Accessed!");
mysql_select_db("$wtdatabase") or die("Unable To Open Your Database - 47");

// Now we count how many posts there are.

$query = "SELECT COUNT(*) FROM wt_surfboard WHERE wt_owner=$wt_owner";
$numposts = mysql_query($query) or die("Select Failed!");
$numpost = mysql_fetch_array($numposts);
?>

<BR>

<?

// This is where we decide to get all the entries 
// or just the last 20.
// We do this by adding '?complete=1' after the URL.
// If you do '?complete=0' after, it will only show the last 20
// example: www.yoursite.com/sbviewfile.php?complete=0
// this will only show the last 20 posts

$maxitems=@$_GET["complete"];
if(!$maxitems)
{
	$maxitems=1;
}
if (@$_GET["complete"] ) {
	$query = "SELECT * FROM wt_surfboard WHERE wt_owner=$wt_owner 
	ORDER BY sb_time DESC LIMIT $maxitems";
}

$posts = mysql_query($query) or die("Selection Failed!");
echo "<TABLE BORDER=\"0\" cellpadding=\"0\" cellspacing=\"0\">";


// This will loop as long as there are records 
// that need processing.
while ($post = mysql_fetch_array($posts)) {
?>


<TR class=wt_tableheader> 
<TD> 
<font face=arial size=1>
<? 
echo $post['sb_name']; 
?>
:</font>
</TD>
<TD NOWRAP align=right>
<font face=arial size=1>
<?
$datefromdb = $post['sb_time']; 
$year = substr($datefromdb,0,4); 
$mon = substr($datefromdb,4,2); 
$day = substr($datefromdb,6,2); 
$hour = substr($datefromdb,8,2); 
$min = substr($datefromdb,10,2); 
$sec = substr($datefromdb,12,2); 
$orgdate = date("m.d.y @ H:i", mktime($hour,$min,$sec,$mon,$day,$year)); 
?>

<?
echo $orgdate; 
?> 
</font>
</TD>
</TR>
<tr><td colspan=2 style=wt_smalltext><IMG SRC=http://www.webmasterthings.com/images/blank.gif border=0 height=1 width=1></td></tr>
<TR> 
<TD COLSPAN="2"> 
<font face=arial size=1>
<? 
echo $post['sb_msg']; 
?>
<BR>&nbsp;</font></td></tr>

<? 
} 

if (!$donotpost)	// if there is NOT a donotpost flag, show the post message option
{
?>
<tr><td colspan=2><BR><BR><center><font face=arial size=1><b><a href="#" onclick="javascript:window.open('http://www.webmasterthings.com/apps/surfboard/surfboard.php?enter=1&wt_owner=<?php echo "$wt_owner"; ?>', '2', 'width=200,height=300');">CLICK TO POST A MESSAGE</a></b></font></center>
<?
}
?>

</TD></TR></TABLE>