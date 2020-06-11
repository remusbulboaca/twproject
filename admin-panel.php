<?php require_once('includes/functions/function.php') ;
require_once ('includes/functions/config.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/admin-panel.css">
    <title>Admin Panel</title>
</head>

<body>
<?php if(admin()==true){
                       
                    }
                    else{
                        redirect('profile-personal-details.php');
                    }?>
    <div class="all">
        <div class="left">
            <div class="logo">
            <a href="">COLR <span>Admin panel</span></a>
            </div>

                    
                <div class="menu_mobile">
                <h2>Dashboard</h2>
                <div class="dropdown">
                <button onclick="myFunction2()" class="dropbtn"> Members</button>
  <div id="myDropdown2" class="dropdown-content">
                <a href="admin-page-users.php">Users</a>
                <?php if(gm()==true){ ?>
                            <a href="admin-page-admins.php">Admins</a>
                            <?php } ?>
                            
                            <a href="">Add user</a>
                            <?php if(gm()==true){ ?>
                            <a href="admin-page-add-admin.php">Add admin</a>
                            <?php } ?>
                </div>
                </div> 
                
                <div class="dropdown">
  <button onclick="myFunction()" class="dropbtn">Products</button>
  <div id="myDropdown" class="dropdown-content">
  <a href="admin-view-products.php">View products</a>
                            <a href="admin-view-favorite.php">View favorites</a>
                            <a href="admin-pending-products.php">Pending</a>
  </div>
</div>

                <h2>Database</h2>
                
                </div>


                <div class="menu">
                    <h2>Dashboard</h2>
                    <h2>Members</h2>
                        <div class="members">
                        <a href="admin-page-users.php">Users</a>
                     
                            <?php if(gm()==true){ ?>
                            <a href="admin-page-admins.php">Admins</a>
                            <?php } ?>
                            
                            <a href="">Add user</a>
                            <?php if(gm()==true){ ?>
                            <a href="admin-page-add-admin.php">Add admin</a>
                            <?php } ?>
                        </div>
                    <h2>Products</h2>
                        <div class="products">
                        <a href="admin-view-products.php">View products</a>
                            <a href="admin-view-favorite.php">View favorites</a>
                            <a href="admin-pending-products.php">Pending</a>
                        </div>
                    <h2>Database</h2>
                        <div class="db">
                            <a href="">Export database</a>
                            <a href="">Import database</a>
                        </div>
                </div>
        </div>

        <div class="right">
            <div class="stats">
                <div class="totalUsers">
                    <h3>Total users</h3>
                    <h2><?php echo no_of_users() ?></h2>
                </div>
                <div class="totalProducts">
                    <h3>Total Products</h3>
                    <h2><?php echo no_of_caps() ?></h2>
                </div>
                <div class="newProducts">
                    <h3>New products today</h3>
                    <h2><?php echo 10 ?></h2>
                </div>
            </div>
        </div>
    </div>
</body>
<script type="text/javascript" src="js/dropdown.js"></script>
</html>