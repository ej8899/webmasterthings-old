<?php

/* file extension + include */
$ext = substr(__FILE__, strrpos(__FILE__, ".") + 1);
require dirname(__FILE__)."/common.$ext";
if(!isset($s_dbname)) {
   exit;
}

/* initialize some stuff */
$url = "${s_dirurl}index.${ext}?dispid=";
$margin = 50;  /* extra left margin until poll list */
$spacer = 120; /* pixels between poll list and actual poll */

/* get list of polls */
symp_connect();
$q1 = "SELECT pid,question,status from wt_sympoll_list WHERE !(status & '$S_VIEW_HIDDEN') ORDER BY timeStamp DESC";
$r1 = mysql_query($q1, $s_dbid);
symp_disconnect();
while($a1 = mysql_fetch_array($r1)) {
   $pl_pid = $a1['pid'];
   if($a1['status'] & $S_VIEW_OPEN) {
      $pl_open[$pl_pid] = htmlspecialchars(stripslashes($a1['question']));
   } else if($a1['status'] & $S_VIEW_CLOSED) {
      $pl_closed[$pl_pid] = htmlspecialchars(stripslashes($a1['question']));
   }
}

/* begin html */
$title = "Sympoll";

include dirname(__FILE__)."/$s_polllist_dir/header.$ext"; ?>

<div align="left">
<table border="0" cellspacing="0" cellpadding="0">
<tr><td width="<?php echo $margin; ?>">&nbsp;</td><td valign="top">

<?php /* display the poll questions in an unordered list */
if(!isset($pl_open) && !isset($pl_closed)) { ?>
  <font<?php echo "$s_txtsize$s_txtface"; ?>>
   &nbsp;&nbsp;&nbsp; <b><?php echo $symp_lang8; ?></b></font><br /><br />
<?php }
if(isset($pl_open)) { ?>
   <font<?php echo "$s_txtsize$s_txtface"; ?>>
   <b>&nbsp;<?php echo $symp_lang5; ?>:</b></font><ul>
   <?php while(list($k,$v) = each($pl_open)) { ?>
      <li><font<?php echo "$s_txtsize$s_txtface"; ?>>
      <a href="<?php echo "$url$k"; ?>"><?php echo $v; ?></a>
      </font></li>
   <?php } ?>
   </ul>
<?php }
if(isset($pl_closed)) { ?>
   <font<?php echo "$s_txtsize$s_txtface"; ?>>
   <b>&nbsp;<?php echo $symp_lang6; ?>:</b></font><ul>
   <?php while(list($k,$v) = each($pl_closed)) { ?>
      <li><font<?php echo "$s_txtsize$s_txtface"; ?>>
      <a href="<?php echo "$url$k"; ?>"><?php echo $v; ?></a>
      </font></li>
   <?php } ?>
   </ul>
<?php }

if($s_refer != "") { ?>
   <br /><font size="1"<?php echo $s_txtface; ?>>
   <?php echo $symp_lang4; ?><i>&nbsp;<?php echo $s_refer; ?></i></font>
<?php } ?>
</td>

<?php if(isset($_GET['dispid']) && $_GET['dispid'] != "") { ?>
   <td width="<?php echo $spacer; ?>">&nbsp;</td>
   <td valign="top" width="<?php echo (((int)$s_width) + 2); ?>"><br />
   <?php /* they picked a poll-- display it */
   require dirname(__FILE__)."/booth.$ext";
   display_booth((int)$_GET['dispid']);
   echo "</td>";
} ?>
</tr></table></div>
<!-- <?php echo $s_version; /* for debugging */ ?> -->
<?php include dirname(__FILE__)."/$s_polllist_dir/footer.$ext"; ?>
