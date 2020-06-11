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
                        <th>Add </th>
                    </tr>
                </thead>




<?php
foreach($_POST as $post_var){
    $searchKey=$post_var;
    $sql = "select * from users where firstName like '%$searchKey%' and admin='0' ";
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
            <input type="checkbox" name="keyToAdd" value="<?php echo $row['id']; ?> ">
                    </td>
                    <td>
                        <input type="submit" name="submitAdd" class="btn">
                    </td>
        </tr>
        <?php } echo "</tbody> </table> </form>";
}

?>