<?
// *******************************************************************
//  include/sites.php
// *******************************************************************

if(!isset($sr)){
    $sr=0;
}

$get_sites_count = sql_query("
    select
        ID
    from
        $tb_links
    where
        Category='$PID'
");

$total_sites = sql_num_rows($get_sites_count);

$get_sites = sql_query("
    
	select $tb_links.ID as site_id,
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
	    where
	        $tb_links.Category='$PID'
	    group by
	        site_id
	    order by
	        hits_in desc
	    limit $sr, $pp
");

if($total_sites > 0){
    echo draw_sites($total_sites, $get_sites);
}

?>
