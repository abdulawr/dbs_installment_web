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
  <?php include("include/image_model.php");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
        <div class="col-sm-12 rounded titleBackground pt-1 pb-1 text-center" >
            <h1>Admin List</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-body">

        <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Image</th>
                      <th>Name</th>
                      <th>Mobile</th>
                      <th>Status</th>
                      <th>Type</th>
                      <th>Email</th>
                      <th>Balance</th>
                      <th>Access Balance</th>
                      <th style="width: 40px">Action</th>
                    </tr>
                  </thead>
                  <tbody>

                  <?php
                  $id = 1;
                 
                  $data = DBHelper::get("SELECT * FROM admin where company_id = '{$_SESSION["company_id"]}' or type = 1 order by type desc");
                  if ($data->num_rows > 0) {
                      while ($row = $data->fetch_assoc()) {
                        $id = $row["id"];
                        $balance = DBHelper::get("SELECT * FROM `admin_account` WHERE adminID = {$id} and company_id = '{$_SESSION['company_id']}'");
                        $balance = ($balance->num_rows > 0) ? $balance->fetch_assoc()["amount"] : "0";

                        $access_pending_amount = DBHelper::get("SELECT SUM(amount) as total FROM `accessories_account` WHERE status = 0 and type = 1 and sellID = {$row["id"]}");
                        $amount = ($access_pending_amount->num_rows > 0) ? $access_pending_amount->fetch_assoc()["total"] : "0";
                              if($row["type"] == 1){
                                DBHelper::set("UPDATE admin_transaction SET `paymentStatus` = 1 WHERE `adminID` = {$row["id"]}");
                              }
                              ?>
                          <tr>
                          <td><?php echo $row["id"]; ?></td>
                          <td>
                             <img onclick="ShowImage(this.src)" class="rounded-circle" width="40" height="40" src="../images/admin/<?php echo $row["image"]; ?>" alt="">
                          </td>
                          <td><?php echo $row["name"]; ?></td>
                          <td><?php echo $row["mobile"]; ?></td>
                          <td>
                              <?php
                              if ($row["account_status"] == 0) {
                                  ?>
                               <span class="badge badge-success">Allowed</span>
                               <?php
                              } else {
                                  ?>
                                <span class="badge badge-danger">Blocked</span>
                                <?php
                              } ?>
                          </td>
                         
                          <td>
                              <?php
                              if ($row["type"] == 1) {
                                  ?>
                               <span class="badge badge-danger">Super</span>
                               <?php
                              } else {
                                  ?>
                                <span class="badge badge-info">Sub</span>
                                <?php
                              } ?>
                          </td>
                          <td><?php echo $row["email"]; ?></td>
                          <td>
                              <?php
                               echo ($balance > 0) ? '<span class="badge badge-warning">'.$balance.'</span>' : $balance; ?>
                             
                          </td>

                          <td ><?php echo $amount; ?></td>
                          
                          <td >
                                <a class="btn btn-info btn-sm" href="adminProfile?ID=<?php echo $row["id"]; ?>">
                                <i class="nav-icon fas fa-user"></i>
                                </a>
                          </td>
                        </tr>
                        <?php
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

</body>
</html>

<script>
   function ShowImage(value){
    let image = $("#imageView");
    image.prop("src",value);
    $('#imageModel').modal({
    keyboard: false,
    show: true
    })
   }
</script>
