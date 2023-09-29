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

if (isset($_REQUEST['datepayrep'])) {
    $sdate = $_REQUEST['getpaydate'];

    $dd = $sdate;
    
    include "../connection.php";
    $ll = "SELECT * FROM payment WHERE paydate = '$sdate' ";
    $lexe = mysqli_query($conn,$ll);
    $cpy = mysqli_query($conn,$ll);
    if (mysqli_num_rows($lexe) == 0) {
        $ll = "SELECT * FROM payment WHERE paydate = '$sdate' LIMIT 0";
        $lexe = mysqli_query($conn,$ll);
        $cpy = mysqli_query($conn,$ll);
    }

}

if (isset($_REQUEST['rdatepayrep'])) {
    $stdate = $_REQUEST['paydatestart'];
    $endate = $_REQUEST['paydateend'];

    $dd = $stdate.' --- '.$endate;
    
    include "../connection.php";
    $ll = "SELECT * FROM payment WHERE paydate BETWEEN  '$stdate' AND '$endate' ";
    $lexe = mysqli_query($conn,$ll);
    $cpy = mysqli_query($conn,$ll);
    if (mysqli_num_rows($lexe) == 0) {
        $ll = "SELECT * FROM payment WHERE paydate BETWEEN  '$stdate' AND '$endate' LIMIT 0";
        $lexe = mysqli_query($conn,$ll);
        $cpy = mysqli_query($conn,$ll);
    }
}



 ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>SHOP | Payment Report</title>
      
      <!-- Favicon -->
      <link rel="shortcut icon" href="../assets/images/favicon.ico" />
      <link rel="stylesheet" href="../assets/css/backend-plugin.min.css">
      <link rel="stylesheet" href="../assets/css/backend.css?v=1.0.0">
      <link rel="stylesheet" href="../assets/vendor/@fortawesome/fontawesome-free/css/all.min.css">
      <link rel="stylesheet" href="../assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css">
      <link rel="stylesheet" href="../assets/vendor/remixicon/fonts/remixicon.css">  </head>
  <body class="sidebar-main">

    <script type="text/javascript" src="../assets/js/excel.js"></script>

  <script type="text/javascript">

    function print_content(){
      var divContents = document.getElementById("print_area").innerHTML;
      var divContents1 = document.getElementById("dis1").innerHTML;
      var divContents2 = document.getElementById("dis2").innerHTML;
      var divContents3 = document.getElementById("dis3").innerHTML;
      var divContents4 = document.getElementById("dis4").innerHTML;
      var divContents5 = document.getElementById("dis5").innerHTML;
      var divContents6 = document.getElementById("dis6").innerHTML;
      var divContents7 = document.getElementById("dis7").innerHTML;
      var divContents8 = document.getElementById("dis8").innerHTML;
      var divContents9 = document.getElementById("dis9").innerHTML;
      var divContents10 = document.getElementById("dis10").innerHTML;
      var divContents11 = document.getElementById("dis11").innerHTML;
      var divContents12 = document.getElementById("dis12").innerHTML;
      var a = window.open('', '', 'height=1000, width=700');
      a.document.write('<html>');
      a.document.write('<body><center><h2><u>Purchase Report Details</u></h2>Date - <?php echo $dd; ?><br><br><table border="1">');
      a.document.write(divContents);
      a.document.write('</table><br>');
      a.document.write(divContents1+' - '+divContents2+'<br>');
      a.document.write(divContents3+' - '+divContents4+'<br>');
      a.document.write(divContents5+' - '+divContents6+'<br>');
      a.document.write(' <br> '+divContents7+' - '+divContents8+'<br>');
      a.document.write(divContents9+' - '+divContents10+'<br>');
      a.document.write(divContents11+' - '+divContents12+'<br>');
      a.document.write('</center></body></html>');
      a.document.close();
      a.print();
    }

    function ExportToExcel(type, fn, dl) {
       var elt = document.getElementById('tbl_exporttable_to_xls');
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
     <div class="container-fluid add-form-list">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">View Payment Report</h4>
                        </div>
                        <div class="col-sm-3 col-md-3 mb-3">
                            <div class="user-list-files d-flex">
                                <a class="bg-danger" href="#" onclick="print_content()">
                                    PDF/Print
                                </a>
                                <a class="bg-danger" href="#" onclick="ExportToExcel('xlsx')">
                                    Excel
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                            <div class="col-md-12">
                                <div class="row mb-4">
                                    <h4 class="h5 text-black">DATE : <?php echo $dd; ?></h4>
                                    <h4 style="margin-left: 430px;" class="h5 text-black"><b><u>Payment Report Details</u></b></h4>
                                </div>
                                <table id="print_area" class="text-center w-100" border="2" role="grid" aria-describedby="user-list-page-info">
                                 <thead>
                                    <tr class="ligth">
                                       <th>Payment ID</th>
                                       <th>Date</th>
                                       <th>Type</th>
                                       <th>Person</th>
                                       <th>Details</th>
                                       <th>Total</th>
                                       <th>Paid</th>
                                       <th>Balance</th>
                                       <th>Payment Status</th>
                                       <th>Payment mode</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php 
                                    $ctotal = $cpaid = $cdue = 0;
                                    $dtotal = $dpaid = $ddue = 0;
                                    $type = $stst = "";
                                    if (mysqli_num_rows($lexe) > 0) {
                                       while ($listdata = mysqli_fetch_array($lexe)) {
                                          if ($listdata[1] == "Supplier") {
                                              $type = "Debit";
                                              $puts = "SELECT name,address FROM suppliers WHERE sid = '$listdata[2]' ";
                                              $sets = mysqli_query($conn,$puts);
                                              $gets = mysqli_fetch_array($sets);
                                          }
                                          if ($listdata[1] == "Customer") {
                                              $type = "Credit";
                                              $puts = "SELECT name,address FROM customers WHERE cid = '$listdata[2]' ";
                                              $sets = mysqli_query($conn,$puts);
                                              $gets = mysqli_fetch_array($sets);
                                          }
                                          if (floatval($listdata[5]) == 0.00) {
                                              $stst = "Paid";
                                          }
                                          if (floatval($listdata[5]) > 0.00) {
                                              $stst = "Due";
                                          }
                                       ?>
                                    <tr>
                                       <td><?php echo $listdata[0]; ?></td>
                                       <td><?php echo $listdata[6]; ?></td>
                                       <td><?php echo $type; ?></td>
                                       <td><?php echo $listdata[1]; ?></td>
                                       <td><?php echo $gets[0].' / '.$gets[1]; ?></td>
                                       <td><?php echo $listdata[3]; ?></td>
                                       <td><?php echo $listdata[4]; ?></td>
                                       <td><?php echo $listdata[5]; ?></td>
                                       <td><?php echo $stst; ?></td>
                                       <td><?php echo $listdata[7]; ?></td>
                                    </tr>
                                    <?php 
                                        if ($listdata[1] == "Supplier") {
                                            $dtotal = $dtotal + floatval($listdata[3]);
                                            $dpaid = $dpaid + floatval($listdata[4]);
                                            $ddue = $ddue + floatval($listdata[5]);
                                        }
                                        if ($listdata[1] == "Customer") {
                                            $ctotal = $ctotal + floatval($listdata[3]);
                                            $cpaid = $cpaid + floatval($listdata[4]);
                                            $cdue = $cdue + floatval($listdata[5]);
                                        }
                                            
                                        }
                                    }
                                        ?>
                                 </tbody>
                              </table>
                              <table id="tbl_exporttable_to_xls" style="display:none;" class="text-center w-100" border="2" role="grid" aria-describedby="user-list-page-info">
                                 <thead>
                                    <tr class="ligth">
                                       <th>Payment ID</th>
                                       <th>Date</th>
                                       <th>Type</th>
                                       <th>Person</th>
                                       <th>Details</th>
                                       <th>Total</th>
                                       <th>Paid</th>
                                       <th>Balance</th>
                                       <th>Payment Status</th>
                                       <th>Payment mode</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php 
                                    $type = $stst = "";
                                    if (mysqli_num_rows($cpy) > 0) {
                                       while ($listdata = mysqli_fetch_array($cpy)) {
                                          if ($listdata[1] == "Supplier") {
                                              $type = "Debit";
                                              $puts = "SELECT name,address FROM suppliers WHERE sid = '$listdata[2]' ";
                                              $sets = mysqli_query($conn,$puts);
                                              $gets = mysqli_fetch_array($sets);
                                          }
                                          if ($listdata[1] == "Customer") {
                                              $type = "Credit";
                                              $puts = "SELECT name,address FROM customers WHERE cid = '$listdata[2]' ";
                                              $sets = mysqli_query($conn,$puts);
                                              $gets = mysqli_fetch_array($sets);
                                          }
                                          if (floatval($listdata[5]) == 0.00) {
                                              $stst = "Paid";
                                          }
                                          if (floatval($listdata[5]) > 0.00) {
                                              $stst = "Due";
                                          }
                                       ?>
                                    <tr>
                                       <td><?php echo $listdata[0]; ?></td>
                                       <td><?php echo $listdata[6]; ?></td>
                                       <td><?php echo $type; ?></td>
                                       <td><?php echo $listdata[1]; ?></td>
                                       <td><?php echo $gets[0].' / '.$gets[1]; ?></td>
                                       <td><?php echo $listdata[3]; ?></td>
                                       <td><?php echo $listdata[4]; ?></td>
                                       <td><?php echo $listdata[5]; ?></td>
                                       <td><?php echo $stst; ?></td>
                                       <td><?php echo $listdata[7]; ?></td>
                                    </tr>
                                    <?php
                                            
                                        }
                                    }
                                        ?>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                       <td>Net Debit Amount</td>
                                       <td><?php echo '₹ '.number_format((float)$dtotal, 2, '.', ''); ?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                       <td>Net Credit Amount</td>
                                       <td><?php echo '₹ '.number_format((float)$ctotal, 2, '.', ''); ?></td>
                                   </tr>
                                    <tr>
                                       <td></td>
                                        <td></td>
                                        <td></td>
                                       <td>Sent Amount</td>
                                       <td><?php echo '₹ '.number_format((float)$dpaid, 2, '.', ''); ?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                       <td>Received Amount</td>
                                       <td><?php echo '₹ '.number_format((float)$cpaid, 2, '.', ''); ?></td>
                                   </tr>
                                    <tr>
                                       <td></td>
                                        <td></td>
                                        <td></td>
                                       <td>Debit Due</td>
                                       <td><?php echo '₹ '.number_format((float)$ddue, 2, '.', ''); ?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                       <td>Credit Due</td>
                                       <td><?php echo '₹ '.number_format((float)$cdue, 2, '.', ''); ?></td>
                                   </tr>
                                 </tbody>
                              </table>
                            </div><hr>
                            <div class="row col-md-12">
                                <div class="col-md-3 ">
                                    <br>
                                    <h4 id="dis1" style="position: absolute;right: 15px;" class="h5 text-black">Net Credit Amount</h4>
                                    <br>
                                    <h4 id="dis3" style="position: absolute;right: 15px;" class="h5 text-black">Received Amount</h4>
                                    <br>
                                    <hr>
                                    <h4 id="dis5" style="position: absolute;right: 15px;" class="h5 text-black">Credit Due</h4>
                                    <br>
                                </div>
                                <div class="col-md-3">
                                    <br>
                                    <h4 id="dis2" style="position: absolute;left: 15px;" class="h5 text-black"><b><?php echo '₹ '.number_format((float)$ctotal, 2, '.', ''); ?></b></h4>
                                    <br>
                                    <h4 id="dis4" style="position: absolute;left: 15px;" class="h5 text-black"><b><?php echo '₹ '.number_format((float)$cpaid, 2, '.', ''); ?></b></h4>
                                    <br>
                                    <hr>
                                    <h4 id="dis6" style="position: absolute;left: 15px;" class="h5 text-black"><b><?php echo '₹ '.number_format((float)$cdue, 2, '.', ''); ?></b></h4>
                                    <br>
                                </div> 
                                <div class="col-md-3 ">
                                    <br>
                                    <h4 id="dis7" style="position: absolute;right: 15px;" class="h5 text-black">Net Debit Amount</h4>
                                    <br>
                                    <h4 id="dis9" style="position: absolute;right: 15px;" class="h5 text-black">Sent Amount</h4>
                                    <br>
                                    <hr>
                                    <h4 id="dis11" style="position: absolute;right: 15px;" class="h5 text-black">Debit Due</h4>
                                    <br>
                                </div>
                                <div class="col-md-3">
                                    <br>
                                    <h4 id="dis8" style="position: absolute;left: 15px;" class="h5 text-black"><b><?php echo '₹ '.number_format((float)$dtotal, 2, '.', ''); ?></b></h4>
                                    <br>
                                    <h4 id="dis10" style="position: absolute;left: 15px;" class="h5 text-black"><b><?php echo '₹ '.number_format((float)$dpaid, 2, '.', ''); ?></b></h4>
                                    <br>
                                    <hr>
                                    <h4 id="dis12" style="position: absolute;left: 15px;" class="h5 text-black"><b><?php echo '₹ '.number_format((float)$ddue, 2, '.', ''); ?></b></h4>
                                    <br>
                                </div>
                            </div>
                        </div>  
                    </div>
                    <a href="page-report.php" class="btn btn-danger mb-3">Back</a>
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
</html><?php 

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

if (isset($_REQUEST['datepayrep'])) {
    $sdate = $_REQUEST['getpaydate'];

    $dd = $sdate;
    
    include "../connection.php";
    $ll = "SELECT * FROM payment WHERE paydate = '$sdate' ";
    $lexe = mysqli_query($conn,$ll);
    $cpy = mysqli_query($conn,$ll);
    if (mysqli_num_rows($lexe) == 0) {
        $ll = "SELECT * FROM payment WHERE paydate = '$sdate' LIMIT 0";
        $lexe = mysqli_query($conn,$ll);
        $cpy = mysqli_query($conn,$ll);
    }

}

if (isset($_REQUEST['rdatepayrep'])) {
    $stdate = $_REQUEST['paydatestart'];
    $endate = $_REQUEST['paydateend'];

    $dd = $stdate.' --- '.$endate;
    
    include "../connection.php";
    $ll = "SELECT * FROM payment WHERE paydate BETWEEN  '$stdate' AND '$endate' ";
    $lexe = mysqli_query($conn,$ll);
    $cpy = mysqli_query($conn,$ll);
    if (mysqli_num_rows($lexe) == 0) {
        $ll = "SELECT * FROM payment WHERE paydate BETWEEN  '$stdate' AND '$endate' LIMIT 0";
        $lexe = mysqli_query($conn,$ll);
        $cpy = mysqli_query($conn,$ll);
    }
}



 ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>SHOP | Payment Report</title>
      
      <!-- Favicon -->
      <link rel="shortcut icon" href="../assets/images/favicon.ico" />
      <link rel="stylesheet" href="../assets/css/backend-plugin.min.css">
      <link rel="stylesheet" href="../assets/css/backend.css?v=1.0.0">
      <link rel="stylesheet" href="../assets/vendor/@fortawesome/fontawesome-free/css/all.min.css">
      <link rel="stylesheet" href="../assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css">
      <link rel="stylesheet" href="../assets/vendor/remixicon/fonts/remixicon.css">  </head>
  <body class="sidebar-main">

    <script type="text/javascript" src="../assets/js/excel.js"></script>

  <script type="text/javascript">

    function print_content(){
      var divContents = document.getElementById("print_area").innerHTML;
      var divContents1 = document.getElementById("dis1").innerHTML;
      var divContents2 = document.getElementById("dis2").innerHTML;
      var divContents3 = document.getElementById("dis3").innerHTML;
      var divContents4 = document.getElementById("dis4").innerHTML;
      var divContents5 = document.getElementById("dis5").innerHTML;
      var divContents6 = document.getElementById("dis6").innerHTML;
      var divContents7 = document.getElementById("dis7").innerHTML;
      var divContents8 = document.getElementById("dis8").innerHTML;
      var divContents9 = document.getElementById("dis9").innerHTML;
      var divContents10 = document.getElementById("dis10").innerHTML;
      var divContents11 = document.getElementById("dis11").innerHTML;
      var divContents12 = document.getElementById("dis12").innerHTML;
      var a = window.open('', '', 'height=1000, width=700');
      a.document.write('<html>');
      a.document.write('<body><center><h2><u>Purchase Report Details</u></h2>Date - <?php echo $dd; ?><br><br><table border="1">');
      a.document.write(divContents);
      a.document.write('</table><br>');
      a.document.write(divContents1+' - '+divContents2+'<br>');
      a.document.write(divContents3+' - '+divContents4+'<br>');
      a.document.write(divContents5+' - '+divContents6+'<br>');
      a.document.write(' <br> '+divContents7+' - '+divContents8+'<br>');
      a.document.write(divContents9+' - '+divContents10+'<br>');
      a.document.write(divContents11+' - '+divContents12+'<br>');
      a.document.write('</center></body></html>');
      a.document.close();
      a.print();
    }

    function ExportToExcel(type, fn, dl) {
       var elt = document.getElementById('tbl_exporttable_to_xls');
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
     <div class="container-fluid add-form-list">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">View Payment Report</h4>
                        </div>
                        <div class="col-sm-3 col-md-3 mb-3">
                            <div class="user-list-files d-flex">
                                <a class="bg-danger" href="#" onclick="print_content()">
                                    PDF/Print
                                </a>
                                <a class="bg-danger" href="#" onclick="ExportToExcel('xlsx')">
                                    Excel
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                            <div class="col-md-12">
                                <div class="row mb-4">
                                    <h4 class="h5 text-black">DATE : <?php echo $dd; ?></h4>
                                    <h4 style="margin-left: 430px;" class="h5 text-black"><b><u>Payment Report Details</u></b></h4>
                                </div>
                                <table id="print_area" class="text-center w-100" border="2" role="grid" aria-describedby="user-list-page-info">
                                 <thead>
                                    <tr class="ligth">
                                       <th>Payment ID</th>
                                       <th>Date</th>
                                       <th>Type</th>
                                       <th>Person</th>
                                       <th>Details</th>
                                       <th>Total</th>
                                       <th>Paid</th>
                                       <th>Balance</th>
                                       <th>Payment Status</th>
                                       <th>Payment mode</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php 
                                    $ctotal = $cpaid = $cdue = 0;
                                    $dtotal = $dpaid = $ddue = 0;
                                    $type = $stst = "";
                                    if (mysqli_num_rows($lexe) > 0) {
                                       while ($listdata = mysqli_fetch_array($lexe)) {
                                          if ($listdata[1] == "Supplier") {
                                              $type = "Debit";
                                              $puts = "SELECT name,address FROM suppliers WHERE sid = '$listdata[2]' ";
                                              $sets = mysqli_query($conn,$puts);
                                              $gets = mysqli_fetch_array($sets);
                                          }
                                          if ($listdata[1] == "Customer") {
                                              $type = "Credit";
                                              $puts = "SELECT name,address FROM customers WHERE cid = '$listdata[2]' ";
                                              $sets = mysqli_query($conn,$puts);
                                              $gets = mysqli_fetch_array($sets);
                                          }
                                          if (floatval($listdata[5]) == 0.00) {
                                              $stst = "Paid";
                                          }
                                          if (floatval($listdata[5]) > 0.00) {
                                              $stst = "Due";
                                          }
                                       ?>
                                    <tr>
                                       <td><?php echo $listdata[0]; ?></td>
                                       <td><?php echo $listdata[6]; ?></td>
                                       <td><?php echo $type; ?></td>
                                       <td><?php echo $listdata[1]; ?></td>
                                       <td><?php echo $gets[0].' / '.$gets[1]; ?></td>
                                       <td><?php echo $listdata[3]; ?></td>
                                       <td><?php echo $listdata[4]; ?></td>
                                       <td><?php echo $listdata[5]; ?></td>
                                       <td><?php echo $stst; ?></td>
                                       <td><?php echo $listdata[7]; ?></td>
                                    </tr>
                                    <?php 
                                        if ($listdata[1] == "Supplier") {
                                            $dtotal = $dtotal + floatval($listdata[3]);
                                            $dpaid = $dpaid + floatval($listdata[4]);
                                            $ddue = $ddue + floatval($listdata[5]);
                                        }
                                        if ($listdata[1] == "Customer") {
                                            $ctotal = $ctotal + floatval($listdata[3]);
                                            $cpaid = $cpaid + floatval($listdata[4]);
                                            $cdue = $cdue + floatval($listdata[5]);
                                        }
                                            
                                        }
                                    }
                                        ?>
                                 </tbody>
                              </table>
                              <table id="tbl_exporttable_to_xls" style="display:none;" class="text-center w-100" border="2" role="grid" aria-describedby="user-list-page-info">
                                 <thead>
                                    <tr class="ligth">
                                       <th>Payment ID</th>
                                       <th>Date</th>
                                       <th>Type</th>
                                       <th>Person</th>
                                       <th>Details</th>
                                       <th>Total</th>
                                       <th>Paid</th>
                                       <th>Balance</th>
                                       <th>Payment Status</th>
                                       <th>Payment mode</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php 
                                    $type = $stst = "";
                                    if (mysqli_num_rows($cpy) > 0) {
                                       while ($listdata = mysqli_fetch_array($cpy)) {
                                          if ($listdata[1] == "Supplier") {
                                              $type = "Debit";
                                              $puts = "SELECT name,address FROM suppliers WHERE sid = '$listdata[2]' ";
                                              $sets = mysqli_query($conn,$puts);
                                              $gets = mysqli_fetch_array($sets);
                                          }
                                          if ($listdata[1] == "Customer") {
                                              $type = "Credit";
                                              $puts = "SELECT name,address FROM customers WHERE cid = '$listdata[2]' ";
                                              $sets = mysqli_query($conn,$puts);
                                              $gets = mysqli_fetch_array($sets);
                                          }
                                          if (floatval($listdata[5]) == 0.00) {
                                              $stst = "Paid";
                                          }
                                          if (floatval($listdata[5]) > 0.00) {
                                              $stst = "Due";
                                          }
                                       ?>
                                    <tr>
                                       <td><?php echo $listdata[0]; ?></td>
                                       <td><?php echo $listdata[6]; ?></td>
                                       <td><?php echo $type; ?></td>
                                       <td><?php echo $listdata[1]; ?></td>
                                       <td><?php echo $gets[0].' / '.$gets[1]; ?></td>
                                       <td><?php echo $listdata[3]; ?></td>
                                       <td><?php echo $listdata[4]; ?></td>
                                       <td><?php echo $listdata[5]; ?></td>
                                       <td><?php echo $stst; ?></td>
                                       <td><?php echo $listdata[7]; ?></td>
                                    </tr>
                                    <?php
                                            
                                        }
                                    }
                                        ?>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                       <td>Net Debit Amount</td>
                                       <td><?php echo '₹ '.number_format((float)$dtotal, 2, '.', ''); ?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                       <td>Net Credit Amount</td>
                                       <td><?php echo '₹ '.number_format((float)$ctotal, 2, '.', ''); ?></td>
                                   </tr>
                                    <tr>
                                       <td></td>
                                        <td></td>
                                        <td></td>
                                       <td>Sent Amount</td>
                                       <td><?php echo '₹ '.number_format((float)$dpaid, 2, '.', ''); ?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                       <td>Received Amount</td>
                                       <td><?php echo '₹ '.number_format((float)$cpaid, 2, '.', ''); ?></td>
                                   </tr>
                                    <tr>
                                       <td></td>
                                        <td></td>
                                        <td></td>
                                       <td>Debit Due</td>
                                       <td><?php echo '₹ '.number_format((float)$ddue, 2, '.', ''); ?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                       <td>Credit Due</td>
                                       <td><?php echo '₹ '.number_format((float)$cdue, 2, '.', ''); ?></td>
                                   </tr>
                                 </tbody>
                              </table>
                            </div><hr>
                            <div class="row col-md-12">
                                <div class="col-md-3 ">
                                    <br>
                                    <h4 id="dis1" style="position: absolute;right: 15px;" class="h5 text-black">Net Credit Amount</h4>
                                    <br>
                                    <h4 id="dis3" style="position: absolute;right: 15px;" class="h5 text-black">Received Amount</h4>
                                    <br>
                                    <hr>
                                    <h4 id="dis5" style="position: absolute;right: 15px;" class="h5 text-black">Credit Due</h4>
                                    <br>
                                </div>
                                <div class="col-md-3">
                                    <br>
                                    <h4 id="dis2" style="position: absolute;left: 15px;" class="h5 text-black"><b><?php echo '₹ '.number_format((float)$ctotal, 2, '.', ''); ?></b></h4>
                                    <br>
                                    <h4 id="dis4" style="position: absolute;left: 15px;" class="h5 text-black"><b><?php echo '₹ '.number_format((float)$cpaid, 2, '.', ''); ?></b></h4>
                                    <br>
                                    <hr>
                                    <h4 id="dis6" style="position: absolute;left: 15px;" class="h5 text-black"><b><?php echo '₹ '.number_format((float)$cdue, 2, '.', ''); ?></b></h4>
                                    <br>
                                </div> 
                                <div class="col-md-3 ">
                                    <br>
                                    <h4 id="dis7" style="position: absolute;right: 15px;" class="h5 text-black">Net Debit Amount</h4>
                                    <br>
                                    <h4 id="dis9" style="position: absolute;right: 15px;" class="h5 text-black">Sent Amount</h4>
                                    <br>
                                    <hr>
                                    <h4 id="dis11" style="position: absolute;right: 15px;" class="h5 text-black">Debit Due</h4>
                                    <br>
                                </div>
                                <div class="col-md-3">
                                    <br>
                                    <h4 id="dis8" style="position: absolute;left: 15px;" class="h5 text-black"><b><?php echo '₹ '.number_format((float)$dtotal, 2, '.', ''); ?></b></h4>
                                    <br>
                                    <h4 id="dis10" style="position: absolute;left: 15px;" class="h5 text-black"><b><?php echo '₹ '.number_format((float)$dpaid, 2, '.', ''); ?></b></h4>
                                    <br>
                                    <hr>
                                    <h4 id="dis12" style="position: absolute;left: 15px;" class="h5 text-black"><b><?php echo '₹ '.number_format((float)$ddue, 2, '.', ''); ?></b></h4>
                                    <br>
                                </div>
                            </div>
                        </div>  
                    </div>
                    <a href="page-report.php" class="btn btn-danger mb-3">Back</a>
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
</html><?php 

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

if (isset($_REQUEST['datepayrep'])) {
    $sdate = $_REQUEST['getpaydate'];

    $dd = $sdate;
    
    include "../connection.php";
    $ll = "SELECT * FROM payment WHERE paydate = '$sdate' ";
    $lexe = mysqli_query($conn,$ll);
    $cpy = mysqli_query($conn,$ll);
    if (mysqli_num_rows($lexe) == 0) {
        $ll = "SELECT * FROM payment WHERE paydate = '$sdate' LIMIT 0";
        $lexe = mysqli_query($conn,$ll);
        $cpy = mysqli_query($conn,$ll);
    }

}

if (isset($_REQUEST['rdatepayrep'])) {
    $stdate = $_REQUEST['paydatestart'];
    $endate = $_REQUEST['paydateend'];

    $dd = $stdate.' --- '.$endate;
    
    include "../connection.php";
    $ll = "SELECT * FROM payment WHERE paydate BETWEEN  '$stdate' AND '$endate' ";
    $lexe = mysqli_query($conn,$ll);
    $cpy = mysqli_query($conn,$ll);
    if (mysqli_num_rows($lexe) == 0) {
        $ll = "SELECT * FROM payment WHERE paydate BETWEEN  '$stdate' AND '$endate' LIMIT 0";
        $lexe = mysqli_query($conn,$ll);
        $cpy = mysqli_query($conn,$ll);
    }
}



 ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>SHOP | Payment Report</title>
      
      <!-- Favicon -->
      <link rel="shortcut icon" href="../assets/images/favicon.ico" />
      <link rel="stylesheet" href="../assets/css/backend-plugin.min.css">
      <link rel="stylesheet" href="../assets/css/backend.css?v=1.0.0">
      <link rel="stylesheet" href="../assets/vendor/@fortawesome/fontawesome-free/css/all.min.css">
      <link rel="stylesheet" href="../assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css">
      <link rel="stylesheet" href="../assets/vendor/remixicon/fonts/remixicon.css">  </head>
  <body class="sidebar-main">

    <script type="text/javascript" src="../assets/js/excel.js"></script>

  <script type="text/javascript">

    function print_content(){
      var divContents = document.getElementById("print_area").innerHTML;
      var divContents1 = document.getElementById("dis1").innerHTML;
      var divContents2 = document.getElementById("dis2").innerHTML;
      var divContents3 = document.getElementById("dis3").innerHTML;
      var divContents4 = document.getElementById("dis4").innerHTML;
      var divContents5 = document.getElementById("dis5").innerHTML;
      var divContents6 = document.getElementById("dis6").innerHTML;
      var divContents7 = document.getElementById("dis7").innerHTML;
      var divContents8 = document.getElementById("dis8").innerHTML;
      var divContents9 = document.getElementById("dis9").innerHTML;
      var divContents10 = document.getElementById("dis10").innerHTML;
      var divContents11 = document.getElementById("dis11").innerHTML;
      var divContents12 = document.getElementById("dis12").innerHTML;
      var a = window.open('', '', 'height=1000, width=700');
      a.document.write('<html>');
      a.document.write('<body><center><h2><u>Purchase Report Details</u></h2>Date - <?php echo $dd; ?><br><br><table border="1">');
      a.document.write(divContents);
      a.document.write('</table><br>');
      a.document.write(divContents1+' - '+divContents2+'<br>');
      a.document.write(divContents3+' - '+divContents4+'<br>');
      a.document.write(divContents5+' - '+divContents6+'<br>');
      a.document.write(' <br> '+divContents7+' - '+divContents8+'<br>');
      a.document.write(divContents9+' - '+divContents10+'<br>');
      a.document.write(divContents11+' - '+divContents12+'<br>');
      a.document.write('</center></body></html>');
      a.document.close();
      a.print();
    }

    function ExportToExcel(type, fn, dl) {
       var elt = document.getElementById('tbl_exporttable_to_xls');
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
     <div class="container-fluid add-form-list">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">View Payment Report</h4>
                        </div>
                        <div class="col-sm-3 col-md-3 mb-3">
                            <div class="user-list-files d-flex">
                                <a class="bg-danger" href="#" onclick="print_content()">
                                    PDF/Print
                                </a>
                                <a class="bg-danger" href="#" onclick="ExportToExcel('xlsx')">
                                    Excel
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                            <div class="col-md-12">
                                <div class="row mb-4">
                                    <h4 class="h5 text-black">DATE : <?php echo $dd; ?></h4>
                                    <h4 style="margin-left: 430px;" class="h5 text-black"><b><u>Payment Report Details</u></b></h4>
                                </div>
                                <table id="print_area" class="text-center w-100" border="2" role="grid" aria-describedby="user-list-page-info">
                                 <thead>
                                    <tr class="ligth">
                                       <th>Payment ID</th>
                                       <th>Date</th>
                                       <th>Type</th>
                                       <th>Person</th>
                                       <th>Details</th>
                                       <th>Total</th>
                                       <th>Paid</th>
                                       <th>Balance</th>
                                       <th>Payment Status</th>
                                       <th>Payment mode</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php 
                                    $ctotal = $cpaid = $cdue = 0;
                                    $dtotal = $dpaid = $ddue = 0;
                                    $type = $stst = "";
                                    if (mysqli_num_rows($lexe) > 0) {
                                       while ($listdata = mysqli_fetch_array($lexe)) {
                                          if ($listdata[1] == "Supplier") {
                                              $type = "Debit";
                                              $puts = "SELECT name,address FROM suppliers WHERE sid = '$listdata[2]' ";
                                              $sets = mysqli_query($conn,$puts);
                                              $gets = mysqli_fetch_array($sets);
                                          }
                                          if ($listdata[1] == "Customer") {
                                              $type = "Credit";
                                              $puts = "SELECT name,address FROM customers WHERE cid = '$listdata[2]' ";
                                              $sets = mysqli_query($conn,$puts);
                                              $gets = mysqli_fetch_array($sets);
                                          }
                                          if (floatval($listdata[5]) == 0.00) {
                                              $stst = "Paid";
                                          }
                                          if (floatval($listdata[5]) > 0.00) {
                                              $stst = "Due";
                                          }
                                       ?>
                                    <tr>
                                       <td><?php echo $listdata[0]; ?></td>
                                       <td><?php echo $listdata[6]; ?></td>
                                       <td><?php echo $type; ?></td>
                                       <td><?php echo $listdata[1]; ?></td>
                                       <td><?php echo $gets[0].' / '.$gets[1]; ?></td>
                                       <td><?php echo $listdata[3]; ?></td>
                                       <td><?php echo $listdata[4]; ?></td>
                                       <td><?php echo $listdata[5]; ?></td>
                                       <td><?php echo $stst; ?></td>
                                       <td><?php echo $listdata[7]; ?></td>
                                    </tr>
                                    <?php 
                                        if ($listdata[1] == "Supplier") {
                                            $dtotal = $dtotal + floatval($listdata[3]);
                                            $dpaid = $dpaid + floatval($listdata[4]);
                                            $ddue = $ddue + floatval($listdata[5]);
                                        }
                                        if ($listdata[1] == "Customer") {
                                            $ctotal = $ctotal + floatval($listdata[3]);
                                            $cpaid = $cpaid + floatval($listdata[4]);
                                            $cdue = $cdue + floatval($listdata[5]);
                                        }
                                            
                                        }
                                    }
                                        ?>
                                 </tbody>
                              </table>
                              <table id="tbl_exporttable_to_xls" style="display:none;" class="text-center w-100" border="2" role="grid" aria-describedby="user-list-page-info">
                                 <thead>
                                    <tr class="ligth">
                                       <th>Payment ID</th>
                                       <th>Date</th>
                                       <th>Type</th>
                                       <th>Person</th>
                                       <th>Details</th>
                                       <th>Total</th>
                                       <th>Paid</th>
                                       <th>Balance</th>
                                       <th>Payment Status</th>
                                       <th>Payment mode</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php 
                                    $type = $stst = "";
                                    if (mysqli_num_rows($cpy) > 0) {
                                       while ($listdata = mysqli_fetch_array($cpy)) {
                                          if ($listdata[1] == "Supplier") {
                                              $type = "Debit";
                                              $puts = "SELECT name,address FROM suppliers WHERE sid = '$listdata[2]' ";
                                              $sets = mysqli_query($conn,$puts);
                                              $gets = mysqli_fetch_array($sets);
                                          }
                                          if ($listdata[1] == "Customer") {
                                              $type = "Credit";
                                              $puts = "SELECT name,address FROM customers WHERE cid = '$listdata[2]' ";
                                              $sets = mysqli_query($conn,$puts);
                                              $gets = mysqli_fetch_array($sets);
                                          }
                                          if (floatval($listdata[5]) == 0.00) {
                                              $stst = "Paid";
                                          }
                                          if (floatval($listdata[5]) > 0.00) {
                                              $stst = "Due";
                                          }
                                       ?>
                                    <tr>
                                       <td><?php echo $listdata[0]; ?></td>
                                       <td><?php echo $listdata[6]; ?></td>
                                       <td><?php echo $type; ?></td>
                                       <td><?php echo $listdata[1]; ?></td>
                                       <td><?php echo $gets[0].' / '.$gets[1]; ?></td>
                                       <td><?php echo $listdata[3]; ?></td>
                                       <td><?php echo $listdata[4]; ?></td>
                                       <td><?php echo $listdata[5]; ?></td>
                                       <td><?php echo $stst; ?></td>
                                       <td><?php echo $listdata[7]; ?></td>
                                    </tr>
                                    <?php
                                            
                                        }
                                    }
                                        ?>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                       <td>Net Debit Amount</td>
                                       <td><?php echo '₹ '.number_format((float)$dtotal, 2, '.', ''); ?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                       <td>Net Credit Amount</td>
                                       <td><?php echo '₹ '.number_format((float)$ctotal, 2, '.', ''); ?></td>
                                   </tr>
                                    <tr>
                                       <td></td>
                                        <td></td>
                                        <td></td>
                                       <td>Sent Amount</td>
                                       <td><?php echo '₹ '.number_format((float)$dpaid, 2, '.', ''); ?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                       <td>Received Amount</td>
                                       <td><?php echo '₹ '.number_format((float)$cpaid, 2, '.', ''); ?></td>
                                   </tr>
                                    <tr>
                                       <td></td>
                                        <td></td>
                                        <td></td>
                                       <td>Debit Due</td>
                                       <td><?php echo '₹ '.number_format((float)$ddue, 2, '.', ''); ?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                       <td>Credit Due</td>
                                       <td><?php echo '₹ '.number_format((float)$cdue, 2, '.', ''); ?></td>
                                   </tr>
                                 </tbody>
                              </table>
                            </div><hr>
                            <div class="row col-md-12">
                                <div class="col-md-3 ">
                                    <br>
                                    <h4 id="dis1" style="position: absolute;right: 15px;" class="h5 text-black">Net Credit Amount</h4>
                                    <br>
                                    <h4 id="dis3" style="position: absolute;right: 15px;" class="h5 text-black">Received Amount</h4>
                                    <br>
                                    <hr>
                                    <h4 id="dis5" style="position: absolute;right: 15px;" class="h5 text-black">Credit Due</h4>
                                    <br>
                                </div>
                                <div class="col-md-3">
                                    <br>
                                    <h4 id="dis2" style="position: absolute;left: 15px;" class="h5 text-black"><b><?php echo '₹ '.number_format((float)$ctotal, 2, '.', ''); ?></b></h4>
                                    <br>
                                    <h4 id="dis4" style="position: absolute;left: 15px;" class="h5 text-black"><b><?php echo '₹ '.number_format((float)$cpaid, 2, '.', ''); ?></b></h4>
                                    <br>
                                    <hr>
                                    <h4 id="dis6" style="position: absolute;left: 15px;" class="h5 text-black"><b><?php echo '₹ '.number_format((float)$cdue, 2, '.', ''); ?></b></h4>
                                    <br>
                                </div> 
                                <div class="col-md-3 ">
                                    <br>
                                    <h4 id="dis7" style="position: absolute;right: 15px;" class="h5 text-black">Net Debit Amount</h4>
                                    <br>
                                    <h4 id="dis9" style="position: absolute;right: 15px;" class="h5 text-black">Sent Amount</h4>
                                    <br>
                                    <hr>
                                    <h4 id="dis11" style="position: absolute;right: 15px;" class="h5 text-black">Debit Due</h4>
                                    <br>
                                </div>
                                <div class="col-md-3">
                                    <br>
                                    <h4 id="dis8" style="position: absolute;left: 15px;" class="h5 text-black"><b><?php echo '₹ '.number_format((float)$dtotal, 2, '.', ''); ?></b></h4>
                                    <br>
                                    <h4 id="dis10" style="position: absolute;left: 15px;" class="h5 text-black"><b><?php echo '₹ '.number_format((float)$dpaid, 2, '.', ''); ?></b></h4>
                                    <br>
                                    <hr>
                                    <h4 id="dis12" style="position: absolute;left: 15px;" class="h5 text-black"><b><?php echo '₹ '.number_format((float)$ddue, 2, '.', ''); ?></b></h4>
                                    <br>
                                </div>
                            </div>
                        </div>  
                    </div>
                    <a href="page-report.php" class="btn btn-danger mb-3">Back</a>
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