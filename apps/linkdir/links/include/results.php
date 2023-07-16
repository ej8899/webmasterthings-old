<?                            
// *******************************************************************
//  include/results.php
// *******************************************************************

if(isset($term) && strlen($term)>0){ 

//////////////////////////////////////////////////////////////////////////////////////////
// PHPLinks XSS Vulnerability Fix - By JeiAr - jeiar@kmfms.com 01-2003 //
/////////////////////////////////////////////////////////////////////////////////////////
//	$ip = $REMOTE_ADDR;
//	$info = $HTTP_USER_AGENT;
//	if (ereg('[-!#$%&\'"*+\\.<->=?^_`{|}]$', $term)) {$err.= "Please enter A 
//	valid Search Term.<BR>";}    
//	if ($err) {									
//	echo $err;
//	echo "<b>Possible Hack Attempt!!</b><br>";
//	echo "<b>$ip</b><br>";
//	echo "<b>$info</b><br>";
//	echo "<a href=index.php>Back</a>";
//	exit;
//	}
///////////////////////////////////////////////////////////////////////////////////////////
	
	if(!isset($sr)){
		$sr=0;
	}

	if($logic == "phrase"){

		$st[0] = $term;

	} else {

		$term = eregi_replace("[-!#$%&\'"*\+.<->=?^_`{|}]$", " ", $term);
		$st = explode(" ", $term);
		$cst = sizeof($st);
		
		if($cst > 1){

			$sterm .= $st[0];
			for($p=1; $p<$cst; $p++){$sterm .= "+" . $st[$p];

		}

	} else {

		$sterm .= $st[0];
	}
}

$i = 0;

while($st[$i]){
	
	if(strlen($st[$i]) > 2){
		$split_term[] = $st[$i];
	} else {
		$removed[] = $st[$i];}
		$i++;
	}

	$i = 0;

	while($split_term[$i]){
		
		if(strlen($split_term[$i]) > 2){
			$new_term .= $split_term[$i]." ";
		}

		$i++;
	}

	$i = 0;

	if(strlen($new_term)>2){
		
		if($ns!=1){
			
			$record_term = sql_query("
				insert into $tb_terms(
					ID,
					Term
				) values (
					'',
					'$new_term'
				)
			");
		}
	}

	while($removed[$i]){

		$removed_term .= $removed[$i];
		if($removed[$i+1])	{$removed_term .= ",";
	}
	
	$i++;
}

$removed_html = stripslashes($new_term);

if($removed_term){

	$removed_html .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(";
	$removed_html .= trim($removed_term).") " . $results_1;
}

if($logic == "or"){

	$sites_sql = "
		select
			$tb_links.ID as site_id,
			$tb_links.SiteName as site_name,
			$tb_links.SiteURL as site_url,
			$tb_categories.Category as category_name,
			$tb_categories.ID as cat_id,
			$tb_links.Added as added,
			$tb_links.LastUpdate as last_update,
			$tb_links.Description as site_description,
			$tb_links.Country as country,
			$tb_links.HitsIn as hits_in,
			$tb_links.HitsOut as hits_out,
			count($tb_reviews.ID) as total_reviews
		from
			$tb_links
		left join
			$tb_categories
		on
			$tb_links.Category=$tb_categories.ID
		left join
			$tb_reviews
		on
			$tb_links.ID=$tb_reviews.SiteID
		where (";
		
		if(isset($search_cat) && $search_cat != 0){
			$sites_sql .= "(";
		}

		$i = 0;

		while($split_term[$i]){

			$sites_sql .= "$tb_links.SiteURL like '%$split_term[$i]%'";

			if($split_term[$i+1]){
				$sites_sql .= " or ";
			}

			$i++;
		}

		$sites_sql .= ") or (";	

		$i = 0;

		while($split_term[$i]){

			$sites_sql .= "$tb_links.Description like '%$split_term[$i]%'";
			
			if($split_term[$i+1]){
				$sites_sql .= " or ";
			}

			$i++;
		}

		$sites_sql .= ") or (";
		$i = 0;

		while($split_term[$i]){
			
			$sites_sql .= "$tb_links.SiteName like '%$split_term[$i]%'";
			
			if($split_term[$i+1]){
				$sites_sql .= " or ";
			}

			$i++;
		}

		$sites_sql .= ") ";

		if(isset($search_cat) && $search_cat != 0){
			$sites_sql .= ") and ($tb_links.Category = '$search_cat') "; 
		}

		$total_sql = $sites_sql . "group by site_id";
		$sites_sql .= "group by site_id limit $sr, $pp";
	
	} else {

		$sites_sql = "
			select
				$tb_links.ID as site_id,
				$tb_links.SiteName as site_name,
				$tb_links.SiteURL as site_url,
				$tb_categories.Category as category_name,
				$tb_categories.ID as cat_id,
				$tb_links.Added as added,
				$tb_links.LastUpdate as last_update,
				$tb_links.Description as site_description,
				$tb_links.HitsIn as hits_in,
				$tb_links.HitsOut as hits_out,
				count($tb_reviews.ID) as total_reviews
			from
				$tb_links
			left join
				$tb_categories
			on
				$tb_links.Category=$tb_categories.ID
			left join
				$tb_reviews
			on
				$tb_links.ID=$tb_reviews.SiteID
			where (";

		$i = 0;

		while($split_term[$i]){

			$sites_sql .= "$tb_links.SiteURL like '%$split_term[$i]%'";
			
			if($split_term[$i+1]){
				$sites_sql .= " and ";
			}

			$i++;
		}

		$sites_sql .= ") or (";
		$i = 0;

		while($split_term[$i]){
			
			$sites_sql .= "$tb_links.Description like '%$split_term[$i]%'";
			
			if($split_term[$i+1]){
				$sites_sql .= " and ";
			}

			$i++;
		}

		$sites_sql .= ") or (";
		$i = 0;

		while($split_term[$i]){

			$sites_sql .= "$tb_links.SiteName like '%$split_term[$i]%'";
			
			if($split_term[$i+1]){
				$sites_sql .= " and ";
			}

			$i++;
		}

		$sites_sql .= ") ";
		$total_sql = $sites_sql . "group by site_id";
		$sites_sql .= "group by site_id limit $sr, $pp";
	}

if(isset($term) && strlen($term)>0){
	
	if($logic == "or"){

		$cats_sql = "
			select
				$tb_categories.ID as category_id,
				$tb_categories.Category as category_name,
				$tb_categories.PID as category_pid
			from
				$tb_categories
			where (";
		
			$i = 0;

			while($split_term[$i]){
				
				$cats_sql .= "$tb_categories.Category like '%$split_term[$i]%'";
				
				if($split_term[$i+1]){
					$cats_sql .= " or ";
				}

				$i++;
			}

			$cats_sql .= ") ";
		
		} else {

			$cats_sql = "
				select
					$tb_categories.Category as category_name,
					$tb_categories.ID as category_id,
					$tb_categories.PID as category_pid
				from
					$tb_categories
				where (";

				$i = 0;

				while($split_term[$i]){
					
					$cats_sql .= "$tb_categories.Category
						like '%$split_term[$i]%'";

					if($split_term[$i+1]){
						$cats_sql .= " and ";
					}

					$i++;
				}

			$cats_sql .= ") ";
		}
	}

	$mtime1 = getmicrotime();
	$site_results = sql_query($sites_sql);
	$cat_results = sql_query($cats_sql);
	$total_results = sql_query($total_sql);
	$total = sql_num_rows($total_results);
	$mtime2 = getmicrotime();
	$search_time = $mtime2 - $mtime1;

	$htmlsrc .= $table2 . "<tr>";
	$htmlsrc .= "\r\n\t<td width=\"100%\" class=\"whatText\">" . $results_2;
	$htmlsrc .= "<font class=\"searchEngines\">" . $removed_html;
	$htmlsrc .= "</font>&nbsp;&nbsp;" . $results_3;
	$htmlsrc .= "<font class=\"searchEngines\">" . substr($search_time, 0, 6);
	$htmlsrc .= "</font>" . $results_4 . "...<br />";
	$htmlsrc .= "</td>\r\n</tr>\r\n</table>\r\n";
	
	echo whattable("100%","center","",$htmlsrc);
	unset($htmlsrc);

	$htmlsrc = $table2 . "<tr><td width=\"100%\" ";
	$htmlsrc .= "class=\"whatText\">" . $results_5 . "</td></tr></table>";;

	echo whattable("100%","center","",$htmlsrc);
	unset($htmlsrc);

	$x=0;

	$htmlsrc =  $table2;
	
	while($x<25){

		$htmlsrc .=  "<tr>";

		$pop_terms = sql_query("
			select
				Term,
				count(*) as Count
			from
				$tb_terms
			group by
				Term
			order by
				Count desc
			limit
				$x,5
		");

		while($pt_rows = sql_fetch_array($pop_terms)){
				
			$htmlsrc .= "<td class=\"searchEngines\">&nbsp;<a class=\"searchEngines\"";
			$htmlsrc .= "href=\"index.php?" . session_name() . "=" . session_id() . "&amp;ns=1&amp;logic=or&amp;maximum=10&amp;term=";
			$htmlsrc .= $pt_rows[Term] . "\">" . $pt_rows[Term] . "</a>(";
			$htmlsrc .= $pt_rows[Count] . ")&nbsp;&nbsp;&nbsp;&nbsp;</td>";
		}

		$htmlsrc .= "</tr>";
		$x=$x+5;
	}

	$htmlsrc .= "</table>";

	echo table("99%","center","",$htmlsrc);
	unset($htmlsrc);

	if($cp<=1){
		echo draw_search_categories($cat_results, $split_term);
	}
	
	echo draw_search_sites($total, $site_results, $split_term);
	
	$htmlsrc = $table2 . "<tr><td class=\"whatText\">" . $results_6 . "</td></tr></table>";

	echo whattable("100%","center","",$htmlsrc);
	unset($htmlsrc);

	$htmlsrc = $table2 . "<tr><td class=\"searchEngineText\">&nbsp;&nbsp;<a class=\"searchEngines\" ";
	$htmlsrc .= "target=\"_blank\" href=\"index.php?" . session_name() . "=";
	$htmlsrc .= session_id() . "&amp;logic=or&amp;maximum=10&amp;term=";
	$htmlsrc .= $sterm . "\">" . $site_title . "</a> - ";

	if($SERVER_NAME != "phplinks.org" && $SERVER_NAME != "dev.phplinks.org"){
		$htmlsrc .= "<a class=\"searchEngines\" href=\"http://phplinks.org/";
		$htmlsrc .= "phplinks/index.php?logic=or&amp;maximum=10&amp;term=" . $sterm;
		$htmlsrc .= "\">phpLinks</a> - ";
	}

	$htmlsrc .= "<a class=\"searchEngines\" target=\"_blank\" ";
	$htmlsrc .= "href=\"http://www.altavista.digital.com/cgi-bin/query?pg=q&what=web&q=";
	$htmlsrc .= $sterm . "\">Alta Vista</a> - <a class=\"searchEngines\"";
	$htmlsrc .= "target=\"_blank\" href=\"http://www.hotbot.com/?MT=" . $sterm;
	$htmlsrc .= "&DU=days&SW=web\">HotBot</a> - <a class=\"searchEngines\" ";
	$htmlsrc .= "target=\"_blank\" href=\"http://www.infoseek.com/Titles?qt=" . $sterm;
	$htmlsrc .= "\">Infoseek</a> - <a class=\"searchEngines\" target=\"_blank\" ";
	$htmlsrc .= "href=\"http://www.dejanews.com/dnquery.xp?QRY=" . $sterm;
	$htmlsrc .= "\">Deja News</a> - <a class=\"searchEngines\" target=\"_blank\" ";
	$htmlsrc .= "href=\"http://www.lycos.com/cgi-bin/pursuit?query=" . $sterm;
	$htmlsrc .= "&maxhits=20\">Lycos</a> - <a class=\"searchEngines\" target=\"_blank\" ";
	$htmlsrc .= "href=\"http://search.yahoo.com/bin/search?p=" . $sterm;
	$htmlsrc .= "\">Yahoo</a></td></tr></table>";

	echo table("99%","center","",$htmlsrc);
	unset($htmlsrc);

} else {

	$htmlsrc = $table2 . "<tr><td class=\"errorText\" align=\"center\"><br /><br />" . $results_7;
	$htmlsrc .= "<br /><br /></td></tr></table>";

	echo table("100%","center","",$htmlsrc);
        unset($htmlsrc);
}

?>

