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

	// ================== Full view mode (permalink)

	if(isset($_GET['id']) && is_numeric(trim($_GET['id']))) {
		$post=$db->query("SELECT * FROM ".MY_PRF."posts WHERE status='1' AND id='{$_GET['id']}'", false);

		if(!empty($post['password'])) {
			// Send the auth interface
			if( !isset($_SERVER['PHP_AUTH_PW']) || $_SERVER['PHP_AUTH_PW'] != $post['password']) {
				header('WWW-Authenticate: Basic realm="Password protected post @ '.BLOG_NAME.'"');
				header('HTTP/1.0 401 Unauthorized');
				bmc_Template('error_page', $lang['post_pass_invalid']);
			}
		}

		if(empty($post)) {
			bmc_template('error_page', $lang['no_id']);
		}

		echo bmc_printPost($post,true);
		exit; // POST FULL VIEW (Permalink page)
	}


	// ================== Printing in the list/summary mode

	// Page numbering..
	$per_page=$bmc_vars['p_page'];
	if(empty($_GET['p']) || $_GET['p'] < 0 || !is_numeric($_GET['p'])) { $pg=1; } else { $pg=trim($_GET['p']); }

	$start=($pg*$per_page)-$per_page;

	if(!isset($db) || !$db) $db=new bDb; // Create a new database object if none exists

	// Keep the post count under the limit
	if(($start+$per_page) > $bmc_vars['p_total']) {
		$per_page=$bmc_vars['p_total']-$per_page;
	}

	// Extra code for extracing posts in a specific category or date/month view

	// show by date
	if(isset($_GET['show']) && strlen($_GET['show']) <11 && strlen($_GET['show']) > 6) {
		$what="date";
	}

	// show by cat
	if(isset($_GET['cat']) && is_numeric($_GET['cat'])) {
		$what="cat";
	}

	$query_str="";

	if(isset($what)) {
		switch($what) {
			case 'cat':
				$sql="AND cat='{$_GET['cat']}'";
				$query_str="&amp;cat=".$_GET['cat'];
				break;


			case 'date':
				list($d_day,$d_month,$d_year)=explode(",", $_GET['show']);

				if(!is_numeric($d_month) || !is_numeric($d_year)) {
					break;
				}

				if(empty($d_day)) {
					$start_time=mktime(0,0,0,$d_month,1,$d_year);
					$end_time=mktime(0,0,0,($d_month+1),1,$d_year);
				} else {
					$start_time=mktime(0,0,0,$d_month,$d_day,$d_year);
					$end_time=mktime(0,0,0,$d_month,$d_day+1,$d_year);
				}
				$query_str="&amp;show=".$_GET['show'];
				$sql="AND date >= '{$start_time}' AND date <= '{$end_time}'";
			break;
		}
	}



	// 1st, check whether there are any Drafted posts
	$drafts=$db->query("SELECT id,draft_date FROM ".MY_PRF."posts WHERE status='2'");

	$now=time();

	if(!empty($drafts)) {
		foreach($drafts as $draft) {
			if($now >= $draft['draft_date']) {
				// If there are any drafted posts, whose date has already been passed, make it a normal post
				$db->query("UPDATE ".MY_PRF."posts SET status='1', date='{$draft['draft_date']}', draft_date='' WHERE id='{$draft['id']}' ");
			}
		}
	}


	// Do the query

	$post_count=$db->query("SELECT count(id) FROM ".MY_PRF."posts WHERE status='1' AND blog='".BLOG."' $sql",false);
	$post_count=$post_count['count(id)']; // Get the post count

	if($sql) {
		$posts=$db->query("SELECT id,user_ip,author,cat,date,title,summary,file,format,m_trackback,m_cmt,m_vote,m_autobr,password FROM ".MY_PRF."posts where status='1' AND blog='".BLOG."' $sql ORDER by date DESC");
	} else {
		$posts=$db->query("SELECT id,user_ip,author,cat,date,title,summary,file,format,m_trackback,m_cmt,m_vote,m_autobr,password FROM ".MY_PRF."posts where status='1' AND blog='".BLOG."' $sql ORDER by date DESC LIMIT $start,$per_page");

		if($bmc_vars['p_total'] < $post_count) {
			$post_count=$bmc_vars['p_total'];
		}
	}

	bmc_Template('page_header', $i_blog['blog_name'], $i_blog['blog_info'], true); // Page header

	// No posts
	if(!count($posts)) {
		bmc_template('error_page', $lang['no_data_avail']);
	}


	// Print the posts on the front page, the summaries
	$tmp_date=null;
	foreach($posts as $dat) {
		echo bmc_printPost($dat,false,$query_str);
	}


	$nm=$post_count; // Some preparations for the page numbering

	$x=$nm/$bmc_vars['p_page'];


	// Include the page number script
	include CFG_PARENT."/templates/".CFG_THEME."/page.num.php";

	bmc_Template('page_footer'); exit;




// ====================
// Function for printing the posts, either summary by summary or a whole post

