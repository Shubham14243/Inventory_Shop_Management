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

include "../connection.php";
$ll = "SELECT * FROM payment ORDER BY payid DESC";
$lexe = mysqli_query($conn,$ll);
if (mysqli_num_rows($lexe) == 0) {
    $ll = "SELECT * FROM payment ORDER BY payid DESC LIMIT 0";
    $lexe = mysqli_query($conn,$ll);
}

 ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>SHOP | Payments</title>
      
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
      var a = window.open('', '', 'height=1000, width=700');
      a.document.write('<html>');
      a.document.write('<body><center><h2>Payment List</h2><br><table border="1"><thead><tr><th>Date</th><th>Payment ID</th><th>Type</th><th>Person</th><th>Details</th><th>Total</th><th>Paid</th><th>Balance</th><th>Payment Status</th><th>Payment mode</th></tr></thead>');
      a.document.write(divContents);
      a.document.write('</table></center></body></html>');
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
     <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                       <div class="header-title">
                            <h4 class="card-title">Payments List</h4>
                            <div class="col-sm-3 col-md-3 mb-3" style="position: absolute;right: 2%;top:3%;">
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
                    </div>
                    <div class="card-body">
                       <div class="table-responsive">
                            <div style="height: 550px;overflow-y: scroll;overflow-x: scroll;">
                                <table id="tbl_exporttable_to_xls" class="data-table table mb-0 tbl-server-info">
                                    <thead>
                                    <tr class="ligth">
                                        <th>Date</th>
                                       <th>Payment ID</th>
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
                                 <tbody id="print_area">
                                    <?php 
                                    $ctotal = $cpaid = $cdue = 0;
                                    $dtotal = $dpaid = $ddue = 0;
                                    $type = $stst = "";
                                    if (mysqli_num_rows($lexe) > 0) {
                                       while ($listdata = mysqli_fetch_array($lexe)) {
                                          if ($listdata[1] == "Supplier") {
                                              $type = "Debit";
                                              $badge = "warning";
                                              $puts = "SELECT name,address FROM suppliers WHERE sid = '$listdata[2]' ";
                                              $sets = mysqli_query($conn,$puts);
                                              $gets = mysqli_fetch_array($sets);
                                          }
                                          if ($listdata[1] == "Customer") {
                                              $type = "Credit";
                                              $badge = "success";
                                              $puts = "SELECT name,address FROM customers WHERE cid = '$listdata[2]' ";
                                              $sets = mysqli_query($conn,$puts);
                                              $gets = mysqli_fetch_array($sets);
                                          }
                                          if (floatval($listdata[5]) == 0.00) {
                                              $stst = "Paid";
                                              $badge1 = "success";
                                          }
                                          if (floatval($listdata[5]) > 0.00) {
                                              $stst = "Due";
                                              $badge1 = "warning";
                                          }
                                       ?>
                                    <tr>
                                       <td><?php echo $listdata[6]; ?></td>
                                       <td><?php echo $listdata[0]; ?></td>
                                       <td><div class="badge badge-<?php echo $badge; ?>"><?php echo $type; ?></div></td>
                                       <td><?php echo $listdata[1]; ?></td>
                                       <td><?php echo $gets[0].' / '.$gets[1]; ?></td>
                                       <td><?php echo $listdata[3]; ?></td>
                                       <td><?php echo $listdata[4]; ?></td>
                                       <td><?php echo $listdata[5]; ?></td>
                                       <td><div class="badge badge-<?php echo $badge1; ?>"><?php echo $stst; ?></div></td>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page end  -->
    </div>
    <!-- Modal Edit -->
    <div class="modal fade" id="edit-note" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="popup text-left">
                        <div class="media align-items-top justify-content-between">                            
                            <h3 class="mb-3">Product</h3>
                            <div class="btn-cancel p-0" data-dismiss="modal"><i class="las la-times"></i></div>
                        </div>
                        <div class="content edit-notes">
                            <div class="card card-transparent card-block card-stretch event-note mb-0">
                                <div class="card-body px-0 bukmark">
                                    <div class="d-flex align-items-center justify-content-between pb-2 mb-3 border-bottom">                                                    
                                        <div class="quill-tool">
                                        </div>
                                    </div>
                                    <div id="quill-toolbar1">
                                        <p>Virtual Digital Marketing Course every week on Monday, Wednesday and Saturday.Virtual Digital Marketing Course every week on Monday</p>
                                    </div>
                                </div>
                                <div class="card-footer border-0">
                                    <div class="d-flex flex-wrap align-items-ceter justify-content-end">
                                        <div class="btn btn-primary mr-3" data-dismiss="modal">Cancel</div>
                                        <div class="btn btn-outline-primary" data-dismiss="modal">Save</div>
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