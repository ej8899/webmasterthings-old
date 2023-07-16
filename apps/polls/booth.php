<?php
///////////////////////////////////////////////////
//  Advanced Poll 1.61 (PHP/MySQL)               //
//  Copyright (c)2001 Chi Kien Uong              //
//  URL: http://www.proxy2.de                    //
///////////////////////////////////////////////////

$comment_page = "comments.php"; // URL to comment page
                                // eg. http://www.yourdomain.com/poll/comments.php
                                
$include_path = dirname(__FILE__);
require $include_path."/include/config.inc.php";
require $include_path."/include/$poll_db";
$ip = $REMOTE_ADDR;
if (!$ip) {
  $ip = getenv("REMOTE_ADDR");
}
$db_connect = new db_sql;
$db_connect->connect($sql_hostname, $sql_username, $sql_password, $dbName);
$varresult = $db_connect->query("SELECT * FROM $sql_config");
$vars = $db_connect->fetch_array($varresult);
while(list($var,$value) = each($vars)) {
  $$var=$value;
}
$db_connect->free_result($varresult);
$poll_version = "1.61";
$found = 0;
$valid = 1;

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
  if(isset($HTTP_COOKIE_VARS)){
    while (list($name, $value)=each($HTTP_COOKIE_VARS)){
      $$name=$value;
    }
  }
}

function display_poll($poll_id) {
  global $sql_index, $sql_data, $poll_version, $PHP_SELF;
  global $question, $font_face, $font_color, $lock_timeout;
  global $vote_button, $result_text, $table_width, $bgcolor_fr, $title, $bgcolor_tab;
  global $db_connect;
?>
<table width="<?php echo $table_width; ?>" border="0" cellspacing="0" cellpadding="1" bgcolor="<?php echo $bgcolor_fr; ?>">
<tr align="center">
<td>
<style type="text/css">
<!--
 .input { font-family: <?php echo $font_face; ?>; font-size: 8pt}
 .links { font-family: <?php echo $font_face; ?>; font-size: 7.5pt; color: <?php echo $font_color; ?>}
-->
</style>
<font face="<?php echo $font_face; ?>" size="-1" color="#FFFFFF"><b><?php echo $title; ?></b></font></td>
</tr>
<tr align="center">
 <td><table width="100%" border="0" cellspacing="0" cellpadding="2" align="center" bgcolor="<?php echo $bgcolor_tab; ?>">
<tr>
  <td height="40" valign="middle"><font face="<?php echo $font_face; ?>" color="<?php echo $font_color; ?>" size="1"><b><?php echo $question; ?></b></font></td>
</tr>
<tr align="right" valign="top">
 <td><form method="post" action="<?php echo $PHP_SELF; ?>">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" height="190">
   <tr valign="top" align="center">
    <td><table width="100%" border="0" cellspacing="0" cellpadding="1" align="center">
<?php
$data_result = $db_connect->query("SELECT * FROM $sql_data WHERE (poll_id = '$poll_id') order by option_id asc");
  while ($data = $db_connect->fetch_array($data_result)) {
    echo "   <tr>
     <td width=\"15%\"><input type=\"radio\" name=\"vote_for\" value=\"$data[option_id]\"></td>
     <td width=\"85%\"><font face=\"$font_face\" size=\"1\" color=\"$font_color\">$data[option_text]</font></td>
   </tr>\n";

  }
?>
     </table>
     <input type="hidden" name="action" value="vote">
     <input type="hidden" name="poll_id" value="<?php echo $poll_id; ?>">
     <input type="submit" value="<?php echo $vote_button; ?>" class="input">
     <br><br>
     <font face="<?php echo $font_face; ?>" color="<?php echo $font_color; ?>" size="1"><a class="links" href="<?php echo $PHP_SELF; ?>?action=results&amp;poll_id=<?php echo "$poll_id\">$result_text"; ?></a><br><br><br></td>
 </tr>
</table>
</form>
  <font face="<?php echo $font_face; ?>" size="1"><a href="http://www.proxy2.de" target="_blank"><acronym title="Advanced Poll">Version <?php echo $poll_version; ?></acronym></a></font></td>
</tr>
</table>
</td>
</tr>
</table>
<?php }

