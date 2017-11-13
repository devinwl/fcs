<?php
include('../../inc/common.php');

if ($phpbb_username == "Anonymous")
	die("LOGIN_FAIL_TO_EXIST");	
else
{			
	$sql = "SELECT codedata
			FROM fcs_codelist
			WHERE userid='" . $phpbb_user_id . "' AND codetype='" . $_POST['code'] . "'";
	$result = $db->query($sql);
	$row = $db->fetch_assoc($result);
			
	echo $row['codedata'];
			
}
?>
