<?php
/*------------------------\
|        TTT STATS        |
|	   Beta           |
|=========================|
|? 2013 SNGaming.org      |
|   All Rights Reserved   |
|=========================|
|   Website printout      |
|      beta testing       |
|      by Handy_man       |
\------------------------*/
include("./includes/superonly.php");
include("./includes/header.php");	

if ($_SESSION['added'] == true){
echo "<script type='text/javascript' language='JavaScript'> alert('User updated successfully')</script>";
$_SESSION['added'] = false;
}

$allAdmins = mysql_query("SELECT * FROM `admin_users` ORDER BY `admin_users`.`ID` DESC");
$multiResult = mysql_num_rows($allAdmins);


?>
<div id="primary_content">

<h4><? echo $multiResult . " Registered users.";?></h4>

<table border ="1">
						<tr>
						<th>E-mail</th>
						<th>Username</th>
						<th>Last Login</th>
						<th>Last IP</th>
						<th>SteamID</th>
						<th>Admin Type</th>
						<th>Edit</th>
						</tr>

<?


while($adminArray = mysql_fetch_array( $allAdmins )) {
echo "<form action='./edit-admin.php' method='post'>";
$adminID = $adminArray['ID'];
$adminEmail = $adminArray['email'];
$adminUsername = $adminArray['user'];
$adminLast = $adminArray['last_login'];
$adminIP = $adminArray['last_ip'];
$adminSID = $adminArray['steamID'];
$adminType = $adminArray['isadmin'];

echo "<tr>";
echo "<td>" . $adminEmail . "</td>";
echo "<td>" . $adminUsername . "</td>";
echo "<td>" . $adminLast . "</td>";
echo "<td>" . $adminIP . "</td>";
echo "<td>" . $adminSID . "</td>";
echo "<td>" . $adminType . "</td>";
echo "<td>" . "<input type='hidden' name='adminID' id='adminID' value='" . $adminID . "'><button class='button' type='submit'>Edit</button>" . "</td>";
echo "</tr>";
echo "</form>";

	
} 

echo "</table> </div>";

include("./includes/footer.php");
?>
