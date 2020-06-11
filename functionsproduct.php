<?php

function addproduct(){
    if(isset($_POST['submit'])){
        $file = $_FILES['img'];
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];
        $fileType = $file['type'];
        $fileExtension = explode('.',$fileName);
        $fileActualExtension = strtolower(end($fileExtension));
        
        $username = $_SESSION['userName'];
        $owner_id = getUserId($username);
        $capName = $_POST['capname'];
        $year = $_POST['year'];
        $description = $_POST['description'];
        $history = $_POST['history'];
        $location = $_POST['location'];
        

        if($fileError===0){
            if($fileSize<500000){
                $fileNameNew = uniqid('',true).".".$fileActualExtension;
                $fileLocation =  "product_images/".$fileNameNew;
                move_uploaded_file($fileTmpName,$fileLocation);
                echo "<script type='text/javascript'>alert('Upload Success!');</script>";

            }else{
                echo "<script type='text/javascript'>alert('Fisierul incarcat este prea mare!');</script>";
            }

        }else{
            echo "<script type='text/javascript'>alert('Eroare incarcare fisier!');</script>";
        }

        $servername = "localhost";
        $username = "root";
        $password = "";

        $conn = new mysqli ($servername,$username,$password,"TW");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
          }
        
        $querry = $conn->prepare("INSERT INTO pending(id_user,name,year,image,description,history,location) VALUES (?,?,?,?,?,?,?)");
        $querry->bind_param("isissss",$owner_id,$capName,$year,$fileNameNew,$description,$history,$location);
        $querry->execute();
        $querry->close();
        $conn->close();
    }
}

function getUserId($userName){
        $user = $userName;
        $servername = "localhost";
        $username = "root";
        $password = "";
    
        $conn = new mysqli ($servername,$username,$password,"TW");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    
        $sql = "SELECT id FROM users where username='$user'";
        $result = $conn->query($sql);
    
        $row = $result->fetch_assoc();
        $id = $row['id'];
        return $id;
}

function displayProfilePicture(){
    $username = $_SESSION['userName'];
    $conn = getDB();
    $sql = "select profileImage from users where username='$username'";
    $result = $conn->query($sql);
    $row=$result->fetch_assoc();
    $image = $row['profileImage'];
    if($image==null){
        return "icons8_male_user_24.png";
    }else{
        return $image;
    }
}

function search(){
    if(isset($_POST['submit'])){
        $param = $_POST['search'];

        echo "<script type='text/javascript'>alert('$param');</script>";
    }
}

function getDB(){
        $servername = "localhost";
        $username = "root";
        $password = "";
        $conn = new mysqli ($servername,$username,$password,"TW");
        if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        }
        return $conn;
}

function searchDB(){
    if(isset($_GET['submit'])){
        $conn = getDB();
        $searchul = $_GET['search'];
        $searchul = preg_replace("#[^0-9a-z]#i","",$searchul);
        $sql ="Select * from products where capname like '%$searchul%' or description like '%$searchul%'";
        $sql2 = "select * from users where username like '%$searchul%'";
        if($result = mysqli_query($conn,$sql)){
            if(mysqli_num_rows($result)>0){
                echo "<div class='capsList'>"; /*Begin CapsList*/
                    while($row = mysqli_fetch_array($result)){
                        echo "<div class='cap'>"; /* Begin cap */
                            echo "<div class='capimg'>"; /* Begin capImg */
                                echo "<img src='".$row['location']."'>";
                            echo "</div>";  /* End cap img */
                            echo "<div class='capDescription'>"; /* Begin capDescription */
                                echo "<div class='capDescriptionTitle'>"; /* capdTitle */
                                    echo "<h5>".$row['capname']."</h5>";
                                echo "</div>"; /* End CapTitle */
                                echo "<div class='capDescriptionSubTitle'>"; /* Begin description */
                                    echo "<p>".$row['description']."</p>";
                                echo "</div>"; /*End description*/
                                    echo "<button style='font-size:24px; background: none; border: none; position: relative; left: 128px; bottom: 10px;'><i class='fas fa-plus-circle'></i></button>";
                                echo "</div>"; /* End capDescription */
                            echo "</div>"; /*End cap */
                    }
                echo "</div>"; /* End capList */
                mysqli_free_result($result);
            }else{
                echo " No caps found!";
            }
        }else{
            echo "Error could not execute sql!";
            mysqli_error($conn);
        }
        /*
        if($result2 = mysqli_query($conn,$sql2)){
            if(mysqli_num_rows($result2)>0){
                while($row = mysqli_fetch_array($result2)){
                    echo "<h1>". $row['username'] . "</h1>";
                }
                mysqli_free_result($result2);
            }else{
                echo "There were no users found !";
            }
        }else{
            echo "Could not execute sql!";
        }
        */
        }
    }

