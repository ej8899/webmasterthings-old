<?php

/*
  ===========================

  boastMachine v3.0 Platinum
  Released : Sunday, October 17th 2004 ( 10/17/2004 )
  http://boastology.com

  Developed by Kailash Nadh
  Email   : kailash@bnsoft.net
  Website : www.kailashnadh.name
			www.bnsoft.net

  boastMachine is a free software and is licensed under GPL (General public license)

  ===========================
*/


	if(!defined('IN_BMC')) {
		die("Access Denied!");
	}

// GENERAL/COMMON FUNCTIONS

include_once CFG_ROOT."/inc/core/show.inc.php";


// ====================
// The Template function. Manages all the header,footer pages

function bmc_Template($query=null,$title="",$desc="",$page_menu=false) {
global $db, $lang, $bmc_vars, $i_blog;

	if(!$query) { return; }

	if(!defined('CFG_THEME')) {
		// If for any reason, no template was loaded, load the default system template
		define("CFG_THEME",bmc_getVar("theme"));
	}

	if(!defined('BLOG') && isset($_REQUEST['blog']) && is_numeric($_REQUEST['blog'])) {
		// If for any reason, no template was loaded, load the default system template

			if(!empty($i_blog['id'])) {
				define("BLOG",$_REQUEST['blog']);
			}
	}

	switch($query) {
		case 'admin_header':
		include_once CFG_PARENT."/templates/admin/admin.header.php";
		break;

		case 'admin_footer':
		include_once CFG_PARENT."/templates/admin/admin.footer.php";
		break;

		case 'page_header':
		$keys=$desc;
		include_once CFG_PARENT."/templates/".CFG_THEME."/header.php";
		break;

		case 'page_footer':
		include_once CFG_PARENT."/templates/".CFG_THEME."/footer.php";
		break;

		case 'error_admin':
		include_once CFG_PARENT."/templates/admin/admin.header.php";
		include_once CFG_PARENT."/templates/".CFG_THEME."/error.inc.php";
		include_once CFG_PARENT."/templates/admin/admin.footer.php";
		exit;
		break;

		case 'error_page':
		include_once CFG_PARENT."/templates/".CFG_THEME."/header.php";
		include_once CFG_PARENT."/templates/".CFG_THEME."/error.inc.php";
		include_once CFG_PARENT."/templates/".CFG_THEME."/footer.php";
		exit;
		break;

	}

}

// ====================
// User's login status
function bmc_isLogged() {
global $db;

	if(isset($_COOKIE['BMC_user']) && isset($_COOKIE['BMC_user_password'])) {
		$user=$_COOKIE['BMC_user'];
		$pass=$_COOKIE['BMC_user_password'];

	$result=$db->query("SELECT user_pass,level FROM ".MY_PRF."users WHERE user_login='{$user}'", false);

		if($pass == $result['user_pass']) {
			if($result['level'] == "4") {
				// The universal constant for an admin
				if(!defined('IS_ADMIN')) define("IS_ADMIN", true);
			} else {
				if(!defined('IS_ADMIN')) define("IS_ADMIN", false);
			}
			return $user; // The user is logged in
		}
	}
	else {
		return false;
	} // Not logged in

}


// ====================
// Global function to get the settings from DB

function bmc_getVar($var=null) {
	global $db;
	if(!$db) { $db=new bDb; }

	$result = $db->query( "SELECT v_val FROM ".MY_PRF."vars WHERE v_name='$var'", false);

	return $result['v_val'];
}


function bmc_setVar($var,$val) {
	global $db;
	if(!$db) { $db=new bDb; }
	$db->query( "UPDATE ".MY_PRF."vars SET v_val='$val' WHERE v_name='$var'" );
}

// Get the boastMachine setting variable
function bmc_getSets() {
	global $db;
	if(!$db) { $db=new bDb; }
	return $db->query( "SELECT v_name, v_val FROM ".MY_PRF."vars" );

}

// ====================
// Smilify a given string :)

// Go through the smilies array and replace with appropriate <img /> tags
function bmc_smilify($str) {
	global $bmc_vars;
	$smiles=bmc_getSmileFiles();

	for($n=0;$n<count($smiles);$n++) {
		$name=explode(".", $smiles[$n]);
		$name=$name[0]; $name=strtolower($name);

			$str=str_replace(":$name:","<img src=\"{$bmc_vars['c_urls']}/smilies/{$smiles[$n]}\" alt=\"$name\" />",$str);
	}


// ====================
// CONVERT PREDEFINED SMILEY SYMBOLS
// Open the smilies data file for parsing
$sm=fread(fopen(CFG_PARENT."/smilies/smiles.pak", "r"), 100000);
$sm=explode("\n",$sm);

	for($i=0;$i<count($sm);$i++) {

		if(trim($sm[$i])) {
		list($file, $smil) = explode("=", $sm[$i]);
		$file=trim($file); $smil=trim($smil);

			if(trim($smil)) {
			$str=str_replace($smil, "<img src=\"".$bmc_vars['c_urls']."/smilies/$file\" alt=\"$smil\" />",$str);
			}
		}
	}


return $str;
}


