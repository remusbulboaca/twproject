<?php require_once('includes/functions/function.php') ;
include ('includes/functions/config.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/admin-page-users.css">
    <title>Admin Panel</title>
    <head>
</head>
<style>

    
    .dash{
        cursor:pointer;
    }
    
</style>
<body>
<?php if(admin()==true){
                       
                    }
                    else{
                        redirect('profile-personal-details.php');
                    }
                    
                     if(gm()==true){

                     }
                     else{
                        redirect('admin-panel.php');
                     }
                    
                    
                    
                    
                    ?>
    <div class="all">
        <div class="left">
            <div class="logo">
            <a href="">COLR <span>Admin panel</span></a>
            </div>
                <div class="menu">
                    <div class="dash">
                    <h2 onclick="location.href='admin-panel.php' ">Dashboard</h2> </div>
                    <h2>Members</h2>
                        <div class="members">
                        <a href="admin-page-users.php">Users</a>
                            <?php if(gm()==true){ ?>
                            <a href="admin-page-admins.php">Admins</a>
                            <?php } ?>
                            
                            <a href="admin-page-add-user.php">Add user</a>
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
                            <a href="admin-export.php">Import/Export DB</a>
                        </div>
                </div>
        </div>

        <div class="right">
        <div class="cool">
        <form method="post" action="">
        
        <input type="email" id="email" name="email" placeholder="Email" required><br><br>
        <input type="text" id="fname" name="fname" placeholder="First name" required><br><br>
        <input type="text" id="lname" name="lname" placeholder="Last name" required><br><br>
        <input type="text" id="username" name="username" placeholder="Username" required><br><br>
        <input type="password" id="password" name="password" placeholder="Password" required><br><br>
        <button class="button"> Create account</button>
        <p style="color:red"> <?php admin_add_user() ?> </p>
    </form>
            
        </div>
        </div>
    </div>
</body>


<script type="text/javascript">
    function getInput(input) {
    const xhr=new XMLHttpRequest();
    xhr.onload=function(){
        const serverResponse=document.getElementById("table-data");
        serverResponse.innerHTML=this.responseText;
    }

    xhr.open("POST","ajax-add-admins.php");
    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhr.send("name="+input)
    }
</script>
</html>