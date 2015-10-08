<?php

require_once "User.php";


$user = new user();

$u = array( 'email'=>'jemiaymen@gmail.com',
			'pw' => sha1( 'admin' ),
			'nom' => 'Aymen Jemi',
			'adress' => 'rue 6222 cite omrane sup',
			'tel' => '52547787'
 );

/*if($user->register($u['email'],$u['pw'],$u['nom'],$u['adress'],$u['tel']))
	echo "sa7it";*/

/*if($user->login('jemiaymen@gmail.com','admin')) 
	echo "login";
else 
	echo "mahouche login";*/

$user->logout();
?>