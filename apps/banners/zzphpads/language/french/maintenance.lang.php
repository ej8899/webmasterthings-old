<?php // $Revision: 1.1 $

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


// Main strings
$GLOBALS['strChooseSection']				= "Choisissez une section";


// Priority
$GLOBALS['strRecalculatePriority']			= "Recalculer les priorit�s";
$GLOBALS['strHighPriorityCampaigns']		= "Campagnes avec une priorit� haute";
$GLOBALS['strAdViewsAssigned']			= "Affichages assign�s";
$GLOBALS['strLowPriorityCampaigns']			= "Campagnes avec une priorit� basse";
$GLOBALS['strPredictedAdViews']			= "Affichages pr�vus";
$GLOBALS['strPriorityDaysRunning']			= "Il y a actuellement {days} jours de statistiques disponibles � partir desquels phpAdsNew peut effectuer ses pr�visions. ";
$GLOBALS['strPriorityBasedLastWeek']		= "Les pr�visions sont bas�es sur les donn�es de cette semaine et de la semaine pass�e. ";
$GLOBALS['strPriorityBasedLastDays']		= "Les pr�visions sont bas�es sur les donn�es des derniers jours. ";
$GLOBALS['strPriorityBasedYesterday']		= "Les pr�visions sont bas�es sur les donn�es d'hier. ";
$GLOBALS['strPriorityNoData']				= "Il n'y a pas assez de donn�es disponible pour effectuer des pr�visions r�alistes � propos du nombre d'affichages que ce serveur de publicit�s va enregistrer aujourd'hui. L'assignement des priorit�s ne sera bas� que sur des statistiques en temps r�el. ";
$GLOBALS['strPriorityEnoughAdViews']		= "Il devrait y avoir suffisament d'affichages pour satisfaire compl�tement les objectifs de toutes les campagnes haute priorit�. ";
$GLOBALS['strPriorityNotEnoughAdViews']		= "Il n'est pas certains qu'il y aura assez d'affichages aujourd'hui pour satisfaire les objectifs de toutes les campagnes haute priorit�. C'est pourquoi toutes les campagnes basse priorit� sont temporairement d�sactiv�es. ";


// Banner cache
$GLOBALS['strRebuildBannerCache']			= "Reconstuire le cache des banni�res";
$GLOBALS['strBannerCacheExplaination']		= "
	Le cache des banni�res contient une copie du code HTML qui est utilis� pour afficher la banni�re. En utilisant
	ce cache de banni�re, il est possible d'acc�l�rer la distribution des banni�res, car le code HTML n'a plus
	besoin d'�tre g�n�r� chaque fois qu'une banni�re est demand�e. Parce que le cache des banni�re contient des
	liens cod�s en dur, il a besoin d'�tre reconstruit � chaque fois que phpAdsNew est d�plac� sur le serveur Web.
";


// Zone cache
$GLOBALS['strZoneCache']				= "Cache des zones";
$GLOBALS['strAge']					= "Age";
$GLOBALS['strRebuildZoneCache']			= "Reconstruire le cache des zones";
$GLOBALS['strZoneCacheExplaination']		= "
	Le cache des zones est utilis� pour acc�l�rer la distribution des banni�res qui sont li�es aux zones.
	Le cache  des zones contient une copie de toutes les banni�res qui sont li�es � la zone, ce qui �vite
	nombre de requ�tes � la base quand la banni�re doit �tre d�livr�e au visiteur. Le cache est habituellement
	reconstruit chaque fois qu'une zone ou une de ses banni�res est modifi�e, il est n�anmoins possible que le cache
	deviennent p�rim�. C'est pourquoi le cache des zones sera automatiquement reconstruit toutes les {seconds} 
	secondes, mais il est aussi possible de le reconstruire � la demande.
";


// Storage
$GLOBALS['strStorage']					= "Stockage";
$GLOBALS['strMoveToDirectory']			= "D�placer les images stock�es dans la base de donn�es vers un r�pertoire";
$GLOBALS['strStorageExplaination']			= "
	Les images utilis�es par les banni�res locales sont stock�es dans la base de donn�es, ou dans un r�pertoire.
	Si vous stockez les images dans un r�pertoire, la charge de la base de donn�es diminuera, et la vitesse
	augmentera.
";


