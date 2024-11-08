<?php
// Include database configuration
include '../config/database.php';

// Initialize a message variable
$message = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form input data
    $first_name = htmlspecialchars(trim($_POST['first_name']));
    $last_name = htmlspecialchars(trim($_POST['last_name']));
    $date_of_birth = htmlspecialchars(trim($_POST['date_of_birth']));
    $gender = htmlspecialchars(trim($_POST['gender']));
    $phone_number = htmlspecialchars(trim($_POST['phone_number']));
    $email = htmlspecialchars(trim($_POST['email']));
    $address = htmlspecialchars(trim($_POST['address']));
    $emergency_contact_name = htmlspecialchars(trim($_POST['emergency_contact_name']));
    $emergency_contact_phone = htmlspecialchars(trim($_POST['emergency_contact_phone']));
    $medical_history = htmlspecialchars(trim($_POST['medical_history']));
    $allergies = htmlspecialchars(trim($_POST['allergies']));
    $doctor_id = htmlspecialchars(trim($_POST['doctor_id']));
    $vip_status = isset($_POST['vip_status']) ? 1 : 0; // Check if the VIP status is checked

    try {
        // Prepare the SQL statement
        $stmt = $conn->prepare("INSERT INTO patient_details (
            first_name, last_name, date_of_birth, gender, phone_number, email, 
            address, emergency_contact_name, emergency_contact_phone, 
            medical_history, allergies, doctor_id, vip_status
        ) VALUES (
            :first_name, :last_name, :date_of_birth, :gender, :phone_number, :email, 
            :address, :emergency_contact_name, :emergency_contact_phone, 
            :medical_history, :allergies, :doctor_id, :vip_status
        )");

        // Bind parameters to the SQL query
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':date_of_birth', $date_of_birth);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':phone_number', $phone_number);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':emergency_contact_name', $emergency_contact_name);
        $stmt->bindParam(':emergency_contact_phone', $emergency_contact_phone);
        $stmt->bindParam(':medical_history', $medical_history);
        $stmt->bindParam(':allergies', $allergies);
        $stmt->bindParam(':doctor_id', $doctor_id);
        $stmt->bindParam(':vip_status', $vip_status);

        // Execute the statement
        $stmt->execute();

         // Redirect to the form with a success message
         header("Location: ../register_patient_form.php?success=true");
         exit();
    } catch (PDOException $e) {
        // Handle errors
        $message = "Error: " . $e->getMessage();
    }
}

// Close the database connection
$conn = null;
?>
