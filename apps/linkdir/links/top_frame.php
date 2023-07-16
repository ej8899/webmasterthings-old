<?
// *******************************************************************
//  top_frame.php
// *******************************************************************
include("include/config.php");
include("include/functions.php");
include("include/common.php");
include("include/session.php");
// tcm remove php warning
// session_start();
$language = $gl["Language"];
include("include/lang/$language.php");
$theme = $gl["Theme"];
include("themes/$theme/tables.php");
$style = "netscape";
if(strstr($HTTP_USER_AGENT, "MSIE")){$style = "style";}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html>
<head>
	<meta name = "keywords" content =   "phplinks,php,mysql,free,links,search engine,index,search index,keyword,results,meta data,script" />
	<meta name = "description" content = "phplinks is a free php script for use with mysql. phplinks is a search engine, link farm script. phplinks is free for download." />
	<meta name = "robots" content = "all" />
	<!-- phplinks is a free php script for use with mysql.  phplinks is a search engine or link farm script. phplinks is free for download php script. -->
	<!-- phplinks,php,mysql,free,links,search engine,index,search index,keyword,results,meta data,script -->
	<title><?=$gl["SiteTitle"]?><?
		if($SERVER_NAME == "newphplinks.com"){
			echo " is a free php script for use with mysql. phplinks is a ";
			echo "search engine script. phplinks free for download.";
		}
		?>
	</title>
	<link rel = "stylesheet" type = "text/css" href = "themes/<?=$theme?>/<?=$style?>.css" />
</head>
<body bgcolor="white" marginwidth="0" marginheight="0" topmargin="0" leftmargin="0"><?
include("themes/$theme/header.php");
include("themes/$theme/navbar.top.php");
?>
</body>
</html>

