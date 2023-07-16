<?php
///////////////////////////////////////////////////
//  Advanced Poll 1.61 (PHP/MySQL)               //
//  Copyright (c)2001 Chi Kien Uong              //
//  URL: http://www.proxy2.de                    //
///////////////////////////////////////////////////
$poll_result = $db_connect->query("SELECT * FROM $sql_index WHERE (poll_id = '$entry_id')");
$row = $db_connect->fetch_array($poll_result);
$question = htmlspecialchars($row['question']);
$db_connect->free_result($poll_result);
$config_result = $db_connect->query("SELECT base_gif as base_gif, lang as lang FROM $sql_config WHERE (config_id = '1')");
$result = $db_connect->fetch_array($config_result);
$base_gif = $result["base_gif"];
$db_connect->free_result($config_result);
include ("./lang/$result[lang]");
$result = $db_connect->query("select * from $sql_data where (poll_id = '$entry_id') order by option_id asc");
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
.td1 {  font-family: "MS Sans Serif"; font-size: 10pt}
.td2 {  font-family: "MS Sans Serif"; font-size: 9pt}
.input {  font-family: "MS Sans Serif"; font-size: 9pt; height: 20px; width: 350px}
.exp_input {  font-family: "MS Sans Serif"; font-size: 9pt; height: 20px; width: 25px}
.button {  font-family: Arial, Helvetica, sans-serif; font-size: 9pt}
.input2 {  font-family: "MS Sans Serif"; font-size: 9pt; height: 20px; width: 80px}
.select {  font-family: Arial, Helvetica, sans-serif; font-size: 9pt}
a:hover {  color: #FF0033; text-decoration: underline}
-->
</style>
<script language="JavaScript">
<!--
blank = new Image(); blank.src = "<?php echo $base_gif; ?>/blank.gif";
<?php
$source_array = array(
  "aqua","blue","brown","darkgreen","gold","green","grey","orange","pink","purple","red","yellow"
);
for ($i=0;$i<sizeof($source_array); $i++) {
  echo "$source_array[$i] = new Image(); $source_array[$i].src = \"$base_gif/$source_array[$i].gif\";\n";
}
?>

function ChangeBar(sel,img) {
  eval("document.bar"+img+".src="+sel+".src");
}

function ResetPoll() {
  for (i=4; i<document.forms[0].elements.length-6; i+=3) {
   document.forms[0].elements[i].value = '0';
  }
}

function CheckDays() {
  if(!(document.poll.exp_time.value >= 0)) {
    alert("<?php echo $SetEmpty; ?>");
    document.poll.exp_time.focus();
    return false;
  }
}
//-->
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
            <form method="post" action="<?php echo $PHP_SELF; ?>" name="poll">
              <table border="0" cellspacing="0" cellpadding="2" align="center" width="90%">
                <tr>
                  <td colspan="5" class="td1" height="30"><img src="<?php echo $base_gif; ?>/h_line.gif" width="15" height="18">&nbsp;
                    <?php echo $$message; ?>&nbsp;<img src="<?php echo $base_gif; ?>/h_line.gif" width="380" height="18">
                  </td>
                </tr>
                <tr>
                  <td width="20%" class="td1"><?php echo $IndexQuest; ?></td>
                  <td width="49%">
                    <input type="text" name="question" class="input" size="35" value="<?php echo $question; ?>">
                  </td>
                  <td width="11%" class="td2">
                    <select name="status" class="select">
                      <option value="0" <?php if ($row['status'] == 0) echo "selected"; ?>><?php echo $EditOff; ?></option>
                      <option value="1" <?php if ($row['status'] == 1) echo "selected"; ?>><?php echo $EditOn; ?></option>
                      <option value="2" <?php if ($row['status'] == 2) echo "selected"; ?>><?php echo $EditHide; ?></option>
                    </select>
                  </td>
                  <td colspan="2" class="td2">
                    <select name="logging" class="select">
                      <option value="0" <?php if ($row['logging'] == 0) echo "selected"; ?>><?php echo $EditLgOff; ?></option>
                      <option value="1" <?php if ($row['logging'] == 1) echo "selected"; ?>><?php echo $EditLgOn; ?></option>
                    </select>
                  </td>
                </tr>
<?php
$i=1;
while ($data = $db_connect->fetch_array($result)) {
  $i++;
  $data["option_text"] = htmlspecialchars($data["option_text"]);
  echo "         <tr>
                  <td width=\"20%\" class=\"td1\">$NewOption $data[option_id]</td>
                  <td width=\"49%\">
                    <input type=\"text\" name=\"option_id[$data[option_id]]\" size=\"35\" class=\"input\" value=\"$data[option_text]\">
                  </td>
                  <td width=\"11%\" class=\"td2\">
                    <input type=\"text\" name=\"votes[$data[option_id]]\" class=\"input2\" size=\"10\" value=\"$data[votes]\">
                  </td>
                  <td width=\"11%\" class=\"td2\">
                   <select name=\"color[$data[option_id]]\" class=\"select\" onChange=\"javascript:ChangeBar(options[selectedIndex].value,$data[option_id])\">
                   <option value=\"blank\">---</option>\n";
  for ($j=0; $j<sizeof($source_array); $j++) {
    if ($data["color"] == $source_array["$j"]) {
      echo "<option value=\"$source_array[$j]\" selected>$color_array[$j]</option>\n";
    } else {
      echo "<option value=\"$source_array[$j]\">$color_array[$j]</option>\n";
    }
  }
  echo "          </select>
                  </td>
                  <td width=\"9%\"><img src=\"$base_gif/$data[color].gif\" name=\"bar$data[option_id]\" width=35 height=12></td>
                </tr>\n";
}
$expiration = round (($row['exp_time']-time())/86400);
if ($expiration<=0) {
  $expiration = 0;
}
?>
                <tr>
                  <td width="20%">&nbsp;</td>
                  <td colspan="4" height="35" class="td2" valign="top"><?php echo $IndexExp; ?>: <input type="text" name="exp_time" class="exp_input" size="3" value="<?php echo $expiration; ?>"> <?php echo $IndexDays; ?>                  
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $IndexNever; ?> <input type="checkbox" name="expire" value="0" <?php if ($row['expire'] == 0) echo "checked"; ?>>
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="<?php echo $base_gif; ?>/point2.gif" width="9" height="9"><?php echo $EditDel; ?>
                </tr>
                <tr>
                  <td width="20%">&nbsp;</td>
                  <td colspan="4" height="35" class="td2" valign="top">
                    <img src="<?php echo $base_gif; ?>/h_line.gif" width="30" height="18">
                    <a href="<?php echo "$PHP_SELF"."?log_in=$log_in&"; ?>action=extend&amp;id=<?php echo $entry_id; ?>"><?php echo $EditAdd; ?></a> <img src="<?php echo $base_gif; ?>/h_line.gif" width="50" height="18">
                    <a href="javascript:ResetPoll()"><?php echo $EditReset; ?></a> <img src="<?php echo $base_gif; ?>/h_line.gif" width="30" height="18">
                    &nbsp;&nbsp;&nbsp;<?php echo $EditCom; ?>&nbsp;<input type="checkbox" name="comments" value="1" <?php if ($row['comments'] == 1) echo "checked"; ?>></td>
                </tr>
                <tr>
                  <td width="20%">&nbsp;</td>
                  <td colspan="4">
                    <input type="submit" value="<?php echo $EditSave; ?>" class="button" onclick="return CheckDays()">
                    <input type="reset" value="<?php echo $FormUndo; ?>" class="button">
                    <input type="hidden" name="action" value="save">
                    <input type="hidden" name="id" value="<?php echo $entry_id; ?>">
                    <input type="hidden" name="log_in" value="<?php echo $log_in; ?>">
                  </td>
                </tr>
              </table>
            </form>
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
