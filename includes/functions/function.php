<?php
include('includes/functions/db.php');



function query($query){
    GLOBAL $connection;
    return mysqli_query($connection,$query);
}


function cleanstring($string){
    return htmlentities($string);
}

function setMessage($msg){
    if (!$msg){
        $_SESSION['Message']=$msg;
    }
    else{
        $msg="";
    }
}

function redirect($location){
    return header("location:{$location}");
}

function displayMessage($msg){
    echo $_SESSION['Message'];
    unset($_SESSION['Message']);
}


//VALIDATE USER
function user_validation(){
    if ($_SERVER['REQUEST_METHOD']=='POST'){

        $raw_firstName=cleanstring($_POST['fname']);
        $raw_lastName=cleanstring($_POST['lname']);
        $raw_userName=cleanstring($_POST['username']);
        $raw_email=cleanstring($_POST['email']);
        $raw_password=cleanstring($_POST['password']);


        $Errors=[];
        

        if(strlen($raw_userName)>15){
            $Errors[]="Username too long ";
        }

        if(email_validation($raw_email)){
            $Errors[]="Email already exist ";
        }

        if(username_validation($raw_userName)){
            $Errors[]="Username already exist ";
        }



        if(!empty($Errors)){
                foreach($Errors as $Errors){
                    echo $Errors;
                }
            }
          else{
            $Fname=escape($raw_firstName);
            $Lname=escape($raw_lastName);
            $Email=escape($raw_email);
            $Username=escape($raw_userName);
            $Pass=escape($raw_password);
            $Password=md5($Pass);
            $validationCode=md5($Username);
            $sql = "insert into users(firstName,lastName,email,username,password,activeUser,validationCode,profileImage)  values ('$Fname','$Lname','$Email','$Username','$Password','0','$validationCode','Ellipse_2.png')";
            $result =query($sql);
            confirm($result);

            //send email
            $subject = "Activate your COLR account";
            $message="Click the link bellow to activate the account 
            
            192.168.64.2/colr/activate.php?email=$Email&Code=$validationCode";
            
            $header="From admin@colr.com";
            send_email($Email,$subject,$message,$header);


            redirect("check-email.php");
            
              
              
          }  
    }
}

//Email Validation

function email_validation($email){
    $sql = "select * from users where email = '$email' ";
    $result =query($sql);
    confirm($result);
    if(fetch_data($result)){
        return true;
    }
    else{
        return false;
    }

}

//username Validation

function username_validation($username){
    $sql = "select * from users where username = '$username' ";
    $result =query($sql);
    confirm($result);
    if(fetch_data($result)){
        return true;
    }
    else{
        return false;
    }
}

function password_validation($password,$username){
    $sql = "select * from users where password = '$password' and username= '$username'";
    $result =query($sql);
    confirm($result);
    if(fetch_data($result)){
        return true;
    }
    else{
        return false;
    }
}

//email sender
function send_email($email,$subject,$message,$header){
    return mail($email,$subject,$message,$header);

}

//activate account
function activation(){
    if ($_SERVER['REQUEST_METHOD']=="GET"){
        $Email=$_GET['email'];
        $Code=$_GET['Code'];
        $sql = "select * from users where email= '$Email' and validationCode='$Code'";
        $result = query($sql);
        confirm($result);
        if(fetch_data($result)){
            echo '<p style="color:green">You have succesfully register </p>';
            $sqlupdate = "update users set activeUser ='1' where email= '$Email' and validationCode='$Code'";
            $result2 = query($sqlupdate);
            confirm($result2);
            header( "refresh:2;url=profile-signin.php" );
        }
        else{
            echo '<p style="color:red">Wrong link </p>';
        }

    }
}




//login validation

function login_validation(){
    if ($_SERVER['REQUEST_METHOD']=='POST'){
        $raw_userName=cleanstring($_POST['username']);
        $raw_password=cleanstring($_POST['password']);
        $remember = isset($_POST['remember']);
        $Errors=[];

        if (empty($raw_userName)){
            $Errors[]="Enter your email";
        }

        if (empty($raw_password)){
            $Errors[]="Password not entered";
        }

        if(!empty($Errors)){
            foreach($Errors as $Errors){
                echo $Errors;
            }
        }
        else{


            if (login($raw_userName,$raw_password,$remember)){
                redirect('profile-personal-details.php');
            }
            else{
                echo '<p style=" color:red ">Wrong Username or Password </p>';
            }
            
        }

    }
}


