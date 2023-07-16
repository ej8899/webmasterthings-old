<?
// *******************************************************************
//  include/line.cat.php
// *******************************************************************

$htmlsrc = $table2 . "<tr><td width=\"100%\" class=\"lineCategoryText\">";
$htmlsrc .= "<a class=\"lineCategoryLink\" href=\"index.php?" . session_name();
$htmlsrc .= "=" . session_id() . "\">" . $line_cat_1 . "</a> ";

unset($gcid);

if(isset($PID)){
	$gcid = $PID;
}

while($gcid > 0){

	$mlc_sql = "select * from $tb_categories where ID = '$gcid'";
	$mlc_query = sql_query($mlc_sql);
	$mlc_array = sql_fetch_array($mlc_query);
	$cat_array[] = $mlc_array["Category"];
	$pid_array[] = $mlc_array["ID"];
	$gcid = $mlc_array["PID"];
}

$count = sizeof($pid_array);

for($depth=$count;$depth>=0;$depth--){	
		
	if($pid_array[$depth]){

		if($PID == $pid_array[$depth]){
				
			$htmlsrc .= ">> ".ereg_replace("_"," ",($cat_array[$depth]));
			$htmlsrc .= "&nbsp;&nbsp;";
			
		} else {
				
			$htmlsrc .= ">> <a class=\"lineCategoryLink\" href=\"index.php?";
			$htmlsrc .= session_name() . "=" . session_id() . "&amp;PID=";
			$htmlsrc .= $pid_array[$depth] . "\">";
			$htmlsrc .= ereg_replace("_"," ",($cat_array[$depth]));
			$htmlsrc .= "</a>&nbsp;&nbsp;";
		}
	}
}

$htmlsrc .= "</td></tr></table>";

echo linecattable("100%","center","",$htmlsrc);
unset($htmlsrc);

?>

