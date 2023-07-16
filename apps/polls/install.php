<?php
///////////////////////////////////////////////////
//  Advanced Poll 1.61 (PHP/MySQL)               //
//  Copyright (c)2001 Chi Kien Uong              //
//  URL: http://www.proxy2.de                    //
///////////////////////////////////////////////////

$version = "v1.61";
if (!isset($PHP_SELF)) {
  $PHP_SELF = $HTTP_SERVER_VARS["PHP_SELF"];
  if (isset($HTTP_GET_VARS)) {
    while (list($name, $value)=each($HTTP_GET_VARS)) {
      $$name=$value;
    }
  }
  if (isset($HTTP_POST_VARS)) {
    while (list($name, $value)=each($HTTP_POST_VARS)) {
      $$name=$value;
    }
  }
}
if (!file_exists("./install/cross.gif")) {
  $img_loc="http://www.proxy2.de/poll/install";
} else {
  $img_loc="install";
}
if (file_exists("./include/config.inc.php")) {
  include ("./include/config.inc.php");
} else {
  abort("Cannot find configuration file <u>config.inc.php</u>.");
}

function print_header($refresh,$stp) {
global $PHP_SELF, $version, $img_loc;
?>
<html>
<head>
<title>Advanced Poll <?php echo $version; ?> Installation</title>
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Expires" content="-1">
<?php
if ($refresh != -1) {
?>
<meta http-equiv="refresh" content="<?php echo "$refresh;URL=$PHP_SELF?action=$stp"; ?>">
<?php } ?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
.td1 {  font-family: "MS Sans Serif"; font-size: 9pt}
.textarea {  font-family: "MS Sans Serif"; width: 450px; background-color: #C6C3C6; height: 140px; clip:  rect(   ); font-size: 9pt}
-->
</style>
<script language="Javascript">
<!--
function abort() {
 if (window.confirm("Do you wish to cancel the installation?")) {
    window.location.href = "http://"+window.location.host+window.location.pathname+"?action=cancel"
 }
}
function go_back() {
  history.go(-1);
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
function check_data() {
  document.FormPwd.username.value = trim(document.FormPwd.username.value);
  document.FormPwd.password.value = trim(document.FormPwd.password.value);
  if (document.FormPwd.username.value == "") {
    alert("You forgot to fill in the username field!");
    document.FormPwd.username.focus();
    return false;
  } else if (document.FormPwd.password.value == "") {
    alert("You forgot to fill in the password field!");
    document.FormPwd.password.focus();
    return false;
  } else if (document.FormPwd.password.value != document.FormPwd.confirm.value) {
    alert("The passwords do not match!");
    return false;
  }
}
function set_focus() {
  document.FormPwd.username.focus();
}
// -->
</script>
</head>

<?php
}

function welcome() {
global $PHP_SELF, $version, $img_loc;
?>
<body bgcolor="#3A6EA5">
<br>
<br>
<table border="1" cellspacing="0" cellpadding="0" align="center" width="500">
  <tr bgcolor="#C6C3C6">
    <td>
      <table width="500" border="0" cellspacing="0" cellpadding="1" align="center">
        <tr bgcolor="#400080">
          <td height="20" class="td1" bgcolor="#000084"><b><font color="#FFFFFF">
            &nbsp;Advanced Poll <?php echo $version; ?> Installation</font></b></td>
          <td height="20" class="td1" align="right" bgcolor="#000084"><img src="<?php echo $img_loc; ?>/cross.gif" width="16" height="14" border="0" usemap="#close"><map name="close"><area shape="rect" coords="1,1,14,12" href="javascript:abort()"></map>
          </td>
        </tr>
        <tr align="center">
          <td colspan="2">
            <form method="post" action="<?php echo $PHP_SELF; ?>">
              <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                <tr bgcolor="#FFFFFF">
                  <td class="td1" height="60">
                    <table border="0" cellspacing="0" cellpadding="0" width="500">
                      <tr>
                        <td width="190"><img src="<?php echo $img_loc; ?>/install.gif" width="164" height="300" alt="Installation"></td>
                        <td width="310" valign="top" class="td1"><br>
                          <b><br>
                          Welcome to the Installation Wizard for <br>Advanced Poll
                          <?php echo $version; ?></b><br>
                          <br>
                          <br>
                          <br>
                          Press 'Next' button to begin the installation.</td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr bgcolor="#C6C3C6">
                  <td align="center" height="20">
                    <img src="<?php echo $img_loc; ?>/h_line.gif" height="18" width="490">
                  </td>
                </tr>
                <tr bgcolor="#C6C3C6" align="right">
                  <td><img src="<?php echo $img_loc; ?>/disabled.gif" width="75" height="22" border="0" alt="Back"><img src="<?php echo $img_loc; ?>/next.gif" width="75" height="22" usemap="#Next" border="0" alt="Next"><map name="Next"><area shape="rect" coords="1,1,74,21" href="<?php echo $PHP_SELF; ?>?action=step_1"></map>
                    &nbsp;&nbsp;<img src="<?php echo $img_loc; ?>/cancel.gif" width="75" height="22" usemap="#Cancel" border="0" alt="Cancel"><map name="Cancel"><area shape="rect" coords="1,2,73,20" href="javascript:abort()"></map>
                    &nbsp;&nbsp; </td>
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
<?php
}

function license() {
global $PHP_SELF, $version, $img_loc;
?>
<body bgcolor="#3A6EA5">
<br>
<br>
<table border="1" cellspacing="0" cellpadding="0" align="center" width="500">
  <tr bgcolor="#C6C3C6">
    <td>
      <table width="500" border="0" cellspacing="0" cellpadding="1" align="center">
        <tr bgcolor="#400080">
          <td height="20" class="td1" bgcolor="#000084"><b><font color="#FFFFFF">
            &nbsp;Advanced Poll <?php echo $version; ?> Installation</font></b></td>
          <td height="20" class="td1" align="right" bgcolor="#000084"><img src="<?php echo $img_loc; ?>/cross.gif" width="16" height="14" border="0" usemap="#close"><map name="close"><area shape="rect" coords="1,1,14,12" href="javascript:abort()"></map>
          </td>
        </tr>
        <tr align="center">
          <td colspan="2">
            <form method="post" action="<?php echo $PHP_SELF; ?>">
              <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                <tr bgcolor="#FFFFFF">
                  <td class="td1" height="30"><b>&nbsp;&nbsp;&nbsp;End-User Software
                    License Agreement</b></td>
                </tr>
                <tr bgcolor="#FFFFFF" valign="top">
                  <td class="td1" height="30"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Please
                    read the following agreement carefully.</td>
                </tr>
                <tr bgcolor="#C6C3C6">
                  <td align="center">
                    <table width="400" border="0" cellspacing="0" cellpadding="0" align="center">
                      <tr>
                        <td class="td1" height="40">Press the PAGE DOWN to see
                          the rest of the agreement</td>
                      </tr>
                      <tr>
                        <td>
                          <font face="MS sans serif" size="1">
<textarea name="textfield" cols="48" rows="10" wrap="VIRTUAL" class="textarea">
You should carefully read the following terms and conditions before using this software. Your use of this software indicates your acceptance of this license agreement. If you do not agree to all the terms of this agreement, do not use this software.

1. This script may be used and modified free of charge for personal, academic and non-profit use. Commercial use must register the script for a one time fee of $10 US or 10 EUR.
--> http://www.proxy2.de/register
Registered users receive support, free upgrades and also do not have to display the text link. 

2. You may copy and distribute verbatim copies of the Program's source code as 
you receive it, in any medium, provided that you conspicuously and appropriately 
publish on each copy an appropriate copyright notice. Keep intact all the notices
that refer to this License and give any other recipients of the Program a copy of this License along with the Program.

3. Selling the code for this program, or a program derived from Advanced Poll, without 
prior written consent is expressly forbidden.

THIS SOFTWARE AND THE ACCOMPANYING FILES ARE PROVIDED "AS IS" 
WITHOUT WARRANTY OF ANY KIND, EITHER EXPRESS OR IMPLIED, INCLUDING 
BUT NOT LIMITED TO THE IMPLIED WARRANTIES OF MERCHANTABILITY AND 
FITNESS FOR A PARTICULAR PURPOSE. THE AUTHOR DOES NOT WARRANT 
THAT THE FUNCTIONS CONTAINED IN THE SOFTWARE WILL MEET YOUR 
REQUIREMENTS, OR THAT THE OPERATION OF THE SOFTWARE WILL BE 
UNINTERRUPTED OR ERROR-FREE, OR THAT ANY DEFECTS DISCOVERED IN 
THE SOFTWARE WILL BE CORRECTED. FURTHERMORE, THE AUTHOR DOES 
NOT WARRANT OR MAKE ANY REPRESENTATIONS REGARDING THE USE OR 
THE RESULTS OF THE USE OF THE SOFTWARE IN TERMS OF ITS CORRECTNESS,
ACCURACY, RELIABILITY, OR OTHERWISE. YOU ASSUME ALL RISKS IN 
USING THE SOFTWARE. NO ORAL OR WRITTEN INFORMATION OR ADVICE 
GIVEN BY THE AUTHOR OR ANY OF THEIR AUTHORIZED REPRESENTATIVES 
SHALL CREATE A WARRANTY OR IN ANY WAY INCREASE THE SCOPE OF THIS 
WARRANTY. IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR ANY DIRECT, 
INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES.
</textarea></font>
                        </td>
                      </tr>
                      <tr>
                        <td class="td1" height="50">Do you accept all the terms
                          of the preceding Lisence Agrement? If you choose NO,
                          the setup will close. To install Advanced Poll <?php echo $version; ?>,
                          you must accept this agreement. </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr bgcolor="#C6C3C6">
                  <td align="center" height="20">
                    <img src="<?php echo $img_loc; ?>/h_line.gif" height="18" width="490">
                  </td>
                </tr>
                <tr bgcolor="#C6C3C6" align="right">
                  <td> <img src="<?php echo $img_loc; ?>/back.gif" width="75" height="22" usemap="#Back" border="0" alt="Back"><map name="Back"><area shape="rect" coords="1,2,73,20" href="javascript:go_back()"></map><img src="<?php echo $img_loc; ?>/yes.gif" width="75" height="22" usemap="#Yes" border="0" alt="Yes"><map name="Yes"><area shape="rect" coords="2,2,73,20" href="<?php echo $PHP_SELF; ?>?action=step_2"></map>
                    &nbsp; <img src="<?php echo $img_loc; ?>/no.gif" width="75" height="22" usemap="#No" border="0" alt="No"><map name="No"><area shape="rect" coords="1,3,73,20" href="javascript:abort()"></map>&nbsp;&nbsp;
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
<?php
}

function install_process($msg,$stat,$stp) {
global $PHP_SELF, $version, $img_loc;
?>
<body bgcolor="#3A6EA5">
<br>
<br>
<table border="1" cellspacing="0" cellpadding="0" align="center" width="500">
  <tr bgcolor="#C6C3C6">
    <td>
      <table width="500" border="0" cellspacing="0" cellpadding="1" align="center">
        <tr bgcolor="#400080">
          <td height="20" class="td1" bgcolor="#000084"><b><font color="#FFFFFF">
            &nbsp;Advanced Poll <?php echo $version; ?> Installation</font></b></td>
          <td height="20" class="td1" align="right" bgcolor="#000084"><img src="<?php echo $img_loc; ?>/cross.gif" width="16" height="14" border="0" usemap="#close"><map name="close"><area shape="rect" coords="1,1,14,12" href="javascript:abort()"></map>
          </td>
        </tr>
        <tr align="center">
          <td colspan="2">
            <form method="post" action="<?php echo $PHP_SELF; ?>">
              <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                <tr bgcolor="#FFFFFF" valign="bottom">
                  <td class="td1" height="30"><b>&nbsp;&nbsp;&nbsp;&nbsp;Installation
                    Process</b></td>
                </tr>
                <tr bgcolor="#FFFFFF">
                  <td class="td1" height="30">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <?php echo $msg; ?>.</td>
                </tr>
                <tr bgcolor="#C6C3C6">
                  <td class="td1" align="center">
                    <table width="400" border="0" cellspacing="0" cellpadding="0" align="center">
                      <tr>
                        <td class="td1" height="75">Please wait while the Installation
                          Wizard creates the tables needed to install Advanced Poll
                          on your server. This may take a few moments.</td>
                      </tr>
                      <tr>
                        <td height="140" class="td1"> Please wait...
                          <table width="100%" border="1" cellspacing="0" cellpadding="0">
                            <tr>
                              <td><img src="<?php echo $img_loc; ?>/status.gif" width="<?php echo $stat; ?>" height="16"></td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr bgcolor="#C6C3C6">
                  <td align="center" height="20">
                    <img src="<?php echo $img_loc; ?>/h_line.gif" height="18" width="490">
                  </td>
                </tr>
                <tr bgcolor="#C6C3C6">
                  <td align="right"><img src="<?php echo $img_loc; ?>/disabled.gif" width="75" height="22" border="0" alt="Back"><img src="<?php echo $img_loc; ?>/next.gif" width="75" height="22" border="0" usemap="#Next" alt="Next"><map name="Next"><area shape="rect" coords="1,1,73,20" href="<?php echo "$PHP_SELF?action=$stp"; ?>"></map>
                    &nbsp;&nbsp;<img src="<?php echo $img_loc; ?>/cancel.gif" width="75" height="22" usemap="#Cancel" border="0" alt="Cancel"><map name="Cancel"><area shape="rect" coords="1,1,73,20" href="javascript:abort()"></map>
                    &nbsp;&nbsp; </td>
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
<?php
}

function create_account() {
global $PHP_SELF, $version, $img_loc;
?>
<body bgcolor="#3A6EA5" onload="set_focus()">
<br>
<br>
<table border="1" cellspacing="0" cellpadding="0" align="center" width="500">
  <tr bgcolor="#C6C3C6">
    <td>
      <table width="500" border="0" cellspacing="0" cellpadding="1" align="center">
        <tr bgcolor="#400080">
          <td height="20" class="td1" bgcolor="#000084"><b><font color="#FFFFFF">
            &nbsp;Advanced Poll <?php echo $version; ?> Installation</font></b></td>
          <td height="20" class="td1" align="right" bgcolor="#000084"><img src="<?php echo $img_loc; ?>/cross.gif" width="16" height="14" border="0" usemap="#close"><map name="close"><area shape="rect" coords="1,1,14,12" href="javascript:abort()"></map>
          </td>
        </tr>
        <tr align="center">
          <td colspan="2">
            <form method="post" action="<?php echo $PHP_SELF; ?>" name="FormPwd" onsubmit="return check_data()">
              <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                <tr bgcolor="#FFFFFF" valign="bottom">
                  <td class="td1" height="30"><b>&nbsp;&nbsp;&nbsp;&nbsp;Installation
                    Process</b></td>
                </tr>
                <tr bgcolor="#FFFFFF">
                  <td class="td1" height="30">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    All tables were created successfully!</td>
                </tr>
                <tr bgcolor="#C6C3C6">
                  <td class="td1" valign="top" align="center">
                    <table width="400" border="0" cellspacing="0" cellpadding="0" align="center">
                      <tr>
                        <td class="td1" height="75">To complete the installation enter a username
                          and password.</td>
                      </tr>
                      <tr>
                        <td height="140" class="td1">
                          <table width="100%" border="0" cellspacing="0" cellpadding="3">
                            <tr>
                              <td width="18%" class="td1">Username:</td>
                              <td width="82%">
                                <input type="text" name="username" size="25">
                              </td>
                            </tr>
                            <tr>
                              <td width="18%" class="td1">Password:</td>
                              <td width="82%">
                                <input type="password" name="password" size="25">
                              </td>
                            </tr>
                            <tr>
                              <td width="18%" class="td1">Confirm:</td>
                              <td width="82%">
                                <input type="password" name="confirm" size="25">
                                <input type="hidden" name="action" value="step_6">
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr bgcolor="#C6C3C6">
                  <td align="center" height="20">
                    <img src="<?php echo $img_loc; ?>/h_line.gif" height="18" width="490">
                  </td>
                </tr>
                <tr bgcolor="#C6C3C6">
                  <td align="right"><img src="<?php echo $img_loc; ?>/disabled.gif" width="75" height="22" border="0" alt="Back"><input type="image" src="install/next.gif" width="75" height="22" border="0" alt="Next">
                    &nbsp;&nbsp;<img src="<?php echo $img_loc; ?>/cancel.gif" width="75" height="22" usemap="#Cancel" border="0" alt="Cancel"><map name="Cancel"><area shape="rect" coords="1,1,73,20" href="javascript:abort()"></map>
                    &nbsp;&nbsp; </td>
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
<?php
}

function abort($msg) {
global $version, $img_loc;
?>
<html>
<head>
<title>Advanced Poll <?php echo $version; ?></title>
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Expires" content="-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
.td1 {  font-family: "MS Sans Serif"; font-size: 9pt}
-->
</style>
</head>
<body bgcolor="#3A6EA5">
<br><br><br><br><br><br>
<table border="1" cellspacing="0" cellpadding="0" align="center" width="300">
  <tr bgcolor="#C6C3C6">
    <td>
      <table width="300" border="0" cellspacing="0" cellpadding="1" align="center">
        <tr bgcolor="#400080">
          <td height="20" class="td1" bgcolor="#000084"><b><font color="#FFFFFF">
            &nbsp;Advanced Poll <?php echo $version; ?></font></b></td>
          <td height="20" class="td1" align="right" bgcolor="#000084"><img src="<?php echo $img_loc; ?>/cross.gif" width="16" height="14" border="0">
          </td>
        </tr>
        <tr align="center">
          <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
              <tr bgcolor="#C6C3C6">
                <td align="center" height="75" width="20%"><img src="<?php echo $img_loc; ?>/info.gif" width="35" height="35"></td>
                <td align="left" height="75" width="80%" class="td1"><?php echo $msg; ?></td>
              </tr>
              <tr bgcolor="#C6C3C6" align="center">
                <td colspan="2" height="40"><img src="<?php echo $img_loc; ?>/disabled.gif" width="75" height="22" border="0" alt="Back">&nbsp;&nbsp;<img src="<?php echo $img_loc; ?>/ok.gif" width="75" height="22" border="0" alt="Ok"></td>
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
<br>
</body>
</html>
<?php
exit();
}

function sql_error() {
  $description = mysql_error();
  $number = mysql_errno();
  $error ="MySQL Error : $description\n";
  $error.="Error Number: $number\n";
  $error.="Date        : ".date("D, F j, Y H:i:s")."\n";
  $error.="IP          : ".getenv("REMOTE_ADDR")."\n";
  $error.="Browser     : ".getenv("HTTP_USER_AGENT")."\n";
  echo "<b><font size=4 face=Arial>$description</font></b><hr>";
  echo "<pre>$error</pre>";
  exit();
}

function error_msg($strg) {
global $PHP_SELF, $version, $img_loc;
?>
<body bgcolor="#3A6EA5">
<br>
<br>
<table border="1" cellspacing="0" cellpadding="0" align="center" width="500">
  <tr bgcolor="#C6C3C6">
    <td>
      <table width="500" border="0" cellspacing="0" cellpadding="1" align="center">
        <tr bgcolor="#400080">
          <td height="20" class="td1" bgcolor="#000084"><b><font color="#FFFFFF">
            &nbsp;Advanced Poll <?php echo $version; ?> Installation</font></b></td>
          <td height="20" class="td1" align="right" bgcolor="#000084"><img src="<?php echo $img_loc; ?>/cross.gif" width="16" height="14" border="0" usemap="#close"><map name="close"><area shape="rect" coords="1,1,14,12" href="javascript:abort()"></map>
          </td>
        </tr>
        <tr align="center">
          <td colspan="2">
            <form method="post" action="<?php echo $PHP_SELF; ?>">
              <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                <tr bgcolor="#FFFFFF">
                  <td class="td1" height="60">
                    <table border="0" cellspacing="0" cellpadding="0" width="500">
                      <tr>
                        <td width="190"><img src="<?php echo $img_loc; ?>/install.gif" width="164" height="300"></td>
                        <td width="310" valign="top" class="td1"><br>
                          <b><br>
                          Welcome to the Installation Wizard for <br>Advanced Poll
                          <?php echo $version; ?></b><br>
                          <br>
                          <br>
                          <br>
                          <font color="#FF0000"><?php echo $strg; ?></font>
                          </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr bgcolor="#C6C3C6">
                  <td align="center" height="20">
                    <img src="<?php echo $img_loc; ?>/h_line.gif" height="18" width="490">
                  </td>
                </tr>
                <tr bgcolor="#C6C3C6">
                  <td align="right"><img src="<?php echo $img_loc; ?>/disabled.gif" width="75" height="22" border="0" alt="Back"><img src="<?php echo $img_loc; ?>/next.gif" width="75" height="22" border="0" usemap="#Next" alt="Back"><map name="Next"><area shape="rect" coords="1,1,73,20" href="<?php echo $PHP_SELF; ?>"></map>
                    &nbsp;&nbsp;<img src="<?php echo $img_loc; ?>/cancel.gif" width="75" height="22" usemap="#Cancel" border="0" alt="Cancel"><map name="Cancel"><area shape="rect" coords="1,1,73,20" href="javascript:abort()"></map>
                    &nbsp;&nbsp; </td>
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
<?php
}

function inst_complete() {
global $version, $img_loc;
?>
<body bgcolor="#3A6EA5">
<br>
<br>
<table border="1" cellspacing="0" cellpadding="0" align="center" width="500">
  <tr bgcolor="#C6C3C6">
    <td>
      <table width="500" border="0" cellspacing="0" cellpadding="1" align="center">
        <tr bgcolor="#400080">
          <td height="20" class="td1" bgcolor="#000084"><b><font color="#FFFFFF">
            &nbsp;Advanced Poll <?php echo $version; ?> Installation</font></b></td>
          <td height="20" class="td1" align="right" bgcolor="#000084"><img src="<?php echo $img_loc; ?>/cross.gif" width="16" height="14" border="0">
          </td>
        </tr>
        <tr align="center">
          <td colspan="2">
            <form method="post" action="<?php echo $PHP_SELF; ?>">
              <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                <tr bgcolor="#FFFFFF" valign="bottom">
                  <td class="td1" height="30"><b>&nbsp;&nbsp;&nbsp;&nbsp;Installation
                    Process</b></td>
                </tr>
                <tr bgcolor="#FFFFFF">
                  <td class="td1" height="30">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    Advanced Poll has been installed successfully.</td>
                </tr>
                <tr bgcolor="#C6C3C6">
                  <td class="td1" align="center">
                    <table width="400" border="0" cellspacing="0" cellpadding="0" align="center">
                      <tr>
                        <td class="td1" height="75">Thank you for using Advanced Poll.<br>
                        If you installed Advanced Poll for the first time, do
                        not forget to read the license.</td>
                      </tr>
                      <tr>
                        <td height="140" class="td1"> Installation complete...
                          <table width="100%" border="1" cellspacing="0" cellpadding="0">
                            <tr>
                              <td><img src="<?php echo $img_loc; ?>/status.gif" width="395" height="16"></td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr bgcolor="#C6C3C6">
                  <td align="center" height="20">
                    <img src="<?php echo $img_loc; ?>/h_line.gif" height="18" width="490">
                  </td>
                </tr>
                <tr bgcolor="#C6C3C6">
                  <td align="right"><img src="<?php echo $img_loc; ?>/disabled.gif" width="75" height="22" border="0" alt="Back"><img src="<?php echo $img_loc; ?>/done.gif" width="75" height="22" border="0" usemap="#Next" alt="Done"><map name="Next"><area shape="rect" coords="1,1,73,20" href="list.php"></map>
                    &nbsp;&nbsp;</td>
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
<?php
}

if (!isset($action)) {
  $action ='';
}

switch ($action) {

case "step_1":
  print_header(200,"step_2");
  license();
  break;

case "step_2":
  print_header(2,"step_3");
  install_process("Connecting to $sql_hostname.",1,"step_3");
  break;

case "step_3":

$tbl[0] = "CREATE TABLE $sql_config (
   config_id smallint(5) unsigned NOT NULL auto_increment,
   base_gif varchar(60) NOT NULL,
   lang varchar(20) NOT NULL,
   title varchar(60) NOT NULL,
   vote_button varchar(30) NOT NULL,
   result_text varchar(40) NOT NULL,
   total_text varchar(40) NOT NULL,
   voted varchar(40) NOT NULL,
   send_com varchar(40) NOT NULL,
   img_height int(5) DEFAULT '0' NOT NULL,
   img_length int(5) DEFAULT '0' NOT NULL,
   table_width varchar(6) NOT NULL,
   bgcolor_tab varchar(7) NOT NULL,
   bgcolor_fr varchar(7) NOT NULL,
   font_face varchar(70) NOT NULL,
   font_color varchar(7) NOT NULL,
   type varchar(10) DEFAULT '0' NOT NULL,
   check_ip smallint(2) DEFAULT '0' NOT NULL,
   lock_timeout int(9) DEFAULT '0' NOT NULL,
   time_offset varchar(5) DEFAULT '0' NOT NULL,
   entry_pp int(4) unsigned DEFAULT '0' NOT NULL,
   PRIMARY KEY (config_id)
)";

$tbl[1] = "CREATE TABLE $sql_data (
   id int(11) NOT NULL auto_increment,
   poll_id int(11) DEFAULT '0' NOT NULL,
   option_id int(11) DEFAULT '0' NOT NULL,
   option_text varchar(100) NOT NULL,
   color varchar(20) NOT NULL,
   votes int(14) DEFAULT '0' NOT NULL,
   PRIMARY KEY (poll_id, option_id),
   KEY id (id)
)";

$tbl[2] = "CREATE TABLE $sql_index (
   poll_id int(11) unsigned NOT NULL auto_increment,
   question varchar(100) NOT NULL,
   timestamp int(11) DEFAULT '0' NOT NULL,
   status smallint(2) DEFAULT '0' NOT NULL,
   logging smallint(2) DEFAULT '0' NOT NULL,
   exp_time int(11) DEFAULT '0' NOT NULL,
   expire smallint(2) DEFAULT '0' NOT NULL,
   comments smallint(2) DEFAULT '0' NOT NULL,
   PRIMARY KEY (poll_id)
)";

