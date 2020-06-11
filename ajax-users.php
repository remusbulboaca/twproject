<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    

<?php
require_once('includes/functions/function.php') ;
?>
 <form action="" method="post" role="form">  
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
                        <th>Delete </th>
                    </tr>
                </thead>




<?php
foreach($_POST as $post_var){
    $searchKey=$post_var;
    $sql = "select * from users where firstName like '$searchKey%' and admin='0' ";
    $result = query($sql);
    confirm($result);
    echo "<tbody>";
    while($row=fetch_data($result)){
        ?>

        <tr>
            <td><?= $row['id'];?></td>
            <td><?= $row['email'];?></td>
            <td><?= $row['firstName'];?></td>
            <td><?= $row['lastName'];?></td>
            <td><?= $row['username'];?></td>
            <td><?= $row['validationCode'];?></td>
            <td><?= $row['activeUser'];?></td>
            <td><?= $row['profileImage'];?></td>
            <td>
                        <input type="checkbox" name="keyToDelete" value="<?php echo $row['id']; ?> required">
                    </td>
                    <td>
                        <input type="submit" name="submitDeleteBtn" class="btn">
                    </td>
                    
        </tr>
        
        <?php } echo "</tbody> </table> </form>";
}

?>
<script type="text/javascript" src="admin-page-users.js"></script>

</body>
</html>
