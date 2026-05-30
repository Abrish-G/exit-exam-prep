<?php
include '../includes/auth.php';
include '../includes/db.php';

$id = $_SESSION['user_id'];

$user = $conn->query("
SELECT *
FROM users
WHERE id='$id'
")->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>

<title>Profile</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

<div class="container mt-5">

<div class="card shadow">

<div class="card-header">

<h3>My Profile</h3>

</div>

<div class="card-body">

<p>
<strong>Name:</strong>
<?= $user['fullname'] ?>
</p>

<p>
<strong>Email:</strong>
<?= $user['email'] ?>
</p>

<p>
<strong>Role:</strong>
<?= $user['role'] ?>
</p>

<p>
<strong>Joined:</strong>
<?= $user['created_at'] ?>
</p>

</div>

</div>

</div>

</body>
</html>