<?php
///////////////////////////////////////////////////
//  Advanced Poll 1.61 (PHP/MySQL)               //
//  Copyright (c)2001 Chi Kien Uong              //
//  URL: http://www.proxy2.de                    //
///////////////////////////////////////////////////
$poll_result = $db_connect->query("SELECT * FROM $sql_index WHERE (poll_id = '$poll_id')");
$row = $db_connect->fetch_array($poll_result);
$logging = $row["logging"];
$db_connect->free_result($poll_result);
$config_result = $db_connect->query("SELECT base_gif as base_gif, time_offset as time_offset, lang as lang FROM $sql_config WHERE (config_id = '1')");
$result = $db_connect->fetch_array($config_result);
$time_offset = $result["time_offset"]*3600;
$base_gif = $result["base_gif"];
$db_connect->free_result($config_result);
$poll_total = $db_connect->query("SELECT SUM(votes) AS total FROM $sql_data WHERE (poll_id = '$poll_id')");
$poll_sum = $db_connect->fetch_array($poll_total);
$db_connect->free_result($poll_total);
include ("./lang/$result[lang]");
list($wday,$mday,$month,$year,$hour,$minutes) = split("( )",date("w j n Y H i",$row['timestamp']+$time_offset));
$newdate = "$weekday[$wday], $mday ".$months[$month-1]." $year $hour:$minutes";
?>
<html>
<head>
<title>Advanced Poll <?php echo $poll_version; ?></title>
<?php echo $charset; ?>
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Expires" content="-1">
<style type="text/css">
<!--
.td1 {  font-family: "MS Sans Serif"; font-size: 10pt}
.td2 {  font-family: "MS Sans Serif"; font-size: 9pt}
-->
</style>
</head>
<body bgcolor="#3A6EA5">
<table border="1" cellspacing="0" cellpadding="0" align="center" width="750">
  <tr bgcolor="#C6C3C6" valign="top">
    <td>
      <table width="750" border="0" cellspacing="0" cellpadding="1" align="center">
        <tr bgcolor="#400080">
          <td height="20" class="td2" bgcolor="#000084"><b><font color="#FFFFFF">
            &nbsp;Advanced Poll <?php echo $poll_version; ?></font></b></td>
          <td height="20" align="right" bgcolor="#000084"><img src="<?php echo $base_gif; ?>/min.gif" width="16" height="14"><img src="<?php echo $base_gif; ?>/max.gif" width="16" height="14">&nbsp;<img src="<?php echo $base_gif; ?>/cross.gif" width="16" height="14"></td>
        </tr>
        <tr valign="top">
          <td colspan="2">
            <table border="0" cellspacing="0" cellpadding="1">
              <tr>
                <td colspan="7"><img src="<?php echo $base_gif; ?>/top_line.gif" width="745" height="3"></td>
              </tr>
              <tr>
                <td align="center" rowspan="2" width="7"><img src="<?php echo $base_gif; ?>/v_line.gif" width="5" height="50"></td>
                <td align="center" width="112"><a href="<?php echo "$PHP_SELF"."?log_in=$log_in&"; ?>action=show"><img src="<?php echo $base_gif; ?>/index.gif" width="32" height="32" border="0" alt="<?php echo $IndexTitle; ?>"></a></td>
                <td align="center" width="122"><a href="<?php echo "$PHP_SELF"."?log_in=$log_in&"; ?>action=new"><img src="<?php echo $base_gif; ?>/new.gif" width="32" height="32" border="0" alt="<?php echo $NewTitle; ?>"></a></td>
                <td align="center" width="156"><a href="<?php echo "$PHP_SELF"."?log_in=$log_in&"; ?>action=settings&amp;panel=general"><img src="<?php echo $base_gif; ?>/settings.gif" width="32" height="32" border="0" alt="<?php echo $SetTitle; ?>"></a></td>
                <td align="center" width="124"><a href="<?php echo "$PHP_SELF"."?log_in=$log_in&"; ?>action=settings&amp;panel=password"><img src="<?php echo $base_gif; ?>/password.gif" width="32" height="32" border="0" alt="<?php echo $PwdTitle; ?>"></a></td>
                <td align="center" width="91"><a href="<?php echo "$PHP_SELF"."?log_in=$log_in&"; ?>action=help"><img src="<?php echo $base_gif; ?>/howto.gif" width="32" height="32" border="0" alt="<?php echo $Help; ?>"></a></td>
                <td align="center" width="129"><a href="<?php echo "$PHP_SELF"."?log_in=$log_in&"; ?>action=logout"><img src="<?php echo $base_gif; ?>/logout.gif" width="32" height="32" border="0" alt="<?php echo $Logout; ?>"></a></td>
              </tr>
              <tr align="center" valign="top">
                <td width="112" class="td2"><?php echo $IndexTitle; ?></td>
                <td width="122" class="td2"><?php echo $NewTitle; ?></td>
                <td width="156" class="td2"><?php echo $SetTitle; ?></td>
                <td width="124" class="td2"><?php echo $PwdTitle; ?></td>
                <td width="91" class="td2"><?php echo $Help; ?></td>
                <td width="129" class="td2"><?php echo $Logout; ?></td>
              </tr>
              <tr align="left">
                <td colspan="7"><img src="<?php echo $base_gif; ?>/top_line.gif" width="745" height="3"></td>
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="3">
              <tr>
                <td colspan="2" class="td1"><img src="<?php echo $base_gif; ?>/h_line.gif" width="15" height="18">
                  <?php echo $IndexStat; ?> <img src="<?php echo $base_gif; ?>/h_line.gif" width="500" height="18"></td>
              </tr>
              <tr>
                <td colspan="2"><b class="td1"><?php echo htmlspecialchars($row['question']); ?></b></td>
              </tr>
              <tr>
                <td colspan="2">
                  <table border="0" cellspacing="0" cellpadding="2" width="300">
                    <tr>
                      <td colspan="2"><img src="<?php echo $base_gif; ?>/top_line.gif" width="300" height="3"></td>
                    </tr>
                    <tr>
                      <td width="152" class="td2"><?php echo $IndexID; ?>: </td>
                      <td width="169" class="td2"><font color="#000099"><?php echo ($row['poll_id']); ?></font></td>
                    </tr>
                    <tr>
                      <td width="152" class="td2"><?php echo $StatCrea; ?>:</td>
                      <td width="169" class="td2"><font color="#000099"><?php echo $newdate; ?></font></td>
                    </tr>
                    <tr>
                      <td width="152" class="td2"><?php echo $StatAct; ?>:</td>
                      <td width="169" class="td2"><font color="#000099"><?php $hours = (int) ((time()-$row['timestamp']+$time_offset)/3600); $days = (int) ($hours/24); $remain = $hours%24; echo "$days $IndexDays, $remain $SetHours"; ?></font></td>
                    </tr>
                    <tr>
                      <td width="152" class="td2"><?php echo $StatTotal; ?>:</td>
                      <td width="169" class="td2"><font color="#000099"><?php echo $poll_sum["total"]; ?></font></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="td2"><b><?php print ($logging ==1) ? "<a href=\"$PHP_SELF?log_in=$log_in&action=reset&amp;id=$poll_id\"><font color=\"#990000\">$StatReset</font></a>" : "- $StatDis -"; ?></b></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="td2"><img src="<?php echo $base_gif; ?>/top_line.gif" width="300" height="3"></td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="3">
