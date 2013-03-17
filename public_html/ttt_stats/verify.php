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
include("./includes/config.php");

if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){  
$adminEmail = $_GET['email'];
$adminHash = $_GET['hash'];
$adminEmail = mysql_real_escape_string($adminEmail);
$adminHash = mysql_real_escape_string($adminHash);

$search = mysql_query("SELECT * FROM `admin_users` WHERE `email` = '$adminEmail' AND `hash` = '$adminHash' AND `active` = 0")or die(mysql_error());   
$results = mysql_num_rows($search);  

if ($results == 1){
$search = mysql_query("UPDATE `handyman_ttt_stats`.`admin_users` SET `last_login` = now(), `active` = '1' WHERE `admin_users`.`email` = '$adminEmail'");
echo "<p class ='noexist'>Your account is now active, please login at the <a href='./login.php'>login</a> page</p>";
}
else{
echo "<p class ='noexist'>Your account is already active!</p>";
}


}
else{
echo "Invalid!";
}
?>





<?PHP include("./includes/footer.php");?>