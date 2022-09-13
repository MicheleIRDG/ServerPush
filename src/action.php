<?php
session_start();

if(isset($_POST['action']) && $_POST['action'] === "leave") {
	require('../class/ChatUser.php');

	$user_object = new ChatUser;
	$user_object->setUserId($_POST['user_id']);
	$user_object->setUserLoginStatus('Logout');
	$user_object->setUserToken($_SESSION['token']);

	if($user_object->update_user_login_data()) {
		unset($_SESSION);
		session_destroy();
		echo json_encode(['status' => 1], JSON_THROW_ON_ERROR);
	} // fine if
} // fine if
?>
