<? // Copyright 2001 Steve Gliebe. All rights reserved.

//
// setup this so it auto deletes old records - we'll need a new db field for the date
//

// run with http://www.webmasterthings.com/apps/links/admin.php?wt_owner=1004




require("common.php");



######### CHECK COOKIE #########
if ($wtdb[password] == $valid_password) {
  $valid = 1;
}
else {
  $valid = 0;
}

######### VALIDATE PASSWORD/SET COOKIE #########
if ($submit_login) {
// echo "$wt_owner|$login_password|$wtdb[password]";
//die;


  if ($login_password == $wtdb[password]) {
    setcookie("valid_password", "$login_password", time()+1800);  // cookie expires after 30 minutes
	setcookie("wt_owner","$wt_owner",time()+1800); // set wt_owner info into cookie
	
    $valid = 1;
	
	// if we are superuser, allow us to edit everything else only their own entries
	if($login_password ==  $admin_password) 
	{
		$wtdbaccess="";				// keeps 'where' clean for all records
	}
	else
	{
		$wtdbaccess="WHERE belongsto = $wt_owner"; 	// allows this wt webmaster to edit only their stuff
	}
  }
  else {
    $failure = "<ul><li>Incorrect Password:</li></ul>";
    $valid = 0;
  }
}

######### PRINT HEADER #########
echo "$header_html";
echo "wt owner: $wt_owner<BR><BR>";

######### LOGIN FORM #########
if (!$valid) {
  echo "<p>\n";
  print_title_message('Log In', 'Please enter your password to access the admin area.');
  echo $failure;
  echo "<form method=post action=$PHP_SELF>\n";
  echo "<span id=linkster-title-small>Password:</span><br>\n";
  echo "<input type=password name=login_password size=12>\n";
  echo "<input type=hidden name=submit_login value=1>\n";
  echo "<input type=hidden name=wt_owner value=$wt_owner>\n";
  echo "<input type=submit value=' Log In '>\n";
  echo "</p>\n";
}

########## MENU ###########
if ($valid) {
  echo "<table border=0 cellpadding=18 cellspacing=0>\n";
  echo "  <tr>\n";
  echo "    <td>\n";
  echo "    <div id=linkster-title-small>Categories Admin</div>\n";
  echo "    <li><a href=$PHP_SELF?action=add_cat>Add a Category</a></li>\n";
  echo "    <li><a href=$PHP_SELF?action=modify_cat>Modify a Category</a></li>\n";
  echo "    <li><a href=$PHP_SELF?action=remove_cat>Remove a Category</a></li>\n";
  echo "    </td>\n";
  echo "    <td>\n";
  echo "    <div id=linkster-title-small>Links Admin</div>\n";
  echo "    <li><a href=$PHP_SELF?action=add_link>Add a Link</a></li>\n";
  echo "    <li><a href=$PHP_SELF?action=modify_link>Modify a Link</a></li>\n";
  echo "    <li><a href=$PHP_SELF?action=remove_link>Remove a Link</a></li>\n";
  echo "	<BR><li><a href=$PHP_SELF?action=logout>Logout</a></li>\n";
  echo "    </td>\n";
  echo "  </tr>\n";
  echo "</table>\n";
}

//
// logout routine.... simply clear our password cookie
//
if($actin=="logout")
{
    setcookie("valid_password", "getlost", time()+1800);  // cookie expires after 30 minutes
	setcookie("wt_owner","0000",time()+1800); // set wt_owner info into cookie
	$wt_owner="";
	echo "logged out";
}


//
//	add a category
//
if ($action == "add_cat" && $valid) {
  // process/validate form
  if ($submit) {
    // validate data
    if(!$Category) {  // blank category
      $error = "<li>Category Name cannot be left blank</li>";
    }
    if (strlen($Description) > 200) {  // description too long
      $error .= "<li>Description cannot exceed 200 characters (length: " . strlen($Description) . ")</li>\n";
    }
    // add category if valid
    if (!$error) {
      $Category = escape_quotes($Category);
      $Description = escape_quotes($Description);
      mysql_query("INSERT INTO $cat_table (Category, Description, belongsto) VALUES ('$Category','$Description','$wt_owner')");  // executes query
    }
    else {
      $Category = strip_quotes($Category);
      $Description = strip_quotes($Description);
    }
  }
  // print title/message
  $title = "Add a Category";
  $message = "Enter your new category's name and description.";
  if ($error) {
    $title = "$title: Error";
    $message = "The following error(s) occurred:\n<ul>$error</ul>";
  }
  if ($submit && !$error) {
    $title = "Category Added";
    $message = "Category has been successfully added.";
  }
  print_title_message($title, $message);
  // print form
  if (!$submit || $error){
    category_form("Add", $PHP_SELF, $QUERY_STRING, $Category, $Description);
  }
}

