<?PHP
require("./includes/session_start.php");
include("./includes/config.php");




// username and password sent from form
$myusername=$_POST['myusername'];
$mypassword=$_POST['mypassword'];
$myemail=$_POST['myemail'];

// To protect MySQL injection (more detail about MySQL injection)
$myusername = mysql_real_escape_string($myusername);
$mypassword = mysql_real_escape_string($mypassword);
$myemail = mysql_real_escape_string($myemail);
$encrypted_mypassword=md5($mypassword);

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
$check = mysql_query("INSERT INTO `handyman_ttt_stats`.`admin_users` (`ID`, `email`, `user`, `pass`, `last_login`, `last_ip`) VALUES (NULL, '$myemail', '$myusername', MD5('$mypassword'), '0000-00-00 00:00:00', '127.0.0.1')");
header('Location: http://' . $_SERVER['HTTP_HOST'] . '/ttt_stats/login.php');
}

?>