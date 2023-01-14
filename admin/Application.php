<?php include("include/header.php") ;
$customer="null";
$title = "";
$qry_status = "";

if(isset($_POST["sarchuser"])){
  $ID = $_POST["query"];
  $qry_status = "application.id = ".$ID;
  $title = "Search Applications";
}
else{
  if(isset($_GET["type"])){
    $type = $_GET["type"];
    switch($type){
        case 'pending':
           $qry_status = "application.status = 0";
           $title = "Pending Applications";
           break;
       case 'accepted':
           $qry_status = "application.status = 1";
           $title = "Accepted Applications";
          break;
       case 'delivered':
           $qry_status = "application.status = 2";
           $title = "Delivered Applications";
          break;
       case 'active':
           $qry_status = "application.status = 3";
           $title = "Active Applications";
           break;
       case 'completed':
           $qry_status = "application.status = 4";
           $title = "Completed Applications";
           break;
        case 'reject':
            $qry_status = "application.status = 5";
            $title = "Rejected Applications";
            break;
    }
   }
   else{
     $qry_status = "application.status in (1,2,3,4,0,5)";
     $title = "Applications";
   }
}

$customer=DBHelper::get("SELECT customer.id AS 'cusID',customer.name,customer.mobile,companies.name 
as 'comp',item_type.name as 'item',application.* from application INNER JOIN 
customer on customer.id = cusID left JOIN companies on companies.id = companyID 
left JOIN item_type on item_type.id = item_type_id where {$qry_status};");

?>

<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <!-- Navbar -->
  <?php include("include/nav.php");?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php include("include/slide.php");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
        <div class="col-sm-8 bg-info pt-1 pb-1 text-center" style="border-top-right-radius: 500px; border-bottom-right-radius: 500px;">
            <h1><?php echo $title;?></h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-body">

        <form method="post">
        <h5>Search application</h5>
        <div class="row mt-2">
            <div class="col">
            <input required name="query" type="text" class="form-control" placeholder="Application Id only...">
            </div>
                
            <div class="col">
            <button name="sarchuser" type="submit" class="btn btn-info">Search</button>
            </div>
           
        </div>
        </form>

        <table id="example2" class="table table-bordered table-hover mt-3">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Item name</th>
                    <th>Model No</th>
                    <th>Type</th>
                    <th>Company</th>
                    <th>Total Price</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                 
                <?php
                if($customer != "null"){
                    if($customer->num_rows > 0){
                        while($row=$customer->fetch_assoc()){
                        ?>
                     <tr>
                        <td><?php echo $row["id"];?></td>
                        <td class="urdu"><?php echo $row["name"];?></td>
                        <td><?php echo $row["mobile"];?></td>
                        <td><?php echo $row["product_name"];?></td>
                        <td><?php echo $row["model_no"];?></td>
                        <td><?php echo $row["item"];?></td>
                        <td><?php echo ucfirst($row["comp"]);?></td>
                        <td><?php echo $row["total_price"];?></td>
                        <td><?php echo date("d-m-Y",strtotime($row["date"]));?></td>
                        <td style="text-align: center;">
                        <?php
                        switch($row["status"]){
                            case 0:
                                ?>
                                  <span class="bg-info p-1 rounded">Pending</span>
                                <?php
                                break;
                            case 1:
                                ?>
                                 <span class="bg-primary p-1 rounded">Accepted</span>
                                <?php
                                break;
                            case 2:
                                ?>
                                 <span class="bg-danger p-1 rounded">Delivered</span>
                                <?php
                                break;
                            case 3:
                                ?>
                                 <span class="bg-success p-1 rounded">Active</span>
                                <?php
                                break;
                            case 4:
                                ?>
                                  <span class="bg-warning p-1 rounded">Complete</span>
                                <?php
                                break;
                            case 5:
                                  ?>
                                    <span class="bg-danger p-1 rounded">Rejected</span>
                                  <?php
                                  break;
                        }
                        ?>
                        </td>
                        <td>
                           
                            <a href="View_Application?ID=<?php echo $row["id"];?>" title="View application details" class="btn btn-info btn-sm">
                            <i class="far fa-file-word nav-icon"></i>
                            </a>
                           
                            <a href="Customer_Profile.php?ID=<?php echo $row["cusID"];?>" title="View customer profile" class="btn btn-success btn-sm mt-1">
                            <i class="nav-icon fas fa-user"></i> 
                            </a>

                            <?php
                            if($row["status"] != 3 && $row["status"] != 4 && $row["status"] != 5){
                              ?>
                            <a href="editApplication?ID=<?php echo $row["id"];?>" title="Edit the application" class="btn btn-warning btn-sm mt-1">
                            <i class="nav-icon fas fa-edit"></i>
                            </a>
                              <?php
                            }
                            ?>
                        
                        </td>
                    </tr>
                        <?php
                        }
                    }
                }
                ?>
                 
                  </tbody>
                
                </table>
          
        </div>
        <!-- /.card-body -->
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<?php include("include/footer.php");?>

<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
<script src="dist/js/adminlte.min.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

</body>
</html>
