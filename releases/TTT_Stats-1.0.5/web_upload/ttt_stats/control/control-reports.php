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
include("./includes/adminonly.php");
include("./includes/header.php");



$removeID=$_POST['reportID'];
$removedName=$_POST['reportName'];

if(isset($removeID)){
$delete = mysql_query("DELETE FROM `ttt_report` WHERE `id` = $removeID");
$allreports = mysql_query("SELECT * FROM `ttt_report` ORDER BY `ttt_report`.`id` DESC");
$multiResult = mysql_num_rows($allreports);
}
else{
$allreports = mysql_query("SELECT * FROM `ttt_report` ORDER BY `ttt_report`.`id` DESC");
$multiResult = mysql_num_rows($allreports);
}


?>
<div id="primary_content">

<h4><? echo $multiResult . " report(s) currently waiting your attention.";?></h4>

<?PHP
if (isset($removeID)){
	echo "<script type='text/javascript' language='JavaScript'> alert('You successfully removed the report against " . $removedName . "')</script>";
}
?>

<table border ="1">
						<tr>
						<th>SteamID</th>
						<th>Nickname</th>
						<th>Karma</th>
						<th>RDM's/ Kills</th>
						<th>Message</th>
						<th>reporterID</th>
						<th>reporterNickname</th>
						<th>Report Time</th>
						<th>Remove?</th>
						</tr>

<?


while($reportArray = mysql_fetch_array( $allreports )) {
echo "<form action='".$_SERVER['PHP_SELF']."' method='post'>";
$reportID = $reportArray['id'];
$reportSteamid = $reportArray['steamid'];
$reportNick = $reportArray['nickname'];
$reportKarma = $reportArray['lKarma'];
$reportKills = $reportArray['opKills'];
$reportMessage = $reportArray['message'];
$reporterID = $reportArray['repID'];
$reporterNick = $reportArray['repNick'];
$reportTime = $reportArray['report_time'];

echo "<tr>";
echo "<td><a href='" . $sb_search_build . $reportSteamid . "&Submit='>" . $reportSteamid . "</a></td>";
echo "<td>" . $reportNick . "</td>";
echo "<td>" . $reportKarma . "</td>";
echo "<td>" . $reportKills . "</td>";
echo "<td>" . $reportMessage . "</td>";
echo "<td>" . $reporterID . "</td>";
echo "<td>" . $reporterNick . "</td>";
echo "<td>" . $reportTime . "</td>";
echo "<td> <input type='hidden' name='reportID' id='reportID' value='" . $reportID . "'> <input type='hidden' name='reportName' id='reportName' value='" . $reportNick . "'> <button class='button' type='submit'>Remove</button></td>";
echo "</tr>";
echo "</form>";
	
} 

echo "</table> </div>";

include("./includes/footer.php");
?>