function view_results($poll_id,$vote_stat) {
  global $sql_index, $sql_data, $comment_page, $poll_version, $PHP_SELF;
  global $base_gif, $font_face, $font_color, $img_height, $img_length, $type, $total_text, $voted;
  global $table_width, $bgcolor_fr, $title, $bgcolor_tab, $send_com;
  global $db_connect;
  $poll_result = $db_connect->query("SELECT * FROM $sql_index WHERE (poll_id = '$poll_id')");
  $row = $db_connect->fetch_array($poll_result);
  $question = htmlspecialchars($row['question']);
?>
<table width="<?php echo $table_width; ?>" border="0" cellspacing="0" cellpadding="1" bgcolor="<?php echo $bgcolor_fr; ?>">
<tr align="center">
<td>
<style type="text/css">
<!--
 .input { font-family: <?php echo $font_face; ?>; font-size: 8pt}
 .links { font-family: <?php echo $font_face; ?>; font-size: 7.5pt; color: <?php echo $font_color; ?>}
-->
</style>
<font face="<?php echo $font_face; ?>" size="-1" color="#FFFFFF"><b><?php echo $title; ?></b></font></td>
</tr>
<tr align="center">
 <td><table width="100%" border="0" cellspacing="0" cellpadding="2" align="center" bgcolor="<?php echo $bgcolor_tab; ?>">
 <tr valign="middle">
   <td height="40"><font face="<?php echo $font_face; ?>" color="<?php echo $font_color; ?>" size="1"><b><?php echo $question; ?></b></font></td>
 </tr>
 <tr align="right" valign="bottom">
   <td>
     <table border="0" cellspacing="0" cellpadding="1" width="100%" align="center" height="210">
       <tr valign="top">
        <td>
         <table width="100%" border="0" cellspacing="0" cellpadding="1" align="center">
<?php
  $i=0;
  $poll_total = $db_connect->query("SELECT SUM(votes) AS total FROM $sql_data WHERE (poll_id = '$poll_id')");
  $poll_sum = $db_connect->fetch_array($poll_total);
  $db_connect->free_result($poll_total);
  $data_result = $db_connect->query("SELECT * FROM $sql_data WHERE (poll_id = '$poll_id') order by votes desc");
  $votes_total = ($poll_sum["total"]==0) ? 1 : $poll_sum["total"];
  while ($data = $db_connect->fetch_array($data_result)) {
    if ($i == 0) {
      $maxvote = ($data["votes"]==0) ? 1 : $data["votes"];
      $i++;
    }
    $img_width = (int) ($data["votes"]*$img_length/$maxvote);
    $vote_val = ($type == "percent") ? sprintf("%.1f",($data['votes']*100/$votes_total))."%" : $data["votes"];
    echo "        <tr>
          <td height=\"22\"><font face=\"$font_face\" color=\"$font_color\" size=\"1\">$data[option_text]</font></td>
          <td nowrap height=\"22\"><font face=\"$font_face\" color=\"$font_color\" size=\"1\"><img src=\"$base_gif/$data[color].gif\" width=\"$img_width\" height=\"$img_height\"> $vote_val</font></td>
        </tr>\n";
  }
?>
       </table>
       <font face="<?php echo $font_face; ?>" color="<?php echo $font_color; ?>" size="1"><br>
       <?php echo $total_text; ?>: <font color="#CC0000"><?php echo $poll_sum['total']; ?></font><br>
       <?php if($vote_stat==1) echo $voted; ?><br><br><div align="center">
       <?php if($row['comments']==1) echo "<a class=\"links\" href=\"javascript:void(window.open('$comment_page?action=send&amp;id=$poll_id','$poll_id','width=230,height=320,toolbar=no,statusbar=no'))\">$send_com"; ?></a>&nbsp;</div></font>
       </td></tr>
      <tr><td height="32">&nbsp;</td></tr>
     </table>
    <font face="<?php echo $font_face; ?>" size="1"><a href="http://www.proxy2.de" target="_blank"><acronym title="Advanced Poll">Version <?php echo $poll_version; ?></acronym></a></font></td>
   </tr>
 </table>
</td>
</tr>
</table>
<?php }

