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

if (isset($_SESSION['custid'])) {
  unset($_SESSION['custid']);
}
if (isset($_SESSION['cartno'])) {
  unset($_SESSION['cartno']);
}
if (isset($_SESSION['cdate'])) {
  unset($_SESSION['cdate']);
}


include "../connection.php";
$ll = "SELECT * FROM sale ORDER BY salid DESC";
$lexe = mysqli_query($conn,$ll);
if (mysqli_num_rows($lexe) == 0) {
    $ll = "SELECT * FROM sale ORDER BY salid DESC LIMIT 0";
    $lexe = mysqli_query($conn,$ll);
}

if (isset($_REQUEST['getd'])) {
    $vid = $_REQUEST["getcustid"];
    $vdate = $_REQUEST["getsaldate"];
    $vcart = $_REQUEST["getcart"];
    $_SESSION['vsdate'] = $vdate;
    $_SESSION['vsid'] = $vid;
    $_SESSION['vscart'] = $vcart;
    header("location:page-view-sale.php");
}

if (isset($_REQUEST['updd'])) {
    $putdate = $_REQUEST['getsaldate'];
    $putid = $_REQUEST['getcustid'];
    $putd = $_REQUEST['getsalid'];
    $cartno = $_REQUEST['getcart'];

    $_SESSION['sdateup'] = $putdate;
    $_SESSION['scidup'] = $putid;
    $_SESSION['sidup'] = $putd;
    $_SESSION['scartno'] = $cartno;
    header("location:page-edit-sale.php");
}

