<?php include("include/header.php") ;
$customer="null";
if(isset($_POST["submit"]) && isset($_POST["type"])){
$qry="";
$query=$_POST["query"];
$type=$_POST["type"];

if($type == "1"){
/* ID */
$qry="SELECT * FROM `investor` WHERE id=$query";
}
elseif($type == "2"){
   /* CNIC */ 
   $qry="SELECT * FROM `investor` WHERE cnic=$query";
}
elseif($type == "3"){
    /* Mobile */
    $qry="SELECT * FROM `investor` WHERE mobile=$query";
}
elseif($type == "4"){
   /* Name */ 
   $qry="SELECT * FROM `investor` WHERE name LIKE '%".$query."%'";
}
else{
    $qry="SELECT * FROM `investor`";
}

$customer=DBHelper::get($qry);
}

else{
$customer=DBHelper::get("SELECT * FROM `investor`");
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
        <div class="col-sm-8 bg-info pt-1 pb-1 text-center" style="border-top-right-radius: 500px; border-bottom-right-radius: 500px;">
            <h1>Investor List</h1>
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
            <input required name="query" type="text" class="form-control" placeholder="Search here...">
            </div>
                <div class="form-group col">
                <select name="type" class="form-control" id="exampleFormControlSelect1">
                <option value="1">ID</option>
                <option value="2">CNIC</option>
                <option value="3">Mobile</option>
                <option value="4">Name</option>
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
                    <th>CNIC</th>
                    <th>Mobile</th>
                    <th>Address</th>
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
                        <td class=""><?php echo $row["name"];?></td>
                        <td><?php echo $row["cnic"];?></td>
                        <td><?php echo $row["mobile"];?></td>
                        <td class=""><?php echo $row["address"];?></td>
                        <td>
                            <a href="Investor_Profile.php?ID=<?php echo $row["id"];?>" class="btn btn-info btn-sm">View Details</a>
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
