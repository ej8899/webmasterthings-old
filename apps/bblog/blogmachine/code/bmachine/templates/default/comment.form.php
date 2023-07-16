<?php
	// The admin's deleting a comment
	if(defined('IS_ADMIN') && isset($_GET['action']) && $_GET['action'] == 'delete_comment' && isset($_GET['cmt']) && is_numeric($_GET['cmt'])) {
		$db->query("DELETE FROM ".MY_PRF."comments WHERE id='{$_GET['cmt']}'");
		bmc_Go("?id=".$post_data['id']); // Redirect
	}

?>
<div class="hr_line"></div>

<div id="form_fields">
<form method="POST" action="<?php echo $bmc_vars['c_urls']."/comments.php"; ?>">
<input type="hidden" name="action" value="post_comment" />
<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
<input type="hidden" name="blog" value="<?php echo BLOG; ?>" />

<?php

	// Show the name,email,url boxes only if its a guest user
	// if a user is already logged in, no need

	if(!bmc_isLogged()) {
?>

<?php echo $lang['cmt_name']; ?><br />
<input type="text" name="name"><br />

<?php echo $lang['cmt_email']; ?><br />
<input type="text" name="email"><br />

<?php echo $lang['cmt_url']; ?><br />
<input type="text" name="url" value="http://"><br />


<?php
	}
	else {
		// If the user is logged, print his username
		echo $lang['str_by']." <strong>".bmc_isLogged()."</strong><br />\n";
	}
?>

<?php echo $lang['cmt_comment']; ?><br />
<textarea name="comments" rows="10" cols="50"></textarea><br />
<input type="submit" value="<?php echo $lang['cmt_submit_but']; ?>" />
</form>
</div>