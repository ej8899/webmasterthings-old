<?php // $Revision: 1.17 $

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2001 by the phpAdsNew developers                       */
/* http://sourceforge.net/projects/phpadsnew                            */
/*                                                                      */
/* Translation Revision 1.15: Francesco Lia                             */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Installer translation strings
$GLOBALS['strInstall']					= "Installazione";
$GLOBALS['strChooseInstallLanguage']	= "Scegli la lingua per la procedura di installazione";
$GLOBALS['strLanguageSelection']		= "Selezione lingua";
$GLOBALS['strDatabaseSettings']			= "Impostazioni database";
$GLOBALS['strAdminSettings']			= "Impostazioni amministratore";
$GLOBALS['strAdvancedSettings']			= "Impostazioni avanzate";
$GLOBALS['strOtherSettings']			= "Altre impostazioni";

$GLOBALS['strWarning']					= "Attenzione";
$GLOBALS['strFatalError']				= "Si &egrave; verificato un errore fatale";
$GLOBALS['strAlreadyInstalled']			= $phpAds_productname." &egrave; gi&agrave; installato su questo sistema. Per modificare le impostazioni clicca <a href='settings-index.php'>qui</a>";
$GLOBALS['strCouldNotConnectToDB']		= "Impossibile connettersi al database, controlla i parametri specificati";
$GLOBALS['strCreateTableTestFailed']	= "L'utente specificato non ha i permessi necessari a creare o aggiornare la struttura del database, contatta l'amministratore di sistema.";
$GLOBALS['strUpdateTableTestFailed']	= "L'utente specificato non ha i permessi necessari ad aggiornare la struttura del database, contatta l'amministratore di sistema.";
$GLOBALS['strTablePrefixInvalid']		= "Il prefisso delle tabelle contiene caratteri non validi";
$GLOBALS['strTableInUse']				= "Il database specificato &egrave; gi&agrave; utilizzato da ".$phpAds_productname.", utilizza un diverso prefisso per le tabelle, o leggi il manuale le istruzioni sull'aggiornamento.";
$GLOBALS['strMayNotFunction']			= "Prima di continuare, correggi questi potenziali problemi:";
$GLOBALS['strIgnoreWarnings']			= "Ignora avvertimenti";
$GLOBALS['strWarningPHPversion']		= $phpAds_productname." richiede PHP 3.0.8 o pi&ugrave; recente per funzionare correttamente. La versione attualmente utilizzata &egrave; {php_version}.";
$GLOBALS['strWarningRegisterGlobals']	= "La variabile di configurazione del PHP register_globals deve essere abilitata.";
$GLOBALS['strWarningMagicQuotesGPC']	= "La variabile di configurazione del PHP magic_quotes_gpc deve essere abilitata.";
$GLOBALS['strWarningMagicQuotesRuntime']	= "La variabile di configurazione del PHP magic_quotes_runtime deve essere disabilitata.";
$GLOBALS['strConfigLockedDetected']		= "Il file <b>config.inc.php</b> non pu&ograve; essere sovrascritto dal server.<br> Non � possiblie procedere finch&eacute; non vengono modificati i permessi sul file. <br>Puoi leggere sul manuale di ".$phpAds_productname." come fare.";
$GLOBALS['strCantUpdateDB']				= "Non &egrave; possibile aggiornare il database. Se decidi di procedere, tutti i banner, le statistiche e i clienti saranno cancellati.";
$GLOBALS['strTableNames']				= "Nomi delle tabelle";
$GLOBALS['strTablesPrefix']				= "Prefisso delle tabelle";
$GLOBALS['strTablesType']				= "Tipo di tabelle";

