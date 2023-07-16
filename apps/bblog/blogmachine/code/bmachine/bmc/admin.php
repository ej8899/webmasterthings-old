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


//################ ADMIN SCRIPT ################

	include_once dirname(__FILE__)."/main.php";
	global $lang;

	// Validate the user
	$user=bmc_isLogged(); // the user

	if(!($user)) {
		bmc_Go($bmc_vars['c_urls']."/login.php");
		exit;
	}


	// The user is logged in, but is he an Admin?
	$result=$db->query("SELECT level,id FROM ".MY_PRF."users WHERE user_login='{$user}'", false);

	if($result['level'] != '4') {
		bmc_template('error_admin', $lang['denied'],$lang['admin_not']); // He's not an admin!
	}

	$logged_user_id=$result['id'];

	// The BLOG
	if(isset($_REQUEST['blog']) && !defined('BLOG')) {
		$result=$i_blog;

		define("BLOG", $_REQUEST['blog']);
		define("BLOG_NAME", $result['blog_name']);

	} else {
		define("BLOG", false);
		define("BLOG_NAME", false);
	}

	define('IN_ADMIN',true); // Flag to determine that we are in the admin

// ====================
// Various actions


if(isset($_REQUEST['action'])) {

	switch($_REQUEST['action']) {

		// User management
		case 'list_users':
		case 'edit_user':
		case 'delete_user':
		case 'add_user':
		include CFG_ROOT."/inc/core/admin/users.inc.php";
		exit;

		// Mail all users
		case 'mail_users':
		include CFG_ROOT."/inc/core/admin/mail.inc.php";
		exit;

		// User/post search
		case 'search':
		include CFG_ROOT."/inc/core/admin/search.inc.php";
		exit;

		// Modify blog properties
		case 'edit_blog':
		case 'mod_blog':
		include_once CFG_ROOT."/inc/core/admin/blog.mod.php";		
		exit;

		// Settings page
		case 'settings':
		case 'setts':
		case 'save_setts':
		include_once CFG_ROOT."/inc/core/admin/settings.admin.php";		
		exit;

		// Backup / Restore
		case 'backup':
		case 'do_backup':
		case 'restore':
		include CFG_ROOT."/inc/core/admin/backup.inc.php";
		exit;

		// Theme editor
		case 'theme_editor':
		include CFG_ROOT."/inc/core/admin/theme.editor.php";
		exit;

		// File manager
		case 'file_manager':
		include CFG_ROOT."/inc/core/admin/file.manager.php";
		exit;

	}
}


// ====================
// The BLOG management module
// Posts,Comments,Categories.. manipulation comes under this

	if(defined("BLOG")) {
	include CFG_ROOT."/inc/core/admin/blog.inc.php";
	}

// ====================
// The admin functions
// (Manage IPs, Languages, themes, logs....... )

	include_once CFG_ROOT."/inc/core/admin/functions.inc.php";



// ====================
// Give the Admin a Hearty welcome! :)

	bmc_Template('admin_header', $lang['admin_welcome']);

	$mt = explode(' ', microtime()); 
	$script_start_time = $mt['0'] + $mt['1'];


// Show the last login info
list($last_time,$last_ip)=explode("||",$last_login);
$last_time=bmcdate($last_time);

?>
<p><strong><?php echo $lang['admin_welcome']." for \"".$user; ?>"</strong><br />
<?php echo str_replace("%ver%",BMC_VERSION,$lang['admin_mode']); ?><br />
</p>
<?php


// The add blog form
?>
<h1><?php echo $lang['admin_blog_title']; ?></h1>

<div class="form_fields">
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<input type="hidden" name="action" value="create_blog" />
<?php echo $lang['admin_blog_new_name']; ?> : <input type="text" name="blog_name" /><br />
&nbsp;<a href="javascript:alert('<?php echo $lang['admin_blog_new_file_help']; ?>')">?</a>&nbsp;<?php echo $lang['admin_blog_new_file']; ?> : <input type="text" name="static_file" /><br />
<input type="submit" value="<?php echo $lang['admin_blog_new']; ?>" />
</form>
</div>

<?php
		// Get all blogs from the DB
		$blogs=$db->query("SELECT * FROM ".MY_PRF."blogs ORDER BY blog_date DESC");
?>

<div>
<strong><?php echo $lang['admin_blog_manage']; ?></strong><br />
<select name="manage_blog" onChange="javascript:document.location='?action=list_posts&blog='+this.value;">
	<?php
		foreach($blogs as $blog) {
			echo "<option value=\"{$blog['id']}\">".$blog['blog_name']."</option>\n";
		}
	?>
</select>

<br /><br /><br /><br />
</div>


<?php
		// List the blogs
	foreach($blogs as $blog) {
		$post_count=$db->row_count("SELECT id FROM ".MY_PRF."posts where blog='{$blog['id']}'");
		$comment_count=$db->row_count("SELECT id FROM ".MY_PRF."comments where blog='{$blog['id']}'");
		$blog['blog_date']=bmcDate($blog['blog_date']);

echo <<<EOF
<div class="blog_boxed">
<strong><a href="?blog={$blog['id']}&amp;action=list_posts">{$blog['blog_name']}</a></strong>&nbsp; 
<a href="{$bmc_vars['c_urls']}/{$blog['blog_file']}">({$lang['admin_blog_view']})</a>
<br />
{$lang['admin_blog_date']} {$blog['blog_date']}<br />
$post_count {$lang['total_articles']} , $comment_count {$lang['comments']}<br /><br />
<a href="?blog={$blog['id']}&amp;action=new_post">{$lang['admin_new']}</a>
&nbsp;&nbsp;::&nbsp;&nbsp;
<a href="?blog={$blog['id']}&amp;action=edit_blog">{$lang['admin_blog_mod']}</a>
&nbsp;&nbsp;::&nbsp;&nbsp;
<a href="?blog={$blog['id']}&amp;action=del_blog&amp;step=1">{$lang['admin_blog_del']}</a><br />
</div> <br />
EOF;
	}

bmc_Template('admin_footer');

?>