//
//	modify a category
//
if ($action == "modify_cat" && $valid) {
  // select category
  if (!$CID) {
    print_title_message("Modify a Category", "Select a category to modify");
    echo "<form method=get action=$PHP_SELF>\n";
    echo "<input type=hidden name=action value=$action>\n";
    echo "<p><div id=linkster-title-small>Category:</div>\n";
    category_select($db, '', '', $cat_table);  // print categories
    echo " <input type=submit value=' Select '>\n";
    echo "</p>\n";	
    echo "</form>\n";
  }
  // modify selected category
  if ($CID) {
    // process/validate form
    if ($submit) {
      // validate category data
      if(!$Category) {  // blank category
        $error = "<li>Category Name cannot be left blank</li>";
      }
      if (strlen($Description) > 200) {  // description too long
        $error .= "<li>Description cannot exceed 200 characters (length: " . strlen($Description) . ")</li>\n";
      }
      // modify category if valid
      if (!$error) {
        $Category = escape_quotes($Category);
        $Description = escape_quotes($Description);
        mysql_query("UPDATE $cat_table SET Category = '$Category', Description = '$Description' WHERE ID = $CID AND belongsto=$wt_owner");  // executes query
      }
      else {
        $Category = strip_quotes($Category);
        $Description = strip_quotes($Description);
      }
    }
    // print title/message
    $title = "Modify a Category";
    if ($error) {
      $title = "$title: Error";
      $message = "The following error(s) occurred:\n<ul>$error</ul>";
    }
    if ($submit && !$error) {
      $title = "Category Modified";
      $message = "Category has been successfully modified.";
    }
    print_title_message($title, $message);
    // print form
    if (!$submit || $error){
      if (!$error) {
        $query = mysql_query("SELECT * FROM $cat_table WHERE ID = $CID");
        extract(mysql_fetch_array($query));
      }
      // print modify form
      category_form("Modify", $PHP_SELF, $QUERY_STRING, $Category, $Description);
    }
  }
}

//
//	remove a category
//
if ($action == "remove_cat" && $valid) {
  // select category
  if (!$CID) {
    print_title_message("Remove a Category", "Select a category to remove.");
    echo "<form method=get action=$PHP_SELF>\n";
    echo "<input type=hidden name=action value=$action>\n";
    echo "<p><div id=linkster-title-small>Category:</div>\n";
    category_select($db, '', '', $cat_table);  // print categories
    echo " <input type=submit value=' Select '>\n";
    echo "</p>\n";	
    echo "</form>\n";
  }
  // remove selected category
  if ($CID) {
    if (!$remove && !$cancel) {
      $query = mysql_query("SELECT Category, $cat_table.Description FROM $cat_table, $link_table WHERE $cat_table.ID = $link_table.Cat_ID AND $cat_table.ID = $CID AND $cat_table.belongsto=$wt_owner");
      $link_count = mysql_num_rows($query);
      if ($link_count == 0) {  // run new query if no links exist
        $query = mysql_query("SELECT Category, Description FROM $cat_table WHERE ID = $CID AND $cat_table.belongsto=$wt_owner");
      }
      extract(mysql_fetch_array($query));  // extract vars
      print_title_message("Remove a Category", "Are you sure you want to remove this category and all of its links?");
      echo "<ul><li><b>$Category</b> ($link_count links)<br>$Description</li></ul>\n";  // print category

      echo "<form method=post action=$PHP_SELF?$QUERY_STRING>\n";
      echo "<input type=submit name=remove value=' Remove '> <input type=submit name=cancel value=' Cancel '>\n";
      echo "</form>\n";
    }
     else {  // process form
      if ($remove) {
        $title = "Category Removed";
        $message = "Category has been successfully removed.";
        mysql_query("DELETE FROM $cat_table WHERE ID = $CID");  // remove category
        mysql_query("DELETE FROM $link_table WHERE Cat_ID = $CID");  // remove links
      }
      if ($cancel) {
        $title = "Category Not Removed";
        $message = "Category has not been removed.";
      }
    print_title_message($title, $message);
    }
  }
}

