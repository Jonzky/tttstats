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
else if ($input == "killed") {
$kills = mysql_query('SELECT SUM(kills) AS kills_sum FROM ttt_stats');
$killsarray = mysql_fetch_array($kills);
$killstotal = $killsarray['kills_sum'];
$text = "Number of players killed:" . $killstotal;
}
else if ($input == "dead") {
$death = mysql_query('SELECT SUM(deaths) AS deaths_sum FROM ttt_stats');
$deatharray = mysql_fetch_array($death);
$deathtotal = $deatharray['deaths_sum'];
$text = "Number of player deaths:" . $deathtotal;
}
else if ($input == "headshots") {
$head = mysql_query('SELECT SUM(headshots) AS headshots_sum FROM ttt_stats');
$headarray = mysql_fetch_array($head);
$headtotal = $headarray['headshots_sum'];
$text = "Number of headshots made:" . $headtotal;
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
ImageDestroy($image);
?>