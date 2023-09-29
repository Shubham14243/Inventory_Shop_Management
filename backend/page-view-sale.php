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

if (!isset($_SESSION['vsdate']) || !isset($_SESSION['vsid']) || !isset($_SESSION['vscart'])) {
  header("location:page-list-sale.php");
}

$vdate = $_SESSION['vsdate'];
$vid = $_SESSION['vsid'];
$vcart = $_SESSION['vscart'];

include "../connection.php";
$ll = "SELECT * FROM sale WHERE cartno = '$vcart' AND saldate = '$vdate' AND custid = '$vid' ";
$lexe = mysqli_query($conn,$ll);
$cpy = mysqli_query($conn,$ll);
if (mysqli_num_rows($lexe) == 0) {
    $ll = "SELECT * FROM sale WHERE cartno = '$vcart' AND saldate = '$vdate' AND custid = '$vid' LIMIT 0";
    $lexe = mysqli_query($conn,$ll);
    $cpy = mysqli_query($conn,$ll);
}

 ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>SHOP | View Sale</title>
      
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
      var d1 = document.getElementById("d1").innerHTML;
      var d2 = document.getElementById("d2").innerHTML;
      var d3 = document.getElementById("d3").innerHTML;
      var d4 = document.getElementById("d4").innerHTML;
      var d5 = document.getElementById("d5").innerHTML;
      var a = window.open('', '', 'height=1000, width=700');
      a.document.write('<html>');
      a.document.write('<body>');
      a.document.write('<p style="position:absolute;top:0;left:5;width:30%;">'+d1+'</p>');
      a.document.write('<center>'+d2+'</center>');
      a.document.write('<p style="position:absolute;top:0;right:5;width:30%;">'+d3+'</p>');
      a.document.write('<br><br><center><h3 style=""><b><u>Sale Invoice</u></b></h3><br>');
      a.document.write('<table border="1" style="width:100%;"><thead><tr><th>S.N0.</th><th>Code</th><th>Name</th><th>Quantity</th><th>MRP</th><th>Tax(Included)</th><th>Discount</th><th>Amount</th></tr></thead>');
      a.document.write(divContents);
      a.document.write('</table></center><br><br><p style="position:absolute;left:10;width:50%;">'+d4+'<p style="position:absolute;right:10;width:33%;">'+d5+'</p></p>');
      a.document.write('<br><br><br><br><center><h4><b>---------- Thank You! Visit Again! ----------</b></h4></center></body></html>');
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
                            <h4 class="card-title">View Sale Details</h4>
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
                        <div class="row">
                            <div class="col-md-3">
                                <h4 class="h5 text-black">DATE : <?php echo $vdate; ?></h4>
                                <h4 class="h5 text-black">SALE ID : <?php 
                                $gg = "SELECT * FROM sale WHERE cartno = '$vcart' AND saldate = '$vdate' AND custid = '$vid' ";
                                $ee = mysqli_query($conn,$gg);
                                $pur = mysqli_fetch_array($ee);
                                echo $pur[0];
                                 ?></h4>
                                 <p id="d1" style="display:none;">
                                     DATE : <?php echo $vdate; ?><br>SALE ID :<?php echo $pur[0]; ?>
                                 </p>
                            </div>
                            <div class="col-md-5">
                                <div class="col-md-12">
                                    <?php include "../connection.php";
                                        $em = $_SESSION['user'];
                                        $ss = "SELECT * FROM users WHERE email = '$em' ";
                                        $gss = mysqli_query($conn,$ss);
                                        $urow = mysqli_fetch_array($gss);
                                     ?>
                                    <center>
                                    <h4 class="h5 text-black"><b><?php echo $urow[5]; ?></b></h4>
                                    <h4 class="h5 text-black"><b><?php echo $urow[6]; ?></b></h4>
                                    <h4 class="h5 text-black"><b>Phone : <?php echo $urow[2]; ?> </b></h4>
                                    <h4 class="h5 text-black"><b>GST No : <?php echo $urow[7]; ?> </b></h4>
                                    </center>
                                    <p id="d2" style="display:none;">
                                        <b><?php echo $urow[5]; ?><br><?php echo $urow[6]; ?><br>Phone : <?php echo $urow[2]; ?><br>GST No : <?php echo $urow[7]; ?></b>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-4"><h4 class="h5 text-black">Customer :<br>Details </h4></div>
                                    <?php include "../connection.php";
                                        $gg = "SELECT * FROM customers WHERE cid = '$vid' ";
                                        $ee = mysqli_query($conn,$gg);
                                        $row = mysqli_fetch_array($ee);
                                     ?>
                                    <div class="col-md-8">
                                        <h4 class="h5 text-black">Name : <?php echo $row[1]; ?> </h4>
                                        <h4 class="h5 text-black">Phone : <?php echo $row[2]; ?> </h4>
                                        <h4 class="h5 text-black">Email : <?php echo $row[3]; ?> </h4>
                                        <h4 class="h5 text-black">Address : <?php echo $row[4]; ?> </h4>
                                        <p id="d3" style="display:none;">
                                            Customer Details :<br>Name : <?php echo $row[1]; ?><br>Phone : <?php echo $row[2]; ?><br>Email : <?php echo $row[3]; ?><br>Address : <?php echo $row[4]; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div><hr>
                            <div class="col-md-12">
                                <h4 class="h5 text-black">Products Sold</h4>
                                <table id="user-list-table" class="text-center w-100" border="2" role="grid" aria-describedby="user-list-page-info">
                                 <thead>
                                    <tr class="ligth">
                                       <th>S.N0.</th>
                                       <th>Code</th>
                                       <th>Name</th>
                                       <th>Quantity</th>
                                       <th>MRP</th>
                                       <th>Tax(Included)</th>
                                       <th>Discount</th>
                                       <th>Amount</th>
                                    </tr>
                                 </thead>
                                 <tbody id="print_area">
                                    <?php if (mysqli_num_rows($lexe) > 0) {
                                        $i = 1;
                                       while ($listdata = mysqli_fetch_array($lexe)) {
                                        $getpid = $listdata[3];
                                        $ll1 = "SELECT * FROM billsale WHERE bsdate ='$vdate' AND custid = '$vid' AND cartno = '$vcart' ";
                                        $lexe1 = mysqli_query($conn,$ll1);
                                        if (mysqli_num_rows($lexe1) > 0) {
                                            while ($ddata = mysqli_fetch_array($lexe1)) {
                                                $sq = "SELECT category,code,name,brand FROM products WHERE pid = '$ddata[4]' ";
                                                $xe = mysqli_query($conn,$sq);
                                                if (mysqli_num_rows($xe) > 0) {
                                                    while ($prodata = mysqli_fetch_array($xe)) {    
                                       ?>
                                    <tr>
                                       <td><?php echo $i; ?></td>
                                       <td><?php echo $prodata[1]; ?></td>
                                       <td><?php echo $prodata[2]; ?></td>
                                       <td><?php echo $ddata[5]; ?></td>
                                       <td><?php echo $ddata[7]; ?></td>
                                       <td><?php echo $ddata[8].' %'; ?></td>
                                       <td><?php echo $ddata[9].' %'; ?></td>
                                       <td><?php echo $ddata[10]; ?></td>
                                    </tr>
                                    <?php
                                     }
                                                }
                                                $i = $i + 1;
                                            }
                                        }
                                    }
                                }
                                        ?>
                                 </tbody>
                              </table>
                                <table id="tbl_exporttable_to_xls" style="display:none;" class="text-center w-100" border="2" role="grid" aria-describedby="user-list-page-info">
                                 <thead>
                                    <tr>
                                        <th>Date :</th>
                                        <th><?php echo $vdate; ?></th>
                                        <th><b><?php echo $urow[5]; ?></b></th>
                                        <th></th>
                                        <th></th>
                                        <th>Customer :</th>
                                        <th>Name :</th>
                                        <th><b><?php echo $row[1]; ?></b></th>
                                    </tr>
                                    <tr>
                                        <th>Sale Id :</th>
                                        <th><?php echo $pur[0]; ?></th>
                                        <th><b><?php echo $urow[6]; ?></b></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>Phone :</th>
                                        <th><b><?php echo $row[2]; ?></b></th>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th><b>Phone : <?php echo $urow[2]; ?></b></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>Email :</th>
                                        <th><b><?php echo $row[3]; ?></b></th>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th><b>GST No : <?php echo $urow[7]; ?></b></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>Address :</th>
                                        <th><b><?php echo $row[4]; ?></b></th>
                                    </tr>
                                    <tr>
                                        <th><b>--</b></th>
                                        <th><b>--</b></th>
                                        <th><b>--</b></th>
                                        <th><b>--</b></th>
                                        <th><b>--</b></th>
                                        <th><b>--</b></th>
                                        <th><b>--</b></th>
                                        <th><b>--</b></th>
                                    </tr>
                                    <tr class="ligth">
                                       <th>S.N0.</th>
                                       <th>Code</th>
                                       <th>Name</th>
                                       <th>Quantity</th>
                                       <th>MRP</th>
                                       <th>Tax(Included)</th>
                                       <th>Discount</th>
                                       <th>Amount</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php if (mysqli_num_rows($cpy) > 0) {
                                        $i = 1;
                                       while ($listdata = mysqli_fetch_array($cpy)) {
                                        $getpid = $listdata[3];
                                        $ll1 = "SELECT * FROM billsale WHERE bsdate ='$vdate' AND custid = '$vid' AND cartno = '$vcart' ";
                                        $lexe1 = mysqli_query($conn,$ll1);
                                        if (mysqli_num_rows($lexe1) > 0) {
                                            while ($ddata = mysqli_fetch_array($lexe1)) {
                                                $sq = "SELECT category,code,name,brand FROM products WHERE pid = '$ddata[4]' ";
                                                $xe = mysqli_query($conn,$sq);
                                                if (mysqli_num_rows($xe) > 0) {
                                                    while ($prodata = mysqli_fetch_array($xe)) {    
                                       ?>
                                    <tr>
                                       <td><?php echo $i; ?></td>
                                       <td><?php echo $prodata[1]; ?></td>
                                       <td><?php echo $prodata[2]; ?></td>
                                       <td><?php echo $ddata[5]; ?></td>
                                       <td><?php echo $ddata[7]; ?></td>
                                       <td><?php echo $ddata[8].' %'; ?></td>
                                       <td><?php echo $ddata[9].' %'; ?></td>
                                       <td><?php echo $ddata[10]; ?></td>
                                    </tr>
                                    <?php
                                     }
                                                }
                                                $i = $i + 1;
                                            }
                                        }
                                        ?>
                                        <tr>
                                            <td><b>--</b></td>
                                            <td><b>--</b></td>
                                            <td><b>--</b></td>
                                            <td><b>--</b></td>
                                            <td><b>--</b></td>
                                            <td><b>--</b></td>
                                            <td><b>--</b></td>
                                            <td><b>--</b></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td><b>Purchase Products Status :</b></td>
                                            <td><b><?php echo $listdata[4]; ?></b></td>
                                            <td></td>
                                            <td></td>
                                            <td><b>Total Amount :</b></td>
                                            <td><b><?php echo '₹ '.$listdata[5]; ?></b></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td><b>Payment Status :</b></td>
                                            <td><b><?php echo $listdata[8]; ?></b></td>
                                            <td></td>
                                            <td></td>
                                            <td><b>Paid :</b></td>
                                            <td><b><?php echo '₹ '.$listdata[6]; ?></b></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td><b>Mode Of Payment :</b></td>
                                            <td><b><?php echo $listdata[9]; ?></b></td>
                                            <td></td>
                                            <td></td>
                                            <td><b>Due Balance :</b></td>
                                            <td><b><?php echo '₹ '.$listdata[7]; ?></b></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td><b>Billed By :</b></td>
                                            <td><b><?php echo $listdata[10]; ?></b></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                 </tbody>
                              </table>
                            </div><hr>
                            <div class="row col-md-12">
                                <div class="col-md-5">
                                    <br>
                                    <h4 class="h5 text-black">Sale Products Status : <b><?php echo $listdata[4]; ?></b></h4>
                                    <h4 class="h5 text-black">Payment Status : <b><?php echo $listdata[8]; ?></b></h4>
                                    <h4 class="h5 text-black">Mode Of Payment : <b><?php echo $listdata[9]; ?></b></h4>
                                    <h4 class="h5 text-black">Billed By : <b><?php echo $listdata[10]; ?></b></h4>
                                    
                                </div> 
                                <div class="col-md-4 ">
                                    <br>
                                    <h4 style="position: absolute;right: 15px;" class="h5 text-black">Total Amount</h4>
                                    <br>
                                    <h4 style="position: absolute;right: 15px;" class="h5 text-black">Paid</h4>
                                    <br>
                                    <hr>
                                    <h4 style="position: absolute;right: 15px;" class="h5 text-black">Due Balance</h4>
                                    <br>
                                </div>
                                <div class="col-md-3">
                                    <br>
                                    <h4 style="position: absolute;left: 15px;" class="h5 text-black"><b><?php echo '₹ '.$listdata[5]; ?></b></h4>
                                    <br>
                                    <h4 style="position: absolute;left: 15px;" class="h5 text-black"><b><?php echo '₹ '.$listdata[6]; ?></b></h4>
                                    <br>
                                    <hr>
                                    <h4 style="position: absolute;left: 15px;" class="h5 text-black"><b><?php echo '₹ '.$listdata[7]; ?></b></h4>
                                    <br>
                                </div>
                                <p id="d4" style="display:none;">
                                    <b>Sale Products Status : <?php echo $listdata[4]; ?><br>Payment Status : <?php echo $listdata[8];?><br>Mode Of Payment : <?php echo $listdata[9]; ?><br>Billed By : <?php echo $listdata[10]; ?></b>
                                </p>
                                <p id="d5" style="display:none;">
                                    <b>Total Amount : <?php echo '₹ '.$listdata[5]; ?><br>Paid : <?php echo '₹ '.$listdata[6]; ?><br>Due : <?php echo '₹ '.$listdata[7]; ?></b>
                                </p>
                                    <?php }
                                    } ?>
                            </div>
                        </div>  
                    </div>
                    <a href="page-list-sale.php" class="btn btn-danger mb-3">Back</a>
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