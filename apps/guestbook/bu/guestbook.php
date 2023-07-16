<?

#  Project           	: phpBook                                                                                  
#  File name         	: guestbook.php                                                                               
#  Last Modified By  	: Erich Fuchs                                                                               
#  e-mail            	: erich.fuchs@netone.at                                                                     
#  Purpose           	: Guestbook Main Area                                                                     


#  Include Configs & Variables                                                                                                                

#################################################################################################                



require ("config.php");



if (strstr (getenv('HTTP_USER_AGENT'), 'MSIE')) { // Internet Explorer Detection                                 

    $in_field_size="50";                                                                                            

    $text_field_size="31";                                                                                       

} else {                                          // Shit !!! fucking Netscape code                                                                            

    $in_field_size="30";                                                                                            

    $text_field_size="24";                                                                                       

}



#  Header                                                                                                                

#################################################################################################                



echo "<html>\n";                                                                                                                 

echo " <head>\n";

echo "  <title>$guestbook_head</title>\n";

echo "  <link rel=\"stylesheet\" type=\"text/css\" href=\"style.css\">\n";                                                             

echo "  $languagemetatag\n";

echo "  <meta name=\"robots\" content=\"index, nofollow\">\n";                                                                       

echo "  <meta name=\"revisit-after\" content=\"20 days\">\n";                                                                        

echo "    <script language=\"Javascript\">\n"; 
echo "       function floodprotect() {\n"; 
echo "   	alert(\"$banned\");\n"; 
echo "       }\n"; 
echo "    </script>\n"; 

echo " </head>\n";                                                                                                               

echo "<body>\n";



#  The Main-Section                                                                                                        

#################################################################################################                



#echo"<td valign=\"top\" align=\"left\">\n";                    

echo" <table align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"1\" margin=1 width=\"$table_width\" height=\"$table_height\">\n";

echo"   <tr>\n";                                                                                     

echo"    <td class=\"class1\">\n";                    

echo"      <table align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\" width=\"100%\" height=\"$table_height\">\n";                                

echo"       <tr>\n";                   

echo"        <td class=\"class2\">\n";

if ($entry=="add") {

    echo "	<div class=\"mainheader\">$gb_link1head</div>\n";                                                                

    echo "	<div class=\"maintext\">\n";                                                                                           

    echo " 	<br>\n";                                                                                                             

    echo " 	<table align=\"center\">\n";                                                                                           

    echo " 	<Form action=\"guestbook_submit.php\" method=\"post\">\n";                                                               

    echo "     	<tr>\n";                                                                                                     

    echo "      <td><div class=\"maininputleft\">$gbadd_name</div></td>\n";                                                 

    echo "      <td><input type=\"text\" name=\"in[name]\" size=\"$in_field_size\" maxlength=\"35\"></td>\n";                            

    echo "     	</tr>\n";                                                                                                    

    echo "     	<tr>\n";                                                                                                     

    echo "      <td><div class=\"maininputleft\">$gbadd_location</td>\n";                                                   

    if ($location_text) {                                                                                            

	echo "  <td><input type=\"text\" name=\"in[location]\" size=\"$in_field_size\" maxlength=\"35\"></td>\n";                        

    } else {                                                                                                         

	echo "	<td class=\"class_add2\"><select name=\"in[location]\">\n";                                            

	echo "	<option value=\"0\" SELECTED>$location_sel</option>\n";                                

	include ("$loc_dir/$locations");                                                                      

	echo "	</select></td>\n";                                                                                     

    }

    echo "     </tr>\n";                                                                                                    

    echo "     <tr>\n";                                                                                                     

    echo "             <td><div class=\"maininputleft\">$gbadd_email</td>\n";                                                      

    echo "             <td><input type=\"text\" name=\"in[email]\" size=\"$in_field_size\" maxlength=\"35\"></td>\n";                           

    echo "     </tr>\n";                                                                                                    

    echo "     <tr>\n";                                                                                                     

    echo "             <td><div class=\"maininputleft\">$gbadd_icq</td>\n";                                                        

    echo "             <td><input type=\"text\" name=\"in[icq]\" size=\"$in_field_size\" value=\"\" maxlength=\"12\"></td>\n";                    

    echo "     </tr>\n";                                                                                                    

    echo "     <tr>\n";                                                                                                     

    echo "             <td><div class=\"maininputleft\">$gbadd_url</td>\n";                                                        

    echo "             <td><input type=\"text\" name=\"in[http]\" size=\"$in_field_size\" maxlength=\"60\" value=\"http://\"></td>\n";            

    echo "     </tr>\n";                                                                                                    

    echo "     <tr>\n";                                                                                                     

    echo "             <td valign=\"top\"><div class=\"maininputleft\">$gbadd_msg<br><br>\n";                                       

    echo "		<div class=\"xsmallleft\"><a href=\"smiliehelp.php\"                                                        

			    onClick='enterWindow=window.open(\"smiliehelp.php\",\"Smilie\",

			    \"width=250,height=450,top=100,left=100,scrollbars=yes\"); return false'                                   

			    onmouseover=\"window.status='$smiliehelp'; return true;\"                                               

			    onmouseout=\"window.status=''; return true;\">$smiley_help</a>\n";                                 

    echo "		<div class=\"xsmallleft\"><a href=\"urlcodehelp.php\"                                                        

			    onClick='enterWindow=window.open(\"urlcodehelp.php\",\"URLCode\",

			    \"width=550,height=450,top=100,left=100,scrollbars=yes\"); return false'                                   

			    onmouseover=\"window.status='$urlcodehelp'; return true;\"                                               

			    onmouseout=\"window.status=''; return true;\">$url_code_help</a>\n";                                 

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

} else {

    echo"	    <table>\n";                                                                                           

    echo"            <tr>\n";                                                                                                            

    echo"             <td width=\"1%\">\n";                                                                                                 

    echo"              <div class=\"mainheader\">$guestbook_head</div>\n";                                                                      

    echo"             </td>\n";                                                                                                          

    echo"             <td>\n";                                                                                                           

    echo"              <div class=\"mainmenu\">\n";                                                                                        

    if ($phpbookcookie==$guestbook_head) {

       echo" 		    <a href=\"\"  onclick=javascript:floodprotect() onmouseover=\"window.status='$gb_link1desc'; return true;\" onmouseout=\"window.status=''; return true;\">$gb_link1</a>\n";                                   

    } else {

       echo" 		    <a href=\"guestbook.php?entry=add\" onmouseover=\"window.status='$gb_link1desc'; return true;\" onmouseout=\"window.status=''; return true;\">$gb_link1</a>\n";                                   

    }

    echo"              </div>\n";                                                                                                        

    echo"             </td>\n";                                                                                                          

    echo"            </tr>\n";                                                                                                           

    echo"           </table>\n";                                                                                                         

    echo"           <div class=\"maintext\">\n";                                                                                           

    include ("guestbook_show.php");

    echo"           </div>\n";

}

echo"        </td>\n";                                                                                                     

echo"       </tr>\n";                                                                                                   

echo"      </table>\n";

echo"    </td>\n";                                                                                                      

echo"   </tr>\n";                                                                                                       

echo" </table>\n";

echo"</body>\n";

echo"</html>\n";

?>