//
//	add a link to database
//
if ($action == "add_link" && $valid) {
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
    if ($URL && !$validURL) {  // if invalid, return error and reset URL to null
      $error .= "<li>Website URL is invalid</li>\n";
    }
    if (strlen($Description) > 200) {
      $error .= "<li>Description cannot exceed 200 characters (length: " . strlen($Description) . ")</li>\n";
    }
    // add link to database
    if (!$error) {
      $Website = escape_quotes($Website);
      $URL = escape_quotes($URL);
      $Description = escape_quotes($Description);
	mysql_query("INSERT INTO $link_table (Cat_ID, Website, URL, Description, Email, belongsto) VALUES ('$CID','$Website','$URL','$Description','$Email','$wt_owner')");
      mysql_query("UPDATE $cat_table SET Count = Count+1 WHERE ID = $CID");
    }
    else {
      $Website = strip_quotes($Website);
      $URL = strip_quotes($URL);
      $Description = strip_quotes($Description);
    }
  }
  // print title and message
  $title = "Add a Link";
  $message = "Fill out the form below to add a link.";
  if ($error) { 
    $title = "Error Adding Link";
    $message = "The following error(s) occured:\n <ul>$error</ul>Please correct any errors and try again.";
  }
  if ($submit && !$error) {
    $title = "Link Added";
    $message = "Link has been added.";
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
    echo "</form>\n";
  }
}

//
//	modify a link
//
if ($action == "modify_link" && $valid) {
  // select category
  if (!$CID & !$LID) {
    print_title_message("Modify a Link", "Select a category to modify its links.");
    echo "<form method=get action=$PHP_SELF>\n";
    echo "<input type=hidden name=action value=$action>\n";
    echo "<p><div id=linkster-title-small>Category:</div>\n";
    category_select($db, '', '', $cat_table);  // print categories
    echo "</p>\n";
    echo "<p><div id=linkster_title_small>Sort Order:</div><span style='font-size: 8pt'><input type=radio name=order value=alpha checked>Alphabetically<br>\n<input type=radio name=order value=chrono>Chronologically</span></p>\n";
    echo "<input type=submit value=' Select '>\n";
    echo "</form>\n";
  }
  // select link from selected category to modify
  if ($CID && !$LID) {
    // sorting
    if ($order == "chrono") {
      $orderby = "$link_table.ID DESC";
    }
    if ($order == "alpha") {
      $orderby = "Website";
    }
    $query = mysql_query("SELECT $link_table.ID, Website, URL, Category, Email FROM $cat_table, $link_table WHERE $cat_table.ID = $link_table.Cat_ID AND Cat_ID = $CID AND $link_table.belongsto=$wt_owner ORDER BY $orderby");
    print_title_message("Modify a Link", "Select a link to modify.");
    echo "<p>\n";
    while (list($LID, $Website, $URL) = mysql_fetch_array($query)) {
      echo "<div><b>[ <a href=$PHP_SELF?action=$action&LID=$LID>Modify</a> ]</b> <a href=$URL>$Website</a><div>\n";  
    }
    echo "</p>\n";
  }
  // modify selected link
  if ($LID) {
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
      if (!$Clicks && $Clicks != '0') {
        $error .= "<li>Clicks cannot be left blank.</li>";
      }
      $Clicks += 0;  // remove non numeric characters
      // modify link
      if (!$error) {
        $Website = escape_quotes($Website);
        $URL = escape_quotes($URL);
        $Description = escape_quotes($Description);
        mysql_query("UPDATE $link_table SET Cat_ID = '$CID', Clicks = '$Clicks', Website = '$Website', URL = '$URL', Description = '$Description', Email='$Email' WHERE ID = $LID");
      }
      else {
        $Website = strip_quotes($Website);
        $URL = strip_quotes($URL);
        $Description = strip_quotes($Description);
      }
    }
    // print title and message
    $title = "Modify a Link";
    if ($error) { 
      $title = "Error Modifying Link";
      $message = "The following error(s) occured:\n <ul>$error</ul>Please correct any errors and try again.";
    }
    if ($submit && !$error) {
      $title = "Link Modified";
      $message = "Link has been modified.";
    } 
    print_title_message($title, $message);
    // print form
    if (!$submit || $error) {
      if (!$error) {
        $query = mysql_query("SELECT * FROM $link_table WHERE ID = $LID");
        extract(mysql_fetch_array($query));
      }
      echo "<form method=post action=$PHP_SELF?$QUERY_STRING>\n";
      link_form($db, $Cat_ID, $CID, $Website, $URL, $Description, $Email, $cat_table, $link_table);
      echo "<p><div id=linkster-title-small>Clicks:</div><input type=text name=Clicks size=4 maxlength=6 value=\"$Clicks\"></p>\n";
      echo "<input type=submit name=submit value=' Modify Link '>\n";
      echo "</form>\n";
    }
  }
}

