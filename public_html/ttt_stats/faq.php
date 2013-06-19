<?php 
/*------------------------\
|        TTT STATS        |
|          Beta           |
|=========================|
|� 2013 SNGaming.org      |
|   All Rights Reserved   |
|=========================|
|   Website printout      |
|      beta testing       |
|      by Handy_man       |
\------------------------*/				

include("./includes/header.php");
?>
	<div id="primary_content_about">
	<h3>The FAQ</h3>
	
	<p><b>Q:</b>How can i get the vbulliten side block as seen on sngaming.org's forum?</br>
	<b>A:</b>Check your download, all the code for that sideblock is seen in the ttt_stats folder under the name vb_module_example.dat</p>
	
	
	<p><b>Q:</b>I'm pretty sure that i've set everything up correctly, but i still don't see any stats on my website what could be wrong?</br>
	<b>A:</b>Most website hosts limit remoteSQL interaction based on your IP address, not allowing users to connect to the SQL databse unless they're on the IP address whitelist. Make sure that your server is on this whitelist so that your gameserer can talk to your webSQL.</br>
	<b>A:</b>Have you given your MYSQL user the correct permissions? Test out giving them all permissions and see what happens.</p>
	
	
	</div>
<?PHP include("./includes/footer.php");?>