$GLOBALS['strInstallWelcome']			= "Benvenuto in ".$phpAds_productname;
$GLOBALS['strInstallMessage']			= "Prima di utilizzare ".$phpAds_productname." &egrave; necessario configurarlo e <br> il database deve essere creato. Clicca su <b>Procedi</b> per continuare.";
$GLOBALS['strInstallSuccess']			= "<b>L'istallazione di ".$phpAds_productname." &egrave stata completata.</b><br><br>Affinch&eacute; ".$phpAds_productname." funzioni correttamente devi assicurarti
                                           che lo script di manutenzione sia lanciato ogni giorno. Puoi trovare informazioni maggiori sull'argomento nel manuale.
                                           <br><br>Clicca <b>Procedi</b> per andare alla pagina di configurazione e impostare
                                           altri parametri. Ricordati di togliere i permessi al file config.inc.php quando hai finito, per evitare problemi di
                                           sicurezza.";
$GLOBALS['strInstallNotSuccessful']		= "<b>L'installazione di ".$phpAds_productname." non ha avuto successo</b><br><br>Alcune parti del processo di installazione non possono essere completate.
                                           &Egrave; possibile che questi problemi siano solo temporanei, in questo caso clicca <b>Procedi</b> per ritornare alla
                                           prima fase dell'installazione. Se vuoi saperne di pi� sul significato dell'errore, e su come risolvere il problema,
                                           consulta il manuale di ".$phpAds_productname.".";
$GLOBALS['strErrorOccured']				= "Si &egrave; verificato il seguente errore:";
$GLOBALS['strErrorInstallDatabase']		= "La struttura del database non pu� essere creata.";
$GLOBALS['strErrorInstallConfig']		= "La configurazione (su file e/o database) non pu&ograve; essere aggiornata.";
$GLOBALS['strErrorInstallDbConnect']	= "Non &egrave; stato possibile connettersi al database.";

$GLOBALS['strUrlPrefix']				= "Prefisso URL";

$GLOBALS['strProceed']					= "Procedi &gt;";
$GLOBALS['strRepeatPassword']			= "Ripeti password";
$GLOBALS['strNotSamePasswords']			= "Le password non coincidono";
$GLOBALS['strInvalidUserPwd']			= "Username o password non validi";

$GLOBALS['strUpgrade']					= "Aggiornamento";
$GLOBALS['strSystemUpToDate']			= "Il sistema &egrave; aggiornato, al momento non sono necessari aggiornamenti. <br>Clicca <b>Procedi</b> per andare alla pagina principale.";
$GLOBALS['strSystemNeedsUpgrade']		= "La struttura del database e il file di configurazione devono essere aggiornati per funzionare correttamente. Clicca <b>Procedi</b> per iniziare il processo di aggiornamento. <br>Sii paziente, il processo pu� durare anche alcuni minuti.";
$GLOBALS['strSystemUpgradeBusy']		= "Aggiornamento in corso, attendere prego...";
$GLOBALS['strServiceUnavalable']		= "Il servizio non &egrave; disponibile al momento. &Egrave; in corso l'aggiornamento del sistema.";

$GLOBALS['strConfigNotWritable']		= "Il file config.inc.php non pu� essere sovrascritto";





/*********************************************************/
/* Configuration translations                            */
/*********************************************************/

// Global
$GLOBALS['strChooseSection']			= "Scegli la sezione";
$GLOBALS['strDayFullNames']				= array("Domenica","Luned&igrave;","Martedi&igrave;","Mercoled&igrave;","Gioved&igrave;","Venerd&igrave;","Sabato");
$GLOBALS['strEditConfigNotPossible']	= "Non risulta possibile modificare queste ipostazioni a causa del file config.inc.php protetto da scrittura per aumentare la sicurezza. ".
                                          "Se vuoi effettuare cambiamenti devi prima sbloccare il file config.inc.php.";
$GLOBALS['strEditConfigPossible']		= "Puoi modificare tutte le impostazioni dato che il file config.inc.php risulta non protetto da scrittura, tuttavia consigliamo di proteggerlo per evitare rischi di sicurezza. ".
                                          "Se vuoi rendere maggiormente sicuro il tuo sistema, dovresti proteggere il file.";



