<?php

include('../../inc/common.php');

// Success messages
$a_success_add = "<div id=\"aresponse\" class=\"succ\"><div id=\"alert_text\"><b>Success!</b> Your code was added.</div></div>";
$a_success_edit = "<div id=\"aresponse\" class=\"succ\"><div id=\"alert_text\"><b>Success!</b> Your code was edited.</div></div>";
$a_success_del = "<div id=\"aresponse\" class=\"succ\"><div id=\"alert_text\"><b>Success!</b> Your code was deleted.</div></div>";
$a_success_notes = "<div id=\"aresponse\" class=\"succ\"><div id=\"alert_text\"><b>Success!</b> Your notes were modifed.</div></div>";

// Alert messages

// Error messages
$a_error_length = "<div id=\"aresponse\" class=\"error\"><div id=\"alert_text\"><b>Error!</b> Your friend code is too long.</div></div>";
$a_error_nlength = "<div id=\"aresponse\" class=\"error\"><div id=\"alert_text\"><b>Error!</b> Your notes are too long.</div></div>";
$a_error_duplicate = "<div id=\"aresponse\" class=\"error\"><div id=\"alert_text\"><b>Error!</b> A friend code for that game already exists.</div></div>";
$a_error_invalid = "<div id=\"aresponse\" class=\"error\"><div id=\"alert_text\"><b>Error!</b> That friend code is invalid.</div></div>";
$a_error_dne = "<div id=\"aresponse\" class=\"error\"><div id=\"alert_text\"><b>Error!</b> That friend code no longer exists.</div></div>";


$action = $_GET['mode'];

switch ($action) {

	case "add":
			
		$c_data = $_GET['addcode_data'];
		$c_type = $_GET['addcode_type'];
		
		// Code validity check
		if((eregi("[a-z]", $c_data)) || (!eregi("[0-9]", $c_data)))
			die($a_error_invalid);
		if (strlen($c_data) > 15)
			die($a_error_length);
		$sql = "SELECT codeid
				FROM fcs_codelist
				WHERE userid='" . $user_id . "' AND codetype='" . $c_type . "'";
		$result = $db->query($sql);
		if ($db->num_rows($result) > 0)
			die($a_error_duplicate);
			
		// Code is valid, proceed
		$sql = "INSERT INTO fcs_codelist
				(userid, codetype, codedata, codeactive)
				VALUES
				('".$user_id."','".$c_type."','".$c_data."','0')";
		$db->query($sql);
		echo $a_success_add;
	
	break;
		
	case "edit":
		
		$c_data = $_GET['data'];
		$c_type = $_GET['type'];
			
		// Code validity check
		if (eregi("[a-z]", $c_data) || !eregi("[0-9]", $c_data))
			die($a_error_invalid);
		if (strlen($c_data) > 15)
			die($a_error_length);
			
		// Code valid, edit
		$sql = "UPDATE fcs_codelist
				SET codedata='".$c_data."'
				WHERE userid='".$user_id."' AND codetype='".$c_type."'";
		$db->query($sql);
		echo $a_success_edit;

	break;
		
	case "del":
		
		$c_type = $_GET['type'];
		
		//Check if code still exists
		$sql = "SELECT codeid
				FROM fcs_codelist
				WHERE userid='" . $user_id . "' AND codetype='" . $c_type . "'";
		$result = $db->query($sql);
		if ($db->num_rows($result) == 0)
			die($a_error_dne);
		
		//Code still exists, delete it
		$sql = "DELETE FROM fcs_codelist
				WHERE userid='".$user_id."' AND codetype='".$c_type."'";
		$db->query($sql);
		
		echo $a_success_del;
		
	break;
		
	case "notes":
		
		$n_data = $_GET['notes'];

		if (strlen($n_data) > 100)
			die($a_error_nlength);
		
		$n_data = str_replace("<", "&lt;", $n_data);
		$n_data = str_replace(">", "&gt;", $n_data);
		
		$sql = "SELECT *
				FROM fcs_usernotes
				WHERE userid='".$user_id."'";
		$result = $db->query($sql);
		if ($db->num_rows($result) > 0)
		{
			$sql = "UPDATE fcs_usernotes
					SET notedata='".$n_data."'
					WHERE userid='".$user_id."'";
		}
		else
		{
			$sql = "INSERT INTO fcs_usernotes
					(userid, notedata)
					VALUES
					('".$user_id."','".$n_data."')";
		}
		
		$db->query($sql);
		echo $a_success_notes;

	break;
		
	default:
		die();	
}

?>
