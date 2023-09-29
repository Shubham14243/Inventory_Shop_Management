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

if (isset($_REQUEST['addc'])) {
   $name = $_REQUEST['cname'];
   $phone = $_REQUEST['cphone'];
   $cemail = $_REQUEST['cemail'];
   $cadd = $_REQUEST['cadd'];
   $ret = $_REQUEST['ret'];
   $visit = "0";

   include "../connection.php";

   $chk = "SELECT name,phone FROM customers";
   $cexe = mysqli_query($conn,$chk);

   $count = 0;

   if (mysqli_num_rows($cexe) > 0) {
        while ($chkdata = mysqli_fetch_array($cexe)) {
            if ($chkdata[0] == $name && $chkdata[1] == $phone) {
                $count = 1;
            }
        }
        if ($count == 1) {
            echo '<script>alert("Customer Already Exists!");</script>';
        }
   }
   if ($count == 0 || mysqli_num_rows($cexe) == 0) {
        $sql = "INSERT INTO  customers(name, phone, email, address, orders, retailer) VALUES('$name', '$phone', '$cemail', '$cadd', '$visit','$ret')";
        $exe = mysqli_query($conn,$sql);
        if ($exe) {
            mysqli_close($conn);
            echo '<script>alert("Customer Added Succesfully!");</script>';
        }else{
            mysqli_close($conn);
            echo '<script>alert("Eror Occured!\nTry Again!");</script>';
        }   
   } 
}

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>SHOP | Add Customer</title>
      
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
     <div class="container-fluid add-form-list">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Add Customer</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="row"> 
                                <div class="col-md-6">                      
                                    <div class="form-group">
                                        <label>Retailer *(Required)</label>
                                        <select class="form-control" name="ret" data-style="py-0" required>
                                            <option value="">SELECT</option>
                                            <option value="YES">YES</option>
                                            <option value="NO">NO</option>
                                        </select>
                                    </div>
                                </div> 
                                <div class="col-md-6">                      
                                    <div class="form-group">
                                        <label>Name *(Required)</label>
                                        <input type="text" class="form-control" name="cname" placeholder="Enter Name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Phone Number</label>
                                        <input type="tel" class="form-control" name="cphone" placeholder="Enter Phone Number" >
                                    </div>
                                </div> 
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" class="form-control" name="cemail" placeholder="Enter Email" >
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <input type="text" class="form-control" name="cadd" placeholder="Enter Address" >
                                    </div>
                                </div>
                            </div>                            
                            <button type="submit" class="btn btn-primary mr-2" name="addc">Add Customer</button>
                            <a href="page-list-customers.php" class="btn btn-secondary">Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page end  -->
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