$tbl[3] = "CREATE TABLE $sql_ip (
   ip_id int(11) NOT NULL auto_increment,
   poll_id int(11) DEFAULT '0' NOT NULL,
   ip_addr varchar(15) NOT NULL,
   timestamp int(11) DEFAULT '0' NOT NULL,
   PRIMARY KEY (ip_id)
)";

$tbl[4] = "CREATE TABLE $sql_log (
   log_id int(11) unsigned NOT NULL auto_increment,
   poll_id int(11) DEFAULT '0' NOT NULL,
   option_id int(11) DEFAULT '0' NOT NULL,
   timestamp int(11) DEFAULT '0' NOT NULL,
   ip_addr varchar(15) NOT NULL,
   host varchar(70) NOT NULL,
   agent varchar(80) DEFAULT '0' NOT NULL,
   PRIMARY KEY (log_id)
)";

$tbl[5] = "CREATE TABLE $sql_user (
   user_id smallint(5) NOT NULL auto_increment,
   username varchar(30) NOT NULL,
   userpass varchar(30) NOT NULL,
   session varchar(32) NOT NULL,
   PRIMARY KEY (user_id)
)";

$tbl[6] = "CREATE TABLE $sql_com (
   com_id int(9) NOT NULL auto_increment,
   poll_id int(9) DEFAULT '0' NOT NULL,
   time int(11) DEFAULT '0' NOT NULL,
   host varchar(70) NOT NULL,
   browser varchar(70) NOT NULL,
   name varchar(60) NOT NULL,
   email varchar(70) NOT NULL,
   message text NOT NULL,
   PRIMARY KEY (com_id)
)";

  $serverid  = mysql_connect($sql_hostname, $sql_username, $sql_password) or sql_error();
  if(!@mysql_select_db($dbName,$serverid)) {
    mysql_create_db("$dbName") or sql_error();
  }
  @mysql_select_db($dbName,$serverid) or sql_error();
  for ($i=0;$i<sizeof($tbl);$i++) {
    mysql_query($tbl[$i],$serverid) or sql_error();
  }
  print_header(2,"step_4");
  install_process("Connecting to '$sql_hostname' succeed. Creating tables...",150,"step_4");
  break;

