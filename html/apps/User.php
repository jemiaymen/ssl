<?php

define("HOST","127.0.0.1");
define("USER","root");
define("PW","sdfpro");
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
		$id = addslashes($_COOKIE['uid']);
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

		$qry = "SELECT demande.id,uid,hash,len,subj,t,d,demande.dtc FROM demande,rep WHERE demande.id not in (select did from rep) group by demande.id LIMIT 30";
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
		$qry = "SELECT rep.id, demande.uid, demande.hash, demande.len, demande.subj, demande.t, demande.d, demande.dtc, rep.dtc, rep.admin FROM demande,rep,cert WHERE demande.id = did AND repn = 1 AND rep.id NOT IN (select rid from cert) GROUP BY rep.id  LIMIT 30";
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

	//select cert.id, admin, dtcr, dtexp, hash, len, ops, subj, cert.dtc,  ca, pkey from user,cert where user.id = uid;

	function getUserCertif(){
		$id = addslashes($_COOKIE['uid']);

		$qry = "select cert.id, admin, dtcr, dtexp, hash, len, ops, subj, cert.dtc,  ca, pkey from user,cert where user.id = uid";

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

	function getCA($id){
		$id = addslashes($id);

		$qry = "SELECT ca FROM cert WHERE id ='$id'";

		if($re = $this->db->query($qry)){
			if ($result = $re->fetch_array()) { 
				return $result[0];
			}
		}
	}

	function getPK($id){
		$id = addslashes($id);

		$qry = "SELECT pkey FROM cert WHERE id ='$id'";

		if($re = $this->db->query($qry)){
			if ($result = $re->fetch_array()) { 
				return $result[0];
			}
		}
	}

	function getDemGen($rid){
		$rid = addslashes($rid);
		$qry = "SELECT hash,len,subj FROM demande,rep WHERE rep.id = '$rid' AND did = demande.id group by rep.id ";
		if($re = $this->db->query($qry)){
			if ($result = $re->fetch_array()) { 
				return $result;
			}
		}
		return null;
	}

	function getDem($rid){
		$rid = addslashes($rid);
		$qry = "SELECT len,hash,subj,d FROM demande,rep WHERE rep.id = '$rid' AND did = demande.id group by rep.id ";
		if($re = $this->db->query($qry)){
			if ($result = $re->fetch_array()) { 
				return $result;
			}
		}
		return null;
	}

	function GenCert($len,$hash,$subj,$days = 365){
		exec("touch index.txt");
		exec("echo 0 > serial");
		exec("echo 0 > crlnumber");
		exec("openssl genrsa -des3 -passout pass:x -out server.pass.key $len");
		exec("openssl rsa -passin pass:x -in server.pass.key -out priv.key");
		exec("openssl req -new -$hash -key priv.key -out ca.csr -subj '$subj'");
		exec("openssl x509 -req -days $days -in ca.csr -signkey priv.key -out ca.crt");
		unlink("server.pass.key");
	}

	function Clear(){
		if (file_exists("index.txt")) {
			unlink("index.txt");
		}
		if (file_exists("serial")) {
			unlink("serial");
		}
		if (file_exists("crlnumber")) {
			unlink("crlnumber");
		}
		if (file_exists("priv.key")) {
			unlink("priv.key");
		}
		if (file_exists("ca.csr")) {
			unlink("ca.csr");
		}
		if (file_exists("ca.crt")) {
			unlink("ca.crt");
		}
		if (file_exists("nca.crt")) {
			unlink("nca.crt");
		}
		if (file_exists("nca.csr")) {
			unlink("nca.csr");
		}
		if (file_exists("nca.csr")) {
			unlink("nca.csr");
		}
		if (file_exists("npkey.key")) {
			unlink("npkey.key");
		}
	}


	function SaveCert($rid,$uid){

		$data = openssl_x509_parse(file_get_contents('ca.crt'));
		$dtcr = $data['validFrom_time_t'];
		$dtexp = $data['validTo_time_t'];
		$rid = addslashes($rid);
		$uid = addslashes($uid);
		$admin = addslashes($admin);
		$hash = addslashes($hash);
		$len = addslashes($len);
		$subj = addslashes($subj);
		$ca = file_get_contents("ca.crt");
		$pkey = file_get_contents("priv.key");
		$csr = file_get_contents("ca.csr");
		$db = file_get_contents("index.txt");
		$admin = $_SERVER['REMOTE_USER'];

		$d = $this->getDemGen($rid);
		$hash = $d[0];
		$len = $d[1];
		$subj = $d[2];

		$qry = "INSERT INTO cert(id,rid,uid,admin,ca,pkey,csr,db,dtcr,dtexp,hash,len,subj) values(NULL,'$rid','$uid','$admin','$ca','$pkey','$csr','$db',FROM_UNIXTIME($dtcr),FROM_UNIXTIME($dtexp),'$hash','$len','$subj')";

		if($this->db->query($qry))
			return true;
		else {
			echo $this->db->error;
			return false;

		}
	}

	function demandeRenew($cid){
		$cid = addslashes($cid);
		$qry = "INSERT INTO demopp(cid) values('$cid') ";
		$qryt = "UPDATE cert SET opn = 2 , ops ='DEMRENEW' WHERE id='$cid' ";
		if($this->db->query($qry)){
			$this->db->query($qryt);
			return true;
		} else {
			echo $this->db->error;
			return false;

		}
	}

	function demandeRevok($cid){
		$cid = addslashes($cid);

		$qry = "INSERT INTO demopp(cid,ops,opn) values('$cid','REVOKE',2) ";
		$qryt = "UPDATE cert SET opn = 3 , ops ='DEMREVOKE' WHERE id='$cid' ";
		if($this->db->query($qry)){
			$this->db->query($qryt);
			return true;
		} else {
			echo $this->db->error;
			return false;

		}
	}

	function getDemOppNT(){

		$qry = "select demopp.id, cert.id, demopp.ops, cert.ops, admin, cn, demopp.dtc, dtcr, dtexp from cert,demopp,user where cert.id = cid and user.id = uid and etatn = 1";

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

	function Revoke(){

	}

	function Renew(){
		
	}

}


?>