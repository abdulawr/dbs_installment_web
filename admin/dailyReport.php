<?php include("include/header.php") ;?>

<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <!-- Navbar -->
  <?php include("include/nav.php");?>
  <!-- /.navbar -->
<style>
      .ths {
  padding: 8px 10px;
  font-weight: bold;
  font-size: 16px;
  border: 1px #707070 solid;
}
.ptag{
  margin-bottom: 0px;
  padding-bottom: 0px;
}
.sign{
  display: none;
  visibility: hidden;
}

h3{
  text-align: left !important;
  padding-left: 20px !important;
}

.styled-table tbody tr {
    border-bottom: 1px solid #dddddd;
}

.styled-table tbody tr:nth-of-type(even) {
    background-color: #f3f3f3;
}

.styled-table tbody tr:last-of-type {
    border-bottom: 2px solid #009879;
}

.styled-table th,
.styled-table td {
    padding: 9px 15px;
}

    #printTable{
      display: none;
      visibility: hidden;
      width:100%;
    }

    .bbbbsss:hover{
        cursor: pointer;
    }
    @media print{
      .cp-txt{
        color:black !important;
      }
      .searchform{
        display:none;
        visibility: hidden;
      }
      @page { margin: 0; } 
      body { margin: 1cm; }
      .dataTables_paginate {
        display:none;
        visibility: hidden;
      }
      .dataTables_info {
        display:none;
        visibility: hidden;
      }
      .sign{
        display: block;
        visibility: visible;
      }
      #printTable{
        display: table;
        visibility: visible;
        width:100% !important;
        margin-bottom:30px;
      }
      #example2{
        display: none;
        visibility: hidden;
      }
      .pr_amount{
        color:black !important;
        font-size:20px !important;
      }
    }
</style>
  <?php
    $date = date('Y-m-d');
    $q = "SELECT company_info.name as cmpn,admin.name,admin_transaction.* FROM `admin_transaction` INNER JOIN admin on adminID = admin.id INNER JOIN company_info on admin_transaction.company_id = company_info.id where admin_transaction.status in(2,0,1) ";

    if(isset($_POST["submit"])){
       $date = $_POST["searchDate"];
       if(isset($_POST["allCompany"]) && $_POST["allCompany"] == "1"){
       }
       else{
          $q .= " and admin_transaction.company_id = ".$_SESSION["company_id"];
       }

       $date = $_POST["searchDate"];

    }else{
        $q .= " and admin_transaction.company_id = ".$_SESSION["company_id"];
    }

    $q .= " and admin_transaction.date = '$date' ";
    $payments = DBHelper::get($q);

    $records = [];
    while($row = $payments->fetch_assoc()){
      array_push($records,$row);
    }
  ?>