// Database
$GLOBALS['strDatabaseSettings']			= "Impostazioni database";
$GLOBALS['strDatabaseServer']			= "Database server";
$GLOBALS['strDbHost']					= "Hostname database";
$GLOBALS['strDbUser']					= "Username database";
$GLOBALS['strDbPassword']				= "Password database";
$GLOBALS['strDbName']					= "Nome database";

$GLOBALS['strDatabaseOptimalisations']	= "Ottimizzazioni database";
$GLOBALS['strPersistentConnections']	= "Utilizza connessioni persistenti";
$GLOBALS['strInsertDelayed']			= "Utilizza inserimenti in differita";
$GLOBALS['strCompatibilityMode']		= "Attiva compatibilit&agrave; con server MySQL 3.22";
$GLOBALS['strCantConnectToDb']			= "Impossibile connettersi al database";



// Invocation and Delivery
$GLOBALS['strInvocationAndDelivery']	= "Impostazioni di invocazione e fornitura banner";

$GLOBALS['strAllowedInvocationTypes']	= "Tipi di invocazione consentiti";
$GLOBALS['strAllowRemoteInvocation']	= "Consenti invocazione remota";
$GLOBALS['strAllowRemoteJavascript']	= "Consenti invocazione remota con JavaScript";
$GLOBALS['strAllowRemoteFrames']		= "Consenti invocazione remota con Frame";
$GLOBALS['strAllowRemoteXMLRPC']		= "Consenti invocazione remota XML-RPC";
$GLOBALS['strAllowLocalmode']			= "Consenti modo locale";
$GLOBALS['strAllowInterstitial']		= "Consenti Interstiziali";
$GLOBALS['strAllowPopups']				= "Consenti Popup";

$GLOBALS['strKeywordRetrieval']			= "Abilita l'uso di keyword";
$GLOBALS['strBannerRetrieval']			= "Metodo di scelta del banner";
$GLOBALS['strRetrieveRandom']			= "Casuale (default)";
$GLOBALS['strRetrieveNormalSeq']		= "Sequenziale normale";
$GLOBALS['strWeightSeq']				= "Sequenziale pesata";
$GLOBALS['strFullSeq']					= "Sequenziale completa";
$GLOBALS['strUseConditionalKeys']		= "Utilizza keyword condizionali";
$GLOBALS['strUseMultipleKeys']			= "Utilizza keyword multiple";
$GLOBALS['strUseAcl']					= "Utilizza le limitazioni di visualizzazione";

$GLOBALS['strZonesSettings']			= "Impostazione zone";
$GLOBALS['strZoneCache']				= "Memorizza zone nella cache (dovrebbe velocizzare il tutto se si usano le zone)";
$GLOBALS['strZoneCacheLimit']			= "Tempo di validit&agrave; della cache (in secondi)";
$GLOBALS['strZoneCacheLimitErr']		= "Il tempo di validit&agrave; deve essere un intero positivo";

$GLOBALS['strP3PSettings']				= "Impostazioni P3P";
$GLOBALS['strUseP3P']					= "Utilizza le policy P3P";
$GLOBALS['strP3PCompactPolicy']			= "Versione compatta della policy P3P";
$GLOBALS['strP3PPolicyLocation']		= "Indirizzo della policy P3P completa";



// Banner Settings
$GLOBALS['strBannerSettings']			= "Impostazioni banner";

$GLOBALS['strAllowedBannerTypes']		= "Tipi di banner consentiti";
$GLOBALS['strTypeSqlAllow']				= "Consenti banner locali (SQL)";
$GLOBALS['strTypeWebAllow']				= "Consenti banner locali (Server web)";
$GLOBALS['strTypeUrlAllow']				= "Consenti banner esterni";
$GLOBALS['strTypeHtmlAllow']			= "Consenti banner HTML";

