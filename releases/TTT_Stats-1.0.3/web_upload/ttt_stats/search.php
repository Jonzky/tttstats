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
$inputType = $_GET['stype'];
/*Regex, we love regex to stop potential SQL injection :D */
$regex = "/^STEAM_0:[01]:[0-9]{7,8}$/";
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
$player = mysql_query("SELECT * FROM `ttt_stats` WHERE `nickname` LIKE '%$playerEscaped%' LIMIT 0, 30 "); //We limit this to 30 based purely on the fact that we'd get way too many results for certain searches.
}
else{
$player = mysql_query("SELECT * FROM `ttt_stats` WHERE `steamid` = '$playerEscaped' LIMIT 0, 30 "); //default to steamid, we should never be here.
}

mysql_close($connect);
}
?>
  <script type="text/javascript">
   function showDiv() {
   document.getElementById('advanced-search').style.display = "block";
   hideDivNormal();
}
function hideDiv() {
   document.getElementById('advanced-search').style.display = "none";
}
function hideDivNormal() {
   document.getElementById('normal-search').style.display = "none";
}

  
  </script>

<div id="primary_content">
<h4>Search for your TTT stats!</h4>
<div id="normal-search" style="display:block;">
<form id="advanced-show" name="input" action="search.php" method="get">
<input type="text" name="STEAMID" placeholder="Your SteamID / Nickname" size="30" value required>
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
include("./includes/config_sb.php");

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
                       'height':300,
					   'colors': ['green', 'blue', 'red'],
					   'is3D': true
					   };

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
<?
if ($multiResult == 1){
echo  "<div id='chart_div'></div>";
}
else if ($multiResult == 0 && isset($inputPlayer)){
echo "<p class='noexist'>No user found under that name.</p>";
}
?>

</div>
<?
include("./includes/footer.php");
?>
