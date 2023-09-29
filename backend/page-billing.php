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

if (!isset($_SESSION['custid']) || !isset($_SESSION['cartno'])|| !isset($_SESSION['cdate'])) {
   header("location:index.php");
}else {
    $ds = "";
   $bsdate = $_SESSION['cdate'];
   $custid = $_SESSION['custid'];
   $cartno = $_SESSION['cartno'];
   include "../connection.php";
   $csql = "SELECT * FROM customers WHERE cid = '$custid' ";
   $cexe = mysqli_query($conn,$csql);
   $custdata = mysqli_fetch_array($cexe);
   if ($custdata[6] == "YES") {
       $ds = "Retailer";
   }else{
        $ds = "Customer";
   }
}

include "../connection.php";
$ll1 = "SELECT bsdate,custid,cartno FROM billsale";
$lexe1 = mysqli_query($conn,$ll1);

if (mysqli_num_rows($lexe1) == 0) {
   $ll = "SELECT * FROM billsale LIMIT 0";
   $lexe = mysqli_query($conn,$ll);
}
$flag = 0;
if (mysqli_num_rows($lexe1) > 0) {
    while ($getx = mysqli_fetch_array($lexe1)) {
        if ($getx[0] == $bsdate && $getx[1] == $custid && $getx[2] == $cartno) {
            $ll = "SELECT * FROM billsale WHERE bsdate = '$bsdate' AND custid = '$custid' AND cartno = '$cartno' AND status = '0' ";
            $lexe = mysqli_query($conn,$ll);
            $flag = 1;
            break;
        }
      }
      if ($flag == 0) {
         $ll = "SELECT * FROM billsale LIMIT 0";
         $lexe = mysqli_query($conn,$ll);
      }   
}


if (isset($_REQUEST['modput'])) {
    $gid = $_REQUEST['selpr'];
    include "../connection.php";
    $ss = "SELECT cost,price,tax,discount,retmrp FROM products WHERE pid = '$gid' ";
    $xee = mysqli_query($conn,$ss);
    $data = mysqli_fetch_array($xee);
    $cost = floatval($data[0]);
    if ($custdata[6] == "YES") {
        $mrp = floatval($data[4]);
    }else{
         $mrp = floatval($data[1]);
    }
    $tax = floatval($data[2]);
    $discount = floatval($data[3]);
    $quantity = 0;
    $net = $mrp - (($mrp*$discount)/100) ;
    $net = $quantity * $net;
    $status = "0";

    $ins = " INSERT INTO billsale(cartno, bsdate, custid, proid, quantity, cost, mrp, tax, discount, netamt,status) VALUES('$cartno', '$bsdate','$custid','$gid','$quantity','$cost','$mrp','$tax','$discount','$net','$status') ";
    $inin = mysqli_query($conn,$ins);
    if ($inin) {
        header("location:page-billing.php");
    }
}

if (isset($_REQUEST['upditm'])) {
    $getid = $_REQUEST['getid'];
    $quantity = $_REQUEST['quantity'];
    $mrp = $_REQUEST['mrp'];
    $discount = $_REQUEST['discount'];

    $net = $mrp - (($mrp*$discount)/100) ;
    $net = $quantity * $net;

    include "../connection.php";

    $up = "UPDATE billsale SET quantity = '$quantity',discount = '$discount',netamt = '$net' WHERE bsid = '$getid' ";
    $upd = mysqli_query($conn,$up);
    if ($upd) {
       header("location:page-billing.php");
    }
}


if (isset($_REQUEST['dele'])) {
    $getid = $_REQUEST['getid'];
    include "../connection.php";
    $dd = "DELETE FROM billsale WHERE bsid = '$getid' ";
    $delp = mysqli_query($conn,$dd);
    if ($delp) {
        header("location:page-billing.php");
    }else{
        echo '<script>alert("Products Not Deleted!");</script>';
    }
}

