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
$loginEmail = trim($conn->real_escape_string($_POST['loginEmail']));
$loginPassword = $_POST['loginPassword'];

                       // Validate inputs
if (empty($loginEmail) || empty($loginPassword)) {
    die("Both email and password are required.");
}

                         // Check if user exists
$stmt = $conn->prepare("SELECT id, signupUsername, signupPassword FROM register1 WHERE signupEmail = ?");
$stmt->bind_param("s", $loginEmail);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Invalid email or password.");
}

$user = $result->fetch_assoc();

                         // Verify password
if (password_verify($loginPassword, $user['signupPassword'])) {
                       // Set session variables
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['signupUsername'];
    $_SESSION['email'] = $loginEmail;
    
                      // Check for admin credentials
    if ($loginEmail === 'admin@gmail.com' && $loginPassword === 'adminadmin') {
                       // Redirect to admin page
        header("Location: admin.html");
    } else {
                      // Redirect to regular user dashboard
        header("Location: Front.php");
    }
    exit();
} else {
    die("Invalid email or password.");
}

$stmt->close();
$conn->close();
?>