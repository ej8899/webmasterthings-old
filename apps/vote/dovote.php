<?php

/* file extension + includes */
$ext = substr(__FILE__, strrpos(__FILE__, ".") + 1);
require dirname(__FILE__)."/common.$ext";

/* basic sanity check */
if(!isset($pid) || !isset($ref)) {
   die("an unexpeted error has occured.");
}
$p = symp_poll_fetch($pid);

/* something's fishy.  just show results */
if($p['voted'] != -1 || !($p['status'] & $S_VIEW_OPEN) || !isset($cid) ||
      ($p['status'] & $S_TYPE_CHECK && (!is_array($cid) || sizeof($cid) < 1))) {
   header("Location: $ref"); 
   exit();
}

/* prep stuff depending on form type */
if($p['status'] & $S_TYPE_RADIO) {
   $cid = (int)$cid;
   $meat = "cid='$cid'";
} else if($p['status'] & $S_TYPE_CHECK) {
   $cookstr = ";";
   $meat = "(";
   while(is_array($cid) && list($k,$v) = each($cid)) {
      if($v == 'poof') {
         if(!isset($sly)) {
            $sly = (int)$k;
         } else {
            $cookstr .= "$sly".";";
            $meat .= "cid='$sly' OR ";
            $sly = (int)$k;
         }
      }
   }
   if(!isset($sly)) {
      header("Location: $ref"); 
      exit();
   }
   $cid = "$cookstr"."$sly".";";
   $meat .= "cid='$sly')";
}

$now = time();
symp_connect();
/* log ip if ip logging is enabled */
if($s_iplog != "0") {
   $q1  = "INSERT INTO wt_sympoll_iplog (vid,pid,voted) ";
   $q1 .= "VALUES('$SYMP_REMOTE_ADDR', '$p[pid]', '$now')";
   $r1 = mysql_query($q1, $s_dbid);
}

/* give cookie if cookie logging is enabled and tally vote */
if($s_cookielog != "0") {
   $sex = time() + ($s_blength * 86400); /* get it?  sex?  a pun off of secs? ha! */
   $sympvotes["symp$p[cstamp]"] = $cid;
   $data = serialize($sympvotes);
   setcookie("sympvotes", "$data", $sex, "/");
   $q2  = "UPDATE wt_sympoll_data SET votes=votes+1 WHERE (pid='$p[pid]' AND $meat)";
   $r2 = mysql_query($q2, $s_dbid);
   symp_disconnect();
   symp_redir("$ref");
} else {
   $q3  = "UPDATE wt_sympoll_data SET votes=votes+1 WHERE (pid='$p[pid]' AND $meat)";
   $r3 = mysql_query($q3, $s_dbid);
   symp_disconnect();
   header("Location: $ref");
}

?>
