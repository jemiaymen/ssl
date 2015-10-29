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


	function getRepsA(){
		$qry = "SELECT rep.id,uid,hash,len,subj,t,d,demande.dtc,rep.dtc,admin FROM demande,rep WHERE demande.id = did AND repn = 1 LIMIT 30";
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

	function GenCert($len,$subj,$hash,$days = 365){
		exec("openssl genrsa -des3 -passout pass:x -out server.pass.key $len");
		exec("openssl rsa -passin pass:x -in server.pass.key -out priv.key");
		exec("openssl req -new -$hash -key priv.key -out ca.csr -subj '$subj'");
		exec("openssl x509 -req -days $days -in ca.csr -signkey priv.key -out ca.crt");
		unlink("server.pass.key");
	}



	//db  taw nriguelha fil dar bel mac
	//dtcr date de creation certifica dtexp date d'expiration
	function SaveCert($rid,$uid,$admin,$hash,$len,$subj){

		/*$data = openssl_x509_parse(file_get_contents('/path/to/cert.crt'));

$validFrom = date('Y-m-d H:i:s', $data['validFrom_time_t']);
$validTo ) date('Y-m-d H:i:s', $data['validTo_time_t']);*/

		$rid = addslashes($rid);
		$uid = addslashes($uid);
		$admin = addslashes($admin);
		$hash = addslashes($hash);
		$len = addslashes($len);
		$subj = addslashes($subj);
		$ca = file_get_contents("ca.crt");
		$pkey = file_get_contents("priv.key");
		$csr = file_get_contents("ca.csr");
		exec("touch index.txt");
		$db = file_get_contents("index.txt");
		$qry = "INSERT INTO cert(id,rid,uid,admin,ca,pkey,csr,db,dtcr,dtexp,hash,len,subj) values(NULL,'$rid','$uid','$admin','$ca','$pkey','$csr','$db','$dtcr','$dtexp','$hash','$len','$subj')";

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