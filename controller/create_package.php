<?php
// controller/create_package.php

require_once '../config/database.php';
require_once '../config/utilities.php';

$error_message = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patientId = $_POST['patient_id'];
    $packageName = $_POST['package_name'];
    $packagePrice = $_POST['package_price'];
    $remainingHours = $_POST['remaining_hours'];
    $validityPeriod = $_POST['validity_period'];
    

    // Fetch the assigned doctor
    $doctor = getAssignedDoctor($patientId);
    if (!$doctor) {
        $error_message = "Doctor not found for the selected patient.";
    } else {
        try {
            $stmt = $conn->prepare("INSERT INTO packages (patient_id, doctor_id, package_name, package_price, remaining_hours, validity_period) 
                                    VALUES (:patient_id, :doctor_id, :package_name, :package_price, :remaining_hours, :validity_period)");
            $stmt->bindParam(':patient_id', $patientId);
            $stmt->bindParam(':doctor_id', $doctor['doctor_id']);
            $stmt->bindParam(':package_name', $packageName);
            $stmt->bindParam(':package_price', $packagePrice);
            $stmt->bindParam(':remaining_hours', $remainingHours);
            $stmt->bindParam(':validity_period', $validityPeriod);
            

            if ($stmt->execute()) {
                $success_message = "Package created successfully!";
            } else {
                $error_message = "Failed to create package.";
            }
        } catch (PDOException $e) {
            $error_message = "Error: " . $e->getMessage();
        }
    }
}
?>
