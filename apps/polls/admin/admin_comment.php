<?php
///////////////////////////////////////////////////
//  Advanced Poll 1.61 (PHP/MySQL)               //
//  Copyright (c)2001 Chi Kien Uong              //
//  URL: http://www.proxy2.de                    //
///////////////////////////////////////////////////
$poll_result = $db_connect->query("SELECT * FROM $sql_index WHERE (poll_id = '$poll_id')");
$record = $db_connect->fetch_array($poll_result);
$question = htmlspecialchars($record['question']);
$db_connect->free_result($poll_result);

$config_result = $db_connect->query("SELECT base_gif as base_gif, time_offset as time_offset, lang as lang, entry_pp as entry_pp FROM $sql_config WHERE (config_id = '1')");
$record = $db_connect->fetch_array($config_result);
$time_offset = $record["time_offset"]*3600;
$base_gif = $record["base_gif"];
$lang = $record["lang"];
$entry_pp = $record["entry_pp"];
$db_connect->free_result($config_result);

$sql_result = $db_connect->query("select count(*) as total from $sql_com WHERE (poll_id = '$poll_id')");
$db_connect->fetch_array($sql_result);
$total = $db_connect->record['total'];
$db_connect->free_result($sql_result);

include ("./lang/$lang");

if(!isset($entry)) {
  $entry = 0;
}
$next_page = $entry+$entry_pp;
$prev_page = $entry-$entry_pp;
$navigation ='';
if ($prev_page >= 0) {
  $navigation = "   <img src=\"$base_gif/back.gif\" width=\"16\" height=\"14\">&nbsp;<a href=\"$PHP_SELF?log_in=$log_in&action=comments&id=$poll_id&entry=$prev_page\">$NavPrev</a>\n";
}
if ($next_page < $total) {
  $navigation = $navigation. " &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"$PHP_SELF?log_in=$log_in&action=comments&id=$poll_id&entry=$next_page\">$NavNext</a>&nbsp;<img src=\"$base_gif/next.gif\" width=\"16\" height=\"14\">\n";
}
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
 if (window.confirm("<?php echo $ComDel; ?>")) {
    window.location.href = "http://"+window.location.host+window.location.pathname+"?log_in=<?php echo $log_in; ?>&action=remove&id=<?php echo $poll_id; ?>&mess_id="+entry+"&no_cache="+Math.random()
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
            <table border="0" cellspacing="1" cellpadding="3" width="100%">
              <tr> 
                <td class="td1" colspan="3" height="30">
                  <img src="<?php echo $base_gif; ?>/h_line.gif" width="15" height="18">&nbsp;<?php echo $question; ?>&nbsp;<img src="<?php echo $base_gif; ?>/h_line.gif" width="250" height="18"></td>
              </tr>
              <tr> 
                <td width="200" class="td2"><?php echo $ComTotal; ?>: <b><font color="#006699"><?php echo $total; ?></font></b></td>
                <td colspan="2" class="td2" align="right"><?php echo $navigation; ?></td>
              </tr>
              <tr>
                <td width="200" bgcolor="#999999" class="td2"><b><?php echo $ComName; ?></b></td>
                <td width="457" class="td2" bgcolor="#999999" valign="top"><b><?php echo $IndexCom; ?></b></td>
                <td width="66" class="td2" bgcolor="#999999" valign="top">&nbsp;</td>
              </tr>
<?php
$results = $db_connect->query("select * from $sql_com WHERE (poll_id = '$poll_id') order by com_id desc limit $entry, $entry_pp");
while ($row = $db_connect->fetch_array($results)) {
  $date = date("j-M-Y H:i",$row['time']+$time_offset);
  $row['message'] = nl2br($row['message']);
  echo "              <tr>
                <td width=\"200\" bgcolor=\"#CCCCCC\" valign=\"top\"> 
                  <table width=\"200\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\">
                    <tr> 
                      <td><img src=\"$base_gif/host.gif\" width=\"16\" height=\"15\">";
      if (eregi("Opera",$row['browser'])) {
        $image = "$base_gif/opera.gif";
      } elseif (eregi("MSIE",$row['browser'])) {
        $image = "$base_gif/msie.gif";
      } elseif (eregi("Mozilla",$row['browser'])) {
        $image = "$base_gif/netscape.gif";
      } else {
        $image = "$base_gif/unknown.gif";	
      }
      echo "                      <img src=\"$image\" width=\"16\" height=\"16\" alt=\"$row[browser]\">\n";
      if ($row['email']) {
        echo "                        <a href=\"mailto:$row[email]\"><img src=\"$base_gif/email.gif\" width=\"15\" height=\"15\" border=\"0\" alt=\"$row[email]\"></a>\n";
      }
      echo "                     </td>
                    </tr>
                    <tr><td class=\"td2\"><font color=\"#990033\">$row[name]</font></td></tr>
                    <tr><td class=\"td2\">$row[host]</td></tr>
                  </table>
                </td>
                <td width=\"457\" class=\"td2\" bgcolor=\"#E6E6E6\" valign=\"top\"><img src=\"$base_gif/post.gif\" width=\"9\" height=\"9\">$ComPost: $date 
                  <hr size=\"1\" noshade>$row[message]
                </td>
                <td width=\"66\" class=\"td2\" align=\"center\"><a href=\"javascript:del_entry($row[com_id])\">$IndexDel</a></td>
              </tr>\n";
}
?>
              <tr bgcolor="#CCCCCC"> 
                <td width="200" class="td2"><?php echo $SetEntry; ?>: <b><font color="#006699"><?php echo $entry_pp; ?></font></b></td>
                <td colspan="2" class="td2" align="right">&nbsp;<?php echo $navigation; ?></td>
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
