<?php
    if(isset($_POST['export'])){
        $connect = mysqli_connect("localhost","root","","TW");
        header('Content-Type: text/csv; charset = utf-8');
        header('Content-Disposition: attachment; filename=data.csv');
        $output = fopen("php://output","w");
        fputcsv($output,array('Id','Id_User','Name','Year','Image','Description','History','Location','Add_Date'));
        $querry = "Select * from caps order by id desc";
        $result = mysqli_query($connect,$querry);
        while($row = mysqli_fetch_assoc($result)){
            fputcsv($output,$row);
        }
        fclose($output);
    }
?>
