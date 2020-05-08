<?php
include('includes/functions/db.php');





    function escape($string){
        GLOBAL $connection;
        return mysqli_real_escape_string($connection,$string);
    }
    
    

    //querry function
    function query($query){
        GLOBAL $connection;
        return mysqli_query($connection,$query);
    }
    
    

    //confirmation funtion
    function confirm($result){
        GLOBAL $connection;
        if(!$result){
            die('Query failed'.mysqli_error($connection));
        }
    }
    
    
    //fetch
    function fetch_data($result){
        GLOBAL $connection;
        return mysqli_fetch_assoc($result);
    }
    
    //no of rows

    function no_of_rows($count){
        return mysqli_num_rows($count);
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
            $sql = "insert into users(firstName,lastName,email,username,password,activeUser,validationCode)  values ('$Fname','$Lname','$Email','$Username','$Password','0','$validationCode')";
            $result =query($sql);
            confirm($result);

            //send email
            $subject = "Activate your COLR account";
            $message="Click the link bellow to acctivate the account 
            
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
                        $link_addr="192.168.64.2/colr/codeconfirm.php?email=$email_recover";
                        echo "<a href=''".$link_addr."'></a>" ;
                        
                        
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

?>