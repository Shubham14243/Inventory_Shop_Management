<?php 
session_start();
if (isset($_SESSION['user'])) {
   header("location:index.php");
}

if (!isset($_SESSION['email'])) {
   header("location:auth-confirm-mail.php");
}

$email = $_SESSION['email'];

if (isset($_REQUEST['create'])) {
   $password = $_REQUEST['Password'];
   $cpassword = $_REQUEST['cPassword'];
   if ($password == $cpassword) {

      $cpassword = md5($cpassword);
      include "../connection.php";
      $sql = "UPDATE users SET password = '$cpassword' WHERE email = '$email' ";
      $exe = mysqli_query($conn,$sql);
      if ($exe) {
         session_destroy();
         header("location:auth-sign-in.php");
      }else{
         echo '<script>alert("Error Occured! Try Again Later!");</script>';
      }
   }else{
      echo '<script>alert("Password & Confirm Password Not Matched!");</script>';
   }
}

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>SHOP | New Password</title>
      
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
                                 <h2 class="mt-3 mb-0">Create New Password</h2>
                                 <br>
                                 <form method="POST">
                                    <div class="row">
                                       <div class="col-lg-12">
                                          <div class="floating-label form-group">
                                             <input class="floating-input form-control" type="Password" name="Password" placeholder=" " required>
                                             <label>Password</label>
                                          </div>
                                       </div>
                                       <div class="col-lg-12">
                                          <div class="floating-label form-group">
                                             <input class="floating-input form-control" type="Password" name="cPassword" placeholder=" " required>
                                             <label>Confirm Password</label>
                                          </div>
                                       </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary" name="create">Submit</button>
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