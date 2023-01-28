<?php include("include/header.php") ;
$customer="null";
if(isset($_POST["submit"]) && isset($_POST["type"])){
$qry="";
$query=$_POST["query"];
$type=$_POST["type"];

if($type == "1"){
/* ID */
$qry=" WHERE customer.id=$query";
}
elseif($type == "2"){
   /* CNIC */ 
   $qry=" WHERE customer.cnic=$query";
}
elseif($type == "3"){
    /* Mobile */
    $qry=" WHERE customer.mobile=$query";
}
elseif($type == "4"){
   /* Name */ 
   $qry=" WHERE customer.name LIKE '%".$query."%'";
}
$qry = "SELECT customer.*,company_info.name as cname FROM `customer` INNER JOIN company_info on company_id = company_info.id ".$qry;
$customer=DBHelper::get($qry);
}
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
        <div class="col-sm-12 titleBackground rounded pt-1 pb-1 text-center" >
            <h1>Search customer in all companies</h1>
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
        <h4>Search Customer</h4>
        <div class="row mt-2">
            <div class="col">
            <input required name="query" type="text" class="form-control" placeholder="Search here..." value="<?php if(isset($_POST["submit"]) && isset($_POST["type"])) echo $_POST['query'];?>">
            </div>
                <div class="form-group col">
                <select name="type" class="form-control" id="exampleFormControlSelect1">
                <option value="1">ID</option>
                <option value="2">CNIC</option>
                <option value="3">Mobile</option>
                <option selected value="4">Name</option>
                </select>
            </div>
            <div class="col">
            <button name="submit" type="submit" class="btn btn-info">Search</button>
            </div>
           
        </div>
        </form>

        <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>F-Name</th>
                    <th>CNIC</th>
                    <th>Mobile</th>
                    <th>Company</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                 
                <?php
                if($customer != "null"){
                    if(@$customer->num_rows > 0){
                        while($row=$customer->fetch_assoc()){
                        ?>
                     <tr>
                        <td><?php echo $row["id"];?></td>
                        <td><?php echo $row["name"];?></td>
                        <td><?php echo $row["fname"];?></td>
                        <td><?php echo $row["cnic"];?></td>
                        <td><?php echo $row["mobile"];?></td>
                        <td><span class="text-bold">
                            <?php echo $row["cname"];?></span>
                        </td>
                        <td>
                            <a href="Customer_Profile.php?ID=<?php echo $row["id"]."&type=search";?>" class="btn btn-success btn-sm">
                                <i class="nav-icon fas fa-eye"></i>
                            </a>
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
