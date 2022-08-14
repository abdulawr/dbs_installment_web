<style>
 .ths {
  padding: 10px 15px;
  font-weight: bold;
  font-size: 18px;
  border: 1px #707070 solid;
}
.tds {
  padding: 10px 15px;
  font-size: 18px;
  border: 1px #707070 solid;
}

@media print{
   .noprint{
       display:none;
       visibility: hidden;
   }

   @page { margin: 0; } 
   body { margin: 1.6cm; }
}

</style>
<?php include("include/header.php");
 $appID = $_GET["ID"];
 if(isset($_GET["ID"])){
  if(DBHelper::set("UPDATE application SET status = 4 WHERE id = {$appID}")){

  }
  else{
    ?>
    <script>
     var id = "<?php echo $_GET["ID"];?>";
     alert("Something went wrong try again!");
     location.replace("../View_Application?ID="+id);
   </script>
  <?php
  }
 }
 else{
     ?>
       <script>
        var id = "<?php echo $_GET["ID"];?>";
        alert("ID is not provided!");
        location.replace("../View_Application?ID="+id);
      </script>
     <?php
 }

 $app = DBHelper::get("SELECT companies.name as 'comp',item_type.name as 'item',application.* from application INNER JOIN companies on companies.id = companyID INNER JOIN item_type on item_type.id = item_type_id WHERE application.id = {$appID}")->fetch_assoc();
 $customer = DBHelper::get("SELECT * FROM `customer` WHERE id = {$app["cusID"]}")->fetch_assoc();
 $investor = DBHelper::get("SELECT * FROM `investor` WHERE id = {$app["investorID"]}")->fetch_assoc();
?>

<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <!-- Navbar -->
  <?php include("include/nav.php"); ?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php include("include/slide.php");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
       
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-body">
         <div>
             <img  class="rounded img-thumbnail" width="80" height="80" src="../images/logo.png" alt="">
             <h1 style="display:inline-block; margin-left:20px; color:brown; font-size:30px">DBS Installment</h1>
         </div>
         <br>
         <h3>Customer Information</h3>
         <br>

         <table class="urdu" style="width: 100%;  border-collapse: collapse;">
            <tr>
            <th class="ths">نام</th>
            <th class="ths">موبائل نمبر</th>
            <th class="ths">قومی شناختی کارڈ</th>
            <th class="ths">مکمل پتہ</th>
            </tr>

            <tr>
                <td class="tds"><?php echo $customer["name"];?></td>
                <td class="tds"><?php echo $customer["mobile"];?></td>
                <td class="tds"><?php echo $customer["cnic"];?></td>
                <td class="tds"><?php echo $customer["address"];?></td>
            </tr>

            </table>
            <hr>

         <br>
         <h3>Application Information</h3>
         <br>

         <table  style="width: 100%;  border-collapse: collapse;" class="border-danger-1">
            <tr>
            <th class="ths">Application ID</th>
            <th class="ths">Item</th>
            <th class="ths">Company</th>
            <th class="ths">Adance payment</th>
            <th class="ths">Monthly payment</th>
            <th class="ths">Installment months</th>
            <th class="ths">Total price</th>
            </tr>

            <tr>
                <td class="tds"><?php echo $app["id"];?></td>
                <td class="tds"><?php echo $app["product_name"];?></td>
                <td class="tds"><?php echo $app["comp"];?></td>
                <td class="tds"><?php echo $app["advance_payment"];?></td>
                <td class="tds"><?php echo $app["monthly_payment"];?></td>
                <td class="tds"><?php echo $app["installment_months"];?></td>
                <td class="tds"><?php echo $app["total_price"];?></td>
            </tr>

            </table>
            <hr>
            <p>This print clearify that the customer have paid all amount of the application.</p>
            <br>
            
            <div class="sign container mt-2">
            <div class="row">
            <div class="col"><p>Customer Sign:________________________</p></div>
            <div class="col"><p>Admin Sign:________________________</p></div>
            <div class="col"><p>Date: <span style="border-bottom:1px solid #000;"><?php echo date('d-m-Y');?></span></p></div>
            </div>
            </div>

            <br>

            <button onclick="prints()" class="noprint btn btn-primary">Print</button>
            <a href="Application" class="btn btn-info ml-2 noprint">Home</a>

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
 function prints(){
      window.print();
    }
</script>


