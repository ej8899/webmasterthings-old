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


	if(!defined('IN_BMC')) {
		die("Access Denied!");
	}


// =======================
// Show the referers page

if($_GET['action']=="refs") {

	// Read the referrer log
	bmc_Template('admin_header', $lang['admin_ref']);

echo <<<EOF
<table border="0" cellpadding="7" cellspacing="0" width="100%">
<tr>
<td width="140">
<p><strong>{$lang['admin_ref_time']}</strong></p>
</td>
<td width="90">
<p><strong>{$lang['admin_ref_ip']}</strong></p>
</td>
<td width="*">
<p><strong>{$lang['admin_ref_url']}</strong></p>
</td>
</tr>
EOF;

$rf_done=false;
$fp = @fopen(CFG_ROOT."/inc/vars/ref.log", "r");

	if(!$fp) {
echo <<<EOF
<tr>
<td><br /><br /><strong>{$lang['no_logs']}</strong></td></tr></table>
EOF;
	bmc_Template('admin_footer'); exit;
	}

	while (!feof($fp)) {
		$ref=fgets($fp, 4096);
			if(!empty($ref)) {
				list($time,$ip,$url)=explode("||",$ref);
				$time=date("h:i:s A - d M y", $time);

				$rf_done=true;

echo <<<EOF
<tr>
<td>
<p>$time</p>
</td>
<td>
<p><a href="http://network-tools.com/default.asp?host=$ip">$ip</a></p>
</td>
<td>
<p><a href="$url" target="_blank">$url</a></p>
</td>
</tr>
EOF;

			}

	}
fclose($fp);

	if(!$rf_done) {
echo <<<EOF
<tr>
<td><br /><br /><strong>{$lang['no_logs']}</strong></td></tr></table>
EOF;
	bmc_Template('admin_footer'); exit;
	}


	echo "</table>";

	bmc_Template('admin_footer');
	exit;
}


// =======================
// Mail Logs ( sent from 'Send to Friend' page )

if($_GET['action']=="mail_logs") {

	// Read the mail log file
	$log=null;
	$fp = @fopen(CFG_ROOT."/inc/vars/mail_log.txt", "r");
	if ($fp) {
		while (!feof($fp)) {
			$log.= fgets($fp, 4096);
		}
	fclose ($fp);
	} else {
		bmc_template('error_admin', $lang['admin_mail_logs_no']);
	}
		// No Logs were found
	if(empty($log) || !trim($log)) {
		bmc_template('error_admin', $lang['admin_mail_logs_no']);
	}

	bmc_Template('admin_header', $lang['admin_mail_logs']);

echo <<<EOF
<a href="?action=clear_mlog">{$lang['admin_mail_clear']}</a><br /><br />\n\n
EOF;

	// Parse the logs, print them in a neat format
	$log=explode("\n", $log);

	for($n=0;$n<count($log);$n++) {

		if(isset($log[$n]) && !empty($log[$n])) {

			$i_log=explode("|",$log[$n]);

			$str=str_replace("%email%","<a href=\"mailto:{$i_log[2]}\"><strong>{$i_log[1]}</strong></a> (<a href=\"http://network-tools.com/default.asp?host={$i_log[5]}\">ip</a>)",$lang['admin_mail_logs_by']);
			echo "{$str} {$i_log[0]}</strong>, <a href=\"{$bmc_vars['c_urls']}/?id={$i_log[4]}\">{$i_log[3]}</a><br />\n";

			unset($i_log[0]); unset($i_log[1]); unset($i_log[2]); unset($i_log[3]); unset($i_log[4]); unset($i_log[5]);
			$i_log=explode("|",implode("|",$i_log));

			for($i=0;$i<count($i_log);$i++) {
				if(isset($i_log[$i]) && trim($i_log[$i])) {
					echo "<a href=\"mailto:{$i_log[$i]}\">{$i_log[$i]}</a>, ";
				}
			}
			echo "\n<br /><br />\n\n";
		}
	}

	bmc_Template('admin_footer');
	exit();
}

// Clear the mail Log file
if($_GET['action']=="clear_mlog") {
	$fp = fopen(CFG_ROOT."/inc/vars/mail_log.txt", "w+") or bmc_template('error_admin', $lang['admin_log_write_msg'], $lang['admin_clr_log_msg']);
	fputs($fp, " ");
	fclose($fp);

	bmc_Go("?done=true");
	exit();
}


// =======================
// The themes page

