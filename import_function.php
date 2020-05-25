<?php   

$connect = mysqli_connect("localhost","root","","TW");
if(isset($_POST['submit'])){
    if($_FILES['file']['name']){
        $filename = explode('.',$_FILES['file']['name']);
        if($filename[1]=='csv'){
            $handle = fopen($_FILES['file']['tmp_name'],"r");
            while($data = fgetcsv($handle)){
                $capname = mysqli_real_escape_string($connect,$data[0]);
                $description = mysqli_real_escape_string($connect,$data[1]);
                $year = mysqli_real_escape_string($connect,$data[2]);
                $owner_id = mysqli_real_escape_string($connect,$data[3]);
                $sql = "INSERT INTO PRODUCTS(capname,description,year,owner_id) values ('$capname','$description','$year','$owner_id')";
                mysqli_query($connect,$sql);
            }
            fclose($handle);
            print "Import done!";
        }
    }
}

?>