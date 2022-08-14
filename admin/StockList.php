<?php include("include/header.php") ;
$customer="null";
if(isset($_POST["submit"]) && isset($_POST["id"])){
$qry="";
$id=$_POST["id"];
$qry="SELECT dbs_shop_stock.*,name as 'comp' FROM dbs_shop_stock INNER JOIN mobile_company_dbs ON companyID = mobile_company_dbs.id where dbs_shop_stock.id = {$id} and quantity > 0";
$customer=DBHelper::get($qry);
}

else{
$customer=DBHelper::get("SELECT dbs_shop_stock.*,name as 'comp' FROM dbs_shop_stock INNER JOIN mobile_company_dbs ON companyID = mobile_company_dbs.id where quantity > 0");
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
            <h1>Customer List</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-body">

        <form method="post" class="mb-4">
        <h4>Search Stock</h4>
        <div class="row mt-2">

            <div class="col">
            <input required name="id" type="text" class="form-control" placeholder="Enter stock id mention on box.... ">
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
                    <th>Company</th>
                    <th>Ram</th>
                    <th>Memory</th>
                    <th>Sim</th>
                    <th>Network</th>
                    <th>Front camera</th>
                    <th>Back camera</th>
                    <th>Buying Price</th>
                    <th>Selling Price</th>
                    <th>Quantity</th>
                    <th>Fringerprint</th>
                
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
                        <td><?php echo ucfirst($row["comp"]);?></td>
                        <td><?php echo $row["ram"];?></td>
                        <td><?php echo $row["memory"];?></td>
                        <td><?php echo $row["sim"];?></td>
                        <td><?php echo $row["network"];?></td>
                        <td><?php echo $row["font_camera"];?></td>
                        <td><?php echo $row["back_camera"];?></td>
                        <td><?php echo $row["buy_price"];?></td>
                        <td><?php echo $row["selling_price"];?></td>
                        <td><?php echo $row["quantity"];?></td>
                        <td><?php echo ($row["fringerprint"] == 0) ? "Yes":"No";?></td>
                        
                       
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