if($_GET['action']=="themes") {
	bmc_Template('admin_header', $lang['admin_theme']);

	$themes=bmc_getThemeList(); // Get the list of theme directories in the /templates directory
	$theme=$bmc_vars['theme']; // Get the current theme
	$theme_name=$bmc_vars['theme_name']; // Get its formal name

echo <<<EOF
<p><strong>{$lang['admin_theme_title']}</strong></p>
{$lang['admin_theme_info']}
<p>{$lang['admin_theme_current']} : <strong>{$theme_name}</strong></p>
<form name="themes" method="POST" action="{$_SERVER['PHP_SELF']}">
<input type="hidden" name="action" value="set_theme" />
<p><select name="theme" size="1">
EOF;

	for($n=0;$n<=count($themes['id'])-1;$n++) {
		if(trim($themes['id'][$n])) {
			echo "<option value=\"".$themes['id'][$n]."\">".$themes['name'][$n]."</option>\n";
		}
	}

echo <<<EOF
</select>&nbsp;&nbsp;&nbsp;<input type="submit" name="theme_ok" value="{$lang['admin_theme_apply_but']}" /></p>
</form>
<br /><br />

<form method="POST" action="{$_SERVER['PHP_SELF']}" name="deltheme">
<input type="hidden" name="action" value="theme_rem" />
<p><select name="theme" size="1">
EOF;

	for($n=0;$n<=count($themes['id'])-1;$n++) {
		if(trim($themes['id'][$n])) {
			echo "<option value=\"".$themes['id'][$n]."\">".$themes['name'][$n]."</option>\n";
		}
	}

echo <<<EOF
</select>&nbsp;&nbsp;&nbsp;
<input type="button" onClick="javascript:remTheme()" name="theme_rem" value="{$lang['admin_theme_del_but']}" /></p>
</form>

<script type="text/javascript">
<!--
function remTheme() {
	var m=confirm("{$lang['admin_theme_del_msg']}");
	if(!m) {
		return false;
	}
	document.deltheme.submit();
}

for(n=0;n<=document.themes.theme.options.length;n++) {
	if(document.themes.theme.options[n].value == "{$theme}") {
		document.themes.theme.options[n].selected=true;
		break;
	}
}

//-->
</script>

EOF;
bmc_Template('admin_footer'); exit;
}

// Save a theme
if(isset($_POST['action']) && $_POST['action']=="set_theme" && isset($_POST['theme'])) {

	// Get the theme name and the theme's directory name
	include CFG_PARENT."/templates/".$_POST['theme']."/theme.info.php";

	if(empty($theme_name) || !trim($theme_name)) {
		bmc_Go("?action=themes&done=false");
	}

	// Set the theme
	bmc_setVar("theme","{$_POST['theme']}");
	bmc_setVar("theme_name","{$theme_name}");
	bmc_Go("?action=themes&done=true");
}


// Delete a theme
if(isset($_POST['action']) && $_POST['action']== "theme_rem" && isset($_POST['theme'])) {

	// Get the details of the current theme
	$theme=$bmc_vars['theme'];

	// If the user is trying to delete the current theme, dont allow it
	if(strtolower($theme) == strtolower($_POST['theme'])) {
		bmc_template('error_admin', $lang['admin_theme_del_no']);
	}

	bmc_remDir(CFG_PARENT."/templates/{$_POST['theme']}"); // Delete the whole theme directory
	bmc_Go("?action=themes&done=true");
}




// ====================
// Language packs

if($_GET['action']=="lang") {
	bmc_Template('admin_header', $lang['admin_lang_title']);

echo <<<EOF

<script type="text/javascript">
<!--

function delPack() {
	var msg=confirm('{$lang['admin_lang_del_msg']}');
	if(!msg) {
		return false;
	}

	document.lang.action.value="del_lang";
	document.lang.submit();
}

function setPack() {
	document.lang.action.value="set_lang";
	document.lang.submit();
}

//-->
</script>

<strong>{$lang['admin_lang_title']}</strong><br /><br />
{$lang['admin_lang_current']}: ' {$lang['name']} '
<form name="lang" method="POST" action="{$_SERVER['PHP_SELF']}">
<input type="hidden" name="action" value="set_lang" />
<select name="lang_file" size="1">
EOF;

	$handle = opendir(CFG_ROOT."/inc/lang");
	while($file = readdir($handle)) {
		if( $file != "." && $file != "..") {

		$load_lang_pack=true; // Set this variable to true.
							  // This will be detected by the lang file and it will load only the necessary variables

		include CFG_ROOT."/inc/lang/$file";

echo <<<EOF
<option value="$file">{$lang['name']}</option>\n
EOF;
		}
	}

	closedir($handle);


echo <<<EOF
	</select>
<br /><br />
<input type="button" onClick="javascript:setPack();" value="{$lang['admin_lang_but']}" />&nbsp;&nbsp;&nbsp;
<input type="button" onClick="javascript:delPack();" value="{$lang['admin_lang_del_but']}" />
</form><br /><br />


<form name="lang_upload" method="POST" action="{$_SERVER['PHP_SELF']}" ENCTYPE="multipart/form-data">
<input type="hidden" name="action" value="upload_lang" />
<strong>{$lang['admin_lang_up']}</strong><br />
<input type="file" name="lang_file" /><br />
{$lang['admin_lang_up_ow']} <input type="checkbox" name="file_ow" value="true" /><br /><br />
<input type="submit" value="{$lang['admin_lang_up_but']}" />
</form>
EOF;

	bmc_Template('admin_footer'); exit;
}

