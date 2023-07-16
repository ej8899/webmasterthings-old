<? 
// Copyright 2002 TCM
// modified 5.15.02 for multiuser support for WebmasterThings.com
//
//
// http://www.webmasterthings.com/apps/links/links.php?wt_owner=1004&CID=0 (or CID=a for all cats)
//

require("common.php");

######### CLICK COUNT #########
if ($QUERY_STRING && $LID && $URL) {
  mysql_query("UPDATE $link_table SET Clicks = Clicks+1 WHERE ID = $LID");  // add 1 to click count
  header("Location: $URL");  // send user to website
}

######### PRINT HEADER/MENU #########
echo "$header_html";

echo "wt_owner: $wt_owner - mode:$mode-<BR><BR>";

//
//	flat mode
//
if ($mode == "flat" && !$QUERY_STRING) {

  $query = "SELECT $link_table.ID AS LID, Clicks, Website, URL, $link_table.Description AS LDescription, $cat_table.ID AS CID, Category, $cat_table.Description AS CDescription FROM $cat_table, $link_table WHERE $cat_table.ID = $link_table.Cat_ID  ORDER BY $cat_order, $links_order";
  print_table ($query, $PHP_SELF, $tbl_border, $tbl_cellpadding, $tbl_cellspacing, $tbl_width, $tbl_align, $row1_color, $row2_color, $row3_color, $Category, $CDescription, $LID, $URL, $Website, $LDescription, $Clicks, $show_clicks, $show_credit, $credit_html, $new_window, $cat_table, $link_table);
}

//
//	categorized mode (1 level deep)
//
if ($mode == "leveled" && !$LID && !$URL) {
  // print categories

  if ($CID=='a') {
    $query = "SELECT ID,belongsto,Count,Category,Description FROM $cat_table WHERE belongsto=$wt_owner ORDER BY $cat_order";
    $result = mysql_query($query) or die("<p><b>Error:</b> No data exists($wt_owner).</p>\n</body>\n</html>\n\n");

    echo "<p align='$tbl_align'>\n";
    echo "<table border='$tbl_border' cellpadding='$tbl_cellpadding' cellspacing='$tbl_cellspacing' width='$tbl_width'>\n";
    echo "  <tr>\n";
    echo "    <td align=left id=linkster-title-small bgcolor='$row2_color'>Choose a site category...</td>\n";
    echo "  </tr>\n";
    while (list($CID, $theowner,$Count, $Category, $Description) = mysql_fetch_array($result)) 
	{
      $Category = "<a href=$PHP_SELF?CID=$CID&wt_owner=$wt_owner>$Category</a>";

      if ($Description) 
	  {
        $Description = ": $Description";
      }
      echo "  <tr>\n";
      echo "    <td bgcolor='$row3_color' id=linkster-list><B>$Category</B>$Description</td>\n";
      echo "  </tr>\n";
    }

    if ($show_credit == "yes") {
      echo "  <tr>\n";
      echo "    <td colspan=2><br>$credit_html</td>\n";
      echo "  </tr>\n";
    }
    echo "</table>\n";
    echo "</p>\n";
  }
  // print links for specific category
  if ($CID=="0")
  {
  	echo "<b>Most Recent Additions to our directory:</b><BR><small>";
	
  	$query = "SELECT $link_table.ID AS LID, Clicks, Website, URL, $link_table.Description AS LDescription, $cat_table.ID AS CID, Category, $cat_table.Description AS CDescription,$link_table.belongsto";
  	$query .= " FROM $cat_table, $link_table";
  	$query .= " WHERE $cat_table.ID = $link_table.Cat_ID AND $link_table.belongsto=$wt_owner AND $link_table.public='y'";
  	$query .= " ORDER BY $link_table.ID DESC LIMIT 0, 25";
  	$result = mysql_query($query);
  	$link_count = mysql_num_rows($result);
  	if ($link_count > 0) 
  	{
	    while (list($LID, $Clicks, $Website, $URL, $LDescription, $CID, $Category, $CDescription) = mysql_fetch_array($result)) 
		{
			echo "&nbsp;- <a href=$PHP_SELF?LID=$LID&URL=$URL".$new_window."><B>$Website</B></a><BR>";
		}
	  	echo "</small><BR><BR><BR><font size=2><b><a href=$PHP_SELF?wt_owner=$wt_owner&CID=a>Click here to see more sites...</a></b></font>";
  	}
  }

  if($CID>0)
  {
  	$query = "SELECT $link_table.ID AS LID, Clicks, Website, URL, $link_table.Description AS LDescription, $cat_table.ID AS CID, Category, $cat_table.Description AS CDescription";
  	$query .= " FROM $cat_table, $link_table";
  	$query .= " WHERE $cat_table.ID = $link_table.Cat_ID AND $cat_table.ID = $CID AND $link_table.belongsto=$wt_owner AND $link_table.public='y'";
  	$query .= " ORDER BY $links_order";
  	print_table ($query, $PHP_SELF, $tbl_border, $tbl_cellpadding, $tbl_cellspacing, $tbl_width, $tbl_align, $row1_color, $row2_color, $row3_color, $Category, $CDescription, $LID, $URL, $Website, $LDescription, $Clicks, $show_clicks, $show_credit, $credit_html, $new_window, $cat_table, $link_table);

  }
}

