<?

// mySql Configuration                                                                                           
$wtserver         = "mysql.4ph.com";           		// Your mySQL Server, most cases "localhost"
$wtdb_user        = "ejohnson";						// Your mySQL Username
$wtdb_pass        = "changeme";           		// Your mySQL Password
$wtdatabase       = "ejohnson1";             	// Database Name
$wttablename		= "wt_users";				// table name


// load the webmaster 'user' details from the users database	
if($wt_owner)
{

	mysql_connect($wtserver, $wtdb_user, $wtdb_pass);

	$wtresult = mysql_db_query($wtdatabase, "SELECT * FROM $wttablename WHERE id=$wt_owner");
	$wtdb = mysql_fetch_array($wtresult);
	mysql_close();
}
// $wtdb[headerfile];		// primary site header HTML
// $wtdb[footerfile];		// primary site footer HTML
// $wtdb[sitename];		// primary site name
// $wtdb[siteurl];			// primary site URL
// $wtdb[password]; 	// webmasters password for files
// $wt_header; 				// var containing the wt owners header html code
// $wt_footer; 				// var containing the wt owners footer html code



// can we not preload the headerfile and footerfile into vars here so or progs just need to echo these vars?
if($wtdb[headerfile])
{
	$efile = fopen ($wtdb[headerfile], "rb");
	$econtents = "";
	do {
	    $edata = fread($efile, 8192);
	    if (strlen($edata) == 0) {
	        break;
	    }
	    $econtents .= $edata;
	} while(true);
	fclose ($efile);
	$wt_header=$econtents;
	
	$tcmHeader=$wtdb[headerfile];		// use this for access to the header file on the 'remote' server
}	
else
{
	// use a default header file
	$wt_header ="<html><head><title>$wtdb[sitename]</title>\n";
	$wt_header.="  <meta name=\"robots\" content=\"index, nofollow\">\n";                                                                       
	$wt_header.="  <meta name=\"revisit-after\" content=\"20 days\">\n";                                                                        
	$wt_header.= " </head><body>\n";
}

if($wtdb[footerfile])
{
	$efile = fopen ($wtdb[footerfile], "rb");
	$econtents = "";
	do {
	    $edata = fread($efile, 8192);
	    if (strlen($edata) == 0) {
	        break;
	    }
	    $econtents .= $edata;
	} while(true);
	fclose ($efile);
	$wt_footer=$econtents;
	$tcmFooter=$wtdb[footerfile];		// use this for access to the footer file on the 'remote' server
}	
else
{
	// use a default footer file
	
	$wt_footer ="</body></html>\n";
}


//
// convert spaces into %20's for passing in browser links
//
function convert_spaces($string) {
	$trans[" "] = "%20";
	$string = strtr($string, $trans);
	return $string;
}


?>