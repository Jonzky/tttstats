<?php
/*------------------------\
|        TTT STATS        |
|	   Beta           |
|=========================|
|? 2013 SNGaming.org      |
|   All Rights Reserved   |
|=========================|
|   Website printout      |
|      beta testing       |
|      by Handy_man       |
\------------------------*/
include("./includes/superonly.php");
include("./includes/header.php");




$editID = $_POST['adminID'];

$editingAdmin = mysql_query("SELECT * FROM `admin_users` WHERE `ID` = '$editID'");
?>
<?
while($adminArrayEdit = mysql_fetch_array( $editingAdmin )) {
$adminID = $adminArrayEdit['ID'];
$adminEmail = $adminArrayEdit['email'];
$adminUsername = $adminArrayEdit['user'];
$adminLast = $adminArrayEdit['last_login'];
$adminIP = $adminArrayEdit['last_ip'];
$adminSID = $adminArrayEdit['steamID'];
$adminType = $adminArrayEdit['isadmin'];
}
//Lets setup our current value for admin.
if ($adminType == 0){
$adminType = "noadmin";
}
else if ($adminType == 1){
$adminType = "admin";
}
else{
$adminType = "superAdmin";
}
?>

<p class="center">
<strong>Edit Admin</strong><br/>
</p>

<form action='edit-admin-process.php' method='post' onsubmit='return checkEmail(this);'>
<input type='hidden' name='ID' id='ID' value="<?PHP echo $adminID;?>">
<span class="formData">Admin Login</span>
<input name="nick" type="text" id="nick" value="<?PHP echo $adminUsername;?>">
<br/>
<span class="formData">Admin E-mail</span>
<input name="e-mail" type="text" id="e-mail" value="<?PHP echo $adminEmail;?>">
<br/>
<span class="formData">Admin SteamID</span>
<input name="steamID" type="text" id="steamID" value="<?PHP echo $adminSID;?>">
<br/>
<span class="formData">Admin Type</span>
<select name="admin">
<?PHP if ($adminType == "noadmin"){echo "selected='selected'";}?>
<option value="noadmin" <?PHP if ($adminType == "noadmin"){echo "selected='selected'";}?>>None</option>
<option value="admin" <?PHP if ($adminType == "admin"){echo "selected='selected'";}?>>Admin</option>
<option value="superAdmin" <?PHP if ($adminType == "superAdmin"){echo "selected='selected';";}?>>Super Admin</option>
</select>
<br/>

<p class="center">
<button class='button' type='submit'>Edit user</button>

</form>
</p>


<?PHP
include("./includes/footer.php");
?>
