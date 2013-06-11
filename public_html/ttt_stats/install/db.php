<?PHP
if(!isset($_POST['accept'])){
//We should probably tell them what they're doing wrong, also this requires the directory to be ttt_stats... 
header('Location: http://' . $_SERVER['HTTP_HOST'] . '/ttt_stats/install/index.php');
}
include("./includes/header.php");
?>
<form action="user.php" method="POST">
<h3 class="center">Database Setup! you should have already created the user & database on your webserver.</h3>
<span class="formData">Server Hostname :</span>
<input name="server_hostname" type="text" id="server_hostname" value="localhost" required>
<br/>
<span class="formData">Server Port :</span>
<input name="server_port" type="text" id="server_port" value="3306" required>
<br/>
<span class="formData">Mysql Username :</span>
<input name="server_user" type="text" id="server_user" placeholder="Username" required>
<br/>
<span class="formData">Password :</span>
<input name="server_pass" type="password" id="server_pass" placeholder="Password" required>
<br/>
<span class="formData">Database :</span>
<input name="server_db" type="text" id="server_db" placeholder="Database name?" required>
<br/>
<br />
<div align="center">
<button class='button' type='submit'>Ok</button></div>


<?PHP include("./includes/footer.php")?>