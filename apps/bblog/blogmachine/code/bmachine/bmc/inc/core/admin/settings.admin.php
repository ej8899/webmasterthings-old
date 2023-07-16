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

// ==============================
// Save the Settings


if(isset($_POST['action']) && $_POST['action'] == "save_setts") {

	// Do some error prevention

	bmc_setVar("c_email", $_POST['admin_email']);
	bmc_setVar("c_urls", $_POST['admin_blog']);
	bmc_setVar("s_title", $_POST['admin_title']);
	bmc_setVar("s_desc", $_POST['admin_desc']);
//	bmc_setVar("gmt_diff", $_POST['admin_gmt_diff']); // Not yet implemented :)
	bmc_setVar("date_str", $_POST['admin_date']);
	bmc_setVar("send_ping", $_POST['admin_ping']);
	bmc_setVar("ping_urls", $_POST['ping_urls']);
	bmc_setVar("archive", $_POST['admin_archive']);
	bmc_setVar("x_wrap", $_POST['admin_xwrap']);
	bmc_setVar("p_page", $_POST['admin_ppage']);
	bmc_setVar("p_total", $_POST['admin_total']);
	bmc_setVar("c_wrap", $_POST['admin_cwrap']);
	bmc_setVar("m_cmt", $_POST['admin_cmt']);
	bmc_setVar("m_cmt_guests", $_POST['admin_cmt_guests']);
	bmc_setVar("m_cmt_ses", $_POST['admin_cmt_sess']);
	bmc_setVar("m_vote", $_POST['admin_vote']);
	bmc_setVar("m_send", $_POST['admin_send']);
	bmc_setVar("m_user", $_POST['admin_users']);
	bmc_setVar("m_new_notify", $_POST['admin_new_notify']);
	bmc_setVar("m_new_welcome", $_POST['admin_new_welcome']);
	bmc_setVar("m_default_level", $_POST['admin_default_level']);
	bmc_setVar("m_search", $_POST['admin_search']);
	bmc_setVar("m_cnv", $_POST['admin_cnv']);
	bmc_setVar("m_html", $_POST['admin_html']);
	bmc_setVar("m_files", $_POST['admin_files']);
	bmc_setVar("subject", $_POST['admin_send_subj']);
	bmc_setVar("ping_urls",$_POST['ping_urls']);


	bmc_Go("?action=settings"); exit;
}

// ==============================
// Settings page

	bmc_Template('admin_header', $lang['admin_sett_title']);

//	include CFG_ROOT."/inc/vars/bmc_conf.php";

	$s_title=noSlash($s_title);
	$s_desc=noSlash($s_desc);
	$subject=noSlash($subject);
	$date_str=noSlash($date_str);

echo <<<EOF
<form method="POST" name="sets" action="{$_SERVER['PHP_SELF']}">
<input type="hidden" name="action" value="save_setts" />
<table align="center" border="0" cellpadding="1" cellspacing="0" width="457">
<tr>
<td width="455"><p>
<h3>{$lang['admin_sett_title']}</h3></p>
<table border="0" cellpadding="4" cellspacing="0" width="456">
<tr>
<td width="188" height="38" valign="top">
<p><strong>{$lang['admin_sett_site_sett']}</strong></p>
</td>
<td width="252" height="38">
<p>&nbsp;</p>
</td>
</tr>
<tr>
<td width="188">
<p>{$lang['admin_sett_aemail']}</p>
</td>
<td width="252"><p>
<input type="text" title="{$lang['admin_sett_tip_email']}" value="{$bmc_vars['c_email']}" name="admin_email">
&nbsp;<a href="javascript:alert('{$lang['admin_sett_tip_email']}');"><strong>?</strong></a></p>
</td>
</tr>

<tr>
<td width="188">
<p>{$lang['admin_sett_burl']}</p>
</td>
<td width="252"><p>
<input type="text" title="{$lang['admin_sett_tip_burl']}" value="{$bmc_vars['c_urls']}" name="admin_blog" size="27">
&nbsp;<a href="javascript:alert('{$lang['admin_sett_tip_burl']}');"><strong>?</strong></a></p>
</td>
</tr>

