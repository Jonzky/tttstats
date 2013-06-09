<?php
/*------------------------\
|        TTT STATS        |
|	   Beta           |
|=========================|
|� 2013 SNGaming.org      |
|   All Rights Reserved   |
|=========================|
|   Website printout      |
|      beta testing       |
|      by Handy_man       |
\------------------------*/
include("./includes/superonly.php");	
include("./includes/header.php");
include("./includes/config.php");

//Save our settings! get all the data we're potentially changing!

?>
<div id="primary_content">
<h4>Welcome to the settings page, <?PHP echo $_SESSION['myusername'];?></h4>
<p>Here you can update a large number of variables that the ttt_stats relies on.</p>
<?PHP echo "<form action='../includes/variableUpdate.php' method='post'>";?>
<strong>Sourcebans enable/ disable</strong>
<input name="sb_enabled" type="radio" value="true">Enabled</br>
<input name="sb_enabled" type="radio" value="false">Disabled</br>
<strong>Reports enable/ disable</strong>
</br>
<input name="reports_enabled" type="radio" value="true">Enabled</br>
<input name="reports_enabled" type="radio" value="false">Disabled</br>
<strong>Server online tracker enable/ disable</strong>
</br>
<input name="servers_enabled" type="radio" value="true">Enabled</br>
<input name="servers_enabled" type="radio" value="false">Disabled</br>
<strong>Badge system enable/ disable</strong>
</br>
<input name="badge_enabled" type="radio" value="true">Enabled</br>
<input name="badge_enabled" type="radio" value="false">Disabled</br>

<div class="fright">
<button class='button' type='submit'>Apply</button>
</div>
</form>
</div>


<?PHP
include("./includes/footer.php");
?>
