<?php
/*------------------------\
|        TTT STATS        |
|	   Beta           |
|=========================|
|� 2013 SNGaming.org      |
|   All Rights Reserved   |
|=========================|
|   Website printout      |
|      beta testing       |
|      by Handy_man       |
\------------------------*/
include("./includes/header.php");
include("./includes/config.php");	
/*Search variable go here */
$inputPlayer = $_GET['STEAMID'];
$inputPlayer2 = $_GET['STEAMID2'];
$inputType = $_GET['stype'];
/*Regex, we love regex to stop potential SQL injection :D */
$regex = "/^STEAM_0:[01]:[0-9]{7,8}$/";
$nickRegex = "/^[a-zA-Z0-9_. ]+((\s|\-) [a-zA-Z0-9_. ]+)?$/";
if (isset($inputPlayer) && isset($inputPlayer2)){
if ($inputType == "NICK"){
if(!preg_match($nickRegex, $inputPlayer) || !preg_match($nickRegex, $inputPlayer2)) {
    echo "<script LANGUAGE='JavaScript'>";
	echo "window.alert('Your Nickname includes invalid characters, please use STEAMID for your next search.')";
	echo "</script>";
	unset($inputPlayer);
	unset($inputPlayer2);
}
}
else{
if(!preg_match($regex, $inputPlayer) || !preg_match($regex, $inputPlayer2)) {
    echo "<script LANGUAGE='JavaScript'>";
	echo "window.alert('Invalid STEAMID! please try again.')";
	echo "</script>";
	unset($inputPlayer);
	unset($inputPlayer2);
}
}
}
/*End of Regex*/


if(isset($inputPlayer) && isset($inputPlayer2)){
$playerEscaped = mysql_real_escape_string($inputPlayer);
$playerEscaped2 = mysql_real_escape_string($inputPlayer2);

if ($inputType == "STEAM_ID"){
$player = mysql_query("SELECT * FROM `ttt_stats` WHERE `steamid` = '$playerEscaped' LIMIT 0, 30 ");
$player2 = mysql_query("SELECT * FROM `ttt_stats` WHERE `steamid` = '$playerEscaped2' LIMIT 0, 30 ");
}
elseif($inputType == "NICK") {
$player = mysql_query("SELECT * FROM `ttt_stats` WHERE `nickname` LIKE '%$playerEscaped%' LIMIT 0, 30 "); //We limit this to 30 based purely on the fact that we'd get way too many results for certain searches.
$player2 = mysql_query("SELECT * FROM `ttt_stats` WHERE `nickname` LIKE '%$playerEscaped2%' LIMIT 0, 30 "); //We limit this to 30 based purely on the fact that we'd get way too many results for certain searches.
}
else{
$player = mysql_query("SELECT * FROM `ttt_stats` WHERE `steamid` = '$playerEscaped' LIMIT 0, 30 "); //default to steamid, we should never be here.
$player2 = mysql_query("SELECT * FROM `ttt_stats` WHERE `steamid` = '$playerEscaped2' LIMIT 0, 30 "); //default to steamid, we should never be here.
}
mysql_close($connect);
}
?>
<div id="primary_content">
<h4>Compare your stats with a friends!</h4>
<div id="normal-search" style="display:block;">
<form id="advanced-show" name="input" action="compare.php" method="get">
<input type="text" name="STEAMID" placeholder="Your SteamID / Nickname" size="30" value required>
<input type="text" name="STEAMID2" placeholder="Your friends Steamid / Nickname" size="30" value required>
<input type="radio" name="stype" value="STEAM_ID">SteamID
<input type="radio" name="stype" value="NICK" checked>Nickname
<button class="button" type="submit">Search</button>
</form>
</div>

<table border ="1">
						<tr>
						<th>SteamID</th>
						<th>Nickname</th>
						<th>Playtime<br/>(hours, minutes, seconds)</th>
						<th>Rounds Played</th>
						<th>Times Innocent</th>
						<th>Times Detective</th>
						<th>Times Traitor</th>
						<th>Total Deaths</th>
						<th>Total Kills</th>
						<th>K/D Ratio</th>
						<th>Total Head-Shots</th>
						<th>Total Points</th>
						<th>Highest Score</th>
						<th>First Joined</th>
						<th>Last Seen</th>
						<?PHP
						if ($sb_enabled == true){
						echo "<th># of Bans</th>";
						}
						?>
						</tr>