<tr>
<td width="188">
<p>{$lang['admin_sett_site_title']}</p>
</td>
<td width="252"><p>
<input type="text" title="{$lang['admin_sett_tip_site_title']}" value="{$bmc_vars['s_title']}" name="admin_title" size="27">
&nbsp;<a href="javascript:alert('{$lang['admin_sett_tip_site_title']}');"><strong>?</strong></a></p>
</td>
</tr>

<tr>
<td width="188">
<p>{$lang['admin_sett_desc']}</p>
</td>
<td width="252"><p>
<input type="text" title="{$lang['admin_sett_tip_desc']}" value="{$bmc_vars['s_desc']}" name="admin_desc" size="27">
&nbsp;<a href="javascript:alert('{$lang['admin_sett_tip_desc']}');"><strong>?</strong></a></p>
</td>
</tr>

<tr>
<td width="188">
<p>{$lang['admin_sett_datestr']}</p>
</td>
<td width="252"><p>
<input type="text" title="{$lang['admin_sett_tip_datestr']}" value="{$bmc_vars['date_str']}" name="admin_date" size="27">
&nbsp;<a href="javascript:alert('{$lang['admin_sett_tip_datestr']}');"><strong>?</strong></a></p>
</td>
</tr>

<tr>
<td width="188">
<p>&nbsp;</p>
</td>
<td width="252"><p>
&nbsp;</p>
</td>
</tr>
<tr>
<td width="188" height="38" valign="top">
<p><strong>{$lang['admin_sett_system_sett']}</strong></p>
</td>
<td width="252" height="38">
<p>&nbsp;</p>
</td>
</tr>

<tr>
<td width="188">
<p>{$lang['admin_sett_users']}</p>
</td>
<td width="252">
<p><select title="{$lang['admin_sett_tip_users']}" name="admin_users" size="1">
<option value="1" selected>{$lang['admin_sett_chk_yes']}</option>
<option value="0">{$lang['admin_sett_chk_no']}</option>
</select>&nbsp;<a href="javascript:alert('{$lang['admin_sett_tip_users']}');"><strong>?</strong></a></p>
</td>
</tr>

<tr>
<td width="188">
<p>{$lang['admin_sett_new_welcome']}</p>
</td>
<td width="252">
<p><select title="{$lang['admin_sett_tip_new_welcome']}" name="admin_new_welcome" size="1">
<option value="1" selected>{$lang['admin_sett_chk_yes']}</option>
<option value="0">{$lang['admin_sett_chk_no']}</option>
</select>&nbsp;<a href="javascript:alert('{$lang['admin_sett_tip_new_welcome']}');"><strong>?</strong></a></p>
</td>
</tr>

<tr>
<td width="188">
<p>{$lang['admin_sett_new_notify']}</p>
</td>
<td width="252">
<p><select title="{$lang['admin_sett_tip_new_notify']}" name="admin_new_notify" size="1">
<option value="1" selected>{$lang['admin_sett_chk_yes']}</option>
<option value="0">{$lang['admin_sett_chk_no']}</option>
</select>&nbsp;<a href="javascript:alert('{$lang['admin_sett_tip_new_notify']}');"><strong>?</strong></a></p>
</td>
</tr>

<tr>
<td width="188">
<p>{$lang['admin_sett_default_level']}</p>
</td>
<td width="252">
<p><select name="admin_default_level" size="1">
<option value="0">0</option>
<option value="1">1</option>
<option value="2"selected>2</option>
<option value="3">3</option>
<option value="4">4</option>
</select>
&nbsp;<a href="javascript:alert('{$lang['admin_sett_tip_default_level']}');"><strong>?</strong></a></p>
</td>
</tr>