// ====================
// Auto Convert URLs & Emails
function bmc_cnvAll($text) {
	$text = " ".$text;
	$text = preg_replace("#(^|[\n ])([\w]+?://[^ \"\n\r\t<]*)#is", "\\1<a href=\"\\2\" target=\"_blank\">\\2</a>", $text);
	$text = preg_replace("#(^|[\n ])((www|ftp)\.[^ \"\t\n\r<]*)#is", "\\1<a href=\"http://\\2\" target=\"_blank\">\\2</a>", $text);
	$text = preg_replace("#(^|[\n ])([a-z0-9&\-_.]+?)@([\w\-]+\.([\w\-\.]+\.)*[\w]+)#i", "\\1<a href=\"mailto:\\2@\\3\">\\2@\\3</a>", $text);
	return substr($text, 1);
}


// ====================
// Send Pings

function bmc_ping() {
global $bmc_vars;

	// Pinging is disabled
	if(!$bmc_vars['send_ping']) {
		return false;
	}


	// Your blog name and url
 	$name = bmc_htmlentities(BLOG_NAME);
	$url  = bmc_htmlentities($bmc_vars['c_urls']."/".BLOG_FILE);


	// The ping hosts list
	$ping_list=explode("\n",$bmc_vars['ping_urls']);

	if(!$ping_list) return false;

// The XML request to be sent
$xml_data=<<<EOF
<?xml version="1.0" ?>
<methodCall>
<methodName>weblogUpdates.ping</methodName>
	<params>
		<param>
			<value>
				<string>{$name}</string>
			</value>
		</param>
		<param>
			<value>
				<string>{$url}</string>
			</value>
		</param>
	</params>
</methodCall>
EOF;

	$len=strlen($xml_data); // The total bytes in the data

	// Loop through the hosts and send each one a ping
	for($n=0;$n<count($ping_list);$n++) {

		// Get the host url, parse it and take out the domain and the path
		$the_host=$ping_list[$n];
		$the_host=str_replace("http://","",$the_host);
		$the_host=str_replace("https://","",$the_host);

		$the_host=explode("/",$the_host);

		$host=trim($the_host[0]); // The host domain name
		unset($the_host[0]);
		$path="/".trim(implode("/",$the_host)); // The path

		if(!empty($path) && !empty($host)) {
			$fp = @fsockopen($host, 80, $errnum, $errstr); // Send the ping
				if($fp) { 
					fputs($fp,"POST $path HTTP/1.0\r\n");
					fputs($fp,"User-Agent: boastMachine ".BMC_VERSION."\r\n");
					fputs($fp,"Content-Type: text/xml\r\n");
					fputs($fp,"Content-length: $len\r\n\r\n");
					fputs($fp,$xml_data);
					fclose($fp);
				}
		} // end if
	} // end for

}


// ====================
// Date conversion from Timestamp [total seconds] to readable one

function bmcDate($input=false,$format=false) {
global $bmc_vars;

	if(!$input) { $input=time(); }

	if(!$format) {
		return date($bmc_vars['date_str'], $input);
	} else {
		return date($bmc_vars['date_str'], $format);
	}
}

// ====================
// The function to do redirection
function bmc_Go($goto="index.php") {

	$goto=str_replace("Location: ","",$goto);

	// Fix for IIS servers+cookies

	if(strpos(strtolower($_SERVER['SERVER_SOFTWARE']), strtolower("Microsoft-IIS")) ) {
		$str="Refresh: 0; URL={$goto}";
	} else {
		$str="Location: $goto";
	}


// if header() fails, use a javascript redirection
if(!@header($str)) {

echo <<<EOF
<HTML><HEAD><TITLE>Redirecting..</TITLE></HEAD><BODY>
<script type="text/javascript">
<!--
	document.location="$goto";
//-->
</script>
</BODY></HTML>
EOF;
}

exit();

}

// ====================
// Get theme directory list
function bmc_getThemeList() {

// Read all the directories in the template folder
	$handle = opendir(CFG_PARENT."/templates");
	$i=0; $j=0;

while($filename = readdir($handle)) 
{
	if($filename != "." && $filename != ".." && trim($filename)) { 

		if(is_dir(CFG_PARENT."/templates/".$filename) && @include(CFG_PARENT."/templates/".$filename."/theme.info.php")) {
			$files['id'][$j]=$filename; // Theme's directory name
			$files['name'][$j]=$theme_name; // Theme's name
			$j=$j+1;
		}

	}
}
	closedir($handle);

return $files;
}


