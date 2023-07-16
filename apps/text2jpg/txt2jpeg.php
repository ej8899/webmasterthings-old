<?php

function text2image($mytext,$imwidth,$imheight) {
	if (!empty($mytext)) {
		if (empty($imwidth)) $imwidth=500;
		if (empty($imheight)) $imheight=400;
		Header("Content-type: image/Jpeg");
		$im = @ImageCreate ($imwidth=500, $imheight) or die ("Cannot Initialize new GD image stream");
		$background_color = ImageColorAllocate ($im, 255, 255, 255);
		$text_color = ImageColorAllocate ($im, 0, 0, 0);
		$mytext = stripslashes($mytext);
		$mytext = ereg_replace("\r\n","\n",$mytext) ;
		$count=5;
		$returns = explode("\n", $mytext);
		while(list($k, $mytext) = each($returns))	{
			$count = $count;
			$insert_text = substr($mytext, 0);
			ltrim($insert_text);

			// font 2 is smaller but nice, 5 is bigger and nice - 2nd var
			ImageString ($im, 5, 5,$count, $insert_text, $text_color);
			imagerectangle ($im, 2, 2, $imwidth-2, $imheight-2, $text_color);
			$count=$count+13;
		}
		ImageJpeg($im);
		ImageDestroy;
	}
}

text2image($mytext,$imwidth,$imheight);

?>
