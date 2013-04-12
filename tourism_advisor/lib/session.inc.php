<?php
//defines all the functions to manage user sessions

//function to create a new session
function create_session($userobj) {
		@session_start();
		$_SESSION['user'] = serialize($userobj);
}

//function to check if thers an active session
function is_valid_session() {
	if(!isset($_SESSION)) session_start();
	if( isset($_SESSION['user']) ) return true;
	else return false;
}

//function to invalidate session
function invalidate_session() {
	if(is_valid_session()) {
		$_SESSION = array();
		session_destroy();
	}
}

?>