<?php
//
// call with
// 	include("http://www.webmasterthings.com/apps/counter/counter.php?name=mnp-jokes");
//

$wtowner=1000;
include("../wtuserinfo.php");

$dbhost		=	"$wtserver";
$db		=	"$wtdatabase";
$dbuser		=	"$wtdb_user";
$dbpasswd	=	"$wtdb_pass";
$table		=	"wt_counter";

mysql_connect("$dbhost","$dbuser","$dbpasswd")
	or die("Unable to connect to SQL server!");
@mysql_select_db("$db")
	or die("Unable to select database!");

if(!$name) { $name = "default"; }

$query = mysql_query("select * from $table where name=\"$name\"");
while ($row  =  mysql_fetch_array($query)) {
		$start = $row[start];
		$count = $row[count];
}

if(!$count) {
	mysql_query("insert into $table values (current_date()+0,\"1\",\"$name\")");
	$count = "1";
}

print("$count");

$count++;
mysql_query("update $table set count=\"$count\" where name=\"$name\"");
?>
