<?php
include '../includes/auth.php';
include '../includes/db.php';

$user_id = $_SESSION['user_id'];

$history = $conn->query("
SELECT *
FROM exams
WHERE user_id='$user_id'
ORDER BY id DESC
");
?>

<!DOCTYPE html>
<html>
<head>

<title>Exam History</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

<div class="container mt-5">

<h2>Exam History</h2>

<table class="table table-bordered">

<tr>

<th>ID</th>
<th>Mode</th>
<th>Score</th>
<th>Total</th>
<th>Date</th>

</tr>

<?php while($row = $history->fetch_assoc()){ ?>

<tr>

<td><?= $row['id'] ?></td>

<td><?= ucfirst($row['mode']) ?></td>

<td><?= $row['score'] ?></td>

<td><?= $row['total_questions'] ?></td>

<td><?= $row['created_at'] ?></td>

</tr>

<?php } ?>

</table>

</div>

</body>
</html>