<tr>
<td width="188">
<p>{$lang['admin_sett_archive']}</p>
</td>
<td width="252">
<p><select title="{$lang['admin_sett_tip_archive']}" name="admin_archive" size="1">
<option value="1" selected>{$lang['admin_sett_chk_yes']}</option>
<option value="0">{$lang['admin_sett_chk_no']}</option>
</select>&nbsp;<a href="javascript:alert('{$lang['admin_sett_tip_archive']}');"><strong>?</strong></a></p>
</td>
</tr>
<tr>
<td width="188">
<p>{$lang['admin_sett_cmt']}</p>
</td>
<td width="252">
<p><select title="{$lang['admin_sett_tip_cmt']}" name="admin_cmt" size="1">
<option value="1" selected>{$lang['admin_sett_chk_yes']}</option>
<option value="0">{$lang['admin_sett_chk_no']}</option>
</select>&nbsp;<a href="javascript:alert('{$lang['admin_sett_tip_cmt']}');"><strong>?</strong></a></p>
</td>
</tr>
<tr>
<td width="188">
<p>{$lang['admin_sett_cmt_guests']}</p>
</td>
<td width="252">
<p><select title="{$lang['admin_sett_tip_cmt']}" name="admin_cmt_guests" size="1">
<option value="1" selected>{$lang['admin_sett_chk_yes']}</option>
<option value="0">{$lang['admin_sett_chk_no']}</option>
</select>&nbsp;<a href="javascript:alert('{$lang['admin_sett_tip_cmt_guests']}');"><strong>?</strong></a></p>
</td>
</tr>
<tr>
<td width="188">
<p>{$lang['admin_sett_cmtsess']}</p>
</td>
<td width="252">
<p><select title="{$lang['admin_sett_tip_cmtsess']}" name="admin_cmt_sess" size="1">
<option value="1" selected>{$lang['admin_sett_chk_yes']}</option>
<option value="0">{$lang['admin_sett_chk_no']}</option>
</select>&nbsp;<a href="javascript:alert('{$lang['admin_sett_tip_cmtsess']}');"><strong>?</strong></a></p>
</td>
</tr>
<tr>
<td width="188">
<p>{$lang['admin_sett_vote']}</p>
</td>
<td width="252">
<p><select title="{$lang['admin_sett_tip_vote']}" name="admin_vote" size="1">
<option value="1" selected>{$lang['admin_sett_chk_yes']}</option>
<option value="0">{$lang['admin_sett_chk_no']}</option>
</select>&nbsp;<a href="javascript:alert('{$lang['admin_sett_tip_vote']}');"><strong>?</strong></a></p>
</td>
</tr>
<tr>
<td width="188">
<p>{$lang['admin_sett_send']}</p>
</td>
<td width="252">
<p><select name="admin_send" size="1">
<option value="1" selected>{$lang['admin_sett_chk_yes']}</option>
<option value="0">{$lang['admin_sett_chk_no']}</option>
</select>&nbsp;<a href="javascript:alert('{$lang['admin_sett_chk_yes']}');"><strong>?</strong></a></p>
</td>
</tr>
<tr>
<td width="188">
<p>{$lang['admin_sett_search']}</p>
</td>
<td width="252">
<p><select name="admin_search" size="1">
<option value="1" selected>{$lang['admin_sett_chk_yes']}</option>
<option value="0">{$lang['admin_sett_chk_no']}</option>
</select>&nbsp;<a href="javascript:alert('{$lang['admin_sett_tip_search']}');"><strong>?</strong></a></p>
</td>
</tr>
<tr>
<td width="188">
<p>{$lang['admin_sett_xml']}</p>
</td>
<td width="252">
<p><select name="admin_xml" size="1">
<option value="1" selected>{$lang['admin_sett_chk_yes']}</option>
<option value="0">{$lang['admin_sett_chk_no']}</option>
</select>&nbsp;<a href="javascript:alert('{$lang['admin_sett_tip_xml']}');"><strong>?</strong></a></p>
</td>
</tr>
<tr>
<td width="188" height="38" valign="top">
<p>&nbsp;</p>
</td>
<td width="252" height="38">
<p>&nbsp;</p>
</td>
</tr>
<tr>
<td width="188" height="38" valign="top">
<p><strong>{$lang['admin_sett_misc_sett']}</strong></p>
</td>
<td width="252" height="38">
<p>&nbsp;</p>
</td>
</tr>
<tr>
<td width="188">
<p>{$lang['admin_sett_total']}</p>
</td>
<td width="252"><p>
<input type="text" title="{$lang['admin_sett_tip_totaal']}" value="{$bmc_vars['p_total']}" name="admin_total" size="7">
&nbsp;<a href="javascript:alert('{$lang['admin_sett_tip_total']}');"><strong>?</strong></a></p>
</td>
</tr>
<tr>
<td width="188">
<p>{$lang['admin_sett_ppage']}</p>
</td>
<td width="252"><p>
<input type="text" title="{$lang['admin_sett_tip_ppage']}" value="{$bmc_vars['p_page']}" name="admin_ppage" size="7">
&nbsp;<a href="javascript:alert('{$lang['admin_sett_tip_ppage']}');"><strong>?</strong></a></p>
</td>
</tr>
<tr>
<td width="188">
<p>{$lang['admin_sett_titlewrap']}</p>
</td>
<td width="252"><p>
<input type="text" title="{$lang['admin_sett_tip_twrap']}" value="{$bmc_vars['x_wrap']}" name="admin_xwrap" size="7">
&nbsp;<a href="javascript:alert('{$lang['admin_sett_tip_twrap']}');"><strong>?</strong></a></p>
</td>
</tr>
<tr>
<td width="188">
<p>{$lang['admin_sett_smrwrap']}</p>
</td>
<td width="252"><p>
<input type="text" title="{$lang['admin_sett_tip_swrap']}" value="{$bmc_vars['c_wrap']}" name="admin_cwrap" size="7">
&nbsp;<a href="javascript:alert('{$lang['admin_sett_tip_swrap']}');"><strong>?</strong></a></p>
</td>
</tr>
<tr>
<td width="188">
<p>{$lang['admin_sett_mail_subj']}</p>
</td>
<td width="252"><p>
<input type="text" title="{$lang['admin_sett_tip_sendm']}" value="{$bmc_vars['subject']}" name="admin_send_subj" size="27">
&nbsp;<a href="javascript:alert('{$lang['admin_sett_tip_sendm']}');"><strong>?</strong></a></p>
</td>
</tr>

