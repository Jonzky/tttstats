<?PHP
include("./includes/superonly.php");
include("../includes/config.php");

// username and password sent from form
$adminUID=$_POST['ID'];
$myusername=$_POST['nick'];
$myemail=$_POST['e-mail'];
$mySteam=$_POST['steamID'];
$myAdminType=$_POST['admin']; //admin, superadmin and None only please :D 
// To protect MySQL injection (more detail about MySQL injection)
$myusername = mysql_real_escape_string($myusername);
$myemail = mysql_real_escape_string($myemail);
$mySteam = mysql_real_escape_string($mySteam);
//Convert it back into a 0, 1 or 2 again... silly users.
if($myAdminType == "admin"){
$myAdminType = 1;
}
else if($myAdminType == "superAdmin"){
$myAdminType = 2;
}
else{
$myAdminType = 0;
}
$check = mysql_query("UPDATE `admin_users` SET`email`='$myemail',`user`='$myusername',`steamID`='$mySteam',`isadmin`=$myAdminType WHERE `ID` = $adminUID");
$_SESSION['added'] = true;
header('Location: http://' . $_SERVER['HTTP_HOST'] . '/ttt_stats/control/list-admin.php');


?>