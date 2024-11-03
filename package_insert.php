<?php
// Include the database connection
require_once '../config/database.php';

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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect and validate form data
    $patient_id = $_POST['patient_id'] ?? '';
    $doctor_id = $_POST['doctor_id'] ?? '';
    $package_name = $_POST['package_name'] ?? '';
    $package_price = $_POST['package_price'] ?? '';
    $remaining_hours = $_POST['remaining_hours'] ?? '';
    $validity_period = $_POST['validity_period'] ?? '';
    $vip_status = isset($_POST['vip_status']) ? 1 : 0; // Checkbox for VIP status

    // Validate required fields
    if (empty($patient_id) || empty($doctor_id) || empty($package_name) || empty($package_price) || empty($remaining_hours) || empty($validity_period)) {
        $error_message = "Please fill in all required fields.";
    } else {
        // Insert the package details into the database
        try {
            $stmt = $conn->prepare("INSERT INTO package_details (patient_id, doctor_id, package_name, package_price, remaining_hours, validity_period, vip_status) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$patient_id, $doctor_id, $package_name, $package_price, $remaining_hours, $validity_period, $vip_status]);
            $success_message = "Package created successfully!";
        } catch (PDOException $e) {
            $error_message = "Error: " . $e->getMessage();
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
</head>
<body>

<?php
include '../config/topbar.php'; // Include the top bar
include '../config/sidebar.php'; // Include the sidebar
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
                                    <select name="patient_id" class="form-control" id="patientId" required>
                                        <option value="">Select a Patient</option>
                                        <?php foreach ($patients as $patient): ?>
                                            <option value="<?= $patient['patient_id'] ?>"><?= htmlspecialchars($patient['first_name'] . ' ' . $patient['last_name']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="doctorId" class="col-md-4 col-lg-3 col-form-label">Doctor</label>
                                <div class="col-md-8 col-lg-9">
                                    <select name="doctor_id" class="form-control" id="doctorId" required>
                                        <option value="">Select a Doctor</option>
                                        <?php foreach ($doctors as $doctor): ?>
                                            <option value="<?= $doctor['doctor_id'] ?>"><?= htmlspecialchars($doctor['first_name'] . ' ' . $doctor['last_name']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="packageName" class="col-md-4 col-lg-3 col-form-label">Package Name</label>
                                <div class="col-md-8 col-lg-9">
                                    <input name="package_name" type="text" class="form-control" id="packageName" required>
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
                                    <input name="validity_period" type="number" class="form-control" id="validityPeriod" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="vipStatus" class="col-md-4 col-lg-3 col-form-label">VIP Status</label>
                                <div class="col-md-8 col-lg-9">
                                    <input name="vip_status" type="checkbox" id="vipStatus">
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

<?php include '../config/footer.php'; // Include the footer ?>

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/main.js"></script>

</body>
</html>
