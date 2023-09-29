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
$ll = "SELECT * FROM customers ORDER BY cid DESC";
$lexe = mysqli_query($conn,$ll);
if (mysqli_num_rows($lexe) == 0) {
   $ll = "SELECT * FROM customers ORDER BY cid DESC LIMIT 0";
   $lexe = mysqli_query($conn,$ll);
}

if (isset($_REQUEST['getsch'])) {
   $sch = $_REQUEST['sch'];
   include "../connection.php";
   if ($sch != "") {
      $ll = "SELECT * FROM customers WHERE name = '$sch' ";
      $lexe = mysqli_query($conn,$ll);
   }else{
      $ll = "SELECT * FROM customers";
      $lexe = mysqli_query($conn,$ll);
   }
}

if (isset($_REQUEST['upd'])) {
   $getid = $_REQUEST['getid'];
   $_SESSION['viewid'] = $getid ;
   header("location:page-edit-customers.php");
}

if (isset($_REQUEST['dele'])) {
   include "../connection.php";
   $gdid = $_REQUEST['getid'];
   $sql2 = "DELETE FROM customers WHERE cid ='$gdid' ";
   $exe2 = mysqli_query($conn,$sql2);
   if ($exe2) {
      mysqli_close($conn);
      header("location:page-list-customers.php");
   }else {
      mysqli_close($conn);
      echo '<script>alert("Customer Not Deleted!");</script>';
   }   
}

 ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>SHOP | Customer List</title>
      
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
      var i = 7; 
      for (var j = 0; j < row.length; j++) {
  
            // Deleting the ith cell of each row.
            row[j].deleteCell(i);
      }
      var divContents = document.getElementById("print_area").innerHTML;
      var a = window.open('', '', 'height=1000, width=700');
      a.document.write('<html>');
      a.document.write('<body><center><h2>Customers List</h2><br><table border="1"><thead><tr><th>ID</th><th>Name</th><th>Phone</th><th>Email</th><th>Address</th><th>Visits</th><th>Retailer</th></tr></thead>');
      a.document.write(divContents);
      a.document.write('</table></center></body></html>');
      a.document.close();
      a.print();
      window.location.replace('page-list-customers.php');
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
      <div class="col-sm-12">
         <div class="card">
            <div class="card-header d-flex justify-content-between">
               <div class="header-title">
                  <h4 class="card-title">Customer List</h4>
                  <a style="position: absolute;right: 2%;top:3%;" class="btn btn-primary" href="page-add-customers.php">Add Customer</a>
               </div>
            </div>
            <div class="card-body">
               <div class="table-responsive">
                  <div class="row justify-content-between">
                     <div class="col-sm-6 col-md-6">
                        <div id="user_list_datatable_info" class="dataTables_filter">
                           <form class="mr-3 position-relative" method="POST">
                              <div class="form-group mb-0">
                                 <ul class="list-inline">
                                    <li class="list-inline-item" style="width:50%;"><input type="search" name="sch" class="form-control" id="exampleInputSearch" placeholder="Enter Name To Search!"
                                    aria-controls="user-list-table">
                                    </li>
                                    <li class="list-inline-item"><button class="btn btn-primary" type="submit" name="getsch"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M18.031 16.617l4.283 4.282-1.415 1.415-4.282-4.283A8.96 8.96 0 0 1 11 20c-4.968 0-9-4.032-9-9s4.032-9 9-9 9 4.032 9 9a8.96 8.96 0 0 1-1.969 5.617zm-2.006-.742A6.977 6.977 0 0 0 18 11c0-3.868-3.133-7-7-7-3.868 0-7 3.132-7 7 0 3.867 3.132 7 7 7a6.977 6.977 0 0 0 4.875-1.975l.15-.15z"/></svg></button></li>
                                 </ul>
                              </div>
                           </form>
                        </div>
                     </div>
                     <div class="col-sm-6 col-md-6">
                        <div class="user-list-files d-flex">
                           <a class="bg-primary" href="#" onclick="print_content()">
                              PDF/Print
                           </a>
                           <a class="bg-primary" href="#" onclick="ExportToExcel('xlsx')">
                              Excel
                           </a>
                        </div>
                     </div>
                  </div>
                  <div style="height: 500px;overflow-y: scroll;overflow-x: scroll;">
                     <table id="tbl_exporttable_to_xls" class="table table-striped dataTable mt-4 text-center" role="grid"
                        aria-describedby="user-list-page-info">
                        <thead>
                           <tr class="ligth">
                              <th>ID</th>
                              <th>Name</th>
                              <th>Phone</th>
                              <th>Email</th>
                              <th>Address</th>
                              <th>Visits</th>
                              <th>Retailer</th>
                              <th style="min-width: 120px">Action</th>
                           </tr>
                        </thead>
                        <tbody id="print_area">
                           <?php if (mysqli_num_rows($lexe) > 0) {
                              while ($listdata = mysqli_fetch_array($lexe)) {
                              ?>
                           <tr>
                              <td><?php echo $listdata[0]; ?></td>
                              <td><?php echo $listdata[1]; ?></td>
                              <td><?php echo $listdata[2]; ?></td>
                              <td><?php echo $listdata[3]; ?></td>
                              <td><?php echo $listdata[4]; ?></td>
                              <td><?php echo $listdata[5]; ?></td>
                              <td><?php echo $listdata[6]; ?></td>
                              <td>
                                 <div class="flex align-items-center list-user-action">
                                    <form method="POST">
                                       <input type="text" name="getid" value="<?php echo $listdata[0]; ?>" style="display:none;">
                                       <button class="btn btn-sm bg-primary list-inline-item" data-toggle="tooltip" data-placement="top" title=""
                                       data-original-title="Edit" name="upd"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15" height="10"><path fill="none" d="M0 0h24v24H0z"/><path d="M15.728 9.686l-1.414-1.414L5 17.586V19h1.414l9.314-9.314zm1.414-1.414l1.414-1.414-1.414-1.414-1.414 1.414 1.414 1.414zM7.242 21H3v-4.243L16.435 3.322a1 1 0 0 1 1.414 0l2.829 2.829a1 1 0 0 1 0 1.414L7.243 21z"/></svg></button>
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
</html