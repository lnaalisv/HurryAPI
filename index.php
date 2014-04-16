<?php
	session_start();
	
	/* MAIN API PROGRAM */
	
	$methods = array();
	$methods[] = "check_authentication";
	$methods[] = "register";
	$methods[] = "login";
	$methods[] = "logout";
	$methods[] = "create_favourite";
	$methods[] = "get_favourites";
	$methods[] = "delete_favourite";
	
	$method = !empty($_REQUEST["method"]) ? $_REQUEST["method"] : null;
	
	if($method) {	
		if(in_array($method,$methods)) {
			$method();
			die();
		} else {
			$return_item = array();
			$return_item["error"] = "Method $method not available.";
			$return_item["available_methods"] = $methods;
			json_reply($return_item);
		}
	} else {
		$return_item = array();
		$return_item["error"] = "No method specified";
		$return_item["available_methods"] = $methods;
		json_reply($return_item);
	}
	
	/* API FUNCTIONS */
	
	function check_authentication() {
		$return_item = array();
		$return_item["logged"] = false;
		if(is_logged_in()) {
			$return_item["logged"] = true;
		}
		json_reply($return_item);
	}
	
	function register() {
		if(empty($_REQUEST["username"]) || empty($_REQUEST["password"])) {
			json_error_reply("username or password undefined");
		}
		$username = $_REQUEST["username"];
		$password = $_REQUEST["password"];
		
		file_put_contents("users.txt", $username.";".$password."\n", FILE_APPEND);
	}
	
	function login() {
		if(empty($_REQUEST["username"]) || empty($_REQUEST["password"])) {
			json_error_reply("username or password undefined");
		}
		$username = $_REQUEST["username"];
		$password = $_REQUEST["password"];
		$lines = file("users.txt");
		foreach($lines as $line) {
			echo "Tutkitaan: $line<br/>\n";
			$parts = explode(";",$line);
			$u = $parts[0];
			$p = $parts[1];
			if($u == $username && $p == $password) {
				echo "löyty!!";
			} else {
				echo "$u ei oo $username eikä $p $password";
			}
		}
		json_reply($lines);
	}
	
	function logout() {
		unset($_SESSION);
	}
	
	function create_favourite() {
		json_error_reply("Not implemented.");
	}
	
	function get_favourites() {
		json_error_reply("Not implemented.");
	}
	
	function delete_favourite() {
		json_error_reply("Not implemented.");
	}
	
	/* INTERNAL FUNCTIONS */
	
	function is_logged_in() {
		if(!empty($_SESSION["user"]) && !empty($_SESSION["password"])) {
			return true;
		}
		return false;
	}
	
	function json_reply($data) {
		header("Content-Type: application/json; charset=UTF-8");
		echo json_encode($data);
		die();
	}
	
	function json_error_reply($data) {
		$error = array();
		$error["error"] = $data;
		json_reply($error);
		die();
	}
?>