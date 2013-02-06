<?php
include("header.php");
?>
							<div id="primary_content">
							<?php 
							//If we have a username, welcome them to the site else show the login form.
							if (isset($_SESSION['username'])){
							echo "Welcome to The Hidden Game Store " . $_SESSION['username'] . " would you like to view our games on sale? </br> ";
							echo "<a href='shop.php'>";
							echo "<img src='images/shop-button.png' alt='shop button' />";
							echo "</a>";
							}
							else
							echo "<form action='login.php' method='post' onsubmit='return checkLogin(this);'><p>Username : <input type='text' name='username' size='30'/> <input type='image' src='images/login-button.png' value='Login'/></p> </form>";
							
							//if we've been sent back to this page from our shop, checkout or basket then execture our JS to tell them why.
							if (isset($_SESSION['loginfailed'])){
							echo "<script LANGUAGE='JavaScript'>";
							echo "window.alert('Please login before going any further.')";
							//Setting this back to null so we don't alert everytime they come onto the index.php page unless coming from our basket, checkout or shop page.
							$_SESSION['loginfailed'] = null;
							echo "</script>";
							}
							
							if (isset($_SESSION['totalfailed'])){
							echo "<script LANGUAGE='JavaScript'>";
							echo "window.alert('Please have something in your basket before trying to checkout.')";
							$_SESSION['totalfailed'] = null;
							echo "</script>";
							}
							?>
						</div>
				<?PHP include("footer.php");?>
