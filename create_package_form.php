<?php
// Include the database connection
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';

// Initialize variables to store data for dropdowns
$patients = [];

// Fetch patient details for the dropdown
try {
    $stmt = $conn->prepare("SELECT patient_id, first_name, last_name FROM patient_details");
    $stmt->execute();
    $patients = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching patients: " . $e->getMessage();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patient_id = $_POST['patient_id'] ?? '';
    $doctor_id = $_POST['doctor_id'] ?? '';
    $package_name = $_POST['package_name'] ?? '';
    $package_price = $_POST['package_price'] ?? '';
    $remaining_hours = $_POST['remaining_hours'] ?? '';
    $validity_period = $_POST['validity_period'] ?? '';

    if (empty($patient_id) || empty($doctor_id) || empty($package_name) || empty($package_price) || empty($remaining_hours) || empty($validity_period)) {
        $error_message = "All fields are required.";
    } else {
        // Insert package details into the database
        try {
            $stmt = $conn->prepare("INSERT INTO package_details (patient_id, doctor_id, package_name, package_price, remaining_hours, validity_period) VALUES (:patient_id, :doctor_id, :package_name, :package_price, :remaining_hours, :validity_period)");
            $stmt->bindParam(':patient_id', $patient_id);
            $stmt->bindParam(':doctor_id', $doctor_id);
            $stmt->bindParam(':package_name', $package_name);
            $stmt->bindParam(':package_price', $package_price);
            $stmt->bindParam(':remaining_hours', $remaining_hours);
            $stmt->bindParam(':validity_period', $validity_period);
            $stmt->execute();
            $success_message = "Package created successfully!";
        } catch (PDOException $e) {
            $error_message = "Error creating package: " . $e->getMessage();
        }
    }
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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
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

                        <?php if (isset($error_message)): ?>
                            <div class="alert alert-danger"><?= $error_message ?></div>
                        <?php endif; ?>
                        <?php if (isset($success_message)): ?>
                            <div class="alert alert-success"><?= $success_message ?></div>
                        <?php endif; ?>

                        <!-- Package Creation Form -->
                        <form action="" method="POST">
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
                                <label for="doctorName" class="col-md-4 col-lg-3 col-form-label">Assigned Doctor</label>
                                <div class="col-md-8 col-lg-9">
                                    <input type="text" class="form-control" id="doctorName" name="doctor_name" readonly>
                                    <input type="hidden" id="doctorId" name="doctor_id">
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

        // Call fetchDoctor when the patient dropdown changes
        document.getElementById("patientId").addEventListener("change", fetchDoctor);
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
        const patientId = document.getElementById("patientId").value;
        if (patientId) {
            fetch(`/controller/get_doctor.php?patient_id=${patientId}`)
                .then(response => response.json())
                .then(data => {
                    if (data && data.doctor_name) {
                        document.getElementById("doctorName").value = data.doctor_name;
                        document.getElementById("doctorId").value = data.doctor_id;
                    } else {
                        document.getElementById("doctorName").value = "Doctor not found";
                        document.getElementById("doctorId").value = "";
                    }
                })
                .catch(error => {
                    console.error("Error fetching doctor details:", error);
                    document.getElementById("doctorName").value = "Error fetching doctor";
                    document.getElementById("doctorId").value = "";
                });
        } else {
            document.getElementById("doctorName").value = "";
            document.getElementById("doctorId").value = "";
        }
    }
</script>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/config/footer.php'; ?>

</body>
</html>
