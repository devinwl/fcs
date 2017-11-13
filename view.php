<?php

include('inc/header.php');

$action = $_GET['a'];
$data = $_GET['w'];

switch ($action)
{

	// List friend codes for a specfic Game ID
	case "g" :
	
		$sql = "SELECT gametitle
				FROM fcs_gamelist
				WHERE gameid='" . $data . "'";
		$result = $db->query($sql);
		$row = $db->fetch_assoc($result);
		
		$g_title = $row['gametitle'];
			
?>
					<div class="content">
						<h1><?php echo $g_title; ?></h1>
<?php
			
		$sql = "SELECT username, user_id, codedata
				FROM phpbb3_users, fcs_codelist
				WHERE fcs_codelist.codetype = '" . $data . "' AND phpbb3_users.user_id = fcs_codelist.userid
				ORDER BY upper(username) ASC";
		$result = $db->query($sql);
		if ($db->num_rows($result) > 0)
		{
?>
						<table><tr>
							<td width="150"><b>Username</b></td><td width="150"><b>Friend Code</b></td></tr>
<?php
			while ($row = $db->fetch_assoc($result))
				echo "						<tr><td width=\"150\"><a href=\"view.php?a=p&w=" . $row['user_id'] . "\">" . $row['username'] . "</a></td><td width=\"150\">" . $row['codedata'] . "</td></tr>\n";
		}
		else
			echo "No friend codes have been added for this game.  If you own the game, why not <a href=\"codes.php\">add your own friend code</a>?\n";
			
?>
						</table>
					</div>
<?php
		
	break;
	
	// List friend codes for a specific User ID
	case "p" :
		
		$sql = "SELECT username, user_avatar
		FROM phpbb3_users
		WHERE phpbb3_users.user_id='" . $data . "'";
		$result = $db->query($sql);
		$row = $db->fetch_assoc($result);
		
		$sql = "SELECT notedata
				FROM fcs_usernotes
				WHERE userid = '".$data."'";
		$result = $db->query($sql);
		$notes = $db->fetch_assoc($result);
		
		$sql = "SELECT COUNT(codedata)
				FROM fcs_codelist
				WHERE userid = '".$data."'";
		$result = $db->query($sql);
		$row2 = $db->fetch_assoc($result);
		$num_codes = $row2['COUNT(codedata)'];
		
		$u_username = $row['username'];
		$u_notes = (($notes['notedata'] == "") ? "" : $notes['notedata']);
		$u_avatar = (((substr($row['user_avatar'], 0, 4)) != "http") ? ("http://www.nintendoconnection.net/forums/download/file.php?avatar=" . $row['user_avatar']) : $row['user_avatar']);

$medals = "";

if ($num_codes > 0)
	$medals .= "<img src=\"images/medals/blue_bronze.png\" title=\"".$u_username." added a friend code!\" />&nbsp;";
if ($num_codes > 4)
	$medals .= "<img src=\"images/medals/blue_silver.png\" title=\"".$u_username." added five friend codes!\" />&nbsp;";
if ($num_codes > 9)
	$medals .= "<img src=\"images/medals/blue_gold.png\" title=\"".$u_username." added ten friend codes!\" />&nbsp;";
if ($num_codes > 14)
	$medals .= "<img src=\"images/medals/blue_bronze_s.png\" title=\"".$u_username." added 15 friend codes!\" />&nbsp;";
if ($num_codes > 19)
	$medals .= "<img src=\"images/medals/blue_silver_s.png\" title=\"".$u_username." added 20 friend codes!\" />&nbsp;";
if ($num_codes > 24)
	$medals .= "<img src=\"images/medals/blue_gold_s.png\" title=\"".$u_username." added over 25 friend codes!  Amazing!\" />&nbsp;";
?>
					<div class="content">
						<div style="float: right;"><?php echo $medals; ?></div>
						<h1><?php echo $u_username; ?>'s Friend Codes</h1>
						<div style="float: left; height: 125px; width: 125px; padding: 10px"><img src="<?php echo $u_avatar; ?>" /></div>
						<i><?php echo stripslashes($u_notes); ?></i>
						<div style="clear: both;"></div>
					</div>
					<br />
					<div class="content">
						<table><tr>
						<td width="350"><b>Game</b></td><td width="150"><b>Friend Code</b></td></tr>
<?php

		$sql = "SELECT codedata, gametitle, gameid
				FROM fcs_codelist, fcs_gamelist
				WHERE fcs_codelist.userid = '" . $data . "' AND fcs_gamelist.gameid = fcs_codelist.codetype
				ORDER BY upper(gametitle) ASC";
		$result = $db->query($sql);
		if ($db->num_rows($result) > 0)
		{
			while ($row = $db->fetch_assoc($result))
			{
				echo "						<td width=\"350\"><a href=\"view.php?a=g&w=" . $row['gameid'] . "\">" . $row['gametitle'] . "</a></td><td width=\"150\">" . $row['codedata'] . "</td></tr>\n";
			}
		}
		else
			echo "This user has not added any friend codes yet.  Let's throw stones at them!\n";
			
?>
					</table>
					</div>
<?php
	break;
	
	default:
		die("ERROR: No action specified.");
			
}
		
include('inc/footer.php');
	
?>
