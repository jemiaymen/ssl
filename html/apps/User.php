<?php

define("HOST","127.0.0.1");
define("USER","root");
define("PW","sdfpro");
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
			if ($result = $re->fetch_array()) {
				setcookie('uid', $result[0], time()+3600,"/"); 
				return true;
			}
		}
		
		return false;
	}

	function register($email,$pw,$nom,$adress,$tel){
		$email = addslashes($email);
		$nom = addslashes($nom);
		$adress = addslashes($adress);
		$tel = addslashes($tel);
		$pw = sha1($pw);
		$qry = "INSERT INTO user() values(NULL,'$email','$pw','$nom','$adress','$tel','1')";
		if($this->db->query($qry))
			return true;
		else {
			echo $this->db->error;
			return false;

		}
	}

	function logout(){
		setcookie('uid', "", time() - 21,"/"); 
	}

	function isauth(){
		return isset($_COOKIE['uid']);
	}

	function SaveCert($key,$crt,$csr,$uid,$admin,$new=1){
		$qry = "INSERT INTO certification() values(NULL,'$uid','$admin','$new','$key','$csr','$crt',NULL)";

		if($this->db->query($qry))
			return true;
		else {
			echo $this->db->error;
			return false;

		}
	}

	function getCertif($id){
		$qry = "SELECT privkey,crt FROM certification WHERE id='$id' ";
		if($re = $this->db->query($qry)){
			if ($result = $re->fetch_array()) { 
				return $result;
			}
		}
	}
}


?>