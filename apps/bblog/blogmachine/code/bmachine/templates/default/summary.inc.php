<!-- Begin post //-->
<h1><?php echo $date; ?></h1>
<h2 class="post_title"><a href="<?php echo BLOG_FILE; ?>?id=<?php echo $post_data['id']; ?>" title="Permalink : <?php echo $title; ?>"><?php echo $title; ?></a></h2>

<div class="entry">
<?php echo $summary; ?>
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

<br />
<div class="entry_info">
<?php echo $lang['posted_by']; ?> <a href="profile.php?id=<?php echo $post_data['author']; ?>"><?php echo $user_name; ?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="<?php echo BLOG_FILE; ?>?id=<?php echo $post_data['id']; ?>#cmt"><?php echo $lang['comments']; ?> (<?php echo $cmn; ?>)</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="<?php echo BLOG_FILE; ?>?id=<?php echo $post_data['id']; ?>#track"><?php echo $lang['trackbacks']; ?> (<?php echo $tracks; ?>)</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="mail.php?id=<?php echo $post_data['id']; ?>&amp;blog=<?php echo BLOG; ?>" title="<?php echo $lang['send']; ?>"><?php echo $lang['send']; ?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<?php
	// If the admin is logged in, then show the ip of the message author
	if(defined('IS_ADMIN') && IS_ADMIN) {
?>
( <a href="http://network-tools.com/default.asp?host=<?php echo $post_data['user_ip']; ?>" title="Trace IP"><?php echo $post_data['user_ip']; ?></a> )
<?php
	}
?>

</div><!-- end entry_info //-->


<!-- End post //-->