function login($raw_userName,$raw_password,$remember){
    $sql = "select * from users where username= '$raw_userName' and activeUser='1' ";
    $result = query($sql);
    confirm($result);
    if($row=fetch_data($result)){
            $passcrypt= $row['password'];
            if (md5($raw_password)==$passcrypt){
                if($remember==true){
                    setcookie('username',$raw_userName,time()+86400);

                }
                $_SESSION['userName']=$raw_userName;
                if($row['admin']==1){
                $_SESSION['admin']=$row['admin'];
                }
                if($row['GM']==1){
                    $_SESSION['GM']=$row['GM'];
                    }
                return true;
            }
            else{
                return false;
            }
    }
    else{
        return false;
    }
}


function loggedIn(){
    if($_SESSION['userName']){
        return true;
    }
    else{
        return false;
    }
}

function admin(){
    if(isset($_SESSION['admin'])){
        return true;
    }
    else{
        return false;
    }
}

function gm(){
    if(isset($_SESSION['GM'])){
        return true;
    }
    else{
        return false;
    }
}


function get_Fname($raw_userName){
    $sql = "select * from users where username= '$raw_userName'";
    $result = query($sql);
    confirm($result);
    if($row=fetch_data($result)){
        echo $row['firstName'];
    }
    else{
        return false;
    }
}


function get_Lname($raw_userName){
    $sql = "select * from users where username= '$raw_userName'";
    $result = query($sql);
    confirm($result);
    if($row=fetch_data($result)){
        echo $row['lastName'];
    }
    else{
        return false;
    }
}

function get_email($raw_userName){
    $sql = "select * from users where username= '$raw_userName'";
    $result = query($sql);
    confirm($result);
    if($row=fetch_data($result)){
        echo $row['email'];
    }
    else{
        return false;
    }
}

//TOKEN GENERATOR
function generateToken(){
    $token=0;
    $token = $_SESSION['token']=md5(uniqid(mt_rand(),true));
    return $token;
}

function forget_pass(){
    if($_SERVER['REQUEST_METHOD']=="POST"){
    
        if(isset($_SESSION['token']) &&  $_POST['token']==$_SESSION['token']){
            //echo $_POST['token'];
            //echo "        ";
            //echo $_SESSION['token'];
            //echo "WORKING";

            $email_recover=$_POST['email'];

            if(email_validation($email_recover)==true){
                    //echo "Working";
                    $verification_code=md5($email_recover);

                    //set cookie to expire de code
                    setcookie('code_temp',$verification_code,time()+180);


                    //set verification code in db
                    $sql = "update users set validationCode='$verification_code' where email='$email_recover' ";
                    $result = query($sql);
                    confirm($result);


                    //email
                    $subject = "Reset your COLR account's password";
                    $message="Click the link bellow to reset your password
                    
                    192.168.64.2/colr/codeconfirm.php?email=$email_recover

                    YOUR CODE IS : $verification_code
                    
                    ";
                    $header="From admin@colr.com";

                    if(send_email($email_recover,$subject,$message,$header)){
                        echo '<p style=" color:green ">Email Sent </p>';

                    }
                    else{
                        echo '<p style=" color:red ">Can t send the email </p>';
                    }
                    

            }
            else{
                echo '<p style=" color:red ">Wrong Email </p>';
            }
            
        }
    }
}


//VALIDATE CODE

function validate_code(){
    if(isset($_COOKIE['code_temp'])){
        if(!isset($_GET['email'])){
            echo '<p style=" color:red ">Wrong link </p>';
        }
        else{
            if($_SERVER['REQUEST_METHOD']=="POST"){
                $raw_code = $_POST['code'];
                $get_email = $_GET['email'];
                
                $sql = "select * from users where email='$get_email'";
                $result = query($sql);
                confirm($result);
                if($row=fetch_data($result)){
                    $get_code=$row['validationCode'];
                    if ($get_code == $raw_code){
                        setcookie('code_temp2',$get_code,time()+500);
                        $redirect_adress='recover-password.php?email='.$get_email;
                        
                        redirect($redirect_adress);
                    }
                    else{
                        echo '<p style=" color:red ">Wrong Code </p>';
                    }
                }
                else{
                    echo "CAN T FETCH";
                }
            }
        }
    }
    else{
        echo '<p style=" color:red ">Code expired </p>';
    }

}


