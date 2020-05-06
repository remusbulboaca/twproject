<?php require_once('includes/functions/function.php');
include ('includes/functions/config.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignIn</title>
    <link rel="stylesheet" href="css/profile-signin.css">
</head>
<style>
    .button {
    position:absolute;
    bottom:20vh;    
    background: #ffffff;
    font-family: "proxima_nova_rgregular";
    font-size: 1em;
    padding: 1vh 10vw;
    border-radius: 50px;
    border: 0;
    color: #191919;
    text-align: center;
    transition: all 0.3s ease 0s;
}

.button:hover{
    letter-spacing: 3px;
    border-radius: 6px;
    border-color: #cecece !important;
    transition: all 0.3s ease 0s;
        }

        @media (min-width : 750px){
            .button {
                padding: 1.5vh 5vw;
            }
        }

        .remember span {
            color:white;
            font-family: "proxima_nova_rgregular";
            padding: 1em ;
        }
</style>
<body>
    <body>
    <header>
        <a href="/home.html">COLR</a>
    </header>
    <div class="all">
        <h2>Organize, find and enjoy 
            your cap’s collection in a
            modern, relax and 
            dynamic way</h2>
    <div class="signup">
        <h1>sign <span>in</span></h1>
       
        <form method="POST">
            <input type="text" id="username" name="username" placeholder="Username" required><br><br>
            <input type="password" id="password" name="password" placeholder="Password" required><br><br>
            <div class="remember">
            <input type="checkbox" name="remember"> <span> Remember me </span>
            </div>
            <button class="button"> Sign In</button>
            <?php login_validation() ;?>

        </form>
    
    </div>
    
    </div>  
    
        
    
</body>
</body>
</html>