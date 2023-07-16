<h1><?php echo $date; ?></h1>
<h2 class="post_title"><?php echo $title; ?></h2>

<div class="entry_info">
<?php echo $lang['posted_by'];?> <a href="profile.php?id=<?php echo $post_data['author']; ?>"><?php echo $user_name; ?></a> 
<?php echo $lang['str_in']; ?> <a href="<?php echo BLOG_FILE;?>?cat=<?php echo $post_data['cat']; ?>"><?php echo $cat; ?></a>

<?php
	// If the admin is logged in, then show the ip of the message author
	if(defined('IS_ADMIN') && IS_ADMIN) {
?>
&nbsp;&nbsp; ( <a href="http://network-tools.com/default.asp?host=<?php echo $post_data['user_ip']; ?>" title="Trace IP"><?php echo $post_data['user_ip']; ?></a> )
<?php
	}
?>
<br />
<?php
	// Show the voting/rating stats
	if($bmc_vars['m_vote'] && $post_data['m_vote']) {
		echo $lang['rating'].": ".$total_rating."/5 &nbsp;&nbsp;";
		echo "<a href=\"javascript:popWin('vote.php?id=".$post_data['id']."')\">".$lang['votes']."</a> : ".$total_votes;
	}
?>

</div><!-- end entry_info //-->

<div class="entry">
<?php echo $msg; ?>
</div> <!-- end entry //-->

<?php
	// If there are attached files, print them in a box

if($file_list) {
?>
	<div class="file_list">
	<strong><?php echo $lang['att_file']; ?></strong><br />
	<?php echo $file_list; ?>
	</div>
<?php
}
?>

<div class="main_page_info">
<?php
	// Mail the article page
	if($bmc_vars['m_send']) {
echo <<<EOF
<a href="mail.php?id={$post_data['id']}&blog=$blog" title="{$lang['send_post_title']}">{$lang['send_post']}</a>&nbsp;&nbsp;&nbsp;
EOF;
	}
?>
<a href="<?php echo BLOG_FILE; ?>?print=<?php echo $post_data['id']; ?>"><?php echo $lang['print']; ?></a>&nbsp;&nbsp;&nbsp;
</div><!-- end entry_info //-->

<?php
	// If trackback is enabled for this post, display the trackback info
	if($post_data['m_trackback']) { ?>

<div class="hr_line"></div>
<h3 id="track"><?php echo $lang['trackbacks']; ?></h3>
<?php echo $lang['trackback_msg']; ?><br />
<strong><?php echo $bmc_vars['c_urls']."/trackback.php/".BLOG."/".$post_data['id']; ?></strong>

<?php include CFG_PARENT."/templates/".CFG_THEME."/tracks.inc.php"; ?>

<br /><br />
<?php } ?>

<!-- comments //-->
<div class="hr_line"></div>
<h3 id="cmt"><?php echo $lang['comments']; ?></h3>