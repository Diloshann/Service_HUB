<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title> Become a Worker </title>
  <!-- Your other styles -->
     <style>
      body {
        font-family: Arial, sans-serif;
         margin: 0;
        padding: 0;
       background: url('fbg.jpg') no-repeat center center fixed; /* Background image */
        background-size: cover; /* Make sure it covers the entire screen */
         color: #fff;  /* White text */
        display: flex;
       justify-content: center;
        align-items: center;
         min-height: 100vh;  /* Ensure the body takes full height */
      }
    
       .container {
         max-width: 800px;
         width: 100%;
       padding: 25px;
        background: rgba(255, 255, 255, 0.1); /* Semi-transparent white */
       border-radius: 10px;
         box-shadow: 0 0 20px rgba(255, 0, 0, 0.6); /* Red shadow */
       border: 1px solid rgba(255, 0, 0, 0.5); /* Red border */
        overflow-y: auto; /* Enable scrolling if the content overflows */
      }
    
      h1 {
        text-align: center;
        color: #FF0000; /* Red heading */
         font-size: 2.5em;
        margin-bottom: 20px;
       font-weight: 600;
      }
    
      .form-group {
        margin-bottom: 20px;
      }
    
       .form-group label {
        display: block;
       margin-bottom: 8px;
         font-weight: bold;
       color: #FF0000;   /* Red labels */
        text-align: left;
      }
    
      .form-group input[type="text"],
       .form-group input[type="tel"],
     .form-group input[type="file"],
      .form-group select,
       .form-group textarea {
        width: 100%;
        padding: 12px;
       margin: 8px 0 16px;
        border: 1px solid #FF0000;   /* Red border */
         border-radius: 6px;
       font-size: 1em;
        box-sizing: border-box;
         background: rgba(255, 255, 255, 0.1);   /* Semi-transparent white */
        color: #fff;   /* White text */
      }
    
       .form-group select {
       background: rgba(255, 255, 255, 0.9);  /* Less transparent for dropdown */
        color: #333;  /* Darker text for better visibility */
      }
    
      .form-group input:focus,
     .form-group select:focus,
      .form-group textarea:focus {
        border-color: #FF4500;  /* Brighter red on focus */
         outline: none;
        box-shadow: 0 0 8px rgba(255, 69, 0, 0.6);  /* Red glow */
      }
    
      .form-group textarea {
       resize: vertical;
        height: 100px;
      }
    
      .form-group input[type="file"] {
        padding: 5px;
      }
    
      .submit-button {
        display: block;
        width: 100%;
       padding: 14px;
         background-color: #FF0000; /* Red button */
        color: white;
       border: none;
        border-radius: 6px;
         font-size: 1.1em;
        cursor: pointer;
        transition: background 0.3s ease;
      }
    
      .submit-button:hover {
        background-color: #B22222;  /* Darker red on hover */
      }
    
      .profile-picture-preview {
        text-align: center;
       margin-bottom: 20px;
      }
    
      .profile-picture-preview img {
        width: 150px;
       height: 150px;
        border-radius: 50%;
         object-fit: cover;
        border: 2px solid #FF0000;  /* Red border */
      }
    
      a {
         color: #FF0000; /* Red links */
        text-decoration: none;
       font-size: 1em;
        margin-top: 20px;
        display: inline-block;
       transition: color 0.3s ease;
      }
      .success-message {
        background-color: #4CAF50;
       color: white;
        padding: 15px;
        margin-bottom: 20px;
         border-radius: 5px;
        text-align: center;
    }
    
     .error {
        background-color: #f44336;
        color: white;
       padding: 10px;
        margin-bottom: 10px;
         border-radius: 5px;
        text-align: center;
    }
      a:hover {
        color: #B22222;     /* Darker red on hover */
        text-decoration: underline;
      }
    
      .file-input {
        position: relative;
       overflow: hidden;
        margin-bottom: 16px;
      }
    
      .file-input input[type="file"] {
        position: absolute;
       top: 0;
        right: 0;
         min-width: 100%;
        min-height: 100%;
       font-size: 100px;
        text-align: right;
        filter: alpha(opacity=0);
       opacity: 0;
        outline: none;
         cursor: pointer;
        display: block;
      }
    
       .file-input-label {
        display: block;
       padding: 12px;
        background: rgba(255, 255, 255, 0.1); /* Semi-transparent white */
        border: 1px solid #FF0000; /* Red border */
         border-radius: 6px;
        text-align: center;
       color: #FF0000; /* Red text */
        cursor: pointer;
        transition: background 0.3s ease;
      }
    
      .file-input-label:hover {
        background: rgba(255, 0, 0, 0.2); /* Semi-transparent red on hover */
      }
    
      </style>
