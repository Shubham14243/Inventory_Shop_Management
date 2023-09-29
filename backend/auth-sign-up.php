<?php 
session_start();
if (isset($_SESSION['user'])) {
   header("location:index.php");
}

if (isset($_REQUEST['reg'])) {
   $name = $_REQUEST['name'];
   $phone = $_REQUEST['phone'];
   $email = $_REQUEST['email'];
   $npassword = $_REQUEST['npassword'];
   $cpassword = $_REQUEST['cpassword'];
   $bname = $_REQUEST['bname'];
   $badd = $_REQUEST['badd'];
   $gst = $_REQUEST['gst'];
   $role = $_REQUEST['role'];
   $jdate = date("Y-m-d");

   include "../connection.php";

   $chk = "SELECT email FROM users";
   $cexe = mysqli_query($conn,$chk);

   $count = 0;
   if (mysqli_num_rows($cexe) > 0) {
      while ($chkdata = mysqli_fetch_array($cexe)) {
         if ($chkdata[0] != $email) {
            $count = $count + 1;
         }
      }
   } 

   if ($count == mysqli_num_rows($cexe)) {
      if ($npassword == $cpassword) {

         $cpassword = md5($cpassword);

         $sql = "INSERT INTO  users(name, phone, email, password, business, address, gst, role, joindate) VALUES('$name', '$phone', '$email', '$cpassword', '$bname', '$badd', '$gst', '$role', '$jdate')";
         $exe = mysqli_query($conn,$sql);
         if ($exe) {
            mysqli_close($conn);
            $_SESSION['user'] = $email;
            header("location:index.php");
         }else{
            mysqli_close($conn);
            echo '<script>alert("Eror Occured!\nTry Again!");</script>';
         }
      }else{
         mysqli_close($conn);
         echo '<script>alert("Password And Confirm Password Not Matched!");</script>';
      }
   }else{
      mysqli_close($conn);
      echo '<script>alert("User & Email Already Exists!");</script>';
   }
}

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>SHOP | Sign Up</title>
      
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
                                 <h2 class="mb-2">Sign Up</h2>
                                 <p>Create your User Account.</p>
                                 <form method="POST">
                                    <div class="row">
                                       <div class="col-lg-6">
                                          <div class="floating-label form-group">
                                             <select name="role" class="floating-input form-control" required>
                                                <option value="" >Select</option>
                                                <option value="Admin" >Admin</option>
                                                <option value="Employee" >Employee</option>
                                             </select>
                                             <label>Role</label>
                                          </div>
                                       </div>
                                       <div class="col-lg-6">
                                          <div class="floating-label form-group">
                                             <input class="floating-input form-control" type="text" name="name" placeholder=" "required>
                                             <label>Name</label>
                                          </div>
                                       </div>
                                       <div class="col-lg-6">
                                          <div class="floating-label form-group">
                                             <input class="floating-input form-control" type="email" name="email" placeholder=" "required>
                                             <label>Email</label>
                                          </div>
                                       </div>
                                       <div class="col-lg-6">
                                          <div class="floating-label form-group">
                                             <input class="floating-input form-control" type="text" name="phone" placeholder=" "required>
                                             <label>Phone No.</label>
                                          </div>
                                       </div>
                                       <div class="col-lg-6">
                                          <div class="floating-label form-group">
                                             <input class="floating-input form-control" type="password" name="npassword" placeholder=" "required>
                                             <label>Password</label>
                                          </div>
                                       </div>
                                       <div class="col-lg-6">
                                          <div class="floating-label form-group">
                                             <input class="floating-input form-control" type="password" name="cpassword" placeholder=" "required>
                                             <label>Confirm Password</label>
                                          </div>
                                       </div>
                                       <div class="col-lg-6">
                                          <div class="floating-label form-group">
                                             <input class="floating-input form-control" type="text" name="bname" placeholder=" "required>
                                             <label>Business Name</label>
                                          </div>
                                       </div>
                                       <div class="col-lg-6">
                                          <div class="floating-label form-group">
                                             <input class="floating-input form-control" type="text" name="gst" placeholder=" ">
                                             <label>GST No(Optional)</label>
                                          </div>
                                       </div>
                                       <div class="col-lg-12">
                                          <div class="floating-label form-group">
                                             <input class="floating-input form-control" type="text" name="badd" placeholder=" "required>
                                             <label>Business Address</label>
                                          </div>
                                       </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary"name="reg">Sign Up</button>
                                    <p class="mt-3">
                                       Already have an Account <a href="auth-sign-in.php" class="text-primary">Sign In</a>
                                    </p>
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