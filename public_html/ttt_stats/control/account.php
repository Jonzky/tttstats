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
include("./includes/header.php");
include("./includes/config.php");

$plySteamID = $_POST['steamID'];
$myUsername = $_SESSION['myusername']; //we should probably do this by id, but i know we have this in session data and it works the same.

$regex = "/^STEAM_0:[01]:[0-9]{7,8}$/";



if(isset($plySteamID)){
	if(!preg_match($regex, $plySteamID)) {
    echo "<script LANGUAGE='JavaScript'>";
	echo "window.alert('Invalid STEAMID! please try again.')";
	echo "</script>";
	unset($plySteamID);
	}
mysql_query("UPDATE `handyman_ttt_stats`.`admin_users` SET `steamID` = '$plySteamID' WHERE `admin_users`.`user` = '$myUsername'");
}
	

?>
<div id="primary_content">
<h4>Welcome to the account page, <?PHP echo $_SESSION['myusername'];?></h4>
<p>Here you can update details about your personal profile, this will include inserting a steamid as well as many other potential things!</p>

<?PHP echo "<form action='".$_SERVER['PHP_SELF']."' method='post'>";?>
<strong>SteamID</strong>
<input name="steamID" type="text" id="steamID" placeholder="SteamID">


<button class='button' type='submit'>Apply</button>
</form>
</div>
<?PHP
include("./includes/footer.php");
?>
