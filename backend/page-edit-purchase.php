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

if (!isset($_SESSION['dateup']) || !isset($_SESSION['idup']) || !isset($_SESSION['pridup']) || !isset($_SESSION['cartno'])) {
  header("location:page-list-purchase.php");
}

$bpdate = $_SESSION['dateup'];
$bpsid = $_SESSION['idup'];
$prid = $_SESSION['pridup'];
$cartno = $_SESSION['cartno'];

include "../connection.php";
$ll1 = "SELECT bpdate,bpsid,cartno FROM billpurchase";
$lexe1 = mysqli_query($conn,$ll1);

if (mysqli_num_rows($lexe1) > 0) {
    $i = 0;
    while ($getx = mysqli_fetch_array($lexe1)) {
        if ($getx[0] == $bpdate && $getx[1] == $bpsid && $getx[2] == $cartno) {
            $ll = "SELECT * FROM billpurchase WHERE bpdate = '$bpdate' AND bpsid = '$bpsid' AND cartno = '$cartno' ";
            $lexe = mysqli_query($conn,$ll);
            $i = 1;
        }  
    }
    if ($i == 0) {
        $ll = "SELECT * FROM billpurchase WHERE 1 != 1";
        $lexe = mysqli_query($conn,$ll);
    }
}

if (isset($_REQUEST['modput'])) {
    $gid = $_REQUEST['selpr'];
    include "../connection.php";
    $ss = "SELECT cost,price,tax,discount FROM products WHERE pid = '$gid' ";
    $xee = mysqli_query($conn,$ss);
    $data = mysqli_fetch_array($xee);
    $cost = floatval($data[0]);
    $mrp = floatval($data[1]);
    $tax = floatval($data[2]);
    $discount = floatval($data[3]);

    $net = $cost + (($cost*$tax)/100) - (($cost*$discount)/100);
    $net = $quantity * $net;

    $ins = " INSERT INTO billpurchase(cartno, bpdate, bpsid, bppid, quantity, cost, mrp, tax, discount, netamt) VALUES('$cartno', '$bpdate','$bpsid','$gid','0','$cost','$mrp','$tax','$discount','$net') ";
    $inin = mysqli_query($conn,$ins);
    if ($inin) {
        header("location:page-edit-purchase.php");
    }
}

if (isset($_REQUEST['upditm'])) {
    $getid = $_REQUEST['getid'];
    $quantity = $_REQUEST['quantity'];
    $cost = $_REQUEST['cost'];
    $mrp = $_REQUEST['mrp'];
    $tax = $_REQUEST['tax'];
    $discount = $_REQUEST['discount'];

    $net = $cost + (($cost*$tax)/100) - (($cost*$discount)/100);
    $net = $quantity * $net;

    include "../connection.php";
    $bpins = "SELECT bppid,quantity,cost,mrp,tax,discount FROM billpurchase WHERE bpid = '$getid' ";
    $bpexe = mysqli_query($conn,$bpins);
    if (mysqli_num_rows($bpexe) > 0) {
        while ($getq = mysqli_fetch_array($bpexe)) {
            $getp = "SELECT quantity FROM products WHERE pid = '$getq[0]' ";
            $pget = mysqli_query($conn,$getp);
            $pdat = mysqli_fetch_array($pget);
            
            $setqty = 0;
            $setqty = intval($pdat[0]) - intval($getq[1]) + intval($quantity);
            $setcost = floatval($getq[2]);
            $setmrp = floatval($getq[3]);
            $settax = floatval($getq[4]);
            $setdiscount = floatval($getq[5]);
            $setprofit = $setmrp - (($setmrp*$settax)/100) - (($setmrp*$setdiscount)/100) - $setcost;

            $insp = "UPDATE products SET quantity = '$setqty', cost = '$setcost', price = '$setmrp', tax = '$settax', discount = '$setdiscount', profit = '$setprofit' WHERE pid = '$getq[0]' ";
            $inspex = mysqli_query($conn,$insp);
        }
    }
        

    $up = "UPDATE billpurchase SET quantity = '$quantity',cost = '$cost',mrp = '$mrp', tax = '$tax',discount = '$discount',netamt = '$net' WHERE bpid = '$getid' ";
    $upd = mysqli_query($conn,$up);
    if ($upd) {
        header("location:page-edit-purchase.php");
    }
}

if (isset($_REQUEST['dele'])) {
    $getid = $_REQUEST['getid'];
    include "../connection.php";

    $getqd = "SELECT quantity,bppid FROM billpurchase WHERE bpid = '$getid' ";
    $exeqd = mysqli_query($conn,$getqd);
    if ($exeqd) {
        $qq = mysqli_fetch_array($exeqd);

        $pro = "SELECT quantity FROM products WHERE pid = '$qq[1]' ";
        $expro = mysqli_query($conn,$pro);
        if ($expro) {
            $pq = mysqli_fetch_array($expro);

            $qtyset = intval($pq[0]) - intval($qq[0]);

            $qset = "UPDATE products SET quantity = '$qtyset' WHERE pid = '$qq[1]' ";
            $exepro = mysqli_query($conn,$qset);
            if ($exepro) {
                $dd = "DELETE FROM billpurchase WHERE bpid = '$getid' ";
                $delp = mysqli_query($conn,$dd);
                if ($delp) {
                    header("location:page-edit-purchase.php");
                }else{
                    echo '<script>alert("Products Not Deleted!");</script>';
                }
            }
        } 
    }
}

