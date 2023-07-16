<div class="comment_info">

<?php

	echo $lang['posted_by']."&nbsp;";

	// If the user was a guest (unregistered), how his name,email,url
	if(empty($cmt['author'])) {

	?>
	<a href="mailto:<?php echo str_replace("@","&#064;",htmlentities($cmt['auth_email'])); ?>"><?php echo htmlentities($cmt['auth_name']); ?></a>&nbsp;&nbsp;
	<a href="<?php echo htmlentities($cmt['auth_url']); ?>">www</a>
	<?php
	} // end if

	else {
		// Just show the username
	?>
	<a href="profile.php?id=<?php echo $cmt['author']; ?>"><?php echo htmlentities($author); ?></a>&nbsp;&nbsp;
	<?php
	}
	?>


<?php
	// If the user logged in is the admin, show the 'delete' link
	// and also the IP of the user posting the comment
	if(defined('IS_ADMIN')) {
?>
&nbsp;&nbsp;<a href="?action=delete_comment&cmt=<?php echo $cmt['id']; ?>&id=<?php echo $post_data['id']; ?>">(<?php echo $lang['admin_but_del']; ?>)</a> &nbsp;
( <a href="http://network-tools.com/default.asp?host=<?php echo $cmt['auth_ip']; ?>" title="Trace IP"><?php echo $cmt['auth_ip']; ?></a> )
<?php
	}
?>

<br />
<?php echo $lang['str_on']; ?> <?php echo $date; ?><br />
</div><!-- end comment_info //-->

<div class="comment">
<?php echo $comment; ?>
</div><!-- end comment //-->