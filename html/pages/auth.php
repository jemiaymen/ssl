<?php
require_once "../apps/User.php";

$u = new user();

if( !empty($_POST['email']) &&
    !empty($_POST['password']) && 
    !empty($_POST['nom']) && 
    !empty($_POST['tel']) &&
    !empty($_POST['adress']) ){
    if ($u->register($_POST['email'],$_POST['password'],$_POST['nom'],$_POST['adress'],$_POST['tel'])) {
        header( "refresh:2;url=login.php" ); 
        echo "Register With success";
    }else {
        header("Location: register.php?error=yes");
    }
}
elseif (isset($_POST['email']) && isset($_POST['password'])) {
    
    if ($u->login($_POST['email'],$_POST['password'])) {
        header("Location: index.html");
    }else {
        header("Location: login.php?error=yes");

    }
}


?>