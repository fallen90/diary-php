<?php

if(isset($_POST['body']) && isset($_POST['user_id'])){
	$post = new Post();
	$result = $post->create($_POST['user_id'], $_POST['body']);
	if($result){
		header('Location: /?create_post=success');
	} else {
		header('Location: /?create_post=error');
	}
}