//
//	remove a link from database
//
if ($action == "remove_link" && $valid) {
  // select category
  if (!$CID & !$LID) {
    print_title_message("Remove a Link", "Select a category to remove links from.");
    echo "<form method=get action=$PHP_SELF>\n";
    echo "<input type=hidden name=action value=$action>\n";
    echo "<p><div id=linkster-title-small>Category:</div>\n";
    category_select($db, $Cat_ID, $CID, $cat_table);  // print categories
    echo "</p>\n";
    echo "<p><div id=linkster_title_small>Sort Order:</div><span style='font-size: 8pt'><input type=radio name=order value=alpha checked>Alphabetically<br>\n<input type=radio name=order value=chrono>Chronologically</span></p>\n";
    echo "<input type=submit value=' Select '>\n";
    echo "</form>\n";
  }
  // select link from selected category to remove
  if ($CID && !$LID) {
    // sorting
    if ($order == "chrono") {
      $orderby = "$link_table.ID DESC";
    }
    if ($order == "alpha") {
      $orderby = "Website";
    }
    $query = mysql_query("SELECT $link_table.ID, Website, URL, Category, belongsto FROM $cat_table, $link_table WHERE $cat_table.ID = $link_table.Cat_ID AND Cat_ID = $CID AND $link_table.belongsto=$wt_owner ORDER BY $orderby");
    print_title_message("Remove a Link", "Select the link you wish to remove.");
    echo "<p>\n";
    while (list($LID, $Website, $URL) = mysql_fetch_array($query)) {
      echo "<div><b>[ <a href=$PHP_SELF?action=$action&LID=$LID>Remove</a> ]</b> <a href=$URL>$Website</a><div>\n";  
    }
    echo "</p>\n";
  }
  if ($LID && !$remove && !$cancel) {
    print_title_message("Remove a Link", "Are you sure you want to remove this link?");
    $query = mysql_query("SELECT * FROM $link_table WHERE ID = $LID");
    extract(mysql_fetch_array($query));
    echo "<ul><a href=$URL>$Website</a> ($Clicks clicks)<br>\n$Description</ul>\n";
    echo "<form method=post action=$PHP_SELF?$QUERY_STRING>\n";
    echo "<input type=hidden name=CID value=\"$Cat_ID\">\n";
    echo "<input type=hidden name=Website value=\"$Website\">\n";
    echo "<input type=submit name=remove value=' Remove '> <input type=submit name=cancel value=' Cancel '>\n";
    echo "</form>\n";
  }
  else {  // process form
    if ($remove) {
      $title = "Link Removed";
      $message = "Link has been successfully removed.";
      mysql_query("DELETE FROM $link_table WHERE ID = $LID");
      mysql_query("UPDATE $cat_table SET Count = Count-1 WHERE ID = $CID");
    }
    if ($cancel) {
      $title = "Link Not Removed";
      $message = "Link has not been removed.";
    }
    print_title_message($title, $message);
  }
}

//
//	show the footer code and close the database
//
echo "$footer_html";
mysql_close($db);

?>