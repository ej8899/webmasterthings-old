<?

#  Project           	: phpBook                                                                                  
#  File name         	: guestbook_show.php                                                                                 
#  Last Modified By  	: Erich Fuchs                                                                               
#  e-mail            	: erich.fuchs@netone.at                                                                     
#  Purpose           	: Show the guestbook entry's                                                                                
                                                                                                                






#
# run a clean up routine - by TCM
#
# delete entries older than $tcmCleanupDays and email submitter 
# - ensure records only from the wt_firstowner 
#
if ($tcmCleanupDays >0)
{
mysql_connect($server, $db_user, $db_pass);
$TCMsort = "desc";
$TCMoffset = 0;
$TCMamount = mysql_db_query($database, "SELECT count(*) FROM $tablename $databwhere");
$TCMamount_array = mysql_fetch_array($TCMamount);
$tcmrecords = ceil($TCMamount_array["0"]);
$tcmresult = mysql_db_query($database, "SELECT * FROM $tablename $databwhere ORDER by id $TCMsort LIMIT $TCMoffset, $tcmrecords");

# loop thru ea db record
while ($TCMdb = mysql_fetch_array($tcmresult)) {
	# delete if its old enough
    $todaystime= time();
	$tcmoutdays=$tcmCleanupDays*86400; # this is # secs  difference
	$tcmtimedif=$todaystime-$TCMdb["timestamp"];
	if($tcmtimedif > $tcmoutdays)
	{
	
		$Subject = "Your guestbook entry expired!";
		$Body = "Today, your guestbook entry expired\n".
				"and has been removed from our listings.\n\n";

		@mail( $TCMdb[email],$Subject, $Body, "From: webmaster@webmasterthings.com");

		mysql_db_query($database, "DELETE FROM $tablename WHERE id='$TCMdb[id]'") or died("Database Query Error");
	}
} # end loop for each record

mysql_close();
}
#
# end cleanup routine
#




#  Connect to the DB
mysql_connect($server, $db_user, $db_pass);



#  Start with Output
echo "<table align=\"center\"  cellspacing=\"0\" cellpadding=\"3\" width=\"100%\" border=\"0\">\n";
echo "<tr>";

#  Calculate Page-Numbers
if (empty($perpage)) $perpage = 1;
if (empty($pperpage)) $pperpage = 9;	//!!! ONLY 5,7,9,11,13 !!!!
if (empty($sort)) $sort = "desc";
if (empty($offset)) $offset = 0;
if (empty($poffset)) $poffset = 0;                                                                               


if($secondowner) 
{
	$amount = mysql_db_query($database, "SELECT count(*) FROM $tablename WHERE (firstowner='$firstowner' AND secondowner='$secondowner')");
}
else
{
	$amount = mysql_db_query($database, "SELECT count(*) FROM $tablename WHERE firstowner='$firstowner'");
}


$amount_array = mysql_fetch_array($amount);
$pages = ceil($amount_array["0"] / $perpage);
$actpage = ($offset+$perpage)/$perpage;                                                                          
$maxoffset = ($pages-1)*$perpage;
$maxpoffset = $pages-$pperpage;
$middlepage=($pperpage-1)/2;