function bmc_printPost($post_data,$full=false,$query_str=null) {
global $bmc_vars, $db, $lang;

	if(!$post_data) { return; }

	 // Create a new database object if none exists
	if(!$db) $db=new bDb;

	$blog=BLOG;

	$title=bmc_BlockWords($title);
	$title=bmc_htmlentities($post_data['title']);

		// Get the name of the category
		$cat = $db->query("SELECT cat_name FROM ".MY_PRF."cats WHERE id='{$post_data['cat']}'",false);
		$cat=$cat['cat_name'];

		// Get author's display id
		$user_name=bmc_dispUser($post_data['author']);

	$date=bmcDate($post_data['date']); // Convert the time stamp into readable format

	if(isset($post_data['file']) && !empty($post_data['file'])) {
		$tmp_file=strpos($post_data['file'],"-"); $tmp_file++;
		$file_name=substr($post_data['file'],$tmp_file,strlen($post_data['file']));
	} else {$file_name=""; }


	// Prepared the attached file list
	if($post_data['file']) {
		$files=explode("|",$post_data['file']); // Create an array of the posted filenames

		for($n=0;$n<count($files);$n++) {
			if(!empty($files[$n])) {
			$file_list.="<a href=\"".$bmc_vars['c_urls']."/files/{$files[$n]}\">{$files[$n]}</a><br />\n";
			}
		}
	} else {
		$file_list=false;
	}


// No post with the specified id was found!
if($full && !$title) {
	// A small language tweak
	bmc_template('error_page', $lang['no_id']);
}

	include_once CFG_ROOT."/inc/users/bbcode.php"; // bbCode script

// Article FULL view. Print out the whole post
if($full) {

	bmc_Template('page_header', "{$bmc_vars['s_title']} :: $cat :: $title", $post_data['keyws'], true);

	if(empty($post_data['data'])) {
		$msg=$post_data['summary']; // No post body, so enter the summary there
	} else {
		$msg=$post_data['data'];
	}

	$msg=bmc_Blockwords($msg); // Clear the bad words



	// Get the votes/rates
	if($bmc_vars['m_vote']) {
		$result=$db->query("SELECT * FROM ".MY_PRF."votes WHERE post='{$post_data['id']}'", false);

		// No one has voted for this post yet
		if(!isset($result['post'])) {
			$total_votes="0";
			$total_rating="0";
		} else {
			$total_votes=$result['number'];
			$total_rating=($result['total']/$total_votes);
			$total_rating=substr($total_rating,0,strpos($total_rating,".")+2);
		}		
	}

	// Clear off the HTML tags for TEXT posts
	if($post_data['format'] == "text") {
		$msg=bmc_htmlentities($msg);
		// Wrap text
	}

	// Convert the BB code
	$msg=BBCode($msg);

	// Wrap the text
	if($post_data['format']=="text") {
		$msg=bmc_wordwrap($msg);
	}

	// Smilify
	$msg=bmc_smilify($msg);

	// Autoconvert links if set
	if($post_data['m_autobr'] && $post_data['format'] == "text") {
		$msg=bmc_cnvAll($msg);
	}

	// Autobr if set
	if($post_data['m_autobr'] && $post_data['format'] == "text") {
		$msg=nl2br($msg);
	}

	// Include the main post template file
	include CFG_PARENT."/templates/".CFG_THEME."/main.template.php";

	// Show the comments for this post
	$comments=$db->query("SELECT * FROM ".MY_PRF."comments WHERE post='{$post_data['id']}' ORDER BY date");

	// Loop through the comments and display them
	foreach($comments as $cmt) {

		if($cmt['author']) {
			$author=bmc_dispUser($cmt['author']);
		} // end if


		$date=bmcDate($cmt['date']);
		$comment=bmc_htmlentities($cmt['data']);
		$comment=bmc_wordwrap($comment);
		$comment=bmc_BlockWords($comment);

		if($bmc_vars['m_cnv']) $comment=bmc_cnvall($comment); // Autoconvert the links

		$comment=bmc_Smilify($comment);
		$comment=nl2br($comment);

		include CFG_PARENT."/templates/".CFG_THEME."/comment.inc.php";
	}


	// Load the comment form
	include CFG_PARENT."/templates/".CFG_THEME."/comment.form.php";


bmc_Template('page_footer');
exit();

} // End main if


// ==================== PRINT THE SUMMARIES

// Total number of comments for this post
	$cmn = $db->row_count("SELECT id FROM ".MY_PRF."comments WHERE post='{$post_data['id']}'",false);


// Total number of trackbacks received by this post
if($post_data['m_trackback']) {
	$tracks = $db->row_count("SELECT id FROM ".MY_PRF."trackbacks WHERE post='{$post_data['id']}'");
} else {
	$tracks=0;
}


// TEXT FORMATTING //

	$summary=$post_data['summary']; // Strip of those unwanted slashes

	$summary=bmc_Blockwords($summary); // Clear the bad words


	// Clear off the HTML tags for TEXT posts
	if($post_data['format'] == "text") {
		$summary=bmc_htmlentities($summary);
	}

	// Convert the BB code
	$summary=BBCode($summary);

	// Wrap the text
	if($post_data['format']=="text") {
		$summary = bmc_wordwrap($summary);
	}


	// AutoConvert links
	if($bmc_vars['m_cnv'] && $post_data['format']=="text") {
		$summary=bmc_cnvAll($summary);
	}


	// Smilify
	$summary=bmc_smilify($summary);

	// Autobr if set
	if($post_data['m_autobr'] && $post_data['format'] == "text") {
		$summary=nl2br($summary);
	}


	include CFG_PARENT."/templates/".CFG_THEME."/summary.inc.php"; // Load the summary template and display it
}

?>