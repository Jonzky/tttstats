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
?>
							<div id="primary_content">
							<p>Welcome! <?PHP echo $_SESSION['myusername'];?>, this is the control section of TTT Stat Tracker. This section is in very early stages of production and as such might have broken things about it.</p>
							<p>Your current steamid is: <?PHP echo $_SESSION['steamid'];?>, </p>
							<p>Your current admin status is: <?PHP echo $_SESSION['isadmin'];?>, </p>
							</div>
				<?PHP include("./includes/footer.php");?>