<?php

    $comp = $_SESSION["company"];

    $barcodeText = DBHelper::intCodeRandom(15);
    $barcodeType= 'codabar';
    $barcodeDisplay= 'horizontal';
    $barcodeSize= '20';
    $printText= 'true';
    if($barcodeText != '') {
     //   echo '<img class="barcode" style="float:right" alt="'.$barcodeText.'" src="include/barcode.php?text='.$barcodeText.'&codetype='.$barcodeType.'&orientation='.$barcodeDisplay.'&size='.$barcodeSize.'&print='.$printText.'"/>';
    }
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

        <form method="post" class="searchform">
            <div class="row">
                <div class="col-md-3 col-sm-12">
                   <input required name="searchDate" type="date" class="form-control" placeholder="Select date">
                </div>
                <div class="col-md-3 col-sm-12" style="display: flex;align-items: center;">
                  <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input bbbbsss" value="1" name="allCompany" id="customCheck1">
                    <label class="custom-control-label" for="customCheck1">All company</label>
                  </div>
                </div>
                <div class="col-md-3 col-sm-12">
                   <button name="submit" type="submit" class="btn btn-outline-info">Search</button>
                   <button type="button" onclick="printRecord()" class="btn btn-outline-success ml-3">Print</button>
                </div>
            </div>
        </form>

        <div class="sign container">
          <div class="row">
            <div class="col"> <img  class="rounded img-thumbnail" width="80" height="80" src="c_images/<?php echo $_SESSION['company']['logo'];?>" alt="">
             <h1 style="display:inline-block; margin-left:20px; color:brown; font-size:30px"><?php echo $_SESSION["company"]['name'];?></h1>

            </div>

             <div class="col">
               <div class="row">
                 <div class="col">
                 <p class="ptag">
                <i class="fas fa-phone nav-icon"></i>
                <?php echo $comp["mobile"];?>
                </p>
                <p class="ptag">
                <i class="fas fa-envelope nav-icon"></i>
                <?php echo $comp["email"];?>
                </p>
                 </div>
                 <div class="col">
                 <p class="ptag">
                <i class="fas fa-laptop nav-icon"></i>
                <?php echo $comp["facebook"];?>
                </p>
                <p class="ptag">
                <i class="fas fa-sms nav-icon"></i>
                <?php echo $comp["whatsapp"];?>
                </p>
                 </div>
               </div>
               <p class="ptag " style="color:brown;"><?php echo $comp["address"];?></p>
             </div>
         
            </div>
            <hr>
        </div>

        <div class="print_container">
        <table class="styled-table" id="printTable" style="width:100%">
          <thead>
          <tr>
                <th>Seq no</th>
                <th>Date</th>
                <th>Company</th>
                <th>Amount</th>
                <th>Admin ID</th>
                <th>Admin name</th>
                <th>App ID</th>
                <th>Status</th>
                </tr>
          </thead>
          <tbody>
                <?php 
                 $rec = $payments;
                 if(count($records) > 0){
                    $i = 1;
                    foreach($records as $row){
                        ?>
                         <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo date("d-m-Y",strtotime($row["date"]));?></td>
                            <td><?php echo $row["cmpn"];?></td>
                            <td><?php echo $row["amount"];?></td>
                            <td><?php echo $row["adminID"];?></td>
                            <td><?php echo $row["name"];?></td>
                            <td><?php echo $row["appID"]; ?></td>
                            <td>
                                <?php if($row["status"] == 2) { ?>
                                 <span class="bg-success px-2 rounded cp-txt" style="font-size:14px; padding-bottom:2px;">Received installment</span>
                                <?php } elseif($row["status"] == 0) { ?>
                                    <span class="bg-warning px-2 rounded cp-txt" style="font-size:14px; padding-bottom:2px;">Add into investor account</span>
                                <?php } elseif($row["status"] == 1) { ?>
                                    <span class="bg-danger px-2 rounded cp-txt" style="font-size:14px; padding-bottom:2px;">Sub from investor account</span>
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
                </div>



        <div class="print_container">
        <table id="example2" class="table table-bordered table-hover my-3">
            <thead>
                <tr>
                <th>Seq no</th>
                <th>Date</th>
                <th>Company</th>
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
                 $cash = 0;
                 $spends = 0;
                 if(count($records) > 0){
                    $i = 1;
                    foreach($records as $row){
                        if($row["status"] == "1"){
                          $spends += $row["amount"];
                        }else{
                           $total += $row["amount"];
                        }
                         
                        ?>
                         <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo date("d-m-Y",strtotime($row["date"]));?></td>
                            <td><?php echo $row["cmpn"];?></td>
                            <td><?php echo $row["amount"];?></td>
                            <td><?php echo $row["adminID"];?></td>
                            <td><?php echo $row["name"];?></td>
                            <td><?php echo $row["appID"]; ?></td>
                            <td>
                                <?php if($row["status"] == 2) { ?>
                                 <span class="bg-success px-2 rounded cp-txt" style="font-size:14px; padding-bottom:2px;">Received installment</span>
                                <?php } elseif($row["status"] == 0) { ?>
                                    <span class="bg-warning px-2 rounded cp-txt" style="font-size:14px; padding-bottom:2px;">Add into investor account</span>
                                <?php } elseif($row["status"] == 1) { ?>
                                    <span class="bg-danger px-2 rounded cp-txt" style="font-size:14px; padding-bottom:2px;">Sub from investor account</span>
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

<?php
  $cash = $total - $spends;
?>
          <h4 class="pr_amount bg-warning rounded px-3 text-right text-bold">Total amount: <?php echo $total; ?></h4>
          <h4 class="pr_amount bg-danger rounded px-3 text-right text-bold">Spends: <?php echo $spends; ?></h4>
          <h4 class="pr_amount bg-success rounded px-3 text-right text-bold">Cash: <?php echo $cash; ?></h4>
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


<script>
  function printRecord(){
    window.print();
  }
</script>