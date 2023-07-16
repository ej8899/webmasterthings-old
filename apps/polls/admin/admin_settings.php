<?php
///////////////////////////////////////////////////
//  Advanced Poll 1.61 (PHP/MySQL)               //
//  Copyright (c)2001 Chi Kien Uong              //
//  URL: http://www.proxy2.de                    //
///////////////////////////////////////////////////
$varresult = $db_connect->query("SELECT * FROM $sql_config");
$vars = $db_connect->fetch_array($varresult);
while(list($var, $value) = each($vars)) {
  $$var = $value;
}
include ("./lang/$lang");
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
.input {  font-family: "MS Sans Serif"; font-size: 9pt; height: 20px}
.button {  font-family: Arial, Helvetica, sans-serif; font-size: 9pt}
.select {  font-family: Arial, Helvetica, sans-serif; font-size: 9pt}
-->
</style>
<script language="Javascript">
<!--
function trim(value) {
 startpos=0;
 while((value.charAt(startpos)==" ")&&(startpos<value.length)) {
   startpos++;
 }
 if(startpos==value.length) {
   value="";
 } else {
   value=value.substring(startpos,value.length);
   endpos=(value.length)-1;
   while(value.charAt(endpos)==" ") {
     endpos--;
   }
   value=value.substring(0,endpos+1);
 }
 return(value);
}
function CheckForm() {
 var found = 0;
 document.form.entry_pp.value = trim(document.form.entry_pp.value);
 if(!(document.form.entry_pp.value>0)) {
   alert('<?php echo $SetEmpty; ?>!');
   document.form.entry_pp.focus();
   found=1; 
 }
 for (i=0; i<document.forms[0].elements.length; i++) {
   document.forms[0].elements[i].value = trim(document.forms[0].elements[i].value);
   if (document.forms[0].elements[i].value == "") {
     alert('<?php echo $SetEmpty; ?>!');
     document.forms[0].elements[i].focus();
     found=1;
     break;
   }
 }
 return (found == 1) ? false : true;
}
// -->
</script>
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
            <form method="post" action="<?php echo $PHP_SELF; ?>" name="form">
              <table width="90%" border="0" cellspacing="0" cellpadding="2" align="center">
                <tr>
                  <td colspan="2" class="td1" height="30"><img src="<?php echo $base_gif; ?>/h_line.gif" width="15" height="18">&nbsp;
                  <?php echo $$message; ?>&nbsp;<img src="<?php echo $base_gif; ?>/h_line.gif" width="350" height="18">
                  </td>
                </tr>
                <tr>
                  <td width="27%" class="td2"><?php echo $SetURL; ?></td>
                  <td width="73%" class="td2">
                    <input type="text" name="base_gif" value="<?php echo $base_gif; ?>" class="input" size="38"> <?php echo $SetNo; ?>!
                  </td>
                </tr>
                <tr>
                  <td width="27%" class="td2"><?php echo $SetLang; ?></td>
                  <td width="73%" class="td2">
                    <input type="text" name="lang" class="input" value="<?php echo $lang; ?>" size="30">
                    <select name="lang_file" class="select" onChange="forms[0].lang.value=options[selectedIndex].value">
                      <option value="english.php" selected><?php echo $SetLang; ?></option>
