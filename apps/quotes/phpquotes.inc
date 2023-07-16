<?
// qotd (Quote of the day) function for phpnuke, based on
// software originally by Joe Stump of miester.org.
// adapted for phpnuke 4.x by Erik Sooff (erik@slooff.com)
// adapted for phpWebsite by Seyed Razavi

function quotes() {
	// Create the random id for the quote
	$result = mysql_query("SELECT * FROM phpquotes");
	$num_rows = mysql_num_rows($result);
	
	// only proceed if we have quotes in the database
	if ($result > 0 && $num_rows > 0) {
		srand((double)microtime()*1000000);
		$random = 1;
		if($num_rows > 1)
		{
		    $random = rand(1,$num_rows);
        }
		// Now that we have the random number we can pull out the record
		// also make sure we hit an existing quote
		// if not we do a query again
		$havequote = 0;
		while ($havequote != $random) {
			$myrow = mysql_fetch_array($result);
			// make sure we stop this loop when we do have a quote
			if (is_array($myrow)) {
				$havequote = $havequote + 1;
			}
		}
		
		// this is the start of the content for the qotd block
		$content = '<font size=1><center><i>';

		// add the quote text and remove whitespaces at begin or end
		$content .= trim($myrow[1]);
		$content .= '</i><br>';

		// add the author and then close everything
		$content .= '-- '.stripslashes($myrow[2]).'<br></center></font>';
	} else {
		
		// this is what we say when the quotes database is empty
		$content = 'Sorry, there are no quotes in the database!';
	}
	
// now we build the box somewhere on the side
    return $content;
}
?>