if (isset($_REQUEST['addsale'])) {
    include "../connection.php";

    $salstatus = $_REQUEST['salstatus'];
    $total = $_REQUEST['total'];
    $paid = $_REQUEST['paid'];
    $balance = $_REQUEST['balance'];
    $paystatus = $_REQUEST['paystatus'];
    $paymode = $_REQUEST['paymode'];

    $useremail1 = $_SESSION['user'];
   include "../connection.php";
   $sql1 = "SELECT * FROM users WHERE email = '$useremail1' ";
   $exe1 = mysqli_query($conn,$sql1);
   $userdata1 = mysqli_fetch_array($exe1);
    $biller = $userdata1[1];

    $c=0;
    $bsins = "SELECT proid,quantity FROM billsale WHERE custid = '$custid' AND bsdate = '$bsdate' AND cartno = '$cartno'";
    $bsexe = mysqli_query($conn,$bsins);
    if (mysqli_num_rows($bsexe) > 0) {
        while ($getq = mysqli_fetch_array($bsexe)) {
            $getp = "SELECT quantity,name FROM products WHERE pid = '$getq[0]' ";
            $pget = mysqli_query($conn,$getp);
            $pdat = mysqli_fetch_array($pget);

            if (intval($pdat[0]) >= intval($getq[1])) {
               $setqty = intval($pdat[0]) - intval($getq[1]);

               $insp = "UPDATE products SET quantity = '$setqty' WHERE pid = '$getq[0]' ";
               $inspex = mysqli_query($conn,$insp);
               if ($inspex) {
                   $c = 1;
               }
            }else {
               echo '<script>alert("Only '.$pdat[0].' '.$pdat[1].' Left");</script>';
               $c = 0 ;
            }
        }
    }

    if ($c == 1) {
        $bpup = "UPDATE billsale SET status = '1' WHERE custid = '$custid' AND bsdate = '$bsdate' AND cartno = '$cartno'";
        $bpupd = mysqli_query($conn,$bpup);
        if ($bpupd) {
            $sqsq = "INSERT INTO sale(cartno, saldate, custid, salstatus, total, paid, balance, paystatus, mode, biller) VALUES('$cartno','$bsdate','$custid','$salstatus','$total','$paid','$balance','$paystatus','$paymode','$biller')";
            $execute = mysqli_query($conn,$sqsq);
            if ($execute) {
                $getpay = "SELECT salid FROM sale WHERE custid = '$custid' AND saldate = '$bsdate' AND cartno = '$cartno' ";
                $exee = mysqli_query($conn,$getpay);
                $paydata = mysqli_fetch_array($exee);
                $type = "Customer";
                $inspay = "INSERT INTO payment(type, typeid, amount, paid, balance, paydate, mode, recid) VALUES('$type', '$custid', '$total', '$paid', '$balance', '$bsdate', '$paymode', '$paydata[0]' )";
                $paypay = mysqli_query($conn,$inspay);
                if ($paypay) {
                  $custcount = "UPDATE customers SET orders = orders + 1 WHERE cid = '$custid' ";
                  $custset = mysqli_query($conn,$custcount);
                  if ($custset) {
                     header("location:page-list-sale.php");
                  }else{
                    echo '<script>alert("Error Occured! Try Again!");</script>';
                  } 
                }else{
                    echo '<script>alert("Error Occured! Try Again!");</script>';
                }     
            }else{
                echo '<script>alert("Error Occured! Try Again!");</script>';
            }
        }else{
            echo '<script>alert("Error Occured! Try Again!");</script>';
        }
    }  
}

