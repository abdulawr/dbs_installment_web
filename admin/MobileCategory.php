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

    <?php
      if(isset($_GET["id"])){
         $data = DBHelper::get("select * from dbs_shop_stock where id ='{$_GET["id"]}' and company_id = '{$_SESSION["company_id"]}';");
         if($data->num_rows <= 0){
          exit("Invalid access, stock deosn`t exist with given id");
         }
         $data = $data->fetch_assoc();
      }
    ?>

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
                <select <?php echo isset($_GET["id"]) ? "disabled" : ""; ?>  name="company" id="inputState" class="form-control">
                    <?php
                    $company = DBHelper::get("SELECT * FROM `mobile_company_dbs` order by id asc");
                    if($company->num_rows > 0){
                        while($row = $company->fetch_assoc()){
                           if(isset($_GET["id"]) && $row["id"] == $data["companyID"]){
                            ?>
                              <option selected="selected" value="<?php echo $row["id"];?>"><?php echo ucfirst($row["name"]);?></option>
                            <?php
                           }
                           else{
                            ?>
                              <option value="<?php echo $row["id"];?>"><?php echo ucfirst($row["name"]);?></option>
                            <?php
                           }
                        }
                    }

                    $rams = [2,3,4,6,8,10,12,16,32,64,128,256,512,1024];
                    ?>
                </select>
                </div>

                <div class="form-group col">
                <label for="inputEmail4">RAM</label>
                <select <?php echo isset($_GET["id"]) ? "disabled" : ""; ?> name="ram" id="inputState" class="form-control">
                  <?php
                     foreach($rams as $row){
                        if(isset($_GET['id']) && $row == $data["ram"]){
                          echo ' <option selected="selected" value="'.$row.'">'.$row.'</option>';
                        }
                        else{
                           echo ' <option value="'.$row.'">'.$row.'</option>';
                        }
                     }
                  ?>
                </select>
                </div>

                <div class="form-group col">
                <label for="inputPassword4">Memory</label>
                <select <?php echo isset($_GET["id"]) ? "disabled" : ""; ?> name="memory" id="inputState" class="form-control">
                  <?php
                     foreach($rams as $row){
                      if(isset($_GET['id']) && $row == $data["memory"]){
                        echo ' <option selected="selected" value="'.$row.'">'.$row.'</option>';
                      }
                      else{
                         echo ' <option value="'.$row.'">'.$row.'</option>';
                      }
                   }
                  ?>
                </select>
                </div>

            </div>



            <div class="form-row">

                <div class="form-group col">
                <label for="inputEmail4">SIM Type</label>
                <select <?php echo isset($_GET["id"]) ? "disabled" : ""; ?> name="sim" id="inputState" class="form-control">
                    <option <?php if(isset($_GET["id"]) && $data["sim"] == 'Single sim'){echo 'selected="selected"';}?> value="Single sim">Single sim</option>
                    <option <?php if(isset($_GET["id"]) && $data["sim"] == 'Double sim'){echo 'selected="selected"';}?> value="Double sim">Double sim</option>
                    <option <?php if(isset($_GET["id"]) && $data["sim"] == 'Triple sim'){echo 'selected="selected"';}?> value="Triple sim">Triple sim</option>
                </select>
                </div>

                <div class="form-group col">
                <label for="inputEmail4">Network</label>
                <select <?php echo isset($_GET["id"]) ? "disabled" : ""; ?> name="network" id="inputState" class="form-control">
                    <option <?php if(isset($_GET["id"]) && $data["network"] == "2G"){echo 'selected="selected"';}?>>2G</option>
                    <option <?php if(isset($_GET["id"]) && $data["network"] == "3G"){echo 'selected="selected"';}?>>3G</option>
                    <option <?php if(isset($_GET["id"]) && $data["network"] == "4G"){echo 'selected="selected"';}?>>4G</option>
                    <option <?php if(isset($_GET["id"]) && $data["network"] == "5G"){echo 'selected="selected"';}?>>5G</option>
                </select>
                </div>

                <div class="form-group col">
                <label for="inputPassword4">Fringprint support</label>
                <select <?php echo isset($_GET["id"]) ? "disabled" : ""; ?> name="fringerprint" id="fingerprint" id="inputState" class="form-control">
                    <option <?php if(isset($_GET["id"]) && $data["fringerprint"] == 0){echo 'selected="selected"';}?> value="0">Yes</option>
                    <option <?php if(isset($_GET["id"]) && $data["fringerprint"] == 1){echo 'selected="selected"';}?> value="1">No</option>
                </select>
                </div>

            </div>

            <div class="form-row">
               <div class="form-group col">
                <label for="inputAddress">Front camera</label>
                <input <?php echo isset($_GET["id"]) ? "disabled" : ""; ?> name="front_camera" required type="number" class="form-control" id="inputAddress" placeholder="Front camera" value="<?php if(isset($_GET["id"])){echo $data["font_camera"];}?>">
                </div>

                <div class="form-group col">
                <label for="inputAddress">Back camera</label>
                <input <?php echo isset($_GET["id"]) ? "disabled" : ""; ?> name="back_camera" type="text" required class="form-control" id="inputAddress" placeholder="Back camera" value="<?php if(isset($_GET["id"])){echo $data["back_camera"];}?>">
                </div>
            </div>


            <div class="form-row">

                <div class="form-group col">
                <label for="inputAddress">Buying price</label>
                <input <?php echo isset($_GET["id"]) ? "disabled" : ""; ?> type="number" required name="buying_price" class="form-control" id="inputAddress" placeholder="Buying price" value="<?php if(isset($_GET["id"])){echo $data["buy_price"];}?>">
                </div>

                <div class="form-group col">
                <label for="inputAddress">Selling price</label>
                <input type="number" required name="selling_price" class="form-control" id="inputAddress" placeholder="Selling price" value="<?php if(isset($_GET["id"])){echo $data["selling_price"];}?>">
                </div>
               
            </div>


            <div class="form-row">

            <div class="form-group col">
            <label for="inputAddress">Quantity</label>
            <input name="quantity" required type="number" class="form-control" id="inputAddress" placeholder="Quantity" value="<?php if(isset($_GET["id"])){echo $data["quantity"];}?>">
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
if(isset($_POST["submit"]) && isset($_POST["quantity"])){
   
    $selling_price = $_POST["selling_price"];
    $quantity = $_POST["quantity"];
    $date = date("Y-m-d");

   if(isset($_GET["id"])){
      // quantity changed
      if($quantity != $data["quantity"]){
         $change = ceil(abs($quantity - $data["quantity"]));
         $total = ceil($data["buy_price"] * $change);
         DBHelper::set("UPDATE dbs_shop_account SET balance = balance + {$total} WHERE status = 1 and company_id = '{$_SESSION["company_id"]}'");
      }

      if(DBHelper::set("UPDATE dbs_shop_stock set `selling_price` = '$selling_price', `quantity` = '$quantity' where id = '{$data["id"]}' and `company_id` = '{$_SESSION["company_id"]}'")){
        ?>
        <script>
          location.replace("StockList?spID=<?php echo $data["id"];?>")
        </script>
        <?php
      }else{
        showMessage("Something went wrong try again",false);
      }

   }
   else{
    $company = $_POST["company"];
    $ram = $_POST["ram"];
    $memory = $_POST["memory"];
    $sim = $_POST["sim"];
    $network = $_POST["network"];
    $fringerprint = $_POST["fringerprint"];
    $front_camera = $_POST["front_camera"];
    $back_camera = $_POST["back_camera"];
    $buying_price = $_POST["buying_price"];

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

}
?>
