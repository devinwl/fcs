<?php

include('inc/header.php');

if ($phpbb_user_level == 0)
{
	echo "This is an admin only page!\n";
	include('inc/footer.php');
	die();
}

if ($_GET['a'] == 'new')
{
	$g_fname = mysql_real_escape_string($_POST['fn_form']);
	$g_sname = mysql_real_escape_string($_POST['sn_form']);
	$g_boxart = mysql_real_escape_string($_POST['ba_form']);
	$g_descr = mysql_real_escape_string($_POST['descr_form']);
	$g_type = mysql_real_escape_string($_POST['game_type']);
	
	if (($g_fname == "") || ($g_sname == "") || ($g_boxart == ""))
		echo "ERROR: Full name, short name or boxart not entered.";
	else
	{
		$sql = "INSERT INTO fcs_gamelist
				(gametitle, gamestitle, gamedesc, gametype)
				VALUES
				('".$g_fname."', '".$g_sname."','".$g_descr."', '".$g_type."')";
		$db->query($sql);
	
		$sql = "SELECT gameid
				FROM fcs_gamelist
				ORDER BY gameid DESC";
		$result = $db->query($sql);
		$row = $db->fetch_assoc($result);
	}
	echo "Adding Completed<br /><br />";
}

if ($_GET['a'] == 'edit') {

	$g_fname = mysql_real_escape_string($_POST['efn_form']);
	$g_sname = mysql_real_escape_string($_POST['esn_form']);
	$g_boxart = mysql_real_escape_string($_POST['eba_form']);
	$g_descr = mysql_real_escape_string($_POST['edescr_form']);
	$g_type = mysql_real_escape_string($_POST['egame_type']);
	$g_id = mysql_real_escape_string($_POST['edit_game']);
	
	$sql = "SELECT gametitle, gamestitle, gamedesc
			FROM fcs_gamelist
			WHERE gameid='" . $g_id . "'";
	$result = $db->query($sql);
	$row = $db->fetch_assoc($result);
	
	$g_fname = (($g_fname == "") ? $row['gametitle'] : $g_fname);
	$g_sname = (($g_sname == "") ? $row['gamestitle'] : $g_sname);
	$g_descr = (($g_descr == "") ? $row['gamedescr'] : $g_descr);
	
	$sql = "UPDATE fcs_gamelist
			SET gametitle='".$g_fname."', gamestitle='".$g_sname."', gamedesc='".$g_descr."', gametype='".$g_type."'
			WHERE gameid='" . $g_id . "'";
	$db->query($sql);
	
	echo "Edit successful!<br /><br />";
	
}

if (isset($_GET['a']))
{
	if ($g_boxart != "")
	{
		$im = imagecreatefromjpeg($g_boxart);
		$width = imagesx($im);
		$height = imagesy($im);
	
		if ($type == 1)
		{
			$im_base = imagecreatefrompng("images/base_wii.png");
			imagecopyresampled($im, $im, 0, 0, 0, 0, 90, 120, $width, $height);
			imagecopy($im_base, $im, 0, 0, 0, 0, 90, 120);
			imageline($im_base, 0, 0, 90, 0, 0); //top border
			imageline($im_base, 89, 0, 89, 119, 0); //right border
			imageline($im_base, 0, 119, 89, 119, 0); //bottom border
			imageline($im_base, 0, 0, 0, 119, 0); //left border
		}
		else
		{
			$im_base = imagecreatefrompng("images/base.png");
			imagecopyresampled($im, $im, 0, 0, 0, 0, 90, 80, $width, $height);
			imagecopy($im_base, $im, 0, 0, 0, 0, 90, 80);
			imageline($im_base, 0, 0, 90, 0, 0); //top border
			imageline($im_base, 89, 0, 89, 79, 0); //right border
			imageline($im_base, 0, 79, 89, 79, 0); //bottom border
			imageline($im_base, 0, 0, 0, 79, 0); //left border
		}
		
		if (file_exists("boxart/" . $g_id . ".png"))
			unlink("boxart/" . $g_id . ".png");
			
		imagepng($im_base, "boxart/" . $g_id . ".png");
	}
}
?>
General Guidelines:
<ul>
<li>Leaving fields empty while editing will not change their existing values</li>
<li>Descriptions are optional, but recommended</li>
<li><b>ALL BOX ART IMAGES MUST BE .jpg/.jpeg</b></li>
</ul><br />
<u>Add a new game</u>:
<form id="addgame_form" name="addgame_form" method="POST" action="admin.php?a=new">
<b>Full Game Name</b>: <input type="text" name="fn_form" id="fn_form" maxlength="100" size="25"><br>
<b>Short-hand Name</b>: <input type="text" name="sn_form" id="sn_form" maxlength="100" size="25"><br>
<b>Box Art</b>: <input type="text" name="ba_form" id="ba_form" maxlength="100" size="45"><br>
<b>Description</b>: <input type="text" name="descr_form" id="descr_form" maxlength="100" size="35"><br>
<b>Game Type</b>: <select name="game_type"><option value="0">DS</option><option value="1">Wii</option></select><br>
<input type="submit" value="Add Game" id="submit">
</form>

<u>Edit an existing game</u>:
<form id="editgame_form" name="editgame_form" method="POST" action="admin.php?a=edit">
<select name="edit_game">
<?php
$sql = "SELECT gameid, gametitle
		FROM fcs_gamelist
		ORDER BY gametitle ASC";
$result = $db->query($sql);
while ($row = $db->fetch_assoc($result))
	echo "<option id='" . $row['gameid'] . "' value='" . $row['gameid'] . "'>" . $row['gametitle'] . "</option>\n";
?>	
</select><br>
<b>Full Game Name</b>: <input type="text" name="efn_form" id="efn_form" maxlength="100" size="25"><br>
<b>Short-hand Name</b>: <input type="text" name="esn_form" id="esn_form" maxlength="100" size="25"><br>
<b>Box Art</b>: <input type="text" name="eba_form" id="eba_form" maxlength="250" size="45"><br>
<b>Description</b>: <input type="text" name="edescr_form" id="edescr_form" maxlength="100" size="35"><br>
<b>Game Type</b>: <select name="egame_type"><option value="0">DS</option><option value="1">Wii</option></select><br>
<input type="submit" value="Edit Game" id="submit">

<?php include('inc/footer.php'); ?>	
