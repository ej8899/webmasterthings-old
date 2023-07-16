<?php
#############################
# phpquotes_admin
# by Seyed Razavi
#############################
if (!$admin)
     header("location:admin.php");

if(!isset($mainfile))
{
  include("mainfile.php");
}
include("header.php");
global $plug_id;

switch ($op)
{
	case('block_set'):
		block_set();
		break;

	case('change_title'):
		change_title($title);
		break;

	case('change_position'):
		change_position($position);
		break;

	case('view_option'):
		view_option($view);
		break;
	
	case "QotdAdd":
		QotdAdd($qquote, $qauthor);
		break;
		
	case "QotdEdit":
	    QotdEdit($qid);
	    break;
	    
	case "QotdUpdate":
	    QotdUpdate($qid, $qquote, $qauthor);
	    break;
	    
	case "QotdDelete":
	    QotdDelete($qid);
	    break;
}   

// need to do some work here
// change this function...
function QotdAdd($qquote, $qauthor) {
    global $plug_id;
    mysql_query("insert into phpquotes (quote, author) values ('$qquote', '$qauthor')");
	$box_title = "<span class=\"onebigger\">Quote added</span>";
	$box_content = "Click <a href=\"phpquotes_admin.php?op=block_set&amp;plug_id=$plug_id\">here</a> to return to admin menu.";
	themesidebox($box_title, $box_content);
}

function QotdEdit($qid)
{
    global $plug_id;
    $get_quote = mysql_query("select quote, author from phpquotes where qid = $qid");
	list ($quote, $author)= mysql_fetch_row($get_quote);
    $box_content .= "<br /><hr /><br />
        </center><font size=\"4\"><b>"."Edit Quote"."</b></font><br /><br />
        <font size=\"2\">
        <form action=\"phpquotes_admin.php\" method=\"post\">
        <table border=\"0\"><tr><td>
        "."Quote text:"." </td><td>
        <textarea class=\"textbox\" name=\"qquote\" cols=\"60\" rows=\"5\">$quote</textarea></td></tr><tr><td>
        "."Author:"." </td><td><input class=\"textbox\" type=\"text\" name=\"qauthor\" size=\"31\" maxlength=\"128\" value=\"$author\" />
        </td></tr><tr><td>
        </td></tr></table>
        <input type=\"hidden\" name=\"plug_id\" value=\"$plug_id\" />
		<input type=\"hidden\" name=\"qid\" value=\"$qid\" />
        <input type=\"hidden\" name=\"op\" value=\"QotdUpdate\" />
        <input type=\"submit\" value=\"Update\" />
        </form>
        </td></tr></table></td></tr></table>";
	themesidebox ($box_title, $box_content);
}

function QotdUpdate($qid, $qquote, $qauthor)
{
    global $plug_id;
    $result = mysql_query("update phpquotes set quote ='$qquote', author='$qauthor' where qid=$qid");
    $box_title = "<span class=\"onebigger\">Quote updated</span>";
	$box_content = "Click <a href=\"phpquotes_admin.php?op=block_set&amp;plug_id=$plug_id\">here</a> to return to admin menu.";
	themesidebox($box_title, $box_content);
}

function QotdDelete($qid)
{
    global $plug_id, $confirm;
    if($confirm)
    {
        mysql_query("delete from phpquotes where qid=$qid");
        $box_title = "<span class=\"onebigger\">Quote deleted</span>";
	    $box_content = "Click <a href=\"phpquotes_admin.php?op=block_set&amp;plug_id=$plug_id\">here</a> to return to admin menu.";
	}
	else
	{
	    $result = mysql_query("select quote, author from phpquotes where qid=$qid");
	    list($quote, $author) = mysql_fetch_row($result);
	    $string = $quote;
        if(strlen($string)>25) 
        { 
            $string = substr($quote,0,24); 
            if($string != " ") 
            { 
                $last_space = strrpos($quote, " "); 
                $string = substr($quote,0,$last_space); 
                $string .= "..."; 
            }
        }
	    $box_title = "Are your should you wish to delete quote \"$string\" ($author)?";
	    $box_content = "<a href=\"phpquotes_admin.php?plug_id=$plug_id&amp;op=QotdDelete&amp;confirm=true&amp;qid=$qid\">Yes</a>&nbsp;<a href=\"phpquotes_admin.php?op=block_set&amp;plug_id=$plug_id\">No</a>";
	}
	themesidebox($box_title, $box_content);
}