//RECOVER PASS

function recover_password(){
    if(isset($_COOKIE['code_temp2'])){
        if(!isset($_GET['email'])){
            echo '<p style=" color:red ">Wrong link </p>';
        }
        else{
            
            if(isset($_SESSION['token']) &&  $_POST['token']==$_SESSION['token']){

                if (email_validation($_GET['email'])){
                    if($_SERVER['REQUEST_METHOD']=="POST"){
                        if($_POST['password'] == $_POST['repet_password']){
                            $new_password=md5($_POST['password']);
                            $Email= $_GET['email'];
                            $sql = "Update users set password='$new_password' where email = '$Email'        ";
                            $result = query($sql);
                            confirm($result);
                            if($result){
                                redirect('profile-signin.php');
                            }
                            

                        }
                        else{
                            echo '<p style=" color:red ">Password not the same </p>';
                        }



                    }
                }
                else{
                    echo '<p style=" color:red ">Wrong email </p>';
                }
        }
        else{
            echo '<p style=" color:red ">Wrong TOKEN </p>';
        }
        }
    }

    else{
        echo '<p style=" color:red ">Session expired, try again </p>';
    }


}



//RESET PASSWORD


function reset_password(){
    if($_SERVER['REQUEST_METHOD']=="POST"){
        if(isset($_SESSION['token']) &&  $_POST['token']==$_SESSION['token']){
            //$_SESSION['userName'];
            $old_password = md5($_POST['oldpassword']);
            if (password_validation($old_password,$_SESSION['userName'])){
                if($_POST['password'] == $_POST['repet_password']){
                    if($_POST['password']==$_POST['oldpassword']){
                        echo '<p style=" color:red ">New password same with the old one </p>';
                    }
                    else{
                    $new_password=md5($_POST['password']);
                    $username=$_SESSION['userName'];
                    $sql = "Update users set password='$new_password' where username = '$username'";
                    $result = query($sql);
                            confirm($result);
                            if($result){
                                echo '<p style=" color:green ">Pasword changed, we will redirect you to profile page </p>';
                                header( "refresh:3;url=profile-personal-details.php" );
                            }
                        }       
                }
                else{
                    echo '<p style=" color:red ">Password not the same </p>';
                }
            }
            else{
                echo '<p style=" color:red ">Old password wrong </p>';
            }   
        }
    }
}




//DELETE ACCOUNT

function delete_account(){
    if($_SERVER['REQUEST_METHOD']=="POST"){
        $username=$_SESSION['userName'];
        $sql = "select id from users where username= '$username'";
        $result = query($sql);
        confirm($result);
        if($row=fetch_data($result)){
            $id=$row['id'];
        }
        $sql = "delete from users where id='$id'";
        $result = query($sql);
        confirm($result);

        $sql = "delete from caps where id_user='$id'";
        $result = query($sql);
        confirm($result);


        $sql = "delete from favorite where username='$username'";
        $result = query($sql);
        confirm($result);

        redirect('logout.php');
    }
}

function delete_account_ajax($id){
    if($_SERVER['REQUEST_METHOD']=="POST"){
        $sql = "select username from users where id= '$id'";
        $result = query($sql);
        confirm($result);
        if($row=fetch_data($result)){
            $username=$row['username'];
        }
        $sql = "delete from users where id='$id'";
        $result = query($sql);
        confirm($result);

        $sql = "delete from caps where id_user='$id'";
        $result = query($sql);
        confirm($result);


        $sql = "delete from favorite where username='$username'";
        $result = query($sql);
        confirm($result);

        echo'<p style=" color:red " class="deleteAlert">Account deleted </p>';
        header("Refresh:1; url=admin-page-users.php");
    }
}


function add_account_ajax($id){
    if($_SERVER['REQUEST_METHOD']=="POST"){
        $sql = "update users set admin='1' where id= '$id'";
        $result = query($sql);
        confirm($result);
        

        echo'<p style=" color:green " class="deleteAlert">Admin added </p>';
        header("Refresh:1; url=admin-page-users.php");
    }
}

function unset_admin_ajax($id){
    if($_SERVER['REQUEST_METHOD']=="POST"){
        $sql = "update users set admin='0' where id= '$id'";
        $result = query($sql);
        confirm($result);
        

        echo'<p style=" color:green " class="deleteAlert">Account no longer admin </p>';
        header("Refresh:1; url=admin-page-users.php");
    }
}






