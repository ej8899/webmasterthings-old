<?

// stuff to know

// $REFERER=""; obtain this automatically or allow for it to be forced in the page call
// $SITE_NAME=""; originating 'site'
// $SITE_URL=""; originating 'site' URL of top most 'level'
// $NUMFRIENDS=""; number of friends on a page
// $ownermessage = a msg for the users

require ("../wtuserinfo.php");		// get user info based on 'wt_owner' variable

if(!$REFERER)
{
	$REFERER=$HTTP_REFERER;

}
if($NUMFRIENDS<1)
{
	$NUMFRIENDS=5;
}

if($action=="1") // setup to mail users and show a thank you
{
	$personalnote="";
	if($message)
	{
		$personalnote="$send_name wanted to also mention:\n";
	}

	// check all emails
	$sendable=verifyEmail("$adminemail");
	if($sendable==1)
	{
		echo "Your email address doesn't appear to be correct";
		exit;
	}
	for ($counting= 1; $counting <= $count; $counting++) 
	{
		$sendable=verifyEmail("$email[$counting]");
		$prefinalmessage="Hello $person[$counting],\n\nYour friend $send_name ($adminemail)\nthinks you would enjoy this web site:\n\n$REFERER\n\n$personalnote$message\n\n$ownermessage\n\n";

		if($wtdb[sitename]) // tack on wt user info if its available
			$finalmessage="$prefinalmessage\nYou might also enjoy $wtdb[sitename] at\n$wtdb[siteurl]\n\n";

//echo "$finalmessage";
		
		// mail is sendable....
		if($sendable=="0")
		{
			if($person[$counting]=="")
			{
				echo "missing name";
			}
			else
			{
				mail("$email[$counting]", "$send_name has a new site for you...", $finalmessage, "From: $adminemail\nReply-To: $adminemail\r\n");
			}
		}

	}


	include("taf-thanks.php");

}
else			// setup to show form
{

	include("taf-form.php");
}


//
// returns 0 if ok else 1 if error
//
function verifyEmail($emailaddy)
{
	if(!eregi("[0-9a-z]([-_.+]?[0-9a-z])*@[0-9a-z]([-.]?[0-9a-z])*\\.[a-z]{2,}$", $emailaddy)) 
	{ 
		return 1;
	}
	else
	{
		return 0;
	}

}
?>