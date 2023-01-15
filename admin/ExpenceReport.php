<?php include("include/header.php") ;
$customer="null";
if(isset($_POST["submit"]) && isset($_POST["month"])){
$qry="";
$month=$_POST["month"];
$year=$_POST["year"];

if($month == 0 && $year == 0){
    $qry = "SELECT company_expense.*,name,mobile from company_expense INNER JOIN admin on adminID = admin.id";
}
elseif($month != 0 && $year == 0){
    $qry = "SELECT company_expense.*,name,mobile from company_expense INNER JOIN admin on adminID = admin.id WHERE Month(company_expense.date) = {$month}";
}
elseif($month == 0 && $year != 0){
    $qry = "SELECT company_expense.*,name,mobile from company_expense INNER JOIN admin on adminID = admin.id WHERE Year(company_expense.date) = {$year}";
}
elseif($month != 0 && $year != 0){
 $qry = "SELECT company_expense.*,name,mobile from company_expense INNER JOIN admin on adminID = admin.id WHERE Year(company_expense.date) = {$year} and Month(company_expense.date) = {$month}";
}
$qry .= " and company_id = '{$_SESSION["company_id"]}' ";
$customer=DBHelper::get($qry);
}

else{
$day = date("d");
$customer=DBHelper::get("SELECT company_expense.*,name,mobile from company_expense INNER JOIN admin on adminID = admin.id where day(company_expense.date) = '{$day}' and company_id = '{$_SESSION["company_id"]}' order by company_expense.id desc;");
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
        <div class="col-sm-12 rounded titleBackground pt-1 pb-1 text-center">
            <h1>Company Expences</h1>
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

          <div class="form-group col">
                <select name="month" class="form-control" id="exampleFormControlSelect1">
                <option value="0">Select month</option>
                <?php
                $i = 1;
                for($i; $i<=12; $i++){
                    ?>
                      <option value="<?php echo $i;?>"><?php echo $i;?></option>
                    <?php
                }
                ?>
                </select>
            </div>
         
            <div class="form-group col">
                <select name="year" class="form-control" id="exampleFormControlSelect1">
                <option value="0">Select year</option>
                <?php
                $i = date("Y");
                for($i; $i>=date("Y")-10; $i--){
                    ?>
                      <option value="<?php echo $i;?>"><?php echo $i;?></option>
                    <?php
                }
                ?>
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
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Comment</th>
                    <th>Type</th>
                    <th>Added by (admin)</th>
                    <th>Mobile</th>
                    <?php
                    if($_SESSION["type"] == '1'){
                      echo " <th>Action</th>";
                    }
                    ?>
                   
                  </tr>
                  </thead>
                  <tbody>
                 
                <?php
                if($customer != "null"){
                    $total = 0;
                    if($customer->num_rows > 0){
                        while($row=$customer->fetch_assoc()){
                            $total += $row["amount"];
                        ?>
                     <tr>
                        <td><?php echo $row["id"];?></td>
                        <td><?php echo $row["amount"];?></td>
                        <td><?php echo date("d-m-Y",strtotime($row["date"]));?></td>
                        <td><?php echo $row["comment"];?></td>
                        <td>
                          <?php
                          if($row["status"] == 0){
                            echo '<span class="badge badge-info">Company</span>';
                          }
                          else{
                            echo '<span class="badge badge-warning">DBS Shop</span>';
                          }
                          ?>
                        </td>
                        <td class=""><?php echo $row["name"];?></td>
                        <td><?php echo $row["mobile"];?></td>

                        <?php
                        if($_SESSION["type"] == '1'){
                          echo '<td>
                          <a href="model/deleteExpence.php?ID='.$row["id"].'" class="btn-sm btn-danger">Delete</a>
                          </td>';
                        }
                        ?>
                       
                    </tr>
                        <?php
                        }
                    }
                }
                ?>
                 
                  </tbody>
                </table>

                <div style="float: right;">
                    <h5 class="d-inline text-bold">Total Amount: </h5>
                    <h5 class="d-inline ml-3"><?php echo $total;?></h5>
                </div>
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
