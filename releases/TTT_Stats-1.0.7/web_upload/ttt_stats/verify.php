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

if(isset($_POST['myemail'])){
$verifyEmail = $_POST['myemail'];
$verifyEmail = mysql_real_escape_string($verifyEmail);
$checkemail = mysql_query("SELECT * FROM admin_users WHERE email='$verifyEmail' AND active = 0");
$usersemail = mysql_num_rows($checkemail);

$checkemailactive = mysql_query("SELECT * FROM admin_users WHERE email='$verifyEmail' AND active = 1");
$usersemailactive = mysql_num_rows($checkemailactive);

if($usersemail==1){ //great they exist, lets send that e-mail with a new hash.
$myHash = md5( rand(0,1000) );
$newHash = mysql_query("UPDATE `admin_users` SET `hash`='$myHash' WHERE `email` = '$verifyEmail'");
$usernameGrab = mysql_query("SELECT * FROM admin_users WHERE email = '$verifyEmail'");
while($userArray = mysql_fetch_array( $usernameGrab )) {
$myusername = $userArray['user'];
}

$to = $verifyEmail;
$subject = '[TTT STATS] Account Verification';

$message = "Automated message " . $_SERVER['HTTP_HOST'] . "/ttt_stats 

Hello, " . $myusername . ". 

Please Verify your account by clicking the following link : http://" . $_SERVER['HTTP_HOST'] . "/ttt_stats/verify.php?email=" . $verifyEmail . "&hash=" . $myHash . "

Thanks,

[TTT STAT TACKER] - " . $_SERVER['HTTP_HOST'] . "/ttt_stats";



$headers = 'From: no-reply@' . $_SERVER['HTTP_HOST'] . '' . "\r\n" .
    'Reply-To: no-reply@' . $_SERVER['HTTP_HOST'] . '' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers);


echo "<p class ='noexist'>Your new verification E-mail has been sent.</p>";
}
else if ($usersemailactive==1){
echo "<p class ='noexist'>Your account is already active!</p>";
}
else{
echo "<p class ='noexist'>That account doesn't exist! are you sure you're <a href='./register.php'>registered</a>?</p>";
}

}

if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){  
$adminEmail = $_GET['email'];
$adminHash = $_GET['hash'];
$adminEmail = mysql_real_escape_string($adminEmail);
$adminHash = mysql_real_escape_string($adminHash);

$search = mysql_query("SELECT * FROM `admin_users` WHERE `email` = '$adminEmail' AND `hash` = '$adminHash' AND `active` = 0")or die(mysql_error());   
$results = mysql_num_rows($search);  

if ($results == 1){
$search = mysql_query("UPDATE `admin_users` SET `last_login` = now(), `active` = '1' WHERE `admin_users`.`email` = '$adminEmail'");
echo "<p class ='noexist'>Your account is now active, please login at the <a href='./login.php'>login</a> page</p>";
}
else{
echo "<p class ='noexist'>Your account is already active!</p>";
}


}
else{ //Lets re-send our verification e-mail if the first one failed for unknown reasons.
echo "<form action='".$_SERVER['PHP_SELF']."' method='post'>";
echo "<p class='center'>";
echo "<strong>Re-send Verification E-mail</strong><br/>";
echo "</p>";
echo "<span class='formData'>E-mail :</span>";
echo "<input name='myemail' type='text' id='myemail' placeholder='E-mail' required>";
echo "<br/>";
echo "<p class='center'>";
echo "<button class='button' type='submit'>re-send</button></form>";
echo "</p>";
}
?>





<?PHP include("./includes/footer.php");?>