case "step_4":
  $timestamp = time();
  $timestamp2 = $timestamp+50;
  $exp_time = time()+10*86400;
  $tbl_data[0]  = "INSERT INTO $sql_config (config_id, base_gif, lang, title, vote_button, result_text, total_text, voted, send_com, img_height, img_length, table_width, bgcolor_tab, bgcolor_fr, font_face, font_color, type, check_ip, lock_timeout, time_offset, entry_pp) VALUES ( '1', 'http://www.proxy2.de/poll/image', 'english.php', 'Advanced Poll', 'Vote', 'View results', 'Total votes', 'You have already voted!', 'Send comment', '10', '42', '170', '#FFFFFF', '#006699', 'Verdana, Arial, Helvetica, sans-serif', '#000000', 'percent', '0', '2', '0', '5')";
  $tbl_data[1]  = "INSERT INTO $sql_index (poll_id, question, timestamp, status, logging, exp_time, expire, comments) VALUES ( '1', 'Which OS is your Website running on?', '$timestamp', '1', '1', '$exp_time', '1', '1')";
  $tbl_data[2]  = "INSERT INTO $sql_index (poll_id, question, timestamp, status, logging, exp_time, expire, comments) VALUES ( '2', 'Which database engine do you prefer?', '$timestamp2', '1', '0', '$exp_time', '0', '1')";
  $tbl_data[3]  = "INSERT INTO $sql_data (id, poll_id, option_id, option_text, color, votes) VALUES ( '1', '1', '1', 'Linux', 'blue', '49')";
  $tbl_data[4]  = "INSERT INTO $sql_data (id, poll_id, option_id, option_text, color, votes) VALUES ( '2', '1', '2', 'Solaris', 'yellow', '12')";
  $tbl_data[5]  = "INSERT INTO $sql_data (id, poll_id, option_id, option_text, color, votes) VALUES ( '3', '1', '3', 'FreeBSD', 'green', '29')";
  $tbl_data[6]  = "INSERT INTO $sql_data (id, poll_id, option_id, option_text, color, votes) VALUES ( '4', '1', '4', 'WindowsNT', 'brown', '17')";
  $tbl_data[7]  = "INSERT INTO $sql_data (id, poll_id, option_id, option_text, color, votes) VALUES ( '5', '1', '5', 'Unix', 'grey', '10')";
  $tbl_data[8]  = "INSERT INTO $sql_data (id, poll_id, option_id, option_text, color, votes) VALUES ( '6', '1', '6', 'BSD', 'red', '15')";
  $tbl_data[9]  = "INSERT INTO $sql_data (id, poll_id, option_id, option_text, color, votes) VALUES ( '7', '1', '7', 'other', 'purple', '9')";
  $tbl_data[10] = "INSERT INTO $sql_data (id, poll_id, option_id, option_text, color, votes) VALUES ( '8', '2', '5', 'Sybase', 'orange', '2')";
  $tbl_data[11] = "INSERT INTO $sql_data (id, poll_id, option_id, option_text, color, votes) VALUES ( '9', '2', '4', 'MS SQL', 'green', '9')";
  $tbl_data[12] = "INSERT INTO $sql_data (id, poll_id, option_id, option_text, color, votes) VALUES ( '10', '2', '3', 'Oracle', 'blue', '17')";
  $tbl_data[13] = "INSERT INTO $sql_data (id, poll_id, option_id, option_text, color, votes) VALUES ( '11', '2', '2', 'PostgreSQL', 'gold', '6')";
  $tbl_data[14] = "INSERT INTO $sql_data (id, poll_id, option_id, option_text, color, votes) VALUES ( '12', '2', '1', 'MySQL', 'pink', '23')";
  $tbl_data[15] = "INSERT INTO $sql_data (id, poll_id, option_id, option_text, color, votes) VALUES ( '13', '2', '6', 'other', 'brown', '3')";
  $tbl_data[16] = "INSERT INTO $sql_data (id, poll_id, option_id, option_text, color, votes) VALUES ( '14', '2', '7', 'DB/2', 'grey', '4')";
  $tbl_data[17] = "INSERT INTO $sql_com (com_id, poll_id, time, host, browser, name, email, message) VALUES ( '1', '1', '$timestamp', 'localhost', 'Mozilla/4.0 (compatible; MSIE 5.5; Windows NT 4.0)', 'nobody', 'nobody@server.com', 'This is the first comment!')";
  
  $serverid  = mysql_connect($sql_hostname, $sql_username, $sql_password) or sql_error();
  @mysql_select_db($dbName,$serverid) or sql_error();
  for ($i=0;$i<sizeof($tbl_data);$i++) {
    mysql_query($tbl_data[$i],$serverid) or sql_error();
  }
  print_header(2,"step_5");
  install_process("Creating tables...succeed. Insert values...",300,"step_5");
  break;

