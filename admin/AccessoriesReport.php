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
        <div class="col-sm-12 rounded pt-1 pb-1 text-center titleBackground" >
            <h1>Accessories Report</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-body">

    <form class="container mt-2" method="post">
        <div class="row">

            <div class="form-group col">
            <select name="day" class="form-control" id="exampleFormControlSelect1">
            <option value="0">Choose Day</option>
            <?php 
            for($i=1; $i<=31; $i++){
              echo '<option value="'.$i.'">'.$i.'</option>';
            }
            ?>
            </select>
            </div>

            <div class="form-group col">
            <select name="month" class="form-control" id="exampleFormControlSelect1">
            <option value="0">Choose Month</option>
            <?php 
            for($i=1; $i<=12; $i++){
              echo '<option value="'.$i.'">'.$i.'</option>';
            }
            ?>
            </select>
            </div>

            <div class="form-group col">
            <select name="year" class="form-control" id="exampleFormControlSelect1">
            <option value="0">Choose Year</option>
            <?php 
            $year = date("Y")+1;
            for($i=1; $i<=10; $i++){
              echo '<option value="'.($year-$i).'">'.($year-$i).'</option>';
            }
            ?>
            </select>
            </div>

            <div class="col">
                <button type="submit" class="btn btn-outline-success" >Search Report</button>
            </div>

        </div>

    </form>

          
  

            <?php
           
            if(isset($_POST["day"]) && isset($_POST["month"])){
             $day = ($_POST["day"] != '0') ? " and Day(accessories_transaction.date) = '{$_POST["day"]}'" : "";
             $month = ($_POST["month"] != '0') ? " and Month(accessories_transaction.date) = '{$_POST["month"]}'" : "";
             $year = ($_POST["year"] != '0') ? " and Year(accessories_transaction.date) = '{$_POST["year"]}'" : "";
             $search = $day.$month.$year;

             $record = DBHelper::get("SELECT accessories_transaction.*,name FROM accessories INNER JOIN accessories_transaction on accessories.id = accessID where accessories_transaction.quantity != '0' {$search} and accessories_transaction.company_id = '{$_SESSION["company_id"]}'");
            }
            else{
                $currentday = date("d");
                $record = DBHelper::get("SELECT accessories_transaction.*,name FROM accessories INNER JOIN accessories_transaction on accessories.id = accessID where Day(accessories_transaction.date) = '{$currentday}' and accessories_transaction.company_id = '{$_SESSION["company_id"]}'");
            }
            ?>

             <table id="example2" class="table table-bordered table-hover mt-3">
                  <thead>
                  <tr>
                    <th>Accessory ID</th>
                    <th>Name</th>
                    <th>Date</th>
                    <th>Buy Price</th>
                    <th>Sell Price</th>
                    <th>Quantity</th>
                  </tr>
                  </thead>
                  <tbody>

                  <?php 
                  $profit =0;
                  $loss = 0;
                  if($record->num_rows > 0){
                      while($row = $record->fetch_assoc()){
                      if($row["sell_price"] >= $row["buy_price"]){
                          $profit += ($row["sell_price"] - $row["buy_price"]);
                          $color = "";
                      }
                      else{
                          $loss += ($row["buy_price"] - $row["sell_price"]);
                          $color = "bg-warning";
                      }
                  ?>
                    <tr class="<?php echo $color;?>">
                      <td><?php echo $row["accessID"];?></td>
                      <td><?php echo $row["name"];?></td>
                      <td><?php echo date_format(date_create($row["date"]),"d-m-Y");?></td>
                      <td><?php echo $row["buy_price"];?></td>
                      <td><?php echo $row["sell_price"];?></td>
                      <td><?php echo $row["quantity"];?></td>
                    </tr>
                <?php  
                    }
                }
                ?>

                  </tbody>
    </table>

         
         <div style="text-align:right">
         <h5>Profit: <b style="margin-left: 10px;"><?php echo $profit;?></b> <span style="margin-left: 30px;">Loss: </span>
         <b style="margin-left: 10px;"><?php echo $loss;?></b></h5>
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
