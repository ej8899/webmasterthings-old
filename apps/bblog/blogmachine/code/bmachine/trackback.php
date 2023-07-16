<?php

/*
  ===========================

  boastMachine v3.0 Platinum
  Released : Saturday, October 26th 2004 ( 10/26/2004 )

  Developed by Kailash Nadh
  Email   : kailash@bnsoft.net
  Website : www.kailashnadh.name
			www.bnsoft.net

  boastMachine
  Email   : kailash@boastology.com
  Website : www.boastology.com

  ===========================

*/


	include_once dirname(__FILE__)."/config.php";
	include_once dirname(__FILE__)."/$bmc_dir/main.php";

	$vars=explode("/", $_SERVER['REQUEST_URI']); // The URI (path)
	$post_id=$vars[count($vars)-1];
	$blog_id=$vars[count($vars)-2];


	//================== SEND TRACKBACKS =======================

	// This code works when the flag $send_track_back is set to true
	// Only used while posting a new article

	if(isset($send_track_back)) {
		$urls=$_POST['track_urls'];
		$urls=explode("\n", $urls); // The url list to be trackbacked

		$title=urlencode($_POST['title']);
		$excerpt=urlencode(substr($_POST['smr'],0,255)); // Cut the characters at 255

		$blog_name=urlencode($i_blog['blog_name']); // Cut the characters at 75

		$url=$bmc_vars['c_urls']."/".BLOG_FILE."?id=".$post_id['id']; // The perma link for this post

		// Send pings!
		for($n=0;$n<count($urls);$n++) {

		// Get the host url, parse it and take out the domain and the path
		$the_host=$urls[$n];
		$the_host=str_replace("http://","",$the_host);
		$the_host=str_replace("https://","",$the_host);
		$the_host=explode("//",$the_host);
		$the_host=$the_host[1];

		$the_host=explode("/",$the_host);

		$host=trim($the_host[0]); // The host domain name
		unset($the_host[0]);
		$path="/".trim(implode("/",$the_host)); // The path

			if(!empty($path) && !empty($host)) {
				$query = "title=$title&url=$url&excerpt=$excerpt&blog_name=$blog_name";
				$fp = fsockopen("$host", 80, $errnum, $errstr, 30); // Send the ping
				if($fp) { 
					fputs($fp, "POST {$path} HTTP/1.1\r\n"); 
					fputs($fp, "Host: {$host}\r\n"); 
					fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n"); 
					fputs($fp, "Content-length: ".strlen($query)."\r\n"); 
					fputs($fp, "Connection: close\r\n\r\n"); 
					fputs($fp, $query . "\r\n\r\n");
					fclose($fp);
				}
			}
		}

	return false;
	}

	//================== ACCEPTING TRACKBACKS =======================

	// Get the blog/post ids from the trackback uri


	$track_blog=$db->query("SELECT id FROM ".MY_PRF."blogs WHERE frozen='0' AND id='{$blog_id}'", false);
	$track_post=$db->query("SELECT id FROM ".MY_PRF."posts WHERE m_trackback='1' AND status ='1' AND blog='{$track_blog['id']}' AND id='{$post_id}'", false);

	if(!isset($track_post['id'])) {
		bmc_trackback_respond(1,"Invalid target post");
	}

	// Empty parameters
	if(!$post_id || !is_numeric($post_id) || !$blog_id || !is_numeric($blog_id)) {
		bmc_trackback_respond(1,"Missing post info");
	}

	// Get the posted variables
	if(!empty($_REQUEST)) {
		if(empty($_REQUEST['title']) || empty($_REQUEST['url'])) {
			bmc_trackback_respond(1,"Missing required fields");
		}
	} else {
		bmc_trackback_respond(1,"Missing required fields");
	}


$title=urldecode(substr($_REQUEST['title'],0,75)); // Cut the characters at 75
$url=urldecode($_REQUEST['url']);

// The excerpt ( summary )
if(!empty($_REQUEST['excerpt'])) {
	$excerpt=urldecode(substr($_REQUEST['excerpt'],0,255)); // Cut the characters at 255
} else {
	$excerpt=$title;
}

// The blog name
if(!empty($_REQUEST['blog_name'])) {
	$blog_name=urldecode(substr($_REQUEST['blog_name'],0,75));
} else {
	$blog_name="";
}

	// Save the data
	$db->query("INSERT INTO ".MY_PRF."trackbacks (title,url,excerpt,blog_name,date,post) VALUES('{$title}','{$url}','{$excerpt}','{$blog_name}','".time()."','{$track_post['id']}')");

	// Send the response
	bmc_trackback_respond(1, "Ping accepted");

	// Trackback reciption ends here!
	//====================================================




//============ Function to send response in XML format

function bmc_trackback_respond($error=0,$text="") {

$fp=fopen(CFG_ROOT."/inc/vars/track.log", "w+");
fputs($fp, serialize($_REQUEST));
fclose($fp);


	header("Content-type: text/xml\n\n"); // XML header
echo <<<EOF
	<?xml version="1.0" encoding="iso-8859-1"?>
	<response>
	<error>$error</error>
	<message>$text</message>
	</response>
EOF;
exit;
}

?>