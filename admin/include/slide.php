<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="dashboard" class="brand-link">
      <img src="c_images/<?php echo $_SESSION['company']['logo'];?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">MIS SYSTEM</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

          <?php if($_SESSION["type"] != '3') { ?>
          
          <li class="nav-item menu-open">
            <a href="dashboard" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Home
                
              </p>
            </a>
           
          </li>

          <?php if ($_SESSION["type"] == "1") {?>
          <li class="nav-item menu-open">
            <a href="new_company" class="nav-link">
              <i class="nav-icon fas fa-building"></i>
              <p>
                New Company
              </p>
            </a>
          </li>
          <?php } ?>

          <li class="nav-item menu-open">
            <a href="searchCustomer" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>
                Search Customer
              </p>
            </a>
          </li>



            <!-- Application Section -->
       <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-file-pdf"></i>
              <p>
                Applications Section
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

              <li class="nav-item">
                <a href="Application?type=pending" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pending Application</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="Application?type=accepted" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Accepted Application</p>
                </a>
              </li>


              <li class="nav-item">
                <a href="Application?type=active" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Active Application</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="Application?type=completed" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Completed Application</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="Application?type=reject" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Rejected Application</p>
                </a>
              </li>

            </ul>
          </li>

           <!-- Investor Section -->
       <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-dollar-sign"></i>
              <p>
                Investor Section
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

              <li class="nav-item">
                <a href="Add_Investor.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Investor</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="InvestorList.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Investor List</p>
                </a>
              </li>

            </ul>
          </li>

      <!-- Customer Section -->
       <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Customer Section
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

              <li class="nav-item">
                <a href="Add_Customer.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Customer</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="Customer_List.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Customer List</p>
                </a>
              </li>

            </ul>
          </li>

            <!-- Control Section -->
       <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                Control Section
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

            <?php if ($_SESSION["type"] == "1") {?>
              <li class="nav-item">
                <a href="CompanyInfo" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Company Info</p>
                </a>
              </li>
            <?php } ?>

              <li class="nav-item">
                <a href="add_company" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add companies</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="add_item_type" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add itme type</p>
                </a>
              </li>

            </ul>
          </li>


       <!-- Admin Section -->
       <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-users-cog"></i>
              <p>
                Admin Section
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

              <?php if ($_SESSION["type"] == "1") {
              ?>
                <li class="nav-item">
                <a href="Add_Admin" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Admin</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="AdminList" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Admin List</p>
                </a>
              </li>

               <?php
          }?>

              <li class="nav-item">
                <a href="Update_Admin" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Update Admin</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="addExp" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Expense</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="ExpenceReport" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Expences Report</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="../APK/apk.apk" download="DBS Mobile App" target="_blank" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Download App</p>
                </a>
              </li>
             
            </ul>
          </li>


           <!-- Report Section -->
       <?php if ($_SESSION["type"] == "1") { ?>
       <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-flag"></i>
              <p>
                Report Section
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

                <li class="nav-item">
                <a href="dailyReport" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Received Cash Report</p>
                </a>
              </li>

            </ul>
          </li>
          <?php } ?>


           <!-- Report Section -->
       <?php if ($_SESSION["type"] == "1") { ?>
       <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-book"></i>
                <p>
                 DigiKhata
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

              <li class="nav-item">
                <a href="add_dg_user" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add user</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="db_user_list" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>User List</p>
                </a>
              </li>

            </ul>
          </li>
          <?php } ?>


          <li class="nav-header">Mobile Shop</li>

          <!--^^^^^^^^^^^^^^^^^^^^^ DBS Shop user section ^^^^^^^^^^^^^^^^^^^^^  -->
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-user"></i>
              <p>
                Shopkeeper Section
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

              <li class="nav-item">
                <a href="addShopkeeper" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add shopkeeper</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="ShopkeeperList" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Shopkeeper List</p>
                </a>
              </li>
             
            </ul>
          </li>
          <!-- ^^^^^^^^^^^^^^^^^^^^^ END ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->

          <!-- ************** DBS Shop Admin section -->
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-calendar-alt"></i>
              <p>
                Admin Section
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

              <li class="nav-item">
                <a href="mobileCompany" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Mobile Company</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="MobileCategory" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add stock</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="StockList" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Stock List</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="GenerateBill" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Generate Bill</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="PendingRequest" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pending Request</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="PurchaseHistory" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Purchase History</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="PurchaseReport" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Purchase Report</p>
                </a>
              </li>
             
            </ul>
          </li>
          <!-- ******************** End ***************** -->


            <!--^^^^^^^^^^^^^^^^^^^^^ DBS Shop user section ^^^^^^^^^^^^^^^^^^^^^  -->
            <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-calendar-alt"></i>
              <p>
              Accessories Section
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

              <li class="nav-item">
                <a href="Add_Accessories" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add stock</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="AccessoriesList" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Accessories List</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="Sell_Accessories" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Generate bill</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="AccessoriesReport" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Accessories Report</p>
                </a>
              </li>

            
             
            </ul>
          </li>
  
         <?php } 
         elseif($_SESSION["type"] == "3") { ?>

         <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-calendar-alt"></i>
              <p>
                ShopKeeper Section
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

              <li class="nav-item">
                <a href="GenerateBill" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Mobile Bill</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="Sell_Accessories" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Accessories bill</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="../APK/apk.apk" download="DBS Mobile App" target="_blank" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Download App</p>
                </a>
              </li>

             
            </ul>
          </li>

         <?php } ?>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>