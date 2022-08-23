<?php
$source = $GET['src'];
$extension = pathinfo($source, PATHINFO_EXTENSION);
	if ($extension == 'jpeg' || $extension == 'jpg')
		$image = imagecreatefromjpeg($source);
	elseif ($extension == 'gif')
		$image = imagecreatefromgif($source);
	elseif ($extension == 'png')
		$image = imagecreatefrompng($source);
	echo imagewebp($image, $destination, $quality);
?>