// Delete a directory and its contents. Used for theme deletion
// ====================
function bmc_remDir($dir){
   $current_dir = opendir($dir);
   while($entryname = readdir($current_dir)){
     if(is_dir("$dir/$entryname") and ($entryname != "." and $entryname!="..")){
         deldir("${dir}/${entryname}");
     }elseif($entryname != "." and $entryname!=".."){
         @unlink("${dir}/${entryname}");
     }
   }
   closedir($current_dir);
   @rmdir(${dir});
}

// ====================
// Bad word filter, takes a string, replaces all bad words with *
// example: Apple => *****   , ODD => ***

function bmc_blockWords($str) {
if(!$str) return;
$bad=bmc_getVar("words");

$bad=str_replace("\n",",",$bad);
$bad=explode(",",$bad);

if(!count($bad)) { return; }

	for($n=0;$n<=count($bad)-1;$n++) {

		$symbol="";
		for($k=0;$k<=strlen(trim($bad[$n]))-1;$k++) {
		$symbol.="*";
		}
	if(!empty($bad[$n])) { $str = eregi_replace(trim($bad[$n]),$symbol,$str); }
	}

return $str;
}

function replacestring($search,$replace,$subject) {
    $srchlen=strlen($search);    // lenght of searched string

    while ($find = stristr($subject,$search)) { // find $search text in $subject - case insensitive
        $srchtxt = substr($find,0,$srchlen); // get new search text
        $subject = str_replace($srchtxt,$replace,$subject); // replace founded case insensitive search text with $replace
    }
    return $subject;
} 


// ====================
// Ban an IP!

function bmc_chkIP() {
	global $lang,$db;

	$user_ip=$_SERVER['REMOTE_ADDR'];
	if(!$user_ip) { return true; }

	$ipdat = bmc_getVar("ips");

	if(empty($ipdat)) return true;

	$ipdat=explode("||",$ipdat);


	for($n=0;$n<count($ipdat);$n++) {
		if(trim($ipdat[$n])) {
			$ip=str_replace(".","\\.",$ipdat[$n]);

			if (preg_match("/^{$ip}/", $user_ip)) { 
				bmc_Template('error_page', $lang['banned']);
			}
		}
	}
}

// ====================
// Load the Shout Box

function bmc_ShoutBox() {
	include CFG_ROOT."/shout.php";
}

// ====================
// Get Smilies from a directory

function bmc_getSmiles($form='msg') {
	global $bmc_vars;

	$row=5; // Number of rows in the smiley table
echo <<<EOF
<table border="0" cellpadding="2" cellspacing="0" width="50">

EOF;

	$files = array();
	$files = bmc_getSmileFiles(); // Get the smilie filenames

	// Print the neatly formatted Table
	$count=count($files); 
	$i=0; 

	foreach($files as $smilie) {
     // make a new if the remainder of $i divided by $row == 0 
     if($i % $row == 0) 
     { 
          echo "<tr>\n"; 
     }             

	$name=explode(".",$smilie);
	$name=$name['0']; $name=strtolower($name);

$code=<<<EOF
<a href="javascript:smil('$form',':$name:');"><img alt=":$name:" src="{$bmc_vars['c_urls']}/smilies/$smilie" /></a>
EOF;

     echo "	<td>$code</td>\n"; 
             
     // add an extra <td></td> if there are not enough columns to complete the table 

     if($i == ($count - 1)) 
     { 
          // keep adding blank cells till it's at the end 
          while(($i + 1) % $row != 0) 
          { 
               echo "\t\t<td>&nbsp;</td>\n"; 
               $i++; 
          }                 
     }             
             
     if(($i + 1) % $row == 0) 
     {                 
          echo "</tr>\n\n"; 
     } 
         
     $i++; 
} 



echo "</table>";
}


// ====================
// Get smilie filenames

function bmc_getSmileFiles() {

$smilies_dir="smilies"; // Smilies directory

// Valid smiley extensions
$exts['gif']=true;
$exts['jpg']=true;
$exts['jpeg']=true;
$exts['png']=true;
$exts['art']=true;
$exts['bmp']=true;
$exts['tif']=true;
$exts['tiff']=true;

$files=array();

// Read all the files in the DATA folder
	$handle = opendir(CFG_PARENT."/smilies");
	$i=0;

while($filename = readdir($handle)) 
{

$ext=explode(".",$filename);
$ext=$ext[count($ext)-1]; $ext=strtolower($ext);

	if($filename != "." && $filename != ".." && isset($exts[$ext])) {
	$files[$i]=trim($filename);
	$i++;
	} 

} 
	closedir($handle);

return $files;
}


// ====================
//Slash manipulation

// Adds slashes if the magic quotes is off.

// This function takes out slashes if the magic quotes are on.
function noSlash($string)
{
   if (is_slashed($string))
   $string = stripslashes($string);
   return $string;
}

