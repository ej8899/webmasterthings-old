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
	global $lang,$bmc_vars;
	$blog=BLOG;

	// Print the date range box

	if(!defined('BLOG')) {
		// No blog!
		bmc_Go("Location: ?null");
		exit;
	}


	// Delete the posts if requested
	if(isset($_POST['action']) && $_POST['action'] == "delete_posts" && !empty($_POST['chk_delete']) ) {
		$post_list=$_POST['chk_delete']; // Get the 'to be deleted' post list as array

		foreach($post_list as $p) {
			$db->query("DELETE FROM ".MY_PRF."posts WHERE id='{$p}'"); // Delete the post
			$db->query("DELETE FROM ".MY_PRF."comments WHERE post='{$p}'"); // Delete the comments
		}


	bmc_updateCache('archive'); // Update the cache

	// Generate the RSS feeds if set
	if($bmc_vars['m_rss']) {
		include CFG_ROOT."/inc/core/rss.build.php";
	}

	bmc_Go("admin.php?action=list_posts&blog=".BLOG);

	}


	// Page header
	bmc_Template('admin_header', $lang['admin_blog_list_posts']);

	$per_page=30; // Posts to be shown per page
	if(!isset($_GET['page']) || !is_numeric($_GET['page'])) { $pg=1; } else { $pg=$_GET['page']; }

	$start=($pg*$per_page)-$per_page;

	// Keep the post count under the limit
	if(($start+$per_page) > 250) {
		$per_page=250-$per_page;
	}


	if(isset($_GET['selIndex'])) $selIndex=$_GET['selIndex']; else $selIndex=0;

// Print the select box
echo <<<EOF
<br />
<div>
<script type="text/javascript">
<!--
function showPosts() {
	document.location="?blog=$blog&amp;action=list_posts&amp;page=$pg&amp;selIndex="+posts_range.show_posts.selectedIndex+"&amp;range="+posts_range.show_posts.value;
}
//-->
</script>
</div>
<div id="form_fields">
<strong>{$lang['admin_post_show']}</strong>
<form name="posts_range">
<div><select name="show_posts" size="1" onChange="javascript:showPosts()">
<option selected value="this_week">{$lang['admin_post_week']}</option>
<option value="this_month">{$lang['admin_post_month']}</option>
<option value="last_month">{$lang['admin_post_last_month']}</option>
<option value="last_six">{$lang['admin_post_last_6month']}</option>
<option value="last_year">{$lang['admin_post_last_year']}</option>
</select></div>
</form>
</div>
<div>
<script type="text/javascript">
<!--
	posts_range.show_posts.selectedIndex=$selIndex;
//-->
</script>
</div>
EOF;

	// Posts sorting
	$sort="date DESC";

	if(isset($_GET['sort'])) {
		switch($_GET['sort']) {

		 case 'title':
		 $sort="title";
		 break;

		 case 'date':
		 $sort="date";
		 break;

		 case 'author':
		 $sort="author";
		 break;

		 case 'title':
		 $sort="title";
		 break;

		 default:
		 $sort="date DESC";
		 break;

		}
	}


// Check whether a range has been specified
if(isset($_GET['range'])) {
	switch ($_GET['range']) {

		case 'this_week':
		$range_sql="and date >= '".(time()-604800)."'";
		break;

		case 'this_month':
		$start_time=mktime('0','0','0',date("m"),1,date("Y")); // Time stamp of the beginning day of this month
		$end_time=mktime('12','59','59',date("m"),date("t"),date("Y")); // Time stamp of the last day of this month
		$range_sql="and date >= '$start_time' and date <= '$end_time'";
		break;

		case 'last_month':
			if(date("m") == 1) {
				$last_month=12;
			} else {
				$last_month=date("m")-1;
			}

		$start_time=mktime('0','0','0',$last_month,1,date("Y")); // Time stamp of the beginning day of this month
		$end_time=mktime('12','59','59',$last_month,date("t"),date("Y")); // Time stamp of the last day of this month
		$range_sql="and date >= '$start_time' and date <= '$end_time'";
		break;

		case 'last_six':
		$range_sql="and date >= '".(time()-15552000)."'";
		break;

		case 'last_year':
		$range_sql="and date >= '".(time()-31104000)."'";
		break;
	}

}
	// Do the query
	$data=$db->query("SELECT id,author,date,title,m_cmt,status FROM ".MY_PRF."posts where blog='".BLOG."' $range_sql ORDER by $sort LIMIT $start,$per_page");
	$post_count=$db->row_count("SELECT id FROM ".MY_PRF."posts");

	// No posts!
	if(empty($data)) {
		echo $lang['admin_search_no'];
		return;
	}


// Page number generation
	$nm=$post_count; // Some preparations for the page numbering
	$x=$nm/$per_page;


	// Include the page number script
	include CFG_PARENT."/templates/".CFG_THEME."/page.num.php";

	$blog=BLOG;

	include CFG_ROOT."/inc/core/admin/posts_list_table.php"; // Load the post list table template

	bmc_Template('admin_footer');
	// Footer
?>