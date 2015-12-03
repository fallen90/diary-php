<?php

if(isset($_POST['user_name']) && isset($_POST['user_pass'])){

	$db = new Database();
	$result = $db->query("SELECT user_id, user_name, user_fullname, user_email FROM users WHERE user_name='" . $_POST['user_name'] . "' AND user_pass='" . $_POST['user_pass'] . "'")->fetch_assoc();
	if(count($result) >=1){
		foreach($result as $k=>$re){
			$_SESSION[$k] = $re;
		}
		header('Location: /?do_login=success');
	} else {
		print_r($db);
		header('Location: /login.php?do_login=error');
	}
}