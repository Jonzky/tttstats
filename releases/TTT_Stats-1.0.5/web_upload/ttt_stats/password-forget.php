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

if (isset($_POST['email'])){

$myemail=$_POST['email'];
$myemail = mysql_real_escape_string($myemail);

$check = mysql_query("SELECT * FROM admin_users WHERE user='$myemail'");
$users = mysql_num_rows($check);

function generatePassword($length=9, $strength=8) {
	$vowels = 'aeuy';
	$consonants = 'bdghjmnpqrstvz';
	if ($strength & 1) {
		$consonants .= 'BDGHJLMNPQRSTVWXZ';
	}
	if ($strength & 2) {
		$vowels .= "AEUY";
	}
	if ($strength & 4) {
		$consonants .= '23456789';
	}
	if ($strength & 8) {
		$consonants .= '@#$%';
	}
 
	$password = '';
	$alt = time() % 2;
	for ($i = 0; $i < $length; $i++) {
		if ($alt == 1) {
			$password .= $consonants[(rand() % strlen($consonants))];
			$alt = 0;
		} else {
			$password .= $vowels[(rand() % strlen($vowels))];
			$alt = 1;
		}
	}
	return $password;
}

if ($users == 1){
while($playerarray = mysql_fetch_array( $check )) {
$userID = $playerarray['ID'];
$to = $playerarray['email'];
}
$theusername = $_POST['email'];
$newpassword = generatePassword();

$subject = '[TTT STATS] Password reset!';

$message = "Automated message " . $_SERVER['HTTP_HOST'] . "/ttt_stats 

Hello, " . $theusername . ". 

Your password has been reset for the TTT stat tracker to: ". $newpassword . "

Thanks,

[TTT STAT TACKER] - " . $_SERVER['HTTP_HOST'] . "/ttt_stats";



$headers = 'From: no-reply@' . $_SERVER['HTTP_HOST'] . '' . "\r\n" .
    'Reply-To: no-reply@' . $_SERVER['HTTP_HOST'] . '' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers);
echo "<p class ='noexist'>Success! e-mail sent to " . $to . "</p>";

$check = mysql_query("UPDATE `admin_users` SET `pass` = MD5('$newpassword') WHERE `admin_users`.`ID` ='$userID'");

}
else{
echo "<p class ='noexist'>That username doesn't exist! are you sure you're <a href='./register.php'>registered</a>?</p>";
}

}
else{

}
echo "<form action='".$_SERVER['PHP_SELF']."' method='post'>";

?>

<p class="center">
<strong>Forgotten your password?</strong><br/>
<strong>Please enter your username</strong>
<input name="email" type="text" id="email" required>
<button class='button' type='submit'>send</button>
</form>

<?PHP
if ($register_enabled == true){ echo"<p class='center'>Have no login? Why not try and <a href='register.php'>register</a>?</p>";}
?>
</p>
<?PHP include("./includes/footer.php");?>