if (isset($_REQUEST['updpur'])) {
    $bpdate = $_SESSION['bpdate'];
    include "../connection.php";
    $gstid = "SELECT * FROM suppliers WHERE sid = '$bpsid' ";
    $exgstid = mysqli_query($conn,$gstid);
    $ddd = mysqli_fetch_array($exgstid);

    $purstatus = $_REQUEST['purstatus'];
    $total = $_REQUEST['total'];
    $paid = $_REQUEST['paid'];
    $balance = $_REQUEST['balance'];
    $paystatus = $_REQUEST['paystatus'];
    $paymode = $_REQUEST['paymode'];

    $purid = $_REQUEST['purpur'];

    $bpup = "UPDATE billpurchase SET status = '1' WHERE bpsid = '$bpsid' AND bpdate = '$bpdate' AND cartno = '$cartno'";
    $bpupd = mysqli_query($conn,$bpup);
    if ($bpupd) {
        $sqsq = "UPDATE purchase SET purstatus = '$purstatus', total = '$total', paid = '$paid', balance = '$balance', paystatus = '$paystatus', mode = '$paymode' WHERE purid = '$purid' ";
        $execute = mysqli_query($conn,$sqsq);
                
        $inspay = "UPDATE payment SET amount = '$total', paid = '$paid', balance = '$balance', mode = '$paymode' WHERE recid = '$purid'  AND type = 'Supplier' ";
        $paypay = mysqli_query($conn,$inspay);
        if ($paypay) {
            header("location:page-list-purchase.php");
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
      <title>SHOP | Update Purchase</title>
      
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
                document.getElementById("balance").value = bb;
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
                            <h4 class="card-title">Update Purchase</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="h5 text-black">DATE : <?php echo $bpdate; ?></h4>
                                <h4 class="h5 text-black">PURCHASE ID : <?php 
                                $gg = "SELECT purid FROM purchase WHERE cartno = '$cartno' AND purdate = '$bpdate' AND supplier = '$bpsid' ";
                                $ee = mysqli_query($conn,$gg);
                                $pur = mysqli_fetch_array($ee);
                                echo $pur[0];
                                 ?></h4>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4"><h4 class="h5 text-black">Supplier : </h4></div>
                                    <?php include "../connection.php";
                                        $gg = "SELECT * FROM suppliers WHERE sid = '$bpsid' ";
                                        $ee = mysqli_query($conn,$gg);
                                        $row = mysqli_fetch_array($ee);
                                     ?>
                                    <div class="col-md-8">
                                        <h4 class="h5 text-black"><?php echo $row[1].', '.$row[5]; ?> </h4>
                                        <h4 class="h5 text-black"><?php echo $row[6].', '.$row[2]; ?> </h4>
                                        <h4 class="h5 text-black"><?php echo $row[4].', '.$row[3]; ?> </h4>
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
                                       <th>Category</th>
                                       <th>Code</th>
                                       <th>Name</th>
                                       <th>Brand</th>
                                       <th>Quantity</th>
                                       <th>Cost</th>
                                       <th>MRP</th>
                                       <th>Tax(in %)</th>
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
                                        $sq = "SELECT category,code,name,brand FROM products WHERE pid = '$getpid' ";
                                        $xe = mysqli_query($conn,$sq);
                                        $prodata = mysqli_fetch_array($xe);
                                        $sum = floatval($listdata[10]) + $sum;
                                       ?>
                                    <tr>
                                       <td><?php echo $listdata[0]; ?></td>
                                       <td><?php echo $prodata[0]; ?></td>
                                       <td><?php echo $prodata[1]; ?></td>
                                       <td><?php echo $prodata[2]; ?></td>
                                       <td><?php echo $prodata[3]; ?></td>
                                             <form method="POST">
                                       <td><input size="7" name="quantity" type="text" value="<?php echo $listdata[5]; ?>"></td>
                                       <td><input size="7" name="cost" type="text" value="<?php echo $listdata[6]; ?>"></td>
                                       <td><input size="7" name="mrp" type="text" value="<?php echo $listdata[7]; ?>"></td>
                                       <td><input size="7" name="tax" type="text" value="<?php echo $listdata[8]; ?>"></td>
                                       <td><input size="7" name="discount" type="text" value="<?php echo $listdata[9]; ?>"></td>
                                       <td><?php echo $listdata[10]; ?></td>
                                       <td>
                                          <div class="flex align-items-center list-user-action">
                                                <input type="text" name="getid" value="<?php echo $listdata[0]; ?>" style="display:none;">
                                                <button class="btn btn-sm bg-primary list-inline-item" data-toggle="tooltip" data-placement="top" title=""
                                                data-original-title="Update" type="submit" name="upditm"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15" height="10"><path fill="none" d="M0 0h24v24H0z"/><path d="M15.728 9.686l-1.414-1.414L5 17.586V19h1.414l9.314-9.314zm1.414-1.414l1.414-1.414-1.414-1.414-1.414 1.414 1.414 1.414zM7.242 21H3v-4.243L16.435 3.322a1 1 0 0 1 1.414 0l2.829 2.829a1 1 0 0 1 0 1.414L7.243 21z"/></svg></button>
                                                <button class="btn btn-sm bg-primary" data-toggle="tooltip" data-placement="top" title=""
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
                                        <label for="purstatus">Purchase Products Status</label>
                                        <select class="selectpicker form-control" id="purstatus" data-style="py-0"  name="purstatus" required>
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
                                <div class="col-md-6" style="display:none;">                      
                                    <div class="form-group">
                                        <label for="purpur">Purchase ID</label>
                                        <input type="text" class="form-control" placeholder="Payment Status" value="<?php echo $pur[0]; ?>" id="purpur" name="purpur" required>
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
                            <button type="submit" name="updpur" class="btn btn-primary mr-2">Update Purchase</button>
                            <a href="page-list-purchase.php" class="btn btn-danger">Back</a>
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