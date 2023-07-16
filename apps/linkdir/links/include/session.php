<? 
$session_key = "id"; 
$session_value = "data"; 
$session_time = "expire"; 
$sdbh = ""; 
$expire =  300; 
function sess_open($save_path, $session_name){ 
	global $dbhost, $dbuser, $dbpasswd, $sdbh; 
	if (! $sdbh = mysql_pconnect($dbhost, $dbuser, $dbpasswd)){ 
		echo mysql_error(); 
		exit; 
	} 
	return true; 
} 
function sess_close(){ 
	return true; 
} 
function sess_read($key){ 
	global $sdbh, $dbname, $tb_sessions, $session_key, $session_value, $session_time; 
	$query = " 
		select 
			$session_value 
		from 
			$tb_sessions 
		where 
			$session_key = '$key' 
		and 
			$session_time > UNIX_TIMESTAMP() 
	"; 
	$result = mysql_db_query($dbname, $query, $sdbh); 
	if($record = mysql_fetch_row($result)){ 
		return $record[0]; 
	} else { 
		return false; 
	} 
} 
function sess_write($key, $val){ 
	global $sdbh, $dbname, $tb_sessions, $expire; 
	$value = addslashes($val); 
	$query = " 
		replace into  
			$tb_sessions 
		values ( 
			'$key', 
			'$value', 
			UNIX_TIMESTAMP() + $expire 
		) 
	"; 
	$result = mysql_db_query($dbname, $query, $sdbh); 
	echo mysql_error(); 
	return $result; 
} 
function sess_destroy($key){ 
	global $sdbh, $dbname, $tb_sessions, $session_key; 
	$query = " 
		delete from 
			$tb_sessions 
		where 
			$session_key = '$key' 
	"; 
	$result = mysql_db_query($dbname, $query, $sdbh); 
	return $result; 
} 
function sess_gc($maxlifetime){ 
	global $sdbh, $dbname, $tb_sessions, $session_time; 
	$query = " 
		delete from 
			$tb_sessions 
		where 
			$session_time < UNIX_TIMESTAMP() 
	"; 
	$result = mysql_db_query($dbname, $query, $sdbh); 
	return mysql_affected_rows($sdbh); 
} 

session_set_save_handler("sess_open","sess_close","sess_read","sess_write","sess_destroy","sess_gc"); 
?> 
