<?php
	// The admin's deleting this trackback
	if(defined('IS_ADMIN') && isset($_GET['action']) && $_GET['action'] == 'delete_trackback' && isset($_GET['track']) && is_numeric($_GET['track'])) {
		$track=$db->query("SELECT post FROM ".MY_PRF."trackbacks WHERE id='{$_GET['track']}'", false);
		echo $db->query("DELETE FROM ".MY_PRF."trackbacks WHERE id='{$_GET['track']}'");

		bmc_Go("?id=".$_GET['id']); // Redirect
	}

?>
<br /><br />
<?php echo $lang['trackback_list_title']; ?><br /><br />
<div class="track">
<?php
	// This template has some serious php codes :)

	// Get the trackbacks for this post
	$trackbacks=$db->query("SELECT * FROM ".MY_PRF."trackbacks WHERE post='{$post_data['id']}'");

// Print all the trackbacks
foreach($trackbacks as $track) {
?>

<a href="<?php echo htmlentities($track['url']); ?>" title="<?php echo htmlentities($track['title']); ?>"><?php echo htmlentities($track['title']); ?></a>

<?php
	// If the user logged in is the admin, show the 'delete' link
	if(defined('IS_ADMIN')) {
?>
&nbsp;&nbsp;<a href="?action=delete_trackback&track=<?php echo $track['id']; ?>&id=<?php echo $post_data['id']; ?>">(<?php echo $lang['admin_but_del']; ?>)</a>
<?php
	}
?>

<br />
<?php echo wordwrap(htmlentities($track['excerpt']), $bmc_vars['c_wrap'],"\n",1); ?><br />
<?php echo $lang['blog']; ?> : <?php echo htmlentities($track['title']); ?><br />
<?php echo $lang['tracked_on']; ?> : <?php echo date("r", $track['date']); ?>
<br /><br />
<?php
}
?>
</div><br /><br />