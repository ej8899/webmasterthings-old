<?
// *******************************************************************
//  index.php
// *******************************************************************

include("include/config.php");
include("include/functions.php");
include("include/common.php");

include("include/session.php");
// // tcm remove php warning
// session_start();

$language = $gl["Language"];

include("include/lang/$language.php");

$theme = $gl["Theme"];

include("themes/$theme/tables.php");

$style = "netscape";

if(strstr($HTTP_USER_AGENT, "MSIE")){
	$style = "style";
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html>
<head>
	<meta
		name    =   "keywords"
		content =   "phplinks,php,mysql,free,links,search engine,
					index,search index,keyword,results,meta data,
					script"
	/>
	<meta
		name    =   "description"
		content =   "phplinks is a free php script for use with 
					mysql. NewPHPLinks is a search engine, link farm
					script. NewPHPLinks is free for download."
	/>
	<meta
		name    =   "robots"
		content =   "all"
	/>
	<!--
		phplinks is a free php script for use with mysql.  phplinks
		is a search engine or link farm script. phplinks is free for
		download php script.
	-->
	<!--
		phplinks,php,mysql,free,links,search engine,index,search
		index,keyword,results,meta data,script
	-->
	<title>
		<?=$gl[SiteTitle]?>
		<?
		if($SERVER_NAME == "http://sourceforge.net/projects/phplinks/"){
			echo " is a free php script for use with mysql. NewPHPlinks is a ";
			echo "search engine script. NewPHPLinks is free for download.";
		}
		?>
	</title>
	<link
		rel     =   "stylesheet"
		type    =   "text/css"
		href    =   "themes/<?=$theme?>/<?=$style?>.css"
	/>
</head>

<body bgcolor="white"><?

include("themes/$theme/header.php");
include("themes/$theme/navbar.top.php");

if(isset($term)){
	
	include("include/results.php");
	include("include/related.php");
}

if(isset($show)){
	
	if($show == "new" || $show == "pop" || $show == "cool"){   
		
		include("include/show.php"); 
	} else {     
		
		include("include/$show.php");
	}
}

if(!isset($term) and !isset($show)){
	
	if(!isset($PID)){   
		
		$PID=0;
		include("include/main.cats.php");
	} else {
		
		include("include/line.cat.php");
		include("include/main.cats.php");
		include("include/sites.php");
		include("include/related.php");
	}
}

include("themes/$theme/navbar.bottom.php");
include("themes/$theme/footer.php");

?>

</body>
</html>

