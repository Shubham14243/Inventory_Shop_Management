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



 ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Shop | Report</title>
      
      <!-- Favicon -->
      <link rel="shortcut icon" href="../assets/images/favicon.ico" />
      <link rel="stylesheet" href="../assets/css/backend-plugin.min.css">
      <link rel="stylesheet" href="../assets/css/backend.css?v=1.0.0">
      <link rel="stylesheet" href="../assets/vendor/@fortawesome/fontawesome-free/css/all.min.css">
      <link rel="stylesheet" href="../assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css">
      <link rel="stylesheet" href="../assets/vendor/remixicon/fonts/remixicon.css">  </head>
  <body class="sidebar-main">

    <script type="text/javascript">
        function div1call(){
            document.getElementById("div1").style = "display:block";
            document.getElementById("div2").style = "display:none";
            document.getElementById("div3").style = "display:none";
            document.getElementById("div4").style = "display:none";
            document.getElementById("hide").style = "display:none";
        }
        function div2call(){
            document.getElementById("div1").style = "display:none";
            document.getElementById("div2").style = "display:block";
            document.getElementById("div3").style = "display:none";
            document.getElementById("div4").style = "display:none";
            document.getElementById("hide").style = "display:none";
        }
        function div3call(){
            document.getElementById("div1").style = "display:none";
            document.getElementById("div2").style = "display:none";
            document.getElementById("div3").style = "display:block";
            document.getElementById("div4").style = "display:none";
            document.getElementById("hide").style = "display:none";
        }
        function div4call(){
            document.getElementById("div1").style = "display:none";
            document.getElementById("div2").style = "display:none";
            document.getElementById("div3").style = "display:none";
            document.getElementById("div4").style = "display:block";
            document.getElementById("hide").style = "display:none";
        }
    </script>

    <!-- Wrapper Start -->
    <div class="wrapper">
      
      <?php include "sidebar.php"; ?>
            <div class="content-page">
     <div class="container-fluid">
        <div class="col-md-12">
            <center>
                <div class="row col-md-8 mb-5 align-items-center justify-content-center" style="border-bottom:1px solid gray;border-radius: 5px;padding: 20px;">
                    
                        <button type="button" onclick="div1call();" class="btn btn-outline-primary"><b>Sales Report</b></button>&nbsp;&nbsp;&nbsp;&nbsp;
                        <button type="button" onclick="div2call();" class="btn btn-outline-primary"><b>Purchase Report</b></button>&nbsp;&nbsp;&nbsp;&nbsp;
                        <button type="button" onclick="div3call();" class="btn btn-outline-primary"><b>Payment Report</b></button>&nbsp;&nbsp;&nbsp;&nbsp;
                        <button type="button" onclick="div4call();" class="btn btn-outline-primary"><b>Payment Due Report</b></button>
                    
                </div> 
            <div class="col-lg-6" id="hide">
                <div class="card card-block card-stretch card-height">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Report</h4>
                        </div>
                    </div>   
                    <div class="card-body">
                        <p>
                            Here, You will get all types of reports regarding your Sale, Purchase and Payments. 
                            <br>
                            Please select any of the above options to proceed. 
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" id="div1" style="display:none;">
                <div class="card card-block card-stretch card-height">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Sales Report</h4>
                        </div>
                    </div>   
                    <div class="card-body">
                        <div class="col-lg-12" style="border: 1px solid lightgray; border-radius: 5px;padding: 10px;">
                            <h5 class="card-title">Sale Report By Customer </h5>
                            <br>
                            <div>
                                <center>
                                    <ul class="list-inline">
                                    <li class="list-inline-item">
                                        <form method="POST" action="page-view-salrep.php">
                                        <label for="bpsupp">Select Customer:</label>
                                    </li>
                                    <li class="list-inline-item">
                                            <div class="form-group">
                                                
                                                    <input class="form-control" list="getcust" name="getscid" id="bpsupp" required>
                                                    <datalist id="getcust">Select</option>
                                                    <?php 
                                                    include "../connection.php";
                                                    $getp = "SELECT * FROM customers";
                                                    $setp = mysqli_query($conn,$getp);
                                                    if (mysqli_num_rows($setp) == 0) {
                                                        $getp = "SELECT * FROM customers LIMIT 0";
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
                                    <li class="list-inline-item"><button class="btn btn-primary" name="custsalrep">Get Report</button></li></form>
                                </ul>
                                </center>
                            </div>
                        </div>
                        <div class="col-lg-12" style="border: 1px solid lightgray; border-radius: 5px;padding: 10px;">
                            <h5 class="card-title">Sale Report By Date</h5>
                            <br>
                            <div>
                                <center>
                                    <form method="POST" action="page-view-salrep.php">
                                        <div class="row" style="padding-left: 70px;">
                                            <div class="col-lg-2">
                                                <label style="margin-right: 10px;" for="sdate">Select : </label>
                                            </div>
                                            <div class="col-lg-10">
                                                <input class="form-control col-lg-8" style="margin-right: 200px;" type="date" id="sdate" name="getsdate">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group"style="padding-left: 25px;">
                                            <button class="btn btn-primary" name="datesalrep">Get Report</button>
                                        </div>
                                   </form>
                                </center>
                            </div>
                        </div>
                        <div class="col-lg-12" style="border: 1px solid lightgray; border-radius: 5px;padding: 10px;">
                            <h5 class="card-title">Sale Report By Date Range</h5>
                            <br>
                            <div>
                                <center>
                                    <form method="POST" action="page-view-salrep.php">
                                        <div class="row" style="padding-left: 70px;">
                                            <div class="col-lg-2">
                                                <label style="margin-right: 10px;" for="sdate">From : </label>
                                            </div>
                                            <div class="col-lg-10">
                                                <input class="form-control col-lg-8" style="margin-right: 200px;" type="date" id="sdate" name="sdatestart">
                                            </div>
                                        </div>
                                        <div class="row" style="padding-left: 70px;">
                                            <div class="col-lg-2">
                                                <label style="margin-right: 10px;" for="sdate">To : </label>
                                            </div>
                                            <div class="col-lg-10">
                                                <input class="form-control col-lg-8" style="margin-right: 200px;" type="date" id="edate" name="sdateend">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group"style="padding-left: 25px;">
                                            <button class="btn btn-primary" name="rdatesalrep">Get Report</button>
                                        </div>
                                   </form>
                                </center>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" id="div2" style="display:none;">
                <div class="card card-block card-stretch card-height">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Purchase Report</h4>
                        </div>
                    </div>   
                    <div class="card-body">
                        <div class="col-lg-12" style="border: 1px solid lightgray; border-radius: 5px;padding: 10px;">
                            <h5 class="card-title">Purchase Report By Supplier </h5>
                            <br>
                            <div>
                                <center>
                                    <ul class="list-inline">
                                    <li class="list-inline-item">
                                        <form method="POST" action="page-view-purrep.php">
                                        <label for="bpsupp">Select Supplier:</label>
                                    </li>
                                    <li class="list-inline-item">
                                            <div class="form-group">
                                                
                                                    <input class="form-control" list="getsup" name="getpsid" id="bpsupp" required>
                                                    <datalist id="getsup">Select</option>
                                                    <?php 
                                                    include "../connection.php";
                                                    $getp = "SELECT * FROM suppliers";
                                                    $setp = mysqli_query($conn,$getp);
                                                    if (mysqli_num_rows($setp) == 0) {
                                                        $getp = "SELECT * FROM suppliers LIMIT 0";
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
                                    <li class="list-inline-item"><button class="btn btn-primary" name="suppurrep">Get Report</button></li></form>
                                </ul>
                                </center>
                            </div>
                        </div>
                        <div class="col-lg-12" style="border: 1px solid lightgray; border-radius: 5px;padding: 10px;">
                            <h5 class="card-title">Purchase Report By Date</h5>
                            <br>
                            <div>
                                <center>
                                    <form method="POST" action="page-view-purrep.php">
                                        <div class="row" style="padding-left: 70px;">
                                            <div class="col-lg-2">
                                                <label style="margin-right: 10px;" for="sdate">Select : </label>
                                            </div>
                                            <div class="col-lg-10">
                                                <input class="form-control col-lg-8" style="margin-right: 200px;" type="date" id="sdate" name="getpdate">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group"style="padding-left: 25px;">
                                            <button class="btn btn-primary" name="datepurrep">Get Report</button>
                                        </div>
                                   </form>
                                </center>
                            </div>
                        </div>
                        <div class="col-lg-12" style="border: 1px solid lightgray; border-radius: 5px;padding: 10px;">
                            <h5 class="card-title">Purchase Report By Date Range</h5>
                            <br>
                            <div>
                                <center>
                                    <form method="POST" action="page-view-purrep.php">
                                        <div class="row" style="padding-left: 70px;">
                                            <div class="col-lg-2">
                                                <label style="margin-right: 10px;" for="sdate">From : </label>
                                            </div>
                                            <div class="col-lg-10">
                                                <input class="form-control col-lg-8" style="margin-right: 200px;" type="date" id="sdate" name="pdatestart">
                                            </div>
                                        </div>
                                        <div class="row" style="padding-left: 70px;">
                                            <div class="col-lg-2">
                                                <label style="margin-right: 10px;" for="sdate">To : </label>
                                            </div>
                                            <div class="col-lg-10">
                                                <input class="form-control col-lg-8" style="margin-right: 200px;" type="date" id="edate" name="pdateend">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group"style="padding-left: 25px;">
                                            <button class="btn btn-primary" name="rdatepurrep">Get Report</button>
                                        </div>
                                   </form>
                                </center>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" id="div3" style="display:none;">
                <div class="card card-block card-stretch card-height">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Payment Report</h4>
                        </div>
                    </div>                    
                    <div class="card-body">
                        <div class="col-lg-12" style="border: 1px solid lightgray; border-radius: 5px;padding: 10px;">
                            <h5 class="card-title">Payment Report By Date</h5>
                            <br>
                            <div>
                                <center>
                                    <form method="POST" action="page-view-payrep.php">
                                        <div class="row" style="padding-left: 70px;">
                                            <div class="col-lg-2">
                                                <label style="margin-right: 10px;" for="sdate">Select : </label>
                                            </div>
                                            <div class="col-lg-10">
                                                <input class="form-control col-lg-8" style="margin-right: 200px;" type="date" id="sdate" name="getpaydate">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group"style="padding-left: 25px;">
                                            <button class="btn btn-primary" name="datepayrep">Get Report</button>
                                        </div>
                                   </form>
                                </center>
                            </div>
                        </div>
                        <div class="col-lg-12" style="border: 1px solid lightgray; border-radius: 5px;padding: 10px;">
                            <h5 class="card-title">Payment Report By Date Range</h5>
                            <br>
                            <div>
                                <center>
                                    <form method="POST" action="page-view-payrep.php">
                                        <div class="row" style="padding-left: 70px;">
                                            <div class="col-lg-2">
                                                <label style="margin-right: 10px;" for="sdate">From : </label>
                                            </div>
                                            <div class="col-lg-10">
                                                <input class="form-control col-lg-8" style="margin-right: 200px;" type="date" id="sdate" name="paydatestart">
                                            </div>
                                        </div>
                                        <div class="row" style="padding-left: 70px;">
                                            <div class="col-lg-2">
                                                <label style="margin-right: 10px;" for="sdate">To : </label>
                                            </div>
                                            <div class="col-lg-10">
                                                <input class="form-control col-lg-8" style="margin-right: 200px;" type="date" id="edate" name="paydateend">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group"style="padding-left: 25px;">
                                            <button class="btn btn-primary" name="rdatepayrep">Get Report</button>
                                        </div>
                                   </form>
                                </center>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" id="div4" style="display:none;">
                <div class="card card-block card-stretch card-height">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Payment Due Report</h4>
                        </div>
                    </div>                    
                    <div class="card-body">
                        <div class="col-lg-12" style="border: 1px solid lightgray; border-radius: 5px;padding: 10px;">
                            <h5 class="card-title">Payment Due Report By Date</h5>
                            <br>
                            <div>
                                <center>
                                    <form method="POST" action="page-view-due.php">
                                        <div class="row" style="padding-left: 70px;">
                                            <div class="col-lg-2">
                                                <label style="margin-right: 10px;" for="sdate">Select : </label>
                                            </div>
                                            <div class="col-lg-10">
                                                <input class="form-control col-lg-8" style="margin-right: 200px;" type="date" id="sdate" name="getduedate">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group"style="padding-left: 25px;">
                                            <button class="btn btn-primary" name="dateduerep">Get Report</button>
                                        </div>
                                   </form>
                                </center>
                            </div>
                        </div>
                        <div class="col-lg-12" style="border: 1px solid lightgray; border-radius: 5px;padding: 10px;">
                            <h5 class="card-title">Payment Due Report By Date Range</h5>
                            <br>
                            <div>
                                <center>
                                    <form method="POST" action="page-view-due.php">
                                        <div class="row" style="padding-left: 70px;">
                                            <div class="col-lg-2">
                                                <label style="margin-right: 10px;" for="sdate">From : </label>
                                            </div>
                                            <div class="col-lg-10">
                                                <input class="form-control col-lg-8" style="margin-right: 200px;" type="date" id="sdate" name="duedatestart">
                                            </div>
                                        </div>
                                        <div class="row" style="padding-left: 70px;">
                                            <div class="col-lg-2">
                                                <label style="margin-right: 10px;" for="sdate">To : </label>
                                            </div>
                                            <div class="col-lg-10">
                                                <input class="form-control col-lg-8" style="margin-right: 200px;" type="date" id="edate" name="duedateend">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group"style="padding-left: 25px;">
                                            <button class="btn btn-primary" name="rdateduerep">Get Report</button>
                                        </div>
                                   </form>
                                </center>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </center>
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