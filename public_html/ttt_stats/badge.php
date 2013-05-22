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
include("./includes/config.php");
header('Content-type: image/png');

/**
$id_source = imagecreatefrompng('./static/images/icon_id.png');
$id_height = $imagesx($id_source);
$id_width = $iamgesx($id_source);

$id_create = imagecreatetruecolor($id_width, $id_height);
$id_create = imagecreatefrompng($id_source);
*/

$input = $_GET[i];

if ($input == "users"){
$var1 = mysql_query('SELECT * FROM `ttt_stats');
$uniqueusers = mysql_num_rows($var1);
$text = "Unique Trouble In Terrorist Town users:" . $uniqueusers;
}	
else
{
	$text = "No input found, please refer to documentation.";
}
$test_length = strlen($text);

$font_size = 4;

$image_height = ImageFontHeight($font_size);
$image_width = ImageFontWidth($font_size) * $test_length;

	$image = imagecreate($image_width, $image_height);
	
imagecolorallocate($image, 255, 255, 255);
$font_color = imagecolorallocate($image, 0,0,0);
	
	
imagestring($image, $font_size, 0, 0, $text, $font_color);

imagepng($image);	
?>