<?php
/*------------------------\
|        TTT STATS        |
|	       Beta           |
|=========================|
|� 2013 SNGaming.org      |
|	All Rights Reserved   |
|=========================|
| 	Website printout      |
| 	   beta testing       |
| 	   by Handy_man       |
\------------------------*/
//When you're refferencing this page for a loadingurl you need to add: ?steamid=%s
//an example of this would be: http://thehiddennation.com/ttt_stats/motd.php?steamid=%s
//so for a loadingurl in the server.cfg your example would be:
//sv_loadingurl "http://thehiddennation.com/ttt_stats/motd.php?steamid=%s"


include("./includes/header.php");
include("./includes/config.php");	

/*SteamID getting from _get data*/
//Get the steamid (really the community id)
$communityid = $_GET["steamid"];
//See if the second number in the steamid (the auth server) is 0 or 1. Odd is 1, even is 0
$authserver = bcsub($communityid, '76561197960265728') & 1;
//Get the third number of the steamid
$authid = (bcsub($communityid, '76561197960265728')-$authserver)/2;
//Concatenate the STEAM_ prefix and the first number, which is always 0, as well as colons with the other two numbers
$steamid = "STEAM_0:$authserver:$authid";



/*Getting our player data!*/
$inputPlayer = $steamid;
if(isset($inputPlayer)){
$playerEscaped = mysql_real_escape_string($inputPlayer);
$player = mysql_query("SELECT * FROM `ttt_stats` WHERE `steamid` = '$playerEscaped' LIMIT 0, 30 ");
$multiResult = mysql_num_rows($player);
$playerarray = mysql_fetch_array($player);
mysql_close($connect);
if ($sb_enabled == true){
include("./includes/config_sb.php");

$banned = mysql_query("SELECT * FROM sb_bans WHERE authid = '$playerEscaped'");
$bannedTotal = mysql_num_rows($banned);
}
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

if ($playerKills && $playerDeaths != 0){
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

//Commented out the JSON API from Steam that grabs the users avatar and displays it in hopes to make a faster loading page.           
//$link = file_get_contents('http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=CA269D3FE157CBEA7386C9830FCC218D&steamids=' . $communityid . '&format=json');
 
//$myarray = json_decode($link, true);
/* This code outputs our avatar wherever it's placed.
<img class='avatar' src='<?php print $myarray['response']['players'][0]['avatarmedium']; ?>'/>
*/
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
                       'width':350,
                       'height':250,
					   'colors': ['green', 'blue', 'red'],
					   'is3D': true
					   };

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
<div id="primary_content">
</br>
<?PHP
if ($multiResult == 1){ 
echo $avatar;
echo"<table border ='1'><tr><th>SteamID</th><th>Nickname</th><th>Playtime(hours, minutes, seconds)</th><th>Rounds played</th><th>Times innocent</th><th>Times detective</th><th>Times traitor</th><th>Total Deaths</th><th>Total Kills</th><th>KDR K/D</th><th>Total Headshots</th><th>Total Points</th><th>Highest Score</th><th>First seen in the server</th>"; if ($sb_enabled == true){echo "<th># of Bans</th></tr>";}
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
if ($sb_enabled == true){
echo "<td>" . $bannedTotal . "</td>";
}
echo "</tr>";
echo "</table>";
echo "<div id='chart_div'>";
echo "</div>";
?>
<?PHP

}
else{
echo "<h3>Looks like you've never joined the server before! Welcome, remember to check out the MOTD in game!</h3>";
}
echo "</div>";

?>


<?
include("./includes/footer.php");
?>