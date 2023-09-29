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

if (isset($_SESSION['cart'])) {
  unset($_SESSION['cart']);
}

if (isset($_SESSION['bpdate'])) {
  unset($_SESSION['bpdate']);
}

if (isset($_SESSION['bpsid'])) {
  unset($_SESSION['bpsid']);
}
if (isset($_SESSION['vdate'])) {
  unset($_SESSION['vdate']);
}
if (isset($_SESSION['vid'])) {
  unset($_SESSION['vid']);
}
if (isset($_SESSION['dateup'])) {
  unset($_SESSION['dateup']);
}
if (isset($_SESSION['idup'])) {
  unset($_SESSION['idup']);
}
if (isset($_SESSION['pridup'])) {
  unset($_SESSION['pridup']);
}


include "../connection.php";
$ll = "SELECT * FROM purchase ORDER BY purid DESC";
$lexe = mysqli_query($conn,$ll);
if (mysqli_num_rows($lexe) == 0) {
  $ll = "SELECT * FROM purchase ORDER BY purid DESC LIMIT 0";
  $lexe = mysqli_query($conn,$ll);
}


if (isset($_REQUEST['next'])) {
    $seldate = $_REQUEST['seldate'];
    $selid = $_REQUEST['selid'];

    include "../connection.php";
    $cqry = "SELECT * FROM billpurchase WHERE bpdate = '$seldate' AND bpsid = '$selid' ";
    $cexe = mysqli_query($conn,$cqry);
    if (mysqli_num_rows($cexe) == 0) {
        $cartno = 1;
    }else {
        if (mysqli_num_rows($cexe) > 0) {
            $c=0;
            while ($cno = mysqli_fetch_array($cexe)) {
                if ($cno[11] == 0) {
                    $cartno = intval($cno[1]);
                    $c=1;
                    break;
                }  
            }
            if ($c == 0) {
                $cartno = intval($cno[1]) + 1;
            }
        }
    }
    $_SESSION['cart'] = $cartno;
    $_SESSION['bpdate'] = $seldate;
    $_SESSION['bpsid'] = $selid;
    header("location:page-add-purchase.php");
}


include "../connection.php";
$gg = "SELECT sid,name,address FROM suppliers;";
$ee = mysqli_query($conn,$gg);

if (isset($_REQUEST['getd'])) {
    $vid = $_REQUEST["getpurid"];
    $vdate = $_REQUEST["getpurdate"];
    $vcart = $_REQUEST["getcart"];
    $_SESSION['vdate'] = $vdate;
    $_SESSION['vid'] = $vid;
    $_SESSION['vcart'] = $vcart;
    header("location:page-view-purchase.php");
}

if (isset($_REQUEST['updd'])) {
    $putdate = $_REQUEST['getpurdate'];
    $putid = $_REQUEST['getpurid'];
    $putd = $_REQUEST['getprid'];
    $cartno = $_REQUEST['getcart'];

    $_SESSION['dateup'] = $putdate;
    $_SESSION['idup'] = $putid;
    $_SESSION['pridup'] = $putd;
    $_SESSION['cartno'] = $cartno;
    header("location:page-edit-purchase.php");
}

