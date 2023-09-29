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


if (isset($_REQUEST['suppurrep'])) {
    $supid = $_REQUEST['getpsid'];

    $class = "Purchase";
    $dd = date("d-m-Y");
    
    include "../connection.php";
    $ll = "SELECT * FROM purchase WHERE supplier = '$supid' ";
    $lexe = mysqli_query($conn,$ll);
    $cpy = mysqli_query($conn,$ll);
    if (mysqli_num_rows($lexe) == 0) {
        $ll = "SELECT * FROM purchase WHERE supplier = '$supid' LIMIT 0";
        $lexe = mysqli_query($conn,$ll);
        $cpy = mysqli_query($conn,$ll);
    }

}

if (isset($_REQUEST['datepurrep'])) {
    $sdate = $_REQUEST['getpdate'];

    $dd = $sdate;
    
    include "../connection.php";
    $ll = "SELECT * FROM purchase WHERE purdate = '$sdate' ";
    $lexe = mysqli_query($conn,$ll);
    $cpy = mysqli_query($conn,$ll);
    if (mysqli_num_rows($lexe) == 0) {
        $ll = "SELECT * FROM purchase WHERE purdate = '$sdate' LIMIT 0";
        $lexe = mysqli_query($conn,$ll);
        $cpy = mysqli_query($conn,$ll);
    }

}

