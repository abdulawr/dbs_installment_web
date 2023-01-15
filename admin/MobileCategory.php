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
            <h1>Add mobile category</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content ">

      <!-- Default box -->
      <div class="card">
        <div class="card-body border-bottom-0 border-info">

        <h5 id="stockID" style="display: none;" class="mb-4 bg-primary pl-4 rounded pt-1 pb-1">Plase ksdf</h5>

        <form method="post">
            <div class="form-row">

                <div class="form-group col">
                <label for="inputEmail4">Company</label>
                <select name="company" id="inputState" class="form-control">
                    <?php
                    $company = DBHelper::get("SELECT * FROM `mobile_company_dbs` order by id asc");
                    if($company->num_rows > 0){
                        while($row = $company->fetch_assoc()){
                            ?>
                              <option value="<?php echo $row["id"];?>"><?php echo ucfirst($row["name"]);?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
                </div>

                <div class="form-group col">
                <label for="inputEmail4">RAM</label>
                <select name="ram" id="inputState" class="form-control">
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="6">6</option>
                    <option value="8">8</option>
                    <option value="10">10</option>
                    <option value="12">12</option>
                    <option value="16">16</option>
                    <option value="32">32</option>
                    <option value="64">64</option>
                    <option value="128">128</option>
                </select>
                </div>

                <div class="form-group col">
                <label for="inputPassword4">Memory</label>
                <select name="memory" id="inputState" class="form-control">
                    <option value="2">2</option>
                    <option value="4">4</option>
                    <option value="6">6</option>
                    <option value="8">8</option>
                    <option value="12">12</option>
                    <option value="16">16</option>
                    <option value="24">24</option>
                    <option value="32">32</option>
                    <option value="64">64</option>
                    <option value="128">128</option>
                    <option value="256">256</option>
                    <option value="512">512</option>
                </select>
                </div>

            </div>



            <div class="form-row">

                <div class="form-group col">
                <label for="inputEmail4">SIM Type</label>
                <select name="sim" id="inputState" class="form-control">
                    <option value="Single sim">Single sim</option>
                    <option value="Double sim">Double sim</option>
                    <option value="Triple sim">Triple sim</option>
                </select>
                </div>

                <div class="form-group col">
                <label for="inputEmail4">Network</label>
                <select name="network" id="inputState" class="form-control">
                    <option>2G</option>
                    <option>3G</option>
                    <option>4G</option>
                    <option>5G</option>
                </select>
                </div>

                <div class="form-group col">
                <label for="inputPassword4">Fringprint support</label>
                <select name="fringerprint" id="fingerprint" id="inputState" class="form-control">
                    <option value="0">Yes</option>
                    <option value="1">No</option>
                </select>
                </div>

            </div>

            <div class="form-row">
               <div class="form-group col">
                <label for="inputAddress">Front camera</label>
                <input name="front_camera" required type="number" class="form-control" id="inputAddress" placeholder="Front camera">
                </div>

                <div class="form-group col">
                <label for="inputAddress">Back camera</label>
                <input name="back_camera" type="text" required class="form-control" id="inputAddress" placeholder="Back camera">
                </div>
            </div>


            <div class="form-row">

                <div class="form-group col">
                <label for="inputAddress">Buying price</label>
                <input type="number" required name="buying_price" class="form-control" id="inputAddress" placeholder="Buying price">
                </div>

                <div class="form-group col">
                <label for="inputAddress">Selling price</label>
                <input type="number" required name="selling_price" class="form-control" id="inputAddress" placeholder="Selling price">
                </div>
               
            </div>


            <div class="form-row">

            <div class="form-group col">
            <label for="inputAddress">Quantity</label>
            <input name="quantity" required type="number" class="form-control" id="inputAddress" placeholder="Buying price">
            </div>

            </div>


            <button name="submit" type="submit" class="btn btn-primary">Submit</button>
            </form>

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
if(isset($_POST["submit"]) && isset($_POST["quantity"]) && isset($_POST["company"])){

    $company = $_POST["company"];
    $ram = $_POST["ram"];
    $memory = $_POST["memory"];
    $sim = $_POST["sim"];
    $network = $_POST["network"];
    $fringerprint = $_POST["fringerprint"];
    $front_camera = $_POST["front_camera"];
    $back_camera = $_POST["back_camera"];
    $buying_price = $_POST["buying_price"];
    $selling_price = $_POST["selling_price"];
    $quantity = $_POST["quantity"];
  
    $date = date("Y-m-d");

    $qry = "INSERT INTO `dbs_shop_stock`(`companyID`, `ram`, `memory`, `sim`, `network`, `fringerprint`, `font_camera`, `back_camera`, `buy_price`, `selling_price`, `quantity`, `date`,company_id) 
    VALUES ($company,$ram,$memory,'{$sim}','{$network}',$fringerprint,'{$front_camera}','{$back_camera}',$buying_price,$selling_price,$quantity,'{$date}','{$_SESSION["company_id"]}')";
   
    if(DBHelper::set($qry)){
      $id = $con->insert_id;
      $total = ceil($buying_price * $quantity);
      if(DBHelper::set("UPDATE dbs_shop_account SET balance = balance + {$total} WHERE status = 1 and company_id = '{$_SESSION["company_id"]}'")){
       showMessage("Stock item successfully, Please add this stock id to every box or mobile in this stock = $id",true);
       ?>
        <script>
          var id="<?php echo $id;?>";
          $("#stockID").show();
          $("#stockID").text("Please add this stock id to every box or mobile in this stock = "+id);
        </script>
       <?php
      }
      else{
        DBHelper::get("delete from dbs_shop_stock where id = {$id} and company_id = '{$_SESSION["company_id"]}'");
        showMessage("Something went wrong try again, adding stock value",false);
      }
    }
    else{
      showMessage("Something went wrong try again",false);
    }

}
?>
