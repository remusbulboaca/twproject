<?php
require_once('includes/functions/db.php');

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

//GENERATE TOKEN
function generateToken(){
    $token = $_SESSION['token']=md5(uniqid(mt_rand(),true));
    return token;
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
            $message="Click the link bellow to acctivate the account 192.168.64.2/colr/activate.php?email=$Email&Code=$validationCode";
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



?>