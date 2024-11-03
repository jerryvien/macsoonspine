<?php
// config/utilities.php

require_once 'database.php'; // Include your database connection

/**
 * Fetch the assigned doctor for a given patient ID.
 *
 * @param int $patientId The patient ID.
 * @return array|null An associative array with doctor details or null if not found.
 */
function getAssignedDoctor($patientId) {
    global $conn;
    try {
        $stmt = $conn->prepare("SELECT d.doctor_id, d.first_name, d.last_name 
                                FROM doctor_details d
                                JOIN patient_details p ON p.doctor_id = d.doctor_id
                                WHERE p.patient_id = :patientId");
        $stmt->bindParam(':patientId', $patientId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error fetching doctor: " . $e->getMessage());
        return null;
    }
}
