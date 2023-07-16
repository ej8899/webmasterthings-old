<?
// *******************************************************************
//  include/related.php
// *******************************************************************

unset($html);
unset($gcid);
unset($pid_array);
unset($id_array);
unset($cat_array);
unset($count2);
unset($ID);

$query = sql_query("
	select
		*
	from
		$tb_related
	where
		cat_id = '$PID'
");

$count = sql_num_rows($query);

if($count > 0){

	$htmlsrc = "\r\n<!-- Related Categories Start -- include/related.php -->\r\n";
	$htmlsrc .= $table2 . "\r\n<tr>\r\n\t<td class=\"whatText\">";
	$htmlsrc .= $related_1 . "</td>\r\n</tr>\r\n</table>\r\n";

	echo whattable("100%","center","",$htmlsrc);
	unset($htmlsrc);

	$htmlsrc .= $table2 . "\r\n<tr>\r\n\t<td class=\"regularText\">";
	
	while($array = sql_fetch_array($query)){
				
			$gcid = $array["rel_id"];
				
			while($gcid > 0){

				$mlc_sql = "
					select
						*
					from
						$tb_categories
					where
						ID = '$gcid'
				";

				$mlc_query = sql_query($mlc_sql);
				$mlc_array = sql_fetch_array($mlc_query);
		
				$cat_array[] = $mlc_array["Category"];
				$pid_array[] = $mlc_array["PID"];
				$id_array[] = $mlc_array["ID"];
		
				$gcid = $mlc_array["PID"];
			}
				
			$count2 = sizeof($pid_array);
		
			$htmlsrc .= "<a class=\"regularText\" href=\"index.php?";
			$htmlsrc .= session_name() . "=" . session_id() . "&amp;PID=";
			$htmlsrc .= $id_array[0] . "\">";
			
			for($depth = $count2; $depth >= 0; $depth--){
			
				if(isset($pid_array[$depth])){
					$html .= " >> ";
					$html .= ereg_replace("_", " ", $cat_array[$depth]);
					$html .= " ";
				}

			}
			
			$htmlsrc .= trim($html);
			$htmlsrc .= "</a><br />";
		
		unset($html);
		unset($gcid);
		unset($pid_array);
		unset($id_array);
		unset($cat_array);
		unset($count2);
		unset($ID);
	}
	
	$htmlsrc .= "</td>\r\n</tr>\r\n</table>\r\n";
}

echo table("99%","center","",$htmlsrc);
unset($htmlsrc);

?>
