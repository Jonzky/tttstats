<?php
/*------------------------\
|        TTT STATS        |
|	       Beta       |
|=========================|
|� 2013 SNGaming.org      
|  All Rights Reserved    |
|=========================|
| 	Website printout  |
| 	   beta testing   |
| 	   by Handy_man   |
\------------------------*/
include("./includes/header.php");
include("./includes/config.php");	
/*Setup variables for SQL statements */
//Used in KDR, basically low amount of deaths (1 or 2) are generally RDMer's in your server.
//This variable allows for you to scale this to your liking, default is set to 30.
$deathLimit = 30;
$hourLimit = 36000; //10 hours
$statHours = floor($hourLimit / 3600); //simple maths to convert our seconds into hours for user friendly reading.
$statType = $_GET['type'];

/*Stats SQL queries all go here */

if(!isset($statType)){

$var1 = mysql_query('SELECT * FROM ttt_stats');
$uniqueusers = mysql_num_rows($var1);

$innocent = mysql_query('SELECT SUM(innocenttimes) AS innocent_sum FROM ttt_stats');
$innocentarray = mysql_fetch_array($innocent);
$innocenttotal = $innocentarray['innocent_sum'];

$traitor = mysql_query('SELECT SUM(traitortimes) AS traitor_sum FROM ttt_stats');
$traitorarray = mysql_fetch_array($traitor);
$traitortotal = $traitorarray['traitor_sum'];

$detective = mysql_query('SELECT SUM(detectivetimes) AS detective_sum FROM ttt_stats');
$detectivearray = mysql_fetch_array($detective);
$detectivetotal = $detectivearray['detective_sum'];

$death = mysql_query('SELECT SUM(deaths) AS deaths_sum FROM ttt_stats');
$deatharray = mysql_fetch_array($death);
$deathtotal = $deatharray['deaths_sum'];

$kills = mysql_query('SELECT SUM(kills) AS kills_sum FROM ttt_stats');
$killsarray = mysql_fetch_array($kills);
$killstotal = $killsarray['kills_sum'];

$head = mysql_query('SELECT SUM(headshots) AS headshots_sum FROM ttt_stats');
$headarray = mysql_fetch_array($head);
$headtotal = $headarray['headshots_sum'];

$point = mysql_query('SELECT SUM(points) AS points_sum FROM ttt_stats');
$pointarray = mysql_fetch_array($point);
$pointtotal = $pointarray['points_sum'];

$time = mysql_query('SELECT SUM(playtime) AS playtime_sum FROM ttt_stats');
$timearray = mysql_fetch_array($time);
$timetotal = $timearray['playtime_sum'];

$topscore = mysql_query("SELECT nickname, maxfrags FROM `ttt_stats` ORDER BY `ttt_stats`.`maxfrags` DESC LIMIT 0, 1");
$topscorearray = mysql_fetch_array ( $topscore );
$topscorefinal = $topscorearray['maxfrags'];
$topscorenick = $topscorearray['nickname'];
}
else{
$top10Time = mysql_query("SELECT nickname, playtime FROM `ttt_stats` ORDER BY `ttt_stats`.`playtime` DESC LIMIT 0, 10 ");
$top10Score = mysql_query("SELECT nickname, maxfrags FROM `ttt_stats` ORDER BY `ttt_stats`.`maxfrags` DESC LIMIT 0, 10 ");
$top10Deaths = mysql_query("SELECT nickname, deaths FROM `ttt_stats` ORDER BY `ttt_stats`.`deaths` DESC LIMIT 0, 10 ");
$top10Kills = mysql_query("SELECT nickname, kills FROM `ttt_stats` ORDER BY `ttt_stats`.`kills` DESC LIMIT 0, 10 ");
$top10Head = mysql_query("SELECT nickname, headshots FROM `ttt_stats` ORDER BY `ttt_stats`.`headshots` DESC LIMIT 0, 10 ");
$top10Points = mysql_query("SELECT nickname, points FROM `ttt_stats` ORDER BY `ttt_stats`.`points` DESC LIMIT 0, 10 ");
$top10KDR = mysql_query("SELECT nickname, kills, deaths, (kills / deaths) KDR FROM `ttt_stats` WHERE deaths >= '$deathLimit' AND playtime >= '$hourLimit' ORDER BY `KDR` DESC LIMIT 0, 10");

$rounds = mysql_query('SELECT SUM(roundsplayed) FROM ttt_stats');
$roundsarray = mysql_fetch_array($rounds);
$roundstotal = array_sum($roundsarray);
}
/*Stats SQL queries end here */

