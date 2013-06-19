<?PHP
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

require("./includes/session_start.php");

include("./includes/config.php");

// username and password sent from form
$myusername=$_POST['u'];
$mypassword=$_POST['p'];

// To protect MySQL injection (more detail about MySQL injection)
$myusername = mysql_real_escape_string($myusername);
$mypassword = mysql_real_escape_string($mypassword);

$check = mysql_query("SELECT * FROM admin_users WHERE user='$myusername' and pass=MD5('$mypassword')");
$users = mysql_num_rows($check);
while($playerarray = mysql_fetch_array( $check )) {
$plySteamID = $playerarray['steamID'];
$plyAdmin = $playerarray['isadmin'];
}


$user_ip = $_SERVER['REMOTE_ADDR'];
if($users==1){
$checkActive = mysql_query("SELECT * FROM admin_users WHERE user='$myusername' and pass=MD5('$mypassword') AND active = 1");
$usersActive = mysql_num_rows($checkActive);

if ($usersActive==1){
$update = mysql_query("UPDATE `admin_users` SET `last_login` = now(), `last_ip` = '$user_ip' WHERE `admin_users`.`user` = '$myusername'");
$_SESSION['myusername'] = $myusername;
$_SESSION['steamid'] = $plySteamID;
$_SESSION['isadmin'] = $plyAdmin;
header('Location: http://' . $_SERVER['HTTP_HOST'] . '/ttt_stats/login-success.php');
}
else {
$_SESSION['failedLogin'] = true;
header('Location: http://' . $_SERVER['HTTP_HOST'] . '/ttt_stats/login.php');
}
}
else{
$_SESSION['verifyorpass'] = true;
header('Location: http://' . $_SERVER['HTTP_HOST'] . '/ttt_stats/login.php');
}

?>