if ($maxpoffset<0) {$maxpoffset=0;}                                                                        
echo "<td align=right><div class=\"wt_normaltext\">\n";                                                                          
if ($admin) {$adminlink="&admin=$admin";}
if ($pages) {                                       // print only when pages > 0                                 
    echo "$ad_pages\n";                                                                                          
    if ($offset) {                                                                                               
        $noffset=$offset-$perpage;                                                                              
        $npoffset = $noffset/$perpage-$middlepage;                                                                        
        if ($npoffset<0) {$npoffset=0;}                                                                        
        if ($npoffset>$maxpoffset) {$npoffset = $maxpoffset;}                                                    
	echo "[<a href=\"guestbook.php?offset=0&poffset=0&$wtgb_data$adminlink\"><<</a>] ";
	echo "[<a href=\"guestbook.php?offset=$noffset&poffset=$npoffset&$wtgb_data$adminlink\"><</a>] ";
	}                                                                                                            

    for($i = $poffset; $i< $poffset+$pperpage && $i < $pages; $i++) {                                            
    	$noffset = $i * $perpage;
        $npoffset = $noffset/$perpage-$middlepage;                                                                        
        if ($npoffset<0) {$npoffset = 0;}
        if ($npoffset>$maxpoffset) {$npoffset = $maxpoffset;}                                                    
	$actual = $i + 1;
        if ($actual==$actpage) {                                                                                 
 	    echo "(<b>$actual</b>) ";
            } else {                                                                                             
 	    echo "[<a href=\"guestbook.php?offset=$noffset&poffset=$npoffset&$wtgb_data$adminlink\">$actual</a>] ";
	    }
	}

    if ($offset+$perpage<$amount_array["0"]) {                                                                   
        $noffset=$offset+$perpage;                                                                              
        $npoffset = $noffset/$perpage-$middlepage;                                                                        
        if ($npoffset<0) {$npoffset=0;}                                                                        
        if ($npoffset>$maxpoffset) {$npoffset = $maxpoffset;}                                                    
	echo "[<a href=\"guestbook.php?offset=$noffset&poffset=$npoffset&$wtgb_data$adminlink\">></a>] ";
	echo "[<a href=\"guestbook.php?offset=$maxoffset&poffset=$maxpoffset&$wtgb_data$adminlink\">>></a>] ";
        }                                                                                                        
    }                                                                                                            

echo "</div></td></tr>\n";                                                                                       
echo "</table>\n";                                                                                               


#  Start the Page

echo "<table align=\"center\"  cellspacing=\"1\" cellpadding=\"3\" width=\"100%\" border=\"0\">\n";

#  Get Entrys for current page 
if($secondowner) 
{
	$result = mysql_db_query($database, "SELECT * FROM $tablename WHERE (firstowner='$firstowner' AND secondowner='$secondowner') ORDER by id $sort LIMIT $offset, $perpage");
}
else
{
	$result = mysql_db_query($database, "SELECT * FROM $tablename WHERE firstowner='$firstowner' ORDER by id $sort LIMIT $offset, $perpage");
}

