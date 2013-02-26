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

/*Search variable go here */


include("./includes/config_sb.php");
$grabAdmin = mysql_query("SELECT 'authid' FROM `sb_admins` WHERE `srv_group` LIKE 'admin' LIMIT 0, 30 ");
mysql_close($connect_sb);
$inputPlayer = $grabAdmin
include("./includes/config.php");	

$playerEscaped = mysql_real_escape_string($inputPlayer);
$player = mysql_query("SELECT * FROM `ttt_stats` WHERE `steamid` = '$playerEscaped' LIMIT 0, 30 ");

}
?>
<div id="primary_content">

<table border ="1">
						<tr>
						<th>SteamID</th>
						<th>Nickname</th>
						<th>Playtime(hours, minutes, seconds)</th>
						<th>Rounds played</th>
						<th>Times innocent</th>
						<th>Times detective</th>
						<th>Times traitor</th>
						<th>Total Deaths</th>
						<th>Total Kills</th>
						<th>KDR K/D</th>
						<th>Total Headshots</th>
						<th>Highest Score</th>
						<th>First seen in the server</th>
						<th>Number of Bans</th>
						</tr>

<?
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
$playerMaxfrags = $playerarray['maxfrags'];
$playerFirstjoined = $playerarray['first_joined'];
$sb_search_string = "http://bans.sngaming.org/index.php?p=banlist&searchText=" . $playerSteamid . "&Submit=";
if ($playerKills or $playerDeaths != 0){
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
echo "<td>" . $playerMaxfrags . "</td>";
echo "<td>" . $playerFirstjoined . "</td>";
echo "<td> <a href=" . $sb_search_string . "/>" . $bannedTotal . "</td>";
echo "</tr>";

	
} 

echo "</table>";

</div>
<?
include("./includes/footer.php");
?>