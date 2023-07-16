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
.code {  font-family: "Courier New", Courier, mono; font-size: 9pt; font-weight: normal; height: 200px; width: 600px;; background-color: #C6C3C6}
.code2 {  font-family: "Courier New", Courier, mono; font-size: 9pt; height: 90px; width: 600px; background-color: #C6C3C6}
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
            <form method="post" action="<?php echo $PHP_SELF; ?>" name="form">
              <table border="0" cellspacing="0" cellpadding="3" align="center" width="680">
                <tr>
                  <td class="td1"><img src="<?php echo $base_gif; ?>/h_line.gif" width="15" height="18">
                   <?php echo $Help; ?> <img src="<?php echo $base_gif; ?>/h_line.gif" width="550" height="18"></td>
                </tr>
                <tr>
                  <td class="td2">Advanced Poll <?php echo $poll_version; ?><br>
                    Copyright &copy;2001<br>
                    Author: Chi Kien Uong<br>
                    URL: <a href="http://www.proxy2.de" target="_blank">http://www.proxy2.de</a><br>
                    <a href="<?php echo "$PHP_SELF"."?log_in=$log_in&"; ?>action=license"><?php echo $License; ?></a></td>
                </tr>
                <tr>
                  <td><img src="<?php echo $base_gif; ?>/h_line.gif" width="600" height="18"></td>
                </tr>
                <tr>
                  <td class="td2"><?php echo $HelpPoll; ?>:</td>
                </tr>
                <tr>
                  <td>
                    <textarea cols="72" rows="12" class="code" wrap="VIRTUAL">
<?php
if (eregi("WIN",PHP_OS)) {
  $path = str_replace("\\","/",$path);
}
?>
&lt;?php
// this code snippet is optional
require (&quot;<?php echo $path; ?>/poll_cookie.php&quot;);
?&gt;
&lt;html&gt;
&lt;body bgcolor=&quot;#ffffff&quot;&gt;
&lt;?php
$poll_id = xx;
require (&quot;<?php echo $path; ?>/booth.php&quot;);
?&gt;
&lt;/body&gt;
&lt;/html&gt;</textarea>
                  </td>
                </tr>
                <tr>
                  <td><img src="<?php echo $base_gif; ?>/h_line.gif" width="600" height="18"></td>
                </tr>
                <tr>
                  <td class="td2"><?php echo $HelpRand; ?></td>
                </tr>
                <tr>
                  <td>
                    <textarea cols="72" rows="6" wrap="VIRTUAL" class="code2">&lt;?php
$random_poll = 1;
require(&quot;<?php echo $path; ?>/booth.php&quot;);
?&gt;
</textarea>
                    <br>
                  </td>
                </tr>
                <tr>
                  <td><img src="<?php echo $base_gif; ?>/h_line.gif" width="600" height="18"></td>
                </tr>
                <tr>
                  <td class="td2"><?php echo $HelpNew; ?></td>
                </tr>
                <tr>
                  <td>
                    <textarea cols="72" rows="6" wrap="VIRTUAL" class="code2">&lt;?php
$newest_poll = 1;
require(&quot;<?php echo $path; ?>/booth.php&quot;);
?&gt;
</textarea>
                    <br>
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
