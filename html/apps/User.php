<?php

define("HOST","127.0.0.1");
define("USER","root");
define("PW","");
define("DB","pki");

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

	function register($email,$pw,$c,$st,$l,$o,$ou,$cn,$tel,$e = 1){
		$email = addslashes($email);
		$tel = addslashes($tel);
		$c = addslashes($c);
		$st = addslashes($st);
		$l = addslashes($l);
		$o = addslashes($o);
		$ou = addslashes($ou);
		$cn = addslashes($cn);
		$pw = sha1($pw);
		$qry = "INSERT INTO user() values(NULL,'$c','$st','$l','$o','$ou','$cn','$email','$pw','$tel','$e',NULL)";
		if($this->db->query($qry))
			return true;
		else {
			echo $this->db->error;
			return false;

		}
	}

	function updateUser($c,$st,$l,$o,$ou,$cn,$tel){
		$id = addslashes($_COOKIE['uid']);
		$tel = addslashes($tel);
		$c = addslashes($c);
		$st = addslashes($st);
		$l = addslashes($l);
		$o = addslashes($o);
		$ou = addslashes($ou);
		$cn = addslashes($cn);
		$qry ="UPDATE user SET tel ='$tel' , c ='$c' , st ='$st', l = '$l', o ='$o' , ou = '$ou' , cn ='$cn' WHERE id = '$id'";
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
		return isset($_COOKIE['uid']) && is_numeric($_COOKIE['uid']);
	}

	function getUser(){
		$id = addslashes($_COOKIE['uid']);
		$qry = "SELECT * FROM user WHERE id ='$id'";
		if($re = $this->db->query($qry)){
			if ($result = $re->fetch_array()) { 
				return $result;
			}
		}
		return null;
	}

	
	function getDemande(){
		$id = addslashes($_COOKIE['uid']);
		$qry = "SELECT * FROM demande WHERE uid ='$id'";
		if($re = $this->db->query($qry)){
			$i = 0;
			$r = array();
			while ($result = $re->fetch_array()) { 
				$r[$i] = $result;
				$i += 1;
			}
			return $r;
		}
		return null;
	}




	function demande($hash,$len,$subj,$t,$d){
		$id = addslashes($_COOKIE['uid']);;
		$hash = addslashes($hash);
		$len = addslashes($len);
		$subj = addslashes($subj);
		$t = addslashes($t);
		$d = addslashes($d);

		$qry = "INSERT INTO demande() values(NULL,'$id','$hash','$len','$subj','$t','$d',NULL)";
		if($this->db->query($qry))
			return true;
		else {
			echo $this->db->error;
			return false;

		}
	}


	function getDemandeNT(){

		$qry = "SELECT demande.id,uid,hash,len,subj,t,d,demande.dtc FROM demande,rep WHERE demande.id not in (select did from rep) LIMIT 30";
		if($re = $this->db->query($qry)){
			$i = 0;
			$r = array();
			while ($result = $re->fetch_array()) { 
				$r[$i] = $result;
				$i += 1;
			}
			return $r;
		}
		return null;
	}


	function getRep($id){
		$id = addslashes($id);
		$qry = "SELECT reps FROM rep WHERE did='$id' LIMIT 30";
		if($re = $this->db->query($qry)){
			if ($result = $re->fetch_array()) { 
				return $result[0];
			}else {
				return "Pas de Reponce";
			}
		}
	}

	function accept($id){
		$admin = $_SERVER['REMOTE_USER'];
		$id = addslashes($id);

		$qry = "INSERT INTO rep(id,did,admin,dtc) values(NULL,'$id','$admin',NULL)";
		if($this->db->query($qry))
			return true;
		else {
			echo $this->db->error;
			return false;

		}
	}


	function refuser($id,$comm){
		$admin = $_SERVER['REMOTE_USER'];
		$id = addslashes($id);
		$comm = addslashes($comm);
		$qry = "INSERT INTO rep(id,did,admin,repn,reps,comm,dtc) values(NULL,'$id','$admin',2,'REFUSED','$comm',NULL)";
		if($this->db->query($qry))
			return true;
		else {
			echo $this->db->error;
			return false;

		}
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