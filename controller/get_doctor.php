<?php
// controller/get_doctor.php

require_once '../config/utilities.php'; // Include the utilities file

if (isset($_GET['patient_id'])) {
    $patientId = intval($_GET['patient_id']);
    $doctor = getAssignedDoctor($patientId);

    if ($doctor) {
        echo json_encode([
            'doctor_id' => $doctor['doctor_id'],
            'doctor_name' => $doctor['first_name'] . ' ' . $doctor['last_name']
        ]);
    } else {
        echo json_encode(['error' => 'Doctor not found']);
    }
} else {
    echo json_encode(['error' => 'Invalid patient ID']);
}

?>