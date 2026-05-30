<?php

$host = "db.fr-pari1.bengt.wasmernet.com";
$user = "user_34adb6fa";
$pass = "pw_e5adcc49";
$db   = "db_ec0868aa";
$port = 10272;

$conn = new mysqli($host, $user, $pass, $db, $port);

if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}
?>