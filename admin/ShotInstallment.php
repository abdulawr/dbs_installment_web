<?php include("include/header.php") ;?>

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
        <div class="col-sm-12 rounded titleBackground pt-1 pb-1 text-center" >
            <h1>Pending Installments</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-body">

        <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>Customer ID</th>
                    <th>Application ID</th>
                    <th>Investor ID</th>
                    <th>Shot Installment</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>

                  <?php

                      function get_months_between_dates(string $start_date, string $end_date): ?int
                      {
                          $startDate = $start_date instanceof Datetime ? $start_date : new DateTime($start_date);
                          $endDate = $end_date instanceof Datetime ? $end_date : new DateTime($end_date);
                          $interval = $startDate->diff($endDate);
                          $months = ($interval->y * 12) + $interval->m;
                          
                        return $startDate > $endDate ? -$months : $months;
                          
                      }


                  $active_app = DBHelper::get("select * from application where status = 3 and company_id = '{$_SESSION["company_id"]}'");
                  while($row = $active_app->fetch_assoc()){
                   
                    $activeDate = $row["active_date"];
                    $currentDate = date("Y-m-d");
                    if (!empty($activeDate) && $activeDate != "null") {
                        $cnt =  get_months_between_dates($activeDate, $currentDate)."<br>";
                        $counts = DBHelper::get("SELECT COUNT(id) as cc FROM `application_installment` WHERE `appID` = {$row["id"]} and type = 'I' limit 1")->fetch_assoc()["cc"];
                  
                        if ($counts < $cnt) {
                            ?>
                    <tr>
                    <td><?php echo $row["cusID"]; ?></td>
                    <td><?php echo $row["id"]; ?></td>
                    <td><?php echo $row["investorID"]; ?></td>
                    <td><?php echo abs((int) $counts - (int) $cnt); ?></td>
                    <td>

                    <a href="View_Application?ID=<?php echo $row["id"]; ?>" title="View application details" class="btn btn-info btn-sm">
                    <i class="far fa-file-word nav-icon"></i>
                    </a>
                           
                   <a href="Customer_Profile.php?ID=<?php echo $row["cusID"]; ?>" title="View customer profile" class="btn btn-success btn-sm ">
                   <i class="nav-icon fas fa-user"></i> 
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