<tr>
<td width="188">
<p>{$lang['admin_sett_autlink']}</p>
</td>
<td width="252">
<p><select name="admin_cnv" size="1">
<option value="1" selected>{$lang['admin_sett_chk_yes']}</option>
<option value="0">{$lang['admin_sett_chk_no']}</option>
</select>&nbsp;<a href="javascript:alert('{$lang['admin_sett_tip_autolink']}');"><strong>?</strong></a></p>
</td>
</tr>

<tr>
<td width="188">
<p>{$lang['admin_sett_html']}</p>
</td>
<td width="252">
<p><select name="admin_html" size="1">
<option value="1" selected>{$lang['admin_sett_chk_yes']}</option>
<option value="0">{$lang['admin_sett_chk_no']}</option>
</select>&nbsp;<a href="javascript:alert('{$lang['admin_sett_tip_html']}');"><strong>?</strong></a></p>
</td>
</tr>

<tr>
<td width="188">
<p>{$lang['admin_sett_files']}</p>
</td>
<td width="252">
<p><select name="admin_files" size="1">
<option value="1" selected>{$lang['admin_sett_chk_yes']}</option>
<option value="0">{$lang['admin_sett_chk_no']}</option>
</select>&nbsp;<a href="javascript:alert('{$lang['admin_sett_tip_files']}');"><strong>?</strong></a></p>
</td>
</tr>

<tr>
<td width="188">
<p>{$lang['admin_sett_ping']}</p>
</td>
<td width="252">
<p><select name="admin_ping" size="1">
<option value="1" selected>{$lang['admin_sett_chk_yes']}</option>
<option value="0">{$lang['admin_sett_chk_no']}</option>
</select>&nbsp;<a href="javascript:alert('{$lang['admin_sett_tip_ping']}');"><strong>?</strong></a></p>
</td>
</tr>

<tr>
<td width="188">
<p>{$lang['admin_sett_ping_urls']}</p>
</td>
<td width="252">
<p>
<textarea name="ping_urls" rows="6" cols="30">
{$bmc_vars['ping_urls']}</textarea>
&nbsp;<a href="javascript:alert('{$lang['admin_sett_tip_ping']}');"><strong>?</strong></a></p>
</td>
</tr>