$GLOBALS['strTypeWebSettings']			= "Configurazione banner locali (Server web)";
$GLOBALS['strTypeWebMode']				= "Tipo di memorizzazione";
$GLOBALS['strTypeWebModeLocal']			= "Modalit&agrave; locale (utilizza una directory locale)";
$GLOBALS['strTypeWebModeFtp']			= "Modalit&agrave; FTP (utilizza un server FTP esterno)";
$GLOBALS['strTypeWebDir']				= "Directory per la modalit&agrave; locale";
$GLOBALS['strTypeWebFtp']				= "Server FTP per la modalit&agrave; FTP";
$GLOBALS['strTypeWebUrl']				= "URL pubblico della directory locale / server FTP";
$GLOBALS['strTypeFTPHost']				= "Hostname FTP";
$GLOBALS['strTypeFTPDirectory']			= "Directory remota";
$GLOBALS['strTypeFTPUsername']			= "Login";
$GLOBALS['strTypeFTPPassword']			= "Password";

$GLOBALS['strDefaultBanners']			= "Banner di default";
$GLOBALS['strDefaultBannerUrl']			= "URL del banner di default";
$GLOBALS['strDefaultBannerTarget']		= "URL destinazione del banner di default";

$GLOBALS['strTypeHtmlSettings']			= "Configurazione banner HTML";
$GLOBALS['strTypeHtmlAuto']				= "Modifica automaticamente i banner HTML per poter registrare i click";
$GLOBALS['strTypeHtmlPhp']				= "Consenti l'esecuzione di espressioni PHP all'interno dei banner HTML";



// Statistics Settings
$GLOBALS['strStatisticsSettings']		= "Impostazioni statistiche";

$GLOBALS['strStatisticsFormat']			= "Formato statistiche";
$GLOBALS['strLogBeacon']				= "Usa i beacon per registrare le Visualizzazioni";
$GLOBALS['strCompactStats']				= "Utilizza il formato delle statistiche compatto";
$GLOBALS['strLogAdviews']				= "Registra visualizzazioni";
$GLOBALS['strBlockAdviews']				= "Abilita protezione su vis. multiple (sec.)";
$GLOBALS['strLogAdclicks']				= "Registra click";
$GLOBALS['strBlockAdclicks']			= "Abilita protezione su click multipli (sec.)";

$GLOBALS['strEmailWarnings']			= "Avvertimenti E-mail";
$GLOBALS['strAdminEmailHeaders']		= "Header aggiuntivi delle email";
$GLOBALS['strWarnLimit']				= "Limite di avvertimento";
$GLOBALS['strWarnLimitErr']				= "Il lmite di avvertimento deve essere un intero positivo";
$GLOBALS['strWarnAdmin']				= "Avvisa l'amministratore";
$GLOBALS['strWarnClient']				= "Avvisa i clienti";
$GLOBALS['strQmailPatch']				= "Abilita patch per qmail";

$GLOBALS['strRemoteHosts']				= "Host remoti";
$GLOBALS['strIgnoreHosts']				= "Host da ignorare nelle statistiche";
$GLOBALS['strReverseLookup']			= "Risolvi nomi di dominio";
$GLOBALS['strProxyLookup']				= "Risolvi indirizzi che utilizzano un server proxy";



// Administrator settings
$GLOBALS['strAdministratorSettings']	= "Impostazioni amministratore";

$GLOBALS['strLoginCredentials']			= "Credenziali di login";
$GLOBALS['strAdminUsername']			= "Username";
$GLOBALS['strOldPassword']				= "Vecchia password";
$GLOBALS['strNewPassword']				= "Nuova password";
$GLOBALS['strInvalidUsername']			= "Username non valido";
$GLOBALS['strInvalidPassword']			= "Password non valida";

$GLOBALS['strBasicInformation']			= "Informazioni di base";
$GLOBALS['strAdminFullName']			= "Nome e cognome";
$GLOBALS['strAdminEmail']				= "Indirizzo email";
$GLOBALS['strCompanyName']				= "Societ&agrave;";

