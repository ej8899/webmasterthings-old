<?php
///////////////////////////////////////////////////
//  Advanced Poll 1.61 (PHP/MySQL)               //
//  Copyright (c)2001 Chi Kien Uong              //
//  URL: http://www.proxy2.de                    //
///////////////////////////////////////////////////
$config_result = $db_connect->query("SELECT base_gif as base_gif, lang as lang FROM $sql_config WHERE (config_id = '1')");
$result = $db_connect->fetch_array($config_result);
$base_gif = $result["base_gif"];
include ("./lang/$result[lang]");
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
.exp_input {  font-family: "MS Sans Serif"; font-size: 9pt; height: 20px; width: 30px}
.button {  font-family: Arial, Helvetica, sans-serif; font-size: 9pt}
.select {  font-family: Arial, Helvetica, sans-serif; font-size: 9pt}
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
 document.form.question.value = trim(document.form.question.value);
 document.form.exp_time.value = trim(document.form.exp_time.value);
 document.forms[0].elements[2].value = trim(document.forms[0].elements[2].value);
 if (document.form.question.value == "") {
   alert('<?php echo $NewNoQue; ?>!');
   document.form.question.focus();
   return false;
 }
 if (document.forms[0].elements[2].value == "") {
   alert('<?php echo $NewNoOpt; ?>!');
   document.forms[0].elements[2].focus();
   return false;
 }
 if (document.form.expire.checked == false) {
   if(!(document.form.exp_time.value >= 0) || document.form.exp_time.value == "") {
     alert("<?php echo $SetEmpty; ?>");
     document.form.exp_time.focus();
     return false;
   }
 }
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
                  <td colspan="4" class="td1" height="30"><img src="<?php echo $base_gif; ?>/h_line.gif" width="15" height="18">&nbsp;
                    <?php echo $$message; ?>&nbsp;<img src="<?php echo $base_gif; ?>/h_line.gif" width="420" height="18">
                  </td>
                </tr>
                <tr>
                  <td width="25%" class="td1"><?php echo $IndexQuest; ?></td>
                  <td width="40%">
                    <input type="text" class="input" name="question" size="38" maxlength="100">
                  </td>
                  <td colspan="2" width="35%" class="select">
                    <select name="logging" class="select">
                      <option value="0" selected><?php echo $EditLgOff; ?></option>
                      <option value="1"><?php echo $EditLgOn; ?></option>
                    </select>
                  </td>
                </tr>
<?php
for ($i=1; $i < 11; $i++) {
  echo "    <tr>
                 <td width=\"25%\" class=\"td1\">$NewOption $i</td>
                 <td width=\"40%\">
                   <input type=\"text\" name=\"option_id[$i]\" size=\"38\" class=\"input\" maxlength=\"100\">
                 </td>
                 <td class=\"td2\" width=\"10%\">
                   <select class=\"select\" name=\"color[$i]\" onChange=\"javascript:ChangeBar(options[selectedIndex].value,$i)\">
                    <option value=\"blank\">---</option>\n";
for ($j=0; $j <sizeof($source_array); $j++) {
  echo "<option value=\"$source_array[$j]\">$color_array[$j]</option>\n";
}
echo "       </select></td>
      <td width=\"25%\" align=\"left\"><img src=\"$base_gif/blank.gif\" name=\"bar$i\" width=\"35\" height=\"12\"></td>
    </tr>\n";
}
?>
                <tr>
                  <td width="25%">&nbsp;</td>
                  <td colspan="3" height="35" class="td2">
                   <?php echo $EditStat; ?>:
                   <select name="status" class="select">
                    <option value="0"><?php echo $EditOff; ?></option>
                    <option value="1" selected><?php echo $EditOn; ?></option>
                    <option value="2"><?php echo $EditHide; ?></option>
                   </select>&nbsp;&nbsp;&nbsp;&nbsp;
                   <?php echo $IndexExp; ?>: <input type="text" name="exp_time" class="exp_input" size="4"> <?php echo $IndexDays; ?>                  
                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $IndexNever; ?> <input type="checkbox" name="expire" value="0" checked>
                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $EditCom; ?><input type="checkbox" name="comments" value="1">
                  </td>
                </tr>
                <tr>
                  <td width="25%">&nbsp;</td>
                  <td colspan="3" height="35">
                    <input class="button" type="submit" value="<?php echo $NewTitle; ?>" onclick="return CheckForm()">
                    <input class="button" type="reset" value="<?php echo $FormUndo; ?>">
                    <input type="hidden" name="action" value="create">
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
