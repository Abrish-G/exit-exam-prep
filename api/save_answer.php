<?php
header('Content-Type: application/json');
require_once '../includes/db.php';

$input = json_decode(file_get_contents('php://input'), true);
if (empty($input['user_id']) || empty($input['question_id']) || empty($input['answer'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid payload']);
    exit();
}

$user_id = intval($input['user_id']);
$question_id = intval($input['question_id']);
$answer = substr(trim($input['answer']), 0, 1);

$stmt = $conn->prepare('INSERT INTO exam_results (user_id, course_id, score, total_questions) VALUES (?, ?, ?, ? )');
if ($stmt) {
    $stmt->bind_param('iiii', $user_id, $question_id, $score, $total_questions);
    $score = 0;
    $total_questions = 0;
    $stmt->execute();
    $stmt->close();
}

echo json_encode(['success' => true, 'message' => 'Answer saved']);
