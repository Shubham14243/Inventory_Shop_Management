<?php 


$useremail = $_SESSION['user'];
include "../connection.php";
$sql = "SELECT * FROM users WHERE email = '$useremail' ";
$exe = mysqli_query($conn,$sql);
$userdata = mysqli_fetch_array($exe);

if (isset($_REQUEST['out'])) {
  session_destroy();
  header("location:auth-sign-in.php");
}

$ca1 = $ca2 = $ca3 = $ca4 = $ca5 = $ca6 = $ca7 = $ca8 = $ca9 = $ca10 = $ca11 = " ";

$link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

if ($link == "http://localhost/inv/backend/index.php") {
  $ca1 = "active";
  $ca2 = $ca3 = $ca4 = $ca5 = $ca6 = $ca7 = $ca8 = $ca9 = $ca10 = $ca11 = " ";
} elseif ($link == "http://localhost/inv/backend/page-add-users.php" || $link == "http://localhost/inv/backend/page-list-users.php") {
  $ca2 = "active";
  $ca1 = $ca3 = $ca4 = $ca5 = $ca6 = $ca7 = $ca8 = $ca9 = $ca10 = $ca11 = " ";
} elseif ($link == "http://localhost/inv/backend/page-add-customers.php" || $link == "http://localhost/inv/backend/page-list-customers.php") {
  $ca3 = "active";
  $ca1 = $ca2 = $ca4 = $ca5 = $ca6 = $ca7 = $ca8 = $ca9 = $ca10 = $ca11 = " ";
} elseif ($link == "http://localhost/inv/backend/page-add-suppliers.php" || $link == "http://localhost/inv/backend/page-list-suppliers.php") {
  $ca11 = "active";
  $ca1 = $ca2 = $ca4 = $ca5 = $ca6 = $ca7 = $ca8 = $ca9 = $ca10 = $ca3 = " ";
} elseif ($link == "http://localhost/inv/backend/page-add-product.php" || $link == "http://localhost/inv/backend/page-list-product.php") {
  $ca4 = "active";
  $ca1 = $ca3 = $ca2 = $ca5 = $ca6 = $ca7 = $ca8 = $ca9 = $ca10 = $ca11 = " ";
} elseif ($link == "http://localhost/inv/backend/pages-list-payment.php") {
  $ca5 = "active";
  $ca1 = $ca3 = $ca4 = $ca2 = $ca6 = $ca7 = $ca8 = $ca9 = $ca10 = $ca11 = " ";
} elseif ($link == "http://localhost/inv/backend/page-add-sale.php" || $link == "http://localhost/inv/backend/page-list-sale.php") {
  $ca6 = "active";
  $ca1 = $ca3 = $ca4 = $ca5 = $ca2 = $ca7 = $ca8 = $ca9 = $ca10 = $ca11 = " ";
} elseif ($link == "http://localhost/inv/backend/page-add-purchase.php" || $link == "http://localhost/inv/backend/page-list-purchase.php") {
  $ca7 = "active";
  $ca1 = $ca3 = $ca4 = $ca5 = $ca6 = $ca2 = $ca8 = $ca9 = $ca10 = $ca11 = " ";
} elseif ($link == "http://localhost/inv/backend/page-report.php") {
  $ca9 = "active";
  $ca1 = $ca3 = $ca4 = $ca5 = $ca6 = $ca7 = $ca8 = $ca2 = $ca10 = $ca11 = " ";
} elseif ($link == "http://localhost/inv/backend/pages-backup.php") {
  $ca10 = "active";
  $ca1 = $ca3 = $ca4 = $ca5 = $ca6 = $ca7 = $ca8 = $ca9 = $ca2 = $ca11 = " ";
}


 ?>


