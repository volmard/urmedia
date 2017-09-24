<?php

class Session {
	
  private $loggedIn = false;
	public  $userId;
	public  $userLogin;
	public  $message;
	
	function __construct() {
		session_start();
		$this->userActivity();
		$this->checkMessage();
		$this->checkLogin();		
	}
	
	public function isLoggedIn() {
		return $this->loggedIn;
	}
	
	public function login($user) {
		if($user) :
			$this->userId    = $_SESSION["userId"]    = $user->id;
		  $this->userLogin = $_SESSION["userLogin"] = $user->login;
			$this->loggedIn  = true;
		endif;
	}
	
	public function logout() {
		unset($_SESSION["userId"], $_SESSION["userLogin"]);
		unset($this->userId);
		$this->loggedIn = false;
	}
	
	public function message($msg = "") {
		if(!empty($msg)) :
			$_SESSION['message'] = $msg;			
		else :
			return $this->message;
		endif;
	}
	
	private function checkLogin() {
		if(isset($_SESSION["userId"])) :
			$this->userId    = $_SESSION["userId"];
		  $this->userLogin = $_SESSION["userLogin"];
			$this->loggedIn  = true;
		else :
			unset($this->userId);
			$this->loggedIn = false;
		endif;
	}
	
	private function checkMessage() {
		if(isset($_SESSION["message"])) :
			$this->message = $_SESSION["message"];
			unset($_SESSION["message"]);
		else :
			$this->message = "";
		endif;
	}
	
	private function userActivity($time = 600) {
	  if(isset($_SESSION['lastActivity']) && (time() - $_SESSION['lastActivity'] > $time)) :
//      session_unset();
//      session_destroy();  
		  $this->logout();
    endif;
    $_SESSION['lastActivity'] = time();
	}
	}
	
$session = new Session();
$message = $session->message;