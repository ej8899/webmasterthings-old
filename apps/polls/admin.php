<?php
///////////////////////////////////////////////////
//  Advanced Poll 1.61 (PHP/MySQL)               //
//  Copyright (c)2001 Chi Kien Uong              //
//  URL: http://www.proxy2.de                    //
///////////////////////////////////////////////////

$poll_version = "v1.61";
require ("./include/config.inc.php");
require ("./include/$poll_db");
$db_connect = new db_sql;
$db_connect->connect($sql_hostname, $sql_username, $sql_password, $dbName);

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

function enter_pass($message) {
  global $db_connect, $sql_config;
  global $poll_version, $PHP_SELF;
  include ("./admin/admin_login.php");
}

function poll_index() {
  global $db_connect, $sql_index, $sql_username, $sql_hostname;
  global $sql_config, $entry, $poll_version, $log_in, $PHP_SELF;
  include ("./admin/admin_index.php");
}

function poll_new($message) {
  global $db_connect, $sql_index;
  global $sql_config, $poll_version, $log_in, $PHP_SELF;
  include ("./admin/admin_new.php");
}

function poll_help() {
  global $db_connect, $sql_index;
  global $sql_config, $path, $poll_version, $log_in, $PHP_SELF;
  include ("./admin/admin_help.php");
}

function poll_license() {
  global $db_connect, $sql_index;
  global $sql_config, $poll_version, $log_in, $PHP_SELF;
  include ("./admin/admin_license.php");
}

function create_poll() {
  global $db_connect, $sql_index, $sql_data;
  global $logging, $expire, $exp_time, $status, $comments;
  global $option_id,$question,$color;
  $timestamp = time();
  if (!isset($expire)) {
    $expire=1;
  }
  if (!isset($comments)) {
    $comments=0;
  }
  if (!isset($exp_time)) {
    $exp_time=$timestamp;
  } else {
    $exp_time=$timestamp+$exp_time*86400;
  }
  if (!get_magic_quotes_gpc()) {
    $question = addslashes($question);
  }
  $db_connect->query("INSERT INTO $sql_index (question,timestamp,status,logging,exp_time,expire,comments) VALUES ('$question','$timestamp','$status','$logging','$exp_time','$expire','$comments')");
  $sql_result = $db_connect->query("SELECT poll_id FROM $sql_index WHERE timeStamp=$timestamp");
  $db_connect->fetch_array($sql_result);
  $poll_id = $db_connect->record['poll_id'];
  for($i=1; $i <= sizeof($option_id); $i++) {
    $option_id[$i] = trim($option_id[$i]);
    if (!empty($option_id[$i])) {
      if (!get_magic_quotes_gpc()) {
        $option_id[$i] = addslashes($option_id[$i]);
      }
      $db_connect->query("INSERT INTO $sql_data (poll_id, option_id, option_text, color, votes) VALUES('$poll_id', '$i', '$option_id[$i]','$color[$i]',0)");
    }
  }
}

function poll_edit($entry_id,$message) {
  global $db_connect, $sql_index, $sql_config, $sql_data;
  global $poll_version, $log_in, $PHP_SELF;
  include ("./admin/admin_edit.php");
}

function save($poll_id) {
  global $db_connect, $sql_index, $sql_data;
  global $option_id, $votes, $color, $status, $logging, $question, $exp_time, $expire, $comments;
  if (!isset($expire)) {
    $expire=1;
  }
  if (!isset($comments)) {
    $comments=0;
  }
  $exp_time=time()+$exp_time*86400;
  $question = trim($question);
  if (!empty($question)) {
    if (!get_magic_quotes_gpc()) {
      $question = addslashes($question);
    }
    $db_connect->query("UPDATE $sql_index set question='$question', status='$status', logging='$logging', exp_time='$exp_time', expire='$expire', comments='$comments' where (poll_id = '$poll_id')");
    $result = $db_connect->query("select max(option_id) as max_option from $sql_data where (poll_id = '$poll_id')");
    $data = $db_connect->fetch_array($result);
    for($i=1; $i <= $data["max_option"]; $i++) {
      if (!isset($option_id["$i"])) {
        continue;
      }
      $option_id["$i"] = trim($option_id["$i"]);
      if (!empty($option_id[$i])) {
         if (!eregi("^[0-9]+$", $votes[$i])) {
           $votes[$i] = 0;
         }
         if (!get_magic_quotes_gpc()) {
           $option_id[$i] = addslashes($option_id[$i]);
         }
         $db_connect->query("UPDATE $sql_data set option_text='$option_id[$i]', color='$color[$i]', votes='$votes[$i]' where (poll_id = '$poll_id' and option_id = '$i')");
      } elseif (sizeof($option_id) > 2) {
        $db_connect->query("DELETE FROM $sql_data where (poll_id = '$poll_id' and option_id = '$i')");
      } else {
        $message = "EditOp";
      }
    }
    $message = "Updated";
  } else {
     $message = "NewNoQue";
  }
  return $message;
}

