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
/*Getting our player data!*/
$inputPlayer = $_GET['i'];
/*Regex, we love regex to stop potential SQL injection :D */
$regex = "/^STEAM_0:[01]:[0-9]{7,8}$/";
if (isset($inputPlayer)){
if(!preg_match($regex, $inputPlayer)) {
    echo "<script LANGUAGE='JavaScript'>";
	echo "window.alert('Invalid STEAMID! please try again.')";
	echo "</script>";
	unset($inputPlayer);
}
}
/*End of Regex*/
if(isset($inputPlayer)){
$playerEscaped = mysql_real_escape_string($inputPlayer);
$player = mysql_query("SELECT * FROM `ttt_stats` WHERE `steamid` = '$playerEscaped' LIMIT 0, 30 ");
$multiResult = mysql_num_rows($player);
$playerarray = mysql_fetch_array($player);
mysql_close($connect);

$playerSteamid = $playerarray['steamid'];
$playerNickname = $playerarray['nickname'];
$playerPlaytime = $playerarray['playtime'];
$playerRoundsplayed = $playerarray['roundsplayed'];
$playerInnocenttimes = $playerarray['innocenttimes'];
$playerDetectivetimes = $playerarray['detectivetimes'];
$playerTraitortimes = $playerarray['traitortimes'];
$playerDeaths = $playerarray['deaths'];
$playerKills = $playerarray['kills'];
$playerPoints = $playerarray['points'];
$playerMaxfrags = $playerarray['maxfrags'];
$playerHeadshots = $playerarray['headshots'];
$playerFirstjoined = $playerarray['first_joined'];
}

if ($playerKills or $playerDeaths != 0){
$playerKDRTrun = $playerKills / $playerDeaths;
$playerKDR = round($playerKDRTrun, 2); //rounding to numbers such as 0.12 rather then 0.1259848797 etc. We don't need that many decimal points in our output, no one cares for that level of accuracy. 
}
else {
$playerKDR = "N/A";
}
/*Search variable end here */
	
/*Maths for any functions go here */

$seconds = $playerPlaytime;
			//start of math for hourse, minues and seconds
				$hours = floor($seconds / (60 * 60));
 
			// extract minutes
				$divisor_for_minutes = $seconds % (60 * 60);
				$minutes = floor($divisor_for_minutes / 60);
 
			// extract the remaining seconds
				$divisor_for_seconds = $divisor_for_minutes % 60;
				$seconds = ceil($divisor_for_seconds);
				
/*Maths for functions end here */
$inputType = $_GET['t'];
if ($inputType == "time"){
$text = $playerNickname . "'s TTT Playtime H:" . $hours . " M:" . $minutes . " S:" . $seconds;
}
else if ($inputType == "all"){
$text = $playerNickname . "'s TTT Stats H: " . $hours . " M: " . $minutes . " S: " . $seconds;
}
else{
$text = "No input type defined, please try again.";
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