<?php
chdir("./lang");
$hnd = opendir(".");
while ($file = readdir($hnd)) {
  if(is_file($file)) {
    $langlist[] = $file;
  }
}
closedir($hnd);
if ($langlist) {
  asort($langlist);
  while (list ($key, $file) = each ($langlist)) {
    if (ereg(".php|.php3",$file,$regs)) {
      echo "<option value=\"".$file."\">".str_replace("$regs[0]","","$file")."</option>\n";
    }
  }
}
?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td width="27%" class="td2"><?php echo $SetPoll; ?></td>
                  <td width="73%">
                    <input type="text" name="title" class="input" value="<?php echo htmlspecialchars($title); ?>" size="25">
                  </td>
                </tr>
                <tr>
                  <td width="27%" class="td2"><?php echo $SetButton; ?></td>
                  <td width="73%">
                    <input type="text" class="input" name="vote_button" value="<?php echo htmlspecialchars($vote_button); ?>" size="25">
                  </td>
                </tr>
                <tr>
                  <td width="27%" class="td2"><?php echo $SetResult; ?></td>
                  <td width="73%">
                    <input type="text" class="input" name="result_text" value="<?php echo htmlspecialchars($result_text); ?>" size="25">
                  </td>
                </tr>
                <tr>
                  <td width="27%" class="td2"><?php echo $StatTotal; ?></td>
                  <td width="73%">
                    <input type="text" class="input" name="total_text" value="<?php echo htmlspecialchars($total_text); ?>" size="25">
                  </td>
                </tr>
                <tr>
                  <td width="27%" class="td2"><?php echo $SetVoted; ?></td>
                  <td width="73%">
                    <input type="text" class="input" name="voted" value="<?php echo htmlspecialchars($voted); ?>" size="25">
                  </td>
                </tr>
                <tr>
                  <td width="27%" class="td2"><?php echo $SetComment; ?></td>
                  <td width="73%">
                    <input type="text" class="input" name="send_com" value="<?php echo htmlspecialchars($send_com); ?>" size="25">
                  </td>
                </tr>
                <tr>
                  <td colspan="2" class="td1"><img src="<?php echo $base_gif; ?>/h_line.gif" width="15" height="18">
                    <?php echo $SetOption; ?> <img src="<?php echo $base_gif; ?>/h_line.gif" width="350" height="18"></td>
                </tr>
                <tr>
                  <td width="27%" class="td2"><?php echo $SetTab; ?></td>
                  <td width="73%">
                    <input type="text" class="input" name="table_width" value="<?php echo $table_width; ?>" size="10">
                  </td>
                </tr>
                <tr>
                  <td width="27%" class="td2"><?php echo $SetBarh; ?></td>
                  <td width="73%">
                    <input type="text" class="input" name="img_height" value="<?php echo $img_height; ?>" size="10">
                  </td>
                </tr>
                <tr>
                  <td width="27%" class="td2"><?php echo $SetBarMax; ?></td>
                  <td width="73%">
                    <input type="text" class="input" name="img_length" value="<?php echo $img_length; ?>" size="10">
                  </td>
                </tr>
                <tr>
                  <td width="27%" class="td2"><?php echo $SetTabBg; ?></td>
                  <td width="73%">
                    <input type="text" class="input" name="bgcolor_tab" value="<?php echo $bgcolor_tab; ?>" size="10" maxlength="7">
                  </td>
                </tr>
                <tr>
                  <td width="27%" class="td2"><?php echo $SetFrmCol; ?></td>
                  <td width="73%">
                    <input type="text" class="input" name="bgcolor_fr" value="<?php echo $bgcolor_fr; ?>" size="10" maxlength="7">
                  </td>
                </tr>
                <tr>
                  <td width="27%" class="td2"><?php echo $SetFontCol; ?></td>
                  <td width="73%">
                    <input type="text" class="input" name="font_color" value="<?php echo $font_color; ?>" size="10" maxlength="7">
                  </td>
                </tr>
                <tr>
                  <td width="27%" class="td2"><?php echo $SetFace; ?></td>
                  <td width="73%">
                    <input type="text" class="input" name="font_face" value="<?php echo $font_face; ?>" size="35">
                  </td>
                </tr>
                <tr>
                  <td colspan="2" class="td1"><img src="<?php echo $base_gif; ?>/h_line.gif" width="15" height="18">
                    <?php echo $SetMisc; ?> <img src="<?php echo $base_gif; ?>/h_line.gif" width="400" height="18"></td>
                </tr>
                <tr>
                  <td width="27%" class="td2"><?php echo $SetShow; ?></td>
                  <td width="73%" class="td2">
                    <input type="radio" name="type" value="percent" <?php if ($type == "percent") echo "checked"; ?>> <?php echo $SetPerc; ?>
                    <input type="radio" name="type" value="votes" <?php if ($type == "votes") echo "checked"; ?>> <?php echo $SetVotes; ?></td>
                </tr>
                <tr>
                  <td width="27%" class="td2"><?php echo $SetCheck; ?></td>
                  <td width="73%" class="td2">
                    <select name="check_ip" class="select">
                      <option value="0" <?php if ($check_ip == 0) echo "selected"; ?>><?php echo $SetNoCheck; ?></option>
                      <option value="2" <?php if ($check_ip == 2) echo "selected"; ?>><?php echo $SetIP; ?></option>
                    </select>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $SetTime; ?>
                    <input type="text" class="input" name="lock_timeout" value="<?php echo $lock_timeout; ?>" size="4">&nbsp;<?php echo $SetHours; ?></td>
                </tr>
                <tr>
                  <td width="27%" class="td2"><?php echo $SetOffset; ?></td>
                  <td width="73%" class="td2">
                    <input type="text" class="input" name="time_offset" value="<?php echo $time_offset; ?>" size="4"> <?php echo $SetHours; ?> </td>
                </tr>
                <tr>
                  <td width="27%" class="td2"><?php echo $SetEntry; ?></td>
                  <td width="73%" class="td2">
                    <input type="text" class="input" name="entry_pp" value="<?php echo $entry_pp; ?>" size="4"></td>
                </tr>
                <tr>
                  <td width="27%">&nbsp;</td>
                  <td height="35" width="73%">
                    <input type="submit" value="<?php echo $SetSubmit; ?>" class="button" onclick="return CheckForm()">
                    <input type="reset" value="<?php echo $FormUndo; ?>" class="button">
                    <input type="hidden" name="action" value="update">
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