function searchDBV2(){
    if(isset($_GET['submit'])){
        $conn = getDB();
        $searchField = $_GET['search'];
        $searchCopy = $_GET['search'];
        $searchField = preg_replace("#[^0-9a-z]#i","",$searchField);
        /* Verificam initial daca searchTerm corespunde unui utilizator */
        $sql = "SELECT * FROM users where username ='$searchField'";
        $found = 0;
        if($resultUser = mysqli_query($conn,$sql)){
            /* Daca avem un utilizator gasit cautam si capace corespunzatoare utilizatorului */
            if(mysqli_num_rows($resultUser)>0){
                $found = 1;
                echo "<div class='users'>";
                $row = mysqli_fetch_array($resultUser);
                $profileFirstName = $row['firstName'];
                $profileLastName = $row['lastName'];
                $profileUserName = $row['username'];
                echo "<div class='usersText'>";
                echo "<h4> User found: </h4>";
                echo "</div>";
                echo "<div class='usersList'>";
                echo "<div class='user'>";
                    echo "<img src='images/user2.png'>";
                    echo "<h5>".$profileFirstName." ".$profileLastName."</h5>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                $profileId = $row ['id'];
                    $sql2 = "SELECT * FROM products where id_user='$profileId'";
                    if($resultProduct = mysqli_query($conn,$sql2)){
                        if(mysqli_num_rows($resultProduct)>0){
                            echo "<h4> Produsele utilizatorului:</h4>";
                            echo "<div class='capsList'>";
                            $row2 = mysqli_fetch_array($resultProduct);
                            /* Daca am gasit produse ale utilizatorului le afisam */
                            while($row2=mysqli_fetch_array($resultProduct)){
                                echo "<div class='cap'>";
                                    echo "<div class='capimg'>";
                                        echo "<img src='product_images/".$row2['image']."'>";
                                    echo "</div>";
                                    echo "<div class='capDescription'>";
                                        echo "<div class='capDescriptionTitle'>";
                                            echo "<h5>".$row2['name']."</h5>";
                                        echo "</div>";
                                        echo "<div class='capDescriptionSubTitle'>";
                                            echo "<p>".$row2['description']."</p>";
                                        echo "</div>";
                                        echo "<button style='font-size:24px; background: none; border: none; position: relative; left: 128px; bottom: 10px;'><i class='fas fa-plus-circle'></i></button>";
                                    echo "</div>";
                                echo "</div>";
                            }
                            echo "</div>";
                            mysqli_free_result($resultProduct);
                        }else{
                            echo "<h5> Acest utilizator nu are produse adagate inca! </h5>";
                        }
                    }
            }
        } 
        if($found == 0){
                
                /* Daca nu am gasit un utlizator cautam produse dupa criteriul dat */
                $sql3 = "SELECT * FROM caps where name like '%$searchField%' or description like '%$searchField%' or year like '$searchField'";
                if($resultAll = mysqli_query($conn,$sql3)){
                    if(mysqli_num_rows($resultAll)>0){
                        echo "<h4> We found the following caps!</h4>";
                        echo "<div class='capsList'>";
                            while($row3 = mysqli_fetch_array($resultAll)){
                                echo "<div class='cap'>";
                                    echo "<div class='capimg'>";
                                        if($row3['image']==null){
                                            echo "<img src='product_images/img_error'>";
                                        }else{
                                        echo "<img src='product_images/".$row3['image']."'>";
                                        }
                                    echo "</div>";
                                
                                echo "<div class='capDescription'>";
                                        echo "<div class='capDescriptionTitle'>";
                                            echo "<h5>".$row3['name']."</h5>";
                                        echo "</div>";
                                        echo "<div class='capDescriptionSubTitle'>";
                                            echo "<p>".$row3['description']."</p>";
                                        echo "</div>";
                                        echo "<button style='font-size:24px; background: none; border: none; position: relative; left: 128px; bottom: 10px;'><i class='fas fa-plus-circle'></i></button>";
                                echo "</div>";
                                echo "</div>";
                                

                               
                            }
                        echo "</div>";
                    }else{
                        echo "Products not found!";
                    }
                }
            }
}
}

function searchProduct(){
    if(isset($_POST['submit'])){
        $searchKeyword=$_POST['searchKeyWord'];
        $year = $_POST['searchYear'];
        $location = $_POST['searchLocation'];
        $alcool = $_POST['alcol'];
        $querry = "SELECT * FROM CAPS WHERE 1";
        if($searchKeyword!=null){
            $querry.=" and name like '%$searchKeyword%' ";
        }
        if($year!=null){
            $querry.="and year='$year' ";
        }
        if($location!=null){
            $querry.="and location like '%$location%' ";
        }
        if($alcool!="none"){
            $querry.=" and alcool='$alcool'";
        }
        
    }
}










?>