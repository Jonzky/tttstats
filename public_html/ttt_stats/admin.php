<?php
/*------------------------\
|        TTT STATS        |
|	   Beta           |
|=========================|
|© 2013 SNGaming.org      |
|   All Rights Reserved   |
|=========================|
|   Website printout      |
|      beta testing       |
|      by Handy_man       |
\------------------------*/
include("./includes/header.php");
$searchType = $_GET['type'];
/*Search variable go here */
if ($sb_enabled == true && $searchType == "sb"){
include("./includes/config_sb.php");	
$getAdmin = mysql_query("SELECT authid FROM sb_admins WHERE `srv_group` = 'admin' OR srv_group= 'SuperAdmin'");
$multiResult = mysql_num_rows($getAdmin);
}
else {
include("./includes/config.php");
$getAdmin = mysql_query("SELECT * FROM `ttt_stats` WHERE `isadmin` = '1'");
$multiResult = mysql_num_rows($getAdmin);
}

echo "<div id='primary_content'>";
if ($sb_enabled == true){
echo "Filter the Admin list based on the awesome tracker database or SourceBans below!";
echo"<form name='input' action='admin.php' method='get'>
<input type='radio' name='type' value='stats' checked>Stats
<input type='radio' name='type' value='sb'>SB
<button class='button' type='submit'>Filter</button>
</form>";
}
echo "<table border ='1'><tr><th>SteamID</th><th>Nickname</th><th>Playtime(hours, minutes, seconds)</th><th>Rounds played</th><th>Times innocent</th><th>Times detective</th><th>Times traitor</th><th>Total Deaths</th><th>Total Kills</th><th>KDR K/D</th><th>Total Headshots</th><th>Points</th><th>Highest Score</th><th>First seen in the server</th><th>Last Seen</th></tr>";
include("./includes/config.php");
$player = mysql_query("SELECT * FROM `ttt_stats` WHERE `isadmin` = '1'");

while($adminArray = mysql_fetch_array( $getAdmin )){
if ($searchType == "sb"){
$myAdmins = $adminArray['authid'];
}
if ($searchType == "sb"){	
$player = mysql_query("SELECT * FROM `ttt_stats` WHERE `steamid` = '$myAdmins'");
}





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


if ($playerKills && $playerDeaths != 0){
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

				

echo "<tr>";
echo "<td> <a href='search.php?STEAMID=" . $playerSteamid . "&stype=STEAM_ID'>" . $playerSteamid . "</a></td>";
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
echo "</tr>";

	
} 
}
echo "</table>";

echo "</div>";

include("./includes/footer.php");
?>