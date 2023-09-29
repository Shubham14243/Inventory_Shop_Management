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

$idget = $_SESSION['viewid'];

if (!isset($_SESSION['viewid'])) {
  header("location:page-list-suppliers.php");
}else {
  $idget = $_SESSION['viewid'];
  include "../connection.php";
  $sql = "SELECT * FROM suppliers WHERE sid = '$idget' ";
  $exe = mysqli_query($conn,$sql);
  $getdata = mysqli_fetch_array($exe);
}

if (isset($_REQUEST['updpr'])) {
   $name = $_REQUEST['name'];
   $cname = $_REQUEST['cname'];
   $email = $_REQUEST['email'];
   $phone = $_REQUEST['phone'];
   $gst = $_REQUEST['gst'];
   $adrs = $_REQUEST['adrs'];

  include "../connection.php";
  $sql = "UPDATE suppliers SET name = '$name',company = '$cname',email = '$email',phone = '$phone',address = '$adrs',gst = '$gst'  WHERE sid = '$idget' ";
  $exe = mysqli_query($conn,$sql);
  if ($exe) {
    mysqli_close($conn);
    header("location:page-list-suppliers.php");
  }else {
    mysqli_close($conn);
    echo '<script>alert("Eror Occured!\nTry Again!");</script>';
  }

}

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>SHOP | Edit Supplier Profile</title>
      
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
            <div class="col-lg-6">
               <div class="card">
                  <div class="card-body p-0">
                     <div class="iq-edit-list usr-edit">
                        <ul class="iq-edit-profile d-flex nav nav-pills">
                           <li class="col-md-12 p-0">
                              <a class="nav-link active" data-toggle="pill" href="#personal-information">
                              Personal Information
                              </a>
                           </li>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-lg-12">
               <div class="iq-edit-list-data">
                  <div class="tab-content">
                     <div class="tab-pane fade active show" id="personal-information" role="tabpanel">
                        <div class="card">
                           <div class="card-header d-flex justify-content-between">
                              <div class="iq-header-title">
                                 <h4 class="card-title">Personal Information</h4>
                              </div>
                           </div>
                           <div class="card-body">
                              <form>
                                 <div class=" row align-items-center">
                                    <div class="form-group col-sm-6">
                                       <label for="name">Name:</label>
                                       <input type="text" class="form-control" id="name" name="name" value="<?php echo $getdata[1]; ?>">
                                    </div>
                                    <div class="form-group col-sm-6">
                                       <label for="cname">Company Name:</label>
                                       <input type="text" class="form-control" id="cname" name="cname" value="<?php echo $getdata[2]; ?>">
                                    </div>
                                    <div class="form-group col-sm-6">
                                       <label for="email">Email:</label>
                                       <input type="email" class="form-control" id="email" name="email" value="<?php echo $getdata[3]; ?>">
                                    </div>
                                    <div class="form-group col-sm-6">
                                       <label for="phone">Phone:</label>
                                       <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo $getdata[4]; ?>">
                                    </div>
                                    <div class="form-group col-sm-6">
                                       <label for="gst">GST NO:</label>
                                       <input type="text" class="form-control" id="gst" name="gst" value="<?php echo $getdata[6]; ?>">
                                    </div>  
                                    <div class="form-group col-sm-6">
                                       <label for="adrs">Address:</label>
                                       <input type="text" class="form-control" id="adrs" name="adrs" value="<?php echo $getdata[5]; ?>">
                                    </div>                               
                                 </div>
                                 <button type="submit" name="updpr" class="btn btn-primary mr-2">Update</button>
                                 <a href="page-list-suppliers.php" class="btn iq-bg-danger">Cancel</a>
                              </form>
                           </div>
                        </div>
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