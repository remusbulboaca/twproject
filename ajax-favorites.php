<?php
require_once('includes/functions/function.php') ;
?>  
<thead>
<tr>
                        <th>id Product</th>
                        <th>Product</th>
                        <th>Username</th>
                        <th>Year</th>
                        <th>Location</th>
                        <th>Date</th>
                    </tr>
                </thead>




<?php
foreach($_POST as $post_var){
    $searchKey=$post_var;
    $sql = "select c.id,c.name,f.username,c.year,c.location,c.add_date from favorite f join caps c on f.id_cap=c.id where f.favorite='1' and username like '%$searchKey%' ";
    $result = query($sql);
    confirm($result);
    echo "<tbody>";
    while($row=fetch_data($result)){
        ?>

        <tr>
        <td><?= $row['id'];?></td>
                    <td><?= $row['name'];?></td>
                    <td><?= $row['username'];?></td>
                    <td><?= $row['year'];?></td>
                    <td><?= $row['location'];?></td>
                    <td><?= $row['add_date'];?></td>
        </tr>
        <?php } echo "</tbody>";
}

?>