<?php
$result = $db_connect->query("select * from $sql_data where (poll_id = '$poll_id') order by option_id asc");
while ($data = $db_connect->fetch_array($result)) {
  $percent = ($poll_sum['total'] == 0) ? "0%" : sprintf("%.2f",($data['votes']*100/$poll_sum['total']))."%";
  $perday = ($days>0) ? sprintf("%.1f",($data["votes"]/$days)) : $data["votes"];
  echo "              <tr>
                <td colspan=\"4\" class=\"td2\"><b>$NewOption $data[option_id]: $data[option_text]</b></td>
              </tr>
              <tr>
                <td colspan=\"2\" class=\"td2\">- $SetVotes: <font color=\"#CC0000\">$data[votes]</font> ($percent)</td>
                <td colspan=\"2\" class=\"td2\">- <font color=\"#0000FF\">$perday</font> $StatDay</td>
              </tr>\n";
  if ($logging == 1) {
    $log_result = $db_connect->query("select * from $sql_log where (poll_id = '$poll_id' and option_id = '$data[option_id]')");
    $row = $db_connect->num_rows($log_result);
    if ($row != 0) {
      echo "              <tr bgcolor=\"#CC9999\" class=\"td2\">
                  <td width=\"15%\" class=\"td2\">$IndexDate</td>
                  <td width=\"13%\" class=\"td2\">IP</td>
                  <td width=\"22%\" class=\"td2\">Host</td>
                  <td width=\"50%\" class=\"td2\">Browser</td>
                </tr>\n";
      while ($log_data = $db_connect->fetch_array($log_result)) {
        echo "        <tr>
                  <td width=\"15%\" class=\"td2\">".date("j-M-Y H:i",$log_data['timestamp']+$time_offset)."</td>
                  <td width=\"13%\" class=\"td2\">$log_data[ip_addr]</td>
                  <td width=\"22%\" class=\"td2\">$log_data[host]</td>
                  <td width=\"50%\" class=\"td2\">$log_data[agent]</td>
                </tr>\n";
      }
    }
  }
}
?>          </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<br>
<br>
</body>
</html>
