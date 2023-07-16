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




	define("BLOG", $blog_id);
	include_once dirname(__FILE__)."/main.php";

	// Load the search
	if(isset($_REQUEST['action']) && $_REQUEST['action']=="search" && defined('BLOG')) {
		include CFG_ROOT."/inc/core/search.inc.php";
		exit;
	}

	// Produce Printer friendly page
	if(isset($_GET['print']) && is_numeric($_GET['print']) && defined('BLOG')) {
		include CFG_ROOT."/inc/core/printer.inc.php";
		exit;
	}

	// The posts processor
	include_once CFG_ROOT."/inc/core/main.inc.php";

?>