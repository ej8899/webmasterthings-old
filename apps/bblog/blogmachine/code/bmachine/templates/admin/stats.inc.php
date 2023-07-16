<?php

	// Simple statistics

if(defined('IS_ADMIN') && IS_ADMIN) {

	if(defined('BLOG')) {
		$blog=BLOG;
	}

	if(isset($blog)) { echo "<strong>".BLOG_NAME."</strong><br />"; } else { $num=null; }

	if(isset($blog))
		$num=bmc_getCount($blog); // Get the blog,post,users,comments count
	else {
		$num=bmc_getCount();
	}

	echo "Total blogs : {$num['blogs']}<br />";
	echo "Total users : {$num['users']}<br />";
	echo "Total posts : {$num['posts']}<br />";
	echo "Total comments : {$num['comments']}<br />";

}

?>