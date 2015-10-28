<?php
require_once "../apps/User.php";

$u = new user();

$u->logout();
header("Location: login.php");

?>