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

$check = mysql_query("SELECT * FROM admin_users WHERE email='$myemail'");
$users = mysql_num_rows($check);


if ($users == 1){
$to = $_POST['email'];

while($playerarray = mysql_fetch_array( $check )) {
$theusername = $playerarray['user'];
}
$subject = '[TTT STATS] Username reminder';

$message = "Automated message from " . $_SERVER['HTTP_HOST'] . "/ttt_stats

Your username was requested to be re-sent to your e-mail address listed for the TTT Stat tracker!

Your username from TTT stats is as follows:" . $theusername . "

Thanks,

[TTT STAT TACKER] - " . $_SERVER['HTTP_HOST'] . "/ttt_stats";



$headers = 'From: no-reply@' . $_SERVER['HTTP_HOST'] . '' . "\r\n" .
    'Reply-To: no-reply@' . $_SERVER['HTTP_HOST'] . '' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers);
echo "<p class ='noexist'>Success! e-mail sent to " . $to . "</p>";
}
else{
echo "<p class ='noexist'>That E-mail address doesn't exist! are you sure you're <a href='./register.php'>registered</a>?</p>";
}

}
else{

}
echo "<form action='".$_SERVER['PHP_SELF']."' method='post'>";

?>

<p class="center">
<strong>Forgotten your username?</strong><br/>
<strong>Please enter your e-mail address</strong>
<input name="email" type="text" id="email" required>
<button class='button' type='submit'>send</button>
</form>

<?PHP
if ($register_enabled == true){ echo"<p class='center'>Have no login? Why not try and <a href='register.php'>register</a>?</p>";}
?>
</p>
<?PHP include("./includes/footer.php");?>