</head>
<body>
    <div class="container">
        <h1>Become a Worker</h1>
        <div id="messageContainer"></div>
        <form id="workerForm" enctype="multipart/form-data">
            <!-- Profile Picture Upload -->
            <div class="form-group">
                <label for="profilePicture">Upload Profile Picture</label>
                 <input type="file" id="profilePicture" name="profilePicture" accept="image/*" onchange="previewProfilePicture(event)">
                <div class="profile-picture-preview">
                    <img id="profilePicturePreview" src="#" alt="Profile Picture Preview" style="display: none;">
                </div>
            </div>

            <!-- Name -->
             <div class="form-group">
                 <label for="fullName">Full Name</label>
                <input type="text" id="fullName" name="fullName" placeholder="Enter your full name" required>
            </div>

            <!-- Phone Number with Country Code -->
            <div class="form-group">
                <label for="phoneNumber">Phone Number</label>
                <div class="phone-input-group">
                    <img src="https://flagcdn.com/w40/lk.png" alt="Sri Lanka Flag" class="country-flag" />
                     <span class="country-code">+94</span>
                    <input type="tel" name="phoneNumber" pattern="\d{9}" maxlength="9" placeholder="Enter 9-digit phone number" required>
                </div>
            </div>
            <style>
                .phone-input-group {
                    display: flex;
                   align-items: center;
                    gap: 8px;
                }
                .country-flag {
                    width: 30px;
                   height: 20px;
                    border-radius: 3px;
                     border: 1px solid #FF0000;
                }
                .country-code {
                    color: #fff;
                    font-size: 1em;
                   font-weight: bold;
                    padding: 0 6px;
                     border: 1px solid #FF0000;
                    border-radius: 6px;
                   background: rgba(255, 255, 255, 0.1);
                    user-select: none;
                }
                #phoneNumber {
                    flex-grow: 1;
                   padding: 10px;
                    border-radius: 6px;
                     border: 1px solid #FF0000;
                    background: rgba(255, 255, 255, 0.1);
                   color: #fff;
                    font-size: 1em;
                       box-sizing: border-box;
                }
                 #phoneNumber:focus {
                    border-color: #FF4500;
                   outline: none;
                    box-shadow: 0 0 8px rgba(255, 69, 0, 0.6);
                }
            </style>

            <!-- Title -->
            <div class="form-group">
                <label for="title">Title</label>
               <input type="text" id="title" name="title" placeholder="e.g., Professional Carpenter, Expert Painter" required>
            </div>

            <!-- Work Type Selection -->
            <div class="form-group">
                <label for="workType">Preferred Work Type</label>
                <select id="workType" name="workType" required>
                  <option value="">Select your work type</option>
                   <option value="carpenter">Carpenter</option>
                 <option value="plumber">Plumber</option>
                  <option value="electrician">Electrician</option>
                 <option value="mason">Mason</option>
                   <option value="painter">Painter</option>
               <option value="roofer">Roofer</option>
                  <option value="mechanic">Mechanic</option>
                <option value="gardener">Gardener</option>
                  <option value="tailor">Tailor</option>
                 <option value="driver">Driver</option>
                  <option value="cook_chef">Cook/Chef</option>
                 <option value="cleaner">Cleaner</option>
                  <option value="housemaid">Housemaid</option>
                   <option value="security_guard">Security Guard</option>
                  <option value="washerman">Washerman</option>
                 <option value="mobile_phone_repair">Mobile Phone Repair Technician</option>
                   <option value="welder">Welder</option>
                  <option value="locksmith">Locksmith</option>
                 <option value="photographer">Photographer</option>
                  <option value="videographer">Videographer</option>
                  <option value="event_organizer">Event Organizer</option>
                 <option value="personal_trainer">Personal Trainer</option>
                   <option value="hair_stylist">Hair Stylist</option>
                  <option value="computer_technician">Computer Technician</option>
                 <option value="laundry_service">Laundry Service Provider</option>
                  <option value="air_conditioning_technician">Air-Conditioning Technician</option>
                   <option value="garden_maintenance">Garden Maintenance Worker</option>
                  <option value="welding_worker">Welding Worker</option>
                 <option value="bookkeeper">Bookkeeper</option>
                  <option value="tailoring_service">Tailoring Service</option>
                  <option value="sound_technician">Sound Technician (for events)</option>
                   <option value="it_support_technician">IT Support Technician</option>
                  <option value="other">Other</option>
                </select>
            </div>

            <!-- City Selection -->
             <div class="form-group">
                <label for="city">Select City</label>
               <select id="city" name="city" required>
                    <option value="">Select your city</option>
                   <option value="Colombo">Colombo</option>
                    <option value="Kandy">Kandy</option>
                    <option value="Galle">Galle</option>
                   <option value="Jaffna">Jaffna</option>
                    <option value="Anuradhapura">Anuradhapura</option>
                     <option value="Trincomalee">Trincomalee</option>
                   <option value="Negombo">Negombo</option>
                    <option value="Batticaloa">Batticaloa</option>
                    <option value="Ratnapura">Ratnapura</option>
                     <option value="Matara">Matara</option>
                    <option value="Kurunegala">Kurunegala</option>
                    <option value="Badulla">Badulla</option>
                   <option value="Polonnaruwa">Polonnaruwa</option>
                    <option value="Kalutara">Kalutara</option>
                   <option value="Matale">Matale</option>
                     <option value="Hambantota">Hambantota</option>
                    <option value="Ampara">Ampara</option>
                    <option value="Nuwara Eliya">Nuwara Eliya</option>
                   <option value="Dambulla">Dambulla</option>
                    <option value="Moratuwa">Moratuwa</option>
                   <option value="Kegalle">Kegalle</option>
                    <option value="Puttalam">Puttalam</option>
                     <option value="Vavuniya">Vavuniya</option>
                    <option value="Mannar">Mannar</option>
                   <option value="Kilinochchi">Kilinochchi</option>
                </select>
            </div>

            <!-- Details -->
            <div class="form-group">
                <label for="details">Details About You</label>
                <textarea id="details" name="details" placeholder="Describe your skills, experience, and services..." required></textarea>
            </div>

            <!-- Work Pictures Upload -->
             <div class="form-group">
                <label for="workPictures">Upload Pictures of Your Work</label>
               <input type="file" id="workPictures" name="workPictures[]" accept="image/*" multiple>
            </div>

            <!-- Additional Notes -->
            <div class="form-group">
                <label for="additionalNotes">Additional Notes</label>
                <textarea id="additionalNotes" name="additionalNotes" placeholder="Any additional information you'd like to share..."></textarea>
             </div>

            <!-- Submit Button -->
            <button type="submit" class="submit-button">Submit</button>
        </form>
    </div>

    <script>
        function previewProfilePicture(event) {
            const preview = document.getElementById('profilePicturePreview');
             const file = event.target.files[0];
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                 preview.style.display = 'block';
            }
            
            if (file) {
                reader.readAsDataURL(file);
            }
        }


        document.getElementById('workerForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const messageContainer = document.getElementById('messageContainer');
            
            fetch('worker_submit.php', {
                method: 'POST',
                body: formData
            })
             .then(response => response.json())
            .then(data => {
                if (data.success) {
                    messageContainer.innerHTML = `<div class="success-message">${data.message}</div>`;
                     document.getElementById('workerForm').reset();
                    document.getElementById('profilePicturePreview').style.display = 'none';
                } else {
                    let errorHtml = '';
                    data.errors.forEach(error => {
                        errorHtml += `<div class="error">${error}</div>`;
                    });
                    messageContainer.innerHTML = errorHtml;
                }
            })
            .catch(error => {
                messageContainer.innerHTML = `<div class="error">An error occurred: ${error.message}</div>`;
            });
        });
    </script>
</body>
</html>