if (isset($_REQUEST['dele'])) {
    $getsalid = $_REQUEST['getsalid'];

    include "../connection.php";
    $cmd = "SELECT * FROM sale WHERE salid = '$getsalid' ";
    $exec = mysqli_query($conn,$cmd);
    $prdata = mysqli_fetch_array($exec);

    $cmd1 = "SELECT * FROM billsale WHERE cartno = '$prdata[1]' AND bsdate = '$prdata[2]'  AND custid = '$prdata[3]' ";
    $exec1 = mysqli_query($conn,$cmd1);
    $c = 0;
    if (mysqli_num_rows($exec1) > 0) {
        while ($bpdata = mysqli_fetch_array($exec1)) {
            $pid = $bpdata[4];
            $qt = intval($bpdata[5]);

            $cmd2 = "SELECT * FROM products WHERE pid = '$pid' ";
            $exec2 = mysqli_query($conn,$cmd2);
            $proddata = mysqli_fetch_array($exec2);

            $qty = intval($proddata[10]);
            $qty = $qty + $qt;
 
            $cmd3 = "UPDATE products SET quantity = '$qty' WHERE pid = '$pid' ";
            $exec3 = mysqli_query($conn,$cmd3);
            
        }
        $c = 1;
    }
    if ($c == 1) {
        $cmd4 = "DELETE FROM billsale WHERE cartno = '$prdata[1]' AND bsdate = '$prdata[2]'  AND custid = '$prdata[3]' ";
        $exec4 = mysqli_query($conn,$cmd4);
        if ($exec4) {
            $cmd5 = "DELETE FROM sale WHERE salid = '$getsalid' ";
            $exec5 = mysqli_query($conn,$cmd5);
            if ($exec5) {
                $cmd6 = "DELETE FROM payment WHERE recid = '$getsalid' ";
                $exec6 = mysqli_query($conn,$cmd6);
                if ($exec6) {
                    header("location:page-list-sale.php");
                }
            }
        }
    }
}

 ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>SHOP | Sale</title>
      
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
      
      // Getting the table
      var tble = document.getElementById('tbl_exporttable_to_xls'); 
  
      // Getting the rows in table.
      var row = tble.rows;  
  
      // Removing the column at index(1).  
      var i = 11; 
      for (var j = 0; j < row.length; j++) {
  
            // Deleting the ith cell of each row.
            row[j].deleteCell(i);
      }
      var divContents = document.getElementById("print_area").innerHTML;
      var a = window.open('', '', 'height=1000, width=700');
      a.document.write('<html>');
      a.document.write('<body><center><h2>Sale List</h2><br><table border="1"><thead><tr><th>Date</th><th>Sale ID</th><th>Customer Info</th><th>Type</th><th>Sale Status</th><th>Total</th><th>Paid</th><th>Balance</th><th>Payment<br> Status</th><th>Payment<br> Mode</th><th>Billed By</th></tr></thead>');
      a.document.write(divContents);
      a.document.write('</table></center></body></html>');
      a.document.close();
      a.print();
      window.location.replace('page-list-sale.php');
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
                          <h4 class="card-title">Sale List</h4>
                          <button style="position: absolute;right: 2%;top:3%;" data-toggle="modal" data-target=".bd-example-modal-sm" class="btn btn-primary add-list"><i class="las la-plus mr-3"></i>Add Sale</button>
                       </div>
                    </div>
                    <div class="card-body">
                       <div class="table-responsive">
                            <div class="row justify-content-between">
                                <div class="col-sm-9 col-md-9 mb-3">
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
                            <div style="height: 500px;overflow-y: scroll;overflow-x: scroll;">
                                <table id="tbl_exporttable_to_xls" class="data-table table mb-0 tbl-server-info">
                                    <thead class="bg-white text-uppercase">
                                        <tr class="ligth ligth-data">
                                            <th>Date</th>
                                            <th>Sale ID</th>
                                            <th>Customer Info</th>
                                            <th>Type</th>
                                            <th>Sale Status</th>
                                            <th>Total</th>
                                            <th>Paid</th>
                                            <th>Balance</th>
                                            <th>Payment<br> Status</th>
                                            <th>Payment<br> Mode</th>
                                            <th>Billed By</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="ligth-body" id="print_area">
                                        <?php $ds = "";
                                        if (mysqli_num_rows($lexe) > 0) {
                                            while ($listdata = mysqli_fetch_array($lexe)) {

                                                $getcust = "SELECT name,phone,retailer FROM customers WHERE cid = '$listdata[3]'";
                                                $getc = mysqli_query($conn,$getcust);
                                                $cdata = mysqli_fetch_array($getc);
                                                if ($cdata[2] == "YES") {
                                                    $ds = "Retailer";
                                                }else {
                                                    $ds = "Customer";
                                                }
                                        ?>
                                                <tr>
                                                    <td><?php echo $listdata[2]; ?></td>
                                                    <td><?php echo $listdata[0]; ?></td>
                                                    <td><?php echo $cdata[0].'('.$cdata[1].')'; ?></td>
                                                    <td><?php echo $ds; ?></td>
                                                    <?php if ($listdata[4] == "Received") {
                                                        $badge = "success";
                                                        }
                                                        if ($listdata[4] == "Pending") {
                                                            $badge = "warning";
                                                        }
                                                     ?>
                                                    <td><div class="badge badge-<?php echo $badge; ?>"><?php echo $listdata[4]; ?></div></td>
                                                    <td><?php echo $listdata[5]; ?></td>
                                                    <td><?php echo $listdata[6]; ?></td>
                                                    <td><?php echo $listdata[7]; ?></td>
                                                    <?php if ($listdata[8] == "Paid") {
                                                        $badge1 = "success";
                                                        }
                                                        if ($listdata[8] == "Due") {
                                                            $badge1 = "warning";
                                                        }
                                                     ?>
                                                    <td><div class="<?php echo 'badge badge-'.$badge1; ?>"><?php echo $listdata[8]; ?></div></td>
                                                    <td><?php echo $listdata[9]; ?></td>
                                                    <td><?php echo $listdata[10]; ?></td>
                                                    <td>
                                                        <div class="d-flex align-items-center list-action">
                                                            <form method="POST">
                                                        <input type="text" name="getsalid" value="<?php echo $listdata[0]; ?>" style="display: none;" >
                                                        <input type="text" name="getcustid" value="<?php echo $listdata[3]; ?>" style="display: none;" >
                                                        <input type="text" name="getsaldate" value="<?php echo $listdata[2]; ?>" style="display: none;" >
                                                        <input type="text" name="getcart" value="<?php echo $listdata[1]; ?>" style="display: none;" >
                                                        <div class="row">
                                                          <button class="btn btn-sm bg-primary list-inline-item" data-toggle="tooltip" data-placement="top" title="" data-original-title="View" name="getd"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15" height="10"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 3c5.392 0 9.878 3.88 10.819 9-.94 5.12-5.427 9-10.819 9-5.392 0-9.878-3.88-10.819-9C2.121 6.88 6.608 3 12 3zm0 16a9.005 9.005 0 0 0 8.777-7 9.005 9.005 0 0 0-17.554 0A9.005 9.005 0 0 0 12 19zm0-2.5a4.5 4.5 0 1 1 0-9 4.5 4.5 0 0 1 0 9zm0-2a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/></svg></button>
                                                        <button class="btn btn-sm bg-success list-inline-item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" name="updd"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15" height="10"><path fill="none" d="M0 0h24v24H0z"/><path d="M15.728 9.686l-1.414-1.414L5 17.586V19h1.414l9.314-9.314zm1.414-1.414l1.414-1.414-1.414-1.414-1.414 1.414 1.414 1.414zM7.242 21H3v-4.243L16.435 3.322a1 1 0 0 1 1.414 0l2.829 2.829a1 1 0 0 1 0 1.414L7.243 21z"/></svg></button>
                                                        <button class="btn btn-sm bg-warning list-inline-item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" name="dele"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15" height="10"><path fill="none" d="M0 0h24v24H0z"/><path d="M17 6h5v2h-2v13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V8H2V6h5V3a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v3zm1 2H6v12h12V8zm-9 3h2v6H9v-6zm4 0h2v6h-2v-6zM9 4v2h6V4H9z"/></svg></button>  
                                                        </div>
                                                        
                                                    </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                        <?php
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