//FAVORITE



function get_noofcaps_favorite($username){
    $sql = "select count(*) from favorite where username='$username' and favorite='1'";
    $result = query($sql);
    confirm($result);
    if($row=fetch_data($result)){
        return $row['count(*)'];
    }
    else{
        return false;
    }
}


function get_cap_name($rowId,$username){
    if($rowId == 1){
        $sql = "select c.name from caps c join favorite f on c.id=f.id_cap where username='$username' and favorite='1' LIMIT $rowId";
    $result = query($sql);
    confirm($result);
    if($row=fetch_data($result)){
        return $row['name'];
    }
    else{
        return false;
    }

    }

    else{
        $rowId1=$rowId-1;
        $sql = "select c.name from caps c join favorite f on c.id=f.id_cap where username='$username' and favorite='1' LIMIT $rowId1,$rowId";
        $result = query($sql);
    confirm($result);
    if($row=fetch_data($result)){
        return $row['name'];
    }
    else{
        return false;
    }
    }
}



function get_cap_year($rowId,$username){
    if($rowId == 1){
        $sql = "select c.year from caps c join favorite f on c.id=f.id_cap where username='$username' and favorite='1' LIMIT $rowId";
    $result = query($sql);
    confirm($result);
    if($row=fetch_data($result)){
        return $row['year'];
    }
    else{
        return false;
    }

    }

    else{
        $rowId1=$rowId-1;
        $sql = "select c.year from caps c join favorite f on c.id=f.id_cap where username='$username' and favorite='1' LIMIT $rowId1,$rowId";
        $result = query($sql);
    confirm($result);
    if($row=fetch_data($result)){
        return $row['year'];
    }
    else{
        return false;
    }
    }
}



function get_cap_id($rowId,$username){
    if($rowId == 1){
        $sql = "select c.id from caps c join favorite f on c.id=f.id_cap where username='$username' and favorite='1' LIMIT $rowId";
    $result = query($sql);
    confirm($result);
    if($row=fetch_data($result)){
        return $row['id'];
    }
    else{
        return false;
    }

    }

    else{
        $rowId1=$rowId-1;
        $sql = "select c.id from caps c join favorite f on c.id=f.id_cap where username='$username' and favorite='1' LIMIT $rowId1,$rowId";
        $result = query($sql);
    confirm($result);
    if($row=fetch_data($result)){
        return $row['id'];
    }
    else{
        return false;
    }
    }
}


function get_cap_image($rowId,$username){
    if($rowId == 1){
        $sql = "select c.image from caps c join favorite f on c.id=f.id_cap where username='$username' and favorite='1' LIMIT $rowId";
    $result = query($sql);
    confirm($result);
    if($row=fetch_data($result)){
        return $row['image'];
    }
    else{
        return false;
    }

    }

    else{
        $rowId1=$rowId-1;
        $sql = "select c.image from caps c join favorite f on c.id=f.id_cap where username='$username' and favorite='1' LIMIT $rowId1,$rowId";
        $result = query($sql);
    confirm($result);
    if($row=fetch_data($result)){
        return $row['image'];
    }
    else{
        return false;
    }
    }
}

//COLLECTION

function get_noofcaps($username){
    $sql = "select count(*) from caps c join users u on c.id_user=u.id where u.username='$username' ";
    $result = query($sql);
    confirm($result);
    if($row=fetch_data($result)){
        return $row['count(*)'];
    }
    else{
        return false;
    }
}


function get_cap_id_collection($rowId,$username){
    if($rowId == 1){
        $sql = "select c.id from caps c join users u on c.id_user=u.id where username='$username' LIMIT $rowId";
    $result = query($sql);
    confirm($result);
    if($row=fetch_data($result)){
        return $row['id'];
    }
    else{
        return false;
    }

    }

    else{
        $rowId1=$rowId-1;
        $sql = "select c.id from caps c join users u on c.id_user=u.id where username='$username' LIMIT $rowId1,$rowId";
        $result = query($sql);
    confirm($result);
    if($row=fetch_data($result)){
        return $row['id'];
    }
    else{
        return false;
    }
    }
}



