<?php
/*------------------------\
|        TTT STATS        |
|	       Beta           |
|=========================|
|© 2013 SNGaming.org      |
|	All Rights Reserved   |
|=========================|
| 	Example databse       |
| 	   beta testing       |
| 	   by Handy_man       |
\------------------------*/

/*SQL connection/ configuration goes here 
change file name to config.php or change the include commands in every php file where required */

$connect = mysql_connect("hostname/url", "username", "password");
$db_select = mysql_select_db('databasename');
if (!connect) {

	die('ERROR,' . mysql_error());
	
}

/*SQL connection/ configuration end here */

?>