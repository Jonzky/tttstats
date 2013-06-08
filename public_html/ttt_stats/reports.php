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
include("./includes/header.php");
if ($reports_enabled == true){
include("./includes/config.php");	

$allreports = mysql_query("SELECT * FROM `ttt_report` ORDER BY `ttt_report`.`id` DESC");
$multiResult = mysql_num_rows($allreports);


?>
<div id="primary_content">

<h4><? echo $multiResult . " report(s) currently waiting your attention.";?></h4>

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
						</tr>

<?


while($reportArray = mysql_fetch_array( $allreports )) {
$reportSteamid = $reportArray['steamid'];
$reportNick = $reportArray['nickname'];
$reportKarma = $reportArray['lKarma'];
$reportKills = $reportArray['opKills'];
$reportMessage = $reportArray['message'];
$reporterID = $reportArray['repID'];
$reporterNick = $reportArray['repNick'];
$reportTime = $reportArray['report_time'];

echo "<tr>";
if ($sb_enabled == true){
echo "<td><a href='" . $sb_search_build . $reportSteamid . "&Submit='>" . $reportSteamid . "</a></td>";
}
else{
echo "<td>" . $reportSteamid . "</td>";

}
echo "<td>" . $reportNick . "</td>";
echo "<td>" . $reportKarma . "</td>";
echo "<td>" . $reportKills . "</td>";
echo "<td>" . $reportMessage . "</td>";
echo "<td>" . $reporterID . "</td>";
echo "<td>" . $reporterNick . "</td>";
echo "<td>" . $reportTime . "</td>";
echo "</tr>";

	
} 

echo "</table> </div>";
}
else{
echo "<p class='center'>Reports has been disabled by the system administrator.</p>";
}
include("./includes/footer.php");
?>
