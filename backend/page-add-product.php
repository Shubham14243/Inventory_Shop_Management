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

if (isset($_REQUEST['addp'])) {
   $category = $_REQUEST['category'];
   $code = $_REQUEST['code'];
   $name = $_REQUEST['name'];
   $brand = $_REQUEST['brand'];
   $cost = $_REQUEST['cost'];
   $price = $_REQUEST['cprice'];
   $retmrp = $_REQUEST['rprice'];
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

   $profit = $price - (($tax*$price)/100) - (($discount*$price)/100) - $cost;

   include "../connection.php";

   $chk = "SELECT name FROM products";
   $cexe = mysqli_query($conn,$chk);
   $count = 0;
   if (mysqli_num_rows($cexe) > 0) {

        while ($chkdata = mysqli_fetch_array($cexe)) {
            if ($chkdata[0] == $name) {
                $count = 1;
            }
        }
        if ($count == 1) {
            echo '<script>alert("Product Already Exists!");</script>';
        }

   }
   if (mysqli_num_rows($cexe) == 0 || $count == 0) {
       $sql = "INSERT INTO  products(category,code,name,brand,cost,price,tax,discount,profit,quantity,retmrp) VALUES('$category','$code','$name','$brand','$cost','$price','$tax','$discount','$profit','$quantity','$retmrp')"; 
        $exe = mysqli_query($conn,$sql);
        if ($exe) {
        mysqli_close($conn);
        echo '<script>alert("Product Added Succesfully!");</script>';
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
      <title>SHOP | Add Product</title>
      
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
                            <h4 class="card-title">Add Product</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="row"> 
                                <div class="col-md-6">                      
                                    <div class="form-group">
                                        <label>Category *</label>
                                        <input type="text" name="category"  class="form-control" placeholder="Enter Category" required>
                                    </div>
                                </div>
                                <div class="col-md-6">                      
                                    <div class="form-group">
                                        <label>Code *</label>
                                        <input type="text" name="code"  class="form-control" placeholder="Enter Code" required>
                                    </div>
                                </div>
                                <div class="col-md-6">                      
                                    <div class="form-group">
                                        <label>Name *</label>
                                        <input type="text" name="name"  class="form-control" placeholder="Enter Name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">                      
                                    <div class="form-group">
                                        <label>Brand *</label>
                                        <input type="text" name="brand"  class="form-control" placeholder="Enter Brand" required>
                                    </div>
                                </div>
                                <div class="col-md-6">                      
                                    <div class="form-group">
                                        <label>Cost *</label>
                                        <input type="text" name="cost"  class="form-control" placeholder="Enter Cost" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Customer MRP *</label>
                                        <input type="text" name="cprice" class="form-control" placeholder="Enter Customer MRP" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Retailer MRP *</label>
                                        <input type="text" name="rprice" class="form-control" placeholder="Enter Retailer MRP" required>
                                    </div>
                                </div> 
                                <div class="col-md-6">                      
                                    <div class="form-group">
                                        <label>Tax *</label>
                                        <input type="text" name="tax" class="form-control" placeholder="Enter Tax" required>
                                    </div>
                                </div>
                                <div class="col-md-6">                      
                                    <div class="form-group">
                                        <label>Discount *</label>
                                        <input type="text" name="discount" class="form-control" placeholder="Enter Discount" required>
                                    </div>
                                </div>
                                <div class="col-md-6">                      
                                    <div class="form-group">
                                        <label>Quantity (Optional)</label>
                                        <input type="text" name="quantity"  class="form-control" placeholder="Enter Quantity" >
                                    </div>
                                </div>
                            </div>                            
                            <button type="submit" class="btn btn-primary mr-2" name="addp">Add Product</button>
                            <a href="page-list-product.php" class="btn btn-secondary">Back</a>
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