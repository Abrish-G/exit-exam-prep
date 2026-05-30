<?php
header('Content-Type: application/json');
require_once '../includes/db.php';

$course_id = isset($_GET['course_id']) ? intval($_GET['course_id']) : 0;

if ($course_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'course_id is required']);
    exit();
}

$stmt = $conn->prepare('SELECT id, question_text, option_a, option_b, option_c, option_d FROM questions WHERE course_id = ?');
$stmt->bind_param('i', $course_id);
$stmt->execute();
$result = $stmt->get_result();
$questions = [];
while ($row = $result->fetch_assoc()) {
    $questions[] = $row;
}
$stmt->close();

echo json_encode(['success' => true, 'questions' => $questions]);
