<?php 

include "../api/classes.php";

$ao = new AuthObject();
$ao->logout();

header("Location: ../Login.php");


?>