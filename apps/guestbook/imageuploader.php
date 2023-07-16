<?php	require("fileupload.class");
		$PATH = "./userphotos/";
		$FILENAME = "picture1url";
		$EXTENSION = ".jpg";
		$SAVE_MODE = 2;
		$upload = new uploader;
		$upload->max_filesize(600000);
		if($upload->upload("$FILENAME", "$ACCEPT", "$EXTENSION"))
		{
			if($upload->save_file("$PATH", $SAVE_MODE))
			{
//				echo "<font face=helvetica size=2>Your photo has been uploaded to our system and saved.<BR><BR>";

// see PHP image files - resample to 700 pixels wide at maximum
// set JPG quality to 72 & resave over top of file

 	$size = GetImageSize($upload->new_file); 
 	$width = $size[0];  $height = $size[1];  $type = $size[2]; 
	if($width>400)	// resample the image if too large
	{
		$scale=400/$width; // 400 is new width
 		$newwidth = round($width*$scale);
 		$newheight = round($height*$scale);
     	$src = imagecreatefromjpeg("$upload->new_file"); 
     	$im = imagecreatetruecolor($newwidth,$newheight); 
     	imagecopyresampled($im,$src,0,0,0,0,$newwidth,$newheight,$width,$height); 
		unlink($upload->new_file);	// remove old file
     	imagejpeg($im,$upload->new_file,72);  // 72 is new quality level save as same file
     	imagedestroy($im); 		
	}
		}
			else
			{
				echo "Error x38 in upload - please notify webmaster@webmasterthings.com if you need assistance.";
			}
		}
		else
		{
			// no photo is 'required' so no sense in reporting an error
			// echo "first error<BR>filename: $upload->new_file($picture1url)";
		}
		if($upload->errors) 
		{
			while(list($key, $var) = each($upload->errors))
			{
				if($var!='No file was uploaded')
					{
						echo "<p>" . $var . "<br>";
					}
			}
		}
		
		// filename uploaded and saved is at $upload->new_file

		$newfilename=$upload->new_file;
?>