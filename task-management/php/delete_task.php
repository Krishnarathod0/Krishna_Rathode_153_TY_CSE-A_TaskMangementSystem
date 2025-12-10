<?php
require_once 'config.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not authenticated']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

$taskId = $data['id'] ?? 0;

// Validate task ID
if (empty($taskId) || !is_numeric($taskId) || $taskId <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid task ID']);
    exit;
}

$conn = getConnection();
$userId = $_SESSION['user_id'];

$stmt = $conn->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $taskId, $userId);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Task deleted successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to delete task']);
}

$stmt->close();
$conn->close();
?>