case "step_5":
  print_header(-1,"stp");
  create_account();
  break;
  
case "step_6":
  if (empty($username) || empty($password)) {
    print_header(-1,"stp");
    install_process("step_5","Please enter a username and password...",300,"step_6");
    break;
  }
  srand((double)microtime()*1000000);
  $session = md5 (uniqid (rand()));
  $serverid  = mysql_connect($sql_hostname, $sql_username, $sql_password) or sql_error();
  @mysql_select_db($dbName,$serverid) or sql_error();
  $sql_query = "INSERT INTO $sql_user (user_id, username, userpass, session) VALUES ( '1', '$username', PASSWORD('$password'), '$session')";
  mysql_query($sql_query,$serverid) or sql_error();
  print_header(-1,"stp");
  inst_complete();
  break;

case "cancel":
  abort("Installation aborted!");
  break;

default:
  print_header(-1,"stp");
  if (empty($dbName) || empty($sql_hostname)) {
    error_msg("Please be sure you have setup your mySQL settings in the configuration file <u>config.inc.php</u> before running Advanced Poll Setup.");
  } elseif (!@mysql_connect($sql_hostname, $sql_username, $sql_password)) {
    error_msg("Cannot connect to $sql_hostname. Please be sure you have setup <br>your mySQL settings in the configuration file.");
  } elseif (empty($sql_index) || empty($sql_data) || empty($sql_config) || empty($sql_ip) || empty($sql_log) || empty($sql_user) || empty($sql_com)) {
    error_msg("Some tables are not defined. Please check the configuration file.");
  } else {  
    welcome();
  }
  break;
}

?>