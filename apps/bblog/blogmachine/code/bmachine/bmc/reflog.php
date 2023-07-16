<?php


/*
  ===========================

  boastMachine v3.0 Platinum
  Released : Sunday, October 17th 2004 ( 10/17/2004 )
  http://boastology.com

  Developed by Kailash Nadh
  Email   : kailash@bnsoft.net
  Website : www.kailashnadh.name
			www.bnsoft.net

  boastMachine is a free software and is licensed under GPL (General public license)

  ===========================
*/


$enable_log=true; // Enable logging?
$num_ref=20; // number of referers to be logged


//=========================== End user config =======================

if(!$enable_log || isset($_COOKIE['bmc_ref_log']) || empty($_GET['i'])) { exit; }

setcookie("bmc_ref_log", '101');

	$ip=$_SERVER['REMOTE_ADDR'];
	$referer=$_GET['i'];


	if(!$referer || !$ip) { exit; }

	$time=time();

	$str="$time||$ip||$referer\n";


	$data=@fread(@fopen(dirname(__FILE__)."/inc/vars/ref.log","r"), @filesize(dirname(__FILE__)."/inc/vars/ref.log"));
	$data=trim($data);
	$refs=$data;

	$data=explode("\n",$data);

	$a=fopen(dirname(__FILE__)."/inc/vars/ref.log", "w+");

	if(count($data) > $num_ref) {
	$refs=NULL;

		for($n=0;$n<$num_ref;$n++) {
			if(trim($data[$n])) { $refs.=trim($data[$n])."\n"; }
		}
	}

	fputs($a,$str.trim($refs));

	fclose($a);

?>