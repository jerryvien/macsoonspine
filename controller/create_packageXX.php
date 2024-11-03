<?php
// Include the database connection
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';

// Initialize messages
$error_message = '';
$success_message = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Collect form data
    $patient_id = $_POST['patient_id'] ?? '';
    $doctor_id = $_POST['doctor_id'] ?? '';
    $package_name = $_POST['package_name'] ?? '';
    $package_price = $_POST['package_price'] ?? '';
    $remaining_hours = $_POST['remaining_hours'] ?? '';
    $validity_period = $_POST['validity_period'] ?? '';

    // Validate required fields
    if (empty($patient_id) || empty($doctor_id) || empty($package_name) || empty($package_price) || empty($remaining_hours) || empty($validity_period)) {
        $error_message = 'All fields are required.';
    } else {
        // Insert the data into the database
        try {
            $stmt = $conn->prepare("INSERT INTO packages (patient_id, doctor_id, package_name, package_price, remaining_hours, validity_period) VALUES (:patient_id, :doctor_id, :package_name, :package_price, :remaining_hours, :validity_period)");
            $stmt->bindParam(':patient_id', $patient_id);
            $stmt->bindParam(':doctor_id', $doctor_id);
            $stmt->bindParam(':package_name', $package_name);
            $stmt->bindParam(':package_price', $package_price);
            $stmt->bindParam(':remaining_hours', $remaining_hours);
            $stmt->bindParam(':validity_period', $validity_period);

            if ($stmt->execute()) {
                $success_message = 'Package created successfully!';
            } else {
                $error_message = 'Failed to create the package. Please try again.';
            }
        } catch (PDOException $e) {
            $error_message = 'Database error: ' . $e->getMessage();
        }
    }
}
?>
