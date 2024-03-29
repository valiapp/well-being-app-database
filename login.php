<?php
session_start();
include 'db_connection.php';

function fetchLoginData($conn, $username, $password, $loginType) {
    $result = null;
    $table = ($loginType === 'customer') ? 'customer' : 'employee';
    
    // Using prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM $table WHERE {$table}_username=? AND password=?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_username = $_POST["username"];
    $customer_password = $_POST["password"];
    $login_type = $_POST["loginType"];

    // Establish database connection using $conn (make sure $conn is defined)

    $login_result = fetchLoginData($conn, $customer_username, $customer_password, $login_type);

    if ($login_result && $login_result->num_rows > 0) {
        // Fetch user data
        $user_data = $login_result->fetch_assoc();
        
        // Set session variables
        $_SESSION['username'] = $user_data[$login_type . '_username'];
        $_SESSION['login_type'] = $login_type;

        // Set login status
        $isLoggedIn = true;

        
        // Redirect to another page
        header("Location: index.php");
        exit();
    } else {
        // Login failed, display an error message
        $error_message = "Invalid credentials. Please check your information and try again.";
    }
}

?>




<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Well-being App | Log in</title>
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
  <style>
    body {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    main {
      flex: 1;
    } 

    /* Adjustments for your footer */
    #footer {
      position: sticky;
    }
    </style>
</head>

<body style="background-color: #1B72BD; min-height: 100vh;">



  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top d-flex align-items-center ">
    <div class="container d-flex align-items-center justify-content-between">

      <h1 class="logo"><a href="index.php">Well-being App</a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href=index.php" class="logo"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto" href="index.php">Home</a></li>
          <li><a class="nav-link scrollto " href="index.php #services">Services</a></li>
          <!-- <li class="dropdown"><a href="#"><span>Plan</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              <li><a href="#">Activity Plan</a></li>
              <li><a href="#">Diet Plan</a></li>
            </ul>
          </li>
          <li><a href="medication.php">Medication</a></li>
          <li><a href="biometrics.php">Biometrics</a></li> -->
          <li><a class="nav-link active" href="login.php">Log In</a></li>
          <li><a href="signup.php">Sign Up</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>






  </header><!-- End Header -->

  
  <!-- <section id="hero" class="d-flex justify-cntent-center align-items-center"> -->
  <main id="main" style="padding-top: 100px; padding-bottom: 20px;"> <!-- Adjust the padding value as needed -->
  <div class="container">
  <div class="container mt-5">
  <div class="row justify-content-center">
    
  <div id="heroCarousel" data-bs-interval="5000" class="container carousel carousel-fade" data-bs-ride="carousel">

      <!-- Slide 1 -->
      <div class="carousel-item active">
        <div class="login-box">
            <form id="loginForm" action="login.php" method="post">
              <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username" required>
              </div>
              <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
              </div>
              <div class="form-group">
                <label for="loginType">Login As:</label>
                <select class="form-control" id="loginType" name="loginType">
                  <option value="customer">Customer</option>
                  <option value="employee">Employee</option>
                </select>
              </div>
              <!-- <button type="submit" class="btn btn-primary">Login</button> -->
              <!-- <center><a class="btn btn-primary" href="#" role="button">Log in</a> </center> -->
              <?php if (isset($error_message)): ?>
                  <div class="alert alert-danger" role="alert">
                      <?php echo $error_message; ?>
                  </div>
              <?php endif; ?>
              <center><button type="submit" class="btn btn-primary">Log in</button></center>
            </form>
            <p class="text-center mt-3 text-muted">Don't have an account? <a href="signup.php">Sign up</a></p>
          </div>
        </div>
      </div>
    </div>
    </main>



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