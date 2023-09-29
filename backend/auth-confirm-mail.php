<?php 
session_start();
if (isset($_SESSION['user'])) {
   header("location:index.php");
}

if (!isset($_SESSION['email']) && !isset($_SESSION['otp'])) {
   header("location:auth-recover-pw.php");
}


$email = $_SESSION['email'];

if (isset($_REQUEST['verify'])) {
   $otp = $_REQUEST['otp'];
   if ($otp == $_SESSION['otp']) {
      unset($_SESSION['otp']);
      header("location:auth-new-password.php");
   }else{
      echo '<script>alert("OTP Not Matched!");</script>';
   }
}

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>SHOP | Recover Email Sent!</title>
      
      <!-- Favicon -->
      <link rel="shortcut icon" href="../assets/images/favicon.ico" />
      <link rel="stylesheet" href="../assets/css/backend-plugin.min.css">
      <link rel="stylesheet" href="../assets/css/backend.css?v=1.0.0">
      <link rel="stylesheet" href="../assets/vendor/@fortawesome/fontawesome-free/css/all.min.css">
      <link rel="stylesheet" href="../assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css">
      <link rel="stylesheet" href="../assets/vendor/remixicon/fonts/remixicon.css">  </head>
  <body class=" ">
    
      <div class="wrapper">
      <section class="login-content">
         <div class="container">
            <div class="row align-items-center justify-content-center height-self-center">
               <div class="col-lg-8">
                  <div class="card auth-card">
                     <div class="card-body p-0">
                        <div class="d-flex align-items-center auth-content">
                           <div class="col-lg-7 align-self-center">
                              <div class="p-3">
                                 <img src="../assets/images/login/mail.png" class="img-fluid" width="80" alt="">
                                 <h2 class="mt-3 mb-0">Success !</h2>
                                 <p class="cnf-mail mb-1">A Email has been send to <b><?php echo $email; ?></b>. <br> Please check for an
                                    Email and enter the included One Time Password(OTP) to reset your password.
                                 </p>
                                 <form method="POST">
                                    <div class="row">
                                       <div class="col-lg-12">
                                          <div class="floating-label form-group">
                                             <input class="floating-input form-control" type="text" name="otp" placeholder=" " required>
                                             <label>OTP</label>
                                          </div>
                                       </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary" name="verify">Submit</button>
                                 </form>
                                 <div class="d-inline-block w-100">
                                    <a href="../backend/index.php" class="btn btn-primary mt-3">Back to Home</a>
                                 </div>
                              </div>
                           </div>
                           <div class="col-lg-5 content-right">
                              <img src="../assets/images/login/01.png" class="img-fluid image-right" alt="">
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
      </div>
    
    <!-- Backend Bundle JavaScript -->
    <script src="../assets/js/backend-bundle.min.js"></script>
    
    <!-- Table Treeview JavaScript -->
    <script src="../assets/js/table-treeview.js"></script>
    
    <!-- Chart Custom JavaScript -->
    <script src="../assets/js/customizer.js"></script>
    
    <!-- Chart Custom JavaScript -->
    <script async src="../assets/js/chart-custom.js"></script>
    
    <!-- app JavaScript -->
    <script src="../assets/js/app.js"></script>
  </body>
</html>