<?php include("include/header.php") ;
$ID = $_GET["ID"];
$app=DBHelper::get("select * from application where id = {$ID}")->fetch_assoc();
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
          <div class="col-sm-8 bg-success pt-1 pb-1 text-center" style="border-top-right-radius: 500px; border-bottom-right-radius: 500px;">
            <h1 >Edit application</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card border-right border-bottom border-info">
        <div class="card-body">

        <form enctype="multipart/form-data" action="" method="post">

        <div class="col-sm-12 bg-info text-center mb-4 mt-4">
            <h5 class="pt-2 pb-2">Business Information</h5>
        </div>


        <div class="row mt-4">
            <div class="col">
            <label for="">Age</label>
            <input required name="age"  type="number" maxlength="3"  class="form-control" placeholder="Age" value="<?php echo $app["age"];?>">
            </div>
            <div>
            <label for="" class="urdu" style="float: right;">ماہانہ آمدنی</label>
            <input required name="monthly_income"  type="text"  class="form-control urdu" placeholder="ماہانہ آمدنی" value="<?php echo $app["monthly_income"];?>">
            </div>
            <div class="col">
            <label for="" class="urdu" style="float: right;">کاروبار کی قسم</label>
            <input required name="business type"  type="text"  class="form-control urdu" placeholder="کاروبار کی قسم" value="<?php echo $app["business_type"];?>">
            </div>
        </div>

        <div class="row mt-4">
            <div class="col">
            <label for="" class="urdu" style="float: right;">کاروباری پتہ</label>
            <textarea required name="bus_address" class="form-control urdu" id="exampleFormControlTextarea1" rows="3" placeholder="کاروباری پتہ">
            <?php echo $app["business_address"];?>
            </textarea>
            </div>
        </div>


        <div class="col-sm-12 bg-info text-center mb-4  mt-4">
            <h5 class="pt-2 pb-2">Product Information</h5>
        </div>

        <div class="row mt-1">
            <div class="col">
            <label for="" class="urdu" style="float: right;" >سامان کا نام</label>
            <input required name="product_name"  type="text"  class="form-control urdu" placeholder="سامان کا نام" value="<?php echo $app["product_name"];?>">
            </div>
            <div class="col">
            <label for="" class="urdu" style="float: right;">کمپنی کا نام</label>
            <select name="company_name_id" class="form-control" id="exampleFormControlSelect1">
            <?php
            $data = DBHelper::get("select * from companies order by id asc");
            if($data->num_rows > 0){
                while($row = $data->fetch_assoc()){
                if($row["id"] == $app["companyID"]){
                    ?>
                    <option selected value="<?php echo $row["id"]; ?>"><?php echo ucfirst($row["name"]); ?></option>
                   <?php
                }
                else{
                    ?>
                 <option value="<?php echo $row["id"]; ?>"><?php echo ucfirst($row["name"]); ?></option>
                <?php
                }
                }
            }
            ?>
            </select>
            </div>
           
            <div class="col">
            <label for="" class="urdu" style="float: right;">ماڈل نمبر</label>
            <input required name="model_number"  type="number"  class="form-control" placeholder="Model number" value="<?php echo $app["model_no"];?>">
            </div>
        </div>

        <div class="row mt-4">
           
            <div class="col">
            <label for="" class="urdu" style="float: right;">سامان کی قسم</label>
            <select name="item_type" class="form-control" id="exampleFormControlSelect1">
            <?php
            $data = DBHelper::get("select * from item_type order by id asc");
            if($data->num_rows > 0){
                while ($row = $data->fetch_assoc()) {
                    if ($row["id"] == $app["item_type_id"]) {
                        ?>
                        <option selected value="<?php echo $row["id"]; ?>"><?php echo ucfirst($row["name"]); ?></option>
                       <?php
                    } else {
                ?>
                 <option value="<?php echo $row["id"]; ?>"><?php echo ucfirst($row["name"]); ?></option>
                <?php
                    }
                }
            }
            ?>
            </select>
            </div>
           
        </div>


        <div class="row mt-4">
            <div class="col">
            <label for="" class="urdu" style="float: right;">کل قیمت</label>
            <input required name="total_price" value="<?php echo $app["total_price"]; ?>"  type="number"  id="total_price" class="form-control" placeholder="Total price">
            </div>
            
            <div class="col">
            <label for="" >Percentage on item</label>
            <input required name="percentage_on_item"  value="<?php echo $app["percentage_on_prod"]; ?>"  type="number" id="percentage_on_item"  class="form-control" placeholder="Percentage on item">
            </div>
           
            <div class="col">
            <label for="" class="urdu" style="float: right;">سامان کی قیمت</label>
            <input required  name="orginal_price" value="<?php echo $app["product_orginal_price"]; ?>"  type="number"  class="form-control" id="item_price" placeholder="Item price">
            </div>
        </div>

        <div class="row mt-4">
            <div class="col">
            <label for="" class="urdu" style="float: right;">پہلی ادائیگی</label>
            <input required name="advance_payment" value="<?php echo $app["advance_payment"]; ?>"  type="number" id="first_installment"  class="form-control" placeholder="Advance payment">
            </div>

            <div class="col">
            <label for="" class="urdu" style="float: right;">ماہانہ ادائیگی</label>
            <input required name="monthly_payment" value="<?php echo $app["monthly_payment"]; ?>"  type="number" id="monthly_payment"  class="form-control" placeholder="Monthly payments">
            </div>
           
            <div class="col">
            <label for="" class="urdu" style="float: right;">قسط مہینوں</label>
            <input required value="<?php echo $app["installment_months"]; ?>" name="install_months"  type="number" id="installment_month"  class="form-control" placeholder="Installment months">
            </div>
        </div>

        <div class="row mt-4">
            <div class="col">
            <label for="" class="urdu" style="float: right;">ریف بیس</label>
            <input value="<?php echo $app["ref_by"]; ?>"  name="ref_by" type="text"  class="form-control urdu" placeholder="Ref by">
            </div>
        </div>

        <button type="submit" name="update" class="btn btn-outline-info mt-3">Update</button>

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
if(isset($_GET["msg"])){
    $msg = $_GET["msg"];
    switch($msg){
        case "success":
            showMessage("Application created successfully",true);
            break;
        case "error":
            showMessage("Something went wrong in creating application",false);
            break;
    }
}
?>

