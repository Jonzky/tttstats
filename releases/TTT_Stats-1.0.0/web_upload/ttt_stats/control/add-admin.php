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


if (isset($_SESSION['failedReg'])){
echo "<script type='text/javascript' language='JavaScript'> alert('That Username or E-mail address already exists!')</script>";
session_destroy();
}

?>

<script type="text/javascript" language="JavaScript">
<!--
//--------------------------------
// This code compares two fields in a form and submit it
// if they're the same, or not if they're different.
//--------------------------------
function checkEmail(theForm) {	
    if (theForm.password.value != theForm.password2.value )
    {
        alert('These Passwords don\'t match!');
        return false;
    }else	
	{
		return true;
    }
}
//-->
</script> 

<p class="center">
<strong>Add a new Admin</strong><br/>
</p>

<form action='add-admin-process.php' method='post' onsubmit='return checkEmail(this);'>
<span class="formData">Admin Login</span>
<input name="nick" type="text" id="nick" placeholder="Example: Handy_man">
<br/>
<span class="formData">Admin SteamID</span>
<input name="steamID" type="text" id="steamID" placeholder="STEAM_0:">
<br/>
<span class="formData">Admin E-mail</span>
<input name="e-mail" type="text" id="e-mail" placeholder="admin@gmail.com">
<br/>
<span class="formData">Admin Password</span>
<input name="password" type="password" id="password" placeholder="Password">
<br/>
<span class="formData">Repeat Password</span>
<input name="password2" type="password" id="password2" placeholder="Repeat password">
<br/>
<span class="formData">Admin Type</span>
<select name="admin">
<option value="admin">Admin</option>
<option value="superAdmin">Super Admin</option>
</select>
<br/>

<p class="center">
<button class='button' type='submit'>Add new Admin</button>

</form>
</p>

<?PHP
include("./includes/footer.php");
?>
