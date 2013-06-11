<?PHP
require("../includes/session_start.php");
include("../includes/config.php");




// username and password sent from form
$myusername=$_POST['myusername'];
$mypassword=$_POST['mypassword'];
$myemail=$_POST['myemail'];

// To protect MySQL injection (more detail about MySQL injection)
$myusername = mysql_real_escape_string($myusername);
$mypassword = mysql_real_escape_string($mypassword);
$myemail = mysql_real_escape_string($myemail);
$myHash = md5( rand(0,1000) );
$myAdminType = 2; //we're a superadmin! yay this is our first user and this script will never be used again which is sad.
$mySteam = "N/A";
$check = mysql_query("SELECT * FROM admin_users WHERE user='$myusername'");
$users = mysql_num_rows($check);

$checkemail = mysql_query("SELECT * FROM admin_users WHERE email='$myemail'");
$usersemail = mysql_num_rows($checkemail);

if($users==1){
$_SESSION['failedReg'] = true;
header('Location: http://' . $_SERVER['HTTP_HOST'] . '/ttt_stats/register.php');
}
else if($usersemail==1){
$_SESSION['failedReg'] = true;
header('Location: http://' . $_SERVER['HTTP_HOST'] . '/ttt_stats/register.php');
}
else {
$check = mysql_query("INSERT INTO `admin_users` (`ID`, `email`, `user`, `pass`, `last_login`, `last_ip`, `steamID`, `isadmin`, `hash`, `active`) VALUES (NULL, '$myemail', '$myusername', MD5('$mypassword'), '0000-00-00 00:00:00', '127.0.0.0', '$mySteam', '$myAdminType', '$myHash', '0')");

$to = $myemail;
$subject = '[TTT STATS] Account Verification';

$message = "Automated message " . $_SERVER['HTTP_HOST'] . "/ttt_stats 

Hello, " . $myusername . ". 

Please Verify your account by clicking the following link : http://" . $_SERVER['HTTP_HOST'] . "/ttt_stats/verify.php?email=" . $myemail . "&hash=" . $myHash . "

Please log into your stats system and goto the 'settings' page, all superadmins can access this page and it allows for editing of things like the header image, enable and disable of a couple of features. The linking to various social networking websites under your community etc.

Please delete the installation directory from your web server it is no longer required and anyone could reset your config.php file meaning you'd have to re-do this installation/ manually edit that file back to the correct details.

Thanks,

Handy_man & Jonzky

[TTT STAT TACKER] -http://www.thehiddennation.com/ttt_stats";



$headers = 'From: no-reply@' . $_SERVER['HTTP_HOST'] . '' . "\r\n" .
    'Reply-To: no-reply@' . $_SERVER['HTTP_HOST'] . '' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers);

if (isset($_POST['accept'])){
$to = "administrator@thehiddennation.com";
$subject = '[TTT STATS] Installation!';

$message = "Automated message " . $_SERVER['HTTP_HOST'] . "/ttt_stats 

TTT Stats has been installed somewhere else on the interenet! 

It was installed to the following webserver: " . $_SERVER['HTTP_HOST'] . "

Don't forget to add this to some kind of persistant counter!";

$headers = 'From: no-reply@' . $_SERVER['HTTP_HOST'] . '' . "\r\n" .
    'Reply-To: no-reply@' . $_SERVER['HTTP_HOST'] . '' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers);
}


$_SESSION['verifynow'] = true;
header('Location: http://' . $_SERVER['HTTP_HOST'] . '/ttt_stats/login.php');
}

?>