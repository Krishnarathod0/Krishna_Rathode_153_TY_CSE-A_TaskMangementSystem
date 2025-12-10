<?php
require_once 'config.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

$username = trim($data['username'] ?? '');
$password = $data['password'] ?? '';

// Validate fields are present
if (empty($username) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Username and password are required']);
    exit;
}

// Validate username format
if (strlen($username) < 3 || strlen($username) > 20) {
    echo json_encode(['success' => false, 'message' => 'Invalid username or password']);
    exit;
}

// Validate password length
if (strlen($password) < 6 || strlen($password) > 50) {
    echo json_encode(['success' => false, 'message' => 'Invalid username or password']);
    exit;
}

$conn = getConnection();

$stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid username or password']);
    exit;
}

$user = $result->fetch_assoc();

if (password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    echo json_encode(['success' => true, 'message' => 'Login successful']);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid username or password']);
}

$stmt->close();
$conn->close();
?>
