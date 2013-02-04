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
//include("/includes/header.php");

/*SQL connection/ configuration goes here */

$connect = mysql_connect("127.0.0.1", "handyman_ttt", "3213560921*+*");
$db_select = mysql_select_db('handyman_ttt_stats');
if (!connect) {

	die('ERROR, Contact Handy_man immediately' . mysql_error());
	
}

/*SQL connection/ configuration end here */

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
echo "Total number of kills: " . $killstotal . "</br>";

echo "Total number of time played between all players is: " . $hours . " Hours " . $minutes . " Minutes and " . $seconds . " seconds. </br>";
echo "The highest score on the server is: " . $topscorefinal . " This is held by " . $topscorenick . " think you can beat him? </br>";

?>