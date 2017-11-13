<?php

include('../../inc/common.php');

if ($phpbb_username == "Anonymous") {

			die("LOGIN_FAIL_TO_EXIST");
			
		} else {
				
		?>
			<div style="float: left; width: 20px">&nbsp;</div><div style="float: left; width: 330px"><b>Game</b></div><div style="float: left; width: 200px"><b>Friend Code</b></div><div style="float: left; width: 15px"><b>Playing?</b></div><br/>
						<div id="codes">
						<?php

						$sql = "SELECT *
								FROM fcs_codelist, fcs_gamelist
								WHERE fcs_codelist.userid = '" . $phpbb_user_id . "' AND fcs_gamelist.gameid = fcs_codelist.codetype
								ORDER BY gametitle ASC";
						$result = $db->query($sql);
						while ($row = $db->fetch_assoc($result))
						{
							$c_ap = (($row['codeactive'] == 0) ? "No" : "Yes");
							echo "<div style=\"float: left; width: 20px; height: 20px\"><a href=\"#\" class=\"del\" value=\"".$row['gameid']."\"><img src=\"images/delete.png\" border=\"0\"></a></div><div style=\"float: left; width: 330px; height: 20px\">".$row['gametitle']."</div><div style=\"float: left; width: 200px; height: 20px\">".$row['codedata']."</div><div style=\"float: left; width: 15px; height: 20px\">".$c_ap."</div><div style=\"clear: both\"></div>\n						";
						}
			
						?>
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
											 WHERE codetype = " . $row['gameid']." AND userid='".$phpbb_user_id."'";
									$result2 = $db->query($sql2);
									$row2 = $db->fetch_assoc($result2);
									if ($row2['TOTALFOUND'] == 0)
										echo "<option id=\"" . $row['gameid'] . "\" value=\"".$row['gameid']."\" name=\"" . $row['gameid'] . "\">" . stripslashes($row['gametitle']) . "</option>\n								";
									
							}

							?></select></div>
							<div style="float: left; width: 200px"><input type="text" name="addcode_data" id="addcode_data" maxlength="15" size="17" class="input"></div>
							<div style="float: left; width: 65px">
								<div style="float: right"><input type="submit" name="submit" id="submit" value="Add!" /></div>
								<select name="addcode_ap" id="addcode_ap" class="input">
									<option value="1">Yes</option>
									<option value="0">No</option>
								</select>
							</div>
							</div>
<?php
		}
		
?>