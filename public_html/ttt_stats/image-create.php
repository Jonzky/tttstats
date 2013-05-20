<?PHP
/*------------------------\
|        TTT STATS        |
|          Beta           |
|=========================|
|© 2013 SNGaming.org      |
|   All Rights Reserved   |
|=========================|
|   Website printout      |
|      beta testing       |
|      by Handy_man       |
\------------------------*/			

header('Content-type: image/jpeg');

$text = 'tesing123';
$test_length = strlen($text);

$font_size = 4;

$image_height = ImageFontHeight($font_size);
$image_width = ImageFontWidth($font_size) * $test_length;

	$image = imagecreate($image_width, $image_height);
	
imagecolorallocate($image, 255, 255, 255);
$font_color = imagecolorallocate($image, 0,0,0);
	
	
imagestring($image, $font_size, 0, 0, $text, $font_color);

imagejpeg($image);
	
?>