if (isset($_REQUEST['dele'])) {
    $getprid = $_REQUEST['getprid'];

    include "../connection.php";
    $cmd = "SELECT * FROM purchase WHERE purid = '$getprid' ";
    $exec = mysqli_query($conn,$cmd);
    $prdata = mysqli_fetch_array($exec);

    $cmd1 = "SELECT * FROM billpurchase WHERE cartno = '$prdata[1]' AND bpdate = '$prdata[2]'  AND bpsid = '$prdata[3]' ";
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
            $qty = $qty - $qt;
 
            $cmd3 = "UPDATE products SET quantity = '$qty' WHERE pid = '$pid' ";
            $exec3 = mysqli_query($conn,$cmd3);
            
        }
        $c = 1;
    }
    if ($c == 1) {
        $cmd4 = "DELETE FROM billpurchase WHERE cartno = '$prdata[1]' AND bpdate = '$prdata[2]'  AND bpsid = '$prdata[3]' ";
        $exec4 = mysqli_query($conn,$cmd4);
        if ($exec4) {
            $cmd5 = "DELETE FROM purchase WHERE purid = '$getprid' ";
            $exec5 = mysqli_query($conn,$cmd5);
            if ($exec5) {
                $cmd6 = "DELETE FROM payment WHERE recid = '$getprid' ";
                $exec6 = mysqli_query($conn,$cmd6);
                if ($exec6) {
                    header("location:page-list-purchase.php");
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
      <title>SHOP | Purchase</title>
      
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
      var i = 10; 
      for (var j = 0; j < row.length; j++) {
  
            // Deleting the ith cell of each row.
            row[j].deleteCell(i);
      }
      var divContents = document.getElementById("print_area").innerHTML;
      var a = window.open('', '', 'height=1000, width=700');
      a.document.write('<html>');
      a.document.write('<body><center><h2>Purchase List</h2><br><table border="1"><thead><tr><th>Date</th><th>Purchase<br> ID</th><th>Supplier Info</th><th>GST NO</th><th>Purchase<br> Status</th><th>Total</th><th>Paid</th><th>Balance</th><th>Payment<br> Status</th><th>Payment<br> Mode</th></tr></thead>');
      a.document.write(divContents);
      a.document.write('</table></center></body></html>');
      a.document.close();
      a.print();
      window.location.replace('page-list-purchase.php');
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
                          <h4 class="card-title">Purchase List</h4>
                          <button style="position: absolute;right: 2%;top:3%;" data-toggle="modal" data-target="#adpurmodal" class="btn btn-primary add-list"><i class="las la-plus mr-3"></i>Add Purchase</button>
                       </div>
                    </div>
                    <div class="card-body">
                       <div class="table-responsive">
                            <div class="row justify-content-between">
                
                                <!-- Small modal -->
                         
                                <div class="modal fade bd-example-modal-sm" id="adpurmodal" tabindex="-1" role="dialog"  aria-hidden="true">
                                    <div class="modal-dialog modal-sm">
                                       <div class="modal-content">
                                          <div class="modal-header">
                                             <h5 class="modal-title">Select Supplier</h5>
                                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                             <span aria-hidden="true">&times;</span>
                                             </button>
                                          </div>
                                          <div class="modal-body">
                                             <form method="POST"> 
                                                 <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="bpdate">Date *</label>
                                                            <input type="date" class="form-control" name="seldate" id="bpdate"  required />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="bpsupp">Select Supplier:</label>
                                                              <input class="form-control" list="getsup" name="selid" id="bpsupp" required >
                                                              <datalist id="getsup">Select</option>
                                                                <?php 
                                                                if (mysqli_num_rows($ee) > 0) {
                                                                    while ($getget = mysqli_fetch_array($ee)) {
                                                                ?>
                                                                        <option value="<?php echo $getget[0]; ?>"><?php echo $getget[1]; ?>/<?php echo $getget[2]; ?></option>
                                                                        
                                                                <?php
                                                                    }
                                                                }
                                                                 ?>
                                                              </datalist>
                                                        </div>
                                                    </div>
                                                </div>
                                          </div>
                                          <div class="modal-footer">
                                             <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                             <button type="submit" name="next" class="btn btn-primary">Next</button>
                                          </div>

                                             </form>
                                       </div>
                                    </div>
                                </div>
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
                                            <th>Purchase<br> ID</th>
                                            <th>Supplier Info</th>
                                            <th>GST NO</th>
                                            <th>Purchase<br> Status</th>
                                            <th>Total</th>
                                            <th>Paid</th>
                                            <th>Balance</th>
                                            <th>Payment<br> Status</th>
                                            <th>Payment<br> Mode</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="print_area" class="ligth-body">
                                        <?php 

                                        if(mysqli_num_rows($lexe) > 0){
                                            while ($listdata = mysqli_fetch_array($lexe)) {
                                                $scart = $listdata[1];
                                                $sdate = $listdata[2];
                                                $ssid = $listdata[3];
                                                $prid = $listdata[0];
                                                $sqlsql = "SELECT name,address FROM suppliers WHERE sid = '$ssid' ";
                                                $exexe = mysqli_query($conn,$sqlsql);
                                                $datadata = mysqli_fetch_array($exexe);        
                                        ?>
                                        <tr>
                                            </td>
                                            <td><?php echo $listdata[2]; ?></td>
                                            <td><?php echo $listdata[0]; ?></td>
                                            <td><?php echo $datadata[0].' '.$datadata[1]; ?></td>
                                            <td><?php echo $listdata[4]; ?></td>
                                            <?php if ($listdata[5] == "Received") {
                                                $badge = "success";
                                                }
                                                if ($listdata[5] == "Pending") {
                                                    $badge = "warning";
                                                }
                                             ?>
                                            <td><div class="badge badge-<?php echo $badge; ?>"><?php echo $listdata[5]; ?></div></td>
                                            <td><?php echo $listdata[6]; ?></td>
                                            <td><?php echo $listdata[7]; ?></td>
                                            <td><?php echo $listdata[8]; ?></td>  
                                            <?php if ($listdata[9] == "Paid") {
                                                $badge1 = "success";
                                                }
                                                if ($listdata[9] == "Due") {
                                                    $badge1 = "warning";
                                                }
                                             ?>                          
                                            <td><div class="<?php echo 'badge badge-'.$badge1; ?>"><?php echo $listdata[9]; ?></div></td>
                                            <td><?php echo $listdata[10]; ?></td> 
                                            <td>
                                                <div class="d-flex align-items-center list-action">
                                                    <form method="POST">
                                                        <input type="text" name="getprid" value="<?php echo $prid; ?>" style="display: none;" >
                                                        <input type="text" name="getpurid" value="<?php echo $ssid; ?>" style="display: none;" >
                                                        <input type="text" name="getpurdate" value="<?php echo $sdate; ?>" style="display: none;" >
                                                        <input type="text" name="getcart" value="<?php echo $scart; ?>" style="display: none;" >
                                                        <div class="row">
                                                          <button class="btn btn-sm bg-primary list-inline-item" data-toggle="tooltip" data-placement="top" title="" data-original-title="View" name="getd"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15" height="10"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 3c5.392 0 9.878 3.88 10.819 9-.94 5.12-5.427 9-10.819 9-5.392 0-9.878-3.88-10.819-9C2.121 6.88 6.608 3 12 3zm0 16a9.005 9.005 0 0 0 8.777-7 9.005 9.005 0 0 0-17.554 0A9.005 9.005 0 0 0 12 19zm0-2.5a4.5 4.5 0 1 1 0-9 4.5 4.5 0 0 1 0 9zm0-2a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/></svg></button>
                                                        <button class="btn btn-sm bg-success list-inline-item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" name="updd"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15" height="10"><path fill="none" d="M0 0h24v24H0z"/><path d="M15.728 9.686l-1.414-1.414L5 17.586V19h1.414l9.314-9.314zm1.414-1.414l1.414-1.414-1.414-1.414-1.414 1.414 1.414 1.414zM7.242 21H3v-4.243L16.435 3.322a1 1 0 0 1 1.414 0l2.829 2.829a1 1 0 0 1 0 1.414L7.243 21z"/></svg></button>
                                                        <button class="btn btn-sm bg-warning list-inline-item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" name="dele"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15" height="10"><path fill="none" d="M0 0h24v24H0z"/><path d="M17 6h5v2h-2v13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V8H2V6h5V3a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v3zm1 2H6v12h12V8zm-9 3h2v6H9v-6zm4 0h2v6h-2v-6zM9 4v2h6V4H9z"/></svg></button>  
                                                        </div>
                                                        
                                                    </form>
                                                        
                                                </div>
                                            </td>
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
        </div>
        <!-- Page end  -->
    </div>
    <!-- Modal Edit -->
    <div class="modal fade bd-example-modal-xl" id="edit-note" tabindex="-1" role="dialog" aria-hidden="true">
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