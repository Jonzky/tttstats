<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
		<link href="css/main.css" media="screen" rel="stylesheet" type="text/css" />
		<?php
		echo "<script type='text/javascript' src='scripts/script.js'></script>";
		?>
		<title>nah14@aber.ac.uk</title>
	</head>
			<body>
				<div id="page">

				<div id="logo">
				<img src="images/game-store-logo-1.png" alt="The Hidden Game Store"/>
				</div>
						<div id='login'>
					<?php 
						//If we've got a username welcome them and offer logout, else offer login.
						if (isset($_SESSION['username'])){
							echo "Welcome, " . $_SESSION['username'] . ". " . "<a href='logout.php'>logout</a>";
							}
						else{
							echo "Welcome, would you like to " . "<a href='index.php'>login?</a>";
							}
							?>
					</div>
					<div id="navigation">
					<a href="index.php">Home</a>	<a href="about.php">About</a>	
					<?php 
					//because we re-direct them if they're not logged in, lets stop them from seeing basket and shop.
					if (isset($_SESSION['username'])){
							echo "<a href='basket.php'>Basket</a> ";
							echo "<a href='shop.php'>Shop</a>";
							}
							?>
					</div>