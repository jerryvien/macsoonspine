<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Register New Patient - NiceAdmin Bootstrap Template</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>

  <?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/config/topbar.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/config/sidebar.php';

  // Fetch doctor details for the dropdown
  $doctors = [];
  try {
      $stmt = $conn->prepare("SELECT doctor_id, first_name, last_name FROM doctor_details");
      $stmt->execute();
      $doctors = $stmt->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
  }
  ?>

  <main id="main" class="main">
    <div class="pagetitle">
      <h1>Register New Patient</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Patients</li>
          <li class="breadcrumb-item active">Register</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">New Patient Registration Form</h5>

              <!-- Registration Form -->
              <form action="controller/register_patient.php" method="POST" onsubmit="return validateForm();">
                <div class="row mb-3">
                  <label for="firstName" class="col-md-4 col-lg-3 col-form-label">First Name</label>
                  <div class="col-md-8 col-lg-9">
                    <input name="first_name" type="text" class="form-control" id="firstName" required>
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="lastName" class="col-md-4 col-lg-3 col-form-label">Last Name</label>
                  <div class="col-md-8 col-lg-9">
                    <input name="last_name" type="text" class="form-control" id="lastName" required>
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="dateOfBirth" class="col-md-4 col-lg-3 col-form-label">Date of Birth</label>
                  <div class="col-md-8 col-lg-9">
                    <input name="date_of_birth" type="date" class="form-control" id="dateOfBirth" required>
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="gender" class="col-md-4 col-lg-3 col-form-label">Gender</label>
                  <div class="col-md-8 col-lg-9">
                    <select name="gender" class="form-control" id="gender" required>
                      <option value="Male">Male</option>
                      <option value="Female">Female</option>
                      <option value="Other">Other</option>
                    </select>
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="phoneNumber" class="col-md-4 col-lg-3 col-form-label">Phone Number</label>
                  <div class="col-md-8 col-lg-9">
                    <input name="phone_number" type="text" class="form-control" id="phoneNumber" required>
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                  <div class="col-md-8 col-lg-9">
                    <input name="email" type="email" class="form-control" id="email">
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="address" class="col-md-4 col-lg-3 col-form-label">Address</label>
                  <div class="col-md-8 col-lg-9">
                    <input name="address" type="text" class="form-control" id="address">
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="emergencyContactName" class="col-md-4 col-lg-3 col-form-label">Emergency Contact Name</label>
                  <div class="col-md-8 col-lg-9">
                    <input name="emergency_contact_name" type="text" class="form-control" id="emergencyContactName">
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="emergencyContactPhone" class="col-md-4 col-lg-3 col-form-label">Emergency Contact Phone</label>
                  <div class="col-md-8 col-lg-9">
                    <input name="emergency_contact_phone" type="text" class="form-control" id="emergencyContactPhone">
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="medicalHistory" class="col-md-4 col-lg-3 col-form-label">Medical History</label>
                  <div class="col-md-8 col-lg-9">
                    <textarea name="medical_history" class="form-control" id="medicalHistory" rows="3"></textarea>
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="allergies" class="col-md-4 col-lg-3 col-form-label">Allergies</label>
                  <div class="col-md-8 col-lg-9">
                    <textarea name="allergies" class="form-control" id="allergies" rows="2"></textarea>
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="doctor" class="col-md-4 col-lg-3 col-form-label">Assigned Doctor</label>
                  <div class="col-md-8 col-lg-9">
                    <select name="doctor_id" class="form-control" id="doctor" required>
                      <option value="">Select a Doctor</option>
                      <?php foreach ($doctors as $doctor) : ?>
                        <option value="<?= $doctor['doctor_id'] ?>">
                          <?= htmlspecialchars($doctor['first_name'] . ' ' . $doctor['last_name']) ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="vipStatus" class="col-md-4 col-lg-3 col-form-label">VIP Status</label>
                  <div class="col-md-8 col-lg-9">
                    <input name="vip_status" type="checkbox" id="vipStatus">
                  </div>
                </div>

                <div class="text-center">
                  <button type="submit" class="btn btn-primary">Register Patient</button>
                </div>
              </form><!-- End Registration Form -->

              <!-- Success Message -->
              <?php
              if (isset($_GET['success']) && $_GET['success'] == 'true') {
                  echo '<div class="alert alert-success mt-3">Patient registered successfully!</div>';
              }
              ?>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main><!-- End #main -->

  <?php include 'config/footer.php'; ?>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>

  <!-- Include the custom JavaScript file for validation -->
  <script src="assets/js/form-validation.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
</body>

</html>
