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
          <div class="col-sm-12 rounded titleBackground bg-info pt-1 pb-1 text-center" >
            <h1 >Company expense</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card border-right border-bottom border-info">
        <div class="card-body">

        <form method="post" action="model/addexpense.php">

        <div class="row">
            <div class="col">
            <label for="">Amount</label>
            <input required name="amount" type="number" class="form-control" placeholder="Amount....." value="<?php echo (isset($_GET["id"])) ? $result["name"] : "";?>">
            </div>
        </div>

        <div class="row mt-3">
            <div class="col">
            <label for="">Comment</label>
            <input required name="comment" type="text" class="form-control" placeholder="Comment....." value="<?php echo (isset($_GET["id"])) ? $result["name"] : "";?>">
            </div>
        </div>

        <div class="row mt-3">
            <div class="col">
            <label for="">Select Expence Type</label>
            <select name="exp_type" class="form-control" id="exampleFormControlSelect1">
              <option value="0">Company Expence</option>
              <option value="1">DBS Shop Expence</option>
            </select>
            </div>
        </div>


        <button type="submit" name="submit" class="btn btn-outline-info mt-3">
        Submit
        </button>

        </form>

        </div>
        <!-- /.card-body -->
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

    </section>


    <section class="content">

    

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