function poll_extend($poll_id) {
  global $db_connect, $sql_index, $sql_data;
  global $sql_config, $poll_version, $log_in, $PHP_SELF;
  include ("./admin/admin_options.php");
}

function add_options($poll_id,$last_id) {
  global $db_connect, $sql_data;
  global $option_id,$color;
  for($i=$last_id; $i < $last_id+10; $i++) {
   $option_id["$i"] = trim($option_id["$i"]);
   if (!empty($option_id["$i"])) {
     if (!get_magic_quotes_gpc()) {
       $option_id["$i"] = addslashes($option_id["$i"]);
     }
     $db_connect->query("INSERT INTO $sql_data (poll_id, option_id, option_text, color, votes) VALUES('$poll_id', '$i', '$option_id[$i]','$color[$i]',0)");
     $added = 1;
   }
  }
  return (isset($added)) ? "EditOk" : "EditNo";
}

function update_settings() {
  global $db_connect, $sql_config;
  global $base_gif,$title,$img_height,$img_length,$table_width,$bgcolor_tab,$bgcolor_fr;
  global $font_face,$font_color,$type,$check_ip,$lock_timeout,$time_offset,$logging;
  global $lang, $vote_button, $total_text, $result_text, $voted, $send_com, $entry_pp;
  if (!eregi(".php|.php3", $lang)) {
    $lang = "english.php";
  }
  if (!eregi("^[0-9]+$", $entry_pp) || $entry_pp==0) {
    $entry_pp = 1;
  }
  $sqlquery= "UPDATE $sql_config set base_gif='$base_gif', lang='$lang', title='$title', vote_button='$vote_button', result_text='$result_text', total_text='$total_text', voted='$voted', send_com='$send_com', img_height='$img_height', img_length='$img_length', ";
  $sqlquery.="table_width='$table_width', bgcolor_tab='$bgcolor_tab', bgcolor_fr='$bgcolor_fr', font_face='$font_face', ";
  $sqlquery.="font_color='$font_color', type='$type', check_ip='$check_ip', lock_timeout='$lock_timeout', time_offset='$time_offset', entry_pp='$entry_pp' WHERE (config_id = '1')";
  $result = $db_connect->query($sqlquery);
  return ($result) ? "Updated" : "NoUpdate";
}

function update_user($username,$userpass) {
  global $db_connect, $sql_user, $log_in;
  if ($db_connect->query("UPDATE $sql_user SET username='$username', userpass=PASSWORD('$userpass') WHERE session='$log_in'")) {
    return "Updated";
  } else {
    return "NoUpdate";
  }
}

function delete_poll($poll_id) {
  global $db_connect, $sql_index, $sql_data;
  global $sql_log, $sql_com;
  $db_connect->query("DELETE FROM $sql_data where (poll_id = '$poll_id')");
  $db_connect->query("DELETE FROM $sql_index where (poll_id = '$poll_id')");
  $db_connect->query("DELETE FROM $sql_log where (poll_id = '$poll_id')");
  $db_connect->query("DELETE FROM $sql_com where (poll_id = '$poll_id')");
}

function poll_settings($cat,$message) {
  global $db_connect, $sql_index;
  global $sql_data, $sql_config, $sql_log, $sql_user, $log_in, $poll_version, $PHP_SELF;
  if ($cat == "general") {
    include ("./admin/admin_settings.php");
  } elseif ($cat == "password") {
    include ("./admin/admin_pwd.php");
  }
}

function poll_stats($poll_id) {
  global $db_connect, $sql_index, $log_in;
  global $sql_data, $sql_log, $sql_config, $poll_version, $PHP_SELF;
  include ("./admin/admin_stat.php");
}

function poll_comments($poll_id) {
  global $db_connect, $sql_index, $log_in;
  global $sql_config, $sql_com, $entry, $poll_version, $PHP_SELF;
  include ("./admin/admin_comment.php");
}

