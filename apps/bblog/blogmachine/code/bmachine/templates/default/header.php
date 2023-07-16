<?php global $bmc_vars; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<title><?php echo $title; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="description" content="<?php echo $title; ?>" />
	<meta name="keywords" content="<?php echo $keys; ?>" />

	<style type="text/css">
	<!--
	<?php include CFG_PARENT."/templates/default/bstyle.css"; ?>
	//-->
	</style>

<link rel="alternate" type="application/rss+xml" title="RSS 2.0 syndication" href="<?php echo $bmc_vars['c_urls']."/" ; ?>rss" />

<script type="text/javascript">
<!-- 
function popWin(url) {
	var theURL=url;
	newWin = window.open(theURL,'win','toolbar=No,menubar=No,left=200,top=200,width=350,resizable=yes,scrollbars=yes,status=No,location=No,height=400');
}
//-->
</script>

</head>

<body>

<div id="wrap">

<div id="header">
	<div id="header_title">

	<?php
	// This might seem crazy, but its simple :) If BLOG_NAME is empty, then display the default site title
	if(defined('BLOG_NAME')) { ?>
	<a href="<?php echo $bmc_vars['c_urls']; ?>/<?php echo BLOG_FILE; ?>" title="<?php echo BLOG_NAME; ?>"><?php echo BLOG_NAME; ?></a>
	<?php
	} else {
	// Default siet title
	?>
	<a href="<?php echo $bmc_vars['c_urls']; ?>" title="<?php echo $bmc_vars['s_title']; ?>"><?php echo $bmc_vars['s_title']; ?></a>
	<?php
	}
	?>

	</div><!-- end header_title //-->
</div> <!-- end header //-->

<div id="main">



<?php
	// Only show the menu if the page_menu flag is set to true
	if($page_menu) {
?>
<div id="menu">

<?php include_once CFG_ROOT."/calendar.php"; ?>

<div class="menu_item">


<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<div>
<strong><?php echo $lang['search']; ?></strong>
</div>
<div>
<input type="hidden" name="action" value="search" />
<input type="hidden" name="item" value="title" />
<input type="hidden" name="blog" value="<?php echo BLOG; ?>" />
<input type="text" name="key" /><br />
<input type="submit" value="Search" />
</div>
</form>
</div> <!-- end menu_item //-->


<div class="menu_item">
<strong><?php echo $lang['cats']; ?></strong><br />
<?php bmc_show_list('cats','','<br />',BLOG); ?>
</div> <!-- end menu_item //-->

<div class="menu_item">
<strong><?php echo $lang['recent_posts']; ?></strong><br />
<?php bmc_show_list('posts','','<br />',BLOG,4); ?>
</div> <!-- end menu_item //-->

<div class="menu_item">
<strong><?php echo $lang['archive']; ?></strong><br />
<?php bmc_show_list('archive','','<br />',BLOG); ?>
</div> <!-- end menu_item //-->

<div class="menu_item">
<strong><?php echo $lang['blog_roll']; ?></strong><br />
<?php bmc_show_list('blogs','','<br />'); ?>
</div> <!-- end menu_item //-->

<div class="menu_item">
<strong><?php echo $lang['syndicate']; ?></strong><br />

<?php
	// The rss filenames are generated in the form, weblog_name.rss
	// So..

	$rss_file=str_replace(".php","",BLOG_FILE);
?>

<a href="<?php echo $bmc_vars['c_urls']; ?>/rss/<?php echo $rss_file; ?>_rss1.xml">RSS .92</a><br />
<a href="<?php echo $bmc_vars['c_urls']; ?>/rss/<?php echo $rss_file; ?>_rss2.xml">RSS 2.0</a><br />
<a href="<?php echo $bmc_vars['c_urls']; ?>/rss/<?php echo $rss_file; ?>_atom.xml">Atom .03</a><br />
</div> <!-- end menu_item //-->

<div class="menu_item">
<strong>Links</strong><br />
<?php
	include CFG_PARENT."/templates/".CFG_THEME."/links.template.php";
?>
</div> <!-- end menu_item //-->

<div class="menu_item">
<?php
	// If the user is not logged in, show the login box
	$user=bmc_isLogged();
	if(!$user) {
?>
<strong><?php echo $lang['user_box_txt']; ?></strong>
<form method="post" action="login.php">
<div>
<?php echo $lang['user_login']; ?> : <input type="text" name="user_login" /><br />
<?php echo $lang['user_pass']; ?> : <input type="password" name="password" /><br /><br />
<input type="submit" value="<?php echo $lang['user_login_but']; ?>" />
</div>
</form>
<a href="<?php echo $bmc_vars['c_urls']; ?>/register.php"><?php echo $lang['user_signup']; ?></a><br />
<?php

	}
	else {
	// else, show the account link
	?>
	<strong>&quot; <?php echo $user; ?> &quot;</strong><br />
	<a href="<?php echo $bmc_vars['c_urls']; ?>/user.php"><?php echo $lang['user_box_acc']; ?></a><br />
	<a href="<?php echo $bmc_vars['c_urls']; ?>/user.php?action=logout"><?php echo $lang['user_logout']; ?></a>
<?php
	}
?>
</div> <!-- end menu_item //-->


<div class="menu_item">
<a href="http://validator.w3.org/check/?uri=referer" title="Valid XHTML">Valid XHTML</a><br />
</div> <!-- end menu_item //-->

</div> <!-- end menu //-->

<?php
	}
		// End if for page_menu
?>


<div id="content">
