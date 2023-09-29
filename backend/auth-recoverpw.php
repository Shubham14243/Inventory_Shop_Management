<?php 
session_start();
if (isset($_SESSION['user'])) {
   header("location:index.php");
}
$dc = $dn = "block";
$connected = @fsockopen("www.workwiththey.com", 80); 
    if ($connected) {
        $dc = "none"; 
        fclose($connected);
    } else {
        $dn = "none";
    }

if (isset($_REQUEST['reset'])) {
   $email = $_REQUEST['email'];

   include "../connection.php";
   $sql = "SELECT email FROM users";
   $exe = mysqli_query($conn,$sql);
   $get = mysqli_fetch_array($exe);
   if ($get[0] == $email) {
      $sql = "SELECT * FROM users WHERE email = '$email'";
      $exe = mysqli_query($conn,$sql);
      if ($exe) {

         $otp = rand(0,99999999);

         $subject = "SHOP | OTP | Reset Password";
         $message = " Your OTP(One Time Password) is\n--[".$otp."]--\n Please Reset Your Password Using this OTP.\nThank You!";

         if (mail($email, $subject, $message)) {
            $_SESSION['email'] = $email;
            $_SESSION['otp'] = $otp;
            header("location:auth-confirm-mail.php");
         }else{
            echo '<script>alert("Email Not Sent! Try Again Later!");</script>';
         }
         
      }

   }else{
      echo '<script>alert("User Not Found!");</script>';
   }
}

?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>SHOP | Recover Password</title>
      
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
               <div class="col-lg-8" id="form" style="display:<?php echo $dn ?>;">
                  <div class="card auth-card">
                     <div class="card-body p-0">
                        <div class="d-flex align-items-center auth-content">
                           <div class="col-lg-7 align-self-center">
                              <div class="p-3">
                                 <h2 class="mb-2">Reset Password</h2>
                                 <p>Enter your Email address and we'll send you an Email with One Time Password(OTP) to Reset your Password.</p>
                                 <form method="POST">
                                    <div class="row">
                                       <div class="col-lg-12">
                                          <div class="floating-label form-group">
                                             <input class="floating-input form-control" type="email" name="email" placeholder=" "required>
                                             <label>Email</label>
                                          </div>
                                       </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary" name="reset">Reset</button>
                                 </form>
                              </div>
                           </div>
                           <div class="col-lg-5 content-right">
                              <img src="../assets/images/login/01.png" class="img-fluid image-right" alt="">
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-8" id="show" style="display:<?php echo $dc ?>;">
                  <div class="card auth-card">
                     <div class="card-body p-0">
                        <div class="d-flex align-items-center auth-content">
                           <div class="col-lg-7 align-self-center">
                              <div class="p-3">
                                 <h2 class="mb-2" style="color:red;">Connect To Internet</h2>
                                 <p>We'll send you an Email with One Time Password(OTP) to Reset your Password.</p>
                                 <form method="POST">
                                    <a href="auth-sign-in.php" class="btn btn-primary">Back</a>
                                 </form>
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