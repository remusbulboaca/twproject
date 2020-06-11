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
                    }?>
    <div class="all">
        <div class="left">
            <div class="logo">
            <a href="">COLR <span>Admin panel</span></a>
            </div>
                <div class="menu">
                    <div class="dash">
                    <h2 onclick="location.href='admin-panel.php' ">Dashboard</h2></div>
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
            
            <h1>products</h1>
            <div class="search">
            <input type="text" name="search" id="EchoInput" onblur="getInput(this.value)" placeholder="Search by id">
            </div>
            <?php 
            $sql = "select * from caps";
            $result = query($sql);
            confirm($result);
            ?>
            
            <div class="table-div">
            <?php  
            if(isset($_POST['submitDeleteBtn'])){
                $id=$_POST['keyToDelete'];
                delete_product_ajax($id);
            }
            ?>  
            <table id="table-data">
            <thead>
                    <tr>
                        <th>id</th>
                        <th>id_user</th>
                        <th>Name</th>
                        <th>Year</th>
                        <th>Image</th>
                        <th>Description</th>
                        <th>History</th>
                        <th>Location</th>
                        <th>Date</th>
                        <th>Select </th>
                        <th>Delete </th>
                    </tr>
                    
                </thead> 
                <tbody>
                    <?php while($row=fetch_data($result)){
                    ?>
                    <tr>
                     <form action="" method="post" role="form">  
                    <td><?= $row['id'];?></td>
                    <td><?= $row['id_user'];?></td>
                    <td><?= $row['name'];?></td>
                    <td><?= $row['year'];?></td>
                    <td><?= $row['image'];?></td>
                    <td><?= $row['description'];?></td>
                    <td><?= $row['history'];?></td>
                    <td><?= $row['location'];?></td>
                    <td><?= $row['add_date'];?></td>
                    <td>
                        <input type="checkbox" name="keyToDelete" value="<?php echo $row['id']; ?> required">
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

    xhr.open("POST","ajax-products.php");
    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhr.send("name="+input)
    }
</script>
</html>