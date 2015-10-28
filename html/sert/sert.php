<?php


// $privkey_enc = openssl_pkey_new($config);
// $csr = openssl_csr_new($dn, $privkey_enc,$SSL);
// $sscert = openssl_csr_sign($csr, null, $privkey_enc, 365);
// openssl_csr_export($csr, $csrout);
// openssl_x509_export($sscert, $sscertout);
// openssl_pkey_export($privkey_enc, $privkeyout);
// $pubkey = openssl_pkey_get_details($privkey_enc )["key"];
// var_dump($csrout);
// echo "\n";
// var_dump($sscertout);
// echo "\n";
// var_dump($privkeyout);
// openssl_x509_export_to_file($sscert, "certificate.crt");
// openssl_pkey_export_to_file($privkey_enc, "key.pem");
// file_put_contents("key.pub",$pubkey);

// $zip = new ZipArchive();
// $zip->open("certif.zip", ZipArchive::CREATE);
// $zip->addFile("certificate.crt");
// $zip->addFile("key.pub");
// $zip->addFile("key.pem");

// $zip->close();
// unlink("certificate.crt");
// unlink("key.pub");
// unlink("key.pem");

// Show any errors that occurred here
// while (($e = openssl_error_string()) !== false) {
//     echo $e . "\n";
// }


function Cert($len,$c,$st,$l,$o,$ou,$cn,$email,$days = 365){
  exec("openssl genrsa -des3 -passout pass:x -out server.pass.key $len");
  exec("openssl rsa -passin pass:x -in server.pass.key -out priv.key");
  exec("openssl req -new -key priv.key -out server.csr -subj '/C=$c/ST=$st/L=$l/O=$o/OU=$ou/CN=$cn/emailAddress=$email'");
  exec("openssl x509 -req -days $days -in server.csr -signkey priv.key -out server.crt");
  unlink("server.pass.key");
}

function RenewCert($csr,$key,$days){
	exec("openssl x509 -in $csr -out new.crt -signkey $key -req -days $days");
}

function clean(){
	unlink("server.crt");
	unlink("priv.key");
	unlink("server.csr");
}

function revoke($id){

}

// require_once "../apps/User.php";

// Cert(1024,"TN","Tunisia","Tunis","Sdf Prod Ltd","Jemix","jemiaymen.com","jemiaymen@gmail.com");
// $u = new user();

// $crt = file_get_contents("server.crt");
// $key = file_get_contents("priv.key");
// $csr = file_get_contents("server.csr");

// $u->SaveCert($key,$crt,$csr,2,"jemix");



// clean();
// file_put_contents("npriv.key",$u->getCertif(12)[0]);
// file_put_contents("nserver.crt",$u->getCertif(12)[1]);

echo "am here :p";
echo $_SERVER['REMOTE_USER'];















?>