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
                <h2 onclick="location.href='admin-panel.php'" style=" cursor:pointer;" >Dashboard</h2> </div>
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
            
            <h1>admins</h1>
            <div class="search">
            <input type="text" name="search" id="EchoInput" onblur="getInput(this.value)" placeholder="Search name">
            </div>
            <?php 
            $sql = "select * from users where admin='1' ";
            $result = query($sql);
            confirm($result);
            ?>
            
            <div class="table-div">
            <?php  
            if(isset($_POST['submitDeleteBtn'])){
                $id=$_POST['keyToDelete'];
                unset_admin_ajax($id);
            }
            ?>  
            <table id="table-data">
            <thead>
                    <tr>
                        <th>id</th>
                        <th>email</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Username</th>
                        <th>Validation Code</th>
                        <th>activeUser</th>
                        <th>Profile Image</th>
                        
                        <th>Select </th>
                        <th>Unset </th>
                        
                    </tr>
                    
                </thead> 
                <tbody>
                    <?php while($row=fetch_data($result)){
                    ?>
                    <tr>
                     <form action="" method="post" role="form">  
                    <td><?= $row['id'];?></td>
                    <td><?= $row['email'];?></td>
                    <td><?= $row['firstName'];?></td>
                    <td><?= $row['lastName'];?></td>
                    <td><?= $row['username'];?></td>
                    <td><?= $row['validationCode'];?></td>
                    <td><?= $row['activeUser'];?></td>
                    <td><?= $row['profileImage'];?></td>
                    
                    <td>
                        <input type="checkbox" name="keyToDelete" value="<?php echo $row['id']; ?>" required>
                    </td>
                    <td>
                        <input type="submit" name="submitDeleteBtn" class="btn">
                    </td>
                    


                    </form> 
                    </tr>
                    <?php }?>
                </tbody>  
                
            </table>
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

    xhr.open("POST","ajax-unset-admin.php");
    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhr.send("name="+input)
    }
</script>
</html>