$GLOBALS['strAdminNovice']				= "Richiedi conferma nelle operazioni di cancellazione dell'amministratore";

$GLOBALS['strAdminCheckUpdates']		= "Controlla aggiornamenti disponibili";
$GLOBALS['strAdminCheckEveryLogin']		= "Ad ogni login";
$GLOBALS['strAdminCheckDaily']			= "Una volta al giorno";
$GLOBALS['strAdminCheckWeekly']			= "Una volta alla settimana";
$GLOBALS['strAdminCheckMonthly']		= "Una volta al mese";
$GLOBALS['strAdminCheckNever']			= "Non controllare";

$GLOBALS['strUserlogEmail']				= "Registra tutte le email in uscita";
$GLOBALS['strUserlogPriority']			= "Registra i calcoli eseguiti ogni ora nell'assegnamento delle priorit&agrave;";


// User interface settings
$GLOBALS['strGuiSettings']				= "Configurazione interfaccia utente";

$GLOBALS['strGeneralSettings']			= "Impostazioni generali";
$GLOBALS['strAppName']					= "Intestazione programma";
$GLOBALS['strMyHeader']					= "File da includere come intestazione";
$GLOBALS['strMyFooter']					= "File da includere a pi&eacute; di pagina";
$GLOBALS['strGzipContentCompression']	= "Utilizza la compressione GZIP";

$GLOBALS['strClientInterface']			= "Interfaccia inserzionista";
$GLOBALS['strClientWelcomeEnabled']		= "Attiva messaggio di benvenuto";
$GLOBALS['strClientWelcomeText']		= "Testo del messaggio<br>(tag HTML consentite)";



// Interface defaults
$GLOBALS['strInterfaceDefaults']		= "Default di interfaccia";

$GLOBALS['strInventory']				= "Inventario";
$GLOBALS['strShowCampaignInfo']			= "Mostra informazioni aggiuntive nella pagina <i>Descrizione Campagne</i>";
$GLOBALS['strShowBannerInfo']			= "Mostra informazioni aggiuntive nella pagina <i>Descrizione Banner</i>";
$GLOBALS['strShowCampaignPreview']		= "Mostra anteprima dei banner nella pagina <i>Descrizione Banner</i>";
$GLOBALS['strShowBannerHTML']			= "Mostra il banner invece del codice HTML nell'anteprima dei banner HTML";
$GLOBALS['strShowBannerPreview']		= "Mostra anteprima nella parte superiore della pagina nelle pagine dei banner";

$GLOBALS['strStatisticsDefaults']		= "Statistiche";
$GLOBALS['strBeginOfWeek']				= "Primo giorno della settimana";
$GLOBALS['strPercentageDecimals']		= "Numero decimali nelle percentuali";

$GLOBALS['strWeightDefaults']			= "Peso di default";
$GLOBALS['strDefaultBannerWeight']		= "Peso di default dei banner";
$GLOBALS['strDefaultCampaignWeight']	= "Peso di default delle campagne";
$GLOBALS['strDefaultBannerWErr']		= "Il peso di default dei banner deve essere un intero positivo";
$GLOBALS['strDefaultCampaignWErr']		= "Il peso di default delle campagne deve essere un intero positivo";



// Not used at the moment
$GLOBALS['strTableBorderColor']			= "Colore del bordo delle tabelle";
$GLOBALS['strTableBackColor']			= "Colore di sfondo delle tabelle";
$GLOBALS['strTableBackColorAlt']		= "Colore di sfondo delle tabelle (Alternativo)";
$GLOBALS['strMainBackColor']			= "Colore di sfondo delle pagine";
$GLOBALS['strOverrideGD']				= "Utilizza formato GD personalizzato";
$GLOBALS['strTimeZone']					= "Fuso orario";

?>