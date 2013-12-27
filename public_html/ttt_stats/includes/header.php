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
include_once("./includes/variables.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
		<meta name="description=" content="Trouble in Terrorist Town Stat tracker, provides a series of Stats for game servers running the popular TTT Gamemode for Garry's Mod.">
		<meta name="author" content="Nathan Hand, www.thehiddennation.com">
		<meta name="keywords" content="TTT, Trouble in terrorist town, Garry's mod, Gmod, TTTS, Stats, statistics, TTTStats, Stat Tracker, thehiddennation, Innocent, Detective, Traitor, Steam, valve, sngaming.org, sky-netgaming.com, skynet, gameservers, tracking">
		<link href="static/main.css" media="screen" rel="stylesheet" type="text/css" />
		<title>[TTTS] Trouble in Terrorist Town Stats</title>
	</head>
			<body>
			<?PHP if ($badge_ref = "www.thehiddennation.com/ttt_stats"){include("analytics2.php");}	?>

				<div id="header">
				  <div>
					<a href="<?PHP echo $base_address; ?>" id="logo"><img src="<?PHP echo $logo_path; ?>" alt="<?PHP echo $base_address; ?>" title="<?PHP echo $base_address; ?>" style="width: 550px; height: 90px;"/></a>
					<?PHP if (isset($_SESSION['myusername'])){ echo "<p class='login'>Welcome, " . $_SESSION['myusername'] . "&nbsp;|&nbsp;<a href='./control'>Control</a>";} elseif ($register_enabled == true){ echo "<p class='login'><a href='./login.php'>Login</a>&nbsp;|&nbsp;<a href='./register.php'>Register</a></p>";} else{echo "<p class='login'><a href='./login.php'>Login</a>"; }?>
				  </div>
				</div>
				
				<div id="page">		
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
								<li><a href="help.php">Help</a></li>
								<li><a href="faq.php">Faq</a></li>
							</ul>
						</li>
						<li>
							<a href="stats.php">Stats</a>
						</li>
						<li>
							<a href="#">Search</a>
							<ul>
							<li><a href="search.php">All</a></li>
							<li><a href="compare.php">Compare</a></li>
							<li><a href="admin.php">Admins</a></li>
							<?PHP
							if ($reports_enabled == true){
							echo "<li><a href='reports.php'>Reports</a></li>";
							}		
							if ($servers_enabled == true){
							echo "<li><a href='servers.php'>Servers</a></li>";
							}
							?>
							
							</ul>
						</li>
						<li>
							<a href="#">Resources</a>
							<ul>
							<li><a href="http://www.thehiddennation.com/maplistttt/index.php">Maps</a></li>
							</ul>
						</li>
						</ul>
					</nav>
					