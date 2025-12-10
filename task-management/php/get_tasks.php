<?php
require_once 'config.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not authenticated']);
    exit;
}

$filter = $_GET['filter'] ?? 'all';
$userId = $_SESSION['user_id'];

$conn = getConnection();

$sql = "SELECT * FROM tasks WHERE user_id = ?";
if ($filter !== 'all') {
    $sql .= " AND status = ?";
}
$sql .= " ORDER BY created_at DESC";

$stmt = $conn->prepare($sql);
if ($filter !== 'all') {
    $stmt->bind_param("is", $userId, $filter);
} else {
    $stmt->bind_param("i", $userId);
}

$stmt->execute();
$result = $stmt->get_result();

$tasks = [];
while ($row = $result->fetch_assoc()) {
    $tasks[] = $row;
}

echo json_encode(['success' => true, 'tasks' => $tasks]);

$stmt->close();
$conn->close();
?>
