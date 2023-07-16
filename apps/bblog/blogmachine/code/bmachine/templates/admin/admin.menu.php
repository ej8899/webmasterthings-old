<?php if(defined('BLOG') && BLOG) { ?>
<h1><?php echo $lang['blog']; ?></h1>
  <ul>
	<li><a href="?action=edit_blog&blog=<?php echo BLOG; ?>"><?php echo $lang['admin_blog_mod']; ?></a></li>
	<li><a href="?action=new_post&blog=<?php echo BLOG; ?>"><?php echo $lang['admin_new']; ?></a></li>
    <li><a href="?action=list_posts&blog=<?php echo BLOG; ?>"><?php echo $lang['post_edit_title']; ?></a></li>
    <li><a href="?action=cats&blog=<?php echo BLOG; ?>"><?php echo $lang['admin_cat']; ?></a></li>
    <li><a href="?action=search&blog=<?php echo BLOG; ?>"><?php echo $lang['search']; ?></a></li>
</ul>
<?php } ?>

<h1><?php echo $lang['admin_author']; ?></h1>
  <ul>
	<li><a href="?action=list_users&blog=<?php echo BLOG; ?>"><?php echo $lang['admin_user_list']; ?></a></li>
	<li><a href="?action=mail_users&blog=<?php echo BLOG; ?>"><?php echo $lang['admin_user_mail']; ?></a></li>
    <li><a href="?action=search&blog=<?php echo BLOG; ?>"><?php echo $lang['admin_user_search']; ?></a></li>
    <li><a href="?action=add_user&blog=<?php echo BLOG; ?>"><?php echo $lang['admin_user_add']; ?></a></li>
</ul>

<h1><?php echo $lang['admin_system']; ?></h1>
  <ul>
	<li><a href="?action=settings"><?php echo $lang['admin_set']; ?></a></li>
	<li><a href="?action=file_manager"><?php echo $lang['admin_file']; ?></a></li>
    <li><a href="?action=themes"><?php echo $lang['admin_theme']; ?></a></li>
    <li><a href="?action=lang"><?php echo $lang['admin_lang']; ?></a></li>
    <li><a href="?action=backup"><?php echo $lang['admin_backup_rstr']; ?></a></li>
    <li><a href="?action=ban"><?php echo $lang['admin_block']; ?></a></li>
    <li><a href="?action=refs"><?php echo $lang['admin_ref']; ?></a></li>
    <li><a href="?action=word"><?php echo $lang['admin_word']; ?></a></li>
    <li><a href="?action=mail_logs"><?php echo $lang['admin_mail_logs']; ?></a></li>
    <li><a href="?action=theme_editor"><?php echo $lang['admin_theme_editor']; ?></a></li>
</ul>