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
?>
				<div class="clearfooter">
				</div>
				</div>
			
			
				<div class="siteFooter">
				<div class="center">
							<?PHP
							if(isset($facebook_link) && $facebook_link != ""){
							echo "<a href='http://www.facebook.com/" . $facebook_link . "'><img src='./static/images/iconFacebook.png' alt='Follus us on Facebook' title='Follow us on Facebook'/></a>";
							}
							if(isset($twitter_link) && $twitter_link != ""){
							echo "<a href='http://www.twitter.com/" . $twitter_link . "'><img src='./static/images/iconTwitter.png' alt='Follus us on Twitter' title='Follow us on Twitter'/></a>";
							}
							if(isset($youtube_link) && $youtube_link != ""){
							echo "<a href='http://www.youtube.com/" . $youtube_link . "'><img src='./static/images/iconYoutube.png' alt='Subscribe to us on YouTube' title='Subscribe to us on YouTube'/></a>";
							}
							if(isset($steam_link) && $steam_link != ""){
							echo "<a href='http://steamcommunity.com/groups/" . $steam_link . "'><img src='./static/images/iconSteam.png' alt='Join our Steam group!' title='Join our Steam group!'/></a>";
							}
							if(isset($twitch_link) && $twitch_link != ""){
							echo"<a href='http://twitch.tv/" . $twitch_link . "'><img src='./static/images/iconTwitch.png' alt='Follow us on Twitch!' title='Follow us on Twitch!'/></a>";
							}
							?>
				</div>
				</div>
		</body>
</html>