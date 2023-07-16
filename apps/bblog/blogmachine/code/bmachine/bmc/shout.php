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


//======================== SHOUT BOX MODULE

$shout=true; // Enable shout box?
$max_posts=5; // Maximum number of posts
$max_chars=100; // Mazimum number of characters to be allowed in the message
$smile=true; // Allow smilies?
$width=200; // Frame width
$height=200; // Frame height
$border=1; // Frame border
$border_color="#AAAAAA";

//==================================

include_once dirname(__FILE__)."/main.php";
// Check whether shout box is enabled
if(!$shout) {
	die($lang['no_shout']);
}


// Save a post
if(isset($_POST['action']) && $_POST['action'] == "save" && !empty($_POST['name']) && !empty($_POST['msg'])) {

	$data=@fread(fopen(CFG_ROOT."/inc/vars/shout.dat","r"), filesize(CFG_ROOT."/inc/vars/shout.dat"));
	$data=trim($data);
	$data=explode("\n",$data);

	$num=count($data);

	// Cut out || from the posted data
	$name=trim(str_replace("||","|",$_POST['name']));
	$email=trim(str_replace("||","|",$_POST['email']));
	$msg=trim(str_replace("||","|",$_POST['msg']));

	$date=time();
	$ip=$_SERVER['REMOTE_ADDR']; // The poster's ip

	$msg=str_replace("\n"," ",$msg); // Strip the line breaks

	// Formatted data
	$str="$name||$email||$date||$ip||$msg";

	if($num >= $max_posts) {
		// If the number of entries exceed the max allowed, remove the oldest entry
		unset($data[0]);
		$data[]=$str;
		$data=implode("\n",$data);
	} else {
		$data=implode("\n",$data);
		$data.="\n".$str;
	}


	// Save the data
	$f=fopen(CFG_ROOT."/inc/vars/shout.dat", "w+");
	fputs($f,$data);
	fclose($f);

	bmc_Go("shout.php?action=show"); // Redirect
	exit;
}

// ========================

if(isset($_GET['action']) && $_GET['action']=="add") {
	// Show the 'ADD SHOUT' form
	include CFG_PARENT."/templates/".CFG_THEME."/shout.inc.php";
	exit;
}


if(isset($_GET['action']) && $_GET['action'] == "show") {
	$data=@fread(fopen(CFG_ROOT."/inc/vars/shout.dat","r"), filesize(CFG_ROOT."/inc/vars/shout.dat"));
	$data=explode("\n",$data);
	$data=array_reverse($data); // Reverse the order of entries


	if(!count($data)) { exit; } // there are no posts


	// Collect the data and parse into an array
	for($n=0;$n<=count($data);$n++) {
		list($name,$email,$date,$ip,$msg)=explode("||",$data[$n]);
		$msg=str_replace("\\n","\n",$msg);

		if(trim($name)) {
			$posts['name'][$n]=bmc_htmlentities($name);
			$posts['email'][$n]=bmc_htmlentities($email);
			$posts['msg'][$n]=bmc_htmlentities(noSlash($msg));
			$posts['date'][$n]=$date;
			$posts['ip'][$n]=$ip;
		}
	}

	include CFG_PARENT."/templates/".CFG_THEME."/shout.inc.php";
}

else {

	$path=$bmc_vars['c_urls'].BMC_DIR."/shout.php?action=show";
	?>

	<script type="text/javascript">
	<!--
		document.writeln("<iframe src=\"<?php echo $path; ?>\" name=\"shout\" style=\"border-width: <?php echo $border; ?>px; border-style:solid;  border-color: <?php echo $border_color; ?>;\" frameborder=\"0\" height=\"<?php echo $height; ?>\" width=\"<?php echo $width; ?>\"></iframe>\n");
	//-->
	</script>
	<br /><a href="<?php echo BMC_DIR."/"; ?>shout.php?action=add" target="shout"><strong>Post</strong></a>

	<?php
}
	?>