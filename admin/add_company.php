<?php include("include/header.php");
if(isset($_GET["id"])){
    $result = DBHelper::get("select * from companies where id = {$_GET["id"]}")->fetch_assoc();
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
            <h1 >Add Company</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card border-right border-bottom border-info">
        <div class="card-body">

        <form method="post" action=" <?php echo (isset($_GET["id"])) ? "model/update_companies.php?id=".$_GET['id'] : "";?>">

        <div class="row">
            <div class="col">
            <label for="">Name</label>
            <input required name="name" type="text" class="form-control" placeholder="Name" value="<?php echo (isset($_GET["id"])) ? $result["name"] : "";?>">
            </div>
        </div>

        <button type="submit" name="submit" class="btn btn-outline-info mt-3">
        <?php echo (isset($_GET["id"])) ? "Update" : "Add";?>
        </button>

        </form>

        </div>
        <!-- /.card-body -->
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

    </section>


    <section class="content">

      <!-- Default box -->
      <div class="card border-right border-bottom border-info">
        <div class="card-body">

        <table class="table table-striped">
        <thead>
            <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $data=DBHelper::get("select * from companies order by id asc");
            if($data->num_rows > 0){
                while($row = $data->fetch_assoc()){
                    ?>
                      <tr>
                        <th class="w-25" scope="row"><?php echo $row["id"];?></th>
                        <td><?php echo ucfirst($row["name"]);?></td>
                        <td class="w-25">
                            <a class="btn-sm btn-warning" href="add_company?id=<?php echo $row["id"];?>">Update</a>
                            <a class="btn-sm btn-danger" href="model/delete_companies.php?id=<?php echo $row["id"];?>">Delete</a>
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

<?php
if(isset($_POST["submit"])){
$name=validateInput($_POST["name"]);
$name = strtolower($name);
if(DBHelper::set("INSERT INTO `companies`(`name`) VALUES ('{$name}')")){
showMessage("company name is added successfully",true);
}
else{
    showMessage("The name is already exist",false);
}
}
?>
