<?

#  Project           	: phpBook                                                                                  
#  File name         	: guestbook.php                                                                               
#  Last Modified By  	: Erich Fuchs                                                                               
#  e-mail            	: erich.fuchs@netone.at                                                                     
#  Purpose           	: Guestbook Main Area                                                                     

// get 'secondowners' email - this will get notice of posting



# setup from passed in variables
#$gbheader  $gbdescribe 	$gburl

if ($gbheader)
{
	$guestbook_head = "$gbheader";           	// Guestbook Header (Name)
	$gb_desc		= "$gbdescribe";			// Enter your description here
}	
$wt_owner		= $firstowner;				// goes to the wt_guestbook firstowner field
$wt_owner2		= $secondowner;				// goes into the secondowner field
$gb_notify		= $owneremail;

//
// Include Configs & Variables
//

require ("config.php");

// this line gets added to guestbook.php calling
$wtgb_data="firstowner=$firstowner&secondowner=$secondowner&gbheader=".convert_spaces($gbheader)."&owneremail=$owneremail&rurl=$rurl&rtext=".convert_spaces($rtext);
#echo "<BR>$wtgb_data<BR>";

if (strstr (getenv('HTTP_USER_AGENT'), 'MSIE')) { // Internet Explorer Detection                                 
    $in_field_size="50";                                                                                            
    $text_field_size="31";                                                                                       
} else {                                          // Shit !!! fucking Netscape code                                                                            
    $in_field_size="30";                                                                                            
    $text_field_size="24";                                                                                       
}


//
//  Header
//
echo "$wt_header";

echo "  <link rel=\"stylesheet\" type=\"text/css\" href=\"gbstyle.css\">\n";

echo "    <script language=\"Javascript\">\n"; 
echo "       function floodprotect() {\n"; 
echo "   	alert(\"$banned\");\n"; 
echo "       }\n"; 
echo "    </script>\n"; 


#  The Main-Section                                                                                                        

#echo"<td valign=\"top\" align=\"left\">\n";                    


echo"<BR><BR><table align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"1\" margin=1 width=\"$table_width\" height=\"$table_height\">\n";
echo"   <tr>\n";                                                                                     
echo"    <td class=\"class1\">\n";                    
echo"      <table align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\" width=\"100%\" height=\"$table_height\">\n";                                
echo"       <tr>\n";                   
echo"        <td class=\"class2\">\n";

