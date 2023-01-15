<?php include("include/header.php") ;
$ID = DBHelper::escape($_GET["ID"]);
$customer=DBHelper::get("select * from customer where id = {$ID} and company_id = '{$_SESSION["company_id"]}' ")->fetch_assoc();
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
            <h1 >New Customer Application</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card border-right border-bottom border-info">
        <div class="card-body">

        <form enctype="multipart/form-data" action="model/application.php?cusID=<?php echo $customer["id"];?>" method="post">
        <div class="col-sm-12 bg-info text-center mb-4">
            <h5 class="pt-2 pb-2">Customer Personal Information</h5>
        </div>

        <img height="150" width="250" class="img-thumbnail mb-3" src="../images/customer/<?php echo $customer["image"];?>" alt="Can`t load image">

        <div class="row">
            <div class="col">
            <label for="">ID</label>
            <input required name="id" type="number" disabled class="form-control" value="<?php echo $customer["id"];?>">
            </div>
            <div class="col">
            <label for="" class="">Name</label>
            <input required name="name" type="text" disabled class="form-control" value="<?php echo $customer["name"];?>">
            </div>
            <div class="col">
            <label for="" class="">F-Name</label>
            <input required name="name" type="text" disabled class="form-control" value="<?php echo $customer["fname"];?>">
            </div>
            <div class="col">
            <label for="">CNIC</label>
            <input required name="cnic" type="number" disabled class="form-control" value="<?php echo $customer["cnic"];?>">
            </div>
            <div class="col">
            <label for="">Mobile</label>
            <input required name="mobile" type="number" disabled class="form-control" value="<?php echo $customer["mobile"];?>">
            </div>
            
        </div>


        <div class="col-sm-12 bg-info text-center mb-4 mt-4">
            <h5 class="pt-2 pb-2">Business Information</h5>
        </div>

        <div class="row">
            <div class="col">
            <label for="">Phone NO: 1</label>
            <input required name="ph1" maxlength="11" type="text"  class="form-control" placeholder="Phone NO: 1">
            </div>
            <div class="col">
            <label for="">Phone NO: 2</label>
            <input  name="ph2" maxlength="11" type="number"  class="form-control" placeholder="Phone NO: 2">
            </div>
            <div class="col">
            <label for="">Phone NO: 3</label>
            <input  name="ph3" maxlength="11" type="number"  class="form-control" placeholder="Phone NO: 3">
            </div>
            <div class="col">
            <label for="">Phone NO: 4</label>
            <input  name="ph4" maxlength="11" type="number"  class="form-control" placeholder="Phone NO: 4">
            </div>
        </div>

        <div class="row mt-4">
            <div class="col">
            <label for="">Age</label>
            <input required name="age"  type="number" maxlength="3"  class="form-control" placeholder="Age">
            </div>
            <div class="col">
            <label for="">Monthly Income</label>
            <input required name="monthly_income"  type="text"  class="form-control" placeholder="Enter monthly income">
            </div>
            <div class="col">
            <label for="" >Business Type</label>
            <input required name="business type"  type="text"  class="form-control" placeholder="Enter business type">
            </div>
        </div>

        <div class="row mt-4">
            <div class="col">
            <label for="">Business Address</label>
            <textarea required name="bus_address" class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Enter business type...."></textarea>
            </div>
        </div>


        <div class="col-sm-12 bg-info text-center mb-4  mt-4">
            <h5 class="pt-2 pb-2">Product Information</h5>
        </div>

        <div class="row mt-1">
            <div class="col">
            <label for="">Item Name</label>
            <input required name="product_name"  type="text"  class="form-control" placeholder="Item name...">
            </div>
            <div class="col">
            <label for="">Select Company</label>
            <select name="company_name_id" class="form-control" id="exampleFormControlSelect1">
            <?php
            $data = DBHelper::get("select * from companies order by id asc");
            if($data->num_rows > 0){
                while($row = $data->fetch_assoc()){
                ?>
                 <option value="<?php echo $row["id"];?>"><?php echo ucfirst($row["name"]);?></option>
                <?php
                }
            }
            ?>
            </select>
            </div>
           
            <div class="col">
            <label for="" >Model Numer (optional)</label>
            <input name="model_number"  type="number"  class="form-control" placeholder="Model number...">
            </div>
        </div>

        <div class="row mt-4">
           
            <div class="col">
            <label for="">Select Item Type</label>
            <select name="item_type" class="form-control" id="exampleFormControlSelect1">
            <?php
            $data = DBHelper::get("select * from item_type order by id asc");
            if($data->num_rows > 0){
                while($row = $data->fetch_assoc()){
                ?>
                 <option value="<?php echo $row["id"];?>"><?php echo ucfirst($row["name"]);?></option>
                <?php
                }
            }
            ?>
            </select>
            </div>
           
        </div>


        <div class="row mt-4">

        <div class="col">
            <label for="" >Item Price</label>
            <input required  name="orginal_price"  type="number"  class="form-control" id="item_price" placeholder="Enter item price...">
            </div>

            <div class="col">
            <label for="" >Percentage on item</label>
            <input required name="percentage_on_item"  type="number" id="percentage_on_item"  class="form-control" placeholder="Percentage on item">
            </div>

            <div class="col">
            <label for="" >Total price</label>
            <input required name="total_price"  type="number"  id="total_price" class="form-control" placeholder="Total price">
            </div>
           
        </div>

        <div class="row mt-4">

            <div class="col">
            <label for="" >Installment months</label>
            <input required  name="install_months"  type="number" id="installment_month"  class="form-control" placeholder="Installment months....">
            </div>

            <div class="col">
            <label for="" >Monthly payment</label>
            <input required name="monthly_payment"  type="number" id="monthly_payment"  class="form-control" placeholder="Monthly payment....">
            </div>

            <div class="col">
            <label for="">Advance payment</label>
            <input required name="advance_payment"  type="number" id="first_installment"  class="form-control" placeholder="Advance payment...">
            </div>
        
        </div>

        <div class="row mt-4">
            <div class="col">
            <label for="">Ref By</label>
            <input  name="ref_by" type="text"  class="form-control" placeholder="Ref by">
            </div>
        </div>

        <div class="row mt-4">
            <div class="col">
            <label for="">Item Description</label>
            <textarea required name="item_desp" class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Enter item description...."></textarea>
            </div>
        </div>

        <div class="col-sm-12 bg-info text-center mb-4  mt-4">
            <h5 class="pt-2 pb-2">Persons of proof</h5>
        </div>

        <button class="btn btn-primary mb-3" type="button" onclick="Add_Proof()">Add proof person</button>
        <button class="btn btn-danger mb-3" type="button" onclick="Delete_Proof()">Delete</button>
        <div id="proof_of_person">
          <!-- Place for adding proof of person -->
      
        </div>

        <button type="submit" name="submit" class="btn btn-outline-info">Submit</button>

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
            '<label for="" >Name</label>'+
            '<input required name="per_name'+count+'" type="text"  class="form-control" placeholder="Name...">'+
            '</div>'+

            '<div class="col">'+
            '<label for="" >Mobile</label>'+
            '<input required name="per_mobile'+count+'" type="number"  class="form-control" placeholder="Mobile...">'+
            '</div>'+

            '<div class="col">'+
            '<label for="" >CNIC</label>'+
            '<input required name="per_cnic'+count+'" type="number"  class="form-control" placeholder="CNIC...">'+
            '</div>'+

        '</div>'+
        '<div class="row mt-4 mb-4">'+

            '<div class="col">'+
            '<label for="" >Father Name</label>'+
            '<input required name="fname'+count+'" type="text"  class="form-control " placeholder="Father name....">'+
            '</div>'+

            '<div class="col">'+
            '<label for="" >Business Address</label>'+
            '<input required name="per_address'+count+'" type="text"  class="form-control " placeholder="Business adress....">'+
            '</div>'+
           
            '<div class="col">'+
            '<label for="">Business Type</label>'+
            '<input  name="per_bussiness_type'+count+'" type="text"  class="form-control " placeholder="Business type...">'+
            '</div>'+
        '</div>'+

        '<div>'+
            '<label for="">Address</label>'+
            '<input  name="org_address'+count+'" type="text"  class="form-control " placeholder="Enter address...">'+
        '</div>'+

        '<div class="row mt-4 mb-4">'+
        '<div class="form-group mt-3">'+
            '<label for="exampleFormControlFile1">Proof person image</label>'+
            '<input  accept=".png,.jpg,.jpeg,.gif"  name="per_proof_image'+count+'" type="file" class="form-control-file" id="exampleFormControlFile1">'+
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