/*Maths for any functions go here */

$seconds = $timetotal;
			//start of math for hourse, minues and seconds
				$hours = floor($seconds / (60 * 60));
 
			// extract minutes
				$divisor_for_minutes = $seconds % (60 * 60);
				$minutes = floor($divisor_for_minutes / 60);
 
			// extract the remaining seconds
				$divisor_for_seconds = $divisor_for_minutes % 60;
				$seconds = ceil($divisor_for_seconds);
				
				
/*Maths for functions end here */

/*print statements */

echo "<div id='primary_content'>";

if(isset($statType) && $statType == "all"){
echo"<form name='input' action='stats.php' method='get'>
<input type='radio' name='type' value='all' checked>All
<input type='radio' name='type' value='time'>Time
<input type='radio' name='type' value='kills'>Kills
<input type='radio' name='type' value='deaths'>Deaths
<input type='radio' name='type' value='score'>Score
<input type='radio' name='type' value='points'>Points
<input type='radio' name='type' value='headshots'>Head-Shots
<input type='radio' name='type' value='kdr'>KDR
<button class='button' type='submit'>Filter</button>
</form>";
}
else if(isset($statType) && $statType == "time"){
echo"<form name='input' action='stats.php' method='get'>
<input type='radio' name='type' value='all'>All
<input type='radio' name='type' value='time' checked>Time
<input type='radio' name='type' value='kills'>Kills
<input type='radio' name='type' value='deaths'>Deaths
<input type='radio' name='type' value='score'>Score
<input type='radio' name='type' value='points'>Points
<input type='radio' name='type' value='headshots'>Head-Shots
<input type='radio' name='type' value='kdr'>KDR
<button class='button' type='submit'>Filter</button>
</form>";
}
else if(isset($statType) && $statType == "kills"){
echo"<form name='input' action='stats.php' method='get'>
<input type='radio' name='type' value='all'>All
<input type='radio' name='type' value='time'>Time
<input type='radio' name='type' value='kills' checked>Kills
<input type='radio' name='type' value='deaths'>Deaths
<input type='radio' name='type' value='score'>Score
<input type='radio' name='type' value='points'>Points
<input type='radio' name='type' value='headshots'>Head-Shots
<input type='radio' name='type' value='kdr'>KDR
<button class='button' type='submit'>Filter</button>
</form>";
}
else if(isset($statType) && $statType == "deaths"){
echo"<form name='input' action='stats.php' method='get'>
<input type='radio' name='type' value='all'>All
<input type='radio' name='type' value='time'>Time
<input type='radio' name='type' value='kills'>Kills
<input type='radio' name='type' value='deaths' checked>Deaths
<input type='radio' name='type' value='score'>Score
<input type='radio' name='type' value='points'>Points
<input type='radio' name='type' value='headshots'>Head-Shots
<input type='radio' name='type' value='kdr'>KDR
<button class='button' type='submit'>Filter</button>
</form>";
}
else if(isset($statType) && $statType == "score"){
echo"<form name='input' action='stats.php' method='get'>
<input type='radio' name='type' value='all'>All
<input type='radio' name='type' value='time'>Time
<input type='radio' name='type' value='kills'>Kills
<input type='radio' name='type' value='deaths'>Deaths
<input type='radio' name='type' value='score' checked>Score
<input type='radio' name='type' value='points'>Points
<input type='radio' name='type' value='headshots'>Head-Shots
<input type='radio' name='type' value='kdr'>KDR
<button class='button' type='submit'>Filter</button>
</form>";
}
else if(isset($statType) && $statType == "points"){
echo"<form name='input' action='stats.php' method='get'>
<input type='radio' name='type' value='all'>All
<input type='radio' name='type' value='time'>Time
<input type='radio' name='type' value='kills'>Kills
<input type='radio' name='type' value='deaths'>Deaths
<input type='radio' name='type' value='score'>Score
<input type='radio' name='type' value='points' checked>Points
<input type='radio' name='type' value='headshots'>Head-Shots
<input type='radio' name='type' value='kdr'>KDR
<button class='button' type='submit'>Filter</button>
</form>";
}
else if(isset($statType) && $statType == "headshots"){
echo"<form name='input' action='stats.php' method='get'>
<input type='radio' name='type' value='all'>All
<input type='radio' name='type' value='time'>Time
<input type='radio' name='type' value='kills'>Kills
<input type='radio' name='type' value='deaths'>Deaths
<input type='radio' name='type' value='score'>Score
<input type='radio' name='type' value='points'>Points
<input type='radio' name='type' value='headshots' checked>Head-Shots
<input type='radio' name='type' value='kdr'>KDR
<button class='button' type='submit'>Filter</button>
</form>";
}
else if(isset($statType) && $statType == "kdr"){
echo"<form name='input' action='stats.php' method='get'>
<input type='radio' name='type' value='all'>All
<input type='radio' name='type' value='time'>Time
<input type='radio' name='type' value='kills'>Kills
<input type='radio' name='type' value='deaths'>Deaths
<input type='radio' name='type' value='score'>Score
<input type='radio' name='type' value='points'>Points
<input type='radio' name='type' value='headshots'>Head-Shots
<input type='radio' name='type' value='kdr' checked>KDR
<button class='button' type='submit'>Filter</button>
</form>";
}
else{
echo"<form name='input' action='stats.php' method='get'>
<input type='radio' name='type' value='all'>All
<input type='radio' name='type' value='time'>Time
<input type='radio' name='type' value='kills'>Kills
<input type='radio' name='type' value='deaths'>Deaths
<input type='radio' name='type' value='score'>Score
<input type='radio' name='type' value='points'>Points
<input type='radio' name='type' value='headshots'>Head-Shots
<input type='radio' name='type' value='kdr'>KDR
<button class='button' type='submit'>Filter</button>
</form>";
}

