<?php
///////////////////////////////////////////////////
//  Advanced Poll 1.61 (PHP/MySQL)               //
//  Copyright (c)2001 Chi Kien Uong              //
//  URL: http://www.proxy2.de                    //
///////////////////////////////////////////////////
$config_result = $db_connect->query("SELECT base_gif as base_gif, time_offset as time_offset, lang as lang FROM $sql_config WHERE (config_id = '1')");
$result = $db_connect->fetch_array($config_result);
$time_offset = $result["time_offset"]*3600;
$base_gif = $result["base_gif"];
$db_connect->free_result($config_result);
$sql_result = $db_connect->query("select count(*) as total from $sql_index");
$db_connect->fetch_array($sql_result);
$total = $db_connect->record['total'];
$db_connect->free_result($sql_result);
include ("./lang/$result[lang]");
if(!isset($entry)) {
  $entry = 0;
}
$next_page = $entry+20;
$prev_page = $entry-20;
$navigation ='';
if ($prev_page >= 0) {
  $navigation = "   <img src=\"$base_gif/back.gif\" width=\"16\" height=\"14\">&nbsp;<a href=\"$PHP_SELF?log_in=$log_in&entry=$prev_page\">$NavPrev</a>\n";
}
if ($next_page < $total) {
  $navigation = $navigation. " &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"$PHP_SELF?log_in=$log_in&entry=$next_page\">$NavNext</a>&nbsp;<img src=\"$base_gif/next.gif\" width=\"16\" height=\"14\">\n";
}
$results = $db_connect->query("select * from $sql_index order by poll_id desc limit $entry, 20");
list($wday,$mday,$month,$year,$hour,$minutes) = split("( )",date("w j n Y H i",time()+$time_offset));
$newdate = "$weekday[$wday], $mday ".$months[$month-1]." $year $hour:$minutes";
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
?>
<html>
<head>
<title>Advanced Poll <?php echo $poll_version; ?></title>
<?php echo $charset; ?>
<style type="text/css">
<!--
a {text-decoration: none}
.td1 {  font-family: "MS Sans Serif"; font-size: 10pt}
.td2 {  font-family: "MS Sans Serif"; font-size: 9pt}
a:hover {  color: #FF0033; text-decoration: underline}
-->
</style>
<script language="Javascript">
<!--
function del_entry(entry) {
 if (window.confirm("<?php echo $Confirm; ?>")) {
    window.location.href = "http://"+window.location.host+window.location.pathname+"?log_in=<?php echo $log_in; ?>&action=delete&id="+entry+"&no_cache="+Math.random()
 }
}
// -->
</script>
</head>
<body bgcolor="#3A6EA5" link="#000000" vlink="#000000">
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
            <table border="0" cellspacing="0" cellpadding="4" align="center" width="100%">
              <tr>
                <td colspan="5" class="td1"><img src="<?php echo $base_gif; ?>/h_line.gif" width="15" height="18">
                  <?php echo $IndexTitle; ?> <img src="<?php echo $base_gif; ?>/h_line.gif" width="300" height="18"></td>
                <td colspan="3" class="td2" align="right"><?php echo $newdate; ?></td>
              </tr>
              <tr>
                <td bgcolor="#9999CC">&nbsp;</td>
                <td class="td2" bgcolor="#9999CC"><b><?php echo $IndexQuest; ?></b></td>
                <td class="td2" bgcolor="#9999CC"><b><?php echo $IndexID; ?></b></td>
                <td class="td2" bgcolor="#9999CC"><b><?php echo $StatCrea; ?></b></td>
                <td class="td2" bgcolor="#9999CC"><b><?php echo $IndexDays; ?></b></td>
                <td class="td2" bgcolor="#9999CC"><b><?php echo $IndexExp; ?></b></td>
                <td class="td2" bgcolor="#9999CC"><b><?php echo $IndexStat; ?></b></td>
                <td class="td2" bgcolor="#9999CC"><b><?php echo $IndexAct; ?></b></td>
              </tr>
<?php
while ($row = $db_connect->fetch_array($results)) {
  $question = htmlspecialchars($row['question']);
  $date = date("j-M-Y",$row['timestamp']+$time_offset);
  if ($row['expire']==0) {
    $exp_date = "<font color=\"#0000FF\">$IndexNever</font>";
  } else {
    $exp_date = (time()>$row['exp_time']) ? "<font color=\"#FF6600\">$IndexExpire</font>" : date("j-M-Y",$row['exp_time']+$time_offset)." (<font color=\"#FF0000\">".round(($row["exp_time"]-time())/86400)."</font>)";
  }
  $days = (int) ((time()-$row['timestamp']+$time_offset)/86400);
  if ($row['status'] == 1) {
    $image = "$base_gif/folder.gif";
    $alt = "$EditOn";
  } elseif ($row['status'] == 2) {
    $image = "$base_gif/hidden.gif";
    $alt = "$EditHide";
  } else {
    $image = "$base_gif/lock.gif";
    $alt = "$EditOff";
  }
  $alt = htmlspecialchars($alt);
  $image2 = ($row['logging'] == 1) ? "$base_gif/log.gif" : "$base_gif/log_off.gif";
  $image3 = ($row['comments'] == 1) ? "$base_gif/reply.gif" : "$base_gif/co_dis.gif";
  echo "              <tr>
                <td align=\"center\" bgcolor=\"#E6E6E6\"><img src=\"$image\" width=\"13\" height=\"16\" alt=\"$alt\"></td>
                <td class=\"td2\" bgcolor=\"#E6E6E6\"><a href=\"$PHP_SELF?log_in=$log_in&amp;action=edit&amp;id=$row[poll_id]\"><acronym title=\"$EditText\">$question</acronym></a></td>
                <td class=\"td2\" bgcolor=\"#CCCCCC\">$row[poll_id]</td>
                <td class=\"td2\" bgcolor=\"#E6E6E6\">$date</td>
                <td class=\"td2\" bgcolor=\"#CCCCCC\">$days</td>
                <td class=\"td2\" bgcolor=\"#E6E6E6\">$exp_date</td>
                <td class=\"td2\" align=\"center\" bgcolor=\"#CCCCCC\"><a href=\"$PHP_SELF?log_in=$log_in&amp;action=stats&amp;id=$row[poll_id]\"><img src=\"$image2\" width=\"16\" height=\"16\" border=\"0\" alt=\"$IndexStat\"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <a href=\"$PHP_SELF?log_in=$log_in&amp;action=comments&amp;id=$row[poll_id]\"><img src=\"$image3\" width=\"18\" height=\"18\" border=\"0\" alt=\"$IndexCom\"></a></td></td>
                <td class=\"td2\" bgcolor=\"#E6E6E6\"><a href=\"javascript:del_entry($row[poll_id])\">$IndexDel</a></td>
              </tr>\n";
}
?>
              <tr>
                <td align="right"><img src="<?php echo $base_gif; ?>/ip.gif" width="16" height="16"></td>
                <td class="td2"><?php echo $sql_username."@".$sql_hostname; ?></td>
                <td colspan="6" align="right" class="td2">&nbsp;<?php echo $navigation; ?></td>
              </tr>
            </table>
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
