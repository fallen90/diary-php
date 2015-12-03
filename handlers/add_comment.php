<?php

if(isset($_POST['body']) && isset($_POST['user_id'])){
	$post = new Comment();
	$result = $post->create($_POST['user_id'], $_POST['post_id'], $_POST['body']);
	if($result){
		header('Location: /?add_comment=success&post_id=' . $_POST['post_id'] . '&comment_id=' . $result);
	} else {
		header('Location: /?add_comment=error&post_id=' . $_POST['post_id']);
	}
}