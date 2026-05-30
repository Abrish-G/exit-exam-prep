<?php

include '../includes/admin_auth.php';
include '../includes/db.php';

$id = $_GET['id'];

$conn->query("
DELETE FROM questions
WHERE id='$id'
");

header("Location: manage_questions.php");
exit();
?>