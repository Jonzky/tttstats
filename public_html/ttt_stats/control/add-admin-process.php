<?PHP
require("./includes/session_start.php");
include("./includes/config.php");




// username and password sent from form
$myusername=$_POST['nick'];
$mypassword=$_POST['password'];
$myemail=$_POST['e-mail'];
$mySteam=$_POST['steamID'];
$myAdminType=$_POST['admin']; //admin or superAdmin please :D 
$myHash = md5( rand(0,1000) );

// To protect MySQL injection (more detail about MySQL injection)
$myusername = mysql_real_escape_string($myusername);
$mypassword = mysql_real_escape_string($mypassword);
$myemail = mysql_real_escape_string($myemail);
$mySteam = mysql_real_escape_string($mySteam);
if($myAdminType == "admin"){
$myAdminType = 1;
}
else if($myAdminType == "superAdmin"){
$myAdminType = 2;
}
else{
$myAdminType = 0;
}

$check = mysql_query("SELECT * FROM admin_users WHERE user='$myusername'");
$users = mysql_num_rows($check);

$checkemail = mysql_query("SELECT * FROM admin_users WHERE email='$myemail'");
$usersemail = mysql_num_rows($checkemail);

if($users==1){
$_SESSION['failedReg'] = true;
header('Location: http://' . $_SERVER['HTTP_HOST'] . '/ttt_stats/control/add-admin.php');
}
else if($usersemail==1){
$_SESSION['failedReg'] = true;
header('Location: http://' . $_SERVER['HTTP_HOST'] . '/ttt_stats/control/add-admin.php');
}
else {
$check = mysql_query("INSERT INTO `handyman_ttt_stats`.`admin_users` (`ID`, `email`, `user`, `pass`, `last_login`, `last_ip`, `steamID`, `isadmin`, `hash`, `active`) VALUES (NULL, '$myemail', '$myusername', MD5('$mypassword'), '0000-00-00 00:00:00', '127.0.0.0', '$mySteam', '$myAdminType', '$myHash', '0')");
header('Location: http://' . $_SERVER['HTTP_HOST'] . '/ttt_stats/login.php');
}

?>