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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
		<meta name="description=" content="Trouble in Terrorist Town Stat tracker, provides a series of Stats for game servers running the popular TTT Gamemode for Garry's Mod.">
		<meta name="author" content="Nathan Hand, www.thehiddennation.com">
		<meta name="keywords" content="TTT, Trouble in terrorist town, Garry's mod, Gmod, TTTS, Stats, TTTStats, Stat Tracker, thehiddennation, Innocent, Detective, Traitor, Steam, valve, sngaming.org, sky-netgaming.com, skynet, gameservers, tracking">
		<link href="static/main.css" media="screen" rel="stylesheet" type="text/css" />
		<title>[TTTS] Trouble in Terrorist Town Stats</title>
	</head>
			<body>
				<div id="page">
				
			

				<div id="logo">
				<a href="http://www.sngaming.org"><img src="./static/images/skynet_logo.png" alt="www.sngaming.org" title="www.sngaming.org"/></a>
				</div>
						<div id='search'>
							<a href="http://www.facebook.com/sngaming2013"><img src="./static/images/iconFacebook.png" alt="Follus us on Facebook" title="Follow us on Facebook"/></a>
							<a href="http://www.twitter.com/skynet_gaming"><img src="./static/images/iconTwitter.png" alt="Follus us on Twitter" title="Follow us on Twitter"/></a>
							<a href="http://www.youtube.com/SkyNetNation"><img src="./static/images/iconYoutube.png" alt="Subscribe to us on YouTube" title="Subscribe to us on YouTube"/></a>
							<a href="http://steamcommunity.com/groups/Sky-NetGaming"><img src="./static/images/iconSteam.png" alt="Join our Steam group!" title="Join our Steam group!"/></a>
							<a href="http://twitch.tv/skynetgaming"><img src="./static/images/iconTwitch.png" alt="Follow us on Twitch!" title="Follow us on Twitch!"/></a>
							
							
						</div>
					
					<nav>
						<ul>
						<li>
						<a href="index.php">Home</a>
						</li>

						<li>
							<a href="#">About</a>
							<ul>
								<li><a href="about-tracker.php">The Tracker</a></li>
								<li><a href="about-team.php">Meet the team</a></li>
							</ul>
						</li>
						<li>
							<a href="stats.php">Stats</a>
						</li>
						<li>
							<a href="#">Search</a>
							<ul>
							<li><a href="search.php">All</a></li>
							<li><a href="admin.php">Admins</a></li>
							<li><a href="reports.php">Reports</a></li>
							</ul>
						</li>
						<li>
							<a href="#">Resources</a>
							<ul>
							<li><a href="http://www.thehiddennation.com/maplistttt/index.php">Maps</a></li>
							</ul>
						</li>
							<li>
							<?PHP if (isset($_SESSION['myusername'])){
							echo "<a href='./control/index.php'>Control</a>";
							}
							else{
							echo "<a href='login.php'>Login</a>";
							}
							?>
							</li>
						</li>
						</ul>
					</nav>
					