<script>
    var count = 1;

    function Delete_Proof(){
     $("#proof_of_person").empty()
     count=1;
    }

    function Add_Proof(){
       let prof_place_to_add = $("#proof_of_person");
       let proof_person_div = '<div id="per"'+count+'>'+
         '  <h4 class="bg-dark p-1 rounded pl-3">Person '+count+'</h4>'+
         ' <input name="per'+count+'" type="hidden" required value="1">'+
         '<div class="row mt-4 mb-4">'+
            '<div class="col">'+
            '<label for="" class="urdu" style="float: right;">موبائل نمبر</label>'+
            '<input required name="per_mobile'+count+'" type="number"  class="form-control" placeholder="Mobile">'+
            '</div>'+

            '<div class="col">'+
            '<label for="" class="urdu" style="float: right;">قومی شناختی کارڈ</label>'+
            '<input required name="per_cnic'+count+'" type="number"  class="form-control" placeholder="CNIC">'+
            '</div>'+
           
            '<div class="col">'+
            '<label for="" class="urdu" style="float: right;">نام</label>'+
            '<input required name="per_name'+count+'" type="text"  class="form-control urdu" placeholder="نام">'+
            '</div>'+
        '</div>'+
        '<div class="row mt-4 mb-4">'+
            '<div class="col">'+
            '<label for="" class="urdu" style="float: right;">کاروباری پتہ</label>'+
            '<input required name="per_address'+count+'" type="text"  class="form-control urdu" placeholder="کاروباری پتہ">'+
            '</div>'+
           
            '<div class="col">'+
            '<label for="" class="urdu" style="float: right;">کاروبار کی قسم</label>'+
            '<input  name="per_bussiness_type'+count+'" type="text"  class="form-control urdu" placeholder="کاروبار کی قسم">'+
            '</div>'+
        '</div>'+

        '<div class="row mt-4 mb-4">'+
        '<div class="form-group mt-3">'+
            '<label for="exampleFormControlFile1">Proof person image</label>'+
            '<input required accept=".png,.jpg,.jpeg,.gif"  name="per_proof_image'+count+'" type="file" class="form-control-file" id="exampleFormControlFile1">'+
        '</div>'+

        '<div class="form-group mt-3">'+
            '<label for="exampleFormControlFile1">CNIC image</label>'+
            '<input accept=".png,.jpg,.jpeg,.gif"  name="per_cnic_image'+count+'" type="file" class="form-control-file" id="exampleFormControlFile1">'+
        '</div>'+

        '<div class="form-group mt-3">'+
            '<label for="exampleFormControlFile1">Business card image</label>'+
            '<input accept=".png,.jpg,.jpeg,.gif"  name="per_bus_card_file'+count+'" type="file" class="form-control-file" id="exampleFormControlFile1">'+
        '</div>'+

        '</div>'+

        '</div>';
        if(count <= 2){
            prof_place_to_add.append(proof_person_div);
        }
        else{
            alert("You can only two person in a single application");
        }
      
        count ++;
    }


    let item_price = $("#item_price");
    let percentage_on_item = $("#percentage_on_item");
    let total_price = $("#total_price");
    let installment_month = $("#installment_month");
    let monthly_payment = $("#monthly_payment");
    let first_installment = $("#first_installment");

    item_price.on("keyup",function(){
        let orginal_price = parseInt(item_price.val());
        let per=parseInt(percentage_on_item.val());
        if(per > 0){
          var pr_value = parseFloat((orginal_price / 100));
          pr_value = pr_value * per;
          pr_value = Math.ceil(pr_value);
          first_installment.val(pr_value);
          pr_value = orginal_price + pr_value
         
          total_price.val(pr_value);
        }
        else{
            total_price.val(orginal_price);
        }
    })

    percentage_on_item.on("keyup",function(){
        let orginal_price = parseInt(item_price.val());
        let per=parseInt(percentage_on_item.val());
        
        if(orginal_price > 0){
            var pr_value = parseFloat((orginal_price / 100)); 
          pr_value = pr_value * per;
          pr_value = Math.ceil(pr_value);
          first_installment.val(pr_value);
          pr_value = orginal_price + pr_value
    
          total_price.val(pr_value);
        }
    })

    installment_month.on("keyup",function(){
       let install = parseInt(installment_month.val());
       if(install <= 24 || install >= 1){
         let total_pr = parseInt(total_price.val());
         let advance = parseInt(first_installment.val());
         var mon = total_pr - advance;
         mon = mon / install;
         mon = Math.ceil(mon);
         monthly_payment.val(mon);
       }
    })