if (!isset($statType)){
echo "<img src='./static/images/icon_id.png' alt='ID icon' title='unique users' /> : " . $uniqueusers;
echo "<img src='./static/images/icon_bullet.png' alt='Bullet icon' title='Total kills'/> : " . $killstotal;
echo "<img src='./static/images/icon_inno.png' alt='TTT innocent icon' title='Total Innocents'/> : " . $innocenttotal;
echo "<img src='./static/images/icon_det.png' alt='TTT Detective icon' title='Total Detectives'/> : " . $detectivetotal;
echo "<img src='./static/images/icon_traitor.png' alt='TTT Traitor icon' title='Total Traitors'/> : " . $traitortotal;
echo "<img src='./static/images/icon_corpse.png' alt='Deadbody icon' title='Total Deaths'/> : " . $deathtotal;
echo "<img src='./static/images/icon_head.png' alt='Headshot icon' title='Total Headshots'/> : " . $headtotal . "<br/>";
echo "<img src='./static/images/icon_points.png' alt='Points icon' title='Total Points'/> : " . $pointtotal . "<br/>";
//echo "Total number of rounds played : " . $roundstotal . "<br/>"; //bad stat, multiple players can play the same round thus it's untrue.
//echo "<img src='./static/images/icon_time.png'/> Total number of " . $hours . " Hours, " . $minutes . " Minutes, and " . $seconds . " seconds spent on SNGaming's TTT servers.<br/>";
echo "<br />The highest score on the server is: " . $topscorefinal . ",  held by " . $topscorenick . "! Think you can beat him?";
}