<?
//start of player1 get data
if(isset($inputPlayer) && isset($inputPlayer2)){

while($playerarray = mysql_fetch_array( $player )) {
$playerSteamid = $playerarray['steamid'];
$playerNickname = $playerarray['nickname'];
$playerPlaytime = $playerarray['playtime'];
$playerRoundsplayed = $playerarray['roundsplayed'];
$playerInnocenttimes = $playerarray['innocenttimes'];
$playerDetectivetimes = $playerarray['detectivetimes'];
$playerTraitortimes = $playerarray['traitortimes'];
$playerDeaths = $playerarray['deaths'];
$playerKills = $playerarray['kills'];
$playerHeadshots = $playerarray['headshots'];
$playerPoints = $playerarray['points'];
$playerMaxfrags = $playerarray['maxfrags'];
$playerFirstjoined = $playerarray['first_joined'];
$playerLastSeen = $playerarray['last_seen'];
$sb_search_string = $sb_search_build . $playerSteamid . "&Submit=";
if ($playerKills and $playerDeaths != 0){
$playerKDRTrun = $playerKills / $playerDeaths;
$playerKDR = round($playerKDRTrun, 2); //rounding to numbers such as 0.12 rather then 0.1259848797 etc. We don't need that many decimal points in our output, no one cares for that level of accuracy. 
}
else {
$playerKDR = "N/A";
}
$seconds = $playerPlaytime;
			//start of math for hourse, minues and seconds
				$hours = floor($seconds / (60 * 60));
 
			// extract minutes
				$divisor_for_minutes = $seconds % (60 * 60);
				$minutes = floor($divisor_for_minutes / 60);
 
			// extract the remaining seconds
				$divisor_for_seconds = $divisor_for_minutes % 60;
				$seconds = ceil($divisor_for_seconds);

if ($sb_enabled == true){
include_once("./includes/config_sb.php");

$banned = mysql_query("SELECT * FROM sb_bans WHERE authid = '$playerSteamid'");
$bannedTotal = mysql_num_rows($banned);
}

echo "<tr>";
echo "<td>" . $playerSteamid . "</td>";
echo "<td>" . $playerNickname . "</td>";
echo "<td> H:" . $hours . " M:" . $minutes . " S:" . $seconds . "</td>";
echo "<td>" . $playerRoundsplayed . "</td>";
echo "<td>" . $playerInnocenttimes . "</td>";
echo "<td>" . $playerDetectivetimes . "</td>";
echo "<td>" . $playerTraitortimes . "</td>";
echo "<td>" . $playerDeaths . "</td>";
echo "<td>" . $playerKills . "</td>";
echo "<td>" . $playerKDR . "</td>";
echo "<td>" . $playerHeadshots . "</td>";
echo "<td>" . $playerPoints . "</td>";
echo "<td>" . $playerMaxfrags . "</td>";
echo "<td>" . $playerFirstjoined . "</td>";
echo "<td>" . $playerLastSeen . "</td>";
if ($sb_enabled == true){
echo "<td> <a href=" . $sb_search_string . "/>" . $bannedTotal . "</td>";
}
echo "</tr>";

	
} 


}
echo "</table>";

//end of player 1 get and print of data
?>

</br>
</br>
</br>
</br>
<table border ="1">
						<tr>
						<th>SteamID</th>
						<th>Nickname</th>
						<th>Playtime<br/>(hours, minutes, seconds)</th>
						<th>Rounds Played</th>
						<th>Times Innocent</th>
						<th>Times Detective</th>
						<th>Times Traitor</th>
						<th>Total Deaths</th>
						<th>Total Kills</th>
						<th>K/D Ratio</th>
						<th>Total Head-Shots</th>
						<th>Total Points</th>
						<th>Highest Score</th>
						<th>First Joined</th>
						<th>Last Seen</th>
						<?PHP
						if ($sb_enabled == true){
						echo "<th># of Bans</th>";
						}
						?>
						</tr>