// Storage
$GLOBALS['strStatisticsExplaination']		= "
	Vous avez activ� les <i>statistiques compactes</i>, mais vos vieilles statistiques sont encore au format
	d�taill�. Voulez vous convertir vos anciennes statistiques d�taill�es en statistiques compactes ?
";


// Product Updates
$GLOBALS['strSearchingUpdates']			= "Recherche de mises � jour. Merci de patienter...";
$GLOBALS['strAvailableUpdates']			= "Mises � jour disponibles";
$GLOBALS['strDownloadZip']				= "T�l�charger (.zip)";
$GLOBALS['strDownloadGZip']				= "T�l�charger (.tar.gz)";

$GLOBALS['strUpdateAlert']				= "Une nouvelle version de ".$phpAds_productname." est disponible.                 \\n\\nVoulez vous des informations suppl�mentaires \\n� son propos ?";
$GLOBALS['strUpdateAlertSecurity']			= "Une nouvelle version de ".$phpAds_productname." est disponible.                 \\n\\nIl est hautement recommand� de mettre � jour\\naussit�t que possible, car cette version \\ncontient un ou plusieurs correctifs de s�curit�.";

$GLOBALS['strUpdateServerDown']			= "
	A cause d'une raison inconnue, il est impossible de r�cup�rer <br>
	des informations concernant de possibles mises � jour. Merci de r�essayer plus tard.
";

$GLOBALS['strNoNewVersionAvailable']		= "
	Votre version de ".$phpAds_productname." est � jour. Il n'y a actuellement aucune mise � jour disponible.
";

$GLOBALS['strNewVersionAvailable']			= "
	<b>Une nouvelle version de ".$phpAds_productname." est disponible.</b><br> Il est recommand� d'installer cette
	mise � jour, car elle peut r�gler certains probl�mes existants actuellement, et ajouter de nouvelles
	fonctionnalit�s. Pour plus d'informations concernant la mise � jour, merci de lire la documentation
	qui est inclus dans les fichiers ci-dessous.
";

$GLOBALS['strSecurityUpdate']				= "
	<b>Il est hautement recommand� d'installer cette mise � jour le plus t�t possible, car elle contient des
	correctifs de s�curit�.</b> La version de ".$phpAds_productname." que vous utilisez actuellement pourrait
	�tre vuln�rable � certaines attaques, et n'est probablement pas sure. Pour plus d'informations concernant
	la mise � jour, merci de lire la documentation qui est inclus dans les fichiers ci-dessous.
";


// Stats conversion
$GLOBALS['strConverting']				= "Conversion";
$GLOBALS['strConvertingStats']			= "Conversion des statistiques...";
$GLOBALS['strConvertStats']				= "Convertir les statistiques";
$GLOBALS['strConvertAdViews']				= "affichages convertis,";
$GLOBALS['strConvertAdClicks']			= "clics convertis...";
$GLOBALS['strConvertNothing']				= "Rien � convertir...";
$GLOBALS['strConvertFinished']			= "Fini...";

$GLOBALS['strConvertExplaination']			= "
	Vous utilisez actuellement le format compact pour stocker vos statistiques, mais il<br>
	y a encore quelques statistiques au format d�taill�. Aussi longtemps que les statistiques<br>
	seront en format d�taill�, le format compact ne sera pas utilis� pour voir ces pages.<br><br>
	Avant de convertir les statistiques, faite une sauvegarde de la base de donn�es !!<br>
	Souhaitez vous convertir vos statistiques d�taill�es avec le nouveau format compact ? <br>
";

$GLOBALS['strConvertingExplaination']		= "
	Toutes les statistiques d�taill�es restante sont en train d'�tre converties au format<br>
	compact. Selon le nombre d'affichages stock�s au format d�taill�, cela peut prendre<br>
	quelques minutes. Merci d'attendre jusqu'� ce que la conversion soit fini, avant de<br>
	visiter d'autres pages. Ci-dessous vous trouverez un journal des modifications faites<br>
	� la base de donn�es.<br>
";

$GLOBALS['strConvertFinishedExplaination']  	= "
	La conversion des statistiques restant au format d�taill� est r�ussie, et les donn�es<br>
	devrait pouvoir est utilisables � nouveau. Ci-dessous vous trouverez un journal des <br>
	modifications faites � la base de donn�es.
";


?>