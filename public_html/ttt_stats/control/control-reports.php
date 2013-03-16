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
include("./includes/config.php");	

$allreports = mysql_query("SELECT * FROM `ttt_report` ORDER BY `ttt_report`.`id` DESC");
$multiResult = mysql_num_rows($allreports);


?>
<div id="primary_content">

<h4><? echo $multiResult . " report(s) currently waiting your attention.";?></h4>

<table border ="1">
						<tr>
						<th>ReportID</th>
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
echo "<td>" . $reportID . "</td>";
echo "<td><a href='http://bans.sngaming.org/index.php?p=banlist&searchText=" . $reportSteamid . "&Submit='>" . $reportSteamid . "</a></td>";
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

include("./includes/footer.php");
?>
