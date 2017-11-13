<?php

include('inc/header.php');

// change me....
$sql = "SELECT username, user_avatar, user_lastpost_time, notedata
		FROM phpbb3_users, fcs_usernotes
		WHERE phpbb3_users.user_id='" . $user_id . "' AND fcs_usernotes.userid = '" . $user_id . "'";
		
$result = $db->query($sql);

$row = $db->fetch_assoc($result);

$u_username = $row['username'];
$u_avatar = (((substr($row['user_avatar'], 0, 4)) != "http") ? ("http://www.nintendoconnection.net/forums/download/file.php?avatar=" . $row['user_avatar']) : $row['user_avatar']);
$u_lastvisit = $row['user_lastpost_time'];
$u_notes = (($row['notedata'] == "") ? "Click here to add some notes to your profile!  A good start would maybe be a few words about yourself." : $row['notedata']);
		
?>
					<div id="response"></div>
					<!-- USER DETAILS BOX START -->
					<div class="content">
						<h1>Your Details</h1>
						<i><div id="editnotes"><?php echo stripslashes($u_notes); ?></div></i>
						<div id="avatar"><img src="http://nintendoconnection.net/forums/download/file.php?avatar=3_1240125882.jpg" /></div>
					</div>
					<div class="clear"></div>
					<!-- USER DETAILS BOX END -->
					<!-- USER FRIEND CODE BOX START -->
					<div class="content">
		   				<h1>Your Friend Codes</h1><?php echo "\n"; ?>
		   				<div id="the_codes">
		   				<div style="float: left; width: 20px">&nbsp;</div><div style="float: left; width: 330px"><b>Game</b></div><div style="float: left; width: 200px"><b>Friend Code</b></div><br/>
						<div id="codes">
						<?php

						$sql = "SELECT *
								FROM fcs_codelist, fcs_gamelist
								WHERE fcs_codelist.userid = '" . $user_id . "' AND fcs_gamelist.gameid = fcs_codelist.codetype
								ORDER BY gametitle ASC";
						$result = $db->query($sql);
						while ($row = $db->fetch_assoc($result))
						{
							echo "<div id=\"".$row['gameid']."\"><div style=\"float: left; width: 20px; height: 20px\"><a href=\"#\" class=\"del\" value=\"".$row['gameid']."\"><img src=\"images/delete.png\" border=\"0\"></a></div><div style=\"float: left; width: 330px; height: 20px\">".$row['gametitle']."</div><div style=\"float: left; width: 200px; height: 20px\" class=\"edit\" value=\"".$row['codedata']."\" type=\"".$row['gameid']."\">".$row['codedata']."</div><div style=\"clear: both\"></div></div>\n						";
						}
			
						?>
						</div>
						<form id="addcode_form">
							<input type="hidden" value="add" id="mode" name="mode">
							<div style="float: left; width: 350px">
							<select name="addcode_type" id="addcode_type" class="input"><?php echo "\n	"; ?>
							<?php
							
							$sql = "SELECT gameid, gametitle
									FROM fcs_gamelist
									ORDER BY gametitle ASC";
							$result = $db->query($sql);
							while($row = $db->fetch_assoc($result))
							{
									$sql2 = "SELECT COUNT(*) as TOTALFOUND
											 FROM fcs_codelist
											 WHERE codetype = " . $row['gameid']." AND userid='".$user_id."'";
									$result2 = $db->query($sql2);
									$row2 = $db->fetch_assoc($result2);
									if ($row2['TOTALFOUND'] == 0)
										echo "<option id=\"" . $row['gameid'] . "\" value=\"".$row['gameid']."\" name=\"" . $row['gameid'] . "\">" . stripslashes($row['gametitle']) . "</option>\n								";
									
							}

							?></select>
							<div style="float: left; width: 200px"><input type="text" name="addcode_data" id="addcode_data" maxlength="15" size="17" class="input"><input type="image" src="images/add.png" name="submit" id="submit" /></div>
							</div>
							</div>
							<br />
						</form>
<div style="clear: both;"></div>
					</div>
					<!-- USER FRIEND CODE BOX END -->
<?php include('inc/footer.php'); ?>
