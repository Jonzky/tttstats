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

<form name="form1" method="post" action="checklogin.php">

<p class="center">
<strong>Member Login</strong></br>
<strong>Username</strong>
<input name="myusername" type="text" id="myusername">
<strong>Password</strong>
<input name="mypassword" type="text" id="mypassword">
<button class='button' type='submit'>Login</button>
</form>
</p>
<?PHP include("./includes/footer.php");?>