if ($statType == 'time' or $statType == 'all'){
echo"<h3>Top 10 Play Time</h3><table border ='1' class='stattable'><tr><th>Nickname</th><th>Playtime(hours, minutes, seconds)</th></tr>";



while($row1 = mysql_fetch_array( $top10Time )) {
		$seconds1 = $row1['playtime'];
			//start of math for hourse, minues and seconds
				$hours1 = floor($seconds1 / (60 * 60));
 
			// extract minutes
				$divisor_for_minutes1 = $seconds1 % (60 * 60);
				$minutes1 = floor($divisor_for_minutes1 / 60);
 
			// extract the remaining seconds
				$divisor_for_seconds1 = $divisor_for_minutes1 % 60;
				$seconds1 = ceil($divisor_for_seconds1);
	
	
	
	
	echo "<tr><td>"; 
	echo $row1['nickname']; 
	echo "</td><td>";
	echo "H:" . $hours1 . " M:" . $minutes1 . " S:" . $seconds1 . "";
	echo "</td></tr>";
} 

echo "</table>";
}
if ($statType == 'score' or $statType == 'all'){
echo"<h3>Top 10 Score</h3><table border ='1' class='stattable'><tr><th>Nickname</th><th>Score</th></tr>";

while($row2 = mysql_fetch_array( $top10Score )) {
		
	echo "<tr><td>"; 
	echo $row2['nickname']; 
	echo "</td><td> " . $row2['maxfrags'] . "</td> </tr>";
	
} 
echo "</table>";
}
if ($statType == 'deaths' or $statType == 'all'){
echo"<h3>Top 10 Deaths</h3><table border ='1' class='stattable'><tr><th>Nickname</th><th>Deaths</th></tr>";


while($row3 = mysql_fetch_array( $top10Deaths )) {
		
	echo "<tr><td>"; 
	echo $row3['nickname']; 
	echo "</td><td> " . $row3['deaths'] . "</td> </tr>";
} 
echo "</table>";
}
if ($statType == 'kills' or $statType == 'all'){
echo"<h3>Top 10 Kills</h3><table border ='1'class='stattable'><tr><th>Nickname</th><th>Kills</th></tr>";


while($row4 = mysql_fetch_array( $top10Kills )) {
		
	echo "<tr><td>"; 
	echo $row4['nickname']; 
	echo "</td><td> " . $row4['kills'] . "</td></tr>";
	
} 
echo "</table>";
}
if ($statType == 'headshots' or $statType == 'all'){
echo"<h3>Top 10 Head-Shots</h3><table border ='1' class='stattable'><tr><th>Nickname</th><th>Headshots</th></tr>";


while($row5 = mysql_fetch_array( $top10Head )) {
		
	echo "<tr><td>"; 
	echo $row5['nickname']; 
	echo "</td><td> " . $row5['headshots'] . "</td></tr>";
	
} 
echo "</table>";
}

if ($statType == 'points' or $statType == 'all'){
echo"<h3>Top 10 Points</h3><table border ='1' class='stattable'><tr><th>Nickname</th><th>Points</th></tr>";


while($row5 = mysql_fetch_array( $top10Points )) {
		
	echo "<tr><td>"; 
	echo $row5['nickname']; 
	echo "</td><td> " . $row5['points'] . "</td></tr>";
	
} 
echo "</table>";
}

if ($statType == 'kdr' or $statType == 'all'){
echo"<h3>Top 10 KDR ( " . $deathLimit . " deaths & " . $statHours . " Hours of playtime before tracked.)</h3><table border ='1' class='stattable'><tr><th>Nickname</th><th>K/D Ratio</th></tr>";

while($row6 = mysql_fetch_array( $top10KDR )) {
		
	echo "<tr><td>"; 
	echo $row6['nickname']; 
	echo "</td>";
	echo "<td> " . $row6['KDR'] . "</td></tr>";
	
} 
echo "</table>";
}
echo "</div>";
include("./includes/footer.php");
?>
