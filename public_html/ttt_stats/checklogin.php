<?PHP
require("./includes/session_start.php");

include("./includes/config.php");



// username and password sent from form
$myusername=$_POST['u'];
$mypassword=$_POST['p'];

// To protect MySQL injection (more detail about MySQL injection)
$myusername = mysql_real_escape_string($myusername);
$mypassword = mysql_real_escape_string($mypassword);
$encrypted_mypassword=md5($mypassword);

$check = mysql_query("SELECT * FROM admin_users WHERE user='$myusername' and pass=MD5('$mypassword')");
echo $myusername . " " . $mypassword;


// Mysql_num_row is counting table row
$users = mysql_num_rows($check);

// If result matched $myusername and $mypassword, table row must be 1 row

if($users==1){

// Register $myusername, $mypassword and redirect to file "login_success.php"
$_session['myusername'] = $myusername;
$echo "You've had your session set! " . $_session['myusername'];
}
else {
echo "Wrong Username or Password";
}

?>