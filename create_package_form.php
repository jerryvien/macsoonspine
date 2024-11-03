<?php
// Include the database connection
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// Initialize variables to store data for dropdowns
$patients = [];
$doctors = [];

// Fetch patient details for the dropdown
try {
    $stmt = $conn->prepare("SELECT patient_id, first_name, last_name FROM patient_details");
    $stmt->execute();
    $patients = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching patients: " . $e->getMessage();
}

// Fetch doctor details for the dropdown
try {
    $stmt = $conn->prepare("SELECT doctor_id, first_name, last_name FROM doctor_details");
    $stmt->execute();
    $doctors = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching doctors: " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Create Package - NiceAdmin Bootstrap Template</title>
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <!-- Include Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Include Select2 JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
</head>
<body>

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/topbar.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/sidebar.php';
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Create Package</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item">Packages</li>
                <li class="breadcrumb-item active">Create</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">New Package Form</h5>

                        <?php
                        // Check for success or error messages
                        if (isset($_GET['success']) && $_GET['success'] === 'true') {
                            echo '<div class="alert alert-success mt-3">Package created successfully!</div>';
                        }
                        if (isset($_GET['error'])) {
                            echo '<div class="alert alert-danger mt-3">' . htmlspecialchars($_GET['error']) . '</div>';
                        }
                        ?>

                        <!-- Package Creation Form -->
                        <form action="controller/create_package.php" method="POST">
                            <div class="row mb-3">
                                <label for="patientId" class="col-md-4 col-lg-3 col-form-label">Patient</label>
                                <div class="col-md-8 col-lg-9">
                                    <select name="patient_id" class="form-control select2" id="patientId" required>
                                        <option value="">Select a Patient</option>
                                        <?php foreach ($patients as $patient): ?>
                                            <option value="<?= $patient['patient_id'] ?>"><?= htmlspecialchars($patient['first_name'] . ' ' . $patient['last_name']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="doctorId" class="col-md-4 col-lg-3 col-form-label">Assigned Doctor</label>
                                <div class="col-md-8 col-lg-9">
                                    <!-- Ensure this field is populated and readonly -->
                                    <input type="text" class="form-control" id="doctorName" name="doctor_name" readonly>
                                    <input type="hidden" id="doctorId" name="doctor_id"> <!-- Hidden field to hold the doctor_id -->
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="packageName" class="col-md-4 col-lg-3 col-form-label">Package Name</label>
                                <div class="col-md-8 col-lg-9">
                                    <select name="package_name" class="form-control" id="packageName" required onchange="populateHours();">
                                        <option value="10 hour package">10 hour package</option>
                                        <option value="20 hour package">20 hour package</option>
                                        <option value="30 hour package">30 hour package</option>
                                        <option value="40 hour package">40 hour package</option>
                                        <option value="50 hour package">50 hour package</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="packagePrice" class="col-md-4 col-lg-3 col-form-label">Package Price</label>
                                <div class="col-md-8 col-lg-9">
                                    <input name="package_price" type="number" class="form-control" id="packagePrice" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="remainingHours" class="col-md-4 col-lg-3 col-form-label">Remaining Hours</label>
                                <div class="col-md-8 col-lg-9">
                                    <input name="remaining_hours" type="number" class="form-control" id="remainingHours" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="validityPeriod" class="col-md-4 col-lg-3 col-form-label">Validity Period (days)</label>
                                <div class="col-md-8 col-lg-9">
                                    <input name="validity_period" type="number" class="form-control" id="validityPeriod" value="365" required>
                                </div>
                            </div>

                

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Create Package</button>
                            </div>
                        </form><!-- End Package Creation Form -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<script>

    // Initialize Select2 for the patient field
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Select a Patient",
            allowClear: true
        });
    });

    // Function to populate remaining hours based on package selection
    function populateHours() {
        const packageName = document.getElementById("packageName").value;
        const remainingHours = document.getElementById("remainingHours");

        switch (packageName) {
            case "10 hour package":
                remainingHours.value = 10;
                break;
            case "20 hour package":
                remainingHours.value = 20;
                break;
            case "30 hour package":
                remainingHours.value = 30;
                break;
            case "40 hour package":
                remainingHours.value = 40;
                break;
            case "50 hour package":
                remainingHours.value = 50;
                break;
            default:
                remainingHours.value = 0;
                break;
        }
    }

    // Function to fetch the assigned doctor for the selected patient
    function fetchDoctor() {
        const patientId = document.getElementById("patientId").value; // Get selected patient ID
        if (patientId) {
            // Fetch doctor details from the server using the patient ID
            fetch(`/controller/get_doctor.php?patient_id=${patientId}`)
                .then(response => response.json()) // Parse the JSON response
                .then(data => {
                    if (data && data.doctor_name) {
                        // Populate the doctor name and set the hidden doctor ID
                        document.getElementById("doctorName").value = data.doctor_name; // Set doctor name
                        document.getElementById("doctorId").value = data.doctor_id; // Set doctor ID in hidden field
                    } else {
                        // If doctor data is not found, show a default message
                        document.getElementById("doctorName").value = "Doctor not found";
                        document.getElementById("doctorId").value = ""; // Clear doctor ID
                    }
                })
                .catch(error => {
                    console.error("Error fetching doctor details:", error); // Log errors to the console
                    document.getElementById("doctorName").value = "Error fetching doctor"; // Show error message
                    document.getElementById("doctorId").value = ""; // Clear doctor ID
                });
        } else {
            // If no patient is selected, clear the doctor fields
            document.getElementById("doctorName").value = "";
            document.getElementById("doctorId").value = "";
        }
    }

        // Call fetchDoctor when the patient dropdown changes
        document.getElementById("patientId").addEventListener("change", fetchDoctor);

</script>



<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/footer.php';
?>

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/main.js"></script>



</body>
</html>
