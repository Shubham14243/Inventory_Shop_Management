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

if (isset($_REQUEST['adds'])) {
   $name = $_REQUEST['name'];
   $cname = $_REQUEST['cname'];
   $email = $_REQUEST['email'];
   $phone = $_REQUEST['phone'];
   $gst = $_REQUEST['gst'];
   $adrs = $_REQUEST['adrs'];

   include "../connection.php";

   $chk = "SELECT phone FROM suppliers";
   $cexe = mysqli_query($conn,$chk);
   
   $count = 0;

   if (mysqli_num_rows($cexe) > 0) {
        while ($chkdata = mysqli_fetch_array($cexe)) {
            if ($chkdata[0] == $phone) {
                $count = 1;
            }
        }
        if ($count == 1) {
            echo '<script>alert("Supplier Already Exists!");</script>';
        }
   }
   if (mysqli_num_rows($cexe) == 0 || $count == 0) {
       $sql = "INSERT INTO  suppliers(name,company,email,phone,address,gst) VALUES('$name','$cname','$email','$phone','$adrs','$gst')";
        $exe = mysqli_query($conn,$sql);
        if ($exe) {
        mysqli_close($conn);
        echo '<script>alert("Supplier Added Succesfully!");</script>';
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
      <title>SHOP | Add Supplier</title>
      
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
                            <h4 class="card-title">Add Supplier</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="row"> 
                                <div class="col-md-6">                      
                                    <div class="form-group">
                                        <label>Name *</label>
                                        <input type="text" name="name"  class="form-control" placeholder="Enter Name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">                      
                                    <div class="form-group">
                                        <label>Comapany Name *</label>
                                        <input type="text" name="cname"  class="form-control" placeholder="Enter Company Name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">                      
                                    <div class="form-group">
                                        <label>Email(Optional)</label>
                                        <input type="email" name="email"  class="form-control" placeholder="Enter Email" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Phone Number *</label>
                                        <input type="tel" name="phone" class="form-control" placeholder="Enter Phone Number" required>
                                    </div>
                                </div> 
                                <div class="col-md-6">                      
                                    <div class="form-group">
                                        <label>GST NO *</label>
                                        <input type="text" name="gst" class="form-control" placeholder="Enter GST No" >
                                    </div>
                                </div>
                                <div class="col-md-6">                      
                                    <div class="form-group">
                                        <label>Address *</label>
                                        <input type="text" name="adrs" class="form-control" placeholder="Enter Address" required>
                                    </div>
                                </div>
                            </div>                            
                            <button type="submit" class="btn btn-primary mr-2" name="adds">Add Supplier</button>
                            <a href="page-list-suppliers.php" class="btn btn-secondary">Back</a>
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
                                <li class="list-inline-item"><label><h6>Phone : 7870602660&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h6></a></label>
                                <li class="list-inline-item"><label><h6>Email : guptashubham14243@gmail.com&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h6></a></label>
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