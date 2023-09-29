<?php 

session_start();
if (!isset($_SESSION['user'])) {
  header("location:auth-sign-in.php");
}

if (isset($_SESSION['email'])) {
  unset($_SESSION['email']);
}

if (isset($_SESSION['otp'])) {
  unset($_SESSION['otp']);
}

if (isset($_REQUEST['reg'])) {
   $name = $_REQUEST['name'];
   $phone = $_REQUEST['phone'];
   $email = $_REQUEST['email'];
   $npassword = $_REQUEST['password'];
   $cpassword = $_REQUEST['cpassword'];
   $bname = $_REQUEST['bname'];
   $badd = $_REQUEST['badd'];
   $role = $_REQUEST['role'];
   $gst = $_REQUEST['gstno'];
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
            header("location:page-list-users.php");
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
      <title>SHOP | Add Users</title>
      
      <!-- Favicon -->
      <link rel="shortcut icon" href="../assets/images/favicon.ico" />
      <link rel="stylesheet" href="../assets/css/backend-plugin.min.css">
      <link rel="stylesheet" href="../assets/css/backend.css?v=1.0.0">
      <link rel="stylesheet" href="../assets/vendor/@fortawesome/fontawesome-free/css/all.min.css">
      <link rel="stylesheet" href="../assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css">
      <link rel="stylesheet" href="../assets/vendor/remixicon/fonts/remixicon.css">  </head>
  <body class="sidebar-main">
    <!-- Wrapper Start -->
    <div class="wrapper">
      
      <?php include "sidebar.php"; ?>
      
      <div class="content-page">
      <div class="container-fluid">
         <div class="row align-items-center justify-content-center">
               <div class="col-xl-12 col-lg-12">
                  <div class="card">
                     <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                           <h4 class="card-title">Add New User</h4>
                        </div>
                     </div>
                     <div class="card-body">
                        <div class="new-user-info">
                           <form method="POST">
                              <div class="row">
                                 <div class="form-group col-md-6">
                                    <div class="form-group">
                                       <label>User Role:</label>
                                       <select name="role" class="selectpicker form-control" data-style="py-0"  required>
                                          <option value="">Select Role</option>
                                          <option value="Admin">Admin</option>
                                          <option value="Employee">Employee</option>
                                       </select>
                                    </div>
                                 </div>
                                 <div class="form-group col-md-6">
                                    <label for="fname">Name:</label>
                                    <input type="text" class="form-control" id="fname" placeholder="Name" name="name" required>
                                 </div>
                                 <div class="form-group col-md-6">
                                    <label for="mobno">Phone Number:</label>
                                    <input type="text" class="form-control" id="mobno" placeholder="Phone Number" name="phone" required>
                                 </div>
                                 <div class="form-group col-md-6">
                                    <label for="email">Email:</label>
                                    <input type="email" class="form-control" id="email" placeholder="Email" name="email" required>
                                 </div>
                                 <div class="form-group col-md-6">
                                    <label for="pass">Password:</label>
                                    <input type="password" class="form-control" id="pass" placeholder="Password" name="password" required>
                                 </div>
                                 <div class="form-group col-md-6">
                                    <label for="rpass">Confirm Password:</label>
                                    <input type="password" class="form-control" id="rpass" placeholder="Repeat Password" name="cpassword" required>
                                 </div>
                                 <div class="form-group col-md-6">
                                    <label for="cname">Business Name</label>
                                    <input type="text" class="form-control" id="cname" placeholder="Business Name" name="bname" required>
                                 </div>
                                 <div class="form-group col-md-6">
                                    <label for="gstno">GST No(Optional)</label>
                                    <input type="text" class="form-control" id="gstno" placeholder="GST No" name="gstno" >
                                 </div>
                                 <div class="form-group col-md-6">
                                    <label for="add1">Address</label>
                                    <input type="text" class="form-control" id="add1" placeholder="Address" name="badd" required>
                                 </div>
                              </div>
                              <button type="submit" class="btn btn-primary" name="reg">Add New User</button>
                              <a href="page-list-users.php" class="btn btn-secondary">Back</a>
                           </form>
                        </div>
                     </div>
                  </div>
            </div>
         </div>
      </div>
      </div>
    </div>
    <!-- Wrapper End-->
    <footer class="iq-footer">
            <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <ul class="list-inline mb-0">
                                <li class="list-inline-item"><a href="index.php"><h5><b>SHOP</b></h5></a></li>
                            </ul>
                        </div>
                        <div class="col-lg-8 text-right">
                            <ul class="list-inline mb-0">
                                <li class="list-inline-item"><label><h6>Developed By : Shubham Kumar Gupta &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h6></a></label>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
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