<tr>
<td width="188">
<p>&nbsp;</p>
</td>
<td width="252">
<p>&nbsp;</p>
</td>
</tr>

<tr>
<td width="188">
<p>&nbsp;</p>
</td>
<td width="252">
<input type="hidden" name="setts" value="true">
<input type="hidden" name="admin_password" value="">
<p><input type="button" onClick="javascript:chkForm();" value="{$lang['admin_sett_save_but']}" /></p>
</td>
</tr>
</table>
<p>&nbsp;</p>
</td>
</tr>
</table>
</form>

<script type="text/javascript">
<!--
// Javascript function to fill in the Yes/No fields

var frm=document.sets;

var fl = new Array;

fl['0']='{$bmc_vars['archive']}'; //admin_archive
fl['1']='{$bmc_vars['m_cmt']}'; //admin_cmt
fl['2']='{$bmc_vars['m_cmt_ses']}'; //admin_cmt_sess
fl['3']='{$bmc_vars['m_vote']}'; //admin_vote
fl['4']='{$bmc_vars['m_send']}'; //admin_send
fl['5']='{$bmc_vars['m_search']}'; //admin_search
fl['6']='{$bmc_vars['m_cnv']}'; //admin_cnv
fl['7']='{$bmc_vars['send_ping']}'; //admin_ping
fl['8']='{$bmc_vars['m_user']}'; //admin_users
fl['9']='{$bmc_vars['m_html']}'; //admin_html
fl['10']='{$bmc_vars['m_files']}'; //admin_files
fl['11']='{$bmc_vars['m_rss']}'; //admin_xml
fl['12']='{$bmc_vars['m_cmt_guests']}'; //admin_cmt_guests
fl['13']='{$bmc_vars['m_new_welcome']}'; // admin_new_welcome
fl['14']='{$bmc_vars['m_new_notify']}'; // admin_new_notify
fl['15']='{$bmc_vars['m_default_level']}'; // admin_default_level


if(fl['0'] != 1) frm.admin_archive.selectedIndex=1;
if(fl['1'] != 1) frm.admin_cmt.selectedIndex=1;
if(fl['2'] != 1) frm.admin_cmt_sess.selectedIndex=1;
if(fl['3'] != 1) frm.admin_vote.selectedIndex=1;
if(fl['4'] != 1) frm.admin_send.selectedIndex=1;
if(fl['5'] != 1) frm.admin_search.selectedIndex=1;
if(fl['6'] != 1) frm.admin_cnv.selectedIndex=1;
if(fl['7'] != 1) frm.admin_ping.selectedIndex=1;
if(fl['8'] != 1) frm.admin_users.selectedIndex=1;
if(fl['9'] != 1) frm.admin_html.selectedIndex=1;
if(fl['10'] != 1) frm.admin_files.selectedIndex=1;
if(fl['11'] != 1) frm.admin_files.selectedIndex=1;
if(fl['12'] != 1) frm.admin_cmt_guests.selectedIndex=1;
if(fl['13'] != 1) frm.admin_new_welcome.selectedIndex=1;
if(fl['14'] != 1) frm.admin_new_notify.selectedIndex=1;

frm.admin_default_level.options[fl['15']].selected=true;

//-->
</script>
<script type="text/javascript">
<!--

function chkForm() {

	if(!document.sets.admin_desc.value) { alert("{$lang['empty_fields']}"); return false; }
	if(!document.sets.admin_date.value) { alert("{$lang['empty_fields']}"); return false; }
	if(!document.sets.admin_ppage.value) { alert("{$lang['empty_fields']}"); return false; }
	if(!document.sets.admin_cwrap.value) { alert("{$lang['empty_fields']}"); return false; }
	if(!document.sets.admin_xwrap.value) { alert("{$lang['empty_fields']}"); return false; }
	if(!document.sets.admin_send_subj.value) { alert("{$lang['empty_fields']}"); return false; }

document.sets.submit();

}

//-->
</script>
EOF;
	bmc_Template('admin_footer');
	exit;

?>