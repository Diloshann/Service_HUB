<?php
include 'session.php';

// Database configuration
$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "project";

// Create connection
$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$signupUsername = trim($conn->real_escape_string($_POST['signupUsername']));
$signupEmail = trim($conn->real_escape_string($_POST['signupEmail']));
$signupPassword = $_POST['signupPassword'];
$signupRePassword = $_POST['signupRePassword'];

// Validate inputs
$errors = [];

if (empty($signupUsername)) {
    $errors[] = "Username is required.";
} elseif (strlen($signupUsername) < 4) {
    $errors[] = "Username must be at least 4 characters.";
}

if (empty($signupEmail)) {
    $errors[] = "Email is required.";
} elseif (!filter_var($signupEmail, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email format.";
}

if (empty($signupPassword)) {
    $errors[] = "Password is required.";
} elseif (strlen($signupPassword) < 8) {
    $errors[] = "Password must be at least 8 characters.";
}

if ($signupPassword !== $signupRePassword) {
    $errors[] = "Passwords do not match.";
}

// Check if email already exists
if (empty($errors)) {
    $stmt = $conn->prepare("SELECT id FROM register1 WHERE signupEmail = ?");
    $stmt->bind_param("s", $signupEmail);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $errors[] = "Email already registered.";
    }
    $stmt->close();
}

// If errors, display them
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo "<div class='error'>$error</div>";
    }
    echo "<a href='register.html'>Go back</a>";
    exit();
}

// Hash the password
$hashedPassword = password_hash($signupPassword, PASSWORD_DEFAULT);

// Insert user into database
$stmt = $conn->prepare("INSERT INTO register1 (signupUsername, signupEmail, signupPassword, signupRePassword) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $signupUsername, $signupEmail, $hashedPassword, $hashedPassword);

if ($stmt->execute()) {
    $_SESSION['user_id'] = $stmt->insert_id;
    $_SESSION['username'] = $signupUsername;
    $_SESSION['email'] = $signupEmail;
    
    header("Location: login.html");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>