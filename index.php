<?php

include('inc/header.php');

define('MAX_POPULAR_GAMES', 5);

?>
					<div style="width: 700px; height: 130px; margin: 0 auto; background: url('images/populargame_bg.jpg'); text-align: center;">
<?php

$sql = "SELECT gameid, gametitle, gametype, COUNT(codedata) as TOTAL_FC
		FROM fcs_codelist, fcs_gamelist
		WHERE fcs_codelist.codetype = fcs_gamelist.gameid
		GROUP BY gametitle
		ORDER BY TOTAL_FC DESC
		LIMIT " . MAX_POPULAR_GAMES;
$result = $db->query($sql);
while ($row = $db->fetch_assoc($result))
{
		echo "					<div style=\"float: left; padding: 5 25 0 25;\">";
	if ($row['gametype'] == 0)
		echo "<div style=\"height: 20px\"></div><a href=\"view.php?a=g&w=" . $row['gameid'] . "\"><img src='boxart/" . $row['gameid'] . ".png' border='0'></a>";
	else
		echo "<a href=\"view.php?a=g&w=" . $row['gameid'] . "\"><img src='boxart/" . $row['gameid'] . ".png' border='0'></a>";
	echo "</div>\n";
}
?>
					</div>
<?php

$sql = "SELECT gametitle, gameid
		FROM fcs_gamelist
		ORDER BY gametitle ASC";
$result = $db->query($sql);
while ($row = $db->fetch_assoc($result))
{
	echo "					<a href=\"view.php?a=g&w=" . $row['gameid'] . "\">" . stripslashes($row['gametitle']) . "</a><br />\n";
}

include('inc/footer.php');

?>
