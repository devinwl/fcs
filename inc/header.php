<?php include('common.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Friend Code Search</title>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js"></script>
		<script type="text/javascript" src="js/fcs.js"></script>
		<link rel="stylesheet" type="text/css" href="css/style.css" />
	</head>
	<body>
<?php
	$sql = "SELECT gameid
			FROM fcs_gamelist";
	$result = $db->query($sql);
	$s_games = $db->num_rows($result);
		
	$sql = "SELECT codeid
			FROM fcs_codelist";
	$result = $db->query($sql);
	$s_codes = $db->num_rows($result);
?>
	<center>
		<div id="container">
			<div id="header">
				<div id="banner"><a href="index.php"><div style="height: 9px"></div>Index</a></div>
				<div style="position: relative; bottom: 45px; left: 5px; width: 150px;">
					<?php 
						if ($username != "Anonymous")
						{
							echo "Welcome, <b>" . $username . "</b>!<br>\n";
							echo "					<a href=\"codes.php\" class=\"navbar_links\">My Page</a><br>\n";
						}
						else
							echo "<a href=\"http://www.nintendoconnection.net/forums/ucp.php?mode=login\" class=\"navbar_links\">Login</a>";
					?>
				</div>
			</div>
			<div style="background: url('images/bbl.gif') no-repeat #9edefa; height: 10px; text-align: right"><img src="images/bbr.gif"></div>
			<div id="body">
				<div id="body_ct"><? echo "\n"; ?>
