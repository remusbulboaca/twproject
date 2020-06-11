<?php
require_once('includes/functions/function.php') ;
?>  
<form action="" method="post" role="form">  
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
                        <th>Alcool</th>
                        <th>Select </th>
                        <th>Delete </th>
                        <th>Accept </th>
                    </tr>
                </thead>




<?php
foreach($_POST as $post_var){
    $searchKey=$post_var;
    $sql = "select * from pending  where id like '%$searchKey%' order by add_date desc";
    $result = query($sql);
    confirm($result);
    echo "<tbody>";
    while($row=fetch_data($result)){
        ?>

        <tr>
                    <td><?= $row['id'];?></td>
                    <td><?= $row['id_user'];?></td>
                    <td><?= $row['name'];?></td>
                    <td><?= $row['year'];?></td>
                    <td><?= $row['image'];?></td>
                    <td><?= $row['description'];?></td>
                    <td><?= $row['history'];?></td>
                    <td><?= $row['location'];?></td>
                    <td><?= $row['add_date'];?></td>
                    <td><?= $row['alcool'];?></td>
                    <td>
                        <input type="checkbox" name="key" value="<?php echo $row['id']; ?> required">
                    </td>
                    <td>
                        <input type="submit" name="submitDeleteBtn" class="btn" value="Delete">
                    </td>
                    <td>
                        <input type="submit" name="submitAcceptBtn" class="btn" value="Accept">
                    </td>
        </tr>
        <?php } echo "</tbody> </table> </form>";
}

?>