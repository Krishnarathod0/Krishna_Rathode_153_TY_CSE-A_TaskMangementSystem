<?php
require_once 'config.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not authenticated']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

$taskId = $data['id'] ?? 0;
$status = $data['status'] ?? '';

// Validate task ID
if (empty($taskId) || !is_numeric($taskId)) {
    echo json_encode(['success' => false, 'message' => 'Invalid task ID']);
    exit;
}

// Validate status
if (!in_array($status, ['pending', 'completed'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid status value']);
    exit;
}

$conn = getConnection();
$userId = $_SESSION['user_id'];

$stmt = $conn->prepare("UPDATE tasks SET status = ? WHERE id = ? AND user_id = ?");
$stmt->bind_param("sii", $status, $taskId, $userId);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Task updated successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update task']);
}

$stmt->close();
$conn->close();
?>