// Check whether a string is slashed or not
function is_slashed($data) {
   if(stripslashes($data) == $data) {
       return 0;
   } else {
       return 1;
   }
}

// ====================
// Emulate the magic quotes

function add_magic_quotes($input) {

$array=array();

	foreach ($input as $key => $value) {
		if (is_array($value)) {
			$array[$key] = add_magic_quotes($value);
		} else {
			$array[$key] = addslashes($value);
		}
	}

	return $array;
}


// ====================
// Get various counts

function bmc_getCount($blog=null,$post=null) {
	global $db;

	$num=array();
	if(!empty($blog)) { $blog_where="WHERE blog='$blog'"; } else { $blog_where=null; }
	if(!empty($post)) { $post_where="WHERE post='$post'"; } else { $post_where=null; }

		// Posts count
		$num['posts']=(!$n=$db->row_count("select id from ".MY_PRF."posts $blog_where")) ? '0' : $n;

		// Comments count
		$num['comments']=(!$n=$db->row_count("select id from ".MY_PRF."comments $blog_where")) ? '0' : $n;

		// Users count
		$num['users']=(!$n=$db->row_count("select id from ".MY_PRF."users")) ? '0' : $n;

		// Categories count
		$num['cats']=(!$n=$db->row_count("select id from ".MY_PRF."cats $blog_where")) ? '0' : $n;

		// Blog count
		$num['blogs']=(!$n=$db->row_count("select id from ".MY_PRF."blogs")) ? '0' : $n;

	return $num;

}


// ==================== Get a user's display name

function bmc_dispUser($id=null) {
global $db;

if(!$id) { return false; }

		$auth=$db->query("SELECT user_name,user_login,user_nick,user_showid FROM ".MY_PRF."users WHERE id='{$id}'", false);
		switch($auth['user_showid']) {
			case 'user_name':
			$user_name=$auth['user_name'];
			break;

			case 'user_login':
			$user_name=$auth['user_login'];
			break;

			case 'user_nick':
			$user_name=$auth['user_nick'];
			break;

			case 'default':
			$user_name=$auth['user_login'];
			break;
		}

return $user_name;

}

// ==================== Update the Categories/Archives/User List/Blog list cache
function bmc_updateCache($what=null) {
global $db;

	if(!$what) { return; }

	$file=null;

	switch($what) {

		// Update the category list cache
		case 'cats':
			$file="cats.dat";
			$data=$db->query("SELECT cat_name,id,blog FROM ".MY_PRF."cats ORDER BY cat_name");
		break;



		// Update the blog list
		case 'blogs':
			$file="blogs.dat";
			$data=$db->query("SELECT blog_name,blog_file,id FROM ".MY_PRF."blogs WHERE frozen='0' ORDER by blog_date DESC");
		break;



		// Update the archive list
		case 'archive':
			$file="archive.dat";
			$result=$db->query("SELECT date,blog FROM ".MY_PRF."posts WHERE status='1' ORDER by date DESC");
			// Get the full date list

			$i=0;
			for($n=0;$n<count($result);$n++) {

				$arch_date=date("mY",$result[$n]['date']);

				if($arch_date != $temp) { // Keep adding the dates to an array while eliminating the duplicates
					$data[$result[$n]['blog']][]=$result[$n]['date'];
					$i=$i+1;
				}

				$temp=$arch_date;
			}

		break;

	}


	if(!$file) { return false; }

	// Write the cache
	$fp=fopen(CFG_ROOT."/inc/vars/cache/".$file, "w+");
	fputs($fp, serialize($data));
	fclose($fp);

return true;

}


// ===================== Safe word wrapping. Doesn't touch HTML tages :) ========

function bmc_wordwrap($str, $cols=null, $cut="\n") {
global $bmc_vars;

	if(!$cols) {
		$cols=$bmc_vars['c_wrap'];
	}

	$len = strlen($str);
	$tag = 0;
	$wordlen=0;
	$result=null;

	for ($i = 0; $i < $len; $i++) {
		$chr = $str[$i];
		if ($chr == '<' || $chr == '&') {
			$tag++;
		} elseif ($chr == '>' || $chr == ';') {
			$tag--;
		} elseif ((!$tag) && (ctype_space($chr))) {
			$wordlen = 0;
		} elseif (!$tag) {
			$wordlen++;
		}

		if ((!$tag) && ($wordlen) && (!($wordlen % $cols))) {
			$chr .= $cut;
		}

		$result .= $chr;
	}
	return $result;
}


// ======================= A modded htmlentities() function ==============
// used to process Chinese and other such special characters
function bmc_htmlentities($text) {
//	$text=htmlentities($text);
	$text=htmlspecialchars($text);
	return preg_replace("/\&amp\;\#(0-9)*/is", '&#$1', $text);
}

?>