function get_cap_image_collection($rowId,$username){
    if($rowId == 1){
        $sql = "select c.image from caps c join users u on c.id_user=u.id where username='$username' LIMIT $rowId";
    $result = query($sql);
    confirm($result);
    if($row=fetch_data($result)){
        return $row['image'];
    }
    else{
        return false;
    }

    }

    else{
        $rowId1=$rowId-1;
        $sql = "select c.image from caps c join users u on c.id_user=u.id where username='$username' LIMIT $rowId1,$rowId";
        $result = query($sql);
    confirm($result);
    if($row=fetch_data($result)){
        return $row['image'];
    }
    else{
        return false;
    }
    }
}

function get_cap_name_collection($rowId,$username){
    if($rowId == 1){
        $sql = "select c.name from caps c join users u on c.id_user=u.id where username='$username' LIMIT $rowId";
    $result = query($sql);
    confirm($result);
    if($row=fetch_data($result)){
        return $row['name'];
    }
    else{
        return false;
    }

    }

    else{
        $rowId1=$rowId-1;
        $sql = "select c.name from caps c join users u on c.id_user=u.id where username='$username' LIMIT $rowId1,$rowId";
        $result = query($sql);
    confirm($result);
    if($row=fetch_data($result)){
        return $row['name'];
    }
    else{
        return false;
    }
    }
}



function get_cap_year_collection($rowId,$username){
    if($rowId == 1){
        $sql = "select c.year from caps c join users u on c.id_user=u.id where username='$username' LIMIT $rowId";
    $result = query($sql);
    confirm($result);
    if($row=fetch_data($result)){
        return $row['year'];
    }
    else{
        return false;
    }

    }

    else{
        $rowId1=$rowId-1;
        $sql = "select c.year from caps c join users u on c.id_user=u.id where username='$username' LIMIT $rowId1,$rowId";
        $result = query($sql);
    confirm($result);
    if($row=fetch_data($result)){
        return $row['year'];
    }
    else{
        return false;
    }
    }
}


//PRODUCT PAGE
function cap_owner($id){
    $sql = "select u.username from caps c join users u on c.id_user=u.id where c.id='$id'";
    $result = query($sql);
confirm($result);
if($row=fetch_data($result)){
    return $row['username'];
}
else{
    return false;
}
}


function delete_cap($id){
    if($_SERVER['REQUEST_METHOD']=="POST"){

        if ( !empty( $_POST["number2"] ) ) {
        $sql = "delete from caps where id='$id'";
        $result = query($sql);
        confirm($result);


        $sql2 = "delete from favorite where id_cap='$id'";
        $result2 = query($sql2);
        confirm($result2);

        redirect('profile-personal-details.php');
    }
}
}




function confirm_cap_id($id){
    $sql = "select count(*) from caps where id='$id'";
    $result = query($sql);
    confirm($result);
    if($row=fetch_data($result)){
        return $row['count(*)'];
    }
}

function get_cap_name_product($id){
    $sql = "select name from caps where id='$id'";
        $result = query($sql);
    confirm($result);
    if($row=fetch_data($result)){
        return $row['name'];
    }
    else{
        return false;
    }
}

function get_cap_year_product($id){
    $sql = "select year from caps where id='$id'";
        $result = query($sql);
    confirm($result);
    if($row=fetch_data($result)){
        return $row['year'];
    }
    else{
        return false;
    }
}

function get_cap_description($id){
    $sql = "select description from caps where id='$id'";
        $result = query($sql);
    confirm($result);
    if($row=fetch_data($result)){
        return $row['description'];
    }
    else{
        return false;
    }
}

function get_cap_history($id){
    $sql = "select history from caps where id='$id'";
        $result = query($sql);
    confirm($result);
    if($row=fetch_data($result)){
        return $row['history'];
    }
    else{
        return false;
    }
}

function get_cap_add_year($id){
    $sql = "select add_date from caps where id='$id'";
        $result = query($sql);
    confirm($result);
    if($row=fetch_data($result)){
        return $row['add_date'];
    }
    else{
        return false;
    }
}

function get_cap_no_fav($id){
    $sql = "select count(*) from favorite where id_cap='$id'";
        $result = query($sql);
    confirm($result);
    if($row=fetch_data($result)){
        return $row['count(*)'];
    }
    else{
        return false;
    }
}




