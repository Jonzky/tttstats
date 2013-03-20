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
include("./includes/config.php");	

$editID = $_POST['adminID'];

$editingAdmin = mysql_query("SELECT * FROM `admin_users` WHERE `ID` = '$editID'");
?>
<div id="primary_content">
<table border ="1">
						<tr>
						<th>E-mail</th>
						<th>Username</th>
						<th>Last Login</th>
						<th>Last IP</th>
						<th>SteamID</th>
						<th>Admin Type</th>
						</tr>

<?


while($adminArrayEdit = mysql_fetch_array( $editingAdmin )) {
$adminID = $adminArrayEdit['ID'];
$adminEmail = $adminArrayEdit['email'];
$adminUsername = $adminArrayEdit['user'];
$adminLast = $adminArrayEdit['last_login'];
$adminIP = $adminArrayEdit['last_ip'];
$adminSID = $adminArrayEdit['steamID'];
$adminType = $adminArrayEdit['isadmin'];

echo "<tr>";
echo "<td>" . $adminEmail . "</td>";
echo "<td>" . $adminUsername . "</td>";
echo "<td>" . $adminLast . "</td>";
echo "<td>" . $adminIP . "</td>";
echo "<td>" . $adminSID . "</td>";
echo "<td>" . $adminType . "</td>";
echo "</tr>";

	
} 

echo "</table>";


echo"</div>";

include("./includes/footer.php");
?>
