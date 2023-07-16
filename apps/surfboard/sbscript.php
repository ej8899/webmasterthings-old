<?

require "../wtuserinfo.php";


// Okay, Now we create the "Post Data" file. 
// This is where we post the datae that a guest has sent. 
// You need to put this file in a folder that doesn't have a 
// viewable page inside of it (eg. cgi-bin).

// here we are making sure the requested method of capturing
// data is by POST, the default is GET.

if (($REQUEST_METHOD=='POST')) {

// Now we'll remove "dangerous" characters from the posted
// data and replace them with "safe" characters so that
// we won't have any problems.

for(reset($HTTP_POST_VARS);
$key=key($HTTP_POST_VARS);
next($HTTP_POST_VARS)) {
$this = ($HTTP_POST_VARS[$key]);
$this = strtr($this, "/", " ");
$this = strtr($this, "{", " ");
$this = strtr($this, "}", " ");
$this = strtr($this, "[", " ");
$this = strtr($this, "]", " ");
$this = strtr($this, ")", " ");
$this = strtr($this, "(", " ");
$this = strtr($this, "?", ".");
$this = strtr($this, "!", ".");
$this = strtr($this, ">", " ");
$this = strtr($this, "<", " ");
$this = strtr($this, "|", " ");
$$key = $this;
}

// This will catch if someone is trying to submit a blank
// or incomplete form and return them back to the surfboard.

if($_POST["name"] && $_POST["msg"]) {

// Now we update our tables.

$query = "INSERT INTO wt_surfboard"; 
$query .= "(sb_id, wt_owner, sb_name, sb_time, sb_msg)"; 
$query .= "values(0000,'$wt_owner','$name',NULL,'$msg')"; 
mysql_pconnect("$wtserver","$wtdb_user","$wtdb_pass") or die("You SQL Server Could Not Be Accessed!"); 
mysql_select_db("$wtdatabase") or die("Unable To Open Your Database"); 
mysql_query($query) or die("Insert Failed!"); 
?>

<script language="JavaScript">
parent.location.href="surfboard.php?fin=1&wt_owner=<?php echo "$wt_owner";?>";
</script>

<? 
} else {
?> 

<!-- If they didn't fill out everything then we'll send them back
 this will trigger a message within the surfboard that will tell
 them that they forgot to fill something out. -->

<script language="JavaScript">
parent.location.href="surfboard.php?fin=0&wt_owner=<?php echo "$wt_owner";?>";
</script>

<? 
}}
?>