function add_to_favorite($id){
    if($_SERVER['REQUEST_METHOD']=="POST"){
        if ( !empty( $_POST["number1"] ) ) {
            
       $username= $_SESSION['userName'];
       $sql = "select favorite from favorite where id_cap='$id' and username='$username'";
        $result = query($sql);
        confirm($result);
        if($row=fetch_data($result)){
        if($row['favorite']==1){
            //este deja in favorite la user, il scoatem
            $sql = "update favorite set favorite=0 where id_cap='$id' and username='$username'";
            $result = query($sql);
            confirm($result);
            echo '<p style=" color:red ">Product no longer available in your favorite list</p>';
        }
        if($row['favorite']==0){
            //nu este in favorite la user, il adaugam
            $sql = "update favorite set favorite=1 where id_cap='$id' and username='$username'";
            $result = query($sql);
            confirm($result);
            echo '<p style=" color:green ">Product added to your favorite list</p>';
        }
        }
        else{
            $sql = "insert into favorite(id_cap,username,favorite) values('$id','$username',1) ";
            $result = query($sql);
            confirm($result);
            echo '<p style=" color:green ">Product added to your favorite list</p>';
        }
    }
}
    
}


function get_cap_image_product($id){
    $sql = "select image from caps where id='$id'";
    $result = query($sql);
    confirm($result);
    if($row=fetch_data($result)){
        return $row['image'];
    }
    else{
        return false;
    }
}


function get_cap_owner_image($id){
    $sql="select profileImage from users u join caps c on u.id=c.id_user where c.id='$id'";
    $result = query($sql);
    confirm($result);
    if($row=fetch_data($result)){
        return $row['profileImage'];
    }
    else{
        return false;
    }

}

function get_profile_image($username){
    $sql="select profileImage from users where username='$username'";
    $result = query($sql);
    confirm($result);
    if($row=fetch_data($result)){
        return $row['profileImage'];
    }
    else{
        return false;
    }
}

function get_username_by_productid($id){
    $sql="select username from users u join caps c on u.id=c.id_user where c.id='$id'";
    $result = query($sql);
    confirm($result);
    if($row=fetch_data($result)){
        return $row['username'];
    }
    else{
        return false;
    }
}


function upload_profile_image(){
    if($_SERVER['REQUEST_METHOD']=="POST"){
        
        $file=$_FILES['file'];

        $name       = $_FILES['file']['name'];  
        $tmpName  = $_FILES['file']['tmp_name'];
        $error = $_FILES['file']['error'];
        $size = $_FILES['file']['size'];

       $fileType1=explode('.',$name);
       $fileType= strtolower(end($fileType1));

       $allowed = array('jpg','jpeg','png');
       if(in_array($fileType,$allowed)){
            if($error==0){
                    if($size < 20000){
                            $new_file_name=uniqid('',true).".".$fileType;
                            $destination= 'images/'.$new_file_name;
                            move_uploaded_file($tmpName,$destination);
                            //echo '<p style=" color:green">SUCCES</p>';
                            //update DB
                            $username=$_SESSION['userName'];
                            $sql="update users set profileImage='$new_file_name' where username='$username'";
                            $result = query($sql);
                            confirm($result);
                            echo '<p style=" color:green">SUCCES, redirecting to your profile in 3s </p>';
                            header( "refresh:3;url=profile-personal-details.php" );
                    }else{
                        echo '<p style=" color:red">File size too big</p>';
                    }
            }
            else{
                echo '<p style=" color:red">Upload error</p>';
            }
       }
       else{
        echo '<p style=" color:red">Can t upload this type of file, please select another one</p>';
       }
    }
}




//POPULAR CAPS


function no_of_popular_caps(){
    $sql = "SELECT COUNT(*) FROM (SELECT f.id, COUNT(*) 'term_count' FROM favorite f WHERE f.favorite='1' GROUP BY f.id_cap ORDER BY term_count DESC, f.id_cap)AS subquery";
    $result = query($sql);
    confirm($result);
    if($row=fetch_data($result)){
        return $row['COUNT(*)'];
    }
    else{
        return false;
    }
}

