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
                            <a href="admin-export.php">Export/Import database</a>
                        </div>
                </div>
        </div>

        <div class="right">
            <div class="import">
            <div class="export-title">
                <h1>Import database from csv file:</h1>
                <p>Caution! Do not alter the order or the name in the header generated inside the CSV File from Import!</p>
            </div>
            <div class="import-form">
                <form action="import_data.php" method="POST" enctype="multipart/form-data">
                    <input type="file" name="csvfile" required="required">
                    <input type="submit" name="submit" value="IMPORT">
                </form>
            </div>
            </div>
            <hr>
            <div class="export">
            <div class="export-title">
                <h1> Export the caps database </h1>
            </div>
            <div class="export-form">
                <form method="POST" action="export_function.php">
                    <input type="submit" name="export" value="CSV EXPORT">
                </form>
            </div>
            </div>
        </div>
    </div>
</body>
<script type="text/javascript" src="js/dropdown.js"></script>
</html>