$sum = "";

 ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>SHOP | Billing</title>
      
      <!-- Favicon -->
      <link rel="shortcut icon" href="../assets/images/favicon.ico" />
      <link rel="stylesheet" href="../assets/css/backend-plugin.min.css">
      <link rel="stylesheet" href="../assets/css/backend.css?v=1.0.0">
      <link rel="stylesheet" href="../assets/vendor/@fortawesome/fontawesome-free/css/all.min.css">
      <link rel="stylesheet" href="../assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css">
      <link rel="stylesheet" href="../assets/vendor/remixicon/fonts/remixicon.css">  </head>
  <body class="sidebar-main">
    <script type="text/javascript">
        function vval(){
            tt = document.getElementById("total").value;
            pp = document.getElementById("paid").value;
            bb = tt-pp;
            if (bb < 0) {
                document.getElementById("paid").value = "";
                document.getElementById("balance").value = "";
                alert("Paid Amount Can't Be More Than Total Amount");
            }else{
                document.getElementById("balance").value = bb.toFixed(2);
            }

            if (bb == 0) {
                document.getElementById("paystatus").value = "Paid";
            }else if(bb > 0){
                document.getElementById("paystatus").value = "Due";
            }
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
                            <h4 class="card-title">Billing</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="h5 text-black">DATE : <?php echo $bsdate; ?></h4>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4"><h4 class="h5 text-black">Customer : </h4></div>
                                    <div class="col-md-8">
                                        <h4 class="h5 text-black"><?php echo $custdata[1].'/'.$ds; ?> </h4>
                                        <h4 class="h5 text-black">Address : <?php echo $custdata[4]; ?> </h4>
                                        <h4 class="h5 text-black">Phone No : <?php echo $custdata[2]; ?> </h4>
                                        <h4 class="h5 text-black">Email : <?php echo $custdata[3]; ?> </h4>
                                    </div>
                                </div>
                                
                            </div>
                        </div><hr>
                            <div class="col-md-12">
                                <ul class="list-inline">
                                    <li class="list-inline-item"><h4 class="h5 text-black">Add Product </h4></li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <li class="list-inline-item">
                                        <form method="POST">
                                        <label for="bpsupp">Select Product:</label>
                                    </li>
                                    <li class="list-inline-item">
                                            <div class="form-group">
                                                
                                                    <input class="form-control" list="getsup" name="selpr" id="bpsupp" required>
                                                    <datalist id="getsup">Select</option>
                                                    <?php 
                                                    include "../connection.php";
                                                    $getp = "SELECT * FROM products";
                                                    $setp = mysqli_query($conn,$getp);
                                                    if (mysqli_num_rows($setp) == 0) {
                                                        $getp = "SELECT * FROM products LIMIT 0";
                                                        $setp = mysqli_query($conn,$getp);
                                                    }
                                                    if (mysqli_num_rows($setp) > 0) {
                                                        while ($putp = mysqli_fetch_array($setp)) {
                                                    ?>
                                                            <option value="<?php echo $putp[0]; ?>"><?php echo $putp[1]; ?>/<?php echo $putp[2]; ?>/<?php echo $putp[3]; ?>/<?php echo $putp[4]; ?></option>      
                                                    <?php
                                                        }
                                                    }
                                                        ?>
                                                    </datalist>
                                             </div>
                                        
                                    </li>
                                    <li class="list-inline-item"><button class="btn btn-primary" name="modput">Add Product</button></li></form>
                                </ul>
                                <br>
                                <table id="user-list-table" class="table table-striped dataTable mt-4 text-center" role="grid" aria-describedby="user-list-page-info">
                                 <thead>
                                    <tr class="ligth">
                                       <th>S.N0.</th>
                                       <th>Brand</th>
                                       <th>Name</th>
                                       <th>Quantity</th>
                                       <th>MRP</th>
                                       <th>Included Tax</th>
                                       <th>Discount(in %)</th>
                                       <th>Amount</th>
                                       <th style="min-width: 120px">Action</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php if (mysqli_num_rows($lexe) > 0) {
                                        $sum = 0;
                                       while ($listdata = mysqli_fetch_array($lexe)) {

                                        $getpid = $listdata[4];
                                        $sq = "SELECT name,brand FROM products WHERE pid = '$getpid' ";
                                        $xe = mysqli_query($conn,$sq);
                                        $prodata = mysqli_fetch_array($xe);
                                        $sum = floatval($listdata[10]) + $sum;
                                       ?>
                                    <tr>
                                       <td><?php echo $listdata[0]; ?></td>
                                       <td><?php echo $prodata[1]; ?></td>
                                       <td><?php echo $prodata[0]; ?></td>
                                             <form method="POST">
                                       <td><input size="7" name="quantity" type="text" value="<?php echo $listdata[5]; ?>" required></td>
                                       <td><?php echo $listdata[7]; ?></td>
                                       <td><?php echo $listdata[8]; ?> %</td>
                                       <td><input size="7" name="discount" type="text" value="<?php echo $listdata[9]; ?>"></td>
                                       <td><?php echo $listdata[10]; ?></td>
                                       <td>
                                          <div class="flex align-items-center list-user-action">
                                                <input type="text" name="getid" value="<?php echo $listdata[0]; ?>" style="display:none;">
                                                <input size="7" name="mrp" type="text" value="<?php echo $listdata[7]; ?>" style="display:none;">
                                                <button class="btn btn-sm bg-success list-inline-item" data-toggle="tooltip" data-placement="top" title=""
                                                data-original-title="Update" type="submit" name="upditm"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15" height="10"><path fill="none" d="M0 0h24v24H0z"/><path d="M15.728 9.686l-1.414-1.414L5 17.586V19h1.414l9.314-9.314zm1.414-1.414l1.414-1.414-1.414-1.414-1.414 1.414 1.414 1.414zM7.242 21H3v-4.243L16.435 3.322a1 1 0 0 1 1.414 0l2.829 2.829a1 1 0 0 1 0 1.414L7.243 21z"/></svg></button>
                                                <button class="btn btn-sm bg-warning" data-toggle="tooltip" data-placement="top" title=""
                                                data-original-title="Caution : Delete" name="dele"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15" height="10"><path fill="none" d="M0 0h24v24H0z"/><path d="M17 6h5v2h-2v13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V8H2V6h5V3a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v3zm1 2H6v12h12V8zm-9 3h2v6H9v-6zm4 0h2v6h-2v-6zM9 4v2h6V4H9z"/></svg></button>
                                             </form>
                                          </div>
                                       </td>
                                    </tr>
                                    <?php }
                                    } ?>
                                 </tbody>
                              </table>
                            </div><hr>
                            <div class="col-md-12">
                                <form method="POST">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="salstatus">Products Sale Status</label>
                                        <select class="selectpicker form-control" id="salstatus" data-style="py-0"  name="salstatus" required>
                                            <option value="">Select</option>
                                            <option value="Pending">Pending</option>
                                            <option value="Received">Received</option>
                                        </select>
                                    </div>
                                </div> 
                                <div class="col-md-6">                      
                                    <div class="form-group">
                                        <label>Total Amount </label>
                                        <input type="text" class="form-control" placeholder="Total Amount" value="<?php echo $sum; ?>" id="total" name="total" required>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">                      
                                    <div class="form-group">
                                        <label for="paystatus">Payment Status</label>
                                        <input type="text" class="form-control" placeholder="Payment Status" id="paystatus" name="paystatus" required>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>    
                                <div class="col-md-6">                      
                                    <div class="form-group">
                                        <label>Paid</label>
                                        <input type="text" class="form-control" onkeyup="vval()" placeholder="Paid" name="paid" id="paid" required>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="paymode">Mode Of Payment</label>
                                        <select class="selectpicker form-control" id="paymode" data-style="py-0"  name="paymode" required>
                                            <option value="">Select</option>
                                            <option value="Cash">Cash</option>
                                            <option value="Cheque">Cheque</option>
                                            <option value="UPI">UPI</option>
                                            <option value="Bank Transfer">Bank Transfer</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">                      
                                    <div class="form-group">
                                        <label>Balance</label>
                                        <input type="text" class="form-control" placeholder="Balance" name="balance" id="balance" required>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>                                
                            </div>                            
                            <button type="submit" name="addsale" class="btn btn-primary mr-2">Add Sale</button>
                            <a href="page-list-sale.php" class="btn btn-danger">Back</a>
                            </form>
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