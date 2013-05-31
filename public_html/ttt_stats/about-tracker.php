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
	<p><img src="./static/images/ttt_logo.png" alt="Trouble in terrorist town!" /></p>
	<p>Welcome to the About page for the Trouble in Terrorist Town Stat Tracker! The TTT Stat Tracker is currently in development and not ready for any kind of final release.
	Although it's not ready you can still freely see and download the code on the <a href="https://github.com/Jonzky/tttstats">GitHub page</a>.</p>
	
	<p>The project currently only has 2 developers working in their spare time to make this add-on to the popular Garry's Mod gamemode Trouble in Terrorist Town. If you want to learn more about Trouble in Terrorist Town please see these links. <a href="http://ttt.badking.net/">TTT Homepage</a> <a href="http://www.moddb.com/mods/trouble-in-terrorist-town">MOD DB</a><p>
	<p>The Stat Tracker currently tracks the following stats for every player in the server: SteamID, Nickname, Playtime, Rounds played, Number of times Innocent, Detective & Traitor, Deaths, Kills, Highest score (per map/ session), First time seen on the server.</p>

<p>There are a few other stats that are being planned to be tracked but are not currently in implementation, these include: Points (custom point system to be determined based on kills, deaths, innocent vs. innocent kills etc becoming a large persistent number).</p>

<p>There are also plans to implement in the search bar the number of bans a user has incurred on the server, this interfaces with SourceBans as it's the ban method used by <a href="http://www.sngaming.org">SNGaming.org</a> and will be included on release as an optional feature.</p>

<p>Please support the TTT Tracker! Donations are most welcome </p>
	<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
">
<input type="image" src="https://www.paypalobjects.com/en_US/GB/i/btn/btn_donateCC_LG.gif" name="submit" alt="PayPal — The safer, easier way to pay online.">
<img alt="" border="0" src="https://www.paypalobjects.com/en_GB/i/scr/pixel.gif" width="1" height="1">
</form>
	</div>
<?PHP include("./includes/footer.php");?>
