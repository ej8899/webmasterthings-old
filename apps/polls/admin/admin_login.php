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
.td1 {  font-family: "MS Sans Serif"; font-size: 9pt}
.button {  font-family: "MS Sans Serif"; font-size: 9pt; height: 22px; width: 75px}
.input {  font-family: "MS Sans Serif"; font-size: 9pt; height: 22px; width: 200px}
-->
</style>
<SCRIPT LANGUAGE="JavaScript">
<!--
function set_focus() {
  document.pass.username.focus();
}
// -->
</SCRIPT>
</head>
<body bgcolor="#3A6EA5" onload="set_focus()">
<br>
<br>
<br>
<br>
<table border="1" cellspacing="0" cellpadding="0" align="center" width="450">
  <tr bgcolor="#C6C3C6">
    <td>
      <table width="450" border="0" cellspacing="0" cellpadding="1" align="center">
        <tr bgcolor="#400080">
          <td height="20" class="td1" bgcolor="#000084"><b><font color="#FFFFFF">
            &nbsp;Advanced Poll <?php echo $poll_version; ?></font></b></td>
          <td height="20" class="td1" align="right" bgcolor="#000084"><img src="<?php echo $base_gif; ?>/help.gif" width="16" height="14">
            <img src="<?php echo $base_gif; ?>/cross.gif" width="16" height="14"> </td>
        </tr>
        <tr align="center">
          <td colspan="2">
            <form method="post" name="pass" action="<?php echo $PHP_SELF; ?>">
              <table border="0" cellspacing="0" cellpadding="1" width="100%">
                <tr>
                  <td rowspan="3" valign="top" align="right" width="12%"><img src="<?php echo $base_gif; ?>/key.gif" width="35" height="40">
                  </td>
                  <td colspan="2" class="td1" height="42"><?php echo $$message; ?></td>
                </tr>
                <tr>
                  <td class="td1" width="18%"><?php echo $PwdUser; ?></td>
                  <td width="70%">
                    <input type="text" name="username" size="25" class="input">
                  </td>
                </tr>
                <tr>
                  <td class="td1" height="35" width="18%"><?php echo $PwdPass; ?></td>
                  <td height="35" width="70%">
                    <input type="password" name="password" size="25" class="input">
                    <input type="hidden" name="enter" value="1">
                  </td>
                </tr>
              </table>
              <table width="100%" border="0" cellspacing="0" cellpadding="1">
                <tr>
                  <td align="right" width="47%">
                    <input type="submit" value="   <?php echo $FormOK; ?>   " class="button">
                  </td>
                  <td align="right" width="1%">&nbsp;</td>
                  <td width="52%">
                    <input type="reset" value="<?php echo $FromClear; ?>" class="button">
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
<br>
</body>
</html>
