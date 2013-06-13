<?php
/*------------------------\
|        TTT STATS        |
|	   Beta           |
|=========================|
|� 2013 SNGaming.org      |
|   All Rights Reserved   |
|=========================|
|   Website printout      |
|      beta testing       |
|      by Handy_man       |
\------------------------*/
include("./includes/superonly.php");	
include("./includes/header.php");
include("../includes/variables.php");

//Save our settings! get all the data we're potentially changing!

?>
<div id="primary_content_new">
<h4>Welcome to the settings page, <?PHP echo $_SESSION['myusername'];?></h4>
<p>Here you can update a large number of variables that the ttt_stats relies on.</p>
<form action='./variableUpdate.php' method='post'>
<strong>Sourcebans enable/ disable</strong>
</br>
<input name="sb_enabled" type="radio" value="true" <?PHP if($sb_enabled == true){echo "checked";}?> >Enabled</br>
<input name="sb_enabled" type="radio" value="false" <?PHP if($sb_enabled == false){echo "checked";}?>>Disabled</br>
<strong>Reports enable/ disable</strong>
</br>
<input name="reports_enabled" type="radio" value="true" <?PHP if($reports_enabled == true){echo "checked";}?>>Enabled</br>
<input name="reports_enabled" type="radio" value="false" <?PHP if($reports_enabled == false){echo "checked";}?>>Disabled</br>
<strong>Server online tracker enable/ disable</strong>
</br>
<input name="servers_enabled" type="radio" value="true" <?PHP if($servers_enabled == true){echo "checked";}?>>Enabled</br>
<input name="servers_enabled" type="radio" value="false" <?PHP if($servers_enabled == false){echo "checked";}?>>Disabled</br>
<strong>Badge system enable/ disable</strong>
</br>
<input name="badge_enabled" type="radio" value="true" <?PHP if($badge_enabled == true){echo "checked";}?>>Enabled</br>
<input name="badge_enabled" type="radio" value="false" <?PHP if($badge_enabled == false){echo "checked";}?> >Disabled</br>
<strong>Register enable/ disable</strong>
</br>
<input name="register_enabled" type="radio" value="true" <?PHP if($register_enabled == true){echo "checked";}?>>Enabled</br>
<input name="register_enabled" type="radio" value="false" <?PHP if($register_enabled == false){echo "checked";}?>>Disabled</br>
<strong>Base website url (Link back to your forums)</strong>
</br>
Base URL: <input type="text" name="base_address" <?PHP echo"value=$base_address";?>>
</br>
<strong>Sorucebans search string (all the text in a sourceabans search before the steamid)</strong>
</br>
Sourcebans Search  URL: <input type="text" name="sb_search_build" <?PHP echo"value=$sb_search_build";?>>
</br>
<strong>Badge refference (what url the bottom of the "badge" points to)</strong>
</br>
Badge refference URL: <input type="text" name="badge_ref" <?PHP echo"value=$badge_ref";?>>
</br>
<strong>Primary Logo path</strong>
</br>
Logo path: <input type="text" name="logo_path" <?PHP echo"value=$logo_path";?>>
</br>
<strong>Social media links</strong>
</br>
Facebook.com/: <input type="text" name="facebook_link" <?PHP echo"value=$facebook_link";?>></br>
Twitter.com/: <input type="text" name="twitter_link" <?PHP echo"value=$twitter_link";?>></br>
youtube.com/: <input type="text" name="youtube_link" <?PHP echo"value=$youtube_link";?>></br>
twitch.tv/: <input type="text" name="twitch_link" <?PHP echo"value=$twitch_link";?>></br>
steamcommunity.com/groups/: <input type="text" name="steam_link" <?PHP echo"value=$steam_link";?>>
</br>



<div class="fright">
<button class='button' type='submit'>Apply</button>
</div>
</form>
</div>


<?PHP
include("./includes/footer.php");
?>
