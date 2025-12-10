<?php
require_once 'config.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not authenticated']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

$title = trim($data['title'] ?? '');
$description = trim($data['description'] ?? '');
$priority = $data['priority'] ?? 'low';
$dueDate = $data['dueDate'] ?? '';

// Validate all fields are present
if (empty($title) || empty($description) || empty($dueDate)) {
    echo json_encode(['success' => false, 'message' => 'All fields are required']);
    exit;
}

// Validate title length
if (strlen($title) < 3 || strlen($title) > 200) {
    echo json_encode(['success' => false, 'message' => 'Title must be 3-200 characters']);
    exit;
}

// Validate description length
if (strlen($description) < 5 || strlen($description) > 1000) {
    echo json_encode(['success' => false, 'message' => 'Description must be 5-1000 characters']);
    exit;
}

// Validate priority
if (!in_array($priority, ['low', 'medium', 'high'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid priority value']);
    exit;
}

// Validate due date format and value
$dateObj = DateTime::createFromFormat('Y-m-d', $dueDate);
if (!$dateObj || $dateObj->format('Y-m-d') !== $dueDate) {
    echo json_encode(['success' => false, 'message' => 'Invalid date format']);
    exit;
}

// Check if due date is not in the past
$today = new DateTime();
$today->setTime(0, 0, 0);
if ($dateObj < $today) {
    echo json_encode(['success' => false, 'message' => 'Due date cannot be in the past']);
    exit;
}

$conn = getConnection();
$userId = $_SESSION['user_id'];

$stmt = $conn->prepare("INSERT INTO tasks (user_id, title, description, priority, due_date) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("issss", $userId, $title, $description, $priority, $dueDate);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Task added successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to add task']);
}

$stmt->close();
$conn->close();
?>