</script>

<?php
if(isset($_POST["update"])){
 $appID = $ID;
 $age = $_POST["age"];
 $monthly_income = $_POST["monthly_income"];
 $business_type = $_POST["business_type"];
 $bus_address = $_POST["bus_address"];
 $product_name = $_POST["product_name"];
 $company_name_id = $_POST["company_name_id"];
 $model_number = $_POST["model_number"];
 $item_type = $_POST["item_type"];
 $total_price = $_POST["total_price"];
 $percentage_on_item = $_POST["percentage_on_item"];
 $orginal_price = $_POST["orginal_price"];
 $advance_payment = $_POST["advance_payment"];
 $monthly_payment = $_POST["monthly_payment"];
 $install_months = $_POST["install_months"];
 $ref_by = $_POST["ref_by"];

 $query = "UPDATE application SET 
 age = {$age},
 monthly_income = {$monthly_income},
 business_type = '{$business_type}',
 business_address = '{$bus_address}',
 product_name = '{$product_name}',
 companyID = {$company_name_id},
 model_no = {$model_number},
 item_type_id = {$item_type},
 total_price = {$total_price},
 percentage_on_prod = {$percentage_on_item},
 product_orginal_price = {$orginal_price},
 advance_payment = {$advance_payment},
 monthly_payment = {$monthly_payment},
 installment_months = {$install_months},
 ref_by = '{$ref_by}' WHERE id = {$ID}";

 if(DBHelper::set($query)){
  showMessage("Action perform successfull");
 }
 else{
     showMessage("Something went try again",false);
 }

}
?>
