<?php // $Revision: 1.15 $

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2002 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Figure out our location
define ('phpAds_path', '.');



/*********************************************************/
/* Include required files                                */
/*********************************************************/

require	(phpAds_path."/config.inc.php"); 
require (phpAds_path."/lib-db.inc.php");

if (($phpAds_config['log_adviews'] && !$phpAds_config['log_beacon']) || $phpAds_config['acl'])
{
	require (phpAds_path."/lib-remotehost.inc.php");
	
	if ($phpAds_config['log_adviews'] && !$phpAds_config['log_beacon'])
		require (phpAds_path."/lib-log.inc.php");
	
	if ($phpAds_config['acl'])
		require (phpAds_path."/lib-acl.inc.php");
}

require	(phpAds_path."/lib-view-main.inc.php");
require (phpAds_path."/lib-cache.inc.php");



/*********************************************************/
/* Java-encodes text                                     */
/*********************************************************/

function enjavanate ($str, $limit = 60)
{
	$str   = str_replace("\r", '', $str);
	
	print "var phpadsbanner = '';\n\n";
	
	while (strlen($str) > 0)
	{
		$line = substr ($str, 0, $limit);
		$str  = substr ($str, $limit);
		
		$line = str_replace('\\', "\\\\", $line);
		$line = str_replace('\'', "\\'", $line);
		$line = str_replace("\r", '', $line);
		$line = str_replace("\n", "\\n", $line);
		$line = str_replace("\t", "\\t", $line);
		$line = str_replace('<', "<'+'", $line);
		
		print "phpadsbanner += '$line';\n";
	}
	
	print "\ndocument.write(phpadsbanner);\n";
}



/*********************************************************/
/* Main code                                             */
/*********************************************************/

if (isset($clientID) && !isset($clientid))	$clientid = $clientID;
if (isset($withText) && !isset($withtext))  $withtext = $withText;

if (!isset($what)) 		$what = '';
if (!isset($clientid)) 	$clientid = 0;
if (!isset($target)) 	$target = '';
if (!isset($source)) 	$source = '';
if (!isset($withtext)) 	$withtext = '';
if (!isset($context)) 	$context = '';

if (isset($exclude) && $exclude != '')
{
	$exclude = explode (',', $exclude);
	$context = array();
	
	for ($i = 0; $i < count($exclude); $i++)
		if ($exclude[$i] != '')
			$context[] = array ("!=" => $exclude[$i]);
}


// Get the banner
$output = view_raw ($what, $clientid, $target, $source, $withtext, $context);

// Show the banner
header("Content-type: application/x-javascript");
enjavanate($output['html']);

// Block this banner for next invocation
if (isset($block) && $block != '' && $block != '0' && $output['bannerid'])
	print ("\nif (document.phpAds_used) document.phpAds_used += '".$output['bannerid'].",';\n");

?>