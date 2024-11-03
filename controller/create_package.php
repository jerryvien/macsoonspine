<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include the database connection
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';

// Initialize a variable for error or success message
$message = "";

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get and sanitize form data
    $patient_id = htmlspecialchars($_POST['patient_id'] ?? '');
    $doctor_id = htmlspecialchars($_POST['doctor_id'] ?? '');
    $package_name = htmlspecialchars($_POST['package_name'] ?? '');
    $package_price = htmlspecialchars($_POST['package_price'] ?? '');
    $remaining_hours = htmlspecialchars($_POST['remaining_hours'] ?? '');
    $validity_period = htmlspecialchars($_POST['validity_period'] ?? '');

    // Check if required fields are not empty
    if (!empty($patient_id) && !empty($doctor_id) && !empty($package_name) && !empty($package_price) && !empty($remaining_hours) && !empty($validity_period)) {
        try {
            // Prepare the SQL statement
            $stmt = $conn->prepare("INSERT INTO packages (patient_id, doctor_id, package_name, package_price, remaining_hours, validity_period) VALUES (:patient_id, :doctor_id, :package_name, :package_price, :remaining_hours, :validity_period)");

            // Bind parameters
            $stmt->bindParam(':patient_id', $patient_id);
            $stmt->bindParam(':doctor_id', $doctor_id);
            $stmt->bindParam(':package_name', $package_name);
            $stmt->bindParam(':package_price', $package_price);
            $stmt->bindParam(':remaining_hours', $remaining_hours);
            $stmt->bindParam(':validity_period', $validity_period);

            // Execute the statement
            if ($stmt->execute()) {
                // Redirect back to the form page with a success message
                header("Location: ../create_package_form.php?success=true");
                exit();
            } else {
                $message = "Failed to create the package. Please try again.";
            }
        } catch (PDOException $e) {
            $message = "Error: " . $e->getMessage();
        }
    } else {
        $message = "All fields are required.";
    }
}

// Redirect back to the form page with an error message if necessary
if (!empty($message)) {
    header("Location: ../create_package_form.php?error=" . urlencode($message));
    exit();
}