if ($entry=="add") {

    echo "	<div class=\"wt_header\"><b>Add to this guestbook...</b></div>\n";
    echo "	<div class=\"maintext\">\n";                                                                                           
    echo " 	<br>\n";                                                                                                             
    echo " 	<table align=\"center\">\n";                                                                                           
    echo " 	<Form action=\"guestbook_submit.php\" enctype=\"multipart/form-data\" method=\"post\">\n";                                                               
	echo "<input type=hidden name=wt_owner value=\"$firstowner\">";
	echo "<input type=hidden name=wt_owner2 value=\"$secondowner\">";	
	echo "<input type=hidden name=gbheader value=\"".convert_spaces($gbheader)."\">";
	echo "<input type=hidden name=owneremail value=\"$owneremail\">";
	echo "<input type=hidden name=rurl value=\"$rurl\">";
	$rtext=stripslashes($rtext);
	echo "<input type=hidden name=rtext value=\"".convert_spaces($rtext)."\">";
	
	echo "     	<tr>\n";                                                                                                     
    echo "      <td><div class=\"wt_normaltext\">$gbadd_name</div></td>\n";                                                 
    echo "      <td><input type=\"text\" name=\"in[name]\" size=\"$in_field_size\" maxlength=\"35\"></td>\n";                            
    echo "     	</tr>\n";                                                                                                    
    echo "     	<tr>\n";                                                                                                     
    echo "      <td><div class=\"wt_normaltext\">$gbadd_location</td>\n";                                                   

    if ($location_text) {                                                                                            
		echo "  <td><input type=\"text\" name=\"in[location]\" size=\"$in_field_size\" maxlength=\"35\"></td>\n";                        
    } 
	else {                                                                                                         
		echo "	<td class=\"class_add2\"><select name=\"in[location]\">\n";                                            
		echo "	<option value=\"0\" SELECTED>$location_sel</option>\n";                                
		include ("$loc_dir/$locations");                                                                      
		echo "	</select></td>\n";                                                                                     
    }

    echo "     </tr>\n";                                                                                                    
    echo "     <tr>\n";                                                                                                     
    echo "             <td><div class=\"wt_normaltext\">$gbadd_email</td>\n";                                                      
    echo "             <td><input type=\"text\" name=\"in[email]\" size=\"$in_field_size\" maxlength=\"35\"></td>\n";                           
    echo "     </tr>\n";                                                                                                    
    echo "     <tr>\n";                                                                                                     
    echo "             <td><div class=\"wt_normaltext\">$gbadd_url</td>\n";                                                        
    echo "             <td><input type=\"text\" name=\"in[http]\" size=\"$in_field_size\" maxlength=\"240\" value=\"http://\"></td>\n";            
    echo "     </tr>\n"; 

	// input picture with entry 2 april 2004
    echo " <tr><td><div class=\"wt_normaltext\">Picture:</td>\n";
	echo " <td><input type=\"file\" name=\"picture1url\" size=\"25\" class=\"input\"></td></tr>\n";
	                                                                                                
    echo "     <tr>\n";                                                                                                     
    echo "             <td valign=\"top\"><div class=\"wt_normaltext\">$gbadd_msg<br><br>\n";                                       
    echo "		<div class=\"wt_smalltext\"><a href=\"smiliehelp.php\"                                                        
			    onClick='enterWindow=window.open(\"smiliehelp.php\",\"Smilie\",
			    \"width=250,height=450,top=100,left=100,scrollbars=yes\"); return false'                                   
			    onmouseover=\"window.status='$smiliehelp'; return true;\"                                               
			    onmouseout=\"window.status=''; return true;\">Smile Codes</a>\n";                                 
    echo "		</div></td>\n";                                                                                            
    echo "             <td><textarea rows=\"8\" name=\"in[message]\" cols=\"$text_field_size\"></textarea></td>\n";                             
    echo "     </tr>\n";                                                                                                    
    echo "     <tr>\n";                                                                                                     
    echo "             <td></td>\n";                                                                                        
    echo "             <td><br><input type=\"submit\" Value=\"$submit\"</td>\n";                                                 
    echo "     </tr>\n";                                                                                                    
    echo " </table>\n";                                                                                                         
    echo " </form>\n";                                                                                                          
    echo"           </div>\n";
} 
else {
    echo"	    <table width=100%>\n";                                                                                           
    echo"            <tr><td>\n";                                                                                                            
    echo"              <div class=\"wt_header\"><b>$guestbook_head</b><BR><a href=\"$rurl\"><b>".stripslashes($rtext)."</b></a></div>\n";                                                                      
    echo"             </td>\n";                                                                                                          
    echo"             <td align=right>\n";
    echo"              <div class=\"wt_normaltext\">\n";

//	
// for flood protection
//
//    if ($phpbookcookie==$guestbook_head) {
//       echo" 		    <a href=\"\"  onclick=javascript:floodprotect() onmouseover=\"window.status='$gb_link1desc'; return true;\" onmouseout=\"window.status=''; return true;\">$gb_link1</a>\n";                                   
//    } 
//	else {
		$rtext=stripslashes($rtext);
       echo "<a href=\"guestbook.php?entry=add&$wtgb_data\" onmouseover=\"window.status='$gb_link1desc'; return true;\" onmouseout=\"window.status=''; return true;\"><b>$gb_link1</b></a>\n";                                   
//   }


    echo"              </div>\n";
    echo"            </td></tr>\n";
    echo"           </table>\n";
    echo"           <div class=\"maintext\">\n";
    include ("guestbook_show.php");

    echo"           </div>\n";
}

echo"        </td></tr></table>\n";
echo"        </td></tr></table>\n";

	
echo "<font face=arial size=1>$firstowner|$secondowner</font>";
echo $wt_footer;


?>