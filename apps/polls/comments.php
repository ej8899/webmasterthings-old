<?php
///////////////////////////////////////////////////
//  Advanced Poll 1.61 (PHP/MySQL)               //
//  Copyright (c)2001 Chi Kien Uong              //
//  URL: http://www.proxy2.de                    //
///////////////////////////////////////////////////

$include_path = dirname(__FILE__);
require $include_path."/include/config.inc.php";
require $include_path."/include/$poll_db";

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

function show_form($poll_id) {
  global $question, $PHP_SELF;
?>
<table border="0" cellspacing="0" cellpadding="1" align="center" bgcolor="#006699">
  <tr align="center">
    <td>
     <style type="text/css">
      <!--
       .button {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 8pt}
       .textarea {  font-family: "MS Sans Serif"; font-size: 9pt; width: 195px}
       .input {  width: 195px}
      -->
    </style><font color="#FFFFFF" face="Verdana, Arial, Helvetica, sans-serif" size="2"><b>Send Your Comment</b></font></td>
  </tr>
  <tr>
    <td>
      <table border="0" cellspacing="0" cellpadding="5" align="center" bgcolor="#FFFFFF" width="200">
        <tr>
          <td width="149">
            <form method="post" action="<?php echo $PHP_SELF; ?>">
              <table border="0" cellspacing="0" cellpadding="2" bgcolor="#FFFFFF" align="center">
                <tr>
                  <td class="td1" height="40"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><?php echo $question; ?></font></b></td>
                </tr>
                <tr>
                  <td class="td1"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">Name:</font><br>
                    <input type="text" name="name" maxlength="25" class="input" size="23">
                  </td>
                </tr>
                <tr>
                  <td class="td1"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">e-mail:</font><br>
                    <input type="text" name="email" size="23" maxlength="50" class="input">
                  </td>
                </tr>
                <tr>
                  <td class="td1"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">Comment(*):</font><br>
                    <font face="MS Sans Serif" size="1">
                    <textarea name="message" cols="19" wrap="VIRTUAL" rows="6" class="textarea"></textarea>
                    </font>
                  </td>
                </tr>
                <tr valign="top">
                  <td>
                    <input type="submit" value="Submit" class="button">
                    <input type="reset" value="Reset" class="button">
                    <input type="hidden" name="action" value="add">
                    <input type="hidden" name="id" value="<?php echo $poll_id; ?>">
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
<?php }

function format_string($strg) {
  if (!get_magic_quotes_gpc()) {
    $strg = addslashes($strg);
  }
  $strg = trim($strg);
  $strg = htmlspecialchars($strg);
  return $strg;
}

function add_comment($poll_id) {
  global $sql_hostname, $sql_username, $sql_password, $dbName;
  global $sql_com, $name, $email, $message;
  global $REMOTE_ADDR, $HTTP_USER_AGENT;
  $name = format_string($name);
  if (!$name) {
    $name = "anonymous";
  }
  $email = trim($email);
  if (!eregi("^[_a-z0-9-]+(\\.[_a-z0-9-]+)*@([0-9a-z][0-9a-z-]*[0-9a-z]\\.)+[a-z]{2,4}$", $email) ) {
    $email = '';
  }
  $this_time = time();
  $ip = $REMOTE_ADDR;
  if (!$ip) {
    $ip = getenv("REMOTE_ADDR");
  }
  $host = @gethostbyaddr($ip);
  $agent = $HTTP_USER_AGENT;
  if (!$agent) {
    $agent = @getenv("HTTP_USER_AGENT");
  }
  $db_connect = new db_sql;
  $db_connect->connect($sql_hostname, $sql_username, $sql_password, $dbName);
  $sql_result = $db_connect->query("INSERT INTO $sql_com (poll_id,time,host,browser,name,email,message) VALUES ('$poll_id','$this_time','$host','$agent','$name','$email','$message')");
  return ($sql_result) ? true : false;
}

function check_poll_id($poll_id) {
  global $sql_hostname, $sql_username, $sql_password, $dbName;
  global $sql_index;
  $db_connect = new db_sql;
  $db_connect->connect($sql_hostname, $sql_username, $sql_password, $dbName);
  $results = $db_connect->query("SELECT * FROM $sql_index WHERE (poll_id = '$poll_id' and status < '2')");
  $row = $db_connect->fetch_array($results);
  if (!$row) {    
    return false;
  } else {
    if ($row["comments"]==0) {
      return false;
    } else {
      $question = htmlspecialchars($row['question']);
      return $question;
    }
  }
}

function print_message($strg,$autoclose) {
  if ($autoclose==1) {
    echo "<script language=\"JavaScript\">
      setTimeout(\"closeWin()\",2000);
      function closeWin() {
	self.close();
      }
      </script>";
  }
  echo "<center><font face=\"Verdana, Arial, Helvetica, sans-serif\" size=\"1\"><b>$strg</b></font></center>";
}

if (!isset($action)) {
  $action = '';
}

switch ($action) {
  case "send":
    if (!isset($id)) {
      echo "<b>Poll ID is not set!</b>";
      break;
    } else {
      $question = check_poll_id($id);
      if (!$question) {
        echo "<b>Poll ID ".$id." does not exist or is disabled!</b>";
        break;
      } else {
        show_form($id); 
        break;
      }
    }
    break;

  case "add":
    $message = format_string($message);
    if (!isset($id)) {
      echo "<b>Poll ID is not set!</b>";
      break;
    } elseif (empty($message)) {
      print_message("You forgot to fill in the message field!<br><a href=\"javascript:history.go(-1)\">Go back</a>",0);
      break;
    } else {
      $question = check_poll_id($id);
      if (!$question) {
        echo "<b>Poll ID ".$id." does not exist or is disabled!</b>";
        break;
      } else {
        if (add_comment($id)) {
          print_message("Your message has been sent!",1);
        } else {
          print_message("Error occured!<br><a href=\"javascript:history.go(-1)\">Go back</a>",0);
        }
      }
    }
    break;

  default:
    echo "<b>No valid command!</b>";
    break;
}

?>