<?
// *******************************************************************
//  themes/original/tables.php
// *******************************************************************

// These are some generic <table> tags     

// small 
$table0 = "\r\n\t\t<!-- Start Inner Table 0 -->"; 
$table0 .= "\r\n\t\t<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n"; 

// centered small 
$table = "\r\n\t\t<!-- Start Inner Table -->"; 
$table .= "\r\n\t\t<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" "; 
$table .= "align=\"center\">\r\n"; 

// centered full size 
$table2 = "\r\n\t\t<!-- Start Inner Table 2 -->"; 
$table2 .= "\r\n\t\t<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" "; 
$table2 .= "align=\"center\" width=\"100%\">\r\n"; 

// full size 
$table3 = "\r\n\t\t<!-- Start Inner Table 3 -->"; 
$table3 .= "\r\n\t\t<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" "; 
$table3 .= "width=\"100%\">\r\n";

// centered full size 
$table4 = "\r\n\t\t<!-- Start Inner Table 4 -->"; 
$table4 .= "\r\n\t\t<table border=\"0\" cellspacing=\"0\" cellpadding=\"3\" "; 
$table4 .= "align=\"center\" width=\"100%\">\r\n"; 

// main table 
$main_table = "\r\n\t\t<!-- Start Main Categories Table -->"; 
$main_table .= "\r\n\t\t<table border=\"0\" cellspacing=\"0\" cellpadding=\"5\" "; 
$main_table .= "width=\"100%\">\r\n\t\t"; 

// main category wrap table 
$main_cw_table = "\r\n\t\t\t<!-- Start Main Category Wrap Table -->";
$main_cw_table .= "\r\n\t\t\t<table border=\"0\" cellspacing=\"3\" cellpadding=\"0\" ";
$main_cw_table .= "width=\"100%\">\r\n\t\t";

// form table
$form_table = "\r\n\t\t<!-- Start Form Table -->"; 
$form_table .= "\r\n\t\t<table border=\"0\" cellspacing=\"5\" cellpadding=\"0\" "; 
$form_table .= "align=\"center\">\r\n"; 


function table($width, $align, $title, $body){
	
	global $theme;

	if((strlen($title) > 0) || (strlen($body) > 0)){

		$html = "\r\n<!-- Start New Table -->\r\n";
		$html .= "<table border=\"0\" cellspacing=\"2\" cellpadding=\"0\" ";
		$html .= "width=\"" . $width . "\" align=\"" . $align . "\">";

		if(strlen($title) > 0){
			
			$html .= "\r\n<tr>\r\n\t<td width=\"100%\" bgcolor=\"#F4F4F4\">";
			$html .= "\r\n\t<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" ";
			$html .= "width=\"100%\">\r\n\t<tr>\r\n\t\t<td align=\"left\" width=\"100%\" ";
			$html .= "background=\"themes/" . $theme . "/back.gif\" class=\"tabletitle\">" . $title;
			$html .= "\t\t</td>\r\n\t</tr>\r\n\t</table>\r\n\t</td>\r\n</tr>";
		}

		if(strlen($body) > 0){
			
			$html .= "\r\n<tr>\r\n\t<td width=\"100%\" bgcolor=\"#F4F4F4\">";
			$html .= "\r\n\t<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" ";
			$html .= "width=\"100%\" bgcolor=\"#F4F4F4\">\r\n\t<tr>\r\n\t\t<td width=\"100%\" ";
			$html .= "bgcolor=\"white\" class=\"tablebody\">" . $body;
			$html .= "\t\t</td>\r\n\t</tr>\r\n\t</table>\r\n\t</td>\r\n</tr>\r\n";
		}

		$html .= "</table>\r\n<!-- End New Table -->\r\n";
	}

	return $html;
}

function linecattable($width, $align, $title, $body){

	if((strlen($title) > 0) || (strlen($body) > 0)){
	
		$html = "\r\n<!-- Start LineCat Table -->\r\n";
		$html .= "<table border=\"0\" cellspacing=\"2\" cellpadding=\"2\" ";
		$html .= "width=\"" . $width . "\" align=\"" . $align . "\">";

		if(strlen($title) > 0){
			
			$html .= "\r\n<tr>\r\n\t<td width=\"100%\">";
			$html .= "\r\n\t<table border=\"0\" cellpadding=\"1\" cellspacing=\"0\" ";
			$html .= "width=\"100%\">\r\n\t<tr>\r\n\t\t<td width=\"100%\" ";
			$html .= "background=\"themes/" . $theme . "/back.gif\" class=\"linecattitle\">" . $title;
			$html .= "</td>\r\n\t</tr>\r\n</table></td>\r\n</tr>";
		}

		if(strlen($body) > 0){
			
			$html .= "\r\n<tr>\r\n\t<td width=\"100%\">";
			$html .= "\r\n\t<table border=\"0\" cellpadding=\"1\" cellspacing=\"0\" ";
			$html .= "width=\"100%\">\r\n\t<tr>\r\n\t\t<td width=\"100%\" ";
			$html .= "class=\"LineCatOut\">" . $body;
			$html .= "</td>\r\n\t</tr>\r\n\t</table>\r\n\t</td>\r\n</tr>\r\n";
		}

		$html .= "</table>\r\n<!-- End New Table -->\r\n";
	}

	return $html;
}

