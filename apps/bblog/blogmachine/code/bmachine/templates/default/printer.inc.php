<HTML>
<HEAD>
<TITLE><?php echo $i_post['title']; ?></TITLE>

<style type="text/css">
<!--

.html,body {
	font-family: Trebuchet MS, Georgia;
	font
}

.title {
	color: #CC3333;
}

#summary {
	font-size: 14px;
}

#body {
	font-size: 14px;
}

.line_hr {
	border: 0px;
	border-color: #666666;
	border-style: solid;
	border-bottom-width: 1px;
	margin-top: 25px;
	margin-bottom: 25px;
}

a {
	color: #CC0000;
	font-weight: bold;
}

//-->
</style>

</HEAD>
<BODY>

<h1 class="title"><?php echo $i_post['title']; ?></h1><br />

<?php echo $lang['posted_by']; ?> <strong><?php echo $user_name; ?></strong> 
<?php echo $lang['str_on']; ?> <strong><?php echo $date; ?></strong><br />
<?php echo $lang['str_in']; ?> <strong><?php echo $cat; ?></strong> ( <strong><?php echo $i_blog['blog_name']; ?></strong>)</span>
<br /><br />

<div id="summary">
<?php echo $summary; ?>
</span>

<?php
	if($body) {
?>
	<div class="line_hr"></div>
	<div id="body">
	<?php echo $body; ?>
	</span>
<?php } ?>


<div class="line_hr"></div>


<span class="t_small"><?php echo $lang['print_from']; ?> : <a href="<?php echo $bmc_vars['c_urls']."/".BLOG_FILE; ?>"><?php echo $bmc_vars['c_urls']."/".BLOG_FILE; ?></a></span><br>
<span class="t_small"><?php echo $lang['printed_from']; ?> : <a href="<?php echo $bmc_vars['c_urls']."/".BLOG_FILE; ?>/?id=<?php echo $i_post['id']; ?>"><?php echo $bmc_vars['c_urls']."/".BLOG_FILE; ?>?id=<?php echo $i_post['id']; ?></a></span>

</BODY>
</HTML>