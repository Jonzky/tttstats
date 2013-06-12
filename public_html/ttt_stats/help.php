<?php 
/*------------------------\
|        TTT STATS        |
|          Beta           |
|=========================|
|© 2013 SNGaming.org      |
|   All Rights Reserved   |
|=========================|
|   Website printout      |
|      beta testing       |
|      by Handy_man       |
\------------------------*/				

include("./includes/header.php");
?>
	<div id="primary_content_about">
	<h3>Installation Help!</h3>
	
	<h5>The web stuff!</h5>
	
	<p><b>1.</b> Upload the folder "ttt_stats" from the web_upload folder to you webserver, keeping attention that i'm bad and for now it should stay in a folder called "ttt_stats".</p>
	<p><b>2.</b> Create a new database user, give it the normal permissions as well as "create" giving it access to the new database you've setup.</p>
	<p><b>3.</b> goto www.yourwebsitehere/ttt_stats/install/ and follow the forms, paying attention to the fact that you will need your database information.</p>	
	<p><b>4.</b> Once installation has been complete check that you're able to log in with the account you created during installation (Check your e-mail for a verification from the installation.)</p>	
	<p><b>5.</b> Once you've confirmed your ability to log into the control panel, delete the /install directory from your webserver.</p>	
	<p><b>6.</b> If your game server is correctly connecting to this database and saving information you should start to see pages fill up with information.</p>	
		
	<h5>The Game server stuffs!</h5>

	<p><b>1.</b> Upload the folder called "dblogging" located in the game_upload directory to your addons folder for your dedicated server.</p>
	<p><b>2.</b> You will need to download the mysql00 module found <a href="http://www.facepunch.com/threads/933647">HERE</a>Installation instructions for that module can be found on that page. </p>
	<p><b>3.</b> You will need to make a couple of edits to the code to get the results you require for your server. Below follows the list:</p>
	<p><b>3a.</b> goto /dblogging/lua/dbmodules/database/database.lua and change the varialbes seen at the top of the file to your oww (database connection information, as well as current game server's ip address and port)</p>
	<p><b>3b.</b> goto /dblogging/lua/dbmodules/sv Here you will see 4 files (darkRPStats, issueTracker, serverTrack, tttStatTracker) each allow different types of logging, for a ttt server remove darkRPStats.lua issueTracker and serverTrack are addons to the TTT_STATS addon, but not required for it's operation and allow for different features. (/servers and /issue for the client)</p>
	<p><b>3c.</b> goto /dblogging/lua/dbmodules/client/cl_showstats changing the variable "url" to include your own web servers address to the file called "motd.php" so www.yourwebsitehere.com/ttt_stats/motd.php making sure to add the steamid get statement ("motd.php?steamid=%s") this can also be used for your sv_loadingurl configuration.</p>
	<p><b>4.</b> Once all of the above steps have been completed your server is ready for stat tracking!</p>

	
	<br/>						
	</div>
<?PHP include("./includes/footer.php");?>
