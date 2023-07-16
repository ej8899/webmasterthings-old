<?
// *******************************************************************
//  include/functions.php
// *******************************************************************

if($db = mysql_pconnect($dbhost, $dbuser, $dbpasswd)){
        mysql_select_db($dbname, $db);
} else {
        echo mysql_error();
        exit;
}

function sql_query($sql){
	global $db;
	return @mysql_query($sql, $db);
}

function sql_fetch_array($result){
	return @mysql_fetch_array($result);
}

function sql_num_rows($result){
	return @mysql_num_rows($result);
}

function sql_insert_id(){

	global $db;

	return mysql_insert_id($db);
}

function getLangList ($dirName){

	global $language;

	$d = dir($dirName);

	while($entry = $d->read()){

		if($entry != "." && $entry != ".." && $entry != "CVS"){

                        $entry = eregi_replace(".php", "", $entry);

			echo "<option value=\"" . $entry . "\"";

				if($language == $entry){

					echo " selected=\"selected\"";
				}

			echo ">" . $entry . "</option>\n";
		}
	}

	$d->close();
}

function getDirList ($dirName){

	global $theme;

	$d = dir($dirName);

	while($entry = $d->read()){

		if($entry != "." && $entry != ".." && $entry != "CVS"){

			echo "<option value=\"" . $entry . "\"";

				if($theme == $entry){

					echo " selected=\"selected\"";
				}

			echo ">" . $entry . "</option>\n";
		}
	}

	$d->close();
}

function getFlagList($dirName, $Country){

	$d = dir($dirName);

	while($entry = $d->read()){

		if($entry != "." && $entry != ".." && $entry != "CVS"){

			$short_entry = eregi_replace(".gif", "", $entry);

			$short_entry = eregi_replace("_", " ", $short_entry);

			$html .= "<option value=\"" . $entry . "\"";

				if($Country == $entry){

					$html .= " selected=\"selected\"";
				}

			$html .= ">" . $short_entry . "</option>\n";
		}
	}

	$d->close();

	return $html;
}

