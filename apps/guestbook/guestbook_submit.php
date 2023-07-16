<?

#  Project           	: phpBook                                                                                        
#  File name         	: guestbook_submit.php                                                                               
#  Last Modified By  	: Erich Fuchs                                                                                     
#  e-mail            	: erich.fuchs@netone.at                                                                           
#  Purpose           	: Submit Guestbook Data                                                                            

#  Include Configs & Variables                                                                                                     
require ("config.php");


#$guestbook_head = "$gbheader";           	// Guestbook Header (Name)
#$gb_desc		= "$gbdescribe";			// Enter your description here


#  Process                                                                                                     
if (!$in && !$delid && !$delcommentid && !$commentid) {                                                                                                      

    header("Location: $url_to_start");                                                       

    exit;                                                                                                           

} elseif ($delid && $admin==$adminpass) {

    mysql_connect($server, $db_user, $db_pass) or died("Database Connect Error");

    mysql_db_query($database, "DELETE FROM $tablename WHERE id='$delid'") or died("Database Query Error");

    mysql_close();

    header("Location: $url_to_start&offset=$offset&poffset=$poffset&admin=$admin");

    exit;

} elseif ($delcommentid && $admin==$adminpass) {                                                                                 

    mysql_connect($server, $db_user, $db_pass) or died("Database Connect Error");                                      

    mysql_db_query($database, "UPDATE $tablename SET comment='' where id='$delcommentid'") or died("Database Query Error");              

    mysql_close();                                                                                                     

    header("Location: $url_to_start&offset=$offset&poffset=$poffset&admin=$admin");                                                         

    exit;                                                                                                              

} elseif ($commentid && $admin==$adminpass) {

    if(isset($comment)){

      $entry=changed;

      mysql_connect($server, $db_user, $db_pass) or died("Database Connect Error");                                      

      mysql_db_query($database, "UPDATE $tablename SET comment='".encode_msg($comment)."' where id='$commentid'") or died("Database Query Error");              

      mysql_close();                                                                                                     

	  } else {

      $entry="";

    }

    header("Location: $url_to_start&commentid=$commentid&entry=$entry&offset=$offset&poffset=$poffset&admin=$admin");

    exit;

} else {                                                                                                         

    mysql_connect($server, $db_user, $db_pass) or died("Database Connect Error");                                

    if (isbanned()) {
		header("Location: $url_to_start");                          
        exit;                                                                                            
    }

    $add_date = time();                                                                                              
    $in = strip_array($in);
    $in['message'] = encode_msg($in['message']);    // Add SQL compatibilty & Smilie Convert                             
    $in['http']    = str_replace("http://", "", $in['http']);   // Remove http:// from URLs                          

    if ($in['name'] == "") { died("<html><head><title>$guestbook_head</title>$languagemetatag</head><body><center>$name_empty</center></body></html>"); }                           

    if ($in['icq'] != "" && ($in['icq'] < 1000 || $in['icq'] > 999999999)) { died("<html><head><title>$guestbook_head</title>$languagemetatag</head><body><center>$icq_wrong</center></body></html>"); }                           

    if (!eregi("^[0-9a-z]([-_.]?[0-9a-z])*@[0-9a-z]([-.]?[0-9a-z])*\\.[a-z]{2,3}$",$in['email']) && $in['email'] != "") { died("<html><head><title>$guestbook_head</title>$languagemetatag</head><body><center>$non_valid_email</center></body></html>"); }                                                                              

    if (strlen($in['message']) < $limit["0"] || strlen($in['message']) > $limit["1"]) { died("<html><head><title>$guestbook_head</title>$languagemetatag</head><body><center>$message_incorrect $limit[0] $and $limit[1] $characters.</center></body></html>"); }                            

    if ($in['email'] == "") { $in['email'] = "none"; }                                                               

    if ($in['icq'] == "") { $in['icq'] = 0; }                                                                        

    if ($in['http'] == "") { $in['http'] = "none"; }                                                                 

    if ($in['location'] == "0") { $in['location'] = "none"; }                                                                 

    $in['browser'] = $HTTP_USER_AGENT;

	
//echo "<BR><BR><B>Maintenance in progress... sorry for the trouble</B><BR><BR>";
// for images 2 april 2004	
require "imageuploader.php";
// returns with $newfilename set

    mysql_db_query($database, "INSERT INTO $tablename (firstowner,secondowner,name, email, http, icq, message, timestamp, ip, location, browser,picture)          

    VALUES('$wt_owner', '$wt_owner2', '$in[name]', '$in[email]','$in[http]','$in[icq]','$in[message]','$add_date', '$REMOTE_ADDR','$in[location]','$in[browser]','$newfilename')")

    or died("Database Error inserting your entry |$tablename|$wt_owner|$wt_owner2|");

    if ($gb_notify) {
        @mail("$gb_notify","$gb_notifysubj","$notify_text $in[name]\n$rurl\n\nThe message posted:\n".censor_msg($in[message]),"From: $gb_notify");
    }
	$rtext=stripslashes($rtext);
	@mail("$in[email]","Thanks for using our Guestbook!","Thanks for posting your message on a WebmasterThings.com hosted guestbook!\n\n\n$rtext:\n$rurl","From: cs@webmasterthings.com");	

    mysql_close();                                                                                             

    if ($timelimit) {
        setcookie("phpbookcookie","$guestbook_head", time()+(60*$timelimit));
    }

    header("Location: $url_to_start");                                               

    exit;                                                                                                    

}

?>