<?php
include '../includes/auth.php';
include '../includes/db.php';

$exam_id = $_GET['exam_id'];

$sql = "
SELECT
questions.question,
questions.option_a,
questions.option_b,
questions.option_c,
questions.option_d,
questions.answer,
questions.explanation,

exam_answers.selected_answer,
exam_answers.is_correct

FROM exam_answers

JOIN questions
ON exam_answers.question_id = questions.id

WHERE exam_answers.exam_id='$exam_id'
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>

<title>Review Exam</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

<div class="container mt-5">

<h2>Exam Review</h2>

<?php while($q = $result->fetch_assoc()){ ?>

<div class="card mb-4 shadow">

<div class="card-body">

<h5>
<?= $q['question'] ?>
</h5>

<ul>

<li>A. <?= $q['option_a'] ?></li>
<li>B. <?= $q['option_b'] ?></li>
<li>C. <?= $q['option_c'] ?></li>
<li>D. <?= $q['option_d'] ?></li>

</ul>

<p>
<strong>Your Answer:</strong>
<?= $q['selected_answer'] ?>
</p>

<p>
<strong>Correct Answer:</strong>
<?= $q['answer'] ?>
</p>

<p>
<strong>Explanation:</strong>
<?= $q['explanation'] ?>
</p>

</div>

</div>

<?php } ?>

</div>

</body>
</html>