<?
//start of player 2 get and print data
if(isset($inputPlayer) && isset($inputPlayer2)){

while($playerarray = mysql_fetch_array( $player2 )) {
$playerSteamid2 = $playerarray['steamid'];
$playerNickname2 = $playerarray['nickname'];
$playerPlaytime2 = $playerarray['playtime'];
$playerRoundsplayed2 = $playerarray['roundsplayed'];
$playerInnocenttimes2 = $playerarray['innocenttimes'];
$playerDetectivetimes2 = $playerarray['detectivetimes'];
$playerTraitortimes2 = $playerarray['traitortimes'];
$playerDeaths2 = $playerarray['deaths'];
$playerKills2 = $playerarray['kills'];
$playerHeadshots2 = $playerarray['headshots'];
$playerPoints2 = $playerarray['points'];
$playerMaxfrags2 = $playerarray['maxfrags'];
$playerFirstjoined2 = $playerarray['first_joined'];
$playerLastSeen2 = $playerarray['last_seen'];
if ($sb_enabled == true){
$sb_search_string2 = $sb_search_build . $playerSteamid2 . "&Submit=";
}
if ($playerKills2 and $playerDeaths2 != 0){
$playerKDRTrun2 = $playerKills2 / $playerDeaths2;
$playerKDR2 = round($playerKDRTrun2, 2); //rounding to numbers such as 0.12 rather then 0.1259848797 etc. We don't need that many decimal points in our output, no one cares for that level of accuracy. 
}
else {
$playerKDR2 = "N/A";
}
$seconds2 = $playerPlaytime2;
			//start of math for hourse, minues and seconds
				$hours2 = floor($seconds2 / (60 * 60));
 
			// extract minutes
				$divisor_for_minutes2 = $seconds2 % (60 * 60);
				$minutes2 = floor($divisor_for_minutes2 / 60);
 
			// extract the remaining seconds
				$divisor_for_seconds2 = $divisor_for_minutes2 % 60;
				$seconds2 = ceil($divisor_for_seconds2);
if ($sb_enabled == true){
$banned2 = mysql_query("SELECT * FROM sb_bans WHERE authid = '$playerSteamid2'");
$bannedTotal2 = mysql_num_rows($banned2);
}

echo "<tr>";
echo "<td>" . $playerSteamid2 . "</td>";
echo "<td>" . $playerNickname2 . "</td>";
echo "<td> H:" . $hours2 . " M:" . $minutes2 . " S:" . $seconds2 . "</td>";
echo "<td>" . $playerRoundsplayed2 . "</td>";
echo "<td>" . $playerInnocenttimes2 . "</td>";
echo "<td>" . $playerDetectivetimes2 . "</td>";
echo "<td>" . $playerTraitortimes2 . "</td>";
echo "<td>" . $playerDeaths2 . "</td>";
echo "<td>" . $playerKills2 . "</td>";
echo "<td>" . $playerKDR2 . "</td>";
echo "<td>" . $playerHeadshots2 . "</td>";
echo "<td>" . $playerPoints2 . "</td>";
echo "<td>" . $playerMaxfrags2 . "</td>";
echo "<td>" . $playerFirstjoined2 . "</td>";
echo "<td>" . $playerLastSeen2 . "</td>";
if ($sb_enabled == true){
echo "<td> <a href=" . $sb_search_string2 . "/>" . $bannedTotal2 . "</td>";
}
echo "</tr>";

	
} 


}
echo "</table>";
//end of player 2 start and get data
if (isset($player) && isset($player2)){
$multiResult = mysql_num_rows($player);
$multiResult2 = mysql_num_rows($player2);
}
if ($multiResult == 0 && isset($inputPlayer) || $multiResult2 == 0 && isset($inputPlayer2)){
echo "<p class='noexist'>One of more users doesn't exist, please try again.</p>";
}

?>

</div>
<?
include("./includes/footer.php");
?>