if (isset($_REQUEST['rdatepurrep'])) {
    $stdate = $_REQUEST['pdatestart'];
    $endate = $_REQUEST['pdateend'];

    $dd = $stdate.' --- '.$endate;
    
    include "../connection.php";
    $ll = "SELECT * FROM purchase WHERE purdate BETWEEN  '$stdate' AND '$endate' ";
    $lexe = mysqli_query($conn,$ll);
    $cpy = mysqli_query($conn,$ll);
    if (mysqli_num_rows($lexe) == 0) {
        $ll = "SELECT * FROM purchase WHERE purdate BETWEEN  '$stdate' AND '$endate' LIMIT 0";
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
      <title>SHOP | Purchase Report</title>
      
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
      var a = window.open('', '', 'height=1000, width=700');
      a.document.write('<html>');
      a.document.write('<body><center><h2><u>Purchase Report Details</u></h2>Date - <?php echo $dd; ?><br><br><table border="1">');
      a.document.write(divContents);
      a.document.write('</table><br>');
      a.document.write(divContents1+' - '+divContents2+'<br>');
      a.document.write(divContents3+' - '+divContents4+'<br>');
      a.document.write(divContents5+' - '+divContents6+'<br>');
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
                            <h4 class="card-title">View Purchase Report</h4>
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
                                    <h4 style="margin-left: 430px;" class="h5 text-black"><b><u>Purchase Report Details</u></b></h4>
                                </div>
                                <table id="print_area" class="text-center w-100" border="2" role="grid" aria-describedby="user-list-page-info">
                                 <thead>
                                    <tr class="ligth">
                                       <th>Purchase ID</th>
                                       <th>Date</th>
                                       <th>Supplier</th>
                                       <th>GST No</th>
                                       <th>Total</th>
                                       <th>Paid</th>
                                       <th>Balance</th>
                                       <th>Purchase Status</th>
                                       <th>Payment Status</th>
                                       <th>Payment mode</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php 
                                    $stotal = $spaid = $sdue = 0;
                                    if (mysqli_num_rows($lexe) > 0) {
                                       while ($listdata = mysqli_fetch_array($lexe)) {
                                          $puts = "SELECT name,address FROM suppliers WHERE sid = '$listdata[3]' ";
                                          $sets = mysqli_query($conn,$puts);
                                          $gets = mysqli_fetch_array($sets);
                                       ?>
                                    <tr>
                                       <td><?php echo $listdata[0]; ?></td>
                                       <td><?php echo $listdata[2]; ?></td>
                                       <td><?php echo $gets[0].' / '.$gets[1]; ?></td>
                                       <td><?php echo $listdata[4]; ?></td>
                                       <td><?php echo $listdata[6]; ?></td>
                                       <td><?php echo $listdata[7]; ?></td>
                                       <td><?php echo $listdata[8]; ?></td>
                                       <td><?php echo $listdata[5]; ?></td>
                                       <td><?php echo $listdata[9]; ?></td>
                                       <td><?php echo $listdata[10]; ?></td>
                                    </tr>
                                    <?php
                                            $stotal = $stotal + floatval($listdata[6]);
                                            $spaid = $spaid + floatval($listdata[7]);
                                            $sdue = $sdue + floatval($listdata[8]);
                                        }
                                    }
                                        ?>
                                 </tbody>
                              </table>
                              <table id="tbl_exporttable_to_xls" style="display:none;" class="text-center w-100" border="2" role="grid" aria-describedby="user-list-page-info">
                                 <thead>
                                    <tr class="ligth">
                                       <th>Purchase ID</th>
                                       <th>Date</th>
                                       <th>Supplier</th>
                                       <th>GST No</th>
                                       <th>Total</th>
                                       <th>Paid</th>
                                       <th>Balance</th>
                                       <th>Purchase Status</th>
                                       <th>Payment Status</th>
                                       <th>Payment mode</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php 
                                    if (mysqli_num_rows($cpy) > 0) {
                                       while ($listdata = mysqli_fetch_array($cpy)) {
                                          $puts = "SELECT name,address FROM suppliers WHERE sid = '$listdata[3]' ";
                                          $sets = mysqli_query($conn,$puts);
                                          $gets = mysqli_fetch_array($sets);
                                       ?>
                                    <tr>
                                       <td><?php echo $listdata[0]; ?></td>
                                       <td><?php echo $listdata[2]; ?></td>
                                       <td><?php echo $gets[0].' / '.$gets[1]; ?></td>
                                       <td><?php echo $listdata[4]; ?></td>
                                       <td><?php echo $listdata[6]; ?></td>
                                       <td><?php echo $listdata[7]; ?></td>
                                       <td><?php echo $listdata[8]; ?></td>
                                       <td><?php echo $listdata[5]; ?></td>
                                       <td><?php echo $listdata[9]; ?></td>
                                       <td><?php echo $listdata[10]; ?></td>
                                    </tr>
                                    <?php
                                        }
                                    }
                                        ?>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                       <td>Total Amount</td>
                                       <td><?php echo '₹ '.number_format((float)$stotal, 2, '.', ''); ?></td>
                                   </tr>
                                    <tr>
                                       <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                       <td>Total Paid</td>
                                       <td><?php echo '₹ '.number_format((float)$spaid, 2, '.', ''); ?></td>
                                   </tr>
                                    <tr>
                                       <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                       <td>Total Due</td>
                                       <td><?php echo '₹ '.number_format((float)$sdue, 2, '.', ''); ?></td>
                                   </tr>
                                 </tbody>
                              </table>
                            </div><hr>
                            <div class="row col-md-12">
                                <div class="col-md-5">
                                </div> 
                                <div class="col-md-4 ">
                                    <br>
                                    <h4 id="dis1" style="position: absolute;right: 15px;" class="h5 text-black">Total Amount</h4>
                                    <br>
                                    <h4 id="dis3" style="position: absolute;right: 15px;" class="h5 text-black">Total Paid</h4>
                                    <br>
                                    <hr>
                                    <h4 id="dis5" style="position: absolute;right: 15px;" class="h5 text-black">Total Due</h4>
                                    <br>
                                </div>
                                <div class="col-md-3">
                                    <br>
                                    <h4 id="dis2" style="position: absolute;left: 15px;" class="h5 text-black"><b><?php echo '₹ '.number_format((float)$stotal, 2, '.', ''); ?></b></h4>
                                    <br>
                                    <h4 id="dis4" style="position: absolute;left: 15px;" class="h5 text-black"><b><?php echo '₹ '.number_format((float)$spaid, 2, '.', ''); ?></b></h4>
                                    <br>                                    
                                    <hr>
                                    <h4 id="dis6" style="position: absolute;left: 15px;" class="h5 text-black"><b><?php echo '₹ '.number_format((float)$sdue, 2, '.', ''); ?></b></h4>
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