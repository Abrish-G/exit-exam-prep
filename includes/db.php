<?php

$host = "db.fr-pari1.bengt.wasmernet.com";
$user = "user_34adb6fa";
$pass = "pw_e5adcc49";
$db   = "db_ec0868aa";

$conn = new mysqli($host, $user, $pass, $db);

if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}
?>