//
//	add a link (surfer option)
//
if ($action == "add_link" && $public_add == "yes") {
  // process form
  if ($submit) {
    // check for errors
    if (!$Website) {
      $error = "<li>Website Name cannot be left blank</li>\n";
    }
    if (!$URL) {
      $error .= "<li>Website URL cannot be left blank</li>\n";
    }
    if (eregi("http://", $URL) && eregi("\.", $URL)) {  // URL must contain http:// and . to be valid
      $validURL = 1;
    }
    if ($URL && !$validURL) { 
      $error .= "<li>Website URL is invalid</li>\n";
    }
    if (strlen($Description) > 200) {
      $error .= "<li>Description cannot exceed 200 characters (length: " . strlen($Description) . ")</li>\n";
    }
	
#
# CHECK FOR RECIP LINK and set error variable if not found
#

#
#
#	
    // add link to database
    if (!$error) {
      $Website = escape_quotes($Website);
      $URL = escape_quotes($URL);
      $Description = escape_quotes($Description);
      mysql_query("INSERT INTO $link_table (Cat_ID, Website, URL, Description, Email, belongsto,public) VALUES ('$CID','$Website','$URL','$Description','$Email', '$wt_owner','n')");
          }
    else {
      $Website = strip_quotes($Website);
      $URL = strip_quotes($URL);
      $Description = strip_quotes($Description);
    }
  }
  // print title and message
  $title = "<B>Add a Site</B>";
  $message = "Fill out the form below to add a site.";
  if ($error) { 
    $title = "<b>Error Adding Site</b>";
    $message = "The following error(s) occured:\n <ul>$error</ul>Please correct any errors and try again.";
  }
  if ($submit && !$error) {
    $title = "<b>Site Added</b>";
    $message = "Your site has been added.";
  } 
  print_title_message($title, $message);
  // print form
  if (!$submit) {  // sets URL before user touches it
    $URL = "http://";
  }
  if (!$submit || $error) {
    echo "<form method=post action=$PHP_SELF?$QUERY_STRING>\n";
    link_form($db, $Cat_ID, $CID, $Website, $URL, $Description, $Email, $cat_table);
    echo "<input type=submit name=submit value=' Add Link '>\n";
	echo "<input type=hidden name=wt_owner value=$wt_owner>";
    echo "</form>\n";
  }
}

//
//	show footer and close database
//
echo "$footer_html";
mysql_close($db);  // close db connection

?>