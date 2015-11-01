<?php
require_once "../apps/User.php";

$u = new user();


if( !empty($_POST['email']) &&
    !empty($_POST['password']) && 
    !empty($_POST['cn']) && 
    !empty($_POST['c']) &&
    !empty($_POST['st']) &&
    !empty($_POST['l']) &&
    !empty($_POST['o']) &&
    !empty($_POST['ou']) &&
    !empty($_POST['tel']) ){

    if ($u->register($_POST['email'],$_POST['password'],$_POST['c'],$_POST['st'],
                     $_POST['l'],$_POST['o'],$_POST['ou'],$_POST['cn'],$_POST['tel'])) {
        header( "refresh:2;url=login.php" ); 
        echo "Register With success";
    }else {
        header("Location: register.html?error=yes");
    }
}
elseif (isset($_POST['email']) && isset($_POST['password'])) {
    
    if ($u->login($_POST['email'],$_POST['password'])) {
        header("Location: index.php");
    }else {
        header("Location: login.php?error=yes");

    }
}elseif(!empty($_POST['cn']) && 
        !empty($_POST['c']) &&
        !empty($_POST['st']) &&
        !empty($_POST['l']) &&
        !empty($_POST['o']) &&
        !empty($_POST['ou']) &&
        !empty($_POST['tel'])  ){


    if ($u->updateUser($_POST['c'],$_POST['st'],$_POST['l'],$_POST['o'],$_POST['ou'],$_POST['cn'],$_POST['tel'])) {
        header("Location: profile.php?update=ok");
    }else {
        header("Location: profile.php?error=yes");
    }

}elseif(!empty($_POST['subj']) &&
        !empty($_POST['type']) && 
        !empty($_POST['len']) &&
        !empty($_POST['d']) &&
        !empty($_POST['hash'])){


    if ($u->demande($_POST['hash'],$_POST['len'],$_POST['subj'],$_POST['type'],$_POST['d'])) {
        header("Location: demande.php?add=ok");
    }else {
        header("Location: demande.php?error=yes");
    }
}


?>