// Set the language pack
if($_POST['action']=='set_lang' && isset($_POST['lang_file']) && file_exists(CFG_ROOT."/inc/lang/".$_POST['lang_file'])) {
	clearstatcache(); // Clear the file stat cache
	bmc_setVar("lang", $_POST['lang_file']);
	bmc_Go("?action=lang"); exit;
}

// Delete a language pack
if($_POST['action']=='del_lang' && isset($_POST['lang_file']) && file_exists(CFG_ROOT."/inc/lang/".$_POST['lang_file'])) {

		clearstatcache(); // Clear the file stat cache

		// Check whether the user is trying to delete the ONLY remaining lang pack
		// or a language pack that is in use

		$num=0;
		$handle = opendir(CFG_ROOT."/inc/lang");
			while($file = readdir($handle)) {
				if( $file != "." && $file != "..") {
					$load_lang_pack=true; // Set the loader flag to true

					if(isset($lang['name'])) { $n=0;$n+1; }

				}
			}
		closedir($handle);

	if(($lang <= 1) || $bmc_vars['lang'] == $_POST['lang_file']) {
		bmc_template('error_admin', $lang['admin_lang_del_no']);
	}

	// Delete the pack
	@unlink(CFG_ROOT."/inc/lang/".$_POST['lang_file']);

	bmc_Go("?action=lang");
}

// Upload a new pack
if($_POST['action'] == "upload_lang" && isset($_FILES['lang_file']['name']) && !empty($_FILES['lang_file']['name'])) {
	$file=$_FILES['lang_file'];

	$file_exists=false;
	// Check whether the file exists
	if(file_exists(CFG_ROOT."/inc/lang/".$file['name'])) {
		clearstatcache(); $file_exists=true;
	}

	// File exists and overwriting is not selected. So the upload stops
	if(!isset($_POST['file_ow']) && $file_exists) {
		bmc_template('error_admin', $lang['admin_lang_up_ow_no']);
	}


	if(!@move_uploaded_file($file['tmp_name'], CFG_ROOT."/inc/lang/".$_file['name'])) {
		bmc_template('error_admin', $lang['admin_lang_up_no']); 
	}

	bmc_Go("admin.php?action=lang");

}


// ====================
// IP banning

if($_GET['action']=="ban") {
	bmc_Template('admin_header', $lang['admin_block_title']);

echo <<<EOF
<form name="ips" method="POST" action="{$_SERVER['PHP_SELF']}">
<input type="hidden" name="action" value="ban_ip" />
{$lang['admin_block_ip']}<br />
<textarea name="ips" rows="15" cols="34">
EOF;

	$ipdat=$bmc_vars['ips'];
	echo(str_replace("||","\n",$ipdat));

echo <<<EOF
</textarea>
<br /><input type="submit" value="{$lang['admin_blck_but']}" />
</form>
EOF;
	bmc_Template('admin_footer');
	exit;
}

// Save the IPs
if($_POST['action']=='ban_ip') {
	$ips=str_replace("\n","||",$_POST['ips']);
	bmc_setVar("ips",$ips);
	bmc_Go("?null"); exit;
}


// ====================
// The bad words page

if($_GET['action']=="word") {
	bmc_Template('admin_header', $lang['admin_bad_title']);
	$words=$bmc_vars['words'];

echo <<<EOF
<strong>{$lang['admin_bad_words']}</strong>
<form method="POST" action="{$_SERVER['PHP_SELF']}">
<input type="hidden" name="action" value="save_words" />
<textarea name="words" rows="5" cols="46">
$words</textarea><br />
<input type="submit" value="{$lang['admin_bad_but']}"><input type="hidden" name="act" value="word" />
</form>
EOF;
	bmc_Template('admin_footer');
	exit;
}

// Save the badwords :)
if($_POST['action']=="save_words") {
	bmc_setVar("words",$_POST['words']);
	bmc_Go("admin.php?action=word");
}


?>