<?php
// Start the session
session_start();

// Include the database connection file
include "../config.php";

// Set the username (you can fetch this from the session or database)
$username = "Admin"; // Replace with dynamic username if needed

// Handle profile image upload
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profile_image'])) {
    $target_dir = "uploads/"; // Directory to store uploaded images
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true); // Create the directory if it doesn't exist
    }
    $target_file = $target_dir . basename($_FILES['profile_image']['name']);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if the file is an image
    $check = getimagesize($_FILES['profile_image']['tmp_name']);
    if ($check !== false) {
        // Check file size (max 5MB)
        if ($_FILES['profile_image']['size'] <= 5000000) {
            // Allow only certain file formats
            if ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif") {
                // Upload the file
                if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_file)) {
                    // Update the profile image path in the database
                    $stmt = $conn->prepare("UPDATE admin SET profile_image = ? WHERE username = ?");
                    if ($stmt) {
                        $stmt->bind_param("ss", $target_file, $username);
                        if ($stmt->execute()) {
                            $success = "Profile image updated successfully!";
                        } else {
                            $error = "Failed to update profile image in the database.";
                        }
                        $stmt->close();
                    } else {
                        $error = "Failed to prepare the SQL statement.";
                    }
                } else {
                    $error = "Failed to upload the image.";
                }
            } else {
                $error = "Only JPG, JPEG, PNG, and GIF files are allowed.";
            }
        } else {
            $error = "File size is too large. Maximum size is 5MB.";
        }
    } else {
        $error = "File is not an image.";
    }
}

// Fetch the current profile image path from the database
$stmt = $conn->prepare("SELECT profile_image FROM admin WHERE username = ?");
if ($stmt) {
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($profile_image);
    $stmt->fetch();
    $stmt->close();
} else {
    $error = "Failed to prepare the SQL statement.";
}

// If no profile image is set, use the default image
if (empty($profile_image)) {
    $profile_image = 'assets/img/user.png';
}
?>

<!-- Header Section -->
<header class="shadow-sm bg-white" style="height: 60px;">
    <div class="container-fluid h-100">
        <div class="row align-items-center h-100">
            <!-- Search Box (Centered) -->
            <div class="col-md-6 offset-md-3 d-flex justify-content-center">
                <form class="d-flex align-items-center" style="max-width: 400px; width: 100%;">
                    <div class="input-group">
                        <input class="form-control rounded-pill border-primary" type="search" placeholder="Search..." aria-label="Search" style="border-color: #0a3a4a;">
                        <button class="btn btn-primary rounded-circle ms-2 p-1" type="submit" style="background-color: #0a3a4a; border: none; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-search text-white" style="font-size: 14px;"></i>
                        </button>
                    </div>
                </form>
            </div>

            <!-- User Profile and Notification Icon (Right-Aligned) -->
            <div class="col-md-3 text-end">
                <div class="d-flex align-items-center justify-content-end">
                    <!-- Circular User Image (Clickable to Open Modal) -->
                    <div class="rounded-circle overflow-hidden me-2" style="width: 40px; height: 40px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#profileImageModal">
                        <img src="<?php echo htmlspecialchars($profile_image); ?>" alt="User Image" class="img-fluid" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <!-- Username -->
                    <span class="me-3 fw-bold text-dark"><?php echo htmlspecialchars($username); ?></span>
                    <!-- Notification Icon -->
                    <a href="#" class="text-dark position-relative">
                        <i class="fas fa-bell fa-lg"></i>
                        <!-- Notification Badge -->
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            3 <!-- Replace with dynamic notification count if available -->
                            <span class="visually-hidden">unread notifications</span>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Modal for Profile Image Upload -->
<div class="modal fade" id="profileImageModal" tabindex="-1" aria-labelledby="profileImageModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="profileImageModalLabel">Update Profile Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php if (isset($success)): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="profile_image" class="form-label">Choose Profile Image</label>
                        <input type="file" class="form-control" id="profile_image" name="profile_image" accept="image/*" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Upload Image</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>