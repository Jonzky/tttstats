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

$inputPlayerNick = $_GET['NICK'];
if(isset($inputPlayerNick)){
$playerEscaped = mysql_real_escape_string($inputPlayerNick);
$player = mysql_query("SELECT * FROM `ttt_stats` WHERE `nickname` LIKE '$playerEscaped' LIMIT 0, 30 ");
$playerarray = mysql_fetch_array($player);

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

}
$inputPlayer = $_GET['STEAMID'];
if(isset($inputPlayer)){
$playerEscaped = mysql_real_escape_string($inputPlayer);
$player = mysql_query("SELECT * FROM `ttt_stats` WHERE `steamid` = '$playerEscaped' LIMIT 0, 30 ");
$playerarray = mysql_fetch_array($player);
mysql_close($connect);
include("./includes/config_sb.php");

$banned = mysql_query("SELECT * FROM sb_bans WHERE authid = '$playerEscaped'");
$bannedTotal = mysql_num_rows($banned);

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


?>
<div id="primary_content">
<h3>Search via STEAMID </h3>
<form name="input" action="search.php" method="get">
<input type="text" name="STEAMID"></br>
<input type="submit" value="Submit">
</form>

<h3>Search via Nickname (last steam name seen on the server)</h3>
<form name="input" action="search.php" method="get">
<input type="text" name="NICK"></br>
<input type="submit" value="Submit">
</form>


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
echo "</table>";
echo "</div>";

include("./includes/footer.php");
?>
