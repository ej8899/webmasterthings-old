<?php
///////////////////////////////////////////////////
//  Advanced Poll 1.61 (PHP/MySQL)               //
//  Copyright (c)2001 Chi Kien Uong              //
//  URL: http://www.proxy2.de                    //
///////////////////////////////////////////////////

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

$img_length = 80;

?>
<html>
<head>
<title>Advanced Poll</title>
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Expires" content="-1">
<style type="text/css">
<!--
a:hover {  color: #000099; text-decoration: underline}
a:active {  color: #000000; text-decoration: none}
a {  text-decoration: none}
td { font-family: <?php echo $font_face; ?>; }
-->
</style>
</head>
<body bgcolor="#FFFFFF">
<table width="96%" border="0" align="center" cellspacing="1" cellpadding="1">
  <tr>
    <td height="55" valign="middle" align="center"> <b><u><font size="2" face="<?php echo $font_face; ?>">POLL RESULTS</u><br>
      </font></b></td>
  </tr>
  <tr>
    <td valign="top" align="center">
<?php
$poll_result = $db_connect->query("SELECT * FROM $sql_index order by timestamp desc");
while ($row = $db_connect->fetch_array($poll_result)) {
  if ($row['status']==2) {
    continue;
  }
  $question = stripslashes($row['question']);
  $question = htmlspecialchars($question);
  $poll_id = $row['poll_id'];
?>
  <table border="0" cellspacing="0" cellpadding="1" bgcolor="#006699" width="400">
    <tr>
      <td>
       <table border="0" cellpadding="4" cellspacing="0" width="100%" align="center" bgcolor="#FFFFFF">
         <tr bgcolor="#006699">
           <td colspan="3"><font size="1" face="<?php echo $font_face; ?>" color="#FFFFFF"><b><?php echo $question; ?></b></font></td>
         </tr>
<?php
$i=0;
$poll_total = $db_connect->query("SELECT SUM(votes) AS total FROM $sql_data WHERE (poll_id = '$poll_id')");
$poll_sum = $db_connect->fetch_array($poll_total);
$db_connect->free_result($poll_total);
$data_result = $db_connect->query("SELECT * FROM $sql_data WHERE (poll_id = '$poll_id') order by votes desc");
$votes_total = ($poll_sum["total"]==0) ? 1 : $poll_sum["total"];
while ($data = $db_connect->fetch_array($data_result)) {
  if ($i == 0) {
    $maxvote = ($data["votes"]==0) ? 1 : $data["votes"];
    $i++;
  }
  $img_width = (int) ($data["votes"]*$img_length/$maxvote);
  $vote_val = sprintf("%.1f",($data['votes']*100/$votes_total))."%";
  echo "        <tr>
        <td><font face=\"$font_face\" color=\"$font_color\" size=\"1\">$data[option_text]</font></td>
        <td><font face=\"$font_face\" color=\"$font_color\" size=\"1\">$data[votes]</font></td>
        <td><font face=\"$font_face\" color=\"$font_color\" size=\"1\"><img src=\"$base_gif/$data[color].gif\" width=\"$img_width\" height=\"$img_height\"> $vote_val</font></td>
      </tr>\n";
}
?>
          <tr>
            <td><font face="<?php echo $font_face; ?>" color="<?php echo $font_color; ?>" size="1">Total votes:</font></td>
            <td><font face="<?php echo $font_face; ?>" size="1" color="#CC0000"><?php echo $poll_sum['total']; ?></font></td>
            <td><font size="1">Created <?php echo date("j-M-Y",$row['timestamp']); ?></font></td>
          </tr>
        </table>
      </td>
    </tr>
  </table><br><br>
<?php } ?>
 <font size="2" face="<?php echo $font_face; ?>"><a href="list.php">More Polls</a></font><br><br>
    <font face="Arial, Helvetica, sans-serif" size="1"><b><a href="http://www.proxy2.de" target="_blank"><font color="#dedfdf">Advanced Poll</font></a></b></font></td>
  </tr>
</table>

</body>
</html>