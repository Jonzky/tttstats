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
include("./includes/config.php");

//Save our settings! get all the data we're potentially changing!

	
	
//Get current server settings
$settings = mysql_query("SELECT * FROM ttt_settings");

$source = mysql_data_seek($settings, 10);
while($settingsArray = mysql_fetch_array( $settings )) {
$sbEnabled = $settingsArray['value'];
}



?>
<div id="primary_content">
<h4>Welcome to the settings page, <?PHP echo $_SESSION['myusername'];?></h4>
<p>Here you can update a number of details about your stat tracker links.</p>
<?PHP 
//echo $sbEnabled;
echo $source;

?>
<?PHP echo "<form action='".$_SERVER['PHP_SELF']."' method='post'>";?>
<strong>SteamID</strong>
<input name="steamID" type="text" id="steamID" placeholder="SteamID">
<div class="fright">
<button class='button' type='submit'>Apply</button>
</div>
</form>
</div>
<div id="primary_content_new">

<?PHP echo "<form action='".$_SERVER['PHP_SELF']."' method='post' onsubmit='return checkPass(this);'>";?>
<strong>Current password</strong>
<input name="prevPass" type="password" id="prevPass" placeholder="Current password" style="margin-left: 30px;">
<br/>
<strong>New password</strong>
<input name="newPass" type="password" id="newPass" placeholder="New password" style="margin-left: 55px;">
<br/>
<strong>Repeat new password</strong>
<input name="newPass1" type="password" id="newPass1" placeholder="Repeat new password">
<div class="fright">
<button class='button' type='submit'>Apply</button>
</div>
</form>
</div>

<?PHP
include("./includes/footer.php");
?>
