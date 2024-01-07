<?php
session_start();
// Include the database connection file
include 'db_connection.php';

// Function to fetch data from the medication table
function fetchMedicationData($conn) {
    $sql = "SELECT * FROM medication";
    $result = $conn->query($sql);
    return $result;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the form
    $customer_username = $_POST["customer_username"];
    $medication_type = $_POST["medication_type"];
    $medication_dosage = $_POST["medication_dosage"];
    $medication_date_start = $_POST["medication_date_start"];
    $medication_end_date = $_POST["medication_end_date"];

    // Insert data into the medication table
    $insert_sql = "INSERT INTO medication (customer_username, medication_type, medication_dosage, medication_date_start, medication_end_date)
                   VALUES ('$customer_username', '$medication_type', '$medication_dosage', '$medication_date_start', '$medication_end_date')";
    if ($conn->query($insert_sql) === TRUE) {
        // Fetch updated data after insertion
        $result = fetchMedicationData($conn);
    } 
} else {
    // Fetch data initially
    $result = fetchMedicationData($conn);
}

// Check if the user is logged in
$isLoggedIn = false; // Set a default value
if (isset($_SESSION['username'])) {
    $isLoggedIn = true;


}
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <!-- <title>Well-being App</title> -->
    <!-- Check if the user is logged in to set the title -->
    <?php if ($isLoggedIn): ?>
        <title>Welcome, <?php echo $_SESSION['username']; ?> - Well-being App</title>
        <?php else: ?>
            <title>Well-being App</title>
        <?php endif; 
    ?>

    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">

    <!-- =======================================================
    * Template Name: Anyar
    * Updated: Sep 18 2023 with Bootstrap v5.3.2
    * Template URL: https://bootstrapmade.com/anyar-free-multipurpose-one-page-bootstrap-theme/
    * Author: BootstrapMade.com
    * License: https://bootstrapmade.com/license/
    ======================================================== -->
    </head>

    <body style="background-color: #1B72BD; min-height: 100vh;">

        <!-- ======= Header ======= -->
        <header id="header" class="fixed-top d-flex align-items-center">
        <div class="container d-flex align-items-center justify-content-between">

        <h1 class="logo"><a href="index.php">Well-being App</a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href=index.php" class="logo"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

        <nav id="navbar" class="navbar">
            <ul>
            <li><a class="nav-link scrollto" href="index.php">Home</a></li>
            <li><a class="nav-link scrollto " href="index.php #services">Services</a></li>
            <li class="dropdown"><a href="#"><span>Plan</span> <i class="bi bi-chevron-down"></i></a>
                <ul>
                <li><a href="#">Activity Plan</a></li>
                <li><a href="#">Diet Plan</a></li>
                </ul>
            </li>
            <li><a class="nav-link active" href="medication.php">Medication</a></li>
            <li><a href="biometrics.php">Biometrics</a></li>
            <?php if (isset($_SESSION['username'])): ?>
                <li><a href="medication.php?logout=true" class="nav-link">Logout</a></li>
            <?php else: ?>
                <li><a href="login.php" class="nav-link">Login</a></li>
                <li><a href="signup.php" class="nav-link">Signup</a></li>
            <?php endif; ?>
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
            <!-- <li><a href="login.php">Log In</a></li>
            <li><a href="signup.php">Sign Up</a></li> -->
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->

        </div>
        </header><!-- End Header -->




        <main id="main" style="padding-top: 100px; padding-bottom: 20px;"> <!-- Adjust the padding value as needed -->
        <!-- <div style="height: 10000px;"> -->
        <div class="container">
        <div class="container mt-5">
        <div class="row justify-content-center">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Customer Username</th> 
                <th>Medication Type</th>
                <th>Medication Dosage</th>
                <th>Medication Start Date</th>
                <th>Medication End Date</th>
            </tr>
            </thead>
            <tbody>
            <?php
            // Display data in the table
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["customer_username"] . "</td><td>" . $row["medication_type"] . "</td><td>" . $row["medication_dosage"] . "</td><td>" . $row["medication_date_start"] . "</td><td>" . $row["medication_end_date"] . "</td></tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No data found</td></tr>";
            }
            ?>
            </tbody>
        </table>
        </div>
        </div>
        <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="signup-box">

                    <h4 style="color: #007bff;">Add Medication</h4>
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

                    <div class="form-group">
                        <label for="customer_username" style="color: #333;">Customer Username:</label>
                        <input type="text" class="form-control" id="customer_username" name="customer_username" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="medication_type" style="color: #333;">Medication Type:</label>
                        <input type="text" class="form-control" id="medication_type" name="medication_type" required>
                    </div>

                    <div class="form-group">
                        <label for="medication_dosage" style="color: #333;">Medication Dosage:</label>
                        <input type="text" class="form-control" id="medication_dosage" name="medication_dosage" required>
                    </div>

                    <div class="form-group">
                        <label for="medication_date_start" style="color: #333;">Medication Start Date:</label>
                        <input type="date" class="form-control" id="medication_date_start" name="medication_date_start" required>
                    </div>

                    <div class="form-group">
                        <label for="medication_end_date" style="color: #333;">Medication End Date:</label>
                        <input type="date" class="form-control" id="medication_end_date" name="medication_end_date" required>
                    </div>

                    <center>
                        <button type="submit" class="btn btn-primary" style="background-color: #007bff; border-color: #007bff;">Add Medication</button>
                    </center>
                    </form>
                </div>
            </div>
        </div>
        </div>
        </div>

        </main><!-- End #main -->

        <!-- ======= Footer ======= -->
        <footer id="footer">
        <div class="container text-center">
        <div class="copyright">
        &copy; Copyright <strong><span>Well-being App</span></strong>. All Rights Reserved
        </div>
        <div class="contact-info">
            <i class="bi bi-envelope-fill"></i><a href="mailto:info@wellbeing.com">info@wellbeing.com</a>
            <i class="bi bi-phone-fill phone-icon"></i> +1 5589 55488 55
        </div>
        <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/anyar-free-multipurpose-one-page-bootstrap-theme/ -->
        </div>
        </div>
        </footer><!-- End Footer -->


        <div id="preloader"></div>
        <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

        <!-- Vendor JS Files -->
        <script src="assets/vendor/aos/aos.js"></script>
        <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
        <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
        <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
        <script src="assets/vendor/php-email-form/validate.js"></script>

        <!-- Template Main JS File -->
        <script src="assets/js/main.js"></script>

    </body>

    </html>