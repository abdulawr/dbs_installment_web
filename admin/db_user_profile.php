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

  <?php
    $id = validateInput($_GET["ID"]);
    $balance = 0;
     $qr = "SELECT * FROM `dg_user_account` WHERE `user_id` = '$id'";
     $user_account = DBHelper::get($qr);
     if($user_account->num_rows > 0){
        $balance =  $user_account->fetch_assoc()["balance"];
     }
    $user = DBHelper::get("select * from dg_user where id = '$id'")->fetch_assoc();
    $transactions = DBHelper::get("SELECT * FROM `dg_user_transaction` WHERE `user_id` = '$id' order by id desc");
  ?>


<!-- Modal -->
<div class="modal fade" id="paymentModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <form method="post" action="model/dg_user_transaction.php">
            <div class="form-group">
              <label for="exampleInputEmail1">Amount</label>
              <input required type="number" class="form-control" name="amount">
            </div>

            <div class="form-group">
              <label for="exampleInputPassword1">Desciption</label>
              <textarea  maxLength="300" class="form-control" name="desc" rows="3"></textarea>
            </div>

            <input type="hidden" name="type" id="paymenttype">
            <input type="hidden" name="ID" value="<?php echo $id;?>">
            <input type="hidden" name="balance" value="<?php echo $balance;?>">

            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
      </div>
    </div>
  </div>
</div>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card mt-3">
        <div class="card-body">

        <?php
          if(isset($_GET["status"])){
             if($_GET["status"] == "success"){
                 echo '<div class="alert alert-success" role="alert">Transaction performed successfully</div>';
             }
             elseif($_GET["status"] == "error"){
               echo '<div class="alert alert-danger" role="alert">Something went wrong try again</div>';
             }
          }
        ?>

        <div class="jumbotron jumbotron-fluid py-2 px-3 rounded">
            <div class="container">
                <div class="d-flex" style="gap:20px"> <p class="text-bold mb-0">Name</p> <p class="mb-0"><?php echo $user["Name"]; ?></p> </div>
                <div class="d-flex" style="gap:20px"> <p class="text-bold mb-0">Mobile</p> <p class="mb-0"><?php echo $user["phone"]; ?></p> </div>
                <div class="d-flex" style="gap:20px"> <p class="text-bold mb-0">CNIC</p> <p class="mb-0"><?php echo $user["cnic"]; ?></p> </div>
                <div class="d-flex" style="gap:20px"> <p class="text-bold mb-0">Date</p> <p class="mb-0"><?php echo date('d/m/Y',strtotime($user["date"])); ?></p> </div>
                <br>
                <?php if($balance <= 0 ) { ?>
                  <div class="d-flex" style="gap:20px"> <p class="text-bold text-danger mb-0">Balance</p> <p class="text-bold text-danger mb-0"><?php echo abs($balance); ?></p> </div>
                <?php } else {?>
                  <div class="d-flex" style="gap:20px"> <p class="text-bold text-success mb-0">Balance</p> <p class="text-bold text-success mb-0"><?php echo abs($balance); ?></p> </div>
                <?php } ?>
              
              </div>
         </div>

           
          <div class="d-flex" style="gap:30px">
             <button onclick="openPopUp(1)" class="btn btn-danger" data-toggle="modal" data-target="#paymentModal">YOU GAVE <small>Rs</small></button>
             <button  onclick="openPopUp(2)" class="btn btn-success" data-toggle="modal" data-target="#paymentModal">YOU GOT <small>Rs</small></button>
          </div>

          <table class="table my-4">
            <thead>
              <tr>
                <th scope="col">Entries</th>
                <th scope="col">You Gave</th>
                <th scope="col">You Got</th>
                <th scope="col">Description</th>
              </tr>
            </thead>
            <tbody>
                <?php
                  if($transactions->num_rows > 0){
                    while($row = $transactions->fetch_assoc()){
                 ?>
              <tr>
                <td><?php echo date('d-m-Y H:i',strtotime($row["date"])); ?> <br> <span class="rounded px-2 text-bold" style="background:#ffb6c1">Bal: <?php echo abs($row["balance"]);?></span></td>
                <td class="text-danger text-bold align-middle"><?php echo ($row["type"] == '1') ? $row["amount"] : "";?></td>
                <td class="text-success text-bold align-middle"><?php echo ($row["type"] == '2') ? $row["amount"] : "";?></td>
                <td class="align-middle" style="font-size:14px"><?php echo $row["desc"]; ?></td>
              </tr>
              <?php }} ?>

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

</body>
</html>


<script>
  function openPopUp(status) {
    let title = status == '1' ? "You Give Transaction" : "You Got Transaction";
    $("#modalTitle").text(title);
    $("#paymenttype").val(status);
  }
</script>


