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
if($servers_enabled == true){	
include("./includes/config.php");
/*Setup variables for SQL statements */
$time = time();
$update_time = 240;
$longAgo = $time - $update_time;
$server_list = mysql_query("SELECT * FROM `server_track` WHERE `lastupdate` >= '$longAgo'");

/*print statements */

echo"<p class='noexist'>This is a live list of the game servers running the server tracker module!</p><table border ='0' class='servertable'><tr><th>Hostname</th><th>Players</th><th>Current Map</th><th>Connect to server</th></tr>";

while($row2 = mysql_fetch_array( $server_list )) {
		
	echo "<tr><td>"; 
	echo $row2['hostname']; 
	echo "</td><td> " . $row2['players'] . "/ " . $row2['maxplayers'] . "</td>";
	echo "<td> " . $row2['map'] . "</td>";
	echo "<td> <form action='steam://connect/" . $row2['hostip'] . "'><button class='button' type='submit'>Connect</button></form> </td>";
	echo "</tr>";
	
} 


echo "</table>";
}
else{
echo "<p class='center'>Servers has been disabled by the system administrator.</p>";
}
include("./includes/footer.php");
?>
