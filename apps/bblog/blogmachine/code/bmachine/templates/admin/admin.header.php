<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<title><?php echo $title; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<style type="text/css">
<!--
<?php include(dirname(__FILE__)."/admin_style.css"); ?>
-->
</style>

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

	<div id="stats">
	<?php include dirname(__FILE__)."/stats.inc.php"; ?>
	</div>

	</div><!-- end header_title //-->

</div> <!-- end header //-->

<div id="header_bar">
	<a href="?null"><?php echo $lang['admin']; ?></a> 
    <a href="<?php echo $bmc_vars['c_urls']; ?>"><?php echo $lang['home']; ?></a> 
    <a href="http://boastology.com/pages/download.php"><?php echo $lang['admin_updates']; ?></a> 
    <a href="http://boastology.com/docs"><?php echo $lang['admin_docs']; ?></a> 
	<a href="<?php echo $bmc_vars['c_urls']; ?>/user.php?action=logout"><?php echo $lang['user_logout']; ?></a>
</div><!-- end header_bar //-->

<div id="main">


<div id="menu">

<div class="menu_item">
<?php if(defined('IS_ADMIN') && defined('IN_ADMIN')) include CFG_PARENT."/templates/admin/admin.menu.php"; ?>
</div>

</div> <!-- end menu //-->



<div id="content">