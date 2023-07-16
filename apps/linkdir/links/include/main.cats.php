<?
// *******************************************************************
//  include/main.cats.php
// *******************************************************************

$cnt_array = sql_fetch_array(
	sql_query("
		select
			Count(*) as Total
		from
			$tb_categories
		where
			PID='$PID'
	")
);

$num_rows = $cnt_array[Total];

if($num_rows > 0){


	if($colcount == 1){

		$num_rows % 1  ? $num_rows += 0 : $num_rows;
		$rows = $num_rows / 1;

		$html = $main_table . "<tr>\r\n\t\t\t<td ";
		$html .= "width=\"100%\" valign=\"top\" class=\"maincats\" ";
		$html .= "nowrap=\"nowrap\" align=\"left\">";
		$html .= build_cat("0", $rows, $PID);
		$html .= "\r\n\t\t\t</td>\r\n\t\t</tr>\r\n\t\t</table>\r\n\r\n";

		echo table("100%", "center", "", $html);
	}

	if($colcount == 2){

		$num_rows % 2  ? $num_rows += 1 : $num_rows;
		$rows = $num_rows / 2;

		$html = $main_table . "<tr>\r\n\t\t\t<td ";
		$html .= "width=\"50%\" valign=\"top\" class=\"maincats\" ";
		$html .= "nowrap=\"nowrap\" align=\"left\">";
		$html .= build_cat("0", $rows, $PID);
		$html .= "\r\n\t\t\t</td>\r\n\t\t\t<td width=\"50%\" valign=\"top\" ";
		$html .= "class=\"maincats\" nowrap=\"nowrap\" align=\"left\">";
		$html .= build_cat($rows, $rows, $PID);
		$html .= "\r\n\t\t\t</td>\r\n\t\t</tr>\r\n\t\t</table>\r\n\r\n";

		echo table("100%", "center", "", $html);
	}

	if($colcount == 3){

		$num_rows % 3  ? $num_rows += 1 : $num_rows;
		$num_rows % 3  ? $num_rows += 1 : $num_rows;
		$rows = $num_rows / 3;
		$rows2 = ($rows * 2);

		$html = $main_table . "<tr>\r\n\t\t\t<td ";
		$html .= "width=\"33%\" valign=\"top\" class=\"maincats\" ";
		$html .= "nowrap=\"nowrap\" align=\"left\">";
		$html .= build_cat("0", $rows, $PID);
		$html .= "\r\n\t\t\t</td>\r\n\t\t\t<td width=\"33%\" valign=\"top\" ";
		$html .= "class=\"maincats\" nowrap=\"nowrap\" align=\"left\">";
		$html .= build_cat($rows, $rows, $PID);
		$html .= "\r\n\t\t\t</td>\r\n\t\t\t<td width=\"34%\" valign=\"top\" ";
		$html .= "class=\"maincats\" nowrap=\"nowrap\" align=\"left\">";
		$html .= build_cat($rows2, $rows, $PID);
		$html .= "\r\n\t\t\t</td>\r\n\t\t</tr>\r\n\t\t</table>\r\n\r\n";

		echo table("100%", "center", "", $html);
	}

	if($colcount == 4){

		$num_rows % 4  ? $num_rows += 1 : $num_rows;
		$num_rows % 4  ? $num_rows += 1 : $num_rows;
		$num_rows % 4  ? $num_rows += 1 : $num_rows;

		$rows = $num_rows / 4;
		$rows2 = ($rows * 2);
		$rows3 = ($rows * 3);

		$html = $main_table . "<tr>\r\n\t\t\t<td ";
		$html .= "width=\"25%\" valign=\"top\" class=\"maincats\" ";
		$html .= "nowrap=\"nowrap\" align=\"left\">";
		$html .= build_cat("0", $rows, $PID);
		$html .= "\r\n\t\t\t</td>\r\n\t\t\t<td width=\"25%\" valign=\"top\" ";
		$html .= "class=\"maincats\" nowrap=\"nowrap\" align=\"left\">";
		$html .= build_cat($rows, $rows, $PID);
		$html .= "\r\n\t\t\t</td>\r\n\t\t\t<td width=\"25%\" valign=\"top\" ";
		$html .= "class=\"maincats\" nowrap=\"nowrap\" align=\"left\">";
		$html .= build_cat($rows2, $rows, $PID);
		$html .= "\r\n\t\t\t</td>\r\n\t\t\t<td width=\"25%\" valign=\"top\" ";
		$html .= "class=\"maincats\" nowrap=\"nowrap\" align=\"left\">";
		$html .= build_cat($rows3, $rows, $PID);
		$html .= "\r\n\t\t\t</td>\r\n\t\t</tr>\r\n\t\t</table>\r\n\r\n";

		echo table("100%", "center", "", $html);
	}
}

$fortune = "N";
$html = $table4 . "<tr>\r\n\t\t\t<td ";
$html .= "width=\"100%\" valign=\"top\"";
$html .= " align=\"left\" class=\"fortune\">" . fortune();
$html .= "</td>\r\n\t\t</tr>\r\n\t\t</table>\r\n\r\n";
if($fortune == "Y" && $PID == 0){echo table("98%", "center", "", $html);}

?>