// this function is for the What's ... table 
function whattable($width, $align, $title, $body){

	if((strlen($title) > 0) || (strlen($body) > 0)){

		$html = "\r\n<!-- Start What Table -->\r\n";
		
		// cellspacing sets distance between prev/next table and left/right margins
		$html .= "<table  border=\"0\" cellspacing=\"2\" cellpadding=\"2\" ";
		$html .= "width=\"" . $width . "\" align=\"" . $align . "\">";

		if(strlen($title) > 0){
			
			$html .= "\r\n<tr>\r\n\t<td width=\"100%\">";
			$html .= "\r\n\t<table border=\"0\" cellpadding=\"1\" cellspacing=\"0\" ";
			$html .= "width=\"100%\">\r\n\t<tr>\r\n\t\t<td width=\"100%\" ";
			$html .= "background=\"themes/" . $theme . "/back.gif\" class=\"whattabletitle\">" . $title;
			$html .= "</td>\r\n\t</tr>\r\n</table></td>\r\n</tr>";
		}

		if(strlen($body) > 0){
			
			$html .= "\r\n<tr>\r\n\t<td width=\"100%\">";
			$html .= "\r\n\t<table border=\"0\" cellpadding=\"1\" cellspacing=\"0\" ";
			$html .= "width=\"100%\">\r\n\t<tr>\r\n\t\t<td width=\"100%\" ";
			$html .= "class=\"WhatTabOut\">" . $body;
			$html .= "</td>\r\n\t</tr>\r\n\t</table>\r\n\t</td>\r\n</tr>\r\n";
		}

		$html .= "</table>\r\n<!-- End New Table -->\r\n";
	}

	return $html;
}

// This table function is for the nav bar ( Page [1] [2] [3]...)
function navtable($width, $align, $title, $body){

	if((strlen($title) > 0) || (strlen($body) > 0)){

		$html = "\r\n<!-- Start Nav Table -->\r\n";

		// celspacing sets distance between prev/next table and left/right margins
		$html .= "<table  border=\"0\" cellspacing=\"2\" cellpadding=\"2\" ";
		$html .= "width=\"" . $width . "\" align=\"" . $align . "\">";

		if(strlen($title) > 0){
			
			$html .= "\r\n<tr>\r\n\t<td width=\"100%\">";
			// cellpadding
			$html .= "\r\n\t<table border=\"0\" cellpadding=\"1\" cellspacing=\"0\" ";
			$html .= "width=\"100%\">\r\n\t<tr>\r\n\t\t<td width=\"100%\" ";
			$html .= "background=\"themes/" . $theme . "/back.gif\" class=\"navtabletitle\">" . $title;
			$html .= "</td>\r\n\t</tr>\r\n</table></td>\r\n</tr>";
		}

		if(strlen($body) > 0){
			
			$html .= "\r\n<tr>\r\n\t<td width=\"100%\">";

			// cellpadding sets thickness of border try 10 for example
			// note we do not use border = x but the background of another table 
			// to set the 'bordercolor' in the stylesheet by changin NavTabOut there
			// cellspacing sets the space duh ! around the table try 10 
			$html .= "\r\n\t<table  border=\"0\" cellpadding=\"1\" cellspacing=\"0\" ";
			$html .= "width=\"100%\" >\r\n\t<tr>\r\n\t\t<td width=\"100%\" ";
			$html .= "class=\"NavTabOut\">" . $body;
			$html .= "</td>\r\n\t</tr>\r\n\t</table>\r\n\t</td>\r\n</tr>\r\n";
		}

		$html .= "</table>\r\n<!-- End Nav Table -->\r\n";
	}

	return $html;
}

// This table function is for the navbar.bottom.php
function navtablebottom($width, $align, $body){

	if(strlen($body) > 0){
			
		$html = "\r\n<!-- Start Nav Bottom Table -->\r\n";
        $html .= "<table  border=\"0\" cellspacing=\"0\" cellpadding=\"0\" ";
        $html .= "width=\"" . $width . "\" align=\"" . $align . "\">";
		$html .= "\r\n<tr>\r\n\t<td width=\"100%\">";
		$html .= "\r\n\t<table  border=\"0\" cellpadding=\"1\" cellspacing=\"4\" ";
		$html .= "width=\"100%\" >\r\n\t<tr>\r\n\t\t<td width=\"100%\" ";
		$html .= "class=\"NavTabOut\">" . $body;
		$html .= "</td>\r\n\t</tr>\r\n\t</table>\r\n\t</td>\r\n</tr>\r\n";
        $html .= "</table>\r\n<!-- End Nav Bottom Table -->\r\n";
	}
	
	return $html;
}

// This table function is for the footer.php
function footertable($width, $align, $body){

	if(strlen($body) > 0){
        
		$html = "\r\n<!-- Start Footer Table -->\r\n";
        $html .= "<table  border=\"0\" cellspacing=\"0\" cellpadding=\"0\" ";
        $html .= "width=\"" . $width . "\" align=\"" . $align . "\">";
		$html .= "\r\n<tr>\r\n\t<td width=\"100%\">";
		$html .= "\r\n\t<table  border=\"0\" cellpadding=\"1\" cellspacing=\"4\" ";
		$html .= "width=\"100%\" >\r\n\t<tr>\r\n\t\t<td width=\"100%\" ";
		$html .= "class=\"footerBot\">" . $body;
		$html .= "</td>\r\n\t</tr>\r\n\t</table>\r\n\t</td>\r\n</tr>\r\n";
        $html .= "</table>\r\n<!-- End Footer Table -->\r\n";
	}
	
	return $html;
}

?>
