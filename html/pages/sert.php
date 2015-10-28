<?php


$dn = array(
   "countryName" => "TN",
   "stateOrProvinceName" => "Tunisia",
   "localityName" => "Tunis",
   "organizationName" => "SDFprod",
   "organizationalUnitName" => "Jemix",
   "commonName" => "jemiaymen.com",
   "emailAddress" => "jemiaymen@gmail.com"
);


$SSL = array(
        'encrypt_key' => true,
        'private_key_type' => OPENSSL_KEYTYPE_DSA,// OPENSSL_KEYTYPE_DH , OPENSSL_KEYTYPE_RSA
        'digest_alg' => 'md5', //md5 , sha1
        'x509_extensions' => 'v3_ca',
        'private_key_bits' => 1024 //512, 1024,2048
        );

$config = array(
    "digest_alg" => "md5",
    "private_key_bits" => 1024,
    "private_key_type" => OPENSSL_KEYTYPE_RSA,
);

$privkey_enc = openssl_pkey_new($config);
$csr = openssl_csr_new($dn, $privkey_enc,$SSL);
$sscert = openssl_csr_sign($csr, null, $privkey_enc, 365);
openssl_csr_export($csr, $csrout);
openssl_x509_export($sscert, $sscertout);
openssl_pkey_export($privkey_enc, $privkeyout);
$pubkey = openssl_pkey_get_details($privkey_enc )["key"];
// var_dump($csrout);
// echo "\n";
// var_dump($sscertout);
// echo "\n";
// var_dump($privkeyout);
echo "\n";
openssl_x509_export_to_file($sscert, "certificate.crt");
openssl_pkey_export_to_file($privkey_enc, "key.pem");
file_put_contents("key.pub",$pubkey);

$zip = new ZipArchive();
$zip->open("certif.zip", ZipArchive::CREATE);
$zip->addFile("certificate.crt");
$zip->addFile("key.pub");
$zip->addFile("key.pem");

$zip->close();
unlink("certificate.crt");
unlink("key.pub");
unlink("key.pem");

// Show any errors that occurred here
// while (($e = openssl_error_string()) !== false) {
//     echo $e . "\n";
// }

?>