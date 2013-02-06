<?php
/*------------------------\
|        TTT STATS        |
|	       Beta           |
|=========================|
|© 2013 SNGaming.org      |
|	All Rights Reserved   |
|=========================|
| 	Website printout      |
| 	   beta testing       |
| 	   by Handy_man       |
\------------------------*/
include("./includes/header.php");

/*Stats SQL queries all go here */

$var1 = mysql_query('SELECT * FROM `ttt_stats');
$uniqueusers = mysql_num_rows($var1);

$kills = mysql_query('SELECT SUM(kills) FROM ttt_stats');
$killsarray = mysql_fetch_array($kills);
$killstotal = array_sum($killsarray);

$innocent = mysql_query('SELECT SUM(innocenttimes) FROM ttt_stats');
$innocentarray = mysql_fetch_array($innocent);
$innocenttotal = array_sum($innocentarray);

$traitor = mysql_query('SELECT SUM(traitortimes) FROM ttt_stats');
$traitorarray = mysql_fetch_array($traitor);
$traitortotal = array_sum($traitorarray);

$detective = mysql_query('SELECT SUM(detectivetimes) FROM ttt_stats');
$detectivearray = mysql_fetch_array($detective);
$detectivetotal = array_sum($detectivearray);

$death = mysql_query('SELECT SUM(deaths) FROM ttt_stats');
$deatharray = mysql_fetch_array($death);
$deathtotal = array_sum($deatharray);

$kills = mysql_query('SELECT SUM(kills) FROM ttt_stats');
$killsarray = mysql_fetch_array($kills);
$killstotal = array_sum($killsarray);

$time = mysql_query('SELECT SUM(playtime) FROM ttt_stats');
$timearray = mysql_fetch_array($time);
$timetotal = array_sum($timearray);

$topscore = mysql_query("SELECT * FROM `ttt_stats` ORDER BY `ttt_stats`.`maxfrags` DESC LIMIT 0, 1");
$topscorearray = mysql_fetch_array ( $topscore );
$topscorefinal = $topscorearray['maxfrags'];
$topscorenick = $topscorearray['nickname'];

$top10Time = mysql_query("SELECT * FROM `ttt_stats` ORDER BY `ttt_stats`.`playtime` DESC LIMIT 0, 10 ");
$top10Score = mysql_query("SELECT * FROM `ttt_stats` ORDER BY `ttt_stats`.`maxfrags` DESC LIMIT 0, 10 ");
$top10Deaths = mysql_query("SELECT * FROM `ttt_stats` ORDER BY `ttt_stats`.`deaths` DESC LIMIT 0, 10 ");
$top10Kills = mysql_query("SELECT * FROM `ttt_stats` ORDER BY `ttt_stats`.`kills` DESC LIMIT 0, 10 ");

$rounds = mysql_query('SELECT SUM(roundsplayed) FROM ttt_stats');
$roundsarray = mysql_fetch_array($rounds);
$roundstotal = array_sum($roundsarray);

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

echo "Number of unique users : " . $uniqueusers . "</br>";
echo "Total number of kills : " . $killstotal . "</br>";
echo "Total number of innocents : " . $innocenttotal . "</br>";
echo "Total number of detectives : " . $detectivetotal . "</br>";
echo "Total number of traitors : " . $traitortotal . "</br>";
echo "Total number of deaths : " . $deathtotal . "</br>";
//echo "Total number of rounds played : " . $roundstotal . "</br>"; //bad stat, multiple players can play the same round thus it's untrue.

echo "Total number of time played between all players is: " . $hours . " Hours " . $minutes . " Minutes and " . $seconds . " seconds. </br>";
echo "The highest score on the server is: " . $topscorefinal . " This is held by " . $topscorenick . " think you can beat him? </br>";

?>
<h3>Top 10 play time</h3>
<table border ="1">
						<tr>
						<th>Nickname</th>
						<th>Playtime(hours, minutes, seconds)</th>
						</tr>

<?
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
?>

<h3>Top 10 Score</h3>
<table border ="1">
						<tr>
						<th>Nickname</th>
						<th>Score</th>
						</tr>

<?
while($row2 = mysql_fetch_array( $top10Score )) {
		
	echo "<tr><td>"; 
	echo $row2['nickname']; 
	echo "<td> " . $row2['maxfrags'] . "</td>";
	
} 
echo "</table>";
?>

<h3>Top 10 Deaths</h3>
<table border ="1">
						<tr>
						<th>Nickname</th>
						<th>Deaths</th>
						</tr>

<?
while($row3 = mysql_fetch_array( $top10Deaths )) {
		
	echo "<tr><td>"; 
	echo $row3['nickname']; 
	echo "</td><td>";
	echo "" . $row3['deaths'] . "";
	echo "</td></tr>";
	
} 
echo "</table>";
?>

<h3>Top 10 Kills</h3>
<table border ="1">
						<tr>
						<th>Nickname</th>
						<th>Kills</th>
						</tr>

<?
while($row4 = mysql_fetch_array( $top10Kills )) {
		
	echo "<tr><td>"; 
	echo $row4['nickname']; 
	echo "<td> " . $row4['kills'] . "</td>";
	
} 
echo "</table>";

include("./includes/footer.php");
?>