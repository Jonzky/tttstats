<?php
$string = '<?php 

$sb_enabled = '. $_POST["sb_enabled"]. ';

$sb_search_build = "'. $_POST["sb_search_build"]. '";

$base_address = "'. $_POST["base_address"]. '";

$reports_enabled = '. $_POST["reports_enabled"]. ';

$servers_enabled = '. $_POST["servers_enabled"]. ';

$register_enabled = '. $_POST["register_enabled"]. ';

$badge_enabled = '. $_POST["badge_enabled"]. ';

$badge_ref = "'. $_POST["badge_ref"]. '";

$facebook_link = "'. $_POST["facebook_link"]. '";

$twitter_link = "'. $_POST["twitter_link"]. '";

$youtube_link = "'. $_POST["youtube_link"]. '";

$steam_link = "'. $_POST["steam_link"]. '";

$twitch_link = "'. $_POST["twitch_link"]. '";

$logo_path = "'. $_POST["logo_path"]. '";

?>';



$fp = fopen("../includes/variables.php", "w");

fwrite($fp, $string);

fclose($fp);

header('Location: http://' . $_SERVER['HTTP_HOST'] . '/ttt_stats/control/variablesSuccess.php');

?>
