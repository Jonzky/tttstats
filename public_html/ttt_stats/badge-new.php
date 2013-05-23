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
//$text = $playerNickname . "'s TTT Stats H:" . $hours . " M:" . $minutes . " S:" . $seconds;
//$text_rounds = "Rounds Played:" . $playerRoundsplayed . " Highest score:" . $playerMaxfrags . " Points:" . $playerPoints;
//$text_kill = "Kills:" . $playerKills . " Deaths:" . $playerDeaths . " Headshots:" . $playerHeadshots . " KDR:" . $playerKDR;
$title = "Trouble In Terrorist Town Stats";
$name = $playerNickname;
$playtime = "H:" . $hours . " M:" . $minutes . " S:" . $seconds;
$membersince = "Member since: " . $playerFirstjoined;
$round = "Round played:" . $playerRoundsplayed;
$high = "Highest score:" . $playerMaxfrags;
$points = "Points:" . $playerPoints;
$kills = "Kills:" . $playerKills;
$deaths = "Deaths:" . $playerDeaths;
$headshots = "Headshots:" . $playerHeadshots;
$KDR = "KDR:" . $playerKDR;
$traitor = "Traitor:" . $playerTraitortimes;
$innocent = "Innocent:" . $playerInnocenttimes;
$detective = "Detective:" . $playerDetectivetimes;
$url = "www.thehiddennation.com/ttt_stats";
}
else{
$text = "No input type defined, please try again.";
}
$test_length = strlen($text);
if ($inputType == "all"){
$test_length_kill = strlen($text_kill);
$test_length_rounds = strlen($text_rounds);

if ($test_length > $test_length_kill & $test_length_rounds){

}
else if ($test_length_kill  > $test_length_rounds){
$test_length = strlen($text_kill);
}
else{
$test_length = strlen($text_rounds);
}
}


$font_size = 2;
$font_double = 42;

//$image_height = ImageFontHeight($font_double);
$image_height = 128;

$image_width = 460;

	$image = imagecreate($image_width, $image_height);
	
imagecolorallocate($image, 51, 51, 51);
$font_color = imagecolorallocate($image, 139,134,131);
	
	
imagestring($image, $font_size, 120, 0, $title, $font_color);
imagestring($image, $font_size, 80, 24, $name, $font_color);
imagestring($image, $font_size, 80, 36, $playtime, $font_color);
imagestring($image, $font_size, 180, 24, $membersince, $font_color);
imagestring($image, $font_size, 180, 36, $kills, $font_color);
imagestring($image, $font_size, 180, 48, $deaths, $font_color);
imagestring($image, $font_size, 180, 60, $KDR, $font_color);
imagestring($image, $font_size, 280, 36, $round, $font_color);
imagestring($image, $font_size, 280, 48, $high, $font_color);
imagestring($image, $font_size, 280, 60, $points, $font_color);
imagestring($image, $font_size, 280, 72, $headshots, $font_color);
imagestring($image, $font_size, 80, 60, $traitor, $font_color);
imagestring($image, $font_size, 80, 72, $innocent, $font_color);
imagestring($image, $font_size, 80, 84, $detective, $font_color);
imagestring($image, $font_size, 260, 115, $url, $font_color);

imagepng($image);	
ImageDestroy($image);
?>