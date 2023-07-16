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


// ====================
// Show blog list/user list/post list/archive list/category list.. :)

function bmc_show_list($what, $start_tag="", $end_tag="", $blog=null, $num_posts=10) {
global $db, $lang, $bmc_vars;

	if(!isset($what)) {
		return false;
	}


	if($blog && $what != "blog") {
		// Get the blog details from the DB
		$i_blog=$db->query("SELECT * FROM ".MY_PRF."blogs WHERE id='$blog' AND frozen='0'", false);

		if(!$i_blog['blog_name']) {
			echo $lang['no_data']; return false;
		}
	}


	switch($what) {

		// Print the category list
		case 'cats':


			if(!$i_blog['id']) {
				echo $lang['no_data']; return false;
			}

			if(!file_exists(CFG_ROOT."/inc/vars/cache/cats.dat")) {
				clearstatcache();
				echo "N/A";
				return false;
			}

			$data=fread(fopen(CFG_ROOT."/inc/vars/cache/cats.dat", "r"), filesize(CFG_ROOT."/inc/vars/cache/cats.dat"));
			$data=unserialize($data); // Convert the serialized data to php code form

				foreach($data as $cat) {
					if($i_blog['id'] == $cat['blog']) {
						echo "$start_tag<a href=\"{$bmc_vars['c_urls']}/{$i_blog['blog_file']}?cat={$cat['id']}\" title=\"".bmc_htmlentities($cat['cat_name'])."\">".bmc_htmlentities($cat['cat_name'])."</a>$end_tag\n";
					}
				}
		break;



		// Print the blog list
		case 'blogs':

			if(!file_exists(CFG_ROOT."/inc/vars/cache/blogs.dat")) {
				clearstatcache();
				echo "N/A";
				return false;
			}

			$data=fread(fopen(CFG_ROOT."/inc/vars/cache/blogs.dat", "r"),  filesize(CFG_ROOT."/inc/vars/cache/blogs.dat"));
			$data=unserialize($data); // Convert the serialized data to php code form

				foreach($data as $blog_data) {
					echo "$start_tag<a href=\"{$bmc_vars['c_urls']}/{$blog_data['blog_file']}\" title=\"".bmc_htmlentities($blog_data['blog_name'])."\">".bmc_htmlentities($blog_data['blog_name'])."</a>$end_tag\n";
				}
			return true;
		break;


		// Print the archive list
		case 'archive':

			if(!$i_blog['id']) {
				echo $lang['no_data']; return false;
			}

			if(!$bmc_vars['archive']) {
				return false;
			}

			if(!file_exists(CFG_ROOT."/inc/vars/cache/archive.dat")) {
				clearstatcache();
				echo "N/A";
				return false;
			}

			$data=fread(fopen(CFG_ROOT."/inc/vars/cache/archive.dat", "r"),  filesize(CFG_ROOT."/inc/vars/cache/archive.dat"));
			$data=unserialize($data); // Convert the serialized data to php code form


			if(isset($data[$blog]) && $data[$blog]) {

				foreach($data[$blog] as $arch) {
					$link="0,".date("m,Y",$arch);
					$disp=$lang["caln_month_".strtolower(date("M",$arch))]." ".date("Y",$arch);
					echo "$start_tag<a href=\"{$bmc_vars['c_urls']}/{$i_blog['blog_file']}?show={$link}\" title=\"".bmc_htmlentities($disp)."\">".bmc_htmlentities($disp)."</a>$end_tag\n";
				}


			} else {
				return false;
			}
				return true;
		break;


		// Print the user list
		case 'users':

			$users=$db->query("SELECT user_login,user_name,id,date FROM ".MY_PRF."users ORDER BY date DESC");

			foreach($users as $user) {
				$date=bmcDate($users['date']);
				include CFG_PARENT."/templates/".CFG_THEME."/user.list.php";
			}

		break;


	// Print the post list
		case 'posts':

			if(!$i_blog['id']) {
				echo $lang['no_data']; return false;
			}

			$posts=$db->query("SELECT id,title FROM ".MY_PRF."posts WHERE status='1' AND blog='{$i_blog['id']}' ORDER BY date DESC LIMIT 0,$num_posts");

			foreach($posts as $post) {
				echo "$start_tag<a href=\"{$bmc_vars['c_urls']}/{$i_blog['blog_file']}?id={$post['id']}\" title=\"".bmc_htmlentities($post['title'])."\">".bmc_htmlentities($post['title'])."</a>$end_tag\n";
			}

		break;


	}

}



?>