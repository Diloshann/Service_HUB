<?php
session_start();
  // Database configuration
$host = 'localhost';
 $dbname = 'project';
$username = 'root';
$password = '';

  // Create connection
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

    // Create uploads directory if it doesn't exist
if (!file_exists('uploads')) {
    mkdir('uploads', 0777, true);
}

 // Function to sanitize input data
function sanitizeInput($data) {
    $data = trim($data);
     $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

  // Initialize variables
 $errors = [];
$success = false;

 // Process form when submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     // Validate and sanitize inputs
    $fullName = sanitizeInput($_POST['fullName']);
     $phoneNumber = sanitizeInput($_POST['phoneNumber']);
  $title = sanitizeInput($_POST['title']);
    $workType = sanitizeInput($_POST['workType']);
   $city = sanitizeInput($_POST['city']);
    $details = sanitizeInput($_POST['details']);
    $additionalNotes = sanitizeInput($_POST['additionalNotes']);

     // Validate required fields
     if (empty($fullName)) $errors[] = "Full name is required";
   if (empty($phoneNumber)) $errors[] = "Phone number is required";
    if (empty($title)) $errors[] = "Title is required";
     if (empty($workType)) $errors[] = "Work type is required";
    if (empty($city)) $errors[] = "City is required";
    if (empty($details)) $errors[] = "Details are required";

      // Handle profile picture upload
    $profilePicturePath = null;
     if (isset($_FILES['profilePicture']) && $_FILES['profilePicture']['error'] === UPLOAD_ERR_OK) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
         $fileType = $_FILES['profilePicture']['type'];
        
        if (in_array($fileType, $allowedTypes)) {
            $extension = pathinfo($_FILES['profilePicture']['name'], PATHINFO_EXTENSION);
             $filename = uniqid('profile_') . '.' . $extension;
            $destination = 'uploads/' . $filename;
            
            if (move_uploaded_file($_FILES['profilePicture']['tmp_name'], $destination)) {
                $profilePicturePath = $destination;
            } else {
                $errors[] = "Failed to upload profile picture";
            }
        } else {
            $errors[] = "Invalid file type for profile picture. Only JPG, PNG, and GIF are allowed.";
        }
    }

      // Handle work pictures upload
    $workPicturesPaths = [];
    if (isset($_FILES['workPictures']) && is_array($_FILES['workPictures']['name'])) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        
        for ($i = 0; $i < count($_FILES['workPictures']['name']); $i++) {
            if ($_FILES['workPictures']['error'][$i] === UPLOAD_ERR_OK) {
                $fileType = $_FILES['workPictures']['type'][$i];
                
                 if (in_array($fileType, $allowedTypes)) {
                    $extension = pathinfo($_FILES['workPictures']['name'][$i], PATHINFO_EXTENSION);
                      $filename = uniqid('work_') . '.' . $extension;
                    $destination = 'uploads/' . $filename;
                    
                     if (move_uploaded_file($_FILES['workPictures']['tmp_name'][$i], $destination)) {
                        $workPicturesPaths[] = $destination;
                    }
                }
            }
        }
    }

         // If no errors, insert into database
     if (empty($errors)) {
        try {
            $workPicturesString = implode(',', $workPicturesPaths);
            
             $stmt = $conn->prepare("INSERT INTO workers (profile_picture, full_name, phone_number, title, work_type, city, details, work_pictures, additional_notes) 
                                   VALUES (:profile_picture, :full_name, :phone_number, :title, :work_type, :city, :details, :work_pictures, :additional_notes)");
            
            $stmt->bindParam(':profile_picture', $profilePicturePath);
           $stmt->bindParam(':full_name', $fullName);
            $stmt->bindParam(':phone_number', $phoneNumber);
             $stmt->bindParam(':title', $title);
          $stmt->bindParam(':work_type', $workType);
            $stmt->bindParam(':city', $city);
             $stmt->bindParam(':details', $details);
            $stmt->bindParam(':work_pictures', $workPicturesString);
          $stmt->bindParam(':additional_notes', $additionalNotes);
            
             $stmt->execute();
            
            $success = true;
        } catch(PDOException $e) {
             $errors[] = "Database error: " . $e->getMessage();
        }
    }
}

   // Return JSON response
header('Content-Type: application/json');
 echo json_encode([
    'success' => $success,
      'errors' => $errors,
    'message' => $success ? 'Worker registration successful!' : 'Please fix the errors below.'
]);
?>
