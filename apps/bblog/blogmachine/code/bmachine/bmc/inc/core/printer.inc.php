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



	if( !isset($_GET['print']) || !is_numeric($_GET['print']) ) {
		bmc_Go($bmc_vars['c_urls']);
	}

	if(!defined('BLOG')) {
		bmc_Go($bmc_vars['c_urls']);
	}

		$blog_id=BLOG;


		// Check the blog whether its frozen or not
		if(empty($i_blog['blog_name'])) {
			bmc_template('error_page', $lang['amin_blog_no']);		
		}


		$i_post=$db->query("SELECT author,title,summary,data,date,m_autobr,id,cat FROM ".MY_PRF."posts WHERE id='{$_GET['print']}' AND status='1' AND blog='{$blog_id}'", false);

		if(empty($i_post['title'])) {
			bmc_template('error_page', $lang['no_id']);		
		}


		// bbCode parser
		include CFG_ROOT."/inc/users/bbcode.php";

		// The post body
		if(!empty($i_post['data'])) {
			$body=$i_post['data'];
			$body=wordwrap($body, $bmc_vars['c_wrap'],"\n",1);

			$body=bmc_Smilify($body); // Smilies
			$body=bbCode($body); // bbCode

				if($i_post['m_autobr']) {
					$body=nl2br($body);
				}

		} else {
			$body=false;
		}


		$summary=wordwrap($summary, $bmc_vars['c_wrap'],"\n",1);

		// The post summary
		$summary=$i_post['summary'];
		$summary=bmc_Smilify($summary); // Smilies
		$summary=bbCode($summary); // bbCode

		if($i_post['m_autobr']) {
			$summary=nl2br($summary);
		}


		$date=bmcDate($i_post['date']);



		$user_name=bmc_dispUser($i_post['author']);

		$cat=$db->query("SELECT cat_name FROM ".MY_PRF."cats WHERE id='{$i_post['cat']}'", false);
		$cat=$cat['cat_name'];

		// Include the printer friendly page template
		include CFG_PARENT."/templates/".CFG_THEME."/printer.inc.php";
		exit;



?>