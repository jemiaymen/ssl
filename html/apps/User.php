<?php

define("HOST","localhost");
define("USER","root");
define("PW","");
define("DB","certif");

class user {
	
	var $db;

	function __construct() {
		$this->db = new Mysqli(HOST,USER,PW,DB);
		if($this->db->connect_error){
			die($this->db->connect_error);
		}
	}

	function login($email,$pw){
		$email = addslashes($email);
		$pw = sha1($pw);
		$qry = "SELECT id FROM user WHERE email='$email' and pw='$pw'";
		if($re = $this->db->query($qry)){
			setcookie('uid', $re->num_rows, time()+3600); 
			return true;
		}
		else
			return false;
	}

	function register($email,$pw,$nom,$adress,$tel){
		$email = addslashes($email);
		$nom = addslashes($nom);
		$adress = addslashes($adress);
		$tel = addslashes($tel);
		$qry = "INSERT INTO user() values(NULL,'$email','$pw','$nom','$adress','$tel')";
		if($this->db->query($qry))
			return true;
		else {
			echo $this->db->error;
			return false;

		}
	}

	function logout(){
		setcookie('uid', "", time() - 21); 
	}
}


?>