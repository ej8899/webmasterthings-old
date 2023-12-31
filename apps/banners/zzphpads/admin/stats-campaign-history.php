<?php // $Revision: 1.20 $

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



// Include required files
require ("config.php");
require ("lib-statistics.inc.php");
require ("lib-expiration.inc.php");


// Security check
phpAds_checkAccess(phpAds_Admin+phpAds_Client);



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

if (isset($Session['prefs']['stats-client-campaigns.php']['listorder']))
	$navorder = $Session['prefs']['stats-client-campaigns.php']['listorder'];
else
	$navorder = '';

if (isset($Session['prefs']['stats-client-campaigns.php']['orderdirection']))
	$navdirection = $Session['prefs']['stats-client-campaigns.php']['orderdirection'];
else
	$navdirection = '';


if (phpAds_isUser(phpAds_Client))
{
	if (phpAds_getUserID() == phpAds_getParentID ($campaignid))
	{
		$res = phpAds_dbQuery("
			SELECT
				*
			FROM
				".$phpAds_config['tbl_clients']."
			WHERE
				parent = ".phpAds_getUserID()."
			".phpAds_getListOrder ($navorder, $navdirection)."
		") or phpAds_sqlDie();
		
		while ($row = phpAds_dbFetchArray($res))
		{
			phpAds_PageContext (
				phpAds_buildClientName ($row['clientid'], $row['clientname']),
				"stats-campaign-history.php?clientid=".$clientid."&campaignid=".$row['clientid'],
				$campaignid == $row['clientid']
			);
		}
		
		phpAds_PageHeader("1.2.1");
			echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;<b>".phpAds_getClientName($campaignid)."</b><br><br><br>";
			phpAds_ShowSections(array("1.2.1", "1.2.2"));
	}
	else
	{
		phpAds_PageHeader("1");
		phpAds_Die ($strAccessDenied, $strNotAdmin);
	}
}

if (phpAds_isUser(phpAds_Admin))
{
	$res = phpAds_dbQuery("
		SELECT
			*
		FROM
			".$phpAds_config['tbl_clients']."
		WHERE
			parent = ".$clientid."
		".phpAds_getListOrder ($navorder, $navdirection)."
	") or phpAds_sqlDie();
	
	while ($row = phpAds_dbFetchArray($res))
	{
		phpAds_PageContext (
			phpAds_buildClientName ($row['clientid'], $row['clientname']),
			"stats-campaign-history.php?clientid=".$clientid."&campaignid=".$row['clientid'],
			$campaignid == $row['clientid']
		);
	}
	
	phpAds_PageShortcut($strClientProperties, 'client-edit.php?clientid='.$clientid, 'images/icon-client.gif');
	phpAds_PageShortcut($strCampaignProperties, 'campaign-edit.php?clientid='.$clientid.'&campaignid='.$campaignid, 'images/icon-campaign.gif');
	
	phpAds_PageHeader("2.1.2.1");
		echo "<img src='images/icon-client.gif' align='absmiddle'>&nbsp;".phpAds_getParentName($campaignid);
		echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
		echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;<b>".phpAds_getClientName($campaignid)."</b><br><br><br>";
		phpAds_ShowSections(array("2.1.2.1", "2.1.2.2"));
}



/*********************************************************/
/* Main code                                             */
/*********************************************************/

$idresult = phpAds_dbQuery ("
	SELECT
		bannerid
	FROM
		".$phpAds_config['tbl_banners']."
	WHERE
		clientid = $campaignid
");

if (phpAds_dbNumRows($idresult) > 0)
{
	while ($row = phpAds_dbFetchArray($idresult))
	{
		$bannerids[] = "bannerid = ".$row['bannerid'];
	}
	
	$lib_history_where     = "(".implode(' OR ', $bannerids).")";
	$lib_history_params    = array ('clientid' => $clientid, 'campaignid' => $campaignid);
	$lib_history_hourlyurl = "stats-campaign-daily.php";
	
	include ("lib-history.inc.php");
}
else
{
	echo "<br><img src='images/info.gif' align='absmiddle'>&nbsp;";
	echo "<b>".$strNoStats."</b>";
	phpAds_ShowBreak();
}


/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>