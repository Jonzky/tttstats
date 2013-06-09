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
include("./includes/config.php");
if (isset($_SESSION['myusername'])){
$myusername = $_SESSION['myusername'];
$check = mysql_query("SELECT * FROM admin_users WHERE user='$myusername'");
while($playerarray = mysql_fetch_array( $check )) {
$plySteamID = $playerarray['steamID'];
$plyAdmin = $playerarray['isadmin'];
}
$_SESSION['steamid'] = $plySteamID;
$_SESSION['isadmin'] = $plyAdmin;
}
else{
header('Location: http://' . $_SERVER['HTTP_HOST'] . '/ttt_stats/nologin.php');
}
$adminLevel = $_SESSION['isadmin']; //0 is non admin, 1 = admin and 2 = superadmin


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
						<a href="#">Home</a>
							<ul>
							<li><a href="../index.php">Normal home</a></li>
							<li><a href="./index.php">Admin home</a></li>
							</ul>
						</li>
						<li>
							<a href="#">Account</a>
							<ul>
							<li><a href="account.php">Edit account</a></li>
							</ul>
						</li>
						<?PHP
						if(isset($adminLevel)){
							if($adminLevel >= 1){
						echo	"<li>";
						echo	"<a href='#'>control</a>";
						echo	"<ul>";
						echo	"<li><a href='control-reports.php'>Reports</a></li>";
						echo	"</ul>";
						echo	"</li>";
						}
						}
						if(isset($adminLevel)){
							if($adminLevel == 2){
								echo "<li>";
								echo "<a href='#'>Admin</a>";
								echo "<ul>";
								echo "<li><a href='add-admin.php'>Add Admin</a></li>";
								echo "<li><a href='list-admin.php'>List Admins</a></li>";
								echo "<li><a href='settings.php'>Settings</a></li>";
								echo "</ul>";
								echo "</li>";
							}
						}
						?>
						<li>
						<a href="logout.php">logout</a>
						</li>
						</ul>
					</nav>
					