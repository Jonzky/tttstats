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

<form name="form1" method="post" action="checkregister.php">

<p class="center">
<strong>Member Registration</strong><br/>
<strong>Username</strong>
<input name="myusername" type="text" id="u">
<strong>Password</strong>
<input name="mypassword" type="text" id="p">
<button class='button' type='submit'>Login</button>
</form>
</p>
<?PHP include("./includes/footer.php");?>