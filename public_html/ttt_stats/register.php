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
</p>
<span class="centerLongUser">Username :</span>
<input name="myusername" type="text" id="myusername" required>
<br/>
<span class="centerShort">Repeat Username :</span>
<input name="myusername2" type="text" id="myusername2" required>
<br/>
<span class="centerLong">Password :</span>
<input name="mypassword" type="password" id="mypassword" required>
<br/>
<span class="centerShortPass">Repeat Password :</span>
<input name="mypassword2" type="password" id="mypassword2" required>
<br/>
<p class="center">
<button class='button' type='submit'>Register</button>
</form>
</p>
<?PHP include("./includes/footer.php");?>