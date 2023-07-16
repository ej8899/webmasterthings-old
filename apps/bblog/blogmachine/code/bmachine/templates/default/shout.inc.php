<?php

// Print the ShoutBox' posting form
if(isset($_GET['action']) && $_GET['action']=="add") {

?>

<html>
<head>
<title>Shout Box</title>
<style type="text/css">
<!--
body,html,p,td { font-family:Verdana; font-size: 9px; }
a { color:rgb(204,0,0); }
input,textarea { font-size: 9px; font-family: Verdana; color:rgb(0,0,0); border-width:1; border-color:rgb(102,102,102); border-style:solid; }
//-->
</style>
</head>

<body>

<script type="text/javascript">
<!--
	function chkPost() {
		if(!document.shout.name.value || !document.shout.name.value || !document.shout.msg.value) {
			alert("Empty fields!"); return false;
		}
		document.shout.submit();
	}
//-->
</script>
<form name="shout" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
<input type="hidden" name="action" value="save" />

<?php echo $lang['user_name']; ?><br />
<input type="text" name="name" /><br />

<?php echo $lang['user_email']; ?><br />
<input type="text" name="email" /><br />

<?php echo $lang['comments']; ?><br />
<textarea name="msg" rows="6" cols="17"></textarea><br />
<input type="button" value="<?php echo $lang['admin_sett_save_but']; ?>" onClick="chkPost()" />

</form>
</body>
</html>

<?php
exit;
}

?>
<html>
<head>
<title>Shout Box</title>
<style type="text/css">
<!--
body,html,p,td { font-family:Verdana; font-size: 9px; }
a { color:rgb(204,0,0); }
input,textarea { color:rgb(250,250,250); border-width:1; border-color:rgb(102,102,102); border-style:solid; }
.entry { line-height: 15px; }
//-->
</style>

</head>

<body>

<?php

for($n=0;$n<=count($posts['name']);$n++) {

	$name=bmc_blockWords($posts['name'][$n]); // Filter bad words
	$email=str_replace("@","&#064;", $posts['email'][$n]);
	$msg=bmc_blockWords($posts['msg'][$n]); // Filter bad words
	$ip=$posts['ip'][$n];

	if(!empty($name)) {
		if($smile) { $msg=bmc_Smilify($msg); }

echo <<<EOF
<div class="entry">
<!-- $ip //-->
<a href="mailto:$email" >$name</a> : $msg<br />
</div>

EOF;

	}
}

?>

</body></html>