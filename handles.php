<?php

if(isset($_SERVER['REQUEST_METHOD'])){
	switch ($_SERVER['REQUEST_METHOD']) {
		case "GET":
			
			if(isset($_GET['action'])){
				if(isset($_GET['action'])){
					if(file_exists('handlers/' . $_GET['action'] . '.php')){
						require_once('handlers/' . $_GET['action'] . '.php');
					} else {
						require_once('tpl/error.tpl');
					}
				}
			}

			break;
		case "POST":
			
			if(isset($_POST['action'])){
				if(file_exists('handlers/' . $_POST['action'] . '.php')){
					require_once('handlers/' . $_POST['action'] . '.php');
				} else {
					require_once('tpl/error.tpl');
				}
			}

		    break;
		default:
			require_once('tpl/error.tpl');
			break;
	}
}