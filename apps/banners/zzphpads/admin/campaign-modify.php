<?php // $Revision: 1.4 $

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
require ("lib-storage.inc.php");
require ("lib-zones.inc.php");


// Security check
phpAds_checkAccess(phpAds_Admin);



/*********************************************************/
/* Main code                                             */
/*********************************************************/

if (isset($campaignid) && $campaignid != '')
{
	if (isset($moveto) && $moveto != '')
	{
		// Move the campaign
		$res = phpAds_dbQuery("UPDATE ".$phpAds_config['tbl_clients']." SET parent = '".$moveto."' WHERE clientid = '".$campaignid."'") or phpAds_sqlDie();
		
		// Rebuild zone cache
		if ($phpAds_config['zone_cache'])
			phpAds_RebuildZoneCache ();
	}
}

Header ("Location: ".$returnurl."?clientid=".$moveto."&campaignid=".$campaignid);

?>
