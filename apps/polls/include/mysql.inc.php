<?php

class db_sql {

  var $conn_id, $result, $record;

  function connect ($host,$user,$pwd,$dbname) {
    $this->conn_id = mysql_connect($host,$user,$pwd);
    if ($this->conn_id == 0) {
      $this->sql_error("Connection Error");
    }
    if (!mysql_select_db($dbname, $this->conn_id)) {
      $this->sql_error("Select DB Error");
    }
    return $this->conn_id;
  }

  function query($query_string) {
    $this->result = mysql_query($query_string,$this->conn_id);  
    if (!$this->result) {
      $this->sql_error("Query Error");
    } 
    return $this->result;
  }

  function fetch_array($query_id) {
    $this->record = mysql_fetch_array($query_id,MYSQL_ASSOC);
    return $this->record;
  }
    
  function num_rows($query_id) {
    return mysql_num_rows($query_id);
  }
  
  function free_result($query_id) {
    return mysql_free_result($query_id);
  }
  
  function sql_error($message) {
    global $admin_mail,$sql_hostname;
    $description = mysql_error();
    $number = mysql_errno();
    $error ="MySQL Error : $message\n";
    $error.="Error Number: $number $description\n"; 
    $error.="Date        : ".date("D, F j, Y H:i:s")."\n";
    $error.="IP          : ".getenv("REMOTE_ADDR")."\n";
    $error.="Browser     : ".getenv("HTTP_USER_AGENT")."\n";
    $error.="Referer     : ".getenv("HTTP_REFERER")."\n";
    echo "<b><font size=4 face=Arial>$message</font></b><hr>";
    echo "<pre>$error</pre>";
    exit();
  }

}

?>