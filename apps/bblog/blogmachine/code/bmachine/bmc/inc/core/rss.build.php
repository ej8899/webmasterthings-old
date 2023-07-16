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

	if(!defined('IN_BMC')) {
		die("Access Denied!");
	}


// =======================
// General configuration

$rss_date="r"; 
	// RFC 822 compliant date formatting string

$rss_cache=true;
	// Cache the XML feeds? Caching decreases the database load and

$rss_trunc=500;
	// The maximum number of characters of the summary of the post to be published

$rss_total=10;
	// Total number of posts to be displayed



// =======================
// Get the feed type requested for
// 1 = RSS .90 , 2 = RSS 2.0 , 3 = Atom .03


// Check whether RSS feeds are enabled glboally, and for this blog

if(!$bmc_vars['m_rss'] || !$i_blog['m_rss']) {
	return;
}

if(defined('BLOG') && BLOG) {
	$blog=BLOG;
} else {

	if(isset($i_blog)) {
		$blog=$i_blog['id'];
	} else {
		return false;
	}
}

	// ========== Do some basic preparations, common for all feeds

	// The basic XML headers
/*
//	header("Content-type: text/xml\n\n");
//	echo "<?xml version=\"1.0\"?>"; */

	$now=date($rss_date); // Present time

	// Get the posts data from the DB

	if(!isset($i_blog)) {
		$this_blog=$db->query("SELECT blog_name,blog_info,blog_file FROM ".MY_PRF."blogs WHERE id='{$blog}' AND frozen='0'",false);
	} else {
		$this_blog=$i_blog;
	}

	$result=$db->query("SELECT id,title,summary,author,date FROM ".MY_PRF."posts WHERE blog='{$blog}' AND status='1' ORDER BY date DESC LIMIT 0,$rss_total");

	$blog_url=$bmc_vars['c_urls']."/".$this_blog['blog_file'];
	$blog_archive=$bmc_vars['c_urls']."/archives/?blog=".$this_blog['id'];
	$this_blog['blog_name']=bmc_cleanXMLtags($this_blog['blog_name']);
	$this_blog['blog_info']=bmc_cleanXMLtags($this_blog['blog_info']);

	$rss_1="";
	$rss_2="";
	$atom="";

//============== CREATE THE RSS .92 AND RSS 2 FEED FOR ==============

$file_name=str_replace(".php","",$this_blog['blog_file']);

$fp_1=fopen(CFG_PARENT."/rss/".$file_name."_rss1.xml", "w+") or bmc_Template($lang['post_rss_no']);
$fp_2=fopen(CFG_PARENT."/rss/".$file_name."_rss2.xml", "w+") or bmc_Template($lang['post_rss_no']);
$fp_3=fopen(CFG_PARENT."/rss/".$file_name."_atom.xml", "w+") or bmc_Template($lang['post_rss_no']);

$ver=BMC_VERSION;
$rss_1=<<<EOF
<!-- generator="boastMachine $ver" -->
<rss version=".92">
 <channel>
	<title>{$this_blog['blog_name']}</title>
	<link>$blog_url</link>
	<description>{$this_blog['blog_info']}</description>
	<language>en</language>
	<docs>http://backend.userland.com/rss092</docs>

EOF;
fputs($fp_1, $rss_1);



$rss_2=<<<EOF
<!-- generator="boastMachine $ver" -->
<rss version="2.0">
 <channel>
	<title>{$this_blog['blog_name']}</title>
	<link>$blog_url</link>
	<description>{$this_blog['blog_info']}</description>
	<language>en</language>
	<docs>http://backend.userland.com/rss092</docs>
	<pubDate>$now</pubDate>
	<managingEditor>{$bmc_vars['c_email']}</managingEditor>
	<webMaster>{$bmc_vars['c_email']}</webMaster>

EOF;
fputs($fp_2, $rss_2);

// The unique ID for this blog
$atom_id="tag:".str_replace("http://","",$bmc_vars['c_urls'])."/".BLOG_FILE.",".date("Y-m-d").":/archives/".BLOG;

$atom=<<<EOF
<feed version="0.3" xmlns="http://purl.org/atom/ns#" xml:lang="en">
  <title>{$this_blog['blog_name']}</title>
  <tagline>{$this_blog['blog_info']}</tagline>
  <link rel="alternate" type="text/html" href="{$blog_archive}"/>
  <id>{$atom_id}</id>
  <copyright>Copyright (c) {$bmc_vars['c_urls']}</copyright>
  <modified>{$now}</modified>

EOF;
fputs($fp_3, $atom);

	foreach($result as $post) {

		// ==== Prepare the variables
		// ==== We use bmc_cleanXMLtags() to make the text safe for xml pages

		$title=bmc_cleanXMLtags($post['title']);
		$desc=bmc_cleanXMLtags($post['summary']);
		$id=bmc_cleanXMLtags($post['id']);
		$date=date($rss_date,$post['date']);
		$url=bmc_cleanXMLtags("{$bmc_vars['c_urls']}/{$this_blog['blog_file']}?id=$id");
		$catid=$post['cat'];

		if(strlen($desc)>500) { $desc=substr($desc,0,500)." .."; } // if the description is too long, truncate it

	// Get the category name
	$cat = $db->query( "SELECT cat_name FROM ".MY_PRF."cats WHERE id='{$catid}'", false );
	$cat = bmc_cleanXMLtags($cat['cat_name']);


// Print the RSS .92 tags
$rss_1=<<<EOF
    <item>
      <title>$title</title>
      <description>$desc</description>
      <link>$url</link>
    </item>

EOF;
fputs($fp_1, $rss_1);



// Print the RSS 2.0 tags
$rss_2=<<<EOF
    <item>
      <title>$title</title>
      <description>$desc</description>
      <link>$url</link>
      <pubDate>$date</pubDate>
      <category>$cat</category>
      <comments>{$url}#cmt</comments>
    </item>

EOF;
fputs($fp_2, $rss_2);


$auth_url=bmc_cleanXMLtags($bmc_vars['c_urls']."/profile.php?id=".$post['author']); // The user's profile page

$user=bmc_dispUser($post['author']); // The user's display name

$atom_id="tag:".str_replace("http://","",$bmc_vars['c_urls'])."/".BLOG_FILE.",".date("Y-m-d").":/archives/".BLOG."/".$result['id'];

// Prints the Atom tags
$atom=<<<EOF
<entry>
  <title>$title</title>
  <link rel="alternate" type="text/html" href="$url"/>
  <issued>$date</issued>
  <modified>$now</modified>
  <id>$atom_id</id>
  <summary>$desc</summary>
  <link rel="related" type="text/html" href="$url" title="$title"/>
  <author>
    <name>$user</name>
    <url>$auth_url</url>
  </author>
</entry>

EOF;
fputs($fp_3, $atom);

	}



// Print the ending tags in .92 and 2.0 files
$xml="  </channel>\n</rss>";
fputs($fp_1, $xml);
fputs($fp_2, $xml);
fputs($fp_3, "\n\n</feed>");

fclose($fp_1);
fclose($fp_2);
fclose($fp_3);

//===========================================================

function bmc_cleanXMLtags($tag) {

	$tag=str_replace("<", "&lt;", $tag);
	$tag=str_replace(">", "&gt;", $tag);

	return utf8_encode($tag);
}


?>