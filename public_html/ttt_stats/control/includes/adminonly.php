<?php 
session_start();
if (isset($_SESSION['myusername']) & isset($_SESSION['isadmin'])){
$adminLevel = $_SESSION['isadmin'];
	if($adminLevel >= 1){
	//do nothing, we're happy that we're superadmin and won't get kicked.
	}
	else{
	header('Location: http://' . $_SERVER['HTTP_HOST'] . '/ttt_stats/control/restricted.php');
	}
}
else{
header('Location: http://' . $_SERVER['HTTP_HOST'] . '/ttt_stats/control/restricted.php');
}
?>
