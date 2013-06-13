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
mysql_query("UPDATE `admin_users` SET `steamID` = '$plySteamID' WHERE `admin_users`.`user` = '$myUsername'");
}

if(isset($_POST['prevPass']) && isset($_POST['newPass'])){
$prevPass = $_POST['prevPass'];
$prevPass = mysql_real_escape_string($prevPass);
$newPass = $_POST['newPass'];
$newPass = mysql_real_escape_string($newPass);

$check = mysql_query("SELECT * FROM admin_users WHERE user='$myusername' and pass=MD5('$prevPass')");
$users = mysql_num_rows($check);

if ($users == 1){
mysql_query("UPDATE `admin_users` SET `pass` =MD5('$newPass') WHERE `admin_users`.`user` = '$myUsername'");

}
else{
	echo "<script LANGUAGE='JavaScript'>";
	echo "window.alert('Incorrect current password! please enter the correct current password!')";
	echo "</script>";
		unset($prevPass);
		unset($newPass);
		
}
}

if(isset($_POST['prevPassDel']) && isset($_POST['delAccount'])){
$prevPassDel = $_POST['prevPassDel'];
$prevPassDel = mysql_real_escape_string($prevPassDel);
$delAccount = $_POST['delAccount'];

$checkDel = mysql_query("SELECT * FROM admin_users WHERE user='$myusername' and pass=MD5('$prevPassDel')");
$usersDel = mysql_num_rows($checkDel);

if ($usersDel == 1){
mysql_query("DELETE FROM `admin_users` WHERE `admin_users`.`user` = '$myUsername'");
include("./logout.php");
}
else{
	echo "<script LANGUAGE='JavaScript'>";
	echo "window.alert('Incorrect current password! please enter the correct current password!')";
	echo "</script>";
		unset($prevPassDel);
		unset($delAccount);
		
}
}
	

?>
<div id="primary_content">
<h4>Welcome to the account page, <?PHP echo $_SESSION['myusername'];?></h4>
<p>Here you can update details about your personal profile, this will include inserting a steamid as well as many other potential things!</p>

<?PHP echo "<form action='".$_SERVER['PHP_SELF']."' method='post'>";?>
<strong>SteamID</strong>
<input name="steamID" type="text" id="steamID" placeholder="SteamID">
<div class="fright">
<button class='button' type='submit'>Apply</button>
</div>
</form>
</div>
<div id="primary_content_new">
<script type="text/javascript" language="JavaScript">
<!--
//--------------------------------
// This code compares two fields in a form and submit it
// if they're the same, or not if they're different.
//--------------------------------
function checkPass(theForm) {	
    if (theForm.newPass.value != theForm.newPass1.value )
    {
        alert('These Passwords don\'t match!');
        return false;
	}
	else{
		return true;
    }
}
//-->
</script> 

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

<div id="primary_content_new">
<?PHP echo "<form action='".$_SERVER['PHP_SELF']."' method='post'>";?>
<strong>Current password</strong>
<input name="prevPassDel" type="password" id="prevPassDel" placeholder="Current password" style="margin-left: 30px;">
<br/>
<strong>Delete account?</strong>
<input name="delAccount" type="checkbox" id="delAccount" style="margin-left: 55px;">

<div class="fright">
<button class='button' type='submit'>Apply</button>
</div>
</form>
</div>

<?PHP
include("./includes/footer.php");
?>
