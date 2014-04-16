<?php
	/* MAIN API PROGRAM */
	$methods = array();
	$methods[] = "check_authentication";
	$methods[] = "register";
	$methods[] = "login";
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
		json_error_reply("Not implemented.");
	}
	
	function login() {
		json_error_reply("Not implemented.");
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