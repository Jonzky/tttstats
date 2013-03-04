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

<script type="text/javascript" language="JavaScript">
<!--
//--------------------------------
// This code compares two fields in a form and submit it
// if they're the same, or not if they're different.
//--------------------------------
function checkEmail(theForm) {
    if (theForm.myusername.value != theForm.myusername2.value )
    {
        alert('These Usernames don\'t match!');
        return false;
    } else if (theForm.mypassword.value != theForm.mypassword2.value ) 
	{
		alert('These Passwords don\'t match!');
        return false;
	} else	
	{
		return true;
    }
}
//-->
</script> 

<form name="form1" method="post" action="checkregister.php" onsubmit="return checkEmail(this);">

<p class="center">
<strong>Member Registration</strong><br/>
<strong>Username :</strong>
<input name="myusername" type="text" id="myusername" required>
<br/>
<strong>Repeat Username :</strong>
<input name="myusername2" type="text" id="myusername2" required>
<br/>
<strong>Password :</strong>
<input name="mypassword" type="password" id="mypassword" required>
<br/>
<strong>Repeat Password :</strong>
<input name="mypassword2" type="password" id="mypassword2" required>
<br/>
<button class='button' type='submit'>Register</button>
</form>
</p>
<?PHP include("./includes/footer.php");?>