function check_poll_ip() {
  global $db_connect, $ip;
  global $poll_id, $sql_ip, $lock_timeout;
  $this_time = time()-$lock_timeout*3600;
  $db_connect->query("DELETE FROM $sql_ip WHERE (timestamp < $this_time)");
  $result = $db_connect->query("SELECT * from $sql_ip WHERE (ip_addr = '$ip' and poll_id='$poll_id')");
  $ips = $db_connect->fetch_array($result);
  return ($ips) ? 1 : 0;
}

function do_vote() {
  global $db_connect, $sql_index, $sql_data, $sql_ip, $sql_log, $check_ip, $logging, $poll_id, $vote_for;
  global $ip, $HTTP_USER_AGENT;
  $poll_result = $db_connect->query("UPDATE $sql_data SET votes=votes+1 WHERE (poll_id='$poll_id') AND (option_id='$vote_for')");
  $log_result = $db_connect->query("SELECT logging as logging FROM $sql_index WHERE (poll_id = '$poll_id')");
  $row = $db_connect->fetch_array($log_result);
  $this_time = time();
  if ($check_ip >= 2) {
    $db_connect->query("INSERT INTO $sql_ip (poll_id,ip_addr,timestamp) VALUES ('$poll_id','$ip','$this_time')");
  }
  if ($row['logging'] == 1) {
    $host = @gethostbyaddr($ip);
    $agent = $HTTP_USER_AGENT;
    if (!$agent) {
      $agent = @getenv("HTTP_USER_AGENT");
    }
    $db_connect->query("INSERT INTO $sql_log (poll_id,option_id,timestamp,ip_addr,host,agent) VALUES ('$poll_id','$vote_for','$this_time','$ip','$host','$agent')");
  }
}

if (isset($random_poll)) {
  if (!isset($poll_id)) {
    $results = $db_connect->query("select poll_id from $sql_index where (status = '1')");
    while ($pollrow = $db_connect->fetch_array($results)) {
      $poll_ids[] = $pollrow["poll_id"];
    }
    if (!isset($poll_ids)) {
      echo "<b>No active polls available!</b>";
      exit();
    }
    $available = sizeof($poll_ids)-1;
    if ($available >0) {
      srand((double) microtime() * 1000000);
      $random_poll = rand(0,$available);
    } else {
      $random_poll=0;
    }
    $poll_id = $poll_ids[$random_poll];
  }
} elseif (isset($newest_poll)) {
  if (!isset($poll_id)) {
    $results = $db_connect->query("select poll_id from $sql_index where (status < '2') order by timestamp desc limit 1");    
    $pollrow = $db_connect->fetch_array($results);
    if (!$pollrow) {
      echo "<b>No active polls available!</b>";
      exit();
    }
    $poll_id = $pollrow['poll_id'];
  }
} elseif (!isset($poll_id)) {
  echo "<b>Poll ID is not set!</b>";
  exit();
}

$poll_result = $db_connect->query("SELECT * FROM $sql_index WHERE (poll_id = '$poll_id' and status < '2')");
$row = $db_connect->fetch_array($poll_result);
if (!$row) {
  echo "<b>Poll ID ".$poll_id." does not exist!</b>";
  exit();
}
if ($row["status"] == 0) {
  $valid = 0;
} elseif ($row["expire"] == 1) {
  if ($row["exp_time"]<time()) {
    $valid = 0;
  }
}

$question = htmlspecialchars($row['question']);
$pollcookie = "AdvancedPoll".$poll_id;

if (!isset($action)) {
  $action = '';
}

switch ($action) {
  case "results":
    view_results($poll_id,0);
    break;

  case "vote":
    if ($valid == 0) {
      view_results($poll_id,0);
      break;
    } elseif (isset($vote_for)) {
      if(isset($$pollcookie)) {
        $found=1;
      }
      if ($check_ip == 2) {
        $found_ip = check_poll_ip();
        $found = ($found==0) ? $found_ip : 1;
      }
      if ($found==0) {
        do_vote();
      }
    }
    view_results($poll_id,$found);
    break;

  default:
    if ($valid == 0) {
      view_results($poll_id,0);
      break;
    }
    if(isset($$pollcookie)) {
      $found=1;
    }
    if ($check_ip == 2) {
      $found_ip = check_poll_ip();
      $found = ($found==0) ? $found_ip : 1;
    }
    if ($found==1) {
      view_results($poll_id,1);
      break;
    }
    display_poll($poll_id);
    break;
}

?>