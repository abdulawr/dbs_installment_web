<?php include("include/header.php") ;?>

<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <!-- Navbar -->
  <?php include("include/nav.php");?>
  <!-- /.navbar -->
<style>
    .bbbbsss:hover{
        cursor: pointer;
    }
</style>
  <?php
    $date = date('Y-m-d');
    $q = "SELECT admin.name,admin_transaction.* FROM `admin_transaction` INNER JOIN admin on adminID = admin.id where admin_transaction.status in(2,0) and admin_transaction.date = '$date' ";

    if(isset($_POST["submit"])){
       $date = $_POST["searchDate"];
       if(isset($_POST["allCompany"]) && $_POST["allCompany"] == "1"){
       }
       else{
          $q .= " and admin_transaction.company_id = ".$_SESSION["company_id"];
       }
    }else{
        $q .= " and admin_transaction.company_id = ".$_SESSION["company_id"];
    }
    $payments = DBHelper::get($q);
  ?>

  <!-- Main Sidebar Container -->
  <?php include("include/slide.php");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
        <div class="col-sm-8 bg-info pt-1 pb-1 text-center" style="border-top-right-radius: 500px; border-bottom-right-radius: 500px;">
            <h1>Received Cash Report</h1>
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
            <div class="row">
                <div class="col-3">
                   <input required name="searchDate" type="date" class="form-control" placeholder="Select date">
                </div>
                <div class="col-2" style="display: flex;align-items: center;">
                  <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input bbbbsss" value="1" name="allCompany" id="customCheck1">
                    <label class="custom-control-label" for="customCheck1">All company</label>
                  </div>
                </div>
                <div class="col-2">
                   <button name="submit" type="submit" class="btn btn-outline-info">Search</button>
                </div>
            </div>
        </form>

        <table id="example2" class="table table-bordered table-hover my-3">
            <thead>
                <tr>
                <th>Seq no</th>
                <th>Date</th>
                <th>Amount</th>
                <th>Admin ID</th>
                <th>Admin name</th>
                <th>App ID</th>
                <th>Status</th>
                </tr>
            </thead>

            <tbody>
                <?php 
                 $total = 0;
                 if($payments->num_rows > 0){
                    $i = 1;
                    while($row = $payments->fetch_assoc()){
                        $total += $row["amount"];
                        ?>
                         <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo date("d-m-Y",strtotime($row["date"]));?></td>
                            <td><?php echo $row["amount"];?></td>
                            <td><?php echo $row["adminID"];?></td>
                            <td><?php echo $row["name"];?></td>
                            <td><?php echo $row["appID"]; ?></td>
                            <td>
                                <?php if($row["status"] == 2) { ?>
                                 <span class="bg-success px-2 rounded" style="font-size:14px; padding-bottom:2px;">Received installment</span>
                                <?php } else { ?>
                                    <span class="bg-warning px-2 rounded" style="font-size:14px; padding-bottom:2px;">Add into investor account</span>
                                <?php } ?>
                            </td>
                          </tr>
                        <?php
                        $i++;
                    }
                 }
                ?>
            </tbody>

          </table>

          <h4 class="bg-warning rounded px-3 text-right text-bold">Amount: <?php echo $total; ?></h4>
        
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

</body>
</html>


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