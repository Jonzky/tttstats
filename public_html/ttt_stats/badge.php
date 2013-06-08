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
include ("./includes/variables.php");
if($badge_enabled == true){
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
$playerLastSeen = $playerarray['last_seen'];
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
$url = $badge_ref;
$lastseen = "Last Seen: " . $playerLastSeen;
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
//$font_color = imagecolorallocate($image, 139,134,131);
$font_color = imagecolorallocate($image, 202,74,15);
	
	
imagestring($image, $font_size, 120, 0, $title, $font_color);
imagestring($image, $font_size, 20, 24, $name, $font_color);
imagestring($image, $font_size, 20, 36, $playtime, $font_color);
imagestring($image, $font_size, 220, 24, $membersince, $font_color);
imagestring($image, $font_size, 220, 36, $lastseen, $font_color);
imagestring($image, $font_size, 120, 60, $kills, $font_color);
imagestring($image, $font_size, 120, 72, $deaths, $font_color);
imagestring($image, $font_size, 120, 84, $KDR, $font_color);
imagestring($image, $font_size, 340, 60, $round, $font_color);
imagestring($image, $font_size, 220, 60, $high, $font_color);
imagestring($image, $font_size, 220, 72, $points, $font_color);
imagestring($image, $font_size, 220, 84, $headshots, $font_color);
imagestring($image, $font_size, 20, 60, $traitor, $font_color);
imagestring($image, $font_size, 20, 72, $innocent, $font_color);
imagestring($image, $font_size, 20, 84, $detective, $font_color);
imagestring($image, $font_size, 120, 115, $url, $font_color);

imagepng($image);	
ImageDestroy($image);
}

?>