while ($db = mysql_fetch_array($result)) {
	$when = strftime("%m/%d/%Y %I:%M %p", $db["timestamp"]);

    if ($db[email]   != "none") { 
	$email = " (<a href=\"http://www.webmasterthings.com/apps/formpro/emailme.php?wt_owner=$firstowner&emailto=".$db[email]."\">email me</a>) "; 
	} else {
	$email = "";
	}
    if ($db[icq]     != 0)      { 
	$icq = "<a href=\"http://wwp.icq.com/scripts/contact.dll?msgto=$db[icq]\"><img src=\"http://wwp.icq.com/scripts/online.dll?icq=" . $db[icq] . "&img=5\" alt=\"$icq_message\" border=\"0\" align=\"right\" height=\"17\"></a>"; 
	} else {
	$icq = "";
	}
    if ($db[http]    != "none") { 
	$http = " (<a href=\"http://$db[http]\" target=\"anewsite\">view my website</a>) ";
	} else {
	$http = "";
	}
    if ($db[ip]      != "none") { 
       if ($admin==$adminpass) {
	  $ip = "<img src=\"$image_dir/icons/ip.gif\" alt=\"".$db[ip]."\" align=\"left\">"; 
       } else {
	  $ip = "<img src=\"$image_dir/icons/ip.gif\" alt=\"$ip_logged\" align=\"left\">"; 
       }   
    } else {
	$ip = "";
    }  
    if ($db[location]!= "none") { 
	$location = "in $db[location]";
	} else {
	$location = "";
	}
    if ($db[browser]      != "") { 
	$browser = "<img src=\"$image_dir/icons/browser.gif\" align=\"left\">"; 
	} else {
	$browser = "";
	}

    echo "  <tr>\n";                                                                                                     
//    echo "     <td class=\"gbtable1\">\n";                                                                           
//    echo "        <div class=\"mainname\">$db[name]</div><br>\n";
//    echo "        <div class=\"smallleft\">$location<br></div>\n";                                             
//    echo "        <br>$icq $http $email $ip $browser\n";                                                                     
//    echo "     </td>\n";                                                                                            
    echo "        <td class=\"gbtable2\"><div class=\"wt_normaltext\">\n";                                                

    if ($admin==$adminpass) {                                                                                             

        echo "<a href=\"guestbook_submit.php?delid=$db[id]&offset=$offset&poffset=$poffset$adminlink\"><img src=\"$image_dir/icons/trash.gif\" alt=\"$moderator_del_entry\" border=\"0\" align=\"right\"></a>";                                             

        echo "<a href=\"guestbook_submit.php?delcommentid=$db[id]&offset=$offset&poffset=$poffset$adminlink\"><img src=\"$image_dir/icons/trashcomment.gif\" alt=\"$moderator_del_comment\" border=\"0\" align=\"right\"></a>";                                             

        echo "<a href=\"guestbook_submit.php?commentid=$db[id]&offset=$offset&poffset=$poffset$adminlink\"><img src=\"$image_dir/icons/comment.gif\" alt=\"$moderator_edit_comment\" border=\"0\" align=\"right\"></a>";                                             

		        echo "<div class=\"spaceleft\">&nbsp;</div>\n";                                                                
    }                                                                                                              

	//
	// actual message display on screen
	//
//    echo "        $gb_posted $when</div><hr><div class=\"mainleft\">".censor_msg($db[message],($admin==$adminpass))."</div>\n";

// assemble $UserPicture info here if required 2 April 2004
$UserPicture="";
if($db[picture])
{
	$rootUser="./userphotos/";
	$UserPicture="<IMG SRC=showthumb.php?newwidth=90&image=$db[picture] width=90 border=0>";
}

		echo "<hr class=\"wt_lines\"><table border=0 width=100%><Tr><td valign=bottom class=\"gbtable2\"><div class=\"wt_normaltext\">";
		echo censor_msg($db[message],($admin==$adminpass))."</div><div align=right class=wt_smalltext><BR>by $db[name]$email on $when $location $http</div>";
		echo "</td><td align=right valign=bottom>$UserPicture</td></tr></table>";






    if($commentid == $db[id] && $entry!="changed" && $admin==$adminpass) {
      echo "  &nbsp;&nbsp\n";
      echo "  <form action=\"guestbook_submit.php\" method=\"post\">\n";
      echo "     <input type=\"hidden\" name=\"admin\" value=\"$admin\"><input type=\"hidden\" name=\"commentid\" value=\"$commentid\">\n";
      echo "     <input type=\"hidden\" name=\"offset\" value=\"$offset\"><input type=\"hidden\" name=\"poffset\" value=\"$poffset\">\n";
      echo "     <div class=\"comment\"><textarea name=\"comment\" cols=\"".($text_field_size-5)."\" rows=\"5\">".decode_msg($db[comment])."</textarea>\n<BR>";
      echo "     <input type=\"submit\">&nbsp;&nbsp;<a href=\"smiliehelp.php\"
                            onClick='enterWindow=window.open(\"smiliehelp.php\",\"Smilie\",
                            \"width=250,height=450,top=100,left=100,scrollbars=yes\"); return false'
                            onmouseover=\"window.status='$smiliehelp'; return true;\"
                            onmouseout=\"window.status=''; return true;\">$smiley_help</a></div>\n";
      echo "  </form>\n";

    } elseif(!empty($db[comment])) {
      echo "  &nbsp;&nbsp<div class=\"comment\">".$gb_modcomment.$db[comment]."</div>\n";
    }

    echo "      </td>\n  </tr>\n";                                                                                                    
    }                                                                                                    

echo "<tr><td><hr class=\"wt_lines\"></td></tr>";		
		
# End of Page reached
echo "</table>\n";                                                                                                         
#echo "<br>\n";
#echo "</div>";

#  Disconnect DB
mysql_close();



?>