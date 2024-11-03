<?php
// get_doctor.php

require_once $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';

if (isset($_GET['patient_id'])) {
    $patient_id = $_GET['patient_id'];

    try {
        // Fetch doctor details based on patient ID
        $stmt = $conn->prepare("SELECT d.doctor_id, d.first_name, d.last_name 
                                FROM doctor_details d
                                INNER JOIN patient_details p ON p.doctor_id = d.doctor_id
                                WHERE p.patient_id = :patient_id");
        $stmt->bindParam(':patient_id', $patient_id, PDO::PARAM_INT);
        $stmt->execute();
        $doctor = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($doctor) {
            echo json_encode([
                'doctor_id' => $doctor['doctor_id'],
                'doctor_name' => $doctor['first_name'] . ' ' . $doctor['last_name']
            ]);
        } else {
            echo json_encode(['error' => 'Doctor not found']);
        }
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Invalid request']);
}
?>