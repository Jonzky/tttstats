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
require("./includes/session_start.php");
session_destroy();
header('Location: http://' . $_SERVER['HTTP_HOST'] . '/ttt_stats');

?>