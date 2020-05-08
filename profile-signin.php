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

<body>
    <body>
    <header>
        <a href="home.php">COLR</a>
    </header>
    <div class="all">
        <h2>Organize, find and enjoy 
            your cap’s collection in a
            modern, relaxed and 
            dynamic way</h2>
    <div class="signup">
        <h1>sign <span>in</span></h1>
       
        <form method="POST">
            <input type="text" id="username" name="username" placeholder="Username" required><br><br>
            <input type="password" id="password" name="password" placeholder="Password" required><br><br>
            
            <div class="remember">
            <input type="checkbox" name="remember"> <span> Remember me </span>
            </div>
           
            <div class="signin">
            <button class="button"> Sign In</button>
            <button type="submit" class="Forget" onclick="location.href='forget.php'"  >Forgot password <i class="signup"></i></button>
            </div>
            <?php login_validation() ;?>

        </form>
    
    </div>
    
    </div>  
    
        
    
</body>
</body>
</html>