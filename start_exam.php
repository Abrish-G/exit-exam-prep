<?php

session_start();

include 'includes/auth.php';
include 'includes/db.php';

$user_id = $_SESSION['user_id'];

$mode = $_POST['mode'];

$selected_courses = $_POST['courses'] ?? [];


/*
|--------------------------------------------------------------------------
| CREATE EXAM SESSION
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare("
    INSERT INTO exams(user_id, mode)
    VALUES(?,?)
");

$stmt->bind_param(
    "is",
    $user_id,
    $mode
);

$stmt->execute();

$exam_id = $stmt->insert_id;


/*
|--------------------------------------------------------------------------
| BUILD FILTERS
|--------------------------------------------------------------------------
*/

$where = [];


/*
|--------------------------------------------------------------------------
| COURSE FILTER
|--------------------------------------------------------------------------
*/

if(count($selected_courses) > 0){

    $safe_courses = array_map('intval', $selected_courses);

    $course_ids = implode(",", $safe_courses);

    $where[] = "questions.course_id IN ($course_ids)";
}


/*
|--------------------------------------------------------------------------
| DATASET FILTER
|--------------------------------------------------------------------------
*/

if($label != 'all' && !empty($label)){

    $where[] = "questions.label = '" . $conn->real_escape_string($label) . "'";
}


/*
|--------------------------------------------------------------------------
| BUILD WHERE SQL
|--------------------------------------------------------------------------
*/

$where_sql = "";

if(count($where) > 0){

    $where_sql = "WHERE " . implode(" AND ", $where);
}


/*
|--------------------------------------------------------------------------
| GET RANDOM QUESTIONS + COURSE NAME
|--------------------------------------------------------------------------
*/

$question_sql = "
SELECT
    questions.*,
    courses.course_name
FROM questions
LEFT JOIN courses
ON questions.course_id = courses.id
$where_sql
ORDER BY RAND()
LIMIT 100
";

$result = $conn->query($question_sql);


/*
|--------------------------------------------------------------------------
| STORE QUESTIONS
|--------------------------------------------------------------------------
*/

$questions = [];

while($row = $result->fetch_assoc()){

    $questions[] = $row;
}


/*
|--------------------------------------------------------------------------
| SAVE SESSION
|--------------------------------------------------------------------------
*/

$_SESSION['exam_questions'] = $questions;

$_SESSION['exam_id'] = $exam_id;

$_SESSION['exam_mode'] = $mode;

$_SESSION['exam_label'] = $label;

// Save the exam start timestamp
$_SESSION['exam_start_time'] = time();


/*
|--------------------------------------------------------------------------
| REDIRECT
|--------------------------------------------------------------------------
*/

header("Location: exam.php");
exit();