<?php

include 'includes/auth.php';
include 'includes/db.php';

$questions = $_SESSION['exam_questions'];

$exam_id = $_SESSION['exam_id'];

$user_answers = $_POST['answers'] ?? [];

$score = 0;

$total = count($questions);

foreach($questions as $q){

    $question_id = $q['id'];

    $correct = $q['answer'];

    $selected =
        $user_answers[$question_id] ?? '';

    $is_correct = 0;

    if($selected == $correct){

        $score++;
        $is_correct = 1;
    }

    $stmt = $conn->prepare("
        INSERT INTO exam_answers(
            exam_id,
            question_id,
            selected_answer,
            is_correct
        )
        VALUES(?,?,?,?)
    ");

    $stmt->bind_param(
        "iisi",
        $exam_id,
        $question_id,
        $selected,
        $is_correct
    );

    $stmt->execute();
}

$update = "
UPDATE exams
SET score='$score',
total_questions='$total'
WHERE id='$exam_id'
";

$conn->query($update);

$_SESSION['final_score'] = $score;
$_SESSION['final_total'] = $total;

header("Location: result.php");
exit();
?>