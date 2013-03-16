<?PHP
require("./includes/session_start.php");
?>

<meta http-equiv="refresh" content="5;url=./control/index.php">

<p>
   Thank you for logging in <?PHP echo$_SESSION['username'];?> you will be redirected to the control panel in 5 seconds. 
   Click <a href="./control/index.php">here</a> if you're impatient.
</p>