function get_id_cap_popular($rowId){
    if($rowId == 1){
        $sql = "SELECT f.id, COUNT(*) 'term_count' FROM favorite f WHERE f.favorite='1' GROUP BY f.id_cap ORDER BY term_count DESC, f.id_cap LIMIT $rowId";
    $result = query($sql);
    confirm($result);
    if($row=fetch_data($result)){
        return $row['id'];
    }
    else{
        return false;
    }

    }

    else{
        $rowId1=$rowId-1;
        $sql = "SELECT f.id, COUNT(*) 'term_count' FROM favorite f WHERE f.favorite='1' GROUP BY f.id_cap ORDER BY term_count DESC, f.id_cap LIMIT $rowId1,$rowId";
        $result = query($sql);
    confirm($result);
    if($row=fetch_data($result)){
        return $row['id'];
    }
    else{
        return false;
    }
    }
}



function get_cap_image_popular($rowId){
    if($rowId == 1){
        $sql = "select c.image, COUNT(*) 'term_count' from caps c join favorite f on c.id=f.id_cap WHERE f.favorite='1' GROUP BY f.id_cap ORDER BY term_count DESC, f.id_cap LIMIT $rowId";
    $result = query($sql);
    confirm($result);
    if($row=fetch_data($result)){
        return $row['image'];
    }
    else{
        return false;
    }

    }

    else{
        $rowId1=$rowId-1;
        $sql = "select c.image, COUNT(*) 'term_count' from caps c join favorite f on c.id=f.id_cap WHERE f.favorite='1' GROUP BY f.id_cap ORDER BY term_count DESC, f.id_cap LIMIT $rowId1,$rowId";
        $result = query($sql);
    confirm($result);
    if($row=fetch_data($result)){
        return $row['image'];
    }
    else{
        return false;
    }
    }
}

function get_cap_name_popular($rowId){
    if($rowId == 1){
        $sql = "select c.name, COUNT(*) 'term_count' from caps c join favorite f on c.id=f.id_cap WHERE f.favorite='1' GROUP BY f.id_cap ORDER BY term_count DESC, f.id_cap LIMIT $rowId";
    $result = query($sql);
    confirm($result);
    if($row=fetch_data($result)){
        return $row['name'];
    }
    else{
        return false;
    }

    }

    else{
        $rowId1=$rowId-1;
        $sql = "select c.name, COUNT(*) 'term_count' from caps c join favorite f on c.id=f.id_cap WHERE f.favorite='1' GROUP BY f.id_cap ORDER BY term_count DESC, f.id_cap LIMIT $rowId1,$rowId";
        $result = query($sql);
    confirm($result);
    if($row=fetch_data($result)){
        return $row['name'];
    }
    else{
        return false;
    }
    }
}

function get_cap_year_popular($rowId){
    if($rowId == 1){
        $sql = "select c.year, COUNT(*) 'term_count' from caps c join favorite f on c.id=f.id_cap WHERE f.favorite='1' GROUP BY f.id_cap ORDER BY term_count DESC, f.id_cap LIMIT $rowId";
    $result = query($sql);
    confirm($result);
    if($row=fetch_data($result)){
        return $row['year'];
    }
    else{
        return false;
    }

    }

    else{
        $rowId1=$rowId-1;
        $sql = "select c.year, COUNT(*) 'term_count' from caps c join favorite f on c.id=f.id_cap WHERE f.favorite='1' GROUP BY f.id_cap ORDER BY term_count DESC, f.id_cap LIMIT $rowId1,$rowId";
        $result = query($sql);
    confirm($result);
    if($row=fetch_data($result)){
        return $row['year'];
    }
    else{
        return false;
    }
    }
}




//LOCATION

function get_cap_location($id){
    $sql = "select location from caps where id='$id'";
    $result = query($sql);
confirm($result);
if($row=fetch_data($result)){
    return $row['location'];
}
else{
    return false;
}
}



//REDIRECT SEARCH

function redirect_search(){
    if($_SERVER['REQUEST_METHOD']=="POST"){
        $url="search.php?search=".$_POST['search']."&submit=";
        redirect($url);
    }
}





//ADMIN

function no_of_users(){
    $sql = "select count(*) from users";
    $result = query($sql);
    confirm($result);
if($row=fetch_data($result)){
    return $row['count(*)'];
}
}

function no_of_caps(){
    $sql = "select count(*) from caps";
    $result = query($sql);
confirm($result);
if($row=fetch_data($result)){
    return $row['count(*)'];
}
}

function no_of_caps_today(){
    $sql = "select count(*) from caps where add_date=";
    $result = query($sql);
confirm($result);
if($row=fetch_data($result)){
    return $row['count(*)'];
}
}

?>