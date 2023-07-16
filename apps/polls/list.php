<?php
///////////////////////////////////////////////////
//  Advanced Poll 1.61 (PHP/MySQL)               //
//  Copyright (c)2001 Chi Kien Uong              //
//  URL: http://www.proxy2.de                    //
///////////////////////////////////////////////////

$refpage = "test.php";

$poll_version = "v1.61";
require ("./include/config.inc.php");
require ("./include/$poll_db");
$db_connect = new db_sql;
$db_connect->connect($sql_hostname, $sql_username, $sql_password, $dbName);
$varresult = $db_connect->query("SELECT * FROM $sql_config");
$vars = $db_connect->fetch_array($varresult);
while(list($var,$value) = each($vars)) {
  $$var=$value;
}
$db_connect->free_result($varresult);
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
?>
<html>
<head>
<title>Advanced Poll <?php echo $poll_version; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
a:hover {  color: #000099; text-decoration: underline}
a {  text-decoration: none}
.td1 {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 8.5pt}
.td2 {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 7.5pt}
-->
</style>
</head>
<body bgcolor="#FFFFFF" link="#000000" alink="#000000" vlink="#000000">
<br>
<table width="530" border="0" cellspacing="0" cellpadding="3" align="center">
  <tr> 
    <td><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Advanced 
      Poll <?php echo $poll_version; ?></font></b><br>
      <font face="Verdana, Arial, Helvetica, sans-serif" size="1">powered by PHP 
      and mySQL</font> </td>
  </tr>
</table>
<table width="530" border="0" cellspacing="1" cellpadding="6" align="center">
  <tr bgcolor="#DDDDDD"> 
    <td class="td1">&nbsp;</td>
    <td class="td1">Poll</td>
    <td class="td1">Expiration</td>
    <td class="td1">&nbsp;</td>
  </tr>
<?php
$i=0;
$data_result = $db_connect->query("select * from  $sql_index order by poll_id desc");
while ($row = $db_connect->fetch_array($data_result)) {
  if ($row['status']==2) {
    continue;
  }
  if ($row['expire']==0) {
    $exp_date = "<font color=\"#0000FF\">never</font>";
  } else {
    $exp_date = (time()>$row['exp_time']) ? "<font color=\"#FF6600\">expired</font>" : date("j-M-Y",$row['exp_time']+$time_offset)." (<font color=\"#FF0000\">".round(($row["exp_time"]-time())/86400)."</font>)";
  }
  $days = (int) ((time()-$row['timestamp']+$time_offset)/86400);
  $image = ($row['status']==1) ? "$base_gif/active.gif" : "$base_gif/expired.gif";
  echo "  <tr>
    <td class=\"td1\" align=\"right\"><img src=\"$image\" width=\"10\" height=\"12\"></td>\n";
  if (($row['status']==1 && time()<$row['exp_time']) || ($row['expire']==0 && $row['status']==1)) {
    echo "    <td class=\"td1\"><a href=\"$refpage?poll_id=$row[poll_id]\"><acronym title=\"$vote_button\">$row[question]</acronym></a></td>\n";    
  } else {
    echo "    <td class=\"td1\"><a href=\"$refpage?action=results&poll_id=$row[poll_id]\"><acronym title=\"$result_text\">$row[question]</acronym></a></td>\n";
  }
  echo "    <td class=\"td1\">$exp_date</td>
    <td class=\"td1\"><a href=\"$refpage?action=results&poll_id=$row[poll_id]\"><font color=\"#008833\">Results</font></a></td>
  </tr>\n";
  $i++;
}
?>
  <tr>
    <td colspan="4" class="td2">There are currently <?php echo $i; ?> polls in the database</td>
  </tr>
</table>
<table width="530" border="0" cellspacing="1" cellpadding="0" align="center">
  <tr> 
    <td valign="top" align="center" class="td1"> 
       <br><a href="results.php">view all results</a>
    </td>
  </tr>
</table>
</body>
</html>
