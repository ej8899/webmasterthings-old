<?PHP
include("postcardconfigure.inc");
echo "$wt_header";




// CHECK DATES

$today = date("Y-m-d");
if ($usecron == 1) {
$senddate = "$year-$month-$day";
} else {
$senddate = $today;
}

if ($senddate < $today) {
echo "<P>The date you chose to send the card has already passed. Please go back and select a later date";
echo "<p align=center><input type='button' value='Back' onclick='history.go(-1)'></p>";
exit;
} 


// CLEAN UP HIDDEN FIELDS

$htext = urldecode("$htext");
$message = urldecode("$message");
$rname = urldecode("$rname");
$sname = urldecode("$sname");
$rmail = urldecode("$rmail");
$smail = urldecode("$smail");


// GENERATE A CARD ID 

$random = md5 (uniqid (""));
$unique = substr ("$random", 0, 20);


// ADD DB SLASHES

$htext2 = addslashes("$htext");
$message2 = addslashes("$message");
$sname2 = addslashes("$sname");
$smail2 = addslashes("$smail");
$rname2 = addslashes("$rname");
$rmail2 = addslashes("$rmail");


// INSERT DATA 

mysql_connect($host,$user,$password);
@mysql_select_db("$db") or die("Unable to open database");
$query = "insert into $table (id, pic, sound, pbcolor, hbcolor, htcolor, hfont, htext, mbcolor, mtcolor, mfont, message, sname, smail, rname, rmail, senddate, pickup_id, date,belongsto,adfile,contentrating,exitpage,picturetext,picturelink) values ('','$pic','$sound','$pbcolor','$hbcolor','$htcolor','$hfont','$htext2','$mbcolor','$mtcolor','$mfont','$message2','$sname2','$smail2','$rname2','$rmail2','$senddate','$unique', now(),'$belongsto','$adfile','$contentrating','$exitpage','$picturetext','$picturelink')";
$result = mysql_query($query);
$rows = mysql_affected_rows();

if ($rows == -1) {
    echo "There was a problem adding that card to the database. Please try again.<P>";
	echo "<p align=center><input type='submit' value='Back' onclick='history.go(-1)'></p>";
} 
else 
{
	echo "<DIV ALIGN=\"center\">";
	echo "<P><BR><P><H2>Thanks $sname</H2><P>"; 
	echo "<B>Your card has been added to the database and will be sent to $rname at $rmail on $month/$day/$year.</B>";
	echo "<P><P><a href=\"$exitpage\">Send Another Card</a></DIV>";
}


//
// run the sending routine here
//

$today = date("Y-m-d");

// GET THE NEEDED INFO FROM DB
@mysql_connect($host,$user,$password) or die("unable to connect to database");
@mysql_select_db("$db") or die("Unable to open database");
$query = "SELECT * FROM $table WHERE senddate='$today' AND sentyet='no'";
$mysql_result = @mysql_query($query) or die ("query failed");
$rows = mysql_num_rows($mysql_result);

// SEND THE MAIL

if ($rows == 0) {
 	// echo "There are no cards to send today.";
 } else 
 {

while($data = mysql_fetch_array($mysql_result)) {

	$eheader_file="email-torxer.html";
		$efile = fopen($eheader_file, "r");
		$econtents = fread($efile, filesize($eheader_file));
		fclose($efile);
$ehtml=$econtents;

$adultinfo="";
if($data[contentrating]=='x')
{
	$eheader_file="email-adultsonly.html";
		$efile = fopen($eheader_file, "r");
		$econtents = fread($efile, filesize($eheader_file));
		fclose($efile);
		$ehtml = eregi_replace('%CONTENTTYPE%', $econtents, $ehtml);
		$contentad="http://www.meobscene.com/ars/pa/index.php";
}
else
{	
		$ehtml=eregi_replace('%CONTENTTYPE%','',$ehtml);
		$contentad="email-gad.html";
}

	$efile = fopen ($contentad, "rb");
	$econtents = "";
	do {
	    $edata = fread($efile, 8192);
	    if (strlen($edata) == 0) {
	        break;
	    }
	    $econtents .= $edata;
	} while(true);
	fclose ($efile);

$ehtml=eregi_replace('%SENDER%',"<a href=mailto:$data[smail]>$data[sname]</a>",$ehtml);
$ehtml=eregi_replace('%SENDCARDURL%',"<a href=$wtdb[siteurl]>$wtdb[siteurl]</a>",$ehtml);
$ehtml=eregi_replace('%CARDCODE%',$data[pickup_id],$ehtml);
$ehtml=eregi_replace('%CONTENTAD%',$econtents,$ehtml);

 $mailsender = "From:  $data[sname] <$data[smail]>";
 $subject = "A friend has sent you a Virtual Greeting Card from $wtdb[sitename];";
 
$headers= "$mailsender\r\n";
//$headers.= "To: $data[rmail]\r\n";
$headers.= "Content-type: text/html; charset=iso-8859-1\r\n";
// echo "<BR><BR>$data[rmail]<BR>$subject<BR>$headers";
mail($data[rmail], $subject, $ehtml, $headers);

 // update database and change 'sentyet' to yes for each record
$updatesql = "UPDATE $table SET sentyet='yes' WHERE id = '$data[id]'";
$updateinsert = mysql_query($updatesql);
 
 $sent++;
}
// echo "$sent card(s) sent successfully on $today";
// echo $ehtml;
}


// all cards to deliver today have been emailed and flagged as sent at this point here





//
// cleanup the database here
//

//
// need to read the card first and sent thanks to both sender & rx'er
//
mysql_connect($host,$user,$password);
  @mysql_select_db("$db") or die("Unable to open database");
  $query = "DELETE FROM $table WHERE date <= DATE_SUB(CURRENT_DATE, INTERVAL 60 DAY) ";
  $result=@mysql_query($query);
  $rows = mysql_affected_rows();
  // echo "$rows cards were deleted from the database.";






echo "$wt_footer";
?>