function reset_log($poll_id) {
  global $db_connect, $sql_log;
  $db_connect->query("DELETE FROM $sql_log where (poll_id = '$poll_id')");
}

function delete_comment($poll_id,$message_id) {
  global $db_connect, $sql_com;
  $db_connect->query("DELETE FROM $sql_com where (com_id = '$message_id')");  
}

function start_session($username) {
  global $db_connect, $sql_user;
  srand((double)microtime()*1000000);
  $session = md5 (uniqid (rand()));
  $db_connect->query("UPDATE $sql_user SET session='$session' WHERE username='$username'");
  return $session;
}

function end_session($log_in) {
  global $db_connect, $sql_user;
  srand((double)microtime()*1000000);
  $session = md5 (uniqid (rand()));
  $db_connect->query("UPDATE $sql_user SET session='$session' WHERE session='$log_in'");
}

function check_pass($username,$password) {
  global $db_connect, $sql_user;
  $check_result = $db_connect->query("SELECT username FROM $sql_user WHERE username='$username' and userpass=PASSWORD('$password')");
  $row = $db_connect->fetch_array($check_result);
  return ($row) ? $row["username"] : false;
}

function get_session_id($log_in) {
  global $db_connect, $sql_user;
  $check_result = $db_connect->query("SELECT session FROM $sql_user WHERE session='$log_in'");
  $row = $db_connect->num_rows($check_result);
  return ($row) ? true : false;
}

if (!isset($log_in)) {
  $log_in = "";
}

if (isset($enter)) {
  if (!get_magic_quotes_gpc()) {
   $username = addslashes($username);
   $password = addslashes($password);
  }
  $user = check_pass($username,$password);
  if ($user) {
    $log_in = start_session($user);
    poll_index();
  } else {
    enter_pass('FormWrong');
  }
}

elseif (get_session_id($log_in)) {

if (!isset($action)) {
  $action ='';
}
switch ($action) {

case "new":
  poll_new("NewTitle");
  break;

case "help":
  $path = dirname(__file__);
  poll_help();
  break;

case "delete":
  if (isset($id)) {
    delete_poll($id);
  }
  poll_index();
  break;

case "stats":
  if (isset($id)) {
    poll_stats($id);
  } else {
    poll_index();
  }
  break;
  
case "comments":
  if (isset($id)) {
    poll_comments($id);
  } else {
    poll_index();
  }
  break;

case "remove":
  if (isset($id)) {
    delete_comment($id,$mess_id);
    poll_comments($id);
  } else {
    poll_index();
  }
  break;  

case "reset":
  if (isset($id)) {
    reset_log($id);
    poll_stats($id);
  } else {
    poll_stats($id);
  }
  break;

case "update":
  if (!get_magic_quotes_gpc() and is_array($GLOBALS)==1) {
    while(list($key,$val)=each($GLOBALS)) {
      if (is_string($val)==1) {
        $GLOBALS[$key]=addslashes($val);
      }
    }
  }
  $message = update_settings();
  poll_settings("general",$message);
  break;

case "update_pwd":
  if (!empty($NEWadmin_name)) {
    $username = trim($NEWadmin_name);
    if (!get_magic_quotes_gpc()) {
      $username = addslashes($username);
    }
  }
  if (!empty($NEWadmin_pass)) {
    $userpass = trim($NEWadmin_pass);
    if (!get_magic_quotes_gpc()) {
      $userpass = addslashes($userpass);
    }
  }
  $message = update_user($username,$userpass);
  poll_settings("password",$message);
  break;

case "edit":
  if (isset($id)) {
    poll_edit($id,"EditText");
  } else {
    poll_index();
  }
  break;

case "show":
  poll_index();
  break;

case "extend":
  if(isset($add)) {
    $message = add_options($id,$last_id);
    poll_edit($id,$message);
  } else {
    poll_extend($id);
  }
  break;

case "save":
  $message = save($id);
  poll_edit($id,$message);
  break;

case "create":
  $question = trim($question);
  if (!empty($question)) {
    create_poll();
    poll_index();
  } else {
    poll_new("EditMis");
  }
  break;

case "settings":
  if ($panel == "general") {
    poll_settings("general","SetText");
  } elseif ($panel == "password") {
    poll_settings("password","PwdText");
  } else {
    poll_index();
  }
  break;

case "logout":
  end_session($log_in);
  enter_pass("FormEnter");
  break;

case "license":
  poll_license();
  break;

default:
  poll_index();
  break;
}

} else {
  enter_pass("FormEnter");
}

?>