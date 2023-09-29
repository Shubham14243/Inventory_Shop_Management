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
  header("location:page-list-products.php");
}else {
  $idget = $_SESSION['viewid'];
  include "../connection.php";
  $sql = "SELECT * FROM products WHERE pid = '$idget' ";
  $exe = mysqli_query($conn,$sql);
  $getdata = mysqli_fetch_array($exe);
}

if (isset($_REQUEST['updpr'])) {
   $category = $_REQUEST['category'];
   $code = $_REQUEST['code'];
   $name = $_REQUEST['name'];
   $brand = $_REQUEST['brand'];
   $cost = $_REQUEST['cost'];
   $mrp = $_REQUEST['mrp'];
   $ret = $_REQUEST['rmrp'];
   $tax = $_REQUEST['tax'];
   $discount = $_REQUEST['discount'];
   $quantity = $_REQUEST['quantity'];

   if ($quantity == "") {
       $quantity = "0";
   }

   $cost = floatval($cost);
   $price = floatval($price);
   $tax = floatval($tax);
   $discount = floatval($discount);

   $profit = $mrp - (($tax*$mrp)/100) - (($discount*$mrp)/100) - $cost;

   include "../connection.php";

   $sql = "UPDATE products SET category = '$category',code = '$code',name = '$name',brand = '$brand',cost = '$cost',price = '$mrp',tax = '$tax',discount = '$discount',profit = '$profit',quantity = '$quantity',retmrp = '$ret' WHERE pid = '$idget' "; 
   $exe = mysqli_query($conn,$sql);
   if ($exe) {
      mysqli_close($conn);
      header("location:page-list-product.php");
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
      <title>SHOP | Edit Product Details</title>
      
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
                              Product  Details
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
                                 <h4 class="card-title">Product  Details</h4>
                              </div>
                           </div>
                           <div class="card-body">
                              <form>
                                 <div class=" row align-items-center">
                                    <div class="form-group col-sm-6">
                                       <label for="category">Category:</label>
                                       <input type="text" class="form-control" id="category" name="category" value="<?php echo $getdata[1]; ?>">
                                    </div>
                                    <div class="form-group col-sm-6">
                                       <label for="code">Code:</label>
                                       <input type="text" class="form-control" id="code" name="code" value="<?php echo $getdata[2]; ?>">
                                    </div>
                                    <div class="form-group col-sm-6">
                                       <label for="name">Name:</label>
                                       <input type="text" class="form-control" id="name" name="name" value="<?php echo $getdata[3]; ?>">
                                    </div>
                                    <div class="form-group col-sm-6">
                                       <label for="brand">Brand:</label>
                                       <input type="text" class="form-control" id="brand" name="brand" value="<?php echo $getdata[4]; ?>">
                                    </div>
                                    <div class="form-group col-sm-6">
                                       <label for="cost">Cost:</label>
                                       <input type="text" class="form-control" id="cost" name="cost" value="<?php echo $getdata[5]; ?>">
                                    </div>
                                    <div class="form-group col-sm-6">
                                       <label for="mrp">Customer MRP:</label>
                                       <input type="text" class="form-control" id="mrp" name="mrp" value="<?php echo $getdata[6]; ?>">
                                    </div>
                                    <div class="form-group col-sm-6">
                                       <label for="mrp">Retailer MRP:</label>
                                       <input type="text" class="form-control" id="mrp" name="rmrp" value="<?php echo $getdata[11]; ?>">
                                    </div>
                                    <div class="form-group col-sm-6">
                                       <label for="tax">Tax( in % ):</label>
                                       <input type="text" class="form-control" id="tax" name="tax" value="<?php echo $getdata[7]; ?>">
                                    </div>  
                                    <div class="form-group col-sm-6">
                                       <label for="discount">Discount( in % ):</label>
                                       <input type="text" class="form-control" id="discount" name="discount" value="<?php echo $getdata[8]; ?>">
                                    </div> 
                                    <div class="form-group col-sm-6">
                                       <label for="quantity">Quantity:</label>
                                       <input type="text" class="form-control" id="quantity" name="quantity" value="<?php echo $getdata[10]; ?>">
                                    </div>                               
                                 </div>
                                 <button type="submit" name="updpr" class="btn btn-primary mr-2">Update</button>
                                 <a href="page-list-product.php" class="btn iq-bg-danger">Cancel</a>
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