<?php
require_once('includes/functions/function.php') ;
include ('includes/functions/config.php');
?>  
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
                        <?php  if(gm()==true) { ?>
                        <th>Select </th>
                        <th>Unset </th>
                        <?php } ?>
                    </tr>
                </thead>




<?php
foreach($_POST as $post_var){
    $searchKey=$post_var;
    $sql = "select * from users where firstName like '%$searchKey%' and admin='1' ";
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
            <?php  if(gm()==true){ ?>
                    <td>
                    <input type="checkbox" name="keyToDelete" value="<?php echo $row['id']; ?>" required>
                    </td>
                    <td>
                        <input type="submit" name="submitDeleteBtn" class="btn">
                    </td>
                    <?php } ?>
        </tr>
        <?php } echo "</tbody>";
}

?>