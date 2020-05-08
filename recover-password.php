<?php require_once('includes/functions/function.php');
include ('includes/functions/config.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignIn</title>
    <link rel="stylesheet" href="css/recover-password.css">
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


    <div class="Forgot">
        
        <form method="POST">
        <h1>recover <span>password</span></h1>
            <input type="password" id="password" name="password" placeholder="New password" required><br><br>
            <input type="password" id="repet_password" name="repet_password" placeholder="Re-enter the password" required><br><br>
            <input type="hidden" name="token" value="<?php $_POST['token'] = generateToken();  ?>">


            <div class="signin">
            <button class="button"> Change password </button>
            </div>
            
        </form>
        <?php echo recover_password() ?>
    
    </div>
    
    </div>  
    
        
    
</body>
</body>
</html>