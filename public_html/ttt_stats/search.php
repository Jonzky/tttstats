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
$inputPlayer = $_GET['STEAMID'];
$inputType = $_GET['stype'];
/*Regex, we love regex to stop potential SQL injection :D */
$regex = "/^STEAM_0:[01]:[0-9]{8,9}$/";
$nickRegex = "/^[a-zA-Z0-9_. ]+((\s|\-) [a-zA-Z0-9_. ]+)?$/";
if (isset($inputPlayer)){
if ($inputType == "NICK"){
if(!preg_match($nickRegex, $inputPlayer)) {
    echo "<script LANGUAGE='JavaScript'>";
	echo "window.alert('Your Nickname includes invalid characters, please use STEAMID for your next search.')";
	echo "</script>";
	unset($inputPlayer);
}
}
else{
if(!preg_match($regex, $inputPlayer)) {
    echo "<script LANGUAGE='JavaScript'>";
	echo "window.alert('Invalid STEAMID! please try again.')";
	echo "</script>";
	unset($inputPlayer);
}
}
}
/*End of Regex*/


if(isset($inputPlayer)){
$playerEscaped = mysql_real_escape_string($inputPlayer);
if ($inputType == "STEAM_ID"){
$player = mysql_query("SELECT * FROM `ttt_stats` WHERE `steamid` = '$playerEscaped' LIMIT 0, 30 ");
}
elseif($inputType == "NICK") {
$player = mysql_query("SELECT * FROM `ttt_stats` WHERE `nickname` LIKE '$playerEscaped' LIMIT 0, 30 ");
}
else{
$player = mysql_query("SELECT * FROM `ttt_stats` WHERE `steamid` = '$playerEscaped' LIMIT 0, 30 "); //default to steamid, we should never be here.
}

mysql_close($connect);
}
?>
<div id="primary_content">
<h4>Search for your TTT stats!</h4>
<form name="input" action="search.php" method="get">
<input type="text" name="STEAMID" placeholder="Steamid / Nickname" value required>
<input type="radio" name="stype" value="STEAM_ID"checked>SteamID
<input type="radio" name="stype" value="NICK">Nickname
<button class="button" type="submit">Search</button>
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

if(isset($inputPlayer)){
$multiResult = mysql_num_rows($player);
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

		
include("./includes/config_sb.php");

$banned = mysql_query("SELECT * FROM sb_bans WHERE authid = '$playerSteamid'");
$bannedTotal = mysql_num_rows($banned);
				

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


}
echo "</table>";
?>
  <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">

      // Load the Visualization API and the piechart package.
      google.load('visualization', '1.0', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([
          ['Innocent', <?echo$playerInnocenttimes;?>],
          ['Detective', <?echo$playerDetectivetimes;?>],
          ['Traitor', <?echo$playerTraitortimes;?>]
        ]);

        // Set chart options
        var options = {'title':'Traitor, Detective, Innocent Times.',
                       'width':400,
                       'height':300};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
<?
if ($multiResult == 1){
echo  "<div id='chart_div'></div>";
}
?>

</div>
<?
include("./includes/footer.php");
?>