<div class="iq-sidebar sidebar-default">
          <div class="iq-sidebar-logo d-flex align-items-center justify-content-between">
              <a href="../backend/index.php" class="header-logo">
                  <img src="../assets/images/logo.png" class="img-fluid rounded-normal light-logo" alt="logo"><h5 class="logo-title light-logo ml-3">Welcome</h5>
              </a>
              <div class="iq-menu-bt-sidebar ml-0">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M3 4h18v2H3V4zm0 7h18v2H3v-2zm0 7h18v2H3v-2z"/></svg>
              </div>
          </div>
          <div class="data-scrollbar" data-scroll="1">
              <nav class="iq-sidebar-menu">
                  <ul id="iq-sidebar-toggle" class="iq-menu">
                      <li class="<?php echo $ca1; ?>">
                          <a href="../backend/index.php"  data-toggle="tooltip" data-placement="right" title="" data-original-title="Dashboard" class="svg-icon">                        
                              <svg  class="svg-icon" id="p-dash1" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                  <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line>
                              </svg>
                              <span class="ml-4">Dashboards</span>
                          </a>
                      </li>
                      <li class="<?php echo $ca5; ?>">
                        <a href="page-list-payment.php"  data-toggle="tooltip" data-placement="right" title="" data-original-title="Payments" class="svg-icon">
                              <svg class="svg-icon" id="p-dash5" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                  <line x1="1" y1="10" x2="23" y2="10"></line>
                              </svg>
                              <span class="ml-4">Payments</span>
                          </a>
                      </li>
                      <li class="<?php echo $ca6; ?>">
                          <a href="page-list-sale.php"  data-toggle="tooltip" data-placement="right" title="" data-original-title="Sale" class="svg-icon">
                              <svg class="svg-icon" id="p-dash4" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                  <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path><path d="M22 12A10 10 0 0 0 12 2v10z"></path>
                              </svg>
                              <span class="ml-4">Sale</span>
                          </a>
                      </li>
                      <li class="<?php echo $ca7; ?>">
                          <a href="page-list-purchase.php"  data-toggle="tooltip" data-placement="right" title="" data-original-title="Purchase" class="svg-icon">
                              <svg class="svg-icon" id="p-dash9" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                  <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><rect x="7" y="7" width="3" height="9"></rect><rect x="14" y="7" width="3" height="5"></rect>
                              </svg>
                              <span class="ml-4">Purchase</span>
                          </a>
                    </li>
                      <li class="<?php echo $ca4; ?>">
                          <a href="page-list-product.php"  data-toggle="tooltip" data-placement="right" title="" data-original-title="Products" class="svg-icon">
                              <svg class="svg-icon" id="p-dash2" width="20" height="20"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle>
                                  <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                              </svg>
                              <span class="ml-4">Products</span>
                          </a>
                      </li>          
                      <li class="<?php echo $ca11; ?>">
                          <a href="page-list-suppliers.php"  data-toggle="tooltip" data-placement="right" title="" data-original-title="Suppliers" class="svg-icon">
                              <svg class="svg-icon" id="p-dash8" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                  <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                              </svg>
                              <span class="ml-4">Suppliers</span>
                          </a>
                      </li>
                      <li class="<?php echo $ca3; ?>">
                          <a href="page-list-customers.php"  data-toggle="tooltip" data-placement="right" title="" data-original-title="Customers" class="svg-icon">
                              <svg class="svg-icon" id="p-dash8" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                  <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                              </svg>
                              <span class="ml-4">Customers</span>
                          </a>
                      </li>
                      <li class="<?php echo $ca2; ?>">
                          <a href="page-list-users.php"  data-toggle="tooltip" data-placement="right" title="" data-original-title="Users" class="svg-icon">
                              <svg class="svg-icon" id="p-dash10" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                  <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><polyline points="17 11 19 13 23 9"></polyline>
                              </svg>
                              <span class="ml-4">Users</span>
                          </a>
                      </li>
                      <li class="<?php echo $ca9; ?>">
                          <a href="../backend/page-report.php"  data-toggle="tooltip" data-placement="right" title="" data-original-title="Reports" class="">
                              <svg class="svg-icon" id="p-dash7" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                  <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline>
                              </svg>
                              <span class="ml-4">Reports</span>
                          </a>
                          <ul id="reports" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                          </ul>
                      </li>
                      <li class="<?php echo $ca10; ?>">
                        <a  href="#" data-toggle="modal" data-target="#bkup" class=" ">
                            <svg class="svg-icon" id="p-dash16" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <ellipse cx="12" cy="5" rx="9" ry="3"></ellipse><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path>
                            </svg>
                            <span class="ml-4">Backup</span>
                        </a>

                      </li>
                  </ul>
              </nav>
              <div class="p-3"></div>
          </div>
          </div>      
          <div class="iq-top-navbar">
          <div class="iq-navbar-custom">
              <nav class="navbar navbar-expand-lg navbar-light p-0">
                  <div class="iq-navbar-logo d-flex align-items-center justify-content-between">
                      <i class="ri-menu-line wrapper-menu"></i>
                      <a href="../backend/index.php" class="header-logo">
                          <img src="../assets/images/logo.png" class="img-fluid rounded-normal" alt="logo">
                          <h5 class="logo-title ml-3">SHOP</h5>
      
                      </a>
                  </div>
                  <div class="iq-search-bar device-search">
                      <label class="h2"><?php echo $userdata[5]; ?></label>
                  </div>
                  <div class="d-flex align-items-center">
                      <button class="navbar-toggler" type="button" data-toggle="collapse"
                          data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                          aria-label="Toggle navigation">
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M3 4h18v2H3V4zm6 7h12v2H9v-2zm-6 7h18v2H3v-2z"/></svg>
                      </button>
                      <div class="collapse navbar-collapse" id="navbarSupportedContent">
                          <ul class="navbar-nav ml-auto navbar-list align-items-center">
                              <li>
                                  <a href="#" data-toggle="modal" data-target=".bd-example-modal-sm" class="btn border add-btn shadow-none mx-2 d-none d-md-block">
                                    <i class="las la-clipboard-list mr-2"></i>Billing
                                  </a>
                              </li>
                              <li>
                                  <h5 style="padding-top:10px;"><?php echo ' Hello '.$userdata[1].' !'; ?></h5>
                              </li>
                              <li class="nav-item nav-icon dropdown caption-content">
                                  <a href="#" class="search-toggle dropdown-toggle" id="dropdownMenuButton4"
                                      data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      <img src="../assets/images/user/1.png" class="img-fluid rounded" alt="user">
                                  </a>
                                  <div class="iq-sub-dropdown dropdown-menu" aria-labelledby="dropdownMenuButton">
                                      <div class="card shadow-none m-0">
                                          <div class="card-body p-0 text-center">
                                              <div class="media-body profile-detail text-center">
                                                  <img src="../assets/images/pbg.jpg" alt="profile-bg"
                                                      class="rounded-top img-fluid mb-4">
                                                  <img src="../assets/images/user/1.png" alt="profile-img"
                                                      class="rounded profile-img img-fluid avatar-70">
                                              </div>
                                              <div class="p-3">
                                                  <h5 class="mb-1"><?php echo $userdata[1]; ?><br><?php echo $userdata[3]; ?></h5>
                                                  <p class="mb-0"><?php echo $userdata[8]; ?></p>
                                                  <div class="d-flex align-items-center justify-content-center mt-3">
                                                      <form method="POST"><button type="submit" name="out" class="btn btn-outline-danger">Sign Out</button></form>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </li>
                          </ul>
                      </div>
                  </div>
              </nav>
          </div>
      </div>
      <!-- billing-modal -->
        <?php   

        if (isset($_REQUEST['billing'])) {
          $cname = $_REQUEST['cname'];
          $cphone = $_REQUEST['cphone'];
          $cemail = $_REQUEST['cemail'];
          $cadd = $_REQUEST['cadd'];
          $ret = $_REQUEST['ret'];
          $count = 0;

          $capname = strtoupper($cname);

          $url = "page-billing.php";

          include "../connection.php";
          $csql = "SELECT * FROM customers";
          $cexe = mysqli_query($conn,$csql);
          if (mysqli_num_rows($cexe) > 0) {
            while ($cdata = mysqli_fetch_array($cexe)) {
              if (strtoupper($cdata[1]) == $capname && $cdata[2] == $cphone) {
                $count = 1;
                $dd = date("Y-m-d");
                $cc = "SELECT * FROM billsale WHERE bsdate = '$dd' AND custid = '$cdata[0]' ORDER BY cartno DESC";
                $ee = mysqli_query($conn,$cc);
                $cct=0;
                if (mysqli_num_rows($ee) == 0) {
                  $cartno = 1;
                }
                else {
                  if (mysqli_num_rows($ee) > 0) {
                    while ($cno = mysqli_fetch_array($ee)) {
                      if ($cno[11] == 0) {
                        $cartno = intval($cno[1]);
                        $cct=1;
                        break;
                      }
                      else {
                        $cartno = intval($cno[1]) + 1;
                        break;
                      }
                    }                  }
                }
                $_SESSION['cdate'] = $dd;
                $_SESSION['cartno'] = $cartno;
                $_SESSION['custid'] = $cdata[0];
                echo '<script type="text/javascript">';
                echo 'window.location.href="'.$url.'";';
                echo '</script>';
              }
            }
            if ($count == 0) {
              $casql = "INSERT INTO customers(name, phone, email, address, orders,retailer) VALUES('$cname', '$cphone', '$cemail', '$cadd', '$count', '$ret')";
              $cains = mysqli_query($conn,$casql);
              if ($cains) {
                $last_id = mysqli_insert_id($conn);
                $dd = date("Y-m-d");
                $cc = "SELECT * FROM billsale WHERE bsdate = '$dd' AND custid = '$last_id' LIMIT 0";
                $ee = mysqli_query($conn,$cc);
                $cartno = 1;
                $dd = date("Y-m-d");
                $_SESSION['cdate'] = $dd;
                $_SESSION['cartno'] = $cartno;
                $_SESSION['custid'] = $last_id;
                echo '<script type="text/javascript">';
                echo 'window.location.href="'.$url.'";';
                echo '</script>';
              }
            }
          }
          if (mysqli_num_rows($cexe) == 0) {
            $casql = "INSERT INTO customers(name, phone, email, address, orders,retailer) VALUES('$cname', '$cphone', '$cemail', '$cadd', '$count', '$ret')";
              $cains = mysqli_query($conn,$casql);
              if ($cains) {
                $last_id = mysqli_insert_id($conn);
                $dd = date("Y-m-d");
                $cc = "SELECT * FROM billsale WHERE bsdate = '$dd' AND custid = '$last_id' LIMIT 0";
                $ee = mysqli_query($conn,$cc);
                $cartno = 1;
                $dd = date("Y-m-d");
                $_SESSION['cdate'] = $dd;
                $_SESSION['cartno'] = $cartno;
                $_SESSION['custid'] = $last_id;
                echo '<script type="text/javascript">';
                echo 'window.location.href="'.$url.'";';
                echo '</script>';
              }
          }
        }
         ?>
                     <div class="modal show fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                           <div class="modal-content">
                              <div class="modal-header">
                                 <h5 class="modal-title">Enter Customer Details</h5>
                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                                 </button>
                              </div>
                              <div class="modal-body">
                                <form method="POST"> 
                                    <div class="row">
                                      <div class="col-md-12">
                                          <div class="form-group">
                                            <label for="cname">Retailer *</label>
                                            <select class="form-control" name="ret" data-style="py-0" required>
                                                <option value="">SELECT</option>
                                                <option value="YES">YES</option>
                                                <option value="NO">NO</option>
                                            </select>
                                          </div>
                                      </div>
                                      <div class="col-md-12">
                                          <div class="form-group">
                                            <label for="cname">Customer Name *</label>
                                            <input type="text" class="form-control" name="cname" id="cname"  required />
                                          </div>
                                      </div>
                                      <div class="col-md-12">
                                          <div class="form-group">
                                            <label for="cphone">Phone No</label>
                                            <input type="tel" class="form-control" name="cphone" id="cphone" />
                                          </div>
                                      </div>
                                      <div class="col-md-12">
                                          <div class="form-group">
                                            <label for="cemail">Email</label>
                                            <input type="email" class="form-control" name="cemail" id="cemail" />
                                          </div>
                                      </div>
                                      <div class="col-md-12">
                                          <div class="form-group">
                                            <label for="cadd">Address</label>
                                            <input type="tel" class="form-control" name="cadd" id="cadd" />
                                          </div>
                                      </div>
                                    </div>
                              </div>
                              <div class="modal-footer">
                                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                 <button type="submit" name="billing" class="btn btn-primary">Next</button>
                              </div>

                                 </form>
                              </div>
                           </div>
                        </div>
                     </div>


                     <?php 

                        if (isset($_REQUEST['backup'])) {
                            // Database configuration
                            $host = "localhost";
                            $username = "root";
                            $password = "";
                            $database_name = "shop";

                            // Get connection object and set the charset
                            $conn = mysqli_connect($host, $username, $password, $database_name);
                            $conn->set_charset("utf8");


                            // Get All Table Names From the Database
                            $tables = array();
                            $sql = "SHOW TABLES";
                            $result = mysqli_query($conn, $sql);

                            while ($row = mysqli_fetch_row($result)) {
                                $tables[] = $row[0];
                            }

                            $sqlScript = "";
                            foreach ($tables as $table) {
                                
                                // Prepare SQLscript for creating table structure
                                $query = "SHOW CREATE TABLE $table";
                                $result = mysqli_query($conn, $query);
                                $row = mysqli_fetch_row($result);
                                
                                $sqlScript .= "\n\n" . $row[1] . ";\n\n";
                                
                                
                                $query = "SELECT * FROM $table";
                                $result = mysqli_query($conn, $query);
                                
                                $columnCount = mysqli_num_fields($result);
                                
                                // Prepare SQLscript for dumping data for each table
                                for ($i = 0; $i < $columnCount; $i ++) {
                                    while ($row = mysqli_fetch_row($result)) {
                                        $sqlScript .= "INSERT INTO $table VALUES(";
                                        for ($j = 0; $j < $columnCount; $j ++) {
                                            $row[$j] = $row[$j];
                                            
                                            if (isset($row[$j])) {
                                                $sqlScript .= '"' . $row[$j] . '"';
                                            } else {
                                                $sqlScript .= '""';
                                            }
                                            if ($j < ($columnCount - 1)) {
                                                $sqlScript .= ',';
                                            }
                                        }
                                        $sqlScript .= ");\n";
                                    }
                                }
                                
                                $sqlScript .= "\n"; 
                            }
                            if(!empty($sqlScript))
                            {
                                // Save the SQL script to a backup file
                                $backup_file_name = 'C:\xampp\htdocs\inv\backup\inv'.$database_name . '_backup_' . date('Y-m-d') . time() . '.sql';
                                $fileHandler = fopen($backup_file_name, 'w+');
                                $number_of_lines = fwrite($fileHandler, $sqlScript);
                                fclose($fileHandler);
                            }
                            echo '<script>alert("DATA BACKUP SUCCESSFUL!");</script>';
                        }
                         ?>

                     <div class="modal show fade bd-example-modal-sm" id="bkup" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                           <div class="modal-content">
                              <div class="modal-header">
                                 <h5 class="modal-title">CREATE DATA BACKUP</h5>
                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                                 </button>
                              </div>
                              <div class="modal-body">
                                <form method="POST">
                                  <div class="col-md-12">
                                    <div class="form-group">
                                      <center>
                                        <button type="submit" name="backup" class="btn btn-primary">CREATE BACKUP</button>
                                      </center>
                                    </div>
                                  </div>
                              </div>
                              <div class="modal-footer">
                                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              </div>
                                </form>
                              </div>
                           </div>
                        </div>
                     </div>