function block_set()
{
#######################################################
# block_set.php
# by: Matthew McNaney
#
# This is a VERY basic setup function for controlling
# where your plug-in appears and what it is named.
#
#######################################################
	global $plug_id;
        $box_title = "<span class=\"onebigger\">Quotes options</span>";
		$get_info = mysql_query("select block_pos, name, admin_only, user_only from plugins where plug_id = $plug_id");
		list ($position, $title, $admin_only, $user_only)= mysql_fetch_row($get_info);

	        $box_content ="
<table cellspacing=\"1\" cellpadding=\"2\" width=\"100%\" border=\"0\">
                <tr>
                <td class=\"type5\" width=\"25%\">
                <form action=\"./phpquotes_admin.php\" method=\"post\">
                        <input type=\"hidden\" name=\"plug_id\" value=\"$plug_id\" />
                        <input type=\"hidden\" name=\"op\" value=\"view_option\" />
                        <input type=\"radio\" name=\"view\" value=\"admin\"";
		if ($admin_only == 1)
			$box_content .= " checked";

		$box_content .= " /> Admin Only<br />
                        <input type=\"radio\" name=\"view\" value=\"user\"";
                if ($user_only == 1)
                        $box_content .= " checked";

                $box_content .= " /> User Only<br />
                        <input type=\"radio\" name=\"view\" value=\"both\"";
                if ($admin_only == 0 && $user_only == 0)
                        $box_content .= " checked";

                $box_content .= " /> Both<br />
			<input type=\"submit\" value=\"Change View\" />
                </form>
                </td>

		<td class=\"type5\">
	        <form action=\"./phpquotes_admin.php\" method=\"post\">
			<input type=\"hidden\" name=\"plug_id\" value=\"$plug_id\" />
			<input type=\"hidden\" name=\"op\" value=\"change_position\" />
	                Position window:
	                <select name=\"position\">
	                <option value=\"1\"";

		if ($position == '1')
			$box_content .= " selected ";

		$box_content .= ">Left side</option>
	                <option value=\"2\"";

                if ($position == '2')
                        $box_content .= " selected ";

                $box_content .= ">Top center</option>
			<option value=\"3\"";

                if ($position == '3')
                        $box_content .= " selected ";

                $box_content .= ">Right side</option>
			<option value=\"0\"";

                if ($position == '0')
                        $box_content .= " selected ";

                $box_content .= ">No display</option>
			</select>
			<input type=\"submit\" value=\"Go!\" />
		</form>
	        ";

		$box_content .= "
		<form action=\"./phpquotes_admin.php\" method=\"post\">
			<input type=\"hidden\" name=\"op\" value=\"change_title\" />
			<input type=\"hidden\" name=\"plug_id\" value=\"$plug_id\" />
			<input type=\"text\" name=\"title\" size=\"30\" maxsize=\"100\" value=\"$title\" />
			<input type=\"submit\" value=\"Update Title\" />
		</form></td><tr/>
		</table>
		<br />In order to add ' or \" to the title, make sure you type \"\\\" before it.  Otherwise it will not show up.	
		";
		$box_content .= "<br /><hr /><br />
            </center><font size=\"2\"><b>"."Add Quote"."</b></font><br /><br />
            <font size=\"2\">
            <form action=\"phpquotes_admin.php\" method=\"post\">
            <input type=\"hidden\" name=\"plug_id\" value=\"$plug_id\" />
			<table border=\"0\"><tr><td>
            "."Quote text:"." </td><td>
            <textarea class=\"textbox\" name=\"qquote\" cols=\"60\" rows=\"5\"></textarea></td></tr><tr><td>
            "."Author:"." </td><td><input class=\"textbox\" type=\"text\" name=\"qauthor\" size=\"31\" maxlength=\"128\" />
            </td></tr><tr><td>
            </td></tr></table>
            <input type=\"hidden\" name=\"op\" value=\"QotdAdd\" />
            <input type=\"submit\" value=\"Add\" />
            </form>";
        $result = mysql_query("SELECT qid, quote, author FROM phpquotes order by qid");
        if(mysql_num_rows($result) < 1)
        {
            $box_content .= "<br /><hr /><br />No quotes in database";
        }
        else
        {
            $box_content .= "<p><table border=\"0\" width=\"100%\"><tr><td><b>Quote</b></td><td colspan=\"2\">&nbsp;</td></tr>";
            while (list($qid, $quote, $author) = mysql_fetch_row($result))
		    {
		        $box_content .= "<tr><td>";
		        $string = $quote;
		        if(strlen($string)>25) 
                { 
                    $string = substr($quote,0,24); 
                    if($string != " ") 
                    { 
                        $last_space = strrpos($quote, " "); 
                        $string = substr($quote,0,$last_space); 
                        $string .= "..."; 
                    }
                } 
                $box_content .= "$string - ($author)</td><td><a href=\"phpquotes_admin.php?plug_id=$plug_id&op=QotdEdit&qid=$qid\">Edit</a></td><td>
                    <a href=\"phpquotes_admin.php?plug_id=$plug_id&op=QotdDelete&qid=$qid\">Delete</a></td></tr>";
		    }
		    $box_content .= "</table></p>";
        }
		themesidebox ($box_title, $box_content);
}

function change_title($title)
{
	global $plug_id;
	mysql_query ("update plugins set name='$title' where plug_id=$plug_id");
	$box_title = "<span class=\"onebigger\">Title changed</span>";
	$box_content = "Click <a href=\"phpquotes_admin.php?op=block_set&amp;plug_id=$plug_id\">here</a> to return to admin menu.";
	themesidebox($box_title, $box_content);
}

function change_position($position)
{
	global $plug_id;
	mysql_query ("update plugins set block_pos=$position where plug_id=$plug_id");
	$box_title = "<span class=\"onebigger\">Quotes block moved.</span>";
	$box_content = "Click <a href=\"phpquotes_admin.php?op=block_set&amp;plug_id=$plug_id\">here</a> to return to admin menu.";
	themesidebox($box_title, $box_content);
}

function view_option ($view)
{
	global $plug_id;
	$sql_query = "update plugins set ";

	switch ($view)
	{
		case ('user'):
			$sql_query .= "admin_only=0, user_only=1 ";
			break;
		case ('admin'):
			$sql_query .= "admin_only=1, user_only=0 ";
			break;
		case ('both'):
			$sql_query .= "admin_only=0, user_only=0 ";
			break;
	}

	$sql_query .= "where plug_id=$plug_id";
	mysql_query ($sql_query);
	$box_title = "<span class=\"onebigger\">Quotes block view changed.</span>";
	$box_content = "Click <a href=\"phpquotes_admin.php?op=block_set&amp;plug_id=$plug_id\">here</a> to return to admin menu.";
	themesidebox($box_title, $box_content);

}

include ("footer.php");
?>
