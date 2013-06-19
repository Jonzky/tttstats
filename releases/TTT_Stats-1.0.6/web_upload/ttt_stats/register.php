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
if ($register_enabled == true){
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

		var x=document.forms["form1"]["myemail"].value;
		var atpos=x.indexOf("@");
		var dotpos=x.lastIndexOf(".");
		if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
		{
		alert("Not a valid e-mail address");
		return false;
		}
	
    if (theForm.myusername.value != theForm.myusername2.value )
    {
        alert('These Usernames don\'t match!');
        return false;
    } else if (theForm.mypassword.value != theForm.mypassword2.value ) 
	{
		alert('These Passwords don\'t match!');
        return false;
	} else if (theForm.myemail.value != theForm.myemail2.value ) 
	{
		alert('These E-mails don\'t match!');
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
<strong>Admin User Registration - if for some reason this fails, it's because you didn't setup the database correctly.</strong><br/>
</p>
<span class="formData">E-mail :</span>
<input name="myemail" type="text" id="myemail" placeholder="E-mail" required>
<br/>
<span class="formData">Repeat E-mail :</span>
<input name="myemail2" type="text" id="myemail2" placeholder="Repeat E-mail" required>
<br/>
<span class="formData">Username :</span>
<input name="myusername" type="text" id="myusername" placeholder="Username" required>
<br/>
<span class="formData">Repeat Username :</span>
<input name="myusername2" type="text" id="myusername2" placeholder="Repeat Username" required>
<br/>
<span class="formData">Password :</span>
<input name="mypassword" type="password" id="mypassword" placeholder="Password" required>
<br/>
<span class="formData">Repeat Password :</span>
<input name="mypassword2" type="password" id="mypassword2" placeholder="Repeat Password" required>
<br/>
<p class="center">
<button class='button' type='submit'>Register</button>
</form>
</p>
<?PHP
}
else{
echo "<p class='center'>Register has been disabled by the system administrator.</p>";
}


 include("./includes/footer.php");?>