<?PHP
$string = '<?php 

$server_hostname = "'. $_POST["server_hostname"]. ":" . $_POST["server_port"] . '";

$server_user = "'. $_POST["server_user"]. '";

$server_pass = "'. $_POST["server_pass"]. '";

$connect = mysql_connect($server_hostname, $server_user, $server_pass);
$db_select = mysql_select_db("' . $_POST["server_db"] . '");
if (!connect) {die(mysql_error());}

?>';

$fp = fopen("../includes/config.php", "w");

fwrite($fp, $string);

fclose($fp);

$dbconn = mysql_connect('' . $_POST["server_hostname"] . '','' . $_POST["server_user"] . '','' . $_POST["server_pass"] . '');
mysql_select_db('' . $_POST["server_db"] . '',$dbconn);

$file = './struc.sql';

if($fp1 = file_get_contents($file)) {
  $var_array = explode(';',$fp1);
  foreach($var_array as $value) {
    mysql_query($value.';',$dbconn);
  }
}  

include("./includes/header.php");
?>

<script type="text/javascript" language="JavaScript">
<!--
//--------------------------------
// This code compares two fields in a form and submit it
// if they're the same, or not if they're different.
//--------------------------------
function checkEmail(theForm) {

		var x=document.forms["form1"]["myemail"].value;
		var atpos=x.indexOf("@");
		var dotpos=x.lastIndexOf(".");
		if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
		{
		alert("Not a valid e-mail address");
		return false;
		}
	
    if (theForm.myusername.value != theForm.myusername2.value )
    {
        alert('These Usernames don\'t match!');
        return false;
    } else if (theForm.mypassword.value != theForm.mypassword2.value ) 
	{
		alert('These Passwords don\'t match!');
        return false;
	} else if (theForm.myemail.value != theForm.myemail2.value ) 
	{
		alert('These E-mails don\'t match!');
        return false;
	} else	
	{
		return true;
    }
}
//-->
</script> 
<form action="checkregister.php" method="POST" onsubmit="return checkEmail(this);">
<h3 class="center">If you have errors at the top of this page, you've messed up and need to go back.</h3>
</br>
</br>
<h3 class="center">SuperAdmin Setup! Your details will be registered for login to the control panel backend.</h3>
<span class="formData">E-mail :</span>
<input name="myemail" type="text" id="myemail" placeholder="E-mail" required>
<br/>
<span class="formData">Repeat E-mail :</span>
<input name="myemail2" type="text" id="myemail2" placeholder="Repeat E-mail" required>
<br/>
<span class="formData">Username :</span>
<input name="myusername" type="text" id="myusername" placeholder="Username" required>
<br/>
<span class="formData">Repeat Username :</span>
<input name="myusername2" type="text" id="myusername2" placeholder="Repeat Username" required>
<br/>
<span class="formData">Password :</span>
<input name="mypassword" type="password" id="mypassword" placeholder="Password" required>
<br/>
<span class="formData">Repeat Password :</span>
<input name="mypassword2" type="password" id="mypassword2" placeholder="Repeat Password" required>
<br/>
<center>
<input type="checkbox" name="accept" id="accept" /><span class="center" style="cursor:pointer;">Do you agree to a notification being sent back to Handy_man that you've installed this software?</span>
</center>
<br />
<div align="center">
<button class='button' type='submit'>Ok</button></div>


<?PHP include("./includes/footer.php")?>