function all_children($children, $cat_id){ 

	global $tb_categories, $tb_links; 

	$cat_html = "\t\t\t<tr>\r\n\t\t\t\t<td nowrap=\"nowrap\"> "; 

	$gtc_query = sql_query(" 
		select 
			$tb_categories.Category as cat_name, 
			$tb_categories.ID as cat_id, 
			$tb_categories.AllowSites as allow_sites, 
			count(*) as count 
		from 
			$tb_links 
		left join 
			$tb_categories 
		on 
			$tb_links.Category = $tb_categories.ID 
		where 
			PID='$cat_id' 
		group by 
			cat_id 
		order by 
			count desc 
		limit 
			0, $children 
	"); 

	$have_rows = sql_num_rows($gtc_query); 

	if($have_rows < 1){ 

		$gtc_query = sql_query(" 
			select 
				$tb_categories.Category as cat_name, 
				$tb_categories.ID as cat_id, 
				$tb_categories.AllowSites as allow_sites, 
				count(*) as count 
			from 
				$tb_links 
			left join 
				$tb_categories 
			on 
				$tb_links.Category=$tb_categories.ID 
			where 
				PID='$cat_id' 
			group by 
				cat_id 
			order by 
				count desc 
			limit 
				0, $children 
		"); 
	} 

	while($gtc_array = sql_fetch_array($gtc_query)){ 

		$count = ($gtc_array[count] + 0); 

		$cat_html .= "&nbsp;&nbsp;<a class=\"subCategory\" href=\"index.php?"; 
		$cat_html .= session_name() . "=" . session_id() . "&PID="; 
		$cat_html .= $gtc_array[cat_id] . "\">"; 
		$cat_html .= eregi_replace("_"," ",$gtc_array[cat_name]) . "</a>"; 

		if($gtc_array[allow_sites] == "Y"){ 
			$cat_html .= "<font class=\"subCategoryCount\">("; 
			$cat_html .= $count . ")</font><br>"; 
		} 

		$cat_html .= " "; 
	} 

	$cat_html .= "</td>\r\n\t\t\t</tr>\r\n"; 

	return $cat_html; 
} 

function top_children($children, $cat_id){

	global $tb_categories, $tb_links;

	$cat_html = "\t\t\t<tr>\r\n\t\t\t\t<td nowrap=\"nowrap\">";

	$gtc_query = sql_query("
		select
			$tb_categories.Category as cat_name,
			$tb_categories.ID as cat_id,
			$tb_categories.AllowSites as allow_sites,
			$tb_categories.ShowSiteCount as show_site_count,
			count(*) as count
		from
			$tb_links
		left join
			$tb_categories
		on
			$tb_links.Category = $tb_categories.ID
		where
			PID='$cat_id'
		group by
			cat_id
		order by
			count desc
		limit
			0, $children
	");

	$have_rows = sql_num_rows($gtc_query);

	if($have_rows < 1){

		$gtc_query = sql_query("
			select
				$tb_categories.Category as cat_name,
				$tb_categories.ID as cat_id,
				$tb_categories.AllowSites as allow_sites,
				$tb_categories.ShowSiteCount as show_site_count,
				count(*) as count
			from
				$tb_links
			left join
				$tb_categories
			on
				$tb_links.Category=$tb_categories.ID
			where
				PID='$cat_id'
			group by
				cat_id
			order by
				count desc
			limit
				0, $children
		");
	}

	while($gtc_array = sql_fetch_array($gtc_query)){

		$count = ($gtc_array[count] + 0);

		$cat_html .= "&nbsp;<a class=\"subCategory\" href=\"index.php?";
		$cat_html .= session_name() . "=" . session_id() . "&amp;PID=";
		$cat_html .= $gtc_array[cat_id] . "\">";
		$cat_html .= eregi_replace("_"," ",$gtc_array[cat_name]) . "</a>";

		if($gtc_array[show_site_count] == "Y"){
			$cat_html .= "<span class=\"subCategoryCount\">(";
			$cat_html .= $count . ")</span>";
		}

		$cat_html .= "";
	}

	$cat_html .= "</td>\r\n\t\t\t</tr>\r\n";
	
	return $cat_html;
}

function rand_children($top_children, $cat_id){
	
	global $tb_categories, $tb_links;

	$cat_html = "\t\t\t<tr>\r\n\t\t\t\t<td class=\"subcats\"";
	$cat_html .= "nowrap=\"nowrap\">";

	$gtc_query = sql_query("
		select
			$tb_categories.Category as cat_name,
			$tb_categories.ID as cat_id,
			$tb_categories.AllowSites as allow_sites,
			$tb_categories.ShowSiteCount as show_site_count,
			count($tb_links.ID) as count
		from
			$tb_links
		left join
			$tb_categories
		on
			$tb_categories.ID=$tb_links.Category
		where
			$tb_categories.PID='$cat_id'
		group by
			cat_id
		order by
			rand()
		limit
			0, $top_children
	");

	while($gtc_array = sql_fetch_array($gtc_query)){

		$count = ($gtc_array[count] + 0);

		$cat_html .= "&nbsp;<a class=\"subCategory\" href=\"index.php?";
		$cat_html .= session_name() . "=" . session_id() . "&amp;PID=";
		$cat_html .= $gtc_array[cat_id] . "\">";
		$cat_html .= eregi_replace("_"," ",$gtc_array[cat_name]) . "</a>";

		if($gtc_array[show_site_count] == "Y"){
			$cat_html .= "<span class=\"subCategoryCount\">(" . $count . ")</span>";
		}

	}

	$cat_html .= "</td>\r\n\t\t\t</tr>\r\n";

	return $cat_html;
}

function build_cat($start, $many, $PID){
	
	global $tb_categories, $tb_links, $main_cw_table, $table, $table3, $table0;

	$gc_query = sql_query("
		select
			$tb_categories.ID as cat_id,
			$tb_categories.Category as cat_name,
			$tb_categories.TopChildren as top_children,
			$tb_categories.Children as children,
			$tb_categories.AllowSites as allow_sites,
			$tb_categories.ShowSiteCount as show_site_count,
			$tb_categories.Description as description,
			count($tb_links.ID) as count
		from
			$tb_categories
		left join
			$tb_links
		on
			$tb_categories.ID = $tb_links.Category
		where
			PID='$PID'
		group by
			cat_id
		order by
			cat_name
		limit
			$start, $many
	");

	while($gc_array = sql_fetch_array($gc_query)){

		$count = ($gc_array[count] + 0);

		$cat_html .= $main_cw_table . "\t<tr>\r\n\t\t\t\t<td><a class=\"mainCategory\" ";
		$cat_html .= "href=\"index.php?" . session_name() . "=" . session_id();
		$cat_html .= "&amp;PID=" . $gc_array[cat_id] . "\">";

		$cat_name = eregi_replace("&","&amp;",$gc_array[cat_name]);

		$cat_html .= eregi_replace("_"," ",$cat_name) . "</a>";

		if($gc_array["show_site_count"] == "Y"){

			$cat_html .= "<span class=\"mainCategoryCount\">(";
			$cat_html .= $count . ")</span>";
		}
		
		$cat_html .= "</td>\r\n\t\t\t</tr>\r\n";

		switch($gc_array["children"]){
			case "Top":
				$cat_html .= top_children($gc_array[top_children], $gc_array[cat_id]);
				break;
			case "Rand":
				$cat_html .= rand_children($gc_array[top_children], $gc_array[cat_id]);
				break;
			case "Desc":
				$cat_html .= "\t\t\t<tr>\r\n\t\t\t\t";
				$cat_html .= "<td class=\"subCategory\" nowrap=\"nowrap\">";
				$cat_html .= "&nbsp;" . $gc_array[description];
				$cat_html .= "</td>\r\n\t\t\t</tr>\r\n";
				break;
			case "Vert": 
				$cat_html .= all_children($gc_array[top_children], $gc_array[cat_id]); 
				break; 
			default:
				$cat_html .= "\t\t\t<tr>\r\n\t\t\t\t<td class=\"subCategory\">";
				$cat_html .= "&nbsp;</td>\r\n\t\t\t</tr>\r\n";
		}
		$cat_html .= "\t\t\t</table>\r\n";
	}
	return $cat_html;
}

function drop_cats($selected, $catID, $catName, &$cats){
	global $tb_categories;

	$get_cats = sql_query("
		select
			ID,
			Category,
			PID,
			AllowSites
		from
			$tb_categories
		where
			PID='$catID'
		order by
			Category asc
	");

	while($get_rows = sql_fetch_array($get_cats)){

		if($get_rows[AllowSites] == "Y"){

			$cats .= "<option value=\"" . $get_rows[ID] . "\"";

			if($get_rows[ID] == $selected){

				$cats .= " selected=\"selected\"";
			}

			$cats .= ">" . $catName;
			$cats .= eregi_replace("_"," ",$get_rows[Category]);
			$cats .= "</option>\n";

		}

		$get_rows_plus = $catName . eregi_replace("_"," ",$get_rows[Category]);
		$get_rows_plus .= " >> ";

		drop_cats($selected, $get_rows[ID], $get_rows_plus, $cats);
	}
}

function drop_related_cats($selected, $catID, $catName, &$cats){
	global $tb_categories;

	$get_cats = sql_query("
		select
			ID,
			Category,
			PID
		from
			$tb_categories
		where
			PID='$catID'
		order by
			Category asc
	");

	while($get_rows = sql_fetch_array($get_cats)){

		$cats .= "<option value=\"" . $get_rows[ID] . "\"";

		if($get_rows[ID] == $selected){

			$cats .= " selected";

		}

		$cats .= ">" . eregi_replace("_"," ",$catName);
		$cats .= eregi_replace("_"," ",$get_rows[Category]) ."</option>\n";

		$get_rows_plus = $catName . $get_rows[Category] . " >> ";

		drop_related_cats($selected, $get_rows[ID], $get_rows_plus, $cats);
	}
}

function admin_drop_cats($catID, $catName, &$cats){
	global $tb_categories;

	$get_cats = sql_query("
		select
			ID,
			Category,
			PID,
			AllowSites
		from
			$tb_categories
		where
			PID='$catID'
		order by
			Category asc
	");

	while($get_rows = sql_fetch_array($get_cats)){

		if($get_rows[AllowSites] == "Y"){

			$cats .= "<option value=\"sites_main.php?" . session_name() . "=";
			$cats .= session_id() . "&amp;submit=1&amp;Category=";
			$cats .= $get_rows[ID] . "\">" . $catName;
			$cats .= eregi_replace("_"," ",$get_rows[Category]) ."</option>\n";
		}

		$get_rows_plus = $catName . eregi_replace("_"," ",$get_rows[Category]);
		$get_rows_plus .= " >> ";

		admin_drop_cats($get_rows[ID], $get_rows_plus, $cats);
	}
}

function admin_drop_top_cats($catID, $catName, &$cats){
	global $tb_categories;

	$get_cats = sql_query("
		select
			ID,
			Category,
			PID,
			AllowSites
		from
			$tb_categories
		where
			PID='$catID'
		order by
			Category asc
	");

	while($get_rows = sql_fetch_array($get_cats)){

		$cats .= "<option value=\"categories_main.php?" . session_name() . "=";
		$cats .= session_id() . "&amp;PID=";
		$cats .= $get_rows[ID] . "\">" . $catName;
		$cats .= eregi_replace("_"," ",$get_rows[Category]) ."</option>\n";

		$get_rows_plus = $catName . $get_rows[Category] . " >> ";

		admin_drop_top_cats($get_rows[ID], $get_rows_plus, $cats);
	}
}

function admin_related_cats($catID, $catName, &$cats){
	global $tb_categories;

	$get_cats = sql_query("
		select
			ID,
			Category,
			PID,
			AllowSites
		from
			$tb_categories
		where
			PID='$catID'
		order by
			Category asc
	");

	while($get_rows = sql_fetch_array($get_cats)){

		if($get_rows[AllowSites] == "Y"){

			$cats .= "<option value=\"related_main.php?" . session_name() . "=";
			$cats .= session_id() . "&amp;submit=1&amp;Category=";
			$cats .= $get_rows[ID] . "\">" . eregi_replace("_"," ",$catName);
			$cats .= eregi_replace("_"," ",$get_rows[Category]) ."</option>\n";
		}

		$get_cats_plus = $catName . $get_rows[Category] . " >> ";

		admin_related_cats($get_rows[ID], $get_cats_plus, $cats);
	}
}

function nav_links($nr, $pp, $pnp, $pn, $url){
	global $sr, $functions_1, $functions_2, $functions_3,
		$functions_4, $functions_5, $functions_6;

	if(!isset($pn)){$pn = 1;}

	if($nr > $pp){

		$pnav = $functions_1;
		$tp = $nr / $pp;

		if($tp != intval($tp)){$tp = intval($tp) + 1;}

		$cp = 0;

		while($cp++ < $tp){

			if(($cp < $pn - $pnp or $cp > $pn + $pnp) and $pnp != 0){

				if($cp == 1){

					$pnav .= " <a class=\"navLink\" href=\"" . $url;
					$pnav .= session_name() . "=" . session_id() . "&amp;sr=0&amp;";
					$pnav .= "pp=" . $pp . "&amp;cp=1\">&lt;&lt;" . $functions_2 . "</a> ...";
				}

				if($cp == $tp){

					$pnav .= " ... <a class=\"navLink\" href=\"" . $url;
					$pnav .= session_name() . "=" . session_id() . "&amp;sr=";
					$pnav .= ($tp - 1) * $pp . "&amp;pp=" . $pp . "&amp;cp=";
					$pnav .= $tp . "\">" . $functions_3 . "&gt;&gt;</a>";
				}
			} else {

				if($cp == $pn){
					$pnav .= "<b> [ $cp ]</b>";
				} else {

					$pnav .= "  <a class=\"navLink\" href=\"" . $url . session_name();
					$pnav .= "=" . session_id() . "&amp;sr=" . ($cp - 1) * $pp;
					$pnav .= "&amp;pp=" . $pp . "&amp;cp=" . $cp . "\">[ $cp ]</a> ";
				}
			}
		}
	}

	$pnav .= "&nbsp;&nbsp;..." . $functions_4;
	$pnav .= ($sr + 1)." - ";

	if($nr > ($sr + $pp)){
		$pnav .= $sr + $pp;
	} else {
		$pnav .= $nr;
	}

	$pnav .= $functions_5 . $nr . $functions_6;
	return $pnav;
}

function draw_sites($total_sites, $get_sites){
	
	global $pp, $np, $cp, $PID, $show, $table, $functions_7, $functions_8,
		$functions_9, $functions_10, $functions_11, $functions_12,
		$functions_13, $functions_14, $functions_15, $functions_16,
		$functions_17, $functions_18, $table2, $FormattedDate, $main_table,
		$user_outer_frame;

	if($total_sites > $pp){

	// This draws the What's New|Cool|Pop bar
		if(isset($show)){

			$htmlsrc = $table2 . "<tr>\r\n\t";
			$htmlsrc .= "<td class=\"whatText\">";

			$htmlsrc .= $functions_7;

			switch ($show) {
				case "new":
					$htmlsrc .= $functions_8;
					break;
				case "cool":
					$htmlsrc .= $functions_9;
					break;
				case "pop":
					$htmlsrc .= $functions_10;
					break;
			}

			$htmlsrc .= "</td>\r\n</tr>\r\n</table>\r\n";

			$html = whattable("100%","center","",$htmlsrc);
		}

		$htmlsrc = $table2 . "<tr>\r\n\t";
		$htmlsrc .= "<td class=\"navText\">";

		if(isset($show)){
			$nav_url = "index.php?show=" . $show . "&amp;";
		} else {
			$nav_url = "index.php?PID=" . $PID . "&amp;";
		}

		$htmlsrc .= nav_links($total_sites, $pp, $np, $cp, $nav_url);
		$htmlsrc .= "</td>\r\n</tr>\r\n</table>\r\n";

		$html .= navtable("100%","center","",$htmlsrc);
		$repeathtml = $htmlsrc;

		unset($htmlsrc);
	}

	if(sql_num_rows($get_sites)>0){

		while($sites_array = sql_fetch_array($get_sites)){

			$hr++;
			
			$cell_color = "BgTable1";
			$i % 2 ? 0: $cell_color = "BgTable2";

			$htmlsrc .= $main_table . "<tr>"; 
			$htmlsrc .= "\r\n\t<td class=\"" . $cell_color . "\">"; 
			$htmlsrc .= "<img border=\"1\" src=\"images/flags/" . $sites_array["country"] . "\"";
			$htmlsrc .= " hspace=\"5\" alt=\"";
			
			$short_entry = eregi_replace(".gif", "", $sites_array["country"]);
			$short_entry = eregi_replace("_", " ", $short_entry);

			$htmlsrc .= $short_entry . "\" title=\"" . $short_entry . "\" />";
			$htmlsrc .= "<a class=\"siteName\" href=\"" . "out";
			if($user_outer_frame == "Y"){$htmlsrc .= "_frame";}
			$htmlsrc .= ".php?";
			$htmlsrc .= session_name() . "=" . session_id() . "&amp;ID=";
			$htmlsrc .= $sites_array[site_id] . "\" target=\"_";
			if($user_outer_frame == "Y"){$htmlsrc .= "top";}else{$htmlsrc .= "blank";}
			$htmlsrc .= "\">" . stripslashes($sites_array["site_name"]) . "</a>";
			$htmlsrc .= "&nbsp;&nbsp;&nbsp;<font class=\"siteURL\">";
			$htmlsrc .= $sites_array["site_url"] . "</font>";
			$htmlsrc .= "&nbsp;&nbsp;<a class=\"ownerLink\" ";
			$htmlsrc .= "href=\"index.php?" . session_name() . "=" . session_id();
			$htmlsrc .= "&amp;show=owner&amp;ID=";
			$htmlsrc .= $sites_array["site_id"] . "\">" . $functions_11 . "</a>";
			$htmlsrc .= "&nbsp;&nbsp;<a class=\"reviewLink\" ";
			$htmlsrc .= "href=\"index.php?" . session_name() . "=" . session_id();
			$htmlsrc .= "&amp;show=review&amp;SiteID=";
			$htmlsrc .= $sites_array["site_id"] . "\">" . $functions_12 . "</a>";
			$htmlsrc .= "<font class=\"reviewCount\">(";
			$htmlsrc .= ($sites_array["total_reviews"]+0) . ")</font>";
			$htmlsrc .= "<br /><font class=\"siteDescription\">...";
			$htmlsrc .= stripslashes($sites_array["site_description"]);
			$htmlsrc .= "...</font><br />";
						$htmlsrc .= "<font class=\"addedText\">" . $functions_13;

			ereg("([0-9]{4})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})",
				$sites_array["added"], $regs) . "";

			$htmlsrc .= date($FormattedDate,
						mktime($regs[4], $regs[5], $regs[6],
							$regs[2], $regs[3], $regs[1]));

			$htmlsrc .= "</font>&nbsp;&nbsp;<font class=\"updateText\">";
			$htmlsrc .= $functions_14;

			ereg("([0-9]{4})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})",
				$sites_array[last_update], $regs);

			$htmlsrc .= date($FormattedDate,
						mktime($regs[4], $regs[5], $regs[6],
							$regs[2], $regs[3], $regs[1]));

			$htmlsrc .= "</font>&nbsp;&nbsp;<font class=\"categoryText\">";
			$htmlsrc .= $functions_15 . "</font><a class=\"categoryLink\" ";
			$htmlsrc .= "href=\"index.php?" . session_name() . "=" . session_id();
			$htmlsrc .= "&amp;PID=" . $sites_array[cat_id] . "\">";
			$htmlsrc .= eregi_replace("_"," ",$sites_array[category_name]);
			$htmlsrc .= "</a>&nbsp;&nbsp;<font class=\"hitsInText\">";
			$htmlsrc .= $functions_16 . $sites_array[hits_in] . "</font>";
			$htmlsrc .= "&nbsp;&nbsp;<font class=\"hitsOutText\">" . $functions_17;
			$htmlsrc .= $sites_array[hits_out] . "</font>";
			$htmlsrc .= "</td>\r\n</tr>\r\n</table>\r\n";
			
			$i++;

			$html .= table("99%","center","",$htmlsrc);
			unset($htmlsrc);
		}
	} else {

		$htmlsrc = $table . "<tr>\r\n\t";
		$htmlsrc .= "<td align=\"center\" class=\"navText\"><br />";
		$htmlsrc .= "<td class=\"navText\"><br /><br />";
		$htmlsrc .= $functions_18 . "<br /><br /></td>\r\n</tr>\r\n</table>\r\n";

		$html .= table("100%","center","",$htmlsrc);
        unset($htmlsrc);
	}

	$html .= navtable("100%","center","",$repeathtml);
	unset($repeathtml);

	return $html;
}

function draw_search_sites($total_sites, $get_sites, $split_term){
	
	global $pp, $np, $cp, $PID, $show, $sterm, $logic, $maximum, $table,
		$functions_19, $functions_11, $functions_12, $functions_13,
		$functions_14, $functions_15, $functions_16, $functions_17,
		$functions_20, $table2, $FormattedDate, $functions_22,
		$user_outer_frame;

	if($total_sites > $pp){

		$htmlsrc = $table2 . "<tr>\r\n\t<td ";
		$htmlsrc .= "class=\"whatText\">";

		$nav_url = "index.php?logic=" . $logic . "&amp;maximum=";
		$nav_url .= $maximum . "&amp;term=" . $sterm . "&amp;";

		$htmlsrc .= nav_links($total_sites, $pp, $np, $cp, $nav_url);
		$htmlsrc .= "</td>\r\n</tr>\r\n</table>\r\n";

		$repeathtml = $htmlsrc;

		$html = navtable("100%","center","",$htmlsrc);
		unset($htmlsrc);
	}

	if(sql_num_rows($get_sites)>0){

		$htmlsrc = $table2 . "<tr><td class=\"whatText\">" . $functions_22 . "</td></tr></table>";

		$html .= whattable("100%","center","",$htmlsrc);
		unset($htmlsrc);

		while($sites_array = sql_fetch_array($get_sites)){
	
			$cell_color = "BgTable1";
			$j % 2 ? 0: $cell_color = "BgTable2";

			$htmlsrc .= $main_table . "<tr>\r\n\t<td class=\"" . $cell_color . "\">";
			$htmlsrc .= "<img border=\"1\" src=\"images/flags/" . $sites_array[country] . "\"";
			$htmlsrc .= "hspace=\"5\" alt=\"";

			$short_entry = eregi_replace(".gif", "", $sites_array[country]);
			$short_entry = eregi_replace("_", " ", $short_entry);

			$htmlsrc .= $short_entry . "\" title=\"" . $short_entry . "\">";
			$htmlsrc .= "<a class=\"siteName\" href=\"out";
			if($user_outer_frame == "Y"){$htmlsrc .= "_frame";}
			$htmlsrc .= ".php?" . session_name();
			$htmlsrc .= "=" . session_id() . "&amp;ID=";
			$htmlsrc .= $sites_array[site_id] . "\" target=\"_";
			if($user_outer_frame == "Y"){$htmlsrc .= "top";}else{$htmlsrc .= "blank";}
			$htmlsrc .= "\">" . stripslashes($sites_array[site_name]);
			$htmlsrc .= "</a>&nbsp;&nbsp;&nbsp;";

			$su = "<font class=\"siteURL\">" . $sites_array[site_url];
			$su .= "</font>";

			$i = 0;

			while($split_term[$i]){

				$su_html = eregi_replace("($split_term[$i])","<b>\\1</b>", $su);
				$su = $su_html;

				$i++;
			}

			$htmlsrc .= $su;
			$htmlsrc .= "&nbsp;&nbsp;<a class=\"ownerLink\" ";
			$htmlsrc .= "href=\"index.php?" . session_name() . "=" . session_id();
			$htmlsrc .= "&amp;show=owner&amp;ID=";
			$htmlsrc .= $sites_array[site_id] . "\">" . $functions_11 . "</a>";
			$htmlsrc .= "&nbsp;&nbsp;<a class=\"reviewLink\" ";
			$htmlsrc .= "href=\"index.php?" . session_name() . "=" . session_id();
			$htmlsrc .= "&amp;show=review&amp;SiteID=";
			$htmlsrc .= $sites_array[site_id] . "\">" . $functions_12 . "</a>";
			$htmlsrc .= "<font class=\"reviewCount\">(";
			$htmlsrc .= ($sites_array[total_reviews]+0) . ")</font>";
			$htmlsrc .= "<br />";

			$sd = stripslashes($sites_array[site_description]);

			$i = 0;

			while($split_term[$i]){
				$sd_html = eregi_replace("($split_term[$i])","<b>\\1</b>", $sd);
				$sd = $sd_html;
				$i++;
			}

			$htmlsrc .= "<font class=\"siteDescription\">..." . $sd . "...</font><br />";
			
			$htmlsrc .= "<font class=\"addedText\">" . $functions_13;

			ereg("([0-9]{4})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})",$sites_array[added], $regs);

			$htmlsrc .= date($FormattedDate,mktime($regs[4], $regs[5], $regs[6],$regs[2],$regs[3], $regs[1]));

			$htmlsrc .= "</font>&nbsp;&nbsp;<font class=\"updateText\">";
			$htmlsrc .= $functions_14;

			ereg("([0-9]{4})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})",$sites_array[last_update], $regs);

			$htmlsrc .= date($FormattedDate,mktime($regs[4], $regs[5], $regs[6],$regs[2],$regs[3], $regs[1]));

			$htmlsrc .= "</font>&nbsp;&nbsp;<font class=\"categoryText\">";
			$htmlsrc .= $functions_15 . "</font><a class=\"categoryLink\" ";
			$htmlsrc .= "href=\"index.php?" . session_name() . "=" . session_id();
			$htmlsrc .= "&amp;PID=" . $sites_array[cat_id] . "\">";
			$htmlsrc .= eregi_replace("_", " ", $sites_array[category_name]);
			$htmlsrc .= "</a>&nbsp;&nbsp;<font class=\"hitsInText\">";
			$htmlsrc .= $functions_16 . $sites_array[hits_in] . "</font>";
			$htmlsrc .= "&nbsp;&nbsp;<font class=\"hitsOutText\">" . $functions_17;
			$htmlsrc .= $sites_array[hits_out] . "</font>";
			$htmlsrc .= "</td>\r\n</tr>\r\n</table>\r\n";

			$j++;

			$html .= table("99%","center","",$htmlsrc);
			unset($htmlsrc);
		}

	} else {

		$htmlsrc .= $table2 . "<tr>";
		$htmlsrc .= "\r\n\t<td class=\"navText\" align=\"center\"><br />";
		$htmlsrc .= $functions_20 . "<br /><br /></td>\r\n</tr>\r\n</table>\r\n";
		
		$html .= navtable("100%","center","",$htmlsrc);
        unset($htmlsrc);
	}

	$html .= whattable("100%","center","",$repeathtml);
    unset($repeathtml);

	return $html;
}


function draw_search_categories($get_categories, $split_term){
	
	global $sterm, $table, $table2, $tb_categories, $functions_21;
	
	if(sql_num_rows($get_categories)>0){

		$htmlsrc = $table2 . "<tr>";
		$htmlsrc .= "\r\n\t<td class=\"whatText\">" . $functions_21;
		$htmlsrc .= "</td>\r\n</tr>\r\n</table>";

		$html = whattable("100%","center","",$htmlsrc);
		unset($htmlsrc);

		$htmlsrc = $table2 . "<tr>\r\n\t<td class=\"regularText\">";

		while($cats_array = sql_fetch_array($get_categories)){

			$gcid = $cats_array[category_id];

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

				$pid_array[] = $mlc_array["ID"];

				$gcid = $mlc_array["PID"];
			}

			$count = sizeof($pid_array);

			$cat_html .= "<a class=\"regularText\" href=\"index.php?";
			$cat_html .= session_name() . "=" . session_id() . "&amp;PID=";
			$cat_html .= $pid_array[0] . "\">";

			for($depth=$count; $depth>=0; $depth--){

				if(isset($pid_array[$depth])){

					$build_cat_html .= " >> ";
					$build_cat_html .= ereg_replace("_"," ",
						($cat_array[$depth]));

					$p++;
				}
			}

			$i = 0;

			while($split_term[$i]){

				$bolded_cat_html = eregi_replace("($split_term[$i])",
					"<font class=\"regularBoldText\">\\1</font>",
					$build_cat_html);

				$i++;
			}

			unset($build_cat_html);

			$cat_html .= $bolded_cat_html . "</a>&nbsp;";

			unset($bolded_cat_html);

			if($p == $count){
				$cat_html .= "<br />";
			}

			$htmlsrc .= $cat_html;

			unset($cat_html);
			unset($pid_array);
			unset($cat_array);
			unset($p);
			unset($count);
		}

		$htmlsrc .= "</td>\r\n</tr>\r\n</table>\r\n";

		$html .= table("98%","center","",$htmlsrc);
		unset($htmlsrc);
	}
	return $html;
}

function getmicrotime(){
    list($sec, $usec) = explode(" ", microtime());
	return ($sec + $usec);
}

?>
