<?PHP

include("./includes/config.php");



// username and password sent from form
$myusername=$_POST['u'];
$mypassword=$_POST['p'];

// To protect MySQL injection (more detail about MySQL injection)
$myusername = stripslashes($myusername);
$mypassword = stripslashes($mypassword);
$myusername = mysql_real_escape_string($myusername);
$mypassword = mysql_real_escape_string($mypassword);
$encrypted_mypassword=md5($mypassword);

$check = mysql_query("SELECT * FROM $admin_users WHERE user='$myusername' and pass='$encrypted_mypassword'");


// Mysql_num_row is counting table row
$users = mysql_num_rows($check);

// If result matched $myusername and $mypassword, table row must be 1 row

if($users==1){

// Register $myusername, $mypassword and redirect to file "login_success.php"
session_register("myusername");
session_register("mypassword");
header("location:/control/index.php");
}
else {
echo "Wrong Username or Password";
}

?>