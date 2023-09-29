
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


if (isset($_SESSION['viewid'])) {
  unset($_SESSION['viewid']);
}

if (isset($_REQUEST['out'])) {
  session_destroy();
  header("location:auth-sign-in.php");
}

include "../connection.php";
$ll = "SELECT category,code,brand,name,quantity,price FROM products ORDER BY category";
$lexe = mysqli_query($conn,$ll);

if (mysqli_num_rows($lexe) == 0) {
  $ll = "SELECT category,code,brand,name,quantity,price FROM products ORDER BY category LIMIT 0";
  $lexe = mysqli_query($conn,$ll);
}


$pay = "SELECT * FROM payment WHERE type = 'Customer' ORDER BY paydate DESC";
$setpay = mysqli_query($conn,$pay);

if (mysqli_num_rows($setpay) == 0) {
  $pay = "SELECT * FROM payment WHERE type = 'Customer' ORDER BY paydate DESC LIMIT 0";
  $setpay = mysqli_query($conn,$pay);
}

$spay = "SELECT * FROM payment WHERE type = 'Supplier' ORDER BY paydate DESC";
$suppay = mysqli_query($conn,$spay);

if (mysqli_num_rows($suppay) == 0) {
  $spay = "SELECT * FROM payment WHERE type = 'Supplier' ORDER BY paydate DESC LIMIT 0";
  $suppay = mysqli_query($conn,$spay);
}


  ?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>SHOP | Home</title>
      
      <!-- Favicon -->
      <link rel="shortcut icon" href="../assets/images/favicon.ico" />
      <link rel="stylesheet" href="../assets/css/backend-plugin.min.css">
      <link rel="stylesheet" href="../assets/css/backend.css?v=1.0.0">
      <link rel="stylesheet" href="../assets/vendor/@fortawesome/fontawesome-free/css/all.min.css">
      <link rel="stylesheet" href="../assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css">
      <link rel="stylesheet" href="../assets/vendor/remixicon/fonts/remixicon.css">  



    </head>
  <body class="sidebar-main">

    <script type="text/javascript" src="../assets/js/excel.js"></script>

  <script type="text/javascript">

    function print_content(el){
      if (el == 'stock') {
        var dis = "Product Stock";
      }
      if (el == 'cust_pay') {
        var dis = "Customer Payment";
      }
      if (el == 'sup_pay') {
        var dis = "Supplier Payment";
      }
      var divContents = document.getElementById(el).innerHTML;
      var a = window.open('', '', 'height=1000, width=700');
      a.document.write('<html>');
      a.document.write('<body><center><h2><b><u>'+dis+'</u></b></h2><br><table border="1">');
      a.document.write(divContents);
      a.document.write('</table></center></body></html>');
      a.document.close();
      a.print();
    }

    function ExportToExcel(el,type, fn, dl) {
       var elt = document.getElementById(el);
       var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
       return dl ?
         XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
         XLSX.writeFile(wb, fn || ('MySheetName.' + (type || 'xlsx')));
    }
  </script>

    <!-- Wrapper Start -->
    <div class="wrapper">
      
      <?php include "sidebar.php"; ?>

      <div class="content-page">
        <div class="container-fluid">
          <div class="row">
              <div class="col-lg-3">
                  <div class="card card-transparent card-block card-stretch card-height border-none">
                      <div class="card-body p-0 mt-lg-2 mt-0">
                          <h1 class="mb-3" style="padding-top:35px;">Your Dashboard!</h1>
                      </div>
                  </div>
              </div>
              <div class="col-lg-9">
                  <div class="row">
                      <div class="col-lg-3 col-md-3">
                          <div class="card card-block">
                              <div class="card-body">
                                  <div class="d-flex align-items-center mb-4 card-total-sale">
                                      <div class="icon iq-icon-box-2 bg-info-light">
                                          <img src="../assets/images/product/1.png" class="img-fluid" alt="image">
                                      </div>
                                      <div>
                                          <p class="mb-2">Total Sales</p>
                                          <?php 

                                          $saleqry = "SELECT SUM(amount) FROM payment WHERE type = 'Customer' ";
                                          $getsaleamt = mysqli_query($conn,$saleqry);
                                          if (mysqli_num_rows($getsaleamt) == 0) {
                                            $$saleqry = "SELECT SUM(amount) FROM payment WHERE type = 'Customer' LIMIT 0";
                                            $getsaleamt = mysqli_query($conn,$saleqry);
                                          }
                                          $saleamt = mysqli_fetch_array($getsaleamt);

                                           ?>
                                          <h4><?php echo '₹ '.$saleamt[0]; ?></h4>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="col-lg-3 col-md-3">
                          <div class="card card-block">
                              <div class="card-body">
                                  <div class="d-flex align-items-center mb-4 card-total-sale">
                                      <div class="icon iq-icon-box-2 bg-info-light">
                                          <img src="../assets/images/product/3.png" class="img-fluid" alt="image">
                                      </div>
                                      <div>
                                          <p class="mb-2">Total Purchase</p>
                                          <?php 

                                          $purqry = "SELECT SUM(amount) FROM payment WHERE type = 'Supplier' ";
                                          $getpuramt = mysqli_query($conn,$purqry);
                                          if (mysqli_num_rows($getpuramt) == 0) {
                                            $purqry = "SELECT SUM(amount) FROM payment WHERE type = 'Supplier' LIMIT 0";
                                            $getpuramt = mysqli_query($conn,$purqry);
                                          }
                                          $puramt = mysqli_fetch_array($getpuramt);

                                           ?>
                                          <h4><?php echo '₹ '.$puramt[0]; ?></h4>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="col-lg-3 col-md-3">
                          <div class="card card-block">
                              <div class="card-body">
                                  <div class="d-flex align-items-center mb-4 card-total-sale">
                                      <div class="icon iq-icon-box-2 bg-danger-light">
                                          <img src="../assets/images/product/2.png" class="img-fluid" alt="image">
                                      </div>
                                      <div>
                                          <p class="mb-2">Product Sold</p>
                                          <?php 

                                          $saleqty = "SELECT SUM(quantity) FROM billsale ";
                                          $getsaleqty = mysqli_query($conn,$saleqty);
                                          if (mysqli_num_rows($getsaleqty) == 0) {
                                            $saleqty = "SELECT SUM(quantity) FROM billsale LIMIT 0";
                                            $getsaleqty = mysqli_query($conn,$saleqty);
                                          }
                                          $saleqty = mysqli_fetch_array($getsaleqty);

                                           ?>
                                          <h4><?php echo $saleqty[0].' Units'; ?></h4>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="col-lg-3 col-md-3">
                          <div class="card card-block">
                              <div class="card-body">
                                  <div class="d-flex align-items-center mb-4 card-total-sale">
                                      <div class="icon iq-icon-box-2 bg-danger-light">
                                          <img src="../assets/images/product/2.png" class="img-fluid" alt="image">
                                      </div>
                                      <div>
                                          <p class="mb-2">Product Stock</p>
                                          <?php 

                                          $purqty = "SELECT SUM(quantity) FROM products ";
                                          $getpurqty = mysqli_query($conn,$purqty);
                                          $purqty = mysqli_fetch_array($getpurqty);
                                          if (mysqli_num_rows($getpurqty) == 0) {
                                            $purqty = "SELECT SUM(quantity) FROM products LIMIT 0";
                                            $getpurqty = mysqli_query($conn,$purqty);
                                          }

                                           ?>
                                          <?php echo '<h4>'.$purqty[0].' Units</h4>'; ?>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="col-lg-12" style="height:500px;">  
                  <div class="card card-block card-stretch card-height">
                      <div class="card-header d-flex justify-content-between">
                          <div class="header-title">
                              <h4 class="card-title">Product Stock</h4>
                          </div>
                        <div class="col-sm-3 col-md-3 mb-3">
                            <div class="user-list-files d-flex">
                                <a class="bg-danger" href="#" onclick="print_content('stock')">
                                    PDF/Print
                                </a>
                                <a class="bg-danger" href="#" onclick="ExportToExcel('stock', 'xlsx')">
                                    Excel
                                </a>
                            </div>
                        </div>
                      </div>
                      <div class="card-body" style="overflow-y: scroll;">
                        <div class="table-responsive rounded mb-3">
                          <table class="data-table table mb-0 tbl-server-info" id="stock">
                              <thead class="bg-white text-uppercase">
                                  <tr class="ligth ligth-data">
                                      <th>Category</th>
                                      <th>Code</th>
                                      <th>Brand</th>
                                      <th>Name</th>
                                      <th>Quantity</th>
                                      <th>MRP</th>
                                  </tr>
                              </thead>
                              <tbody class="ligth-body">
                                  <?php 

                                  if(mysqli_num_rows($lexe) > 0){
                                      while ($listdata = mysqli_fetch_array($lexe)) {     
                                  ?>
                                  <tr>
                                      </td>
                                      <td><?php echo $listdata[0]; ?></td>
                                      <td><?php echo $listdata[1]; ?></td>
                                      <td><?php echo $listdata[2]; ?></td>
                                      <td><?php echo $listdata[3]; ?></td>
                                      <?php if (intval($listdata[4]) > 10) {
                                            $badge = "success";
                                          }
                                          else {
                                            $badge = "warning";
                                          }
                                       ?>
                                      <td><div class="badge badge-<?php echo $badge; ?>"><?php echo $listdata[4]; ?></div></td>
                                      <td><?php echo $listdata[5]; ?></td>
                                  </tr>       
                                  <?php    }
                                  }
                                   ?>
                                  
                              </tbody>
                          </table>
                        </div>
                      </div>
                  </div>
              </div>
              <div class="col-lg-12" style="height:500px;" >  
                  <div class="card card-block card-stretch card-height">
                      <div class="card-header d-flex justify-content-between">
                          <div class="header-title">
                              <h4 class="card-title">Customer Payment</h4>
                          </div>
                        <div class="col-sm-3 col-md-3 mb-3">
                            <div class="user-list-files d-flex">
                                <a class="bg-danger" href="#" onclick="print_content('cust_pay')">
                                    PDF/Print
                                </a>
                                <a class="bg-danger" href="#" onclick="ExportToExcel('cust_pay','xlsx')">
                                    Excel
                                </a>
                            </div>
                        </div>
                      </div>
                      <div class="card-body" style="overflow-y: scroll;">
                        <div class="table-responsive rounded mb-3">
                          <table class="data-table table mb-0 tbl-server-info" id="cust_pay">
                              <thead class="bg-white text-uppercase">
                                  <tr class="ligth ligth-data">
                                      <th>Date</th>
                                      <th>Customer</th>
                                      <th>Amount</th>
                                      <th>Paid</th>
                                      <th>Balance</th>
                                      <th>Status</th>
                                      <th>Mode</th>
                                  </tr>
                              </thead>
                              <tbody class="ligth-body">
                                  <?php 
                                  $dis = "";
                                  if(mysqli_num_rows($setpay) > 0){
                                      while ($getpay = mysqli_fetch_array($setpay)) {  
                                      $putc = "SELECT name,phone,address FROM customers WHERE cid = '$getpay[2]' ";
                                      $setc = mysqli_query($conn,$putc);
                                      $getc = mysqli_fetch_array($setc);    
                                  ?>
                                  <tr>
                                      </td>
                                      <td><?php echo $getpay[6]; ?></td>
                                      <td><?php echo $getc[0].' / '.$getc[1].' / '.$getc[2]; ?></td>
                                      <td><?php echo $getpay[3]; ?></td>
                                      <td><?php echo $getpay[4]; ?></td>
                                      <td><?php echo $getpay[5]; ?></td>
                                      <?php if (floatval($getpay[5]) == 0.00) {
                                            $badge = "success";
                                            $dis = "Paid";
                                          }
                                          else {
                                            $badge = "warning";
                                            $dis = "Due";
                                          }
                                       ?>
                                      <td><div class="badge badge-<?php echo $badge; ?>"><?php echo $dis; ?></div></td>
                                      <td><?php echo $getpay[7]; ?></td>
                                  </tr>       
                                  <?php    }
                                  }
                                   ?>
                                  
                              </tbody>
                          </table>
                        </div>
                      </div>
                  </div>
              </div>
              <div class="col-lg-12" style="height:500px;">  
                  <div class="card card-block card-stretch card-height">
                      <div class="card-header d-flex justify-content-between">
                          <div class="header-title">
                              <h4 class="card-title">Supplier Payment</h4>
                          </div>
                        <div class="col-sm-3 col-md-3 mb-3">
                            <div class="user-list-files d-flex">
                                <a class="bg-danger" href="#" onclick="print_content('sup_pay')">
                                    PDF/Print
                                </a>
                                <a class="bg-danger" href="#" onclick="ExportToExcel('sup_pay','xlsx')">
                                    Excel
                                </a>
                            </div>
                        </div>
                      </div>
                      <div class="card-body" style="overflow-y: scroll;">
                        <div class="table-responsive rounded mb-3">
                          <table class="data-table table mb-0 tbl-server-info" id="sup_pay">
                              <thead class="bg-white text-uppercase">
                                  <tr class="ligth ligth-data">
                                      <th>Date</th>
                                      <th>Supplier</th>
                                      <th>Amount</th>
                                      <th>Paid</th>
                                      <th>Balance</th>
                                      <th>Status</th>
                                      <th>Mode</th>
                                  </tr>
                              </thead>
                              <tbody class="ligth-body">
                                  <?php 
                                  $dis = "";
                                  if(mysqli_num_rows($suppay) > 0){
                                      while ($gotpay = mysqli_fetch_array($suppay)) {   
                                      $puts = "SELECT name,phone,address FROM suppliers WHERE sid = '$gotpay[2]' ";
                                      $sets = mysqli_query($conn,$puts);
                                      $gets = mysqli_fetch_array($sets);  
                                  ?>
                                  <tr>
                                      </td>
                                      <td><?php echo $gotpay[6]; ?></td>
                                      <td><?php echo $gets[0].' / '.$gets[1].' / '.$gets[2]; ?></td>
                                      <td><?php echo $gotpay[3]; ?></td>
                                      <td><?php echo $gotpay[4]; ?></td>
                                      <td><?php echo $gotpay[5]; ?></td>
                                      <?php if (floatval($gotpay[5]) == 0.00) {
                                            $badge = "success";
                                            $dis = "Paid";
                                          }
                                          else {
                                            $badge = "warning";
                                            $dis = "Due";
                                          }
                                       ?>
                                      <td><div class="badge badge-<?php echo $badge; ?>"><?php echo $dis; ?></div></td>
                                      <td><?php echo $gotpay[7]; ?></td>
                                  </tr>       
                                  <?php    }
                                  }
                                   ?>
                                  
                              </tbody>
                          </table>
                        </div>
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