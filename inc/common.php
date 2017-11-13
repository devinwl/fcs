<?php

//include('connect.php');
include('db.php');

/* 
// phpBB Session Management
define('IN_PHPBB', true);
$phpbb_root_path = '../forums/';

$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($phpbb_root_path . 'common.php');
include($phpbb_root_path . 'includes/functions_user.php');
include($phpbb_root_path . 'includes/ucp/ucp_register.php');

// Start session management
$user->session_begin();
$auth->acl($user->data);
$user->setup();

$phpbb_username = $user->data['username'];
$phpbb_user_id = $user->data['user_id'];
$phpbb_user_level = $user->data['user_type'];

*/

$username = "Test";
$user_id = 31;
$user_level = 99;

// End session management

//DB SET UP
$db = new db();
$db->connect(localhost, "user", "password", "db");

?>
