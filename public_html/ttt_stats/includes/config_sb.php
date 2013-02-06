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

/*SQL connection/ configuration goes here */

$connect_sb = mysql_connect("127.0.0.1", "handyman_ttt", "3213560921*+*");
$db_select = mysql_select_db('handyman_sbans');
if (!connect_sb) {

	die('ERROR, Contact Handy_man immediately